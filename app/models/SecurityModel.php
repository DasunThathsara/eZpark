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
    public function viewSecurities($id){
        $this->db->query('SELECT * FROM security WHERE id = :id;');

        // Bind values
        $this->db->bind(':id', $id);

        $row = $this->db->resultSet();

        return $row;
    }

    // View all securities
    public function viewAvailableSecurities (){
//        $this->db->query('SELECT * FROM security_land_request slr LEFT JOIN security s ON slr.sid = s.id WHERE s.landID = 0;');
//        $this->db->query('SELECT * FROM security_land_request slr JOIN security s ON slr.sid = s.id WHERE s.landID = 0;');
        $this->db->query('SELECT u.name,s.* FROM user u JOIN security s ON u.id = s.id WHERE s.landID = 0;');
//        $this->db->query('SELECT u.name, s.*, COALESCE(slr.lid, 0) AS lid FROM user u JOIN security s ON u.id = s.id LEFT JOIN security_land_request slr ON s.id = slr.sid WHERE s.landID = 0;');

        $row = $this->db->resultSet();
//        die(print_r($row));
        return $row;
    }

    // Send request for security
    public function sendRequest($landID, $securityID){
        $this->db->query('INSERT INTO  security_land_request (lid, sid) VALUES (:landID, :securityID);');

        // Bind values
        $this->db->bind(':landID', $landID);
        $this->db->bind(':securityID', $securityID);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Cancel request for security
    public function cancelRequest($landID, $securityID){
        $this->db->query('DELETE FROM security_land_request WHERE lid = :landID AND sid = :securityID;');

        // Bind values
        $this->db->bind(':landID', $landID);
        $this->db->bind(':securityID', $securityID);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Get land request count
    public function getLandRequestCount(){
        // Prepare statement
        $this->db->query('SELECT COUNT(*) FROM security_land_request WHERE sid = :sid');

        // Bind values
        $this->db->bind(':sid', $_SESSION['user_id']);

        $row = $this->db->single();
        return $row->{'COUNT(*)'};
    }

    // Get security pending list
    public function getSecurityPendingList($LandID){
        // Prepare statement
        $this->db->query('SELECT * FROM security_land_request WHERE lid = :lid');

        // Bind values
        $this->db->bind(':lid', $LandID);

        $row = $this->db->resultSet();
        return $row;
    }
}