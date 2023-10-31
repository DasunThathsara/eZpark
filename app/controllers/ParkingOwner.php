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

    // Register Land
    public function LandRegister(){
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

            // Validation is completed and no error found*/
            if (empty($data['err'])){
                // Register land
                print_r($data);
                print_r($_SESSION['user_id']);
                if ($this->parkingOwnerModel->registerLand($data)){
                    redirect('parkingOwner/lands');
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
                'err' => '',
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
                'city' => trim($_POST['city'])
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
        $lands = $this->parkingOwnerModel->viewLands();

        $this->view('parkingOwner/packages', $lands);
    }

}