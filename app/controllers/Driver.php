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
        $this->parkingOwnerModel = $this->model('ParkingOwnerModel');
        $this->reservationModel = $this->model('ReservationModel');
    }

    public function index(){
        $data = $this->landModel->viewAllLands();

        $other_data['notification_count'] = $this->userModel->viewNotifications();

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('driver/index', $data, $other_data);
    }

    public function vehicles(){
        $vehicles = $this->driverModel->viewVehicles();

        $other_data['notification_count'] = $this->userModel->viewNotifications();

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('driver/vehicles', $vehicles, $other_data);
    }

    // ------------------------ Bookings ------------------------
    public function booking(){
        $reservations = $this->driverModel->getReservations();

        $other_data['notification_count'] = $this->userModel->viewNotifications();

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('driver/booking', $reservations, $other_data);
    }

    // ------------------------ History ------------------------
    public function history(){
        $history = $this->driverModel->viewHistory();

        $other_data['notification_count'] = $this->userModel->viewNotifications();

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('driver/history', $history, $other_data);
    }

    // ------------------------ recentTransaction ------------------------
    public function recentTransaction(){
        $recentTransaction = $this->driverModel->viewRecentTransaction();
// die(print_r($recentTransaction));
        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('driver/recentTransaction', $recentTransaction, $other_data);
    }


    // ------------------------ recentTransaction ------------------------
    public function updateRecentTransaction(){
        $successTransaction = $this->driverModel->updateRecentTransaction();
        // die(print_r($successTransaction));
        $other_data['notification_count'] = 0;
    
        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];
    
        redirect('driver/recentTransaction', $other_data);
    }
    


    // ------------------------ Packages ------------------------
    public function packages(){
        $packages = $this->driverModel->viewSubscribedPackages();

        $other_data['notification_count'] = $this->userModel->viewNotifications();

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('driver/packages', $packages, $other_data);
    }

    public function subscribePackage(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'landID' => trim($_POST['landID']),
                'vehicle-type' => trim($_POST['vehicleType']),
                'package-type' => trim($_POST['packageType'])
            ];
        }

        // Subscribe to package
        $this->driverModel->subscribePackage($data);

        redirect('driver/gotoLand/'.$data['landID']);
    }

    // ------------------------ Direction To Parking ------------------------
    public function directionToParking($landID = null){
        // If the land ID is not found
        if ($landID == null){
            redirect('driver/directionToParking=error');
        }

        $coordinates = $this->driverModel->getCoordinates($landID);

        // If the coordinates are not found
        if ($coordinates == null){
            redirect('driver/directionToParking=error');
        }

        $notifications['list'] = $this->userModel->viewNotifications();
        $notifications['notification_count'] = $this->userModel->getNotificationCount();

        if ($notifications['notification_count'] < 10)
            $notifications['notification_count'] = '0'.$notifications['notification_count'];


        $this->view('driver/directionToParking', $coordinates, $notifications);
    }

    // Go to specific land
    public function gotoLand($land_ID = null){
        $data['id'] = $land_ID;
        $land = $this->landModel->viewLand($land_ID);
        $land->packages = $this->driverModel->viewPackages($data);

        $land->freeSLots = $this->landModel->getFreeSlots($land_ID);

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

        $other_data['notification_count'] = $this->userModel->viewNotifications();

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0' . $other_data['notification_count'];

        $lands = $this->landModel->viewLand($land_ID);

        // Check parking status of the driver
        $parking_status = $this->driverModel->checkParkingStatus($data['id']);

        if($parking_status){
            // If the driver is already parked, then exit the parking
            $this->driverModel->exitParking($data);
            redirect('driver/index?completion_status='.$land_ID);
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

            if ($this->driverModel->getVehicleAvailability($vehicle_type) > 0){
                $this->driverModel->enterParking($land_ID, $vehicle_type);
                redirect('driver/index');
            }
            else{
                // If the vehicle is not available
                redirect('driver/gotoLand/'.$land_ID.'?error=1');
            }
        }
    }

    // Add rating, and review or complaint to the parking
    public function addRatingReviewComplaint(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'landID' => $_POST['landID'],
                'rating' => $_POST['rate'],
                'review' => $_POST['review-message'],
                'complaint' => isset($_POST['complaint']) ? 1 : 0
            ];


            if ($data['complaint'] == 1){
                // Add complaint
                $complaintID = $this->driverModel->addComplaint($data);
                if($complaintID != 0){
                    $this->userModel->addNotification('Complaint for '.$this->landModel->getLandName($data['landID']).'. Complaint: '.$data['review'], 'complaint', $_SESSION['username'], 0, $complaintID);
                    $this->userModel->addNotification('Complaint for '.$this->landModel->getLandName($data['landID']).'. Complaint: '.$data['review'], 'complaint', $_SESSION['username'], $this->landModel->getLandownerID($data['landID']), $complaintID);
                }

            }
            else{
                // Add review
                $reviewID = $this->driverModel->addReview($data);
                if ($reviewID != 0){
                    $this->userModel->addNotification($data['review'].' from '.$_SESSION['username'], 'complaint', $_SESSION['username'], $this->landModel->getLandownerID($data['landID']), $reviewID);
                }
            }

            // Add rating
            $this->driverModel->addRating($data);

            redirect('driver/index');
        }
    }


    // ------------------------ Scan QR Code ------------------------
    // Open QR scanner
    public function scanQRCode(){
        $data = [];

        $other_data['notification_count'] = $this->userModel->viewNotifications();

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('driver/scanQRCode', $data, $other_data);
    }


    // ------------------------ Start Time ------------------------

    // ------------------------ Scan QR Code To Exit ------------------------

    // ------------------------ Parking Fee ------------------------

    // ------------------------ Online Payment ------------------------

    // ------------------------ Payment Successful ------------------------
    public function paymentSuccessful(){
        $vehicles = $this->driverModel->viewVehicles();

        $other_data['notification_count'] = $this->userModel->viewNotifications();

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('driver/paymentSuccessful', $vehicles, $other_data);
    }

    // ------------------------ Reservation ------------------------
    public function makeReservation($landID = null){
        if($landID == null && !isset($_POST['landID'])){
            redirect('page/404');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Submitted form data

            $other_data['notification_count'] = $this->userModel->viewNotifications();

            if ($other_data['notification_count'] < 10)
                $other_data['notification_count'] = '0'.$other_data['notification_count'];


            $data = [
                'landID' => trim($_POST['landID']),
                'vehicles' => $this->driverModel->viewVehicles(),
                'startDate' => trim($_POST['reservationSDate']),
                'startTime' => trim($_POST['reservationSTime']),
                'endDate' => trim($_POST['reservationEDate']),
                'endTime' => trim($_POST['reservationETime']),
                'vehicleNumber' => trim($_POST['vehicleNumber']),
                'err' => ''
            ];

            if (empty($data['startDate'])){
                $data['err'] = 'Please select a start date';
            }

            if (empty($data['startTime'])){
                $data['err'] = 'Please select a start time';
            }

            if (empty($data['endDate'])){
                $data['err'] = 'Please select an end date';
            }

            if (empty($data['endTime'])){
                $data['err'] = 'Please select an end time';
            }

            if (empty($data['vehicleNumber'])){
                $data['err'] = 'Please select a vehicle';
            }

            // Check start date and time < end date and time
            if (strtotime($data['startDate'].' '.$data['startTime']) > strtotime($data['endDate'].' '.$data['endTime'])){
                $data['err'] = 'End date and time should be greater than start date and time';
            }

            // Check start date and time > current date and time
            if (strtotime($data['startDate'].' '.$data['startTime']) < time()){
                $data['err'] = 'Start date and time should be greater than current date and time';
            }

            $slotCount = $this->driverModel->getVehicleCapacityByType($_POST['landID'], $this->driverModel->getVehicleTypeByNumber($data['vehicleNumber']));

            // Check given time slot is already reserved
            $slotID = 0;
            for($slot = 1; $slot <= $slotCount; $slot++){
                $flag = 0;
                $reservations = $this->reservationModel->viewReservationBySlotID($slot, $data['landID'], $data['startDate'], $this->driverModel->getVehicleTypeByNumber($data['vehicleNumber']));

                foreach ($reservations as $reservation){
                    if (strtotime($data['startDate'].' '.$data['startTime']) >= strtotime($reservation->startTime) && strtotime($data['endDate'].' '.$data['endTime']) <= strtotime($reservation->expectedEndTime)){
                        $flag = 1;
                        break;
                    }

                    else if (strtotime($data['startDate'].' '.$data['startTime']) >= strtotime($reservation->startTime) && strtotime($data['startDate'].' '.$data['startTime']) <= strtotime($reservation->expectedEndTime)){
                        $flag = 1;
                        break;
                    }

                    else if (strtotime($data['endDate'].' '.$data['endTime']) >= strtotime($reservation->startTime) && strtotime($data['endDate'].' '.$data['endTime']) <= strtotime($reservation->expectedEndTime)){
                        $flag = 1;
                        break;
                    }

                    if (strtotime($data['startDate'].' '.$data['startTime']) <= strtotime($reservation->startTime) && strtotime($data['endDate'].' '.$data['endTime']) >= strtotime($reservation->expectedEndTime)){
                        $flag = 1;
                        break;
                    }
                }

                if ($flag == 0){
                    $slotID = $slot;
                    break;
                }
            }

            if ($flag == 1){
                $data['err'] = 'This time slot is already reserved';
            }

            if(empty($data['err'])){
                if($this->reservationModel->makeReservation($data, $slotID)){
                    redirect('driver/makeReservation/'.$data['landID']);
                }
                else{
                    $data['err'] = 'Something went wrong';
                    $this->view('driver/makeReservation', $data, $other_data);
                }
            }
            else {
                // Load with errors
                $this->view('driver/makeReservation', $data, $other_data);
            }
        }

        else{
            $other_data['notification_count'] = 0;

            if ($other_data['notification_count'] < 10)
                $other_data['notification_count'] = '0'.$other_data['notification_count'];

            $data = [
                'landID' => $landID,
                'vehicles' => $this->driverModel->viewVehicles(),
                'vehicle' => '',
                'reservation' => '',
                'startDate' => '',
                'startTime' => '',
                'endDate' => '',
                'endTime' => '',
                'vehicleNumber' => '',
                'err' => ''
            ];

            $this->view('driver/makeReservation', $data, $other_data);
        }
    }

    public function findReservation($landID = null){
        if($landID == null && !isset($_POST['landID'])){
            redirect('page/404');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Submitted form data

            $other_data['notification_count'] = 0;

            if ($other_data['notification_count'] < 10)
                $other_data['notification_count'] = '0'.$other_data['notification_count'];

            $data = [
                'landID' => trim($_POST['landID']),
                'reservations' => $this->reservationModel->viewReservations(trim($_POST['landID']), trim($_POST['reservationDate']), trim($_POST['vehicleType'])),
            ];

            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }
}