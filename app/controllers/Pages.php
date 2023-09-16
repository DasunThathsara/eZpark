<?php
    class Pages extends Controller {
        public function __construct(){
        }

        public function index(){
        }

        public function about($name){
            $data = [
                'username' => $name
            ];
            $this->view('v_about', $data);
        }
    }