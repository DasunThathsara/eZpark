<?php
    class PageModel{
        private $db;

        public function __construct(){
            $this->db = new Database();
        }

        public function getUser(){
            $this->db->query('SELECT * FROM user');

            return $this->db->resultSet();
        }
    }