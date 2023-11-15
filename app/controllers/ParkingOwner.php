<?php
class ParkingOwner extends Controller {
    public function __construct(){
        $this->middleware = new AuthMiddleware();
        // Only parkingOwner are allowed to access parkingOwner pages
        $this->middleware->checkAccess(['parkingOwner']);
        $this->parkingOwnerModel = $this->model('ParkingOwnerModel');
    }

    public function index(){
        $lands = $this->parkingOwnerModel->viewLands();
        $this->view('parkingOwner/index', $lands);
    }

    // ------------------------------ Lands ------------------------------
    // View all lands
    public function lands(){
        $lands = $this->parkingOwnerModel->viewLands();
        

        $this->view('parkingOwner/lands', $lands);
    }

    // Go to specific land
    public function gotoLand($land_ID = null, $land_name = null){
        $data = [
            'id' => $land_ID,
            'name' => $land_name
        ];

        $lands = $this->parkingOwnerModel->viewLands();

        $data = [
            'id' => $land_ID,
            'name' => $land_name,
            'package_count' => $this->parkingOwnerModel->getPackageCount($data)
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

        $this->view('parkingOwner/packages', $data, $packages);
    }
}
