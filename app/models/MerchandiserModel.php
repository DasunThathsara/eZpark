<?php

use PHPMailer\PHPMailer\PHPMailer;

require APPROOT.'/libraries/vendor/autoload.php';
class MerchandiserModel{
    private $db;

    public function __construct(){
        $this->db = new Database();
        $this->mail = new PHPMailer(true);
        
    }

    // Request to a parking
    public function mergeParking($land_ID, $baseLandID, $duration){
        // Prepare statement
        $this->db->query('INSERT INTO parking_merge (landID, baseLandID, duration) VALUES (:landID, :baseLandID, :duration)');

        // Bind values
        $this->db->bind(':landID', $land_ID);
        $this->db->bind(':baseLandID', $baseLandID);
        $this->db->bind(':duration', $duration);

        // Execute
        if ($this->db->execute()){
            $this->db->query('SELECT LAST_INSERT_ID() AS id;');
            $id = $this->db->single();
            return $id->id;
        }
        else {
            return false;
        }
    }

    // confirm parking merge
    public function confirmMergeParking($mergeID){
        // Prepare statement
        $this->db->query('UPDATE parking_merge SET status = 1 WHERE mergeID = :mergeID');

        // Bind values
        $this->db->bind(':mergeID', $mergeID);

        // Execute
        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }

    // ------------------------- Assigned Security Functionalities -------------------------
    public function landAccessControl($sec_id): bool{
        // Prepare statement
        $this->db->query('UPDATE security SET landAccess = CASE WHEN landAccess = 1 THEN 0 WHEN landAccess = 0 THEN 1 ELSE landAccess END WHERE id = :id;');
        // die(print_r($sec_id));
        // Bind values
        $this->db->bind(':id', $sec_id);

        // Execute
        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }

        // ------------------------- Report Functionalities -------------------------
    // View report
    public function viewReport($data){
        $this->db->query('SELECT * FROM driver_land dl LEFT JOIN vehicle v ON dl.driverID = v.id WHERE landID = :landid AND startTime >= :sdate AND endTime <= :edate' );
        $this->db->bind(':landid', $data['landid']);
        $this->db->bind(':sdate', $data['sdate']);
        $this->db->bind(':edate', date('Y-m-d', strtotime($data['edate'] . ' +1 day')));
        
        $row = $this->db->resultSet();
        

        return $row;
    }

         // Get assigned land id
     public function securityRemove($sec_id , $land_ID){
        // Prepare statement
        $this->db->query('UPDATE security SET landID = 0, landAccess = 0 WHERE id = :sec_id');

        // Bind values
        $this->db->bind(':sec_id', $sec_id);

        // die(print_r($sec_id));

        // Execute
        // Execute
        if ($this->db->execute()){

            // Get email and name
            $this->db->query('SELECT name, email FROM user WHERE id = :sec_id');

            // Bind values
            $this->db->bind(':sec_id', $sec_id);
            $data = $this->db->single();

            $this->db->query('SELECT name FROM land WHERE id = :land_ID');

            $this->db->bind(':land_ID', $land_ID);
            $landDetails = $this->db->single();

            $name = $data->name;
            $email = $data->email;
            $landName = $landDetails->name;

            // die(print_r($data));

            $message = '<div id="overview" style="margin: auto; width: 80%; font-size: 13px">
            <p style="color: black">
                Dear '.$name.'<br>
                (Security ID: '.$sec_id.'),<br><br>
        
                The request that you sent for security by ('.$_SESSION['user_name'].') has been removed for the assigned land.<br>
                Land Name: '.$landName.'<br>
                Land ID: '.$land_ID.'<br>
                <br>
                Best regards,<br>
                eZpark Team
            </p>
        </div>';

            $this->sendEmail($email, $name, 'Unassigned Land.', $message);

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
}

  