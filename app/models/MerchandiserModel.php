<?php
class MerchandiserModel{
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

// ------------------------- land Functionalities -------------------------
    // Register land
    public function registerLand($data): bool
    {
        // Prepare statement
        $this->db->query('INSERT INTO land (name, city, street, deed, car, bike, threeWheel, contactNo, id) VALUES (:name, :city, :deed, :car, :bike, :threeWheel, :street, :contactNo, :id)');

        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':city', $data['city']);
        $this->db->bind(':street', $data['street']);
        $this->db->bind(':deed', $data['deed']);
        $this->db->bind(':car', $data['car']);
        $this->db->bind(':bike', $data['bike']);
        $this->db->bind(':threeWheel', $data['threeWheel']);
        $this->db->bind(':contactNo', $data['contactNo']);
        $this->db->bind(':id', $_SESSION['user_id']);

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
        $this->db->query('SELECT * FROM land WHERE name = :name and id = :id');
        $this->db->bind(':name', $name);
        $this->db->bind(':id', $_SESSION['user_id']);

        $row = $this->db->single();

        // Check row
        if ($this->db->rowCount() > 0){
            return true;
        } else {
            return false;
        }
    }

    public function viewLands(){
        $this->db->query('SELECT * FROM land WHERE id = :id');
        $this->db->bind(':id', $_SESSION['user_id']);

        $row = $this->db->resultSet();

        return $row;
    }

    // Romove land
    public function removeLand($data): bool
    {
        // Prepare statement
        $this->db->query('DELETE FROM land WHERE name = :name AND id = :id');

        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':id', $_SESSION['user_id']);
        print_r($data['name']);
        print_r($_SESSION['user_id']);
        // Execute
        if ($this->db->execute()){
            print_r("check 4");
            return true;
        }
        else {
            print_r("check 5");
            return false;
        }
    }

    // Update land
    public function updateLand($data): bool
    {
        // Prepare statement
        $this->db->query('UPDATE land SET name = :name, city = :city, street = :street, deed = :deed, car = :car, bike = :bike, threeWheel = :threeWheel, contactNo = :contactNo  WHERE id = :id and name = :old_name ');

        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':old_name', $data['old_name']);
        $this->db->bind(':city', $data['city']);
        $this->db->bind(':old_city', $data['old_city']);
        $this->db->bind(':street', $data['street']);
        $this->db->bind(':old_street', $data['old_street']);
        $this->db->bind(':deed', $data['deed']);
        $this->db->bind(':old_deed', $data['old_deed']);
        $this->db->bind(':car', $data['car']);
        $this->db->bind(':old_car', $data['old_car']);
        $this->db->bind(':bike', $data['bike']);
        $this->db->bind(':old_bike', $data['old_bike']);
        $this->db->bind(':threeWheel', $data['threeWheel']);
        $this->db->bind(':old_threeWheel', $data['old_threeWheel']);
        $this->db->bind(':contactNo', $data['contactNo']);
        $this->db->bind(':old_contactNo', $data['old_contactNo']);
        $this->db->bind(':id', $_SESSION['user_id']);


        print_r($data);
        // Execute
        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }
}



