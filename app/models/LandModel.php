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

    // Register parking slot
    public function registerParkingSlot($landID, $car, $bike, $threewheel): bool
    {
        $result = true;

        for ($i = 1; $i <= $car; $i++){
            $this->db->query('INSERT INTO parking_slot (slotID, landID, vehicleType, availability) VALUES (:slotID, :landID, :vehicleType, :availability)');

            $this->db->bind(':slotID', $i);
            $this->db->bind(':landID', $landID);
            $this->db->bind(':vehicleType', 'car');
            $this->db->bind(':availability', 0);

            if ($this->db->execute()){
                $result = $result & true;
            }
            else {
                $result = $result & false;
            }
        }

        for ($i = $car + 1; $i <= $bike + $car; $i++){
            $this->db->query('INSERT INTO parking_slot (slotID, landID, vehicleType, availability) VALUES (:slotID, :landID, :vehicleType, :availability)');

            $this->db->bind(':slotID', $i);
            $this->db->bind(':landID', $landID);
            $this->db->bind(':vehicleType', 'bike');
            $this->db->bind(':availability', 0);

            if ($this->db->execute()){
                $result = $result & true;
            }
            else {
                $result = $result & false;
            }
        }

        for ($i = $car + $bike + 1; $i <= $threewheel + $car + $bike; $i++){
            $this->db->query('INSERT INTO parking_slot (slotID, landID, vehicleType, availability) VALUES (:slotID, :landID, :vehicleType, :availability)');

            $this->db->bind(':slotID', $i);
            $this->db->bind(':landID', $landID);
            $this->db->bind(':vehicleType', 'threewheel');
            $this->db->bind(':availability', 0);

            if ($this->db->execute()){
                $result = $result & true;
            }
            else {
                $result = $result & false;
            }
        }

        return $result;
    }

    // Register land
    public function registerLand($data): bool
    {
        // Prepare statement
        $this->db->query('INSERT INTO land (name, city, street, deed, car, bike, threeWheel, contactNo, uid, status, availability, address, district, province, cover, latitude, longitude, image1, image2, image3) VALUES (:name, :city, :street, :deed, :car, :bike, :threeWheel, :contactNo, :uid, :status, :availability, :address, :district, :province, :cover, :latitude, :longitude, :image1, :image2, :image3)');

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
//        $this->db->bind(':QR', $data['qrcode']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':district', $data['district']);
        $this->db->bind(':province', $data['province']);
        $this->db->bind(':cover', $data['cover']);
        $this->db->bind(':latitude', $data['latitude']);
        $this->db->bind(':longitude', $data['longitude']);
        $this->db->bind(':image1', $data['photo1']);
        $this->db->bind(':image2', $data['photo2']);
        $this->db->bind(':image3', $data['photo3']);

        // Execute
        if ($this->db->execute()){
            $this->db->query('SELECT LAST_INSERT_ID() AS landID');
            $result = $this->db->single();
            if ($this->registerParkingSlot($result->landID, $data['car'], $data['bike'], $data['threeWheel'])){
                return true;
            }
            else{
                return false;
            }
        }
        else {
            return false;
        }
    }

    // Get land name
    public function getLandName($land_ID){
        $this->db->query('SELECT name FROM land WHERE id = :id');
        $this->db->bind(':id', $land_ID);

        $row = $this->db->single();

        return $row->name;
    }

    // Get land district
    public function getLandDistrict($land_ID){
        $this->db->query('SELECT district FROM land WHERE id = :id');
        $this->db->bind(':id', $land_ID);

        $row = $this->db->single();

        return $row->district;
    }

    // Get land province
    public function getLandProvince($land_ID){
        $this->db->query('SELECT province FROM land WHERE id = :id');
        $this->db->bind(':id', $land_ID);

        $row = $this->db->single();

        return $row->province;
    }

    // Get capacity of the land
    public function getCapacity($land_ID){
        $this->db->query('SELECT car, bike, threeWheel FROM land WHERE id = :id');
        $this->db->bind(':id', $land_ID);

        $row = $this->db->single();

        return $row->car + $row->bike + $row->threeWheel;
    }

    // Set land availability
    public function changeAvailability($land_ID): bool{
        // Prepare statement
        $this->db->query('UPDATE land SET availability = CASE WHEN availability = 1 THEN 0 WHEN availability = 0 THEN 1 ELSE availability END WHERE id = :id;');

        // Bind values
        $this->db->bind(':id', $land_ID);

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
        $this->db->query('UPDATE land SET secAvail = :secAvail WHERE uid = :uid and name = :name ');

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

    // Get availability
    public function getAvailability($land_ID){
        $this->db->query('SELECT availability FROM land WHERE id = :id');
        $this->db->bind(':id', $land_ID);

        $row = $this->db->single();

        return $row->availability;
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
        $this->db->query('SELECT * FROM land WHERE uid = :uid');
        $this->db->bind(':uid', $_SESSION['user_id']);

        $row = $this->db->resultSet();

        return $row;
    }

    //retrieve images from images of land
    public function getLandImages($land_ID){

        $this->db->query('SELECT image1, image2, image3, cover FROM land WHERE id = :id');
        $this->db->bind(':id', $land_ID);

        $row = $this->db->single();
        
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

    public function getReviewsAndComplaintsCount($land_ID){
        $this->db->query('SELECT COUNT(*) FROM review  WHERE revieweeID = :revieweeID');
        $this->db->bind(':revieweeID', $land_ID);

        $review_count = $this->db->single();

        $this->db->query('SELECT COUNT(*) FROM complaint  WHERE complaineeID = :complaineeID');
        $this->db->bind(':complaineeID', $land_ID);

        $complaint_count = $this->db->single();

        $total = $complaint_count->{'COUNT(*)'} + $review_count->{'COUNT(*)'};
        return $total;
    }

    public function getAvgRatingCount($land_ID){
        $this->db->query('SELECT SUM(amount) AS tot_rate FROM rate  WHERE id = :id');
        $this->db->bind(':id', $land_ID);

        $rate_amount = $this->db->single();
        $total_rate = $rate_amount->tot_rate;

        $this->db->query('SELECT COUNT(*) FROM rate  WHERE id = :id');
        $this->db->bind(':id', $land_ID);

        $land_rate_count = $this->db->single()->{'COUNT(*)'};

        if ($land_rate_count == 0){
            return $land_rate_count;
                    // die(print_r($land_rate_count));
        }else{
            $avg_rate = $total_rate/$land_rate_count;
            // Format average rate to two decimal places
            $formatted_avg_rate = number_format($avg_rate, 2);
            return $formatted_avg_rate;
        }
    }

    // Get land ID by UID and name
    public function getLandID($name){
        $this->db->query('SELECT id FROM land WHERE name = :name and uid = :uid');
        $this->db->bind(':name', $name);
        $this->db->bind(':uid', $_SESSION['user_id']);

        $row = $this->db->single();

        return $row->id;
    }

    public function getUnVerifyLandCount(){
        // Prepare statement
        $this->db->query('SELECT COUNT(*) FROM land  WHERE status = :status AND admin = 0');

        // Bind values
        $this->db->bind(':status', 0);


        $row = $this->db->single();
        return $row->{'COUNT(*)'};
    }

    public function viewUnVerifyLands(){
        // Prepare statement
        $this->db->query('SELECT l.id AS id, l.name, l.city, l.status, l.admin AS adminID, u.name AS adminName 
                        FROM land l 
                        LEFT JOIN user u ON l.admin = u.id
                        WHERE l.status = :status OR (l.status = :status AND u.id IS NULL)');

        // Bind values
        $this->db->bind(':status', 0);
        $this->db->execute();

        $row = $this->db->resultSet();
        // die(print_r($row));
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

            // Delete slots
            $this->db->query('DELETE FROM parking_slot WHERE landID = :id');

            // Bind values
            $this->db->bind(':id', $id);
            $this->db->execute();


            // Get email and name
            $this->db->query('SELECT name, email FROM user WHERE id = :id');

            // Bind values
            $this->db->bind(':id', $uid);
            $data = $this->db->single();



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
        $this->db->query('SELECT car, requestedCar, bike, requestedBike, threeWheel, requestedThreeWheel FROM land WHERE id = :id');
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
        if($data['vehicle_type'] == 'car'){
            $this->db->query('UPDATE land SET car = :capacity WHERE id = :id');
        }else if($data['vehicle_type'] == 'bike')
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

    public function acceptRequestedCapacity($data): bool
    {
        // Prepare statement
        if($data['vehicle_type'] == 'car')
            $this->db->query('UPDATE land SET car = :requestedCapacity, requestedCar = -1 WHERE id = :id');
        else if($data['vehicle_type'] == 'bike')
            $this->db->query('UPDATE land SET bike = :requestedCapacity, requestedBike = -1 WHERE id = :id');
        else if($data['vehicle_type'] == 'threeWheel')
            $this->db->query('UPDATE land SET threeWheel = :requestedCapacity, requestedThreeWheel = -1 WHERE id = :id');

        // Bind values
        $this->db->bind(':requestedCapacity', $data['requestedCapacity']);
        $this->db->bind(':id', $data['id']);


        // Execute
        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }

    public function rejectRequestedCapacity($data): bool
    {
        // Prepare statement
        if($data['vehicle_type'] == 'car'){
        // die(print_r($data));
            $this->db->query('UPDATE land SET requestedCar = -1 WHERE id = :id');
    }else if($data['vehicle_type'] == 'bike')
            $this->db->query('UPDATE land SET requestedBike = -1 WHERE id = :id');
        else if($data['vehicle_type'] == 'threeWheel')
            $this->db->query('UPDATE land SET requestedThreeWheel = -1 WHERE id = :id');

        // Bind values
        // $this->db->bind(':requestedCapacity', $data['requestedCapacity']);
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

    // Get landowner id by land id
    public function getLandownerID($landID){
        $this->db->query('SELECT uid FROM land WHERE id = :id');
        $this->db->bind(':id', $landID);

        $row = $this->db->single();

        return $row->uid;
    }

    // Assign land verification to admin
    public function assignMySelf($landID, $adminID): bool
    {
        // Prepare statement
        $this->db->query('UPDATE land SET admin = :admin WHERE id = :id');

        // Bind values
        $this->db->bind(':admin', $adminID);
        $this->db->bind(':id', $landID);

        // Execute
        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }

    // Unassigned land verification to admin
    public function unassignedMySelf($landID, $adminID): bool
    {
        // Prepare statement
        $this->db->query('UPDATE land SET admin = 0 WHERE id = :id');

        // Bind values
        $this->db->bind(':id', $landID);

        // Execute
        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }

    // Get today transactions
    public function getTodayTransactions($landID){
        $this->db->query('SELECT lt.*, v.vehicleNumber FROM land_transaction lt JOIN vehicle v ON lt.driverID = v.id AND lt.vehicleType = v.vehicleType WHERE lt.landID = :landID AND lt.transactionTime >= :transactionTime ORDER BY lt.transactionTime DESC LIMIT 8');
        $this->db->bind(':landID', $landID);
        $this->db->bind(':transactionTime', date('Y-m-d'));

        $row = $this->db->resultSet();

        return $row;
    }

    // Get total income of the parking for current month
    public function getTotalParkingIncome($landID){
        $this->db->query('SELECT SUM(cost) AS totalIncome FROM driver_land WHERE landID = :landID AND endTime >= :endTime');
        $this->db->bind(':landID', $landID);
        $this->db->bind(':endTime', date('Y-m-01'));

        $row = $this->db->single();

        return $row->totalIncome;
    }

    // Get total today transactions
    public function getTodayTotalTransactions(){
        $this->db->query('SELECT lt.*, l.name FROM land_transaction lt JOIN land l ON lt.ownerID = l.uid AND lt.landID = l.id WHERE lt.ownerID = :ownerID AND lt.transactionTime >= :transactionTime ORDER BY lt.transactionTime DESC LIMIT 8');
        $this->db->bind(':ownerID', $_SESSION['user_id']);
        $this->db->bind(':transactionTime', date('Y-m-d'));

        $row = $this->db->resultSet();

        return $row;
    }

    // Get All recent transactions from all owners
    public function getAllTodayTotalTransactions(){
        $this->db->query('SELECT lt.*, l.name FROM land_transaction lt JOIN land l ON lt.ownerID = l.uid AND lt.landID = l.id WHERE lt.transactionTime >= :transactionTime ORDER BY lt.transactionTime DESC LIMIT 8');
        $this->db->bind(':transactionTime', date('Y-m-d'));

        $row = $this->db->resultSet();

        return $row;
    }

    // Get total income of owner's all parking
    public function getTotalIncome(){
        $this->db->query('SELECT SUM(dl.cost) AS totalIncome FROM driver_land dl JOIN land l ON dl.landID = l.id WHERE l.uid = :uid AND dl.endTime >= :endTime');
        $this->db->bind(':uid', $_SESSION['user_id']);
        $this->db->bind(':endTime', date('Y-m-01'));

        $row = $this->db->single();

        return $row->totalIncome;
    }

    // Get income distribution of the land
    public function getIncomeDistribution($landID){
        $this->db->query('SELECT * FROM income WHERE landID = :landID AND year = :year AND ownerID = :ownerID');
        $this->db->bind(':landID', $landID);
        $this->db->bind(':year', date('Y'));
        $this->db->bind(':ownerID', $_SESSION['user_id']);

        $row = $this->db->single();

        return $row;
    }

    //newly added to get the total income distribution of a land owner
    public function getTotalIncomeDistribution(){
        $this->db->query('SELECT SUM(January) AS January,SUM(February) AS February,SUM(March) AS March,SUM(April) AS April,SUM(May) AS May,SUM(June) AS June,SUM(July) AS July,SUM(August) AS August,SUM(September) AS September,SUM(October) AS October,SUM(November) AS November,SUM(December) AS December FROM income WHERE ownerID = :ownerID AND year = :year');
        $this->db->bind(':ownerID', $_SESSION['user_id']);
        $this->db->bind(':year', date('Y'));

        $row = $this->db->single();

        return $row;
    }

    // Get total income distribution of all lands registered in the system
    public function getAllTotalIncomeDistribution(){
        $this->db->query('SELECT SUM(January) AS January,SUM(February) AS February,SUM(March) AS March,SUM(April) AS April,SUM(May) AS May,SUM(June) AS June,SUM(July) AS July,SUM(August) AS August,SUM(September) AS September,SUM(October) AS October,SUM(November) AS November,SUM(December) AS December FROM income WHERE year = :year');
        $this->db->bind(':year', date('Y'));

        $row = $this->db->single();

        return $row;
    }

    // Get vehicle distribution of the land
    public function getVehicleDistribution($landID){
        $this->db->query('SELECT * FROM vehicle_flow WHERE landID = :landID AND year = :year AND ownerID = :ownerID');
        $this->db->bind(':landID', $landID);
        $this->db->bind(':year', date('Y'));
        $this->db->bind(':ownerID', $_SESSION['user_id']);

        $row = $this->db->single();

        return $row;
    }

    //newly added to get the total vehicle distribution of a land owner
    public function getTotalVehicleDistribution()
    {
        $this->db->query('SELECT SUM(January) AS January,SUM(February) AS February,SUM(March) AS March,SUM(April) AS April,SUM(May) AS May,SUM(June) AS June,SUM(July) AS July,SUM(August) AS August,SUM(September) AS September,SUM(October) AS October,SUM(November) AS November,SUM(December) AS December FROM vehicle_flow WHERE ownerID = :ownerID AND year = :year');
        $this->db->bind(':ownerID', $_SESSION['user_id']);
        $this->db->bind(':year', date('Y'));

        $row = $this->db->single();

        return $row;
    }

    // Get total vehicle distribution of all lands registered in the system
    public function getAllTotalVehicleDistribution(){
        $this->db->query('SELECT SUM(January) AS January,SUM(February) AS February,SUM(March) AS March,SUM(April) AS April,SUM(May) AS May,SUM(June) AS June,SUM(July) AS July,SUM(August) AS August,SUM(September) AS September,SUM(October) AS October,SUM(November) AS November,SUM(December) AS December FROM vehicle_flow WHERE year = :year');
        $this->db->bind(':year', date('Y'));

        $row = $this->db->single();

        return $row;
    }

    public function updateRequestedCapacity($data){

        if($data['vehicle_type'] == 'car'){
            $this->db->query('UPDATE land SET requestedCar = :requestedCar WHERE id = :id');

             // Bind values
            $this->db->bind(':requestedCar', $data['requestedCapacity']);
            $this->db->bind(':id', $data['id']);

            // die(print_r($data));
        }else if($data['vehicle_type'] == 'bike'){
            $this->db->query('UPDATE land SET requestedBike = :requestedBike WHERE id = :id');
        
             // Bind values
            $this->db->bind(':requestedBike', $data['requestedCapacity']);
            $this->db->bind(':id', $data['id']);

        }else if($data['vehicle_type'] == 'threeWheel'){
            $this->db->query('UPDATE land SET requestedThreeWheel = :requestedThreeWheel WHERE id = :id');
        
             // Bind values
            $this->db->bind(':requestedThreeWheel', $data['requestedCapacity']);
            $this->db->bind(':id', $data['id']);

        }

        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }

    // Get free slots in the parking
    public function getFreeSlots($landID){
        $this->db->query('SELECT COUNT(*) AS freeSlots FROM parking_slot WHERE landID = :landID AND availability = 0 AND vehicleType = "car"');
        $this->db->bind(':landID', $landID);

        $row = $this->db->single();

        $data['car'] = $row->freeSlots;

        $this->db->query('SELECT COUNT(*) AS freeSlots FROM parking_slot WHERE landID = :landID AND availability = 0 AND vehicleType = "bike"');
        $this->db->bind(':landID', $landID);

        $row = $this->db->single();

        $data['bike'] = $row->freeSlots;

        $this->db->query('SELECT COUNT(*) AS freeSlots FROM parking_slot WHERE landID = :landID AND availability = 0 AND vehicleType = "threeWheel"');
        $this->db->bind(':landID', $landID);

        $row = $this->db->single();

        $data['threeWheel'] = $row->freeSlots;

        return $data;
    }

    public function viewComplaints($landID){
        $this->db->query('SELECT complaint.*, user.name AS complainerName 
                          FROM complaint JOIN
                          user ON complaint.complainerID = user.id
                          WHERE complaint.complaineeID = :land_id');

        $this->db->bind(':land_id', $landID);

        $result = $this->db->resultSet();

        // die(print_r($result));
        return $result;
    }

    public function viewReviews($landID){
        $this->db->query('SELECT review.*, user.name AS reviewerName 
                          FROM review JOIN
                          user ON review.reviewerID = user.id
                          WHERE review.revieweeID = :land_id');

        $this->db->bind(':land_id', $landID);

        $result = $this->db->resultSet();

        // die(print_r($result));
        return $result;
    }    
    // Ban parking
    public function banParking($land_id, $user_id)
    {
        // Get name and user email
        $this->db->query('SELECT name, email FROM user WHERE id = :id');

        // Bind values
        $this->db->bind(':id', $user_id);
        $data = $this->db->single();
        $name = $data->name;
        $email = $data->email;


        // get land name using land ID
        $this->db->query('SELECT name FROM land WHERE id = :id');
        $this->db->bind(':id', $land_id);
        $land = $this->db->single();
        $landName = $land->name;


        //Content
        $this->mail->Body = '<div id="overview" style="margin: auto; width: 80%; font-size: 13px">
            <p style="color: black">
                Dear ' . $name . ',<br><br>
        
                We regret to inform you that your land '.$landName.' with eZpark has been banned. This action has been taken due to a violation of our terms of service or community guidelines.
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

        $this->db->query('UPDATE land SET status = 2 WHERE id = :id');
        $this->db->bind(':id', $land_id);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function viewAllLandsByUserID(){
        $this->db->query('SELECT id, name FROM land WHERE uid = :uid');
        $this->db->bind(':uid', $_SESSION['user_id']);

        $row = $this->db->resultSet();

        return $row;
    }

    // Get land id using request id
    public function getLandIDByRequestID($mergeID){
        $this->db->query('SELECT baseLandID FROM parking_merge WHERE mergeID = :mergeID');
        $this->db->bind(':mergeID', $mergeID);

        $row = $this->db->single();

        return $row->baseLandID;
    }

    // get ownerId using landID
    public function getOwnerID($landID){
        $this->db->query('SELECT uid FROM land WHERE id = :id');
        $this->db->bind(':id', $landID);

        $row = $this->db->single();

        return $row->uid;
    }
}