<?php
class Admin extends Controller {
    public function __construct(){
        $this->middleware = new AuthMiddleware();
        // Only admin are allowed to access parkingOwner pages
        $this->middleware->checkAccess(['admin']);
        $this->adminModel = $this->model('AdminModel');
    }

    public function index(){
        $data = [
            'title' => 'Admin Dashboard'
        ];
        $this->view('admin/index', $data);
    }
}