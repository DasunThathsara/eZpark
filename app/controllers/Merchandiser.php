<?php
class Merchandiser extends Controller {
    public function __construct(){
        $this->middleware = new AuthMiddleware();
        // Only merchandiser personnel are allowed to access merchandiser pages
        $this->middleware->checkAccess(['merchandiser']);
        $this->merchandiserModel = $this->model('MerchandiserModel');
        $this->landModel = $this->model('LandModel');
        $this->securityModel = $this->model('SecurityModel');
    }

    public function index(){
        $lands = $this->landModel->viewLands();

        $data = [
            'land_count' => $this->landModel->getLandCount(),
            'total_capacity' => $this->landModel->getTotalCapacity()
        ];

        $lands['notification_count'] = 0;

        if ($lands['notification_count'] < 10)
            $lands['notification_count'] = '0'.$lands['notification_count'];

        $this->view('merchandiser/index', $data, $lands);
    }

        // --------------------------------------- Lands ---------------------------------------
    // View all lands
    public function lands(){
        $lands = $this->landModel->viewLands();

        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('merchandiser/lands', $lands, $other_data);
    }

    // Go to specific land
    public function gotoLand($land_ID = null){
        $data = [
            'id' => $land_ID,
            'name' => $this->landModel->getLandName($land_ID),
        ];

        $lands = $this->landModel->viewLands();

        $lands['notification_count'] = 0;

        if ($lands['notification_count'] < 10)
            $lands['notification_count'] = '0'.$lands['notification_count'];

        $data = [
            'id' => $land_ID,
            'name' => $this->landModel->getLandName($land_ID),
            // 'package_count' => $this->merchandiserModel->getPackageCount($data),
            'land_count' => $this->landModel->getLandCount($data),
            'security_count' => $this->securityModel->getSecurityCount($land_ID),
            'availability' => $this->landModel->getAvailability($land_ID),
            'capacity' => $this->landModel->getCapacity($land_ID),
        ];

        $this->view('merchandiser/land', $data, $lands);
    }

        // --------------------------------- Parking Capacity ----------------------------------
    // View all packages
    public function parkingCapacity($parking_ID = null, $parking_name = null){
        $lands = $this->landModel->viewLands();

        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('merchandiser/capacity', $lands, $other_data);
    }

        // -------------------------------------- Report ---------------------------------------
        public function viewReport(){
            $data = [
                'title' => 'Home page'
            ];
    
            $other_data['notification_count'] = 0;
    
            if ($other_data['notification_count'] < 10)
                $other_data['notification_count'] = '0'.$other_data['notification_count'];
    
            $this->view('merchandiser/report', $data, $other_data);
        }

            // ------------------------------------ Securities -------------------------------------
    // View all securities
    public function securities($landID){
        $data = [
            'id' => $landID
        ];

        $other_data = $this->securityModel->viewSecurities($landID);

        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('merchandiser/securities', $data, $other_data);
    }

    public function setPriceForm(){
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Submitted form data
                // input data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                    'name' => trim($_POST['name']),
                    'car' => trim($_POST['car']),
                    'bike' => trim($_POST['bike']),
                    'threeWheel' => trim($_POST['threeWheel']),
                    'err' => ''
                ];

                // Validate data
                if (empty($data['car'])){
                    $data['err'] = 'Please enter car';
                } else if (!preg_match('/^[1-9]\d*(\.\d+)?$/', $data['car'])){
                    $data['err'] = 'Invalid data type for cars';
                }

                if (empty($data['bike'])){
                    $data['err'] = 'Please enter bike';
                } else if (!preg_match('/^[1-9]\d*(\.\d+)?$/', $data['bike'])){
                    $data['err'] = 'Invalid data type for bikes';
                }

                if (empty($data['threeWheel'])){
                    $data['err'] = 'Please enter threeWheel';
                } else if (!preg_match('/^[1-9]\d*(\.\d+)?$/', $data['threeWheel'])){
                    $data['err'] = 'Invalid data type for three wheels';
                }

