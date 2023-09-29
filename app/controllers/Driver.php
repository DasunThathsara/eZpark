<?php
class Driver extends Controller {
    public function __construct(){
        $this->middleware = new AuthMiddleware();
        // Only drivers are allowed to access driver pages
        $this->middleware->checkAccess(['driver']);
        $this->driverModel = $this->model('DriverModel');
    }

    public function index(){
        $data = [
            'title' => 'Home page'
        ];
        $this->view('driver/index', $data);
    }

    public function vehicles(){
        $data = [
            'title' => 'Vehicles'
        ];

        $this->view('driver/vehicles', $data);
    }

    public function vehicleRegister(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'vehicle_type' => trim($_POST['vehicle_type']),
                'err' => ''
            ];

            // Validate data
            // Validate email
            if (empty($data['name'])){
                $data['err'] = 'Please enter name';
            } else {
                // Check name
                if ($this->driverModel->findVehicleByName($data['name'])){
                    $data['err'] = 'Name cannot be duplicate';
                }
            }

            // Validate user type
            if (empty($data['vehicle_type'])){
                $data['err'] = 'Please select vehicle type';
            }

            // Validation is completed and no error found
            if (empty($data['err'])){
                // Register vehicle
                print_r($data);
                print_r($_SESSION['user_id']);
                if ($this->driverModel->registerVehicle($data)){
                    redirect('driver/vehicles');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('driver/vehicles/create', $data);
            }

        } else {
            // Initial form data
            $data = [
                'name' => '',
                'vehicle_type' => '',
                'err' => '',
            ];

            // Load view
            $this->view('driver/vehicles/create', $data);
        }
    }
}