<?php
class Security extends Controller {
    public function __construct(){
        $this->middleware = new AuthMiddleware();
        // Only security personnel are allowed to access security pages
        $this->middleware->checkAccess(['security']);
        $this->landModel = $this->model('LandModel');
        $this->securityModel = $this->model('SecurityModel');
        $this->userModel = $this->model('UserModel');
        $this->parkingOwnerModel = $this->model('ParkingOwnerModel');
    }

    public function index(){

        $land_ID = $this->securityModel->getAssignedLandID();

        if (empty($land_ID)){
            $notifications['notification_count'] = $this->userModel->getNotificationCount();
    
            if ($notifications['notification_count'] < 10)
                $notifications['notification_count'] = '0'.$notifications['notification_count'];


            $data = [
                'id' => 0,
                'name' => 0,
                'package_count' => 0,
                'land_count' => 0,
                'availability' => 0,
                'capacity' => 0
            ];
        }
        else{
            $data = [
                'id' => $land_ID,
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
                'availability' => $this->landModel->getAvailability($land_ID),
                'capacity' => $this->landModel->getCapacity($land_ID)
            ];
        }
        
        // die(print_r($data));
        $this->view('security/index', $data, $notifications);
    }

    // Add security
    public function securitySearch($landID = null){
        $data = [
            'id' => $landID
        ];

        $other_data = $this->securityModel->viewAllSecurities();

        // die(print_r($other_data));

        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('security/securityRegister', $data, $other_data);
    }

    // View land request
    public function viewRequests(){
        $data = $this->securityModel->viewLandRequest();

        // die(print_r($data));

        $notifications['list'] = $this->userModel->viewNotifications();
        $notifications['notification_count'] = $this->userModel->getNotificationCount();

        if ($notifications['notification_count'] < 10)
            $notifications['notification_count'] = '0'.$notifications['notification_count'];

        $this->view('security/viewRequests', $data, $notifications);
    }

    // View requested land details 
    public function viewLand($landID = null, $notificationID = null){
        // Mark notification as read
        if ($notificationID != null)
            $this->userModel->markAsRead($notificationID);

        // Get land details
        $data = $this->landModel->viewLand($landID);
        $data->assignedLand = $this->securityModel->getAssignedLandID();

        $notifications['list'] = $this->userModel->viewNotifications();
        $notifications['notification_count'] = $this->userModel->getNotificationCount();

        if ($notifications['notification_count'] < 10)
            $notifications['notification_count'] = '0'.$notifications['notification_count'];

        $this->view('security/viewRequestedLand', $data, $notifications);
    }

    // Accept land request
    public function acceptLandRequest(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $this->securityModel->acceptLandRequest($_POST['id'] , $this->landModel->getLandOwnerID($_POST['id']));

            // die(print_r($id));
            // Send notification to the landowner
            $this->userModel->addNotification('Your request was accepted by '.$_SESSION['user_name'], 'securityRequestResult', $_SESSION['user_id'], $this->landModel->getLandOwnerID($_POST['id']));

            // redirect('security/viewLand/'.$_POST['id'].'/'.$_SESSION['user_id']);
            redirect('security/viewRequests');
        }
    }

    // Decline land request
    public function declineLandRequest(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $this->securityModel->declineLandRequest($_POST['id'], $this->landModel->getLandOwnerID($_POST['id']));
            // die(print_r($this->landModel->getLandOwnerID($_POST['id'])));

            // Send notification to the landowner
            $this->userModel->addNotification('Your request was declined by '.$_SESSION['user_name'], 'securityRequestResult', $_SESSION['user_id'], $this->landModel->getLandOwnerID($_POST['id']));

            redirect('security/viewRequests');
        }
    }

}