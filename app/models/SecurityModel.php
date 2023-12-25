<?php
class SecurityModel{
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    // Get security count of the land
    public function getSecurityCount($landID){
        // Prepare statement
        $this->db->query('SELECT COUNT(*) FROM security  WHERE landID = :landID');

        // Bind values
        $this->db->bind(':landID', $landID);


        $row = $this->db->single();
        return $row->{'COUNT(*)'};
    }

    // View securities of the land
    public function viewSecurities($landID){
        $this->db->query('SELECT * FROM user u JOIN security s ON u.id = s.id WHERE s.landID = :landID;');

        // Bind values
        $this->db->bind(':landID', $landID);

        $row = $this->db->resultSet();

        return $row;
    }

    // View all securities
    public function viewAvailableSecurities (){
        $this->db->query('SELECT * FROM user u JOIN security s ON u.id = s.id WHERE landID = 0;');

        $row = $this->db->resultSet();

        return $row;
    }
}