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

public function parkings(){
    $parkings = $this->merchandiserModel->viewparkings();

    $this->view('merchandiser/parkings', $parkings);
}

// Register parking
public function ParkingRegister(){
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Submitted form data
        // input data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
            'name' => trim($_POST['name']),
            'city' => trim($_POST['city']),
            'err' => ''
        ];

        // Validate data
        // Validate email
        if (empty($data['name'])){
            $data['err'] = 'Please enter name';
        } else {
            // Check name
            if ($this->merchandiserModel->findParkingByName($data['name'])){
                $data['err'] = 'Name cannot be duplicate';
            }
        }

        if (empty($data['city'])){
            $data['err'] = 'Please enter city';
        } else {
            // Check city
            if ($this->merchandiserModel->findParkingByName($data['city'])){
                $data['err'] = 'City cannot be duplicate';
            }
        }

        // Validation is completed and no error found
        if (empty($data['err'])){
            // Register parking
            print_r($data);
            print_r($_SESSION['user_id']);
            if ($this->merchandiserModel->registerparking($data)){
                redirect('merchandiser/parkings');
            } else {
                die('Something went wrong');
            }
        } else {
            // Load view with errors
            $this->view('merchandiser/parkings/create', $data);
        }

    } else {
        // Initial form data
        $data = [
            'name' => '',
            'city' => '',
            'err' => '',
        ];

        // Load view
        $this->view('merchandiser/parkings/create', $data);
    }
}

// Remove Parking
public function parkingRemove(){
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Submitted form data
        // input data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
            'name' => trim($_POST['name']),
            'city' => trim($_POST['city'])
        ];

        // Delete the Parking
        if ($this->merchandiserModel->removeParking($data)){
            redirect('merchandiser/parkings');
        } else {
            die('Something went wrong');
        }
    }
}

// Update Parking
public function parkingUpdateForm(){
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $data = [
            'name' => trim($_POST['name']),
            'city' => trim($_POST['city']),
            'err' => ''
        ];
        $this->view('merchandiser/parkings/update', $data);
    }
}

public function parkingUpdate(){
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Submitted form data
        // input data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
            'name' => trim($_POST['name']),
            'old_name' => trim($_POST['old_name']),
            'city' => trim($_POST['city']),
            'old_city' => trim($_POST['old_city']),
            'err' => ''
        ];

        // Validate data
        // Validate email
        if (empty($data['name'])){
            $data['err'] = 'Please enter name';
        } else {
            // Check name
            if ($this->merchandiserModel->findParkingByName($data['name']) and $data['name'] != $data['old_name']){
                $data['err'] = 'Name cannot be duplicate';
            }
        }

        if (empty($data['city'])){
            $data['err'] = 'Please enter city';
        } else {
            // Check city
            if ($this->merchandiserModel->findParkingByName($data['city']) and $data['city'] != $data['old_city']){
                $data['err'] = 'City cannot be duplicate';
            }
        }

        // Validation is completed and no error found
        if (empty($data['err'])){
            // Register parking
            print_r($_SESSION['user_id']);
            if ($this->merchandiserModel->updateParking($data)){
                redirect('merchandiser/parkings');
            } else {
                die('Something went wrong');
            }
        } else {
            // Load view with errors
            $this->view('merchandiser/parkings/update', $data);
        }
    }
}

}