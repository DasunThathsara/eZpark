<?php
class Merchandiser extends Controller {
    public function __construct(){
        $this->middleware = new AuthMiddleware();
        // Only merchandiser personnel are allowed to access merchandiser pages
        $this->middleware->checkAccess(['merchandiser']);
        $this->merchandiserModel = $this->model('MerchandiserModel');
    }

    public function index(){
        $data = [
            'title' => 'Home page'
        ];
        $this->view('merchandiser/index', $data);
    }

public function lands(){
    $lands = $this->merchandiserModel->viewlands();

    $this->view('merchandiser/lands', $lands);
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
            'deed' => trim($_POST['deed']),
            'car' => trim($_POST['car']),
            'bike' => trim($_POST['bike']),
            'threeWheel' => trim($_POST['threeWheel']),
            'street' => trim($_POST['street']),
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
        } else {
            // Check city
            if ($this->merchandiserModel->findLandByName($data['city'])){
                $data['err'] = 'City cannot be duplicate';
            }
        }

        if (empty($data['deed'])){
            $data['err'] = 'Please enter deed';
        } else {
            // Check deed
            if ($this->merchandiserModel->findLandByName($data['deed'])){
                $data['err'] = 'Deed cannot be duplicate';
            }
        }

        if (empty($data['car'])){
            $data['err'] = 'Please enter car';
        } else {
            // Check car
            if ($this->merchandiserModel->findLandByName($data['car'])){
                $data['err'] = 'Car cannot be duplicate';
            }
        }

        if (empty($data['bike'])){
            $data['err'] = 'Please enter bike';
        } else {
            // Check bike
            if ($this->merchandiserModel->findLandByName($data['bike'])){
                $data['err'] = 'Bike cannot be duplicate';
            }
        }

        if (empty($data['threeWheel'])){
            $data['err'] = 'Please enter threeWheel';
        } else {
            // Check threeWheel
            if ($this->merchandiserModel->findLandByName($data['threeWheel'])){
                $data['err'] = 'Three Wheel cannot be duplicate';
            }
        }

        if (empty($data['street'])){
            $data['err'] = 'Please enter street';
        } else {
            // Check street
            if ($this->merchandiserModel->findLandByName($data['street'])){
                $data['err'] = 'Street cannot be duplicate';
            }
        }

        if (empty($data['contactNo'])){
            $data['err'] = 'Please enter contactNo';
        } else {
            // Check contactNo
            if ($this->merchandiserModel->findLandByName($data['contactNo'])){
                $data['err'] = 'Contact Number cannot be duplicate';
            }
        }

        // Validation is completed and no error found
        if (empty($data['err'])){
            // Register land
            print_r($data);
            print_r($_SESSION['user_id']);
            if ($this->merchandiserModel->registerLand($data)){
                redirect('merchandiser/lands');
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
            'deed' => '',
            'car' => '',
            'bike' => '',
            'threeWheel' => '',
            'street' => '',
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
            'name' => trim($_POST['name']),
            'city' => trim($_POST['city']),
            'deed' => trim($_POST['deed']),
            'car' => trim($_POST['car']),
            'bike' => trim($_POST['bike']),
            'threeWheel' => trim($_POST['threeWheel']),
            'street' => trim($_POST['street']),
            'contactNo' => trim($_POST['contactNo'])
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
            'deed' => trim($_POST['deed']),
            'car' => trim($_POST['car']),
            'bike' => trim($_POST['bike']),
            'threeWheel' => trim($_POST['threeWheel']),
            'street' => trim($_POST['street']),
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
            'old_city' => trim($_POST['old_city']),
            'deed' => trim($_POST['deed']),
            'old_deed' => trim($_POST['old_deed']),
            'car' => trim($_POST['car']),
            'old_car' => trim($_POST['old_car']),
            'bike' => trim($_POST['bike']),
            'old_bike' => trim($_POST['old_bike']),
            'threeWheel' => trim($_POST['threeWheel']),
            'old_threeWheel' => trim($_POST['old_threeWheel']),
            'street' => trim($_POST['street']),
            'old_street' => trim($_POST['old_street']),
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
            if ($this->merchandiserModel->findLandByName($data['name']) and $data['name'] != $data['old_name']){
                $data['err'] = 'Name cannot be duplicate';
            }
        }

        if (empty($data['city'])){
            $data['err'] = 'Please enter city';
        } else {
            // Check city
            if ($this->merchandiserModel->findLandByName($data['city']) and $data['city'] != $data['old_city']){
                $data['err'] = 'City cannot be duplicate';
            }
        }

        if (empty($data['deed'])){
            $data['err'] = 'Please enter deed';
        } else {
            // Check deed
            if ($this->merchandiserModel->findLandByName($data['deed']) and $data['deed'] != $data['old_deed']){
                $data['err'] = 'Deed cannot be duplicate';
            }
        }

        if (empty($data['car'])){
            $data['err'] = 'Please enter car';
        } else {
            // Check car
            if ($this->merchandiserModel->findLandByName($data['car']) and $data['car'] != $data['old_car']){
                $data['err'] = 'Car cannot be duplicate';
            }
        }

        if (empty($data['bike'])){
            $data['err'] = 'Please enter bike';
        } else {
            // Check bike
            if ($this->merchandiserModel->findLandByName($data['bike']) and $data['bike'] != $data['old_bike']){
                $data['err'] = 'Bike cannot be duplicate';
            }
        }

        if (empty($data['threeWheel'])){
            $data['err'] = 'Please enter threeWheel';
        } else {
            // Check threeWheel
            if ($this->merchandiserModel->findLandByName($data['threeWheel']) and $data['threeWheel'] != $data['old_threeWheel']){
                $data['err'] = 'Three Wheel cannot be duplicate';
            }
        }

        if (empty($data['street'])){
            $data['err'] = 'Please enter street';
        } else {
            // Check street
            if ($this->merchandiserModel->findLandByName($data['street']) and $data['street'] != $data['old_street']){
                $data['err'] = 'Street cannot be duplicate';
            }
        }

        if (empty($data['contactNo'])){
            $data['err'] = 'Please enter contactNo';
        } else {
            // Check contactNo
            if ($this->merchandiserModel->findLandByName($data['contactNo']) and $data['contactNo'] != $data['old_contactNo']){
                $data['err'] = 'Contact Number cannot be duplicate';
            }
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

}