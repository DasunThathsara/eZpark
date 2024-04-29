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
        $this->driverModel = $this->model('DriverModel');
        $this->chatModel = $this->model('ChatModel');
        $this->parkingOwnerModel = $this->model('ParkingOwnerModel');

    }

    public function index(){
        $lands = $this->landModel->viewLands();

        $data = [
            'land_count' => $this->landModel->getLandCount(),
            'total_capacity' => $this->landModel->getTotalCapacity(),
            'today_total_transactions' => $this->landModel->getTodayTotalTransactions(),    // Add this line
            'total_income' => $this->landModel->getTotalIncome(),
            'total_income_distribution' => $this->landModel->getTotalIncomeDistribution(),
            'total_vehicle_distribution' => $this->landModel->getTotalVehicleDistribution()
        ];

        // die(print_r($data));

         $lands['notification_count'] = $this->userModel->getNotificationCount();
        // $lands['list'] = $this->userModel->getNotificationCount();
        // $lands['notification_count'] = $this->userModel->getNotificationCount();      //changed

        if ($lands['notification_count'] < 10)
            $lands['notification_count'] = '0'.$lands['notification_count'];

        //$data['lands'] = $lands;

        $this->view('merchandiser/index', $data, $lands);   //changed
    }

        // --------------------------------------- Lands ---------------------------------------
    // View all lands
    public function lands(){
        $lands = $this->landModel->viewLands();

        $other_data['notification_count'] = $this->userModel->getNotificationCount();
        //$notifications['list'] = $this->userModel->getNotificationCount();
        //$notifications['notification_count'] = $this->userModel->getNotificationCount();
        //$other_data['list'] = $this->userModel->getNotificationCount();
        //$other_data['notification_count'] = $this->userModel->getNotificationCount();

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

        $lands['notification_count'] = $this->userModel->getNotificationCount();
        

        

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
            'vehicle_distribution' => $this->landModel->getVehicleDistribution($land_ID),
            'land_images' =>$this->landModel->getLandImages($land_ID),
            'reviewsAndComplaints_count' => $this->landModel->getReviewsAndComplaintsCount($land_ID),
            'rating_count' => $this->landModel->getAvgRatingCount($land_ID)
        ];

        $this->view('merchandiser/land', $data, $lands);
    }

        // --------------------------------- Parking Capacity ----------------------------------
    // View capacity
    public function parkingCapacity($parking_ID = null, $parking_name = null){
        $lands = $this->landModel->viewLands();

        $other_data['notification_count'] = $this->userModel->getNotificationCount();

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('merchandiser/capacity', $lands, $other_data);
    }

        // -------------------------------------- Report ---------------------------------------
    public function viewReport($land_ID = null){
        $data = [
            'title' => 'Home page',
            'landID' => $land_ID,
            'lands' => $this->landModel->viewLands()
        ];

        $other_data['notification_count'] = $this->userModel->getNotificationCount();

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

            // echo "<pre>";
            // die(print_r($data));
            // echo "</pre>";

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
        
        $other_data['notification_count'] = $this->userModel->getNotificationCount();

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

    // Search parking
    public function findParking(){
        $lands = $this->landModel->viewAllLands();

        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('merchandiser/searchParking', $lands, $other_data);
    }

    // View parking
    public function viewParking($land_ID = null, $mergedLandID = null){
        if($mergedLandID == null){
            $data['id'] = $land_ID;
            $land = $this->landModel->viewLand($land_ID);
            $land->packages = $this->driverModel->viewPackages($data);

            $land->freeSLots = $this->landModel->getFreeSlots($land_ID);

            $land->baseLands = $this->landModel->viewAllLandsByUserID();

            $land->landID = $land_ID;

            $notifications['list'] = $this->userModel->viewNotifications();
            $notifications['notification_count'] = $this->userModel->getNotificationCount();

            if ($notifications['notification_count'] < 10)
                $notifications['notification_count'] = '0'.$notifications['notification_count'];

            $this->view('merchandiser/viewParking', $land, $notifications);
        }
        else{
            $data['id'] = $land_ID;
            $land_ID = $mergedLandID;
            $mergedLandID = $data['id'];
            $data['id'] = $mergedLandID;
            $land = $this->landModel->viewLand($land_ID);
            $land->packages = $this->driverModel->viewPackages($data);

            $land->freeSLots = $this->landModel->getFreeSlots($land_ID);

            $land->baseLands = $this->landModel->viewAllLandsByUserID();

            $land->mergedLandID = $mergedLandID;

            $notifications['list'] = $this->userModel->viewNotifications();
            $notifications['notification_count'] = $this->userModel->getNotificationCount();

            if ($notifications['notification_count'] < 10)
                $notifications['notification_count'] = '0'.$notifications['notification_count'];

            $this->view('merchandiser/viewParkingRequest', $land, $notifications);
        }
    }

    // Send request to merge parking
    public function requestParking(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $land_ID = $_POST['landID'];
            $baseLandID = $_POST['baseLandID'];
            $duration = $_POST['duration'];

            $mergeID = $this->merchandiserModel->mergeParking($land_ID, $baseLandID, $duration);

            // Send notification to the landowner
            $this->userModel->addNotification('You have a request to merge your parking with another parking', 'parkingMergeRequest', $this->landModel->getLandOwnerID($baseLandID), $this->landModel->getLandOwnerID($land_ID), $mergeID);

            redirect('merchandiser/viewParking/'.$land_ID);
        }
    }

    public function viewAllLandsByusdrID(){
        $lands = $this->landModel->viewAllLandsByusdrID();

        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('merchandiser/lands', $lands, $other_data);
    }

    public function confirmRequestParking(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $BaseLandID = $_POST['otherBaseLandID'];
            $mergeID = $_POST['mergeID'];

            $mergeDetails = $this->parkingOwnerModel->getMergeDetails($mergeID);

            $this->chatModel->createChat((int)$_SESSION['user_id'], (int)$this->landModel->getLandOwnerID($mergeDetails->landID));

            $this->merchandiserModel->confirmMergeParking($mergeID);

            redirect('chat/viewChat/');
        }
    }
}