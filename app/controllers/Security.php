<?php
class Security extends Controller {
    public function __construct(){
        $this->pagesModel = $this->model('SecurityModel');
    }

    public function index(){
        $data = [
            'title' => 'Home page'
        ];
        $this->view('security/index', $data);
    }

    public function about(){
        $users = $this->pagesModel->getUser();
        $data = [
            'users' => $users
        ];
        $this->view('about', $data);
    }
}