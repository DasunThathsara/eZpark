<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require APPROOT.'/libraries/vendor/autoload.php';
class UserModel{
    private $db;
    private $mail;

    public function __construct(){
        $this->db = new Database();
        $this->mail = new PHPMailer(true);
    }

    // Email Sender
    public function sendEmail($email, $name, $subject, $message){
        $this->mail->isSMTP();                             //Send using SMTP
        $this->mail->Host = 'smtp.gmail.com';              //Set the SMTP server to send through
        $this->mail->SMTPAuth = true;                      //Enable SMTP authentication
        $this->mail->Username = 'ezpark.help@gmail.com';   //SMTP username
        $this->mail->Password = 'pcop yjvy adrx mlcl';     //SMTP password
        $this->mail->Port = 587;                           //TCP port to connect to; use 587 if you have set SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS

        //Recipients
        $this->mail->setFrom('ezpark.help@gmail.com', $subject);
        $this->mail->addAddress($email, $name);            //Add a recipient

        //Content
        $this->mail->isHTML(true);                  //Set email format to HTML
        $this->mail->Subject = $subject;
        $this->mail->Body = $message;
        $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $this->mail->send();
    }

    // Register user
    public function register($data): bool
    {
        if ($data['user_type'] != 'admin'){
            $name = $data['name'];
            $email = $data['email'];

            //Content
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
            $this->sendEmail($email, $name, 'Verification code', $this->mail->Body);
        }
        else{
            $verification_code = '000000';
        }

        // Prepare statement
        $this->db->query('INSERT INTO user (name, username, email, password, userType, contactNo, otp, otpTime) VALUES (:name, :username, :email, :password, :userType, :contactNo, :otp, :otpTime)');

        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':userType', $data['user_type']);
        $this->db->bind(':contactNo', $data['contact_no']);
        $this->db->bind(':otp', $verification_code);
        $this->db->bind(':otpTime', date("Y-m-d H:i:s"));

