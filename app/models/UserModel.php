<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
class UserModel{
    private $db;
    private $mail;

    public function __construct(){
        $this->db = new Database();
        $this->mail = new PHPMailer(true);
    }

    // Register user
    public function register($data): bool
    {
        $name = $data['name'];
        $email = $data['email'];
        // Prepare statement
        $this->db->query('INSERT INTO user (name, username, email, password, userType, contactNo,otp) VALUES (:name, :username, :email, :password, :userType, :contactNo,:otp');
        $this->mail->isSMTP();                                            //Send using SMTP
        $this->mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $this->mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $this->mail->Username = 'symphonyuscs@gmail.com';                     //SMTP username
        $this->mail->Password = 'wmoe qbsp fxcl bwqp';                               //SMTP password
        $this->mail->Port = 587;                                    //TCP port to connect to; use 587 if you have set SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS

        //Recipients
        $this->mail->setFrom('symphonyucsc@gmail.com', 'Symphony');
        $this->mail->addAddress($email, $name);     //Add a recipient

        //Attachments
//    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $this->mail->isHTML(true);                                  //Set email format to HTML
        $this->mail->Subject = 'Here is the subject';
        $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
        $this->mail->Body = '<div id="overview" style="border: 1px solid #343131;margin: auto;width: 50%;text-align: center">
          <h1 style="">Hello '.$name.'</h1>
          <p style="font-size: 18px;text-align: justify;width: 90%;margin: auto">Thank you for choosing Symphony. We are excited to have you on board!</p>
          <hr style="width:90%;color: #3d3b3b;opacity: 0.3;">
          <p style="font-size: 20px; color: #2e043a;">To complete your account creation, please use the following verification code:</p>
          <p style="font-size: 24px; color: #333;  cursor: pointer; margin: 15px 10px;">' . $verification_code . '</p>
        </div>';
        $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $this->mail->send();
        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':userType', $data['user_type']);
        $this->db->bind(':contactNo', $data['contact_no']);
        $this->db->bind(':otp', $verification_code);

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