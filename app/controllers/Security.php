<?php
class Security extends Controller {
    public function __construct(){
        $this->middleware = new AuthMiddleware();
        // Only security personnel are allowed to access security pages
        $this->middleware->checkAccess(['security']);
        $this->landModel = $this->model('LandModel');
        $this->securityModel = $this->model('SecurityModel');
        $this->userModel = $this->model('UserModel');
    }

    public function index(){
        $data = [
            'title' => 'Home page'
        ];

        $other_data['notification_count'] = $this->userModel->getNotificationCount();

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('security/index', $data, $other_data);
    }

    // Add security
    public function securitySearch($landID = null){
        $data = [
            'id' => $landID
        ];

        $other_data = $this->securityModel->viewAllSecurities();

        die(print_r($other_data));

        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('security/securityRegister', $data, $other_data);
    }

    // View land request
    public function viewRequests(){
        $data = $this->securityModel->viewLandRequest();

        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('security/viewRequests', $data, $other_data);
    }

    // View requested land details 
    public function viewLand($landID = null){
        $data = $this->landModel->viewLand($landID);
        $data->assignedLand = $this->securityModel->getAssignedLandID();

        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('security/viewRequestedLand', $data, $other_data);
    }

    // Accept land request
    public function acceptLandRequest(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $this->securityModel->acceptLandRequest($_POST['id']);

            redirect('security/viewLand/'.$_POST['id'].'/'.$_SESSION['user_id']);
        }
    }

    // Decline land request
    public function declineLandRequest(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $this->securityModel->declineLandRequest($_POST['id']);

            redirect('security/landRequest');
        }
    }
}