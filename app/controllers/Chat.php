<?php
class Chat extends Controller {
    public function __construct(){
        $this->middleware = new AuthMiddleware();
        // Only parkingOwner are allowed to access driver pages
        $this->middleware->checkAccess(['parkingOwner', 'merchandiser']);
        $this->parkingOwnerModel = $this->model('ParkingOwnerModel');
        $this->merchandiserModel = $this->model('MerchandiserModel');
        $this->chatModel = $this->model('ChatModel');
        // $this->landModel = $this->model('LandModel');
    }

    public function viewChat($chat_ID = null){
        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $data = [
            'chat_list' => $this->chatModel->getChatList()
        ];

        if(!empty($chat_ID)){
            $data['chat_history'] = $this->chatModel->getChatHistory($chat_ID);
            $data['chat_id'] = $chat_ID;
        }

        if($_SESSION['user_type'] == "merchandiser")
            $this->view('merchandiser/chat', $data, $other_data);
        else
            $this->view('parkingOwner/chat', $data, $other_data);
    }

    public function sendMessage(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->chatModel->sendMessage($_POST['message'], $_POST['chatID']);

            redirect('chat/viewChat/'.$_POST['chatID']);
        }
    }
}
