<?php
class Chat extends Controller {
    public function __construct(){
        $this->middleware = new AuthMiddleware();
        $this->UserModel = $this->model('UserModel');
        // Only parkingOwner are allowed to access driver pages
        // $this->middleware->checkAccess(['parkingOwner']);
        // $this->parkingOwnerModel = $this->model('parkingOwnerModel');
    }

    public function viewChat(){
        $data = [
            'title' => 'Home page',
            'data' => $this->UserModel->viewUsersById(),
        ];
        $this->view('chat/chat', $data);
    }

    // public function viewMsg(){
    //     $data = [
    //         'title' => 'Home page',
    //         'data' => $this->UserModel->viewUsersById(),
    //     ];
    //     $this->view('chat/msg', $data);
    // }
}