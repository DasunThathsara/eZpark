<?php
class SecurityModel{
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function getUser(){
        $this->db->query('SELECT * FROM users');

        return $this->db->resultSet();
    }
}