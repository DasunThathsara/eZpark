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

    // ------------------------ Bookings ------------------------
    public function rating(){
        $vehicles = $this->driverModel->viewVehicles();

        $this->view('driver/rating', $vehicles);
    }

    // ------------------------ Packages ------------------------
    public function packages(){
        $vehicles = $this->driverModel->viewVehicles();

        $this->view('driver/packages', $vehicles);
    }
}