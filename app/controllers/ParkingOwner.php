<?php
class ParkingOwner extends Controller {
    public function __construct(){
        $this->middleware = new AuthMiddleware();
        // Only parkingOwner are allowed to access parkingOwner pages
        $this->middleware->checkAccess(['parkingOwner']);
        $this->parkingOwnerModel = $this->model('ParkingOwnerModel');
        $this->landModel = $this->model('LandModel');
    }

    public function index(){
        $lands = $this->landModel->viewLands();

        $data = [
            'land_count' => $this->landModel->getLandCount(),
            'total_capacity' => $this->landModel->getTotalCapacity()
        ];

        $lands['notification_count'] = 0;

        if ($lands['notification_count'] < 10)
            $lands['notification_count'] = '0'.$lands['notification_count'];

        $this->view('parkingOwner/index', $data, $lands);
    }

    // ------------------------------ Lands ------------------------------
    // View all lands
    public function lands(){
        $lands = $this->landModel->viewLands();

        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('parkingOwner/lands', $lands, $other_data);
    }

    // Go to specific land
    public function gotoLand($land_ID = null, $land_name = null){
        $data = [
            'id' => $land_ID,
            'name' => $land_name
        ];

        $lands = $this->landModel->viewLands();

        $lands['notification_count'] = 0;

        if ($lands['notification_count'] < 10)
            $lands['notification_count'] = '0'.$lands['notification_count'];

        $data = [
            'id' => $land_ID,
            'name' => $land_name,
            'package_count' => $this->parkingOwnerModel->getPackageCount($data),
            'land_count' => $this->landModel->getLandCount($data)
        ];

        $this->view('parkingOwner/land', $data, $lands);
    }

    // ----------------------------- Packages -----------------------------
    // View all packages
    public function packages($parking_ID = null, $parking_name = null){
        $data = [
            'id' => $parking_ID,
            'name' => $parking_name
        ];

        $packages = $this->parkingOwnerModel->viewPackages($data);

        $packages['notification_count'] = 0;

        if ($packages['notification_count'] < 10)
            $packages['notification_count'] = '0'.$packages['notification_count'];

        $this->view('parkingOwner/packages', $data, $packages);
    }

    // ----------------------------- Parking Capacity -----------------------------
    // View all packages
    public function parkingCapacity($parking_ID = null, $parking_name = null){
        $lands = $this->landModel->viewLands();

        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('parkingOwner/capacity', $lands, $other_data);
    }

    // -------------------------- Report ---------------------------
    public function viewReport(){
        $data = [
            'title' => 'Home page'
        ];
        $this->view('parkingOwner/report', $data);
    }
}
