<?php
class Security extends Controller {
    public function __construct(){
        $this->middleware = new AuthMiddleware();
        // Only security personnel are allowed to access security pages
        $this->middleware->checkAccess(['security']);
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