<?php
class Merchandiser extends Controller {
    public function __construct(){
        $this->middleware = new AuthMiddleware();
        // Only merchandiser personnel are allowed to access merchandiser pages
        $this->middleware->checkAccess(['merchandiser']);
        $this->merchandiserModel = $this->model('MerchandiserModel');
        $this->landModel = $this->model('LandModel');
        $this->securityModel = $this->model('SecurityModel');
        $this->userModel = $this->model('UserModel');

    }

    public function index(){
        $lands = $this->landModel->viewLands();

        $data = [
            'land_count' => $this->landModel->getLandCount(),
            'total_capacity' => $this->landModel->getTotalCapacity(),
            'today_total_transactions' => $this->landModel->getTodayTotalTransactions(),    // Add this line
            'total_income' => $this->landModel->getTotalIncome()
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
            'today_transactions' => $this->landModel->getTodayTransactions($land_ID),
            'total_income' => $this->landModel->getTotalParkingIncome($land_ID),
            'income_distribution' => $this->landModel->getIncomeDistribution($land_ID),
            'vehicle_distribution' => $this->landModel->getVehicleDistribution($land_ID)
        ];

        $this->view('merchandiser/land', $data, $lands);
    }

        // --------------------------------- Parking Capacity ----------------------------------
    // View capacity
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

        $securityDetails = $this->securityModel->viewSecurities($landID);

        $data['securityDetails'] = $securityDetails;
        
        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('merchandiser/securities', $data, $other_data);
    }

    // remove assinged security
    public function securityRemove(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $land_ID = $_POST['land_id'];
            $sec_id = $_POST['sec_id'];

            $this->merchandiserModel->securityRemove($sec_id , $land_ID);

            // Send notification to the landowner
            // $this->userModel->addNotification('You unassigned from the land was declined by '.$_SESSION['user_name'], 'parkingownerUnassignFromLand', $this->landModel->getLandOwnerID($_POST['id']), $this->landModel->getLandOwnerID($_POST['id']));

            redirect('merchandiser/securities/'.$land_ID);
        }
    }

    public function landAccessControl($sec_id = null){
        if ($_SERVER['REQUEST_METHOD'] == 'GET'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // die(print_r($land_ID));

            if ($this->merchandiserModel->landAccessControl($sec_id)){
                $land_ID = $_GET['land_id'];
                redirect($_SESSION['userType'].'/securities/'.$land_ID);
            } else {
                die('Something went wrong');
            }
        }
    } 

}