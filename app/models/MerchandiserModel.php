<?php
class MerchandiserModel{
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

// // ------------------------- land Functionalities -------------------------
//     // Register land
//     public function registerLand($data): bool
//     {
//         // Prepare statement
//         $this->db->query('INSERT INTO land (name, city, street, deed, car, bike, threeWheel, contactNo, uid) VALUES (:name, :city, :street, :deed, :car, :bike, :threeWheel, :contactNo, :uid)');

//         // Bind values
//         $this->db->bind(':name', $data['name']);
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

//     public function updateSecurityOfficerAvail($data): bool{
//         // die(print_r($data));
//         // Prepare statement
//         $this->db->query('UPDATE land SET secAvail = :secAvail  WHERE uid = :uid and name = :name ');

//         // Bind values
//         $this->db->bind(':name', $data['name']);
//         $this->db->bind(':secAvail', $data['secAvail']);
//         $this->db->bind(':uid', $_SESSION['user_id']);

//         // Execute
//         if ($this->db->execute()){
//             return true;
//         }
//         else {
//             return false;
//         }
//     }

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
}

  