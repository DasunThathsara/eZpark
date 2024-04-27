<?php
class SuperAdmin extends Controller {
    public function __construct(){
        $this->middleware = new AuthMiddleware();
        // Only superadmin are allowed to access superadmin pages
        $this->middleware->checkAccess(['superAdmin']);
        $this->adminModel = $this->model('AdminModel');
        $this->superAdminModel = $this->model('SuperAdminModel');
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

        $other_data['notification_count'] = $data['request_count'];
        $other_data['admin_count'] = $this->userModel->getAdminCount();

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('superAdmin/index', $data, $other_data);
    }

    // View all the registration requests
    public function viewRegistrationRequests(){
        $data = $this->landModel->viewUnVerifyLands();

        // die(print_r($data));

        $other_data['notification_count'] = $this->landModel->getUnVerifyLandCount();

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('superAdmin/requests', $data, $other_data );
    }

    // View specific land
    public function viewRegistrationRequestedLand($land_id = null){
        $data = $this->landModel->viewLand($land_id);

        $other_data['notification_count'] = $this->landModel->getUnVerifyLandCount();

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('superAdmin/viewRequest', $data, $other_data);
    }

    // Verify the given land
    public function verifyLand(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $this->landModel->verifyLand($_POST['id']);

            redirect('superAdmin/viewRegistrationRequests');
        }
    }

    // Unverified the given land
    public function unverifyLand(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $this->landModel->unverifyLand($_POST['id']);

            redirect('superAdmin/viewRegistrationRequests');
        }
    }

    // Unassigned registration requests to admin
    public function unassignedAdminFromLand(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $this->landModel->unassignedMySelf($_POST['id'], $_POST['admin']);

            redirect('superAdmin/viewRegistrationRequests');
        }
    }

    // View all the admins in the system
    public function viewAdmins(){
        $data = $this->userModel->viewAdmins();

        $other_data['notification_count'] = $this->landModel->getUnVerifyLandCount();

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        // die(print_r($data));

        $this->view('superAdmin/admins', $data, $other_data);
    }

    // View specific admin
    public function viewAdmin($admin_id = null){
        $data = $this->userModel->viewAdmin($admin_id);

        $other_data['notification_count'] = $this->landModel->getUnVerifyLandCount();

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        // die(print_r($data));

        $this->view('superAdmin/admins/view', $data, $other_data);
    }

    // Add new admin
    public function addAdmin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'username' => trim($_POST['username']),
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'contact_no' => trim($_POST['contact_no']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'user_type' => trim($_POST['user_type']),
                'err' => ''
            ];

            // Validate username
            if (empty($data['username'])) {
                $data['err'] = 'Please enter username';
            } else {
                // Check if username exists
                if ($this->userModel->findUserByUsername($data['username'])) {
                    $data['err'] = 'Username is already taken';
                }
            }

            // Validate name
            if (empty($data['name'])) {
                $data['err'] = 'Please enter name';
            }

            // Validate email
            if (empty($data['email'])) {
                $data['err'] = 'Please enter email';
            } else {
                // Check if email exists
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['err'] = 'Email is already taken';
                }
            }

            // Validate contact number
            if (empty($data['contact_no'])) {
                $data['err'] = 'Please enter contact number';
            }

            // Validate password
            if (empty($data['password'])) {
                $data['err'] = 'Please enter password';
            } elseif (strlen($data['password']) < 6) {
                $data['err'] = 'Password must be at least 6 characters';
            }

            // Validate confirm password
            if (empty($data['confirm_password'])) {
                $data['err'] = 'Please confirm password';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['err'] = 'Passwords do not match';
                }
            }

            // Make sure errors are empty
            if (empty($data['err'])) {
                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register user
                if ($this->userModel->register($data)) {
//                    $this->userModel->addAdmin($data);
                    redirect('superAdmin/viewAdmins');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('superAdmin/admins/add', $data);
            }
        } else {
            $other_data['notification_count'] = $this->landModel->getUnVerifyLandCount();

            if ($other_data['notification_count'] < 10)
                $other_data['notification_count'] = '0'.$other_data['notification_count'];


            $data = [
                'username' => '',
                'name' => '',
                'email' => '',
                'contact_no' => '',
                'password' => '',
                'confirm_password' => '',
                'user_type' => 'admin',
                'err' => ''
            ];

            $this->view('superAdmin/admins/add', $data, $other_data);
        }
    }

    // Remove admin
    public function removeAdmin(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $this->userModel->removeAdmin(trim($_POST['id']));

            redirect('superAdmin/viewAdmins');
        }
    }

    // Ban admin
    public function banAdmin(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $this->userModel->banAdmin(trim($_POST['id']));

            redirect('superAdmin/viewAdmins');
        }
    }

    // Update admin
    public function updateAdmin($admin_id = null){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => trim($_POST['id']),
                'username' => trim($_POST['username']),
                'old_username' => trim($_POST['old_username']),
                'name' => trim($_POST['name']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'err' => ''
            ];

            // Validate username
            if (empty($data['username'])) {
                $data['err'] = 'Please enter username';
            } else {
                // Check if username exists
                if ($this->userModel->findUserByUsername($data['username']) and $data['username'] != $data['old_username']) {
                    $data['err'] = 'Username is already taken';
                }
            }

            // Validate name
            if (empty($data['name'])) {
                $data['err'] = 'Please enter name';
            }

            // Validate password
            if (empty($data['password'])) {
                $data['err'] = 'Please enter password';
            } elseif (strlen($data['password']) < 6) {
                $data['err'] = 'Password must be at least 6 characters';
            }

            // Validate confirm password
            if (empty($data['confirm_password'])) {
                $data['err'] = 'Please confirm password';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['err'] = 'Passwords do not match';
                }
            }

//            die(print_r($data));

            // Make sure errors are empty
            if (empty($data['err'])){
                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register user
                if ($this->userModel->updateAdmin($data)){
                    redirect('superAdmin/viewAdmins');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $data = (object)$data;

                $other_data['notification_count'] = $this->landModel->getUnVerifyLandCount();

                if ($other_data['notification_count'] < 10)
                    $other_data['notification_count'] = '0'.$other_data['notification_count'];


                $this->view('superAdmin/admins/update', $data, $other_data);
            }
        }
        else{
            if (empty($admin_id))
                $data = $this->userModel->viewAdmin($_GET['id']);
            else
                $data = $this->userModel->viewAdmin($admin_id);


            $other_data['notification_count'] = $this->landModel->getUnVerifyLandCount();

            if ($other_data['notification_count'] < 10)
                $other_data['notification_count'] = '0'.$other_data['notification_count'];

            $this->view('superAdmin/admins/update', $data, $other_data);
        }
    }

    public function adminAccessControl(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // die(print_r($land_ID));

            if ($this->superAdminModel->adminAccessControl($_POST['adminId'])){
                redirect('superAdmin/viewAdmins/');
            } else {
                die('Something went wrong');
            }
        }
    } 
}