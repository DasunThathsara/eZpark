<?php
class MerchandiserModel{
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    // public function getUser(){
    //     $this->db->query('SELECT * FROM users');

    //     return $this->db->resultSet();
    // }


// ------------------------- Parking Functionalities -------------------------
    // Register parking
    public function registerParking($data): bool
    {
        // Prepare statement
        $this->db->query('INSERT INTO parking (name, city, id) VALUES (:name, :city, :id)');

        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':city', $data['city']);
        $this->db->bind(':id', $_SESSION['user_id']);

        // Execute
        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }

    // Find parking
    public function findParkingByName($name): bool
    {
        $this->db->query('SELECT * FROM parking WHERE name = :name and id = :id');
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

    public function viewParkings(){
        $this->db->query('SELECT * FROM parking WHERE id = :id');
        $this->db->bind(':id', $_SESSION['user_id']);

        $row = $this->db->resultSet();

        return $row;
    }

    // Romove parking
    public function removeParking($data): bool
    {
        // Prepare statement
        $this->db->query('DELETE FROM parking WHERE name = :name AND id = :id');

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

    // Update parking
    public function updateParking($data): bool
    {
        // Prepare statement
        $this->db->query('UPDATE parking SET name = :name city = :city WHERE id = :id and name = :old_name ');

        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':old_name', $data['old_name']);
        $this->db->bind(':city', $data['city']);
        $this->db->bind(':old_city', $data['old_city']);
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



