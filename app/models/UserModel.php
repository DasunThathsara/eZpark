<?php
class UserModel{
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    // Register user
    public function register($data): bool
    {
        // Prepare statement
        $this->db->query('INSERT INTO user (name, username, email, password, userType, contactNo) VALUES (:name, :username, :email, :password, :userType, :contactNo)');

        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':userType', $data['user_type']);
        $this->db->bind(':contactNo', $data['contact_no']);

        // Execute
        if ($this->db->execute() and $this->userTableUpdate($data)){;
            return true;
        }
        else {
            return false;
        }
    }

    // Update the specific user table
    public function userTableUpdate($data): bool
    {

        $this->db->query('SELECT id FROM user WHERE username = :username AND password = :password');

        // Bind values
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', $data['password']);

        $row = $this->db->single();
        $id = $row->id;

        // Prepare statement

        if ($data['user_type'] == 'merchandiser'){
            $this->db->query('INSERT INTO parkingowner (id) VALUES (:id)');
            $this->db->bind(':id', $id);
            $row = $this->db->single();

            $this->db->query('INSERT INTO merchandiser (id, website, merchandiserName, merchantType) VALUES (:id, :website, :merchandiserName, :merchantType)');
            $this->db->bind(':id', $id);
            $this->db->bind(':website', $data['website']);
            $this->db->bind(':merchandiserName', $data['merchantName']);
            $this->db->bind(':merchantType', $data['merchantType']);
        }


        // Execute
        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }

    // Find user
    public function findUserByEmail($email): bool
    {
        $this->db->query('SELECT * FROM user WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        // Check row
        if ($this->db->rowCount() > 0){
            return true;
        } else {
            return false;
        }
    }

    public function findUserByUsername($username): bool
    {
        $this->db->query('SELECT * FROM user WHERE username = :username');
        $this->db->bind(':username', $username);

        $row = $this->db->single();

        // Check row
        if ($this->db->rowCount() > 0){
            return true;
        } else {
            return false;
        }
    }

    // Login user
    public function login($email, $password, $username){
        $this->db->query('SELECT * FROM user WHERE email = :email OR username = :username');
        $this->db->bind(':email', $email);
        $this->db->bind(':username', $username);

        $row = $this->db->single();

        $hashed_password = $row->password;
        if (password_verify($password, $hashed_password)){
            return $row;
        } else {
            return false;
        }
    }

    // Update user profile
    public function updateProfile($data): bool
    {
        // Prepare statement
        $this->db->query('UPDATE user SET username = :username, email = :email, name = :name, contactNo = :contactNo, profilePhoto = :profile_photo WHERE id = :id');

        // Bind values
        $this->db->bind(':id', $_SESSION['user_id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':contactNo', $data['contact_no']);
        $this->db->bind(':profile_photo', $data['profile_photo']);

        // Execute
        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }

    // Remove user profile photo
    public function removeProfilePhoto(): bool
    {
        // Prepare statement
        $this->db->query('UPDATE user SET profilePhoto = :profile_photo WHERE id = :id');

        // Bind values
        $this->db->bind(':id', $_SESSION['user_id']);
        $this->db->bind(':profile_photo', '');

        // Execute
        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }
}