        // Execute
        if ($this->db->execute() and $this->userTableUpdate($data)){;
            return true;
        }
        else {
            return false;
        }
    }

    // Update user status
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

    // Resend OTP
    public function resendOTP($data): bool
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
        $this->db->query('UPDATE user SET otp = :otp, otpTime = :otpTime WHERE id = :id');

        // Bind values
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':otp', $verification_code);
        $this->db->bind(':otpTime', date("Y-m-d H:i:s"));

        // Execute
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

        $result = true;

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

            $result = $this->db->execute();
        }
        else if ($data['user_type'] == 'security'){
            $this->db->query('INSERT INTO security (id, NIC, experience, address, preferredDistrictToWork) VALUES (:id, :NIC, :experience, :address, :preferredDistrictToWork)');
            $this->db->bind(':id', $id);
            $this->db->bind(':NIC', $data['NIC']);
            $this->db->bind(':experience', $data['experience']);
            $this->db->bind(':address', $data['address']);
            $this->db->bind(':preferredDistrictToWork', $data['city']);

            $result = $this->db->execute();
        }

        // Execute
        if ($result){
            return true;
        }
        else {
            return false;
        }
    }

    // Find verified user by email
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

    // Find verified user by username
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

    // Find user by email
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

    // Find user by username
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

    // Find user count by username
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

    // Get ban count
    public function getStatus($username){
        $this->db->query('SELECT banCount FROM user WHERE username = :username');
        $this->db->bind(':username', $username);

        $row = $this->db->single();

        return $row->banCount;
    }

    // Get ban time
    public function getBanTime($username){
        $this->db->query('SELECT banTime FROM user WHERE username = :username');
        $this->db->bind(':username', $username);

        $row = $this->db->single();

        return $row->banTime;
    }

    // Unban according to the time
    public function UnbanAccordingTime(){
        $this->db->query('UPDATE user
SET status = :status
WHERE (banCount = 1 OR banCount = 2) 
    AND (banCount = 1 AND DATE_ADD(banTime, INTERVAL 1 DAY) <= NOW()
         OR banCount = 2 AND DATE_ADD(banTime, INTERVAL 7 DAY) <= NOW());');

        $this->db->bind(':status', 1);

        // Execute
        if ($this->db->execute()){;
            return true;
        }
        else {
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

    // Get admin count
    public function getAdminCount(){
        $this->db->query('SELECT COUNT(*) AS adminCount FROM user WHERE userType = "admin"');

        $row = $this->db->single();

        return $row->adminCount;
    }

    // View all admins
    public function viewAdmins(){
        $this->db->query('SELECT * FROM user WHERE userType = "admin" AND status != 10');

        $results = $this->db->resultSet();

        return $results;
    }

    // View specific admin
    public function viewAdmin($admin_id){
        $this->db->query('SELECT * FROM user WHERE id = :id');
        $this->db->bind(':id', $admin_id);

        $row = $this->db->single();

        return $row;
    }

    // Remove admin
    public function removeAdmin($admin_id){
        $this->db->query('UPDATE user SET status = 10 WHERE id = :id');
        $this->db->bind(':id', $admin_id);

        // Execute
        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }

    // Ban admin
    public function banAdmin($admin_id){
        $this->db->query('SELECT name, email FROM user WHERE id = :id');

        // Bind values
        $this->db->bind(':id', $admin_id);
        $data = $this->db->single();

        $name = $data->name;
        $email = $data->email;

        //Content
        $this->mail->Body = '<div id="overview" style="margin: auto; width: 80%; font-size: 13px">
            <p style="color: black">
                Dear '.$name.',<br><br>
        
                We regret to inform you that your account with eZpark has been banned. This action has been taken due to a violation of our terms of service or community guidelines.
                <br><br>
                Reasons for account bans include, but are not limited to, engaging in prohibited activities, violation of user policies, or repeated breaches of our terms.
                <br><br>
                If you believe this action has been taken in error or if you have any questions, please contact our support team at support@ezpark.com.
                <br><br>
                We take the security and well-being of our community seriously, and we appreciate your understanding.
                <br>
            </p>
            <p>
                Best regards,<br>
                eZpark Team
            </p>
        </div>';

        $this->sendEmail($email, $name, 'Your account has been banned', $this->mail->Body);

        $this->db->query('UPDATE user SET status = 2, banCount = banCount + 1, banTime = :banTime WHERE id = :id');
        $this->db->bind(':id', $admin_id);
        $this->db->bind(':banTime', date("Y-m-d H:i:s"));

        // Execute
        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }

    // Update admin
    public function updateAdmin($data): bool
    {
        // Prepare statement
        $this->db->query('UPDATE user SET username = :username, name = :name, password = :password WHERE id = :id');

        // Bind values
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', $data['password']);

        // Execute
        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }

    // Get notification count
    public function getNotificationCount(){
        if ($_SESSION['user_type'] == 'admin')
            $this->db->query('SELECT COUNT(*) AS notificationCount FROM notification WHERE (receiverId = :receiverId OR receiverId = 0) AND status = 0');
        else
            $this->db->query('SELECT COUNT(*) AS notificationCount FROM notification WHERE receiverId = :receiverId AND status = 0');

        $this->db->bind(':receiverId', $_SESSION['user_id']);

        $row = $this->db->single();

        return $row->notificationCount;
    }

    // View notifications
    public function viewNotifications(){
        if ($_SESSION['user_type'] == 'admin')
            $this->db->query('SELECT * FROM notification WHERE receiverId = 0 OR receiverId = :receiverId ORDER BY notificationTime DESC');
        else
            $this->db->query('SELECT * FROM notification WHERE receiverId = :receiverId ORDER BY notificationTime DESC');
        $this->db->bind(':receiverId', $_SESSION['user_id']);

        $results = $this->db->resultSet();

        return $results;
    }

    // Add notification
    public function addNotification($notification, $type, $sender, $receiver): bool
    {
        // Prepare statement
        $this->db->query('INSERT INTO notification (receiverId, senderId, notificationType, notification, status) VALUES (:receiverId, :senderId, :notificationType, :notification, :status)');

        // Bind values
        $this->db->bind(':receiverId', $receiver);
        $this->db->bind(':senderId', $sender);
        $this->db->bind(':notificationType', $type);
        $this->db->bind(':notification', $notification);
        $this->db->bind(':status', 0);

        // Execute
        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }

    // Remove notification
    public function removeNotification($type, $sender, $receiver): bool
    {
        // Prepare statement
        $this->db->query('DELETE FROM notification WHERE senderId = :senderId AND receiverId = :receiverId AND notificationType = :notificationType');

        // Bind values
        $this->db->bind(':senderId', $sender);
        $this->db->bind(':receiverId', $receiver);
        $this->db->bind(':notificationType', $type);

        // Execute
        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }

    // Remove notification by ID
    public function removeNotificationByID($id): bool
    {
        // Prepare statement
        $this->db->query('DELETE FROM notification WHERE id = :id');

        // Bind values
        $this->db->bind(':id', $id);

        // Execute
        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }

    // Change notification status
    public function markAsRead($id): bool
    {
        // Prepare statement
        $this->db->query('UPDATE notification SET status = 1 WHERE id = :id');

        // Bind values
        $this->db->bind(':id', $id);

        // Execute
        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }


    //chat
    //get all users 
    // View all users
    public function viewUsers(){
        // $this->db->query('SELECT * FROM user WHERE userType = "merchandiser" AND userType = "security"');
        $this->db->query('SELECT * FROM user');

        $results = $this->db->resultSet();

        return $results;

    }
        // new function
        public function viewUsersById(){
        
        
        $outgoing_id = $_SESSION['user_id'];
        $sql = mysqli_query($conn , "SELECT * FROM user WHERE NOT id = {$outgoing_id}");
        $output = "";

        if(mysqli_num_rows($sql) == 1){
            $output .= "No users are available to chat";
        }else if(mysqli_num_rows($sql) > 0){
            // include "data.php";

            while($row = mysqli_fetch_assoc($sql)){

                $sql2 = "SELECT * FROM chat WHERE (incoming_msg_id = {$row['id']}
                        OR outgoing_msg_id = {$row['id']}) AND (outgoing_msg_id = {$outgoing_id}
                        OR incoming_msg_id = {$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";
        
                $query2 = mysqli_query($conn, $sql2);
                $row2 = mysqli_fetch_assoc($query2);
                if(mysqli_num_rows($query2)>0){
                    $result = $row2['msg'];
                }else{
                    $result = "No msg available";
                }
        
                (strlen($result)>28) ? $msg = substr($result,0 ,28).'...' : $msg = $result;
        
                $you = ""; // Initialize $you to an empty string
                if (isset($outgoing_id) && isset($row2['outgoing_msg_id']) && $outgoing_id == $row2['outgoing_msg_id']) {
                    $you = "You: ";
                }
        
                //check online or offline
                // ($row['status'] == "Offline now") ? $offline = "offline" : $offline = "";
        
        
                $output .= '<a href="chat.php?user_id='.$row['id'].'">
                            <div class="content">
                            // <!-- <img src="php/images/'.$row['img'].'" alt=""> -->
                            <div class="details">
                            <span>'. $row['username'] .'</span>
                            <p>'. $you . $msg .'</p>
                            </div>
                            </div>
                            // <div class="status-dot Online"><i class="fas fa-circle"></i></div>
                            </a>';
            }
        }
        return $output;
        }
}