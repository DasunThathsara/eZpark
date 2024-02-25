<?php
class Driver extends Controller {
    public function __construct(){
        $this->middleware = new AuthMiddleware();
        // Only drivers are allowed to access driver pages
        $this->middleware->checkAccess(['driver']);
        $this->driverModel = $this->model('DriverModel');
        $this->landModel = $this->model('LandModel');
        $this->vehicleLandModel = $this->model('VehicleLandModel');
        $this->userModel = $this->model('UserModel');
    }

    public function index(){
        $data = $this->landModel->viewAllLands();

        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('driver/index', $data, $other_data);
    }

    public function vehicles(){
        $vehicles = $this->driverModel->viewVehicles();

        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('driver/vehicles', $vehicles, $other_data);
    }

    // ------------------------ Bookings ------------------------
    public function booking(){
        $vehicles = $this->driverModel->viewVehicles();

        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('driver/booking', $vehicles, $other_data);
    }

    // ------------------------ Search ------------------------
    public function search(){
        $vehicles = $this->driverModel->viewVehicles();

        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('driver/search', $vehicles, $other_data);
    }

    // ------------------------ History ------------------------
    public function history(){
        $vehicles = $this->driverModel->viewVehicles();

        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('driver/history', $vehicles, $other_data);
    }

    // ------------------------ Rating ------------------------
    public function rating(){
        $vehicles = $this->driverModel->viewVehicles();

        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('driver/rating', $vehicles, $other_data);
    }

    // ------------------------ Packages ------------------------
    public function packages(){
        $vehicles = $this->driverModel->viewVehicles();

        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('driver/packages', $vehicles, $other_data);
    }

    // ------------------------ Direction To Parking ------------------------
    public function directionToParking(){
        $vehicles = $this->driverModel->viewVehicles();

        $this->view('driver/directionToParking', $vehicles);
    }

    // Go to specific land
    public function gotoLand($land_ID = null){
        $data = [
            'id' => $land_ID,
            'name' => $this->landModel->getLandName($land_ID),
        ];

        $land = $this->landModel->viewLand($land_ID);

        $notifications['list'] = $this->userModel->viewNotifications();
        $notifications['notification_count'] = $this->userModel->getNotificationCount();

        if ($notifications['notification_count'] < 10)
            $notifications['notification_count'] = '0'.$notifications['notification_count'];


        $this->view('driver/viewParking', $land, $notifications);
    }

    // Start and stop timer
    public function enterExitParking($land_ID = null){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => $_POST['id']
            ];
            
        }
        else{
            $data = [
                'id' => $land_ID
            ];
        }

        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0' . $other_data['notification_count'];

        $lands = $this->landModel->viewLand($land_ID);

        // Check parking status of the driver
        $parking_status = $this->driverModel->checkParkingStatus($data['id']);

        if($parking_status){
            // If the driver is already parked, then exit the parking
            $this->driverModel->exitParking($data);
            redirect('driver/index');
        }
        else{
            // If the driver is not parked, then select the vehicle type
            $this->view('driver/enterExitParking/vehicleTypeSelection', $data, $other_data);
        }
    }

    // Enter parking
    public function enterParking(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $land_ID = $_POST['id'];
            $vehicle_type = $_POST['vehicle_type'];

            $this->driverModel->enterParking($land_ID, $vehicle_type);
            redirect('driver/index');
        }
    }


    // ------------------------ Scan QR Code ------------------------
    public function scanQRCode(){
        $vehicles = $this->driverModel->viewVehicles();

        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('driver/scanQRCode', $vehicles, $other_data);
    }
    
    // ------------------------ Start Time ------------------------
    public function startTime(){
        $vehicles = $this->driverModel->viewVehicles();

        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('driver/startTime', $vehicles, $other_data);
    }

    // ------------------------ Scan QR Code To Exit ------------------------
    public function scanQRCodeToExit(){
        $vehicles = $this->driverModel->viewVehicles();

        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('driver/scanQRCodeToExit', $vehicles, $other_data);
    }
    
    // ------------------------ Parking Fee ------------------------
    public function parkingFee(){
        $vehicles = $this->driverModel->viewVehicles();

        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('driver/parkingFee', $vehicles, $other_data);
    }

    
    // ------------------------ Online Payment ------------------------
    public function onlinePayment(){
        $vehicles = $this->driverModel->viewVehicles();

        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('driver/onlinePayment', $vehicles, $other_data);
    } 

    
    // ------------------------ Payment Successful ------------------------
    public function paymentSuccessful(){
        $vehicles = $this->driverModel->viewVehicles();

        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('driver/paymentSuccessful', $vehicles, $other_data);
    } 
}