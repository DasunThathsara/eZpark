<?php
class ParkingOwnerModel{
    private $db;

    public function __construct(){
        $this->db = new Database();
    }


    // ------------------------- package Functionalities -------------------------
    // Register package
    public function registerPackage($data): bool
    {
        // Prepare statement
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
        $this->db->query('UPDATE package SET name = :name, price=:price, packageType =:packageType WHERE pid = :pid and name = :oldName and packageType = :oldPackageType');

        // Bind values
        $this->db->bind(':oldPackageType', $data['old_vehicle_type']);
        $this->db->bind(':packageType', $data['vehicle_type']);
        $this->db->bind(':price', $data['package_price']);
        $this->db->bind(':oldName', $data['old_package_type']);
        $this->db->bind(':name', $data['package_type']);
        $this->db->bind(':pid', $data['id']);


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

}