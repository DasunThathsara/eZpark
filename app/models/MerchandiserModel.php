<?php

use PHPMailer\PHPMailer\PHPMailer;

require APPROOT.'/libraries/vendor/autoload.php';
class MerchandiserModel{
    private $db;

    public function __construct(){
        $this->db = new Database();
        $this->mail = new PHPMailer(true);
        
    }

// // ------------------------- land Functionalities -------------------------
//     // Register land
//     public function registerLand($data): bool
//     {
//         // Prepare statement
//         $this->db->query('INSERT INTO land (name, city, street, deed, car, bike, threeWheel, contactNo, uid) VALUES (:name, :city, :street, :deed, :car, :bike, :threeWheel, :contactNo, :uid)');

//         // Bind values
    //     $this->db->bind(':name', $data['name']);
    //     $this->db->bind(':city', $data['city']);
    //     $this->db->bind(':street', $data['street']);
    //     $this->db->bind(':deed', $data['deed']);
    //     $this->db->bind(':car', $data['car']);
    //     $this->db->bind(':bike', $data['bike']);
    //     $this->db->bind(':threeWheel', $data['threeWheel']);
    //     $this->db->bind(':contactNo', $data['contactNo']);
    //     $this->db->bind(':uid', $_SESSION['user_id']);

    //     // Execute
    //     if ($this->db->execute()){
    //         return true;
    //     }
    //     else {
    //         return false;
    //     }
    // }

    // public function updateSecurityOfficerAvail($data): bool{
    //      die(print_r($data));
    //     // Prepare statement
    //     $this->db->query('UPDATE land SET secAvail = :secAvail  WHERE uid = :uid and name = :name ');

    //     // Bind values
    //     $this->db->bind(':name', $data['name']);
    //     $this->db->bind(':secAvail', $data['secAvail']);
    //     $this->db->bind(':uid', $_SESSION['user_id']);

    //     // Execute
    //     if ($this->db->execute()){
    //         return true;
    //     }
    //     else {
    //         return false;
    //     }
    // }

//     public function findLandID($name){
//         $this->db->query('SELECT * FROM land WHERE name = :name and uid = :uid');
//         $this->db->bind(':name', $name);
//         $this->db->bind(':uid', $_SESSION['user_id']);

//         $row = $this->db->single();
//         return $row->id;
//     }

//     public function setPrice($data):bool
//     {
//         if ($this->setCarPrice($data) and $this->setBikePrice($data) and $this->setThreeWheelPrice($data)){
//             return true;
//         }
//         else{
//             return false;
//         }
//     }

//     public function setCarPrice($data):bool
//     {
//         $id = (int)$this->findLandID($data['name']);

//         // Prepare statement
//         $this->db->query('INSERT INTO price (pid, vehicleType, hourPrice, additionalHourPrice) VALUES (:pid, :vehicleType, :hourPrice, :additionalHourPrice)');
//         $this->db->bind(':pid', $id);
//         $this->db->bind(':vehicleType', 'car');
//         $this->db->bind(':hourPrice', $data['car']);
//         $this->db->bind(':additionalHourPrice', 1);

//         // Execute
//         if ($this->db->execute()){
//             return true;
//         }
//         else {
//             return false;
//         }
//     }

//     public function setBikePrice($data):bool
//     {
//         $id = (int)$this->findLandID($data['name']);

//         // Prepare statement
//         $this->db->query('INSERT INTO price (pid, vehicleType, hourPrice, additionalHourPrice) VALUES (:pid, :vehicleType, :hourPrice, :additionalHourPrice)');
//         $this->db->bind(':pid', $id);
//         $this->db->bind(':vehicleType', 'bike');
//         $this->db->bind(':hourPrice', $data['bike']);
//         $this->db->bind(':additionalHourPrice', 1);

//         // Execute
//         if ($this->db->execute()){
//             return true;
//         }
//         else {
//             return false;
//         }
//     }

//     public function setThreeWheelPrice($data):bool
//     {
//         $id = (int)$this->findLandID($data['name']);

//         // Prepare statement
//         $this->db->query('INSERT INTO price (pid, vehicleType, hourPrice, additionalHourPrice) VALUES (:pid, :vehicleType, :hourPrice, :additionalHourPrice)');
//         $this->db->bind(':pid', $id);
//         $this->db->bind(':vehicleType', 'threeWheel');
//         $this->db->bind(':hourPrice', $data['threeWheel']);
//         $this->db->bind(':additionalHourPrice', 1);

//         // Execute
//         if ($this->db->execute()){
//             return true;
//         }
//         else {
//             return false;
//         }
//     }

//     // Find land
//     public function findLandByName($name): bool
//     {
//         $this->db->query('SELECT * FROM land WHERE name = :name and uid = :uid');
//         $this->db->bind(':name', $name);
//         $this->db->bind(':uid', $_SESSION['user_id']);

//         $row = $this->db->single();

//         // Check row
//         if ($this->db->rowCount() > 0){
//             return true;
//         } else {
//             return false;
//         }
//     }

//     public function viewLands(){
//         $this->db->query('SELECT * FROM land WHERE uid = :uid');
//         $this->db->bind(':uid', $_SESSION['user_id']);

//         $row = $this->db->resultSet();

//         return $row;
//     }

//     // Romove land
//     public function removeLand($data): bool
//     {
//         // Prepare statement
//         $this->db->query('DELETE FROM land WHERE name = :name AND uid = :uid');

//         // Bind values
//         $this->db->bind(':name', $data['name']);
//         $this->db->bind(':uid', $_SESSION['user_id']);
//         // Execute
//         if ($this->db->execute()){
//             return true;
//         }
//         else {
//             return false;
//         }
//     }

//     // Update land
//     public function updateLand($data): bool
//     {
//         // Prepare statement
//         $this->db->query('UPDATE land SET name = :name, city = :city, street = :street, deed = :deed, car = :car, bike = :bike, threeWheel = :threeWheel, contactNo = :contactNo  WHERE uid = :uid and name = :old_name ');

//         // Bind values
//         $this->db->bind(':name', $data['name']);
//         $this->db->bind(':old_name', $data['old_name']);
//         $this->db->bind(':city', $data['city']);
//         $this->db->bind(':street', $data['street']);
//         $this->db->bind(':deed', $data['deed']);
//         $this->db->bind(':car', $data['car']);
//         $this->db->bind(':bike', $data['bike']);
//         $this->db->bind(':threeWheel', $data['threeWheel']);
//         $this->db->bind(':contactNo', $data['contactNo']);
//         $this->db->bind(':uid', $_SESSION['user_id']);

//         // Execute
//         if ($this->db->execute()){
//             return true;
//         }
//         else {
//             return false;
//         }
//     }


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
        $this->db->query('SELECT * FROM driver_land WHERE landID = :landid AND startTime >= :sdate AND endTime <= :edate' );
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

  