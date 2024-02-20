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

    // View vehicles
    public function viewVehicles(){
        $this->db->query('SELECT * FROM vehicle WHERE id = :id');
        $this->db->bind(':id', $_SESSION['user_id']);

        $row = $this->db->resultSet();

        return $row;
    }

    // Remove vehicle
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

    // Update vehicle details
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

    // ------------------------- Parking Functionalities -------------------------
    // Check parking status
    public function checkParkingStatus($landID){
        $this->db->query('SELECT * FROM driver_land WHERE landID = :landID and driverID = :driverID and status = 1');
        $this->db->bind(':landID', $landID);
        $this->db->bind(':driverID', $_SESSION['user_id']);

        $row = $this->db->single();

        if ($this->db->rowCount() == 0)
            return 0;

        return $row->status;
    }

    // Enter parking
    public function enterParking($land_ID, $vehicle_type){
        $this->db->query('INSERT INTO driver_land (landID, driverID, status, vehicleType, startTime) VALUES (:landID, :driverID, :status, :vehivleType, :startTime)');
        $this->db->bind(':landID', $land_ID);
        $this->db->bind(':driverID', $_SESSION['user_id']);
        $this->db->bind(':status', 1);
        $this->db->bind(':vehivleType', $vehicle_type);
        $this->db->bind(':startTime', date("Y-m-d H:i:s"));

        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }

    // Exit parking
    public function exitParking($data){
        $this->db->query('UPDATE driver_land SET endTime = :endTime WHERE landID = :landID and driverID = :driverID');
        $this->db->bind(':landID', $data['id']);
        $this->db->bind(':driverID', $_SESSION['user_id']);
        $this->db->bind(':endTime', date("Y-m-d H:i:s"));

        if ($this->db->execute() && $this->updateCost($data)){
            return true;
        }
        else {
            return false;
        }
    }

    // Update cost
    public function updateCost($data){
        // get the start time, end time and type of the vehicle
        $this->db->query('SELECT * FROM driver_land WHERE landID = :landID AND driverID = :driverID AND status = 1');
        $this->db->bind(':landID', $data['id']);
        $this->db->bind(':driverID', $_SESSION['user_id']);
        $row = $this->db->single();

        $start_time = $row->startTime;
        $end_time = $row->endTime;
        $type = $row->vehicleType;

        // Convert the start time and end time to DateTime objects
        $datetime1 = new DateTime($start_time);
        $datetime2 = new DateTime($end_time);

        // Get the difference between the two DateTime objects
        $interval = $datetime1->diff($datetime2);

        // Get the total minutes
        $total_minutes = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;

        // Get the slot price of the given vehicle type
        $this->db->query('SELECT * FROM land WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $row = $this->db->single();

        // Calculate the slot price according to the vehicle type
        if($type == 'car'){
            $slot_price = $row->car;
        }
        else if($type == 'bike'){
            $slot_price = $row->bike;
        }
        else if($type == 'threeWheel'){
            $slot_price = $row->threeWheel;
        }

        // Calculate the cost
        if($total_minutes % 60 == 0 OR $total_minutes % 60 < 10){
            $cost = intval($total_minutes / 60) * $slot_price;
        }
        else if($total_minutes % 60 < 30){
            $cost = intval($total_minutes / 60) * $slot_price +  0.5 * $slot_price;
        }
        else{
            $cost = intval($total_minutes / 60) * $slot_price + $slot_price;
        }

        // Update the cost and status of the transaction
        $this->db->query('UPDATE driver_land SET status = 0, cost = :cost WHERE landID = :landID AND driverID = :driverID AND status = 1;');
        $this->db->bind(':landID', $data['id']);
        $this->db->bind(':driverID', $_SESSION['user_id']);
        $this->db->bind(':cost', $cost);

        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }
}