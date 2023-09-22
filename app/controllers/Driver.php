<?php
class Driver extends Controller {
    public function __construct(){
        $this->pagesModel = $this->model('DriverModel');
    }

    public function index(){
        $data = [
            'title' => 'Home page'
        ];
        $this->view('driver/index', $data);
    }

    public function about(){
        $users = $this->pagesModel->getUser();
        $data = [
            'users' => $users
        ];
        $this->view('about', $data);
    }
}