<?php
class ParkingOwner extends Controller {
    public function __construct(){
        $this->pagesModel = $this->model('ParkingOwnerModel');
    }

    public function index(){
        $data = [
            'title' => 'Home page'
        ];
        $this->view('parkingOwner/index', $data);
    }

    public function about(){
        $users = $this->pagesModel->getUser();
        $data = [
            'users' => $users
        ];
        $this->view('about', $data);
    }
}