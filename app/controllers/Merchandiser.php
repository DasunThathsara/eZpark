<?php
class Merchandiser extends Controller {
    public function __construct(){
        $this->middleware = new AuthMiddleware();
        // Only merchandiser personnel are allowed to access merchandiser pages
        $this->middleware->checkAccess(['merchandiser']);
        $this->merchandiserModel = $this->model('MerchandiserModel');
        $this->landModel = $this->model('LandModel');
        $this->securityModel = $this->model('SecurityModel');
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

        $this->view('merchandiser/index', $data, $lands);
    }

        // --------------------------------------- Lands ---------------------------------------
    // View all lands
    public function lands(){
        $lands = $this->landModel->viewLands();

        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('merchandiser/lands', $lands, $other_data);
    }

    // Go to specific land
    public function gotoLand($land_ID = null){
        $data = [
            'id' => $land_ID,
            'name' => $this->landModel->getLandName($land_ID),
        ];

        $lands = $this->landModel->viewLands();

        $lands['notification_count'] = 0;

        if ($lands['notification_count'] < 10)
            $lands['notification_count'] = '0'.$lands['notification_count'];

        $data = [
            'id' => $land_ID,
            'name' => $this->landModel->getLandName($land_ID),
            // 'package_count' => $this->merchandiserModel->getPackageCount($data),
            'land_count' => $this->landModel->getLandCount($data),
            'security_count' => $this->securityModel->getSecurityCount($land_ID),
            'availability' => $this->landModel->getAvailability($land_ID),
            'capacity' => $this->landModel->getCapacity($land_ID),
        ];

        $this->view('merchandiser/land', $data, $lands);
    }

        // --------------------------------- Parking Capacity ----------------------------------
    // View all packages
    public function parkingCapacity($parking_ID = null, $parking_name = null){
        $lands = $this->landModel->viewLands();

        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('merchandiser/capacity', $lands, $other_data);
    }

        // -------------------------------------- Report ---------------------------------------
        public function viewReport(){
            $data = [
                'title' => 'Home page'
            ];
    
            $other_data['notification_count'] = 0;
    
            if ($other_data['notification_count'] < 10)
                $other_data['notification_count'] = '0'.$other_data['notification_count'];
    
            $this->view('merchandiser/report', $data, $other_data);
        }

            // ------------------------------------ Securities -------------------------------------
    // View all securities
    public function securities($landID){
        $data = [
            'id' => $landID
        ];

        $other_data = $this->securityModel->viewSecurities($landID);

        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('merchandiser/securities', $data, $other_data);
    }

}