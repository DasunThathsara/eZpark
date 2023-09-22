<?php
    class Pages extends Controller {
        public function __construct(){
            $this->pagesModel = $this->model('PageModel');
        }

        public function index(){
            $data = [
                'title' => 'Home page'
            ];
            $this->view('pages/index', $data);
        }

        public function about(){
            $users = $this->pagesModel->getUser();
            $data = [
                'users' => $users
            ];
            $this->view('about', $data);
        }
    }