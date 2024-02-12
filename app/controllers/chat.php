<?php
class Chat extends Controller {
    public function __construct(){
        $this->middleware = new AuthMiddleware();
        // Only parkingOwner are allowed to access driver pages
        // $this->middleware->checkAccess(['parkingOwner']);
        // $this->parkingOwnerModel = $this->model('parkingOwnerModel');
    }

    public function viewChat(){
        $data = [
            'title' => 'Home page'
        ];
        $this->view('chat/chat', $data);
    }
}