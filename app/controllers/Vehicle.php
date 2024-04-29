<?php
class Vehicle extends Controller
{
    public function __construct()
    {
        $this->middleware = new AuthMiddleware();
        // Only drivers are allowed to access driver pages
        $this->middleware->checkAccess(['driver']);
        $this->driverModel = $this->model('DriverModel');
    }

    // Register Vehicle
    public function vehicleRegister()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'vehicle_type' => trim($_POST['vehicle_type']),
                'vehicle_number' => trim($_POST['vehicle_number']),
                'err' => ''
            ];

            // Validate data
            // Validate name
            if (empty($data['name'])) {
                $data['err'] = 'Please enter name';
            } else {
                // Check name
                if ($this->driverModel->findVehicleByName($data['name'])) {
                    $data['err'] = 'Name cannot be duplicate';
                }
            }

            // Validate vehicle number
            if (empty($data['vehicle_number'])) {
                $data['err'] = 'Please enter vehicle number';
            } else {
                // Check vehicle_number
                if ($this->driverModel->findVehicleByNumber($data['vehicle_number'])) {
                    $data['err'] = 'Vehicle number cannot be duplicate';
                }
            }

            // Validate user type
            if (empty($data['vehicle_type'])) {
                $data['err'] = 'Please select vehicle type';
            } else if ($data['vehicle_type'] != 'car' and $data['vehicle_type'] != 'bike' and $data['vehicle_type'] != 'threeWheel') {
                $data['err'] = 'Invalid vehicle type';
            }

            // Validation is completed and no error found
            if (empty($data['err'])) {
                // Register vehicle
                print_r($data);
                print_r($_SESSION['user_id']);
                if ($this->driverModel->registerVehicle($data)) {
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

    // Remove Vehicle
    public function vehicleRemove()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name'])
            ];

            // Delete the vehicle
            if ($this->driverModel->removeVehicle($data)) {
                redirect('driver/vehicles');
            } else {
                die('Something went wrong');
            }
        }
    }

    // Update Vehicle
    public function vehicleUpdateForm()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $data = [
                'name' => trim($_POST['name']),
                'vehicle_type' => trim($_POST['vehicle_type']),
                'err' => ''
            ];
            $this->view('driver/vehicles/update', $data);
        }
    }

    public function vehicleUpdate(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'old_name' => trim($_POST['old_name']),
                'vehicle_type' => trim($_POST['vehicle_type']),
                'err' => ''
            ];

            // Validate data
            // Validate email
            if (empty($data['name'])) {
                $data['err'] = 'Please enter name';
            } else {
                // Check name
                if ($this->driverModel->findVehicleByName($data['name']) and $data['name'] != $data['old_name']) {
                    $data['err'] = 'Name cannot be duplicate';
                }
            }

            // Validate user type
            if (empty($data['vehicle_type'])) {
                $data['err'] = 'Please select vehicle type';
            } else if ($data['vehicle_type'] != 'car' and $data['vehicle_type'] != 'bike' and $data['vehicle_type'] != '3wheel') {
                $data['err'] = 'Invalid vehicle type' . $data['vehicle_type'];
            }

            // Validation is completed and no error found
            if (empty($data['err'])) {
                // Register vehicle
                print_r($_SESSION['user_id']);
                if ($this->driverModel->updateVehicle($data)) {
                    redirect('driver/vehicles');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('driver/vehicles/update', $data);
            }
        }
    }

}
