<?php
class Land extends Controller {
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

    // ------------------------------ Lands ------------------------------
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
    public function landUpdateForm($land_ID = null, $land_name = null){
        if (sizeof($_GET) > 1){
            $data = [
                'name' => trim($_GET['name']),
                'id' => trim($_GET['id'])
            ];
    
            redirect('land/landUpdateForm/'.$data['id'].'/'.$data['name']);
        }
        else{
            $data = [
                'name' => $land_name,
                'id' => $land_ID
            ];

            $prices = $this->parkingOwnerModel->viewToBeUpdatedLand($data);
            

            $data = [
                'name' => $prices[0]->name,
                'city' => $prices[0]->city,
                'street' => $prices[0]->street,
                'deed' => $prices[0]->deed,
                'car' => $prices[0]->car,
                'bike' => $prices[0]->bike,
                'threeWheel' => $prices[0]->threeWheel,
                'contactNo' => $prices[0]->contactNo,
                'err' => '',
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

    // Success property register page
    public function successPropertyRegister($data){
        $this->view('parkingOwner/lands/successPropertyRegister', $data);
    }

    // ------------------------------ Price ------------------------------
    // View all lands
    public function prices($land_ID = null, $land_name = null){
        if (sizeof($_GET) > 1){
            $data = [
                'name' => trim($_GET['name']),
                'id' => trim($_GET['id'])
            ];
    
            redirect('land/prices/'.$data['id'].'/'.$data['name']);
        }
        else{
            $data = [
                'name' => $land_name,
                'id' => $land_ID
            ];

            $prices = $this->parkingOwnerModel->viewPrice($data);

            $this->view('parkingOwner/prices', $data, $prices);
        }
    }
}