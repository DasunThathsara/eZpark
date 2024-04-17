<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;  

//Load Composer's autoloader
require APPROOT.'/libraries/vendor/autoload.php';

class ParkingOwnerModel{
    private $db;

    public function __construct(){
        $this->db = new Database();
        $this->mail = new PHPMailer(true);
    }

    // ------------------------- package Functionalities -------------------------
    // Register package
    public function registerPackage($data): bool
    {
        $this->db->query('INSERT INTO package (name, price, packageType, pid) VALUES (:name, :price, :packageType, :pid)');

        // Bind values
        $this->db->bind(':name', $data['package_type']);
        $this->db->bind(':price', $data['package_price']);
        $this->db->bind(':packageType', $data['vehicle_type']);
        $this->db->bind(':pid', $data['id']);

            // Execute
        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }

    public function checkPackage($data): bool
    {
        // Check if the package already exists
        $this->db->query('SELECT COUNT(*) AS count FROM package WHERE name = :name AND packageType = :packageType AND pid = :pid');

        // Bind values
        $this->db->bind(':name', $data['package_type']);
        $this->db->bind(':packageType', $data['vehicle_type']);
        $this->db->bind(':pid', $data['id']);
        $result = $this->db->single();

        // If a package with the same key values already exists, return false
        if ($result->count == 0){
            return true;
        }
        else {
            return false;
        }
    }

    // Find package
    public function findPackage($pid, $package_type, $vehicle_type): bool
    {
        $this->db->query('SELECT * FROM package WHERE name = :name and pid = :pid and packageType = :packageType');
        $this->db->bind(':name', $package_type);
        $this->db->bind(':pid', $pid);
        $this->db->bind('packageType', $vehicle_type);

        $row = $this->db->single();

        // Check row
        if ($this->db->rowCount() > 0){
            return true;
        } else {
            return false;
        }
    }

    public function viewPackages($data){
        $this->db->query('SELECT * FROM package WHERE pid = :pid');
        $this->db->bind(':pid', $data['id']);

        $row = $this->db->resultSet();

        return $row;
    }

    public function removePackage($data): bool
    {
        // Prepare statement
        $this->db->query('DELETE FROM package WHERE name = :name AND pid = :pid AND packageType = :packageType');

        // Bind values
        $this->db->bind(':name', $data['package_type']);
        $this->db->bind(':packageType', $data['vehicle_type']);
        $this->db->bind(':pid', $data['id']);

        // Execute
        if ($this->db->execute()){
            return true;
        }
        else {

            return false;
        }
    }

    public function updatePackage($data): bool
    {
        // Prepare statement
        $this->db->query('UPDATE package SET name = :name, price=:price, packageType =:packageType WHERE pid = :pid and name = :oldName and packageType = :oldPackageType ');

        // Bind values
        $this->db->bind(':oldPackageType', $data['old_vehicle_type']);
        $this->db->bind(':packageType', $data['vehicle_type']);
        $this->db->bind(':price', $data['package_price']);
        $this->db->bind(':oldName', $data['old_package_type']);
        $this->db->bind(':name', $data['package_type']);
        $this->db->bind(':pid', $data['id']);

        // die(print_r($data));
        // Execute
        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }

    public function viewToBeUpdatedPackage($data){
        $this->db->query('SELECT * FROM package WHERE pid = :pid and name = :name and packageType = :packageType');
        $this->db->bind(':pid', $data['id']);
        $this->db->bind(':name', $data['package_type']);
        $this->db->bind(':packageType', $data['vehicle_type']);

        $row = $this->db->resultSet();

        return $row;
    }

    public function getPackageCount($data){
        // Prepare statement
        $this->db->query('SELECT COUNT(*) FROM package  WHERE pid = :pid');

        // Bind values
        $this->db->bind(':pid', $data['id']);


        $row = $this->db->single();
        return $row->{'COUNT(*)'};
    }

    // ------------------------- Price Functionalities -------------------------
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

    // ------------------------- Report Functionalities -------------------------
    // View report
    public function viewReport($data){
        $this->db->query('SELECT * FROM driver_land WHERE landID = :landid');
        $this->db->bind(':landid', $data['landid']);
        
        $row = $this->db->resultSet();

        return $row;
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