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
        $this->db->query('SELECT * FROM security_land_request WHERE sid = :sid;');

        // Bind values
        $this->db->bind(':sid', $_SESSION['user_id']);

        $row = $this->db->resultSet();

        return $row;
    }

    public function acceptLandRequest($id): bool
    {
        // Get the landowner's id
        $this->db->query('SELECT * FROM land  WHERE id = :id');

        // Bind values
        $this->db->bind(':id', $id);
        $row = $this->db->single();

        $uid = $row->uid;
        $parking_name = $row->name;
        $deed = $row->deed;

        // Prepare statement
        $this->db->query('UPDATE land SET status = :status WHERE id = :id');

        // Bind values
        $this->db->bind(':status', 1);
        $this->db->bind(':id', $id);

        // Execute
        if ($this->db->execute()){
            // Get email and name
            $this->db->query('SELECT name, email FROM user WHERE id = :id');

            // Bind values
            $this->db->bind(':id', $uid);
            $data = $this->db->single();

//            die(print_r($data));

            $name = $data->name;
            $email = $data->email;

            $message = '<div id="overview" style="margin: auto; width: 80%; font-size: 13px">
            <p style="color: black">
                Dear '.$name.',<br><br>
        
                Your now allocated to the '.$parking_name.' as a security.They will inform about them. <br>
                <br>
                Best regards,<br>
                eZpark Team
            </p>
        </div>';

            $this->sendEmail($email, $name, 'Your now allocated to the land.', $message);

            return true;
        }
        else {
            return false;
        }
    }
}