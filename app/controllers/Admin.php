<?php
class Admin extends Controller {
    public function __construct(){
        $this->middleware = new AuthMiddleware();
        // Only admin are allowed to access parkingOwner pages
        $this->middleware->checkAccess(['admin']);
        $this->adminModel = $this->model('AdminModel');
        $this->landModel = $this->model('LandModel');
    }

    public function index(){
        $data = [
            'request_count' => $this->landModel->getUnVerifyLandCount(),
            'title' => 'Admin Dashboard'
        ];

        $other_data['notification_count'] = $data['request_count'];

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('admin/index', $data, $other_data);
    }

    public function viewRegistrationRequests(){
        $data = $this->landModel->viewUnVerifyLands();

        $other_data['notification_count'] = $this->landModel->getUnVerifyLandCount();

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('admin/requests', $data, $other_data);
    }

    public function viewRegistrationRequestedLand($land_id = null){
        $data = $this->landModel->viewLand($land_id);

        $other_data['notification_count'] = $this->landModel->getUnVerifyLandCount();

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('admin/viewRequest', $data, $other_data);
    }

    public function verifyLand(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $this->landModel->verifyLand($_POST['id']);

            redirect('admin/viewRegistrationRequests');
        }
    }

    public function unverifyLand(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $this->landModel->unverifyLand($_POST['id']);

            redirect('admin/viewRegistrationRequests');
        }
    }
}