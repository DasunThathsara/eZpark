<?php
    class Pages extends Controller {
        public function __construct(){
            $this->pagesModel = $this->model('M_pages');
        }

        public function index(){
        }

        public function about(){
            $users = $this->pagesModel->getUser();
            $data = [
                'users' => $users
            ];
            $this->view('v_about', $data);
        }
    }