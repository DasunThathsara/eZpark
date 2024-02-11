<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;  

//Load Composer's autoloader
require APPROOT.'/libraries/vendor/autoload.php';


class SecurityModel{
    private $db;

    public function __construct(){
        $this->db = new Database();
        $this->mail = new PHPMailer(true);
    }

    // Get security count of the land
    public function getSecurityCount($landID){
        // Prepare statement
        $this->db->query('SELECT COUNT(*) FROM security  WHERE landID = :landID');

        // Bind values
        $this->db->bind(':landID', $landID);


        $row = $this->db->single();
        return $row->{'COUNT(*)'};
    }

    // // View securities of the land
    // public function viewSecurities($id){
    //     $this->db->query('SELECT * FROM security WHERE id = :id;');

    //     // Bind values
    //     $this->db->bind(':id', $id);

    //     die(print_r($id));
    //     $row = $this->db->resultSet();

    //     return $row;
    // }

     // View securities of the land
    public function viewSecurities($landID){
        $this->db->query('
            SELECT u.id AS security_id, u.name AS security_name, u.contactNo AS sec_contact
            FROM user u
            JOIN security s ON u.id = s.id
            WHERE s.landID = :landID
        ');

        // Bind values
        $this->db->bind(':landID', $landID);
        // $this->db->bind(':id',$secID);

        $row = $this->db->resultSet();
        // die(print_r($row));
        return $row;
    }
   

    // View security profile
    public function viewSecurityProfile($data){
        $this->db->query('SELECT u.*, s.* FROM user u JOIN security s ON u.id = s.id WHERE u.id = :id;');

        // Bind values
        $this->db->bind(':id', $data['id']);

        $row = $this->db->resultSet();

        return $row;
    }

    // View all securities
    public function viewAvailableSecurities (){
//        $this->db->query('SELECT * FROM security_land_request slr LEFT JOIN security s ON slr.sid = s.id WHERE s.landID = 0;');
//        $this->db->query('SELECT * FROM security_land_request slr JOIN security s ON slr.sid = s.id WHERE s.landID = 0;');
        $this->db->query('SELECT u.name,s.* FROM user u JOIN security s ON u.id = s.id WHERE s.landID = 0;');
//        $this->db->query('SELECT u.name, s.*, COALESCE(slr.lid, 0) AS lid FROM user u JOIN security s ON u.id = s.id LEFT JOIN security_land_request slr ON s.id = slr.sid WHERE s.landID = 0;');

        $row = $this->db->resultSet();
//        die(print_r($row));
        return $row;
    }

    // Send request for security
    public function sendRequest($landID, $securityID){
        $this->db->query('INSERT INTO  security_land_request (lid, sid) VALUES (:landID, :securityID);');

        // Bind values
        $this->db->bind(':landID', $landID);
        $this->db->bind(':securityID', $securityID);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Cancel request for security
    public function cancelRequest($landID, $securityID){
        $this->db->query('DELETE FROM security_land_request WHERE lid = :landID AND sid = :securityID;');

        // Bind values
        $this->db->bind(':landID', $landID);
        $this->db->bind(':securityID', $securityID);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Get land request count
    public function getLandRequestCount(){
        // Prepare statement
        $this->db->query('SELECT COUNT(*) FROM security_land_request WHERE sid = :sid');

        // Bind values
        $this->db->bind(':sid', $_SESSION['user_id']);

        $row = $this->db->single();
        return $row->{'COUNT(*)'};
    }

    // Get security pending list
    public function getSecurityPendingList($LandID){
        // Prepare statement
        $this->db->query('SELECT * FROM security_land_request WHERE lid = :lid');

        // Bind values
        $this->db->bind(':lid', $LandID);

        $row = $this->db->resultSet();
        return $row;
    }

    // View land requests
    public function viewLandRequest(){
        $this->db->query('SELECT slr.lid, slr.sid, l.name, l.district, l.province
        FROM security_land_request AS slr
        JOIN land AS l ON slr.lid = l.id
        WHERE slr.sid = :sid;
        ');

        // Bind values
        $this->db->bind(':sid', $_SESSION['user_id']);

        $row = $this->db->resultSet();
        // die(print_r($row));

        return $row;
    }

    // Accept land request
    public function acceptLandRequest($id , $ownerId = null): bool
    {
        // Prepare statement
        $this->db->query('UPDATE security SET landID = :landID WHERE id = :id');

        // Bind values
        $this->db->bind(':landID', $id);
        $this->db->bind(':id', $_SESSION['user_id']);

        // Execute
        if ($this->db->execute()){

             // Get email and name
            $this->db->query('SELECT name, email FROM user WHERE id = :id');

            // Bind values
            $this->db->bind(':id', $ownerId);
            $data = $this->db->single();

        //    die(print_r($ownerId));

            $name = $data->name;
            $email = $data->email;

            // die(print_r($data));

            $message = '<div id="overview" style="margin: auto; width: 80%; font-size: 13px">
            <p style="color: black">
                Dear '.$name.',<br><br>
        
                The request that you sent for security by ('.$_SESSION['user_name'].') has been accepted.<br>
                Security ID : '.$_SESSION['user_id'].'.<br>
                <br>
                Best regards,<br>
                eZpark Team
            </p>
        </div>';

            $this->sendEmail($email, $name, 'Your land accepted.', $message);

            return true;
        }
        else {
            return false;
        }
    }

    // Decline land request
    public function declineLandRequest($id , $ownerId = null): bool
    {
        // Prepare statement for delete land request
        $this->db->query('DELETE FROM security_land_request WHERE lid = :lid AND sid = :sid');

        // Bind values
        $this->db->bind(':lid', $id);
        $this->db->bind(':sid', $_SESSION['user_id']);

        $result1 = $this->db->execute();

        // Prepare statement for delete notification
        $this->db->query('DELETE FROM notification WHERE senderID = :senderID AND receiverID = :receiverID');

        // Bind values
        $this->db->bind(':senderID', $id);
        $this->db->bind(':receiverID', $_SESSION['user_id']);

        $result2 = $this->db->execute();

        // Execute
        if ($result1 && $result2){

            // Get email and name
            $this->db->query('SELECT name, email FROM user WHERE id = :uid');

            // Bind values
            $this->db->bind(':uid', $ownerId);
            $data = $this->db->single();

        //    die(print_r($ownerId));

            $name = $data->name;
            $email = $data->email;

            // die(print_r($data));

            $message = '<div id="overview" style="margin: auto; width: 80%; font-size: 13px">
            <p style="color: black">
                Dear '.$name.',<br><br>
        
                The request that you sent for security by ('.$_SESSION['user_name'].') has been declined.<br>
                Security ID : '.$_SESSION['user_id'].'.<br>
                <br>
                Best regards,<br>
                eZpark Team
            </p>
        </div>';

            $this->sendEmail($email, $name, 'Your land declined.', $message);

            return true;
        }
        else {
            return false;
        }
    }

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

        //Attachments
//    $mail->addAttachment('/var/tmp/file.tar.gz');        //Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');   //Optional name

        //Content
        $this->mail->isHTML(true);                     //Set email format to HTML
        $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
        $this->mail->Body = $message;
        $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $this->mail->send();
    }

    // Get assigned land id
    public function getAssignedLandID(){
        // Prepare statement
        $this->db->query('SELECT landID FROM security WHERE id = :id');

        // Bind values
        $this->db->bind(':id', $_SESSION['user_id']);

        $row = $this->db->single();
        return $row->landID;
    }

     // Get assigned land id
     public function securityRemove(){
        // // Prepare statement
        // $this->db->query('SELECT landID FROM security WHERE id = :id');

        // // Bind values
        // $this->db->bind(':id', $_SESSION['user_id']);

        // $row = $this->db->single();
        // return $row->landID;
    }
}