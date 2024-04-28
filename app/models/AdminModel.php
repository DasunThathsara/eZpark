<?php
class AdminModel{
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    // View Complaints
    public function viewComplaints(){
        $this->db->query('SELECT * FROM complaint');
        $results = $this->db->resultSet();

        foreach ($results as $result){
            $this->db->query('SELECT * FROM user WHERE id = :id');
            $this->db->bind(':id', $result->complainerID);
            $complainer = $this->db->single();
            $result->complainerName = $complainer->name;

            $this->db->query('SELECT * FROM land WHERE id = :id');
            $this->db->bind(':id', $result->complaineeID);
            $complainee = $this->db->single();
            $result->complaineeName = $complainee->name;
        }
        return $results;
    }
}