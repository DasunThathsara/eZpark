<?php
class SecurityModel{
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function getSecurityCount($landID){
        // Prepare statement
        $this->db->query('SELECT COUNT(*) FROM security  WHERE landID = :landID');

        // Bind values
        $this->db->bind(':landID', $landID);


        $row = $this->db->single();
        return $row->{'COUNT(*)'};
    }

    public function viewSecurities($landID){
        $this->db->query('SELECT * FROM user u JOIN security s ON u.id = s.id WHERE s.landID = :landID;');

        // Bind values
        $this->db->bind(':landID', $landID);

        $row = $this->db->resultSet();

        return $row;
    }
}