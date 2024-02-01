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

    // View security profile
    public function viewSecurityProfile($data){
        $this->db->query('SELECT u.*, s.* FROM user u JOIN security s ON u.id = s.id WHERE u.id = :id;');

        // Bind values
        $this->db->bind(':id', $data['id']);

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

    // View land requests
    public function viewLandRequest(){
        $this->db->query('SELECT slr.lid, slr.sid, l.name, l.district, l.province
        FROM security_land_request AS slr
        JOIN land AS l ON slr.lid = l.id
        WHERE slr.sid = :sid;
        ');

        // Bind values
        $this->db->bind(':sid', $_SESSION['user_id']);

        $row = $this->db->resultSet();
        // die(print_r($row));

        return $row;
    }

    // Accept land request
    public function acceptLandRequest($id): bool
    {
        // Prepare statement
        $this->db->query('UPDATE security SET landID = :landID WHERE id = :id');

        // Bind values
        $this->db->bind(':landID', $id);
        $this->db->bind(':id', $_SESSION['user_id']);

        // Execute
        if ($this->db->execute()){
            return true;
        }
        else {
            return false;
        }
    }

    // Decline land request
    public function declineLandRequest($id): bool
    {
        // Prepare statement for delete land request
        $this->db->query('DELETE FROM security_land_request WHERE lid = :lid AND sid = :sid');

        // Bind values
        $this->db->bind(':lid', $id);
        $this->db->bind(':sid', $_SESSION['user_id']);
       
        $result1 = $this->db->execute();
        // die(print_r($result1));  

        // Prepare statement for delete notification
        $this->db->query('DELETE FROM notification WHERE senderID = :senderID AND receiverID = :receiverID');

        // Bind values
        $this->db->bind(':senderID', $id);
        $this->db->bind(':receiverID', $_SESSION['user_id']);

        $result2 = $this->db->execute();
        // die(print_r($_SESSION['user_id']));

        // $this->db->query('DELETE FROM notification WHERE notification.id = :notification.id');

        // $this->db->bind(':notification.id', $nid);
        // die(print_r($nid));

        // Execute
        if ($result1 && $result2){
            return true;
        }
        else {
            return false;
        }
    }

    // Get assigned land id
    public function getAssignedLandID(){
        // Prepare statement
        $this->db->query('SELECT landID FROM security WHERE id = :id');

        // Bind values
        $this->db->bind(':id', $_SESSION['user_id']);

        $row = $this->db->single();
        return $row->landID;
    }
}