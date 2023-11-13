<?php
class ParkingOwner extends Controller {
    public function __construct(){
        $this->middleware = new AuthMiddleware();
        // Only parkingOwner are allowed to access parkingOwner pages
        $this->middleware->checkAccess(['parkingOwner']);
        $this->parkingOwnerModel = $this->model('ParkingOwnerModel');
    }

    public function index(){
        $lands = $this->parkingOwnerModel->viewLands();
        $this->view('parkingOwner/index', $lands);
    }

    public function lands(){
        $lands = $this->parkingOwnerModel->viewLands();

        $this->view('parkingOwner/lands', $lands);
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
                if ($this->parkingOwnerModel->setPrice($data)){
//                       redirect('parkingOwner/lands');
                    $this->successPropertyRegister($data);
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('parkingOwner/lands/setPrice', $data);
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
            $this->view('parkingOwner/lands/create', $data);
        }
    }

    public function setPrice($data){
        $this->view('parkingOwner/lands/setPrice', $data);
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
                if ($this->parkingOwnerModel->updateSecurityOfficerAvail($data)){
                    $this->setPrice($data);
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('parkingOwner/lands', $data);
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
            $this->view('parkingOwner/lands/create', $data);
        }
    }
    
    public function aboutSecurityOfficer($data){
        $this->view('parkingOwner/lands/aboutSecurityOfficer', $data);
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
                if ($this->parkingOwnerModel->findLandByName($data['name'])){
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

            // Validation is completed and no error found*/
            if (empty($data['err'])){
                // Register land
                if ($this->parkingOwnerModel->registerLand($data)){
                    $this->aboutSecurityOfficer($data);
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('parkingOwner/lands/create', $data);
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
            $this->view('parkingOwner/lands/create', $data);
        }
    }

    // Remove Land
    public function landRemove(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name'])
            ];

            // Delete the land
            if ($this->parkingOwnerModel->removeLand($data)){
                redirect('parkingOwner/lands');
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
            $this->view('parkingOwner/lands/update', $data);
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
                if ($data['name'] != $data['old_name'] and $this->parkingOwnerModel->findLandByName($data['name'])){
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
                if ($this->parkingOwnerModel->updateLand($data)){
                    redirect('parkingOwner/lands');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('parkingOwner/lands/update', $data);
            }
        }
    }

    public function gotoLand($land_ID = null, $land_name = null){
        $data = [
            'id' => $land_ID,
            'name' => $land_name
        ];

        $lands = $this->parkingOwnerModel->viewLands();

        $this->view('parkingOwner/land', $data, $lands);
    }

    // ------------------------ Packages ------------------------
    public function packages($parking_ID = null, $parking_name = null){
        $data = [
            'id' => $parking_ID,
            'name' => $parking_name
        ];

        $packages = $this->parkingOwnerModel->viewPackages($data);

        $this->view('parkingOwner/packages', $data, $packages);
    }

     // ------------------------ Success Property Register ------------------------
    public function successPropertyRegister($data){
        $this->view('parkingOwner/lands/successPropertyRegister', $data);
    }

}