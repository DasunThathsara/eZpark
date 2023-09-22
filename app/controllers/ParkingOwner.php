<?php
class ParkingOwner extends Controller {
    public function __construct(){
        $this->middleware = new AuthMiddleware();
        // Only parkingOwner personnel are allowed to access parkingOwner pages
        $this->middleware->checkAccess(['parkingOwner']);
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