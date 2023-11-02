<?php
class ParkingOwner extends Controller {
    public function __construct(){
        $this->middleware = new AuthMiddleware();
        // Only parkingOwner are allowed to access parkingOwner pages
        $this->middleware->checkAccess(['parkingOwner']);
        $this->parkingOwnerModel = $this->model('ParkingOwnerModel');
    }

    public function index(){
        $data = [
            'title' => 'Home page'
        ];
        $this->view('parkingOwner/index', $data);
    }

    public function lands(){
        $lands = $this->parkingOwnerModel->viewLands();

        $this->view('parkingOwner/lands', $lands);
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
                'secAvail' => trim($_POST['secAvail'])
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
                'name' => ''
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
            } else {
                // Check city
                if ($this->parkingOwnerModel->findLandByName($data['city'])){
                    $data['err'] = 'City cannot be duplicate';
                }
            }

            if (empty($data['street'])){
                $data['err'] = 'please enter street';
            } else {
                //check street
                if ($this->parkingOwnerModel->findLandByName($data['street'])){
                    $data['err'] = 'Street cannot be duplicate';
                }
            }

            if (empty($data['deed'])){
                $data['err'] = 'please enter deed';
            } else {
                //check deed
                if ($this->parkingOwnerModel->findLandByName($data['deed'])){
                    $data['err'] = 'Deed cannot be duplicate';
                }
            }

            if (empty($data['car'])){
                $data['err'] = 'please enter price for a car';
            } else {
                //check price for a car
                if ($this->parkingOwnerModel->findLandByName($data['car'])){
                    $data['err'] = 'Price cannot be duplicate';
                }
            }

            if (empty($data['bike'])){
                $data['err'] = 'please enter price for a bike';
            } else {
                //check price for a bike
                if ($this->parkingOwnerModel->findLandByName($data['bike'])){
                    $data['err'] = 'Price cannot be duplicate';
                }
            }

            if (empty($data['threeWheel'])){
                $data['err'] = 'please enter price for a three-wheeler';
            } else {
                //check price for a three-wheeler
                if ($this->parkingOwnerModel->findLandByName($data['threeWheel'])){
                    $data['err'] = 'Price cannot be duplicate';
                }
            }
        

            if (empty($data['contactNo'])){
                $data['err'] = 'please enter contact number';
            } else {
                //check contact number
                if ($this->parkingOwnerModel->findLandByName($data['contactNo'])){
                    $data['err'] = 'Contact number cannot be duplicate';
                }
            }

            // Validation is completed and no error found*/
            if (empty($data['err'])){
                // Register land
                print_r($data);
                print_r($_SESSION['user_id']);
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
                'name' => trim($_POST['name']),
                'city' => trim($_POST['city']),
                'street' => trim($_POST['street']),
                'deed' => trim($_POST['deed']),
                'car' => trim($_POST['car']),
                'bike' => trim($_POST['bike']),
                'threeWheel' => trim($_POST['threeWheel']),
                'contactNo' => trim($_POST['contactNo'])
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
                //'land_type' => trim($_POST['land_type']),
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
                'old_city' => trim($_POST['old_city']),
                'street' => trim($_POST['street']),
                'old_street' => trim($_POST['old_street']),
                'deed' => trim($_POST['deed']),
                'old_deed' => trim($_POST['old_deed']),
                'car' => trim($_POST['car']),
                'old_car' => trim($_POST['old_car']),
                'bike' => trim($_POST['bike']),
                'old_bike' => trim($_POST['old_bike']),
                'threeWheel' => trim($_POST['threeWheel']),
                'old_threeWheel' => trim($_POST['old_threeWheel']),
                'contactNo' => trim($_POST['contactNo']),
                'old_contactNo' => trim($_POST['old_contactNo']),
                'err' => ''
            ];

            // Validate data
            // Validate email
            if (empty($data['name'])){
                $data['err'] = 'Please enter name';
            } else {
                // Check name
                if ($this->parkingOwnerModel->findLandByName($data['name']) and $data['name'] != $data['old_name']){
                    $data['err'] = 'Name cannot be duplicate';
                }
            }

            if (empty($data['city'])){
                $data['err'] = 'Please enter city';
            } else {
                // Check city
                if ($this->parkingOwnerModel->findLandByName($data['city']) and $data['city'] != $data['old_city']){
                    $data['err'] = 'City cannot be duplicate';
                }
            }

            if (empty($data['street'])){
                $data['err'] = 'Please enter street';
            } else {
                // Check street
                if ($this->parkingOwnerModel->findLandByName($data['street']) and $data['street'] != $data['old_street']){
                    $data['err'] = 'Street cannot be duplicate';
                }
            }
    
            if (empty($data['deed'])){
                $data['err'] = 'Please enter deed';
            } else {
                // Check deed
                if ($this->parkingOwnerModel->findLandByName($data['deed']) and $data['deed'] != $data['old_deed']){
                    $data['err'] = 'Deed cannot be duplicate';
                }
            }

            if (empty($data['car'])){
                $data['err'] = 'Please enter car';
            } else {
                // Check car
                if ($this->parkingOwnerModel->findLandByName($data['car']) and $data['car'] != $data['old_car']){
                    $data['err'] = 'Car cannot be duplicate';
                }
            }
    
            if (empty($data['bike'])){
                $data['err'] = 'Please enter bike';
            } else {
                // Check bike
                if ($this->parkingOwnerModel->findLandByName($data['bike']) and $data['bike'] != $data['old_bike']){
                    $data['err'] = 'Bike cannot be duplicate';
                }
            }
    
            if (empty($data['threeWheel'])){
                $data['err'] = 'Please enter threeWheel';
            } else {
                // Check threeWheel
                if ($this->parkingOwnerModel->findLandByName($data['threeWheel']) and $data['threeWheel'] != $data['old_threeWheel']){
                    $data['err'] = 'Three Wheel cannot be duplicate';
                }
            }

            if (empty($data['contactNo'])){
                $data['err'] = 'Please enter contactNo';
            } else {
                // Check contactNo
                if ($this->parkingOwnerModel->findLandByName($data['contactNo']) and $data['contactNo'] != $data['old_contactNo']){
                    $data['err'] = 'Contact Number cannot be duplicate';
                }
            }

            // Validation is completed and no error found
            if (empty($data['err'])){
                // Register land
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

    // ------------------------ Packages ------------------------
    public function packages(){
        $packages = $this->parkingOwnerModel->viewPackages();

        $this->view('parkingOwner/packages', $packages);
    }

     // ------------------------ Success Property Register ------------------------
 public function successPropertyRegister(){
    $lands = $this->parkingOwnerModel->viewLands();

    $this->view('parkingOwner/lands/successPropertyRegister', $lands);
}

}