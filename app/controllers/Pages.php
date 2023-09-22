<?php
    class Pages extends Controller {
        public function __construct(){
            $this->pagesModel = $this->model('Pages');
        }

        public function index(){
        }

        public function about(){
            $users = $this->pagesModel->getUser();
            $data = [
                'users' => $users
            ];
            $this->view('about', $data);
        }
    }