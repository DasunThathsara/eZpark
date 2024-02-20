<?php
class Chat extends Controller {
    public function __construct(){
        $this->middleware = new AuthMiddleware();
        $this->UserModel = $this->model('UserModel');
        $this->ChatModel = $this->model('ChatModel');
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

    public function loadUsers(){
       $data = [
            'title' => 'Home page',
            'data' => $this->UserModel->viewUsersById(),
        ];
        // $this->view('chat/chat', $data);
        echo json_encode($data);
    }

    public function viewMsg(){
        $data = [
            'title' => 'Home page',
            'data' => $this->UserModel->viewUsersById(),
        ];
        $this->view('chat/msg', $data);
    }

    public function insertMsg(){
        $data = [
            'title' => 'Home page',
            'data' => $this->ChatModel->insertChat(),
        ];
        echo json_encode($data);
    }

    public function getMsg(){
        $data = [
            'title' => 'Home page',
            'data' => $this->ChatModel->getChat(),
        ];
        echo json_encode($data);
        echo 'hi';
    }
}