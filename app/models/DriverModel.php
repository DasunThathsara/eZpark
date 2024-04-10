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
        $this->db->query('INSERT INTO vehicle (name, vehicleType, id, vehicleNumber) VALUES (:name, :vehicleType, :id, :vehicleNumber)');

        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':vehicleType', $data['vehicle_type']);
        $this->db->bind(':id', $_SESSION['user_id']);
        $this->db->bind(':vehicleNumber', $data['vehicle_number']);

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

    // Find vehicle
    public function findVehicleByNumber($number): bool
    {
        $this->db->query('SELECT * FROM vehicle WHERE vehicleNumber = :vehicleNumber');
        $this->db->bind(':vehicleNumber', $number);

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
    // Update income table
    public function updateIncome($landID, $charge, $ownerID){
        // first check whether the record is already exist. If it was exist, update the record. If not, insert a new record
        $this->db->query('SELECT * FROM income WHERE landID = :landID AND ownerID = :ownerID AND year = :year');
        $this->db->bind(':landID', $landID);
        $this->db->bind(':ownerID', $ownerID);
        $this->db->bind(':year', date("Y"));

        $row = $this->db->single();

        $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

        if ($this->db->rowCount() > 0){
            // update the record
            $this->db->query('UPDATE income SET January = January + :January, February = February + :February, March = March + :March, April = April + :April, May = May + :May, June = June + :June, July = July + :July, August = August + :August, September = September + :September, October = October + :October, November = November + :November, December = December + :December WHERE landID = :landID and ownerID = :ownerID and year = :year');
            $this->db->bind(':landID', $landID);
            $this->db->bind(':ownerID', $ownerID);
            $this->db->bind(':year', date("Y"));

            // update each month with considering current month
            for ($i = 1; $i <= 12; $i++){
                if ($i == date("m")){
                    $this->db->bind(':'.$months[$i - 1], $charge);
                }
                else {
                    $this->db->bind(':'.$months[$i - 1], 0);
                }
            }

            if ($this->db->execute()){
                return true;
            }
            else {
                return false;
            }
        }
        else {
            // insert a new record
            $this->db->query('INSERT INTO income (ownerID, landID, year, January, February, March, April, May, June, July, August, September, October, November, December) VALUES (:ownerID, :landID, :year, :January, :February, :March, :April, :May, :June, :July, :August, :September, :October, :November, :December)');
            $this->db->bind(':landID', $landID);
            $this->db->bind(':ownerID', $ownerID);
            $this->db->bind(':year', date("Y"));

            // update each month with considering current month
            for ($i = 1; $i <= 12; $i++){
                if ($i == date("m")){
                    $this->db->bind(':'.$months[$i - 1], $charge);
                }
                else {
                    $this->db->bind(':'.$months[$i - 1], 0);
                }
            }

            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }

    // Update vehicle flow table
    public function updateVehicleCount($landID, $ownerID){
        // first check whether the record is already exist. If it was exist, update the record. If not, insert a new record
        $this->db->query('SELECT * FROM vehicle_flow WHERE landID = :landID AND ownerID = :ownerID AND year = :year');
        $this->db->bind(':landID', $landID);
        $this->db->bind(':ownerID', $ownerID);
        $this->db->bind(':year', date("Y"));

        $row = $this->db->single();

        $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

        if ($this->db->rowCount() > 0){
            // update the record
            $this->db->query('UPDATE vehicle_flow SET January = January + :January, February = February + :February, March = March + :March, April = April + :April, May = May + :May, June = June + :June, July = July + :July, August = August + :August, September = September + :September, October = October + :October, November = November + :November, December = December + :December WHERE landID = :landID and ownerID = :ownerID and year = :year');
            $this->db->bind(':landID', $landID);
            $this->db->bind(':ownerID', $ownerID);
            $this->db->bind(':year', date("Y"));

            // update each month with considering current month
            for ($i = 1; $i <= 12; $i++){
                if ($i == date("m")){
                    $this->db->bind(':'.$months[$i - 1], 1);
                }
                else {
                    $this->db->bind(':'.$months[$i - 1], 0);
                }
            }

            if ($this->db->execute()){
                return true;
            }
            else {
                return false;
            }
        }
        else {
            // insert a new record
            $this->db->query('INSERT INTO vehicle_flow (ownerID, landID, year, January, February, March, April, May, June, July, August, September, October, November, December) VALUES (:ownerID, :landID, :year, :January, :February, :March, :April, :May, :June, :July, :August, :September, :October, :November, :December)');
            $this->db->bind(':landID', $landID);
            $this->db->bind(':ownerID', $ownerID);
            $this->db->bind(':year', date("Y"));

            // update each month with considering current month
            for ($i = 1; $i <= 12; $i++){
                if ($i == date("m")){
                    $this->db->bind(':'.$months[$i - 1], 1);
                }
                else {
                    $this->db->bind(':'.$months[$i - 1], 0);
                }
            }

            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }

    // Get landowner id by land id
    public function getLandownerID($landID){
        $this->db->query('SELECT uid FROM land WHERE id = :id');
        $this->db->bind(':id', $landID);

        $row = $this->db->single();

        return $row->uid;
    }

    // Get vehicleType using landID driverID and status
    public function getVehicleType($landID){
        $this->db->query('SELECT vehicleType FROM driver_land WHERE landID = :landID and driverID = :driverID and status = 1');
        $this->db->bind(':landID', $landID);
        $this->db->bind(':driverID', $_SESSION['user_id']);

        $row = $this->db->single();

        return $row->vehicleType;
    }

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
        // Update driver_land table
        $this->db->query('INSERT INTO driver_land (landID, driverID, status, vehicleType, startTime) VALUES (:landID, :driverID, :status, :vehicleType, :startTime)');
        $this->db->bind(':landID', $land_ID);
        $this->db->bind(':driverID', $_SESSION['user_id']);
        $this->db->bind(':status', 1);
        $this->db->bind(':vehicleType', $vehicle_type);

        // End time
        $startTime = date("Y-m-d H:i:s");
        $this->db->bind(':startTime', $startTime);

        $result1 = $this->db->execute();

        // Update land_transaction table
        $ownerID = $this->getLandOwnerID($land_ID);
        $this->db->query('INSERT INTO land_transaction (ownerID, landID, driverID, status, vehicleType, transactionTime) VALUES (:ownerID, :landID, :driverID, :status, :vehicleType, :transactionTime)');
        $this->db->bind(':ownerID', $ownerID);
        $this->db->bind(':landID', $land_ID);
        $this->db->bind(':driverID', $_SESSION['user_id']);
        $this->db->bind(':status', 1);
        $this->db->bind(':vehicleType', $vehicle_type);
        $this->db->bind(':transactionTime', $startTime);

        $result2 = $this->db->execute();

        if ($result1 && $result2){
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

        // End time
        $startTime = date("Y-m-d H:i:s");
        $this->db->bind(':endTime', $startTime);

        $result1 = $this->db->execute();

        // Update land_transaction table
        $ownerID = $this->getLandOwnerID($data['id']);
        $vehicleType = $this->getVehicleType($data['id']);
        $this->db->query('INSERT INTO land_transaction (ownerID, landID, driverID, status, vehicleType, transactionTime) VALUES (:ownerID, :landID, :driverID, :status, :vehicleType, :transactionTime)');
        $this->db->bind(':ownerID', $ownerID);
        $this->db->bind(':landID', $data['id']);
        $this->db->bind(':driverID', $_SESSION['user_id']);
        $this->db->bind(':status', 0);
        $this->db->bind(':vehicleType', $vehicleType);
        $this->db->bind(':transactionTime', $startTime);

        $result2 = $this->db->execute();

        if ($result1 && $result2 && $this->updateCost($data, $ownerID)){
            return true;
        }
        else {
            return false;
        }
    }

    // Update cost
    public function updateCost($data, $ownerID){
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

        if ($this->db->execute() && $this->updateIncome($data['id'], $cost, $ownerID) && $this->updateVehicleCount($data['id'], $ownerID)){
            return true;
        }
        else {
            return false;
        }
    }

    // Subscribe package
    public function subscribePackage($data){
        // Prepare statement
        $this->db->query('INSERT INTO driver_package (landID, driverID, vehicleType, packageType, status, subscribeDate) VALUES (:landID, :driverID, :vehicleType, :packageType, :status, :subscribeDate)');

        // Bind values
        $this->db->bind(':landID', $data['landID']);
        $this->db->bind(':driverID', $_SESSION['user_id']);
        $this->db->bind(':vehicleType', $data['vehicle-type']);
        $this->db->bind(':packageType', $data['package-type']);
        $this->db->bind(':status', 1);
        $this->db->bind(':subscribeDate', date("Y-m-d"));

        // Execute
        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }

    // View packages
    public function viewPackages($data){
        $this->db->query('SELECT p.*, dp.status FROM package p LEFT JOIN driver_package dp ON p.pid = dp.landID AND p.name = dp.packageType AND dp.driverID = :driverID WHERE pid = :pid');
        $this->db->bind(':pid', $data['id']);
        $this->db->bind(':driverID', $_SESSION['user_id']);

        $row = $this->db->resultSet();

        return $row;
    }

    // View subscribed packages
    public function viewSubscribedPackages(){
        $this->db->query('SELECT dp.*, l.name, l.city FROM driver_package dp JOIN land l ON l.id = dp.landID WHERE driverID = :driverID');
        $this->db->bind(':driverID', $_SESSION['user_id']);

        $row = $this->db->resultSet();

        return $row;
    }

    // View parking history
    public function viewHistory(){
        $this->db->query('SELECT dl.*, l.name, l.city FROM driver_land dl JOIN land l ON l.id = dl.landID WHERE driverID = :driverID ORDER BY startTime DESC');
        $this->db->bind(':driverID', $_SESSION['user_id']);

        $row = $this->db->resultSet();

        return $row;
    }
}