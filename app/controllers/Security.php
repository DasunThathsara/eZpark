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

        die(print_r($data));

        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('security/landRequest', $data, $other_data);
    }
}