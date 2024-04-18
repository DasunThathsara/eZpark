<?php
class ParkingOwner extends Controller {
    public function __construct(){
        $this->middleware = new AuthMiddleware();
        // Only parkingOwner are allowed to access parkingOwner pages
        $this->middleware->checkAccess(['parkingOwner']);
        $this->parkingOwnerModel = $this->model('ParkingOwnerModel');
        $this->landModel = $this->model('LandModel');
        $this->securityModel = $this->model('SecurityModel');
        $this->userModel = $this->model('UserModel');
    }

    public function index(){
        $lands = $this->landModel->viewLands();

        $data = [
            'land_count' => $this->landModel->getLandCount(),
            'total_capacity' => $this->landModel->getTotalCapacity(),
            'today_total_transactions' => $this->landModel->getTodayTotalTransactions(),
            'total_income' => $this->landModel->getTotalIncome()
        ];

        $notifications['list'] = $this->userModel->viewNotifications();
        $notifications['notification_count'] = $this->userModel->getNotificationCount();

        if ($notifications['notification_count'] < 10)
            $notifications['notification_count'] = '0'.$notifications['notification_count'];

        $notifications['lands'] = $lands;

        $this->view('parkingOwner/index', $data, $notifications);
    }

    // --------------------------------------- Lands ---------------------------------------
    // View all lands
    public function lands(){
        $lands = $this->landModel->viewLands();

        $notifications['list'] = $this->userModel->viewNotifications();
        $notifications['notification_count'] = $this->userModel->getNotificationCount();

        if ($notifications['notification_count'] < 10)
            $notifications['notification_count'] = '0'.$notifications['notification_count'];

        $this->view('parkingOwner/lands', $lands, $notifications);
    }

    // Go to specific land
    public function gotoLand($land_ID = null){
        $data = [
            'id' => $land_ID,
            'name' => $this->landModel->getLandName($land_ID)
        ];

        $notifications['lands'] = $this->landModel->viewLands();

        $notifications['list'] = $this->userModel->viewNotifications();
        $notifications['notification_count'] = $this->userModel->getNotificationCount();

        if ($notifications['notification_count'] < 10)
            $notifications['notification_count'] = '0'.$notifications['notification_count'];

        $data = [
            'id' => $land_ID,
            'name' => $this->landModel->getLandName($land_ID),
            'package_count' => $this->parkingOwnerModel->getPackageCount($data),
            'land_count' => $this->landModel->getLandCount($data),
            'security_count' => $this->securityModel->getSecurityCount($land_ID),
            'availability' => $this->landModel->getAvailability($land_ID),
            'capacity' => $this->landModel->getCapacity($land_ID),
            'today_transactions' => $this->landModel->getTodayTransactions($land_ID),
            'total_income' => $this->landModel->getTotalParkingIncome($land_ID),
            'income_distribution' => $this->landModel->getIncomeDistribution($land_ID),
            'vehicle_distribution' => $this->landModel->getVehicleDistribution($land_ID)
        ];

        $this->view('parkingOwner/land', $data, $notifications);
    }

    // -------------------------------------- Packages -------------------------------------
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

    // --------------------------------- Parking Capacity ----------------------------------
    // View all packages
    public function parkingCapacity($parking_ID = null, $parking_name = null){
        $lands = $this->landModel->viewLands();

        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('parkingOwner/capacity', $lands, $other_data);
    }

    // -------------------------------------- Report ---------------------------------------
    public function viewReport($land_ID = null){
        $data = [
            'title' => 'Home page',
            'landID' => $land_ID,
            'lands' => $this->landModel->viewLands()
        ];

        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

            // echo "<pre>";
            // die(print_r($data));
            // echo "</pre>";

        $this->view('parkingOwner/report', $data, $other_data);
    }

    // ------------------------------------ Securities -------------------------------------
 
    public function securities($landID){

         // Ensure $landID is valid (you may want to add further validation)
         if (!is_numeric($landID)) {
            // Handle invalid input, for example, redirect to an error page
            redirect('error');
            return;
        }

        $data = [
            'id' => $landID
        ];

        // die(print_r($securityDetails));
        // Call the SecurityModel to get security details
        $securityDetails = $this->securityModel->viewSecurities($landID);
        // You can include more data if needed
        $data['securityDetails'] = $securityDetails;

         // Example: Fetch other data needed for the view
        $other_data['notification_count'] = $this->userModel->getNotificationCount();

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('parkingOwner/securities', $data, $other_data);
    }
    
        // remove assinged security
    public function securityRemove(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $land_ID = $_POST['land_id'];
            $sec_id = $_POST['sec_id'];

            $this->ParkingOwnerModel->securityRemove($sec_id , $land_ID);

            // Send notification to the landowner
            // $this->userModel->addNotification('You unassigned from the land was declined by '.$_SESSION['user_name'], 'parkingownerUnassignFromLand', $this->landModel->getLandOwnerID($_POST['id']), $this->landModel->getLandOwnerID($_POST['id']));

            redirect('parkingOwner/securities/'.$land_ID);
        }
    }
  
    public function landAccessControl($sec_id = null){
        if ($_SERVER['REQUEST_METHOD'] == 'GET'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // die(print_r($land_ID));

            if ($this->ParkingOwnerModel->landAccessControl($sec_id)){
                $land_ID = $_GET['land_id'];
                redirect($_SESSION['userType'].'/securities/'.$land_ID);
            } else {
                die('Something went wrong');
            }
        }
    } 
}