                // Validation is completed and no error found
                if (empty($data['err'])){
                    // Register land
                    if ($this->merchandiserModel->setPrice($data)){
//                       redirect('merchandiser/lands');
                        $this->successPropertyRegister($data);
                    } else {
                        die('Something went wrong');
                    }
                } else {
                    // Load view with errors
                    $this->view('merchandiser/lands/setPrice', $data);
                }

            } else {
                // Initial form data
                $data = [
                    'name' => '',
                    'car' => '',
                    'bike' => '',
                    'threeWheel' => '',
                    'err' => ''

                ];

                // Load view
                $this->view('merchandiser/lands/create', $data);
            }
        }

    public function setPrice($data){
        $this->view('merchandiser/lands/setPrice', $data);
    }

    public function secAvailSet(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'secAvail' => trim($_POST['secAvail']),
                'car' => '',
                'bike' => '',
                'threeWheel' => ''
            ];

            // Validate data
            // Validate email
            if (empty($data['name'])){
                $data['err'] = 'Please enter name';
            }

            if (empty($data['secAvail'])){
                $data['err'] = 'Please enter secAvail';
            }

            // Validation is completed and no error found
            if (empty($data['err'])){
                // Register land
                if ($this->merchandiserModel->updateSecurityOfficerAvail($data)){
                    $this->setPrice($data);
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('merchandiser/lands', $data);
            }

        } else {
            // Initial form data
            $data = [
                'name' => '',
                'car' => '',
                'bike' => '',
                'threeWheel' => ''
            ];

            // Load view
            $this->view('merchandiser/lands/create', $data);
        }
    }

    public function aboutSecurityOfficer($data){
        $this->view('merchandiser/lands/aboutSecurityOfficer', $data);
    }

    // Register Land
    public function landRegister(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'city' => trim($_POST['city']),
                'street' => trim($_POST['street']),
                'deed' => trim($_POST['deed']),
                'car' => trim($_POST['car']),
                'bike' => trim($_POST['bike']),
                'threeWheel' => trim($_POST['threeWheel']),
                'contactNo' => trim($_POST['contactNo']),
                'err' => ''
            ];

            // Validate data
            // Validate email
            if (empty($data['name'])){
                $data['err'] = 'Please enter name';
            } else {
                // Check name
                if ($this->merchandiserModel->findLandByName($data['name'])){
                    $data['err'] = 'Name cannot be duplicate';
                }
            }

            if (empty($data['city'])){
                $data['err'] = 'Please enter city';
            }

            if (empty($data['street'])){
                $data['err'] = 'Please enter street';
            }

            if (empty($data['deed'])){
                $data['err'] = 'Please enter deed';
            }

            if (!preg_match('/^(0|\d+)$/', $data['car'])){
                $data['err'] = 'Invalid data type for cars';
            }

            if (!preg_match('/^(0|\d+)$/', $data['bike'])){
                $data['err'] = 'Invalid data type for bikes';
            }

            if (!preg_match('/^(0|\d+)$/', $data['threeWheel'])) {
                $data['err'] = 'Invalid data type for three wheels';
            }

            if (empty($data['contactNo'])){
                $data['err'] = 'Please enter contactNo';
            } else if(!preg_match('/^(0\d{9}|[1-9]\d{8}|\+94\d{7})$/', $data['contactNo'])) {
                $data['err'] = 'Invalid contact number format';
            }

            // Validation is completed and no error found
            if (empty($data['err'])){
                // Register land
                if ($this->merchandiserModel->registerLand($data)){
                    $this->aboutSecurityOfficer($data);
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('merchandiser/lands/create', $data);
            }

        } else {
            // Initial form data
            $data = [
                'name' => '',
                'city' => '',
                'street' => '',
                'deed' => '',
                'car' => '',
                'bike' => '',
                'threeWheel' => '',
                'contactNo' => '',
                'err' => ''

            ];

            // Load view
            $this->view('merchandiser/lands/create', $data);
        }
    }

    // Remove land
    public function landRemove(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name'])
            ];

            // Delete the land
            if ($this->merchandiserModel->removeLand($data)){
                redirect('merchandiser/lands');
            } else {
                die('Something went wrong');
            }
        }
    }

    // Update Land
    public function landUpdateForm(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data = [
                'name' => trim($_POST['name']),
                'city' => trim($_POST['city']),
                'street' => trim($_POST['street']),
                'deed' => trim($_POST['deed']),
                'car' => trim($_POST['car']),
                'bike' => trim($_POST['bike']),
                'threeWheel' => trim($_POST['threeWheel']),
                'contactNo' => trim($_POST['contactNo']),
                'err' => ''
            ];
            $this->view('merchandiser/lands/update', $data);
        }
    }

    public function landUpdate(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'old_name' => trim($_POST['old_name']),
                'city' => trim($_POST['city']),
                'street' => trim($_POST['street']),
                'deed' => trim($_POST['deed']),
                'car' => trim($_POST['car']),
                'bike' => trim($_POST['bike']),
                'threeWheel' => trim($_POST['threeWheel']),
                'contactNo' => trim($_POST['contactNo']),
                'err' => ''
            ];

            // Validate data
            // Validate email
            if (empty($data['name'])){
                $data['err'] = 'Please enter name';
            } else {
                // Check name
                if ($data['name'] != $data['old_name'] and $this->merchandiserModel->findLandByName($data['name'])){
                    $data['err'] = 'Name cannot be duplicate';
                }
            }

            if (empty($data['city'])){
                $data['err'] = 'Please enter city';
            }

            if (empty($data['street'])){
                $data['err'] = 'Please enter street';
            }

            if (empty($data['deed'])){
                $data['err'] = 'Please enter deed';
            }

            if (!preg_match('/^(0|\d+)$/', $data['car'])){
                $data['err'] = 'Invalid data type for cars';
            }

            if (!preg_match('/^(0|\d+)$/', $data['bike'])){
                $data['err'] = 'Invalid data type for bikes';
            }

            if (!preg_match('/^(0|\d+)$/', $data['threeWheel'])) {
                $data['err'] = 'Invalid data type for three wheels';
            }


            if (empty($data['contactNo'])){
                $data['err'] = 'Please enter contactNo';
            } else if(!preg_match('/^(0\d{9}|[1-9]\d{8}|\+94\d{7})$/', $data['contactNo'])) {
                $data['err'] = 'Invalid contact number format';
            }

            // Validation is completed and no error found
            if (empty($data['err'])){
                // Register Land
                print_r($_SESSION['user_id']);
                if ($this->merchandiserModel->updateLand($data)){
                    redirect('merchandiser/lands');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('merchandiser/lands/update', $data);
            }
        }
    }

 // ------------------------ Success Property Register ------------------------
    public function successPropertyRegister($data){
        $this->view('merchandiser/lands/successPropertyRegister', $data);
    }
}