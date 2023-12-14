<?php
class Driver extends Controller {
    public function __construct(){
        $this->middleware = new AuthMiddleware();
        // Only drivers are allowed to access driver pages
        $this->middleware->checkAccess(['driver']);
        $this->driverModel = $this->model('DriverModel');
        $this->landModel = $this->model('LandModel');
        $this->vehicleLandModel = $this->model('VehicleLandModel');
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

    // ------------------------ After Select Location ------------------------
    public function afterSelectLocation(){
        $vehicles = $this->driverModel->viewVehicles();

        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('driver/afterSelectLocation', $vehicles, $other_data);
    }

    // ------------------------ Scan QR Code ------------------------
    public function scanQRCode(){
        $vehicles = $this->driverModel->viewVehicles();

        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('driver/scanQRCode', $vehicles, $other_data);
    }

    
    // ------------------------ Enter Parking ------------------------
    public function enterParking(){
        $vehicles = $this->driverModel->viewVehicles();

        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('driver/enterParking', $vehicles, $other_data);
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