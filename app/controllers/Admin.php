<?php
class Admin extends Controller {
    public function __construct(){
        $this->middleware = new AuthMiddleware();
        // Only admin are allowed to access parkingOwner pages
        $this->middleware->checkAccess(['admin']);
        $this->adminModel = $this->model('AdminModel');
        $this->landModel = $this->model('LandModel');
        $this->userModel = $this->model('UserModel');
    }

    public function index(){
        $data = [
            'request_count' => $this->landModel->getUnVerifyLandCount(),
            'all_today_total_transactions' => $this->landModel->getAllTodayTotalTransactions(),
            'all_total_income_distribution' => $this->landModel->getAllTotalIncomeDistribution(),
            'all_total_vehicle_distribution' => $this->landModel->getAllTotalVehicleDistribution(),
            'title' => 'Admin Dashboard'
        ];

        $notifications['list'] = $this->userModel->viewNotifications();
        $notifications['notification_count'] = $this->userModel->getNotificationCount();

        // die(print_r($notifications['list']));

        if ($notifications['notification_count'] < 10)
            $notifications['notification_count'] = '0'.$notifications['notification_count'];

        $this->view('admin/index', $data, $notifications);
    }

    public function viewRegistrationRequests(){
        $data = $this->landModel->viewUnVerifyLands();

        $notifications['list'] = $this->userModel->viewNotifications();
        $notifications['notification_count'] = $this->userModel->getNotificationCount();

        // die(print_r($notifications['list']));

        if ($notifications['notification_count'] < 10)
            $notifications['notification_count'] = '0'.$notifications['notification_count'];

        $this->view('admin/requests', $data, $notifications);
    }

    public function viewRegistrationRequestedLand($land_id = null, $notification_id = null){
        if ($notification_id != null)
            $this->userModel->markAsRead($notification_id);

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

    // Assign land verification to admin
    public function assignLandVerification(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $this->landModel->assignLandVerification($_POST['id'], $_SESSION['user_id']);

            redirect('admin/requests');
        }
    }

    // Assign registration requests to admin
    public function assignMySelf(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $this->landModel->assignMySelf($_POST['id'], $_SESSION['user_id']);

            redirect('admin/viewRegistrationRequests');
        }
    }

    // Unassigned registration requests to admin
    public function unassignedMySelf(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $this->landModel->unassignedMySelf($_POST['id'], $_SESSION['user_id']);

            redirect('admin/viewRegistrationRequests');
        }
    }

    // View Complaints
    public function complaints(){
        $data = $this->adminModel->viewComplaints();

        $notifications['list'] = $this->userModel->viewNotifications();
        $notifications['notification_count'] = $this->userModel->getNotificationCount();

        if ($notifications['notification_count'] < 10)
            $notifications['notification_count'] = '0'.$notifications['notification_count'];


        $this->view('admin/complaints', $data, $notifications);
    }

    // Assign my self complaint
    public function assignMySelfComplaint(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $this->userModel->assignMySelfComplaint($_POST['id'], $_SESSION['user_id']);

            redirect('admin/complaints');
        }
    }

    // Unassign my self complaint
    public function unassignedMySelfComplaint(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $this->userModel->unassignMySelfComplaint($_POST['id'], $_SESSION['user_id']);

            redirect('admin/complaints');
        }
    }

    // View Complaint
    public function viewComplaint($complaint_id){
        $data = $this->userModel->viewComplaint($complaint_id);
        $land = $this->landModel->viewLand($data->complaineeID);

        $notifications['list'] = $this->userModel->viewNotifications();
        $notifications['notification_count'] = $this->userModel->getNotificationCount();

        if ($notifications['notification_count'] < 10)
            $notifications['notification_count'] = '0'.$notifications['notification_count'];

        $notifications['complaint_details'] = $data;

        $this->view('admin/viewComplaint', $land, $notifications);
    }

    // Ban user
    public function banUser(){
        $complaintID = $_POST['id'];
        $ownerID = $_POST['ownerID'];

        $this->userModel->banUser($ownerID);

        redirect('admin/viewComplaint/'.$complaintID);
    }

    // Ban parking
    public function banParking(){
        $landID = $_POST['landID'];
        $complaintID = $_POST['id'];
        $ownerID = $_POST['ownerID'];

        $this->landModel->banParking($landID, $ownerID);

        redirect('admin/viewComplaint/'.$complaintID);
    }
}
