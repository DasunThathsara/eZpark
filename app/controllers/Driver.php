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
        $vehicles = $this->driverModel->viewVehicles();

        $this->view('driver/vehicles', $vehicles);
    }

    // ------------------------ Bookings ------------------------
    public function booking(){
        $vehicles = $this->driverModel->viewVehicles();

        $this->view('driver/booking', $vehicles);
    }

    // ------------------------ Search ------------------------
    public function search(){
        $vehicles = $this->driverModel->viewVehicles();

        $this->view('driver/search', $vehicles);
    }

    // ------------------------ History ------------------------
    public function history(){
        $vehicles = $this->driverModel->viewVehicles();

        $this->view('driver/history', $vehicles);
    }

    // ------------------------ Rating ------------------------
    public function rating(){
        $vehicles = $this->driverModel->viewVehicles();

        $this->view('driver/rating', $vehicles);
    }

    // ------------------------ Packages ------------------------
    public function packages(){
        $vehicles = $this->driverModel->viewVehicles();

        $this->view('driver/packages', $vehicles);
    }

           // ------------------------ Direction To Parking ------------------------
    public function directionToParking(){
        $vehicles = $this->driverModel->viewVehicles();

        $this->view('driver/directionToParking', $vehicles);
    }

       // ------------------------ After Select Location ------------------------
    public function afterSelectLocation(){
        $vehicles = $this->driverModel->viewVehicles();

        $this->view('driver/afterSelectLocation', $vehicles);
    }

               // ------------------------ Scan QR Code ------------------------
    public function scanQRCode(){
        $vehicles = $this->driverModel->viewVehicles();

        $this->view('driver/scanQRCode', $vehicles);
    }

    
                   // ------------------------ Enter Parking ------------------------
    public function enterParking(){
        $vehicles = $this->driverModel->viewVehicles();

        $this->view('driver/enterParking', $vehicles);
    }
    
                    // ------------------------ Start Time ------------------------
    public function startTime(){
        $vehicles = $this->driverModel->viewVehicles();
                        
        $this->view('driver/startTime', $vehicles);
    }

                        // ------------------------ Scan QR Code To Exit ------------------------
    public function scanQRCodeToExit(){
        $vehicles = $this->driverModel->viewVehicles();
                        
        $this->view('driver/scanQRCodeToExit', $vehicles);
    }
    
}