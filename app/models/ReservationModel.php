<?php
class ReservationModel{
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function viewReservations($landID, $date, $vehicleType){
        $this->db->query('SELECT b.* FROM booking b JOIN vehicle v ON v.vehicleNumber = b.vehicleNumber WHERE landID = :landID AND v.vehicleType = :vehicleType AND DATE(startTime) = :reservationDate');
        $this->db->bind(':landID', $landID);
        $this->db->bind(':reservationDate', $date);
        $this->db->bind(':vehicleType', $vehicleType);

        $reservations = $this->db->resultSet();

        return $reservations;
    }

    public function makeReservation($data){
        $this->db->query('INSERT INTO booking (landID, driverID, vehicleNumber, startTime, expectedEndTime) VALUES (:landID, :driverID, :vehicleNumber, :startTime, :expectedEndTime)');
        $this->db->bind(':landID', $data['landID']);
        $this->db->bind(':driverID', $_SESSION['user_id']);
        $this->db->bind(':vehicleNumber', $data['vehicleNumber']);
        $this->db->bind(':startTime', $data['startDate'].' '.$data['startTime']);
        $this->db->bind(':expectedEndTime', $data['endDate'].' '.$data['endTime']);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }
}