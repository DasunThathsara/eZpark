<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require APPROOT.'/libraries/vendor/autoload.php';

class LandModel{
    private $db;
    private $mail;

    public function __construct(){
        $this->db = new Database();
        $this->mail = new PHPMailer(true);
    }

    // ------------------------- Land Functionalities -------------------------
    // Register land
    public function registerLand($data): bool
    {
        // Prepare statement
        $this->db->query('INSERT INTO land (name, city, street, deed, car, bike, threeWheel, contactNo, uid, status, availability, QR) VALUES (:name, :city, :street, :deed, :car, :bike, :threeWheel, :contactNo, :uid, :status, :availability, :QR)');

        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':city', $data['city']);
        $this->db->bind(':street', $data['street']);
        $this->db->bind(':deed', $data['deed']);
        $this->db->bind(':car', $data['car']);
        $this->db->bind(':bike', $data['bike']);
        $this->db->bind(':threeWheel', $data['threeWheel']);
        $this->db->bind(':contactNo', $data['contactNo']);
        $this->db->bind(':uid', $_SESSION['user_id']);
        $this->db->bind(':status', 0);
        $this->db->bind(':availability', 0);
        $this->db->bind(':QR', $data['qrcode']);

        // Execute
        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }

    // Set security availability
    public function updateSecurityOfficerAvail($data): bool{
        // die(print_r($data));
        // Prepare statement
        $this->db->query('UPDATE land SET secAvail = :secAvail  WHERE uid = :uid and name = :name ');

        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':secAvail', $data['secAvail']);
        $this->db->bind(':uid', $_SESSION['user_id']);

        // Execute
        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }

    // Set three wheel price
    public function findLandID($name){
        $this->db->query('SELECT * FROM land WHERE name = :name and uid = :uid');
        $this->db->bind(':name', $name);
        $this->db->bind(':uid', $_SESSION['user_id']);

        $row = $this->db->single();
        return $row->id;
    }

    // Set vehicle price
    public function setPrice($data):bool
    {
        if ($this->setCarPrice($data) and $this->setBikePrice($data) and $this->setThreeWheelPrice($data)){
            return true;
        }
        else{
            return false;
        }
    }

    // Set car price
    public function setCarPrice($data):bool
    {
        $id = (int)$this->findLandID($data['name']);

        // Prepare statement
        $this->db->query('INSERT INTO price (pid, vehicleType, hourPrice, additionalHourPrice) VALUES (:pid, :vehicleType, :hourPrice, :additionalHourPrice)');
        $this->db->bind(':pid', $id);
        $this->db->bind(':vehicleType', 'car');
        $this->db->bind(':hourPrice', $data['car']);
        $this->db->bind(':additionalHourPrice', 1);

        // Execute
        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }

    // Set bike price
    public function setBikePrice($data):bool
    {
        $id = (int)$this->findLandID($data['name']);

        // Prepare statement
        $this->db->query('INSERT INTO price (pid, vehicleType, hourPrice, additionalHourPrice) VALUES (:pid, :vehicleType, :hourPrice, :additionalHourPrice)');
        $this->db->bind(':pid', $id);
        $this->db->bind(':vehicleType', 'bike');
        $this->db->bind(':hourPrice', $data['bike']);
        $this->db->bind(':additionalHourPrice', 1);

        // Execute
        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }

    // Set three wheel price
    public function setThreeWheelPrice($data):bool
    {
        $id = (int)$this->findLandID($data['name']);

        // Prepare statement
        $this->db->query('INSERT INTO price (pid, vehicleType, hourPrice, additionalHourPrice) VALUES (:pid, :vehicleType, :hourPrice, :additionalHourPrice)');
        $this->db->bind(':pid', $id);
        $this->db->bind(':vehicleType', 'threeWheel');
        $this->db->bind(':hourPrice', $data['threeWheel']);
        $this->db->bind(':additionalHourPrice', 1);

        // Execute
        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }

    // Find land
    public function findLandByName($name): bool
    {
        $this->db->query('SELECT * FROM land WHERE name = :name and uid = :uid');
        $this->db->bind(':name', $name);
        $this->db->bind(':uid', $_SESSION['user_id']);

        $row = $this->db->single();

        // Check row
        if ($this->db->rowCount() > 0){
            return true;
        } else {
            return false;
        }
    }

    // View all lands of current user
    public function viewLands(){
        $this->db->query('SELECT * FROM land WHERE uid = :uid and status = :status');
        $this->db->bind(':uid', $_SESSION['user_id']);
        $this->db->bind(':status', 1);

        $row = $this->db->resultSet();

        return $row;
    }

    // View all lands
    public function viewAllLands(){
        $this->db->query('SELECT * FROM land WHERE status = :status');
        $this->db->bind(':status', 1);

        $row = $this->db->resultSet();

        return $row;
    }

    public function viewLand($id){
        $this->db->query('SELECT * FROM land WHERE id = :id');
        $this->db->bind(':id', $id);

        $row = $this->db->single();
        return $row;
    }

    // Remove land
    public function removeLand($data): bool
    {
        // Prepare statement
        $this->db->query('DELETE FROM land WHERE name = :name AND uid = :uid');

        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':uid', $_SESSION['user_id']);
        // Execute
        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }

    // Update land
    public function updateLand($data): bool
    {
        // Prepare statement
        $this->db->query('UPDATE land SET name = :name, city = :city, street = :street, deed = :deed, car = :car, bike = :bike, threeWheel = :threeWheel, contactNo = :contactNo  WHERE uid = :uid and name = :old_name ');

        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':old_name', $data['old_name']);
        $this->db->bind(':city', $data['city']);
        $this->db->bind(':street', $data['street']);
        $this->db->bind(':deed', $data['deed']);
        $this->db->bind(':car', $data['car']);
        $this->db->bind(':bike', $data['bike']);
        $this->db->bind(':threeWheel', $data['threeWheel']);
        $this->db->bind(':contactNo', $data['contactNo']);
        $this->db->bind(':uid', $_SESSION['user_id']);

        // Execute
        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }

    public function viewToBeUpdatedLand($data){
        $this->db->query('SELECT * FROM land WHERE id = :id');
        $this->db->bind(':id', $data['id']);

        $row = $this->db->resultSet();

        return $row;
    }

    public function getLandCount(){
        // Prepare statement
        $this->db->query('SELECT COUNT(*) FROM land  WHERE uid = :id and status = :status');

        // Bind values
        $this->db->bind(':id', $_SESSION['user_id']);
        $this->db->bind(':status', 1);


        $row = $this->db->single();
        return $row->{'COUNT(*)'};
    }

    public function getUnVerifyLandCount(){
        // Prepare statement
        $this->db->query('SELECT COUNT(*) FROM land  WHERE status = :status');

        // Bind values
        $this->db->bind(':status', 0);


        $row = $this->db->single();
        return $row->{'COUNT(*)'};
    }

    public function viewUnVerifyLands(){
        // Prepare statement
        $this->db->query('SELECT * FROM land  WHERE status = :status');

        // Bind values
        $this->db->bind(':status', 0);


        $row = $this->db->resultSet();
        return $row;
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

    public function verifyLand($id): bool
    {
        // Get the landowner's id
        $this->db->query('SELECT * FROM land  WHERE id = :id');

        // Bind values
        $this->db->bind(':id', $id);
        $row = $this->db->single();

        $uid = $row->uid;
        $parking_name = $row->name;
        $deed = $row->deed;

        // Prepare statement
        $this->db->query('UPDATE land SET status = :status WHERE id = :id');

        // Bind values
        $this->db->bind(':status', 1);
        $this->db->bind(':id', $id);

        // Execute
        if ($this->db->execute()){
            // Get email and name
            $this->db->query('SELECT name, email FROM user WHERE id = :id');

            // Bind values
            $this->db->bind(':id', $uid);
            $data = $this->db->single();

//            die(print_r($data));

            $name = $data->name;
            $email = $data->email;

            $message = '<div id="overview" style="margin: auto; width: 80%; font-size: 13px">
            <p style="color: black">
                Dear '.$name.',<br><br>
        
                Your land '.$parking_name.' is now vrified. You can now login to your account and start using it.<br>
                <br>
                Best regards,<br>
                eZpark Team
            </p>
        </div>';

            $this->sendEmail($email, $name, 'Your land is now verified.', $message);

            return true;
        }
        else {
            return false;
        }
    }

    public function unverifyLand($id): bool
    {
        // Get the landowner's id
        $this->db->query('SELECT uid, name FROM land  WHERE id = :id');

        // Bind values
        $this->db->bind(':id', $id);
        $row = $this->db->single();

        $uid = $row->uid;
        $parking_name = $row->name;

        // Prepare statement
        $this->db->query('DELETE FROM land WHERE id = :id');

        // Bind values
        $this->db->bind(':id', $id);

        // Execute
        if ($this->db->execute()){
            // Get email and name
            $this->db->query('SELECT name, email FROM user WHERE id = :id');

            // Bind values
            $this->db->bind(':id', $uid);
            $data = $this->db->single();

//            die(print_r($data));

            $name = $data->name;
            $email = $data->email;

            // Prepare statement
            $this->mail->isSMTP();                             //Send using SMTP
            $this->mail->Host = 'smtp.gmail.com';              //Set the SMTP server to send through
            $this->mail->SMTPAuth = true;                      //Enable SMTP authentication
            $this->mail->Username = 'ezpark.help@gmail.com';   //SMTP username
            $this->mail->Password = 'pcop yjvy adrx mlcl';     //SMTP password
            $this->mail->Port = 587;                           //TCP port to connect to; use 587 if you have set SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS

            //Recipients
            $this->mail->setFrom('ezpark.help@gmail.com', 'Your land request was rejected.');
            $this->mail->addAddress($email, $name);            //Add a recipient

            //Attachments
//    $mail->addAttachment('/var/tmp/file.tar.gz');        //Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');   //Optional name

            //Content
            $this->mail->isHTML(true);                     //Set email format to HTML
            $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
            $this->mail->Body = '<div id="overview" style="margin: auto; width: 80%; font-size: 13px">
            <p style="color: black">
                Dear '.$name.',<br><br>
        
                Your land '.$parking_name.'\'s registration request was rejected. now vrified. Try again with the correct details, and if you have any clarifications, contact us.<br>
                <br>
                Best regards,<br>
                eZpark Team
            </p>
        </div>';
            $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $this->mail->send();

            return true;
        }
        else {
            return false;
        }
    }

    public function viewCapacity($data){
        $this->db->query('SELECT car, bike, threeWheel FROM land WHERE id = :id');
        $this->db->bind(':id', $data['id']);

        $row = $this->db->resultSet();

        return $row;
    }

    // Get total capacity
    public function getTotalCapacity(){
        $this->db->query('SELECT car + bike + threeWheel AS totCap FROM land WHERE uid = :uid');
        $this->db->bind(':uid', $_SESSION['user_id']);

        $row = $this->db->resultSet();

        $total_capacity = 0;
        foreach ($row as $item){
            $total_capacity += $item->totCap;
        }
        return $total_capacity;
    }

    public function updateCapacity($data): bool
    {
        // Prepare statement
        if($data['vehicle_type'] == 'car')
            $this->db->query('UPDATE land SET car = :capacity WHERE id = :id');
        else if($data['vehicle_type'] == 'bike')
            $this->db->query('UPDATE land SET bike = :capacity WHERE id = :id');
        else if($data['vehicle_type'] == 'threeWheel')
            $this->db->query('UPDATE land SET threeWheel = :capacity WHERE id = :id');

        // Bind values
        $this->db->bind(':capacity', $data['capacity']);
        $this->db->bind(':id', $data['id']);


        // Execute
        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }

    // View slot prices
    public function viewPrice($data){
        $this->db->query('SELECT * FROM price WHERE pid = :pid');
        $this->db->bind(':pid', $data['id']);

        $row = $this->db->resultSet();

        return $row;
    }

    // Update slot price
    public function updatePrice($data): bool
    {
        // Prepare statement
        $this->db->query('UPDATE price SET hourPrice = :hourPrice, additionalHourPrice = :additionalHourPrice WHERE pid = :pid and vehicleType = :vehicleType');

        // Bind values
        $this->db->bind(':hourPrice', $data['hour_price']);
        $this->db->bind(':additionalHourPrice', $data['additional_hour_price']);
        $this->db->bind(':vehicleType', $data['vehicle_type']);
        $this->db->bind(':pid', $data['id']);


        // Execute
        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }
}