<?php
class DriverModel{
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    // ------------------------- Vehicle Functionalities -------------------------
    // Register vehicle
    public function registerVehicle($data): bool
    {
        // Prepare statement
        $this->db->query('INSERT INTO vehicle (name, vehicleType, id) VALUES (:name, :vehicleType, :id)');

        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':vehicleType', $data['vehicle_type']);
        $this->db->bind(':id', $_SESSION['user_id']);

        // Execute
        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }

    // Find vehicle
    public function findVehicleByName($name): bool
    {
        $this->db->query('SELECT * FROM vehicle WHERE name = :name and id = :id');
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

    public function viewVehicles(){
        $this->db->query('SELECT * FROM vehicle WHERE id = :id');
        $this->db->bind(':id', $_SESSION['user_id']);

        $row = $this->db->resultSet();

        return $row;
    }

    public function removeVehicle($data): bool
    {
        // Prepare statement
        $this->db->query('DELETE FROM vehicle WHERE name = :name AND id = :id');

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

    public function updateVehicle($data): bool
    {
        // Prepare statement
        $this->db->query('UPDATE vehicle SET name = :name, vehicleType = :vehicleType WHERE id = :id and name = :old_name');

        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':old_name', $data['old_name']);
        $this->db->bind(':vehicleType', $data['vehicle_type']);
        $this->db->bind(':id', $_SESSION['user_id']);


        // Execute
        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }
}