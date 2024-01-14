<?php
class Chat extends Controller {
    public function __construct(){
        // $this->middleware = new AuthMiddleware();
        // // Only parkingOwner are allowed to access driver pages
        // $this->middleware->checkAccess(['parkingOwner']);
        // $this->parkingOwnerModel = $this->model('parkingOwnerModel');
    }

    public function viewChat(){
        $data = [
            'title' => 'Home page'
        ];
        $this->view('chat/index', $data);
    }


//     public function viewChat(){
//         $data = [
//             'title' => 'Home page'
//         ];

//         $other_data['notification_count'] = 0;

//         if ($other_data['notification_count'] < 10)
//             $other_data['notification_count'] = '0'.$other_data['notification_count'];

//         $this->view('chat/index', $data, $other_data);
//     }

}