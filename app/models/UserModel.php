<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require APPROOT.'/libraries/vendor/autoload.php';
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
        $this->mail->isSMTP();                             //Send using SMTP
        $this->mail->Host = 'smtp.gmail.com';              //Set the SMTP server to send through
        $this->mail->SMTPAuth = true;                      //Enable SMTP authentication
        $this->mail->Username = 'ezpark.help@gmail.com';   //SMTP username
        $this->mail->Password = 'pcop yjvy adrx mlcl';     //SMTP password
        $this->mail->Port = 587;                           //TCP port to connect to; use 587 if you have set SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS

        //Recipients
        $this->mail->setFrom('ezpark.help@gmail.com', 'Your One-Time Password (OTP) for eZpark Registration');
        $this->mail->addAddress($email, $name);            //Add a recipient

        //Attachments
//    $mail->addAttachment('/var/tmp/file.tar.gz');        //Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');   //Optional name

        //Content
        $this->mail->isHTML(true);                   //Set email format to HTML
        $this->mail->Subject = 'Verification code';
        $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
        $this->mail->Body = '<div id="overview" style="margin: auto; width: 80%; font-size: 13px">
            <p style="color: black">
                Dear '.$name.',<br><br>
        
                Thank you for choosing eZpark! We\'re excited to have you on board. To ensure the security of your account, we require you to verify your registration by entering the One-Time Password (OTP) provided below.
                <br><br>
                Please enter this code on the registration page to complete the verification process. Please note that this OTP is valid for a limited time, so make sure to use it promptly. Your account security is important to us, and we recommend not sharing this OTP with anyone.
                <br>
            </p>
            <p style="font-size: 18px; text-align: center;"><span style=" background-color: #EAEAEAFF; padding:8px; border-radius: 10px;">'.$verification_code.'</span></p>
            <p>
                Best regards,<br>
                eZpark Team
            </p>
        </div>';
        $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $this->mail->send();

        // Prepare statement
        $this->db->query('INSERT INTO user (name, username, email, password, userType, contactNo, otp, regTime) VALUES (:name, :username, :email, :password, :userType, :contactNo, :otp, :regTime)');

        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':userType', $data['user_type']);
        $this->db->bind(':contactNo', $data['contact_no']);
        $this->db->bind(':otp', $verification_code);
        $this->db->bind(':regTime', date("Y-m-d H:i:s"));

        // Execute
        if ($this->db->execute() and $this->userTableUpdate($data)){;
            return true;
        }
        else {
            return false;
        }
    }

    public function updateStatus($id):bool
    {
        $this->db->query('UPDATE user SET status = 1 WHERE id = :id');
        $this->db->bind(':id', $id);

        if ($this->db->execute()){
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
    public function findUserByEmailV($email, $state): bool
    {
        $this->db->query('SELECT * FROM user WHERE email = :email AND status = :status');
        $this->db->bind(':email', $email);
        $this->db->bind(':status', $state);

        $row = $this->db->single();

        // Check row
        if ($this->db->rowCount() > 0){
            return true;
        } else {
            return false;
        }
    }

    public function findUserByUsernameV($username, $state): bool
    {
        $this->db->query('SELECT * FROM user WHERE username = :username AND status = :status');
        $this->db->bind(':username', $username);
        $this->db->bind(':status', $state);

        $row = $this->db->single();

        // Check row
        if ($this->db->rowCount() > 0){
            return true;
        } else {
            return false;
        }
    }

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

    public function getUserByUsername($username){
        $this->db->query('SELECT * FROM user WHERE username = :username');
        $this->db->bind(':username', $username);

        $row = $this->db->single();

        if ($this->db->rowCount() > 0){
            return $row;
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