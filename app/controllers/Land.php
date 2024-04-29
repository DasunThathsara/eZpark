<?php

require_once APPROOT.'/libraries/phpqrcode/qrlib.php';

class Land extends Controller {
    public function __construct(){
        $this->middleware = new AuthMiddleware();
        $this->middleware->checkAccess(['parkingOwner', 'merchandiser', 'security']);
        $this->landModel = $this->model('LandModel');
        $this->securityModel = $this->model('SecurityModel');
        $this->userModel = $this->model('UserModel');
    }

    public function index(){
        $lands = $this->landModel->viewLands();
        $this->view('parkingOwner/index', $lands);
    }

    // ------------------------------ Lands ------------------------------
    public function changeAvailability($land_ID = null){
        if ($this->landModel->changeAvailability($land_ID)){
            redirect($_SESSION['userType'].'/gotoLand/'.$land_ID);
        } else {
            die('Something went wrong');
        }
    }

    public function setPriceForm(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'car' => trim($_POST['car']),
                'bike' => trim($_POST['bike']),
                'threeWheel' => trim($_POST['threeWheel']),
                'err' => ''
            ];

            // Validate data
            if (empty($data['car'])){
                $data['err'] = 'Please enter car';
            } else if (!preg_match('/^[1-9]\d*(\.\d+)?$/', $data['car'])){
                $data['err'] = 'Invalid data type for cars';
            }else if( ($data['car']) < 0){
                $data['err'] = 'Price must be positive';
            }

            if (empty($data['bike'])){
                $data['err'] = 'Please enter bike';
            } else if (!preg_match('/^[1-9]\d*(\.\d+)?$/', $data['bike'])){
                $data['err'] = 'Invalid data type for bikes';
            }else if( ($data['bike']) < 0){
                $data['err'] = 'Price must be positive';
            }

            if (empty($data['threeWheel'])){
                $data['err'] = 'Please enter threeWheel';
            } else if (!preg_match('/^[1-9]\d*(\.\d+)?$/', $data['threeWheel'])){
                $data['err'] = 'Invalid data type for three wheels';
            }else if( ($data['threeWheel']) < 0){
                $data['err'] = 'Price must be positive';
            }

            $other_data['notification_count'] = $this->userModel->getNotificationCount();

            if ($other_data['notification_count'] < 10)
                $other_data['notification_count'] = '0'.$other_data['notification_count'];

            // Validation is completed and no error found
            if (empty($data['err'])){
                // Register land
                if ($this->landModel->setPrice($data)){
                    $id = $this->landModel->findLandID($data['name']);
                    redirect('land/successPropertyRegister/'.$id);
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('parkingOwner/lands/setPrice', $data, $other_data);
            }

        } else {
            // Initial form data
            $data = [
                'name' => '',
                'car' => '',
                'bike' => '',
                'threeWheel' => '',
                'err' => ''

            ];

            $other_data['notification_count'] = 0;

            if ($other_data['notification_count'] < 10)
                $other_data['notification_count'] = '0'.$other_data['notification_count'];

            // Load view
            $this->view('parkingOwner/lands/create', $data, $other_data);
        }
    }

    public function setPrice($data){
        $other_data['notification_count'] = 0;

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('parkingOwner/lands/setPrice', $data, $other_data);
    }
    
    public function secAvailSet(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'secAvail' => trim($_POST['secAvail']),
                'car' => '',
                'bike' => '',
                'threeWheel' => ''
            ];

            // Validate data
            // Validate email
            if (empty($data['name'])){
                $data['err'] = 'Please enter name';
            }

            if (empty($data['secAvail'])){
                $data['err'] = 'Please enter secAvail';
            }

            $other_data['notification_count'] = $this->userModel->getNotificationCount();

            if ($other_data['notification_count'] < 10)
                $other_data['notification_count'] = '0'.$other_data['notification_count'];

            // Validation is completed and no error found
            if (empty($data['err'])){
                // Register land
                if ($this->landModel->updateSecurityOfficerAvail($data)){
                    if($_SESSION['user_type'] == 'parkingOwner'){
                        $this->setPrice($data);
                    }
                    else {

                        $data = [
                            'name' => trim($_POST['name']),
                            'car' => 0,
                            'bike' => 0,
                            'threeWheel' => 0,
                            'err' => ''
                        ];

                        redirect('land/successPropertyRegister/'.$id);
                    }
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('parkingOwner/lands', $data, $other_data);
            }

        } else {
            // Initial form data
            $data = [
                'name' => ''
            ];

            $other_data['notification_count'] = 0;

            if ($other_data['notification_count'] < 10)
                $other_data['notification_count'] = '0'.$other_data['notification_count'];

            // Load view
            $this->view('parkingOwner/lands/create', $data, $other_data);
        }
    }
    
    public function aboutSecurityOfficer($data){
        $other_data['notification_count'] = $this->userModel->getNotificationCount();

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('parkingOwner/lands/aboutSecurityOfficer', $data, $other_data);
    }

    public function deedUpload($file){
        $data = [
            'deed' => '',
            'err' => ''
        ];

        $file_name = $_FILES[$file]['name'];
        $file_size = $_FILES[$file]['size'];
        $tmp_name = $_FILES[$file]['tmp_name'];
        $error = $_FILES[$file]['error'];

        if ($error === 0){
            $file_ex = pathinfo($file_name, PATHINFO_EXTENSION);
            $file_ex_lc = strtolower($file_ex);

            $allowed_exs = array("pdf", "PDF");

            if (in_array($file_ex_lc, $allowed_exs)){
                // Move into mag_img folder
                $new_file_name = uniqid("DEED-", true).'.'.$file_ex_lc;
                $file_upload_path = PUBLICROOT.'/deeds/'.$new_file_name;
                move_uploaded_file($tmp_name, $file_upload_path);

                $data['deed'] = $new_file_name;
                return $data;
            }
            else{
                $data['err'] = "You can't upload files of this type";
                return $data;
            }
        }
    }

    // Image upload
    public function imageUpload($file){
        $data = [
            'image' => '',
            'err' => ''
        ];

        $file_name = $_FILES[$file]['name'];
        $file_size = $_FILES[$file]['size'];
        $tmp_name = $_FILES[$file]['tmp_name'];
        $error = $_FILES[$file]['error'];

        if ($error === 0){
            $file_ex = pathinfo($file_name, PATHINFO_EXTENSION);
            $file_ex_lc = strtolower($file_ex);

            $allowed_exs = array("jpg", "JPEG", "png");

            if (in_array($file_ex_lc, $allowed_exs)){
                // Move into ParkingPhotos folder
                $new_file_name = uniqid("ParkingPhoto-", true).'.'.$file_ex_lc;
                $file_upload_path = PUBLICROOT.'/ParkingPhotos/'.$new_file_name;
                move_uploaded_file($tmp_name, $file_upload_path);

                $data['image'] = $new_file_name;
                return $data;
            }

            else{
                $data['err'] = "You can't upload files of this type";
                return $data;
            }
        }
    }

    // Register Land
    public function landRegister(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'city' => trim($_POST['city']),
                'street' => trim($_POST['street']),
                'deed' => '',
                'car' => trim($_POST['car']),
                'bike' => trim($_POST['bike']),
                'threeWheel' => trim($_POST['threeWheel']),
                'contactNo' => trim($_POST['contactNo']),
                'address' => trim($_POST['address']),
                'district' => trim($_POST['district']),
                'province' => '',
                'cover' => '',
                'image1' => '',
                'image2' => '',
                'image3' => '',
                'longitude' => trim($_POST['longitude']),
                'latitude' => trim($_POST['latitude']),
                'err' => ''
            ];

            // Validate data
            // Validate email
            if (empty($data['name'])){
                $data['err'] = 'Please enter name';
            }
            else {
                // Check name
                if ($this->landModel->findLandByName($data['name'])){
                    $data['err'] = 'Name cannot be duplicate';
                }
            }

            if (empty($data['city'])){
                $data['err'] = 'Please enter city';
            }

            if (empty($data['street'])){
                $data['err'] = 'Please enter street';
            }

            if (empty($data['longitude']) OR empty($data['latitude'])){
                $data['err'] = 'Pleas select your location';
            }

            if (!preg_match('/^(0|\d+)$/', $data['car'])){
                $data['err'] = 'Invalid data type for cars';
            }

            if (!preg_match('/^(0|\d+)$/', $data['bike'])){
                $data['err'] = 'Invalid data type for bikes';
            }

            if (!preg_match('/^(0|\d+)$/', $data['threeWheel'])) {
                $data['err'] = 'Invalid data type for three wheels';
            }

            if (empty($data['contactNo'])){
                $data['err'] = 'Please enter contactNo';
            } else if(!preg_match('/^(0\d{9}|[1-9]\d{8}|\+94\d{7})$/', $data['contactNo'])) {
                $data['err'] = 'Invalid contact number format';
            }

            // Deed upload validation
            if (empty($data['err']) and !empty($_FILES['deed']['name'])){
                $deed = $this->deedUpload('deed');
                $data['deed'] = $deed['deed'];
                if(empty($deed['err']))
                    $data['err'] = '';
                else
                    $data['err'] = $deed['err'];
            }

            if (empty($data['deed']) and empty($data['err'])){
                $data['err'] = 'Please upload deed';
            }

            // Cover photo upload validation
            if (empty($data['err']) and !empty($_FILES['cover']['name'])){
                $cover = $this->imageUpload('cover');
                $data['cover'] = $cover['image'];
                if(empty($cover['err']))
                    $data['err'] = '';
                else
                    $data['err'] = $cover['err'];
            }

            if (empty($data['cover']) and empty($data['err'])){
                $data['err'] = 'Please upload cover photo';
            }

            // Parking photo 1 upload validation
            if (empty($data['err']) and !empty($_FILES['photo1']['name'])){
                $cover = $this->imageUpload('photo1');
                $data['photo1'] = $cover['image'];
                if(empty($cover['err']))
                    $data['err'] = '';
                else
                    $data['err'] = $cover['err'];
            }

            if (empty($data['photo1']) and empty($data['err'])){
                $data['err'] = 'Please upload parking photo 1';
            }

            // Parking photo 2 upload validation
            if (empty($data['err']) and !empty($_FILES['photo2']['name'])){
                $cover = $this->imageUpload('photo2');
                $data['photo2'] = $cover['image'];
                if(empty($cover['err']))
                    $data['err'] = '';
                else
                    $data['err'] = $cover['err'];
            }

            if (empty($data['photo2']) and empty($data['err'])){
                $data['err'] = 'Please upload parking photo 2';
            }

            // Parking photo 3 upload validation
            if (empty($data['err']) and !empty($_FILES['photo3']['name'])){
                $cover = $this->imageUpload('photo3');
                $data['photo3'] = $cover['image'];
                if(empty($cover['err']))
                    $data['err'] = '';
                else
                    $data['err'] = $cover['err'];
            }

            if (empty($data['photo3']) and empty($data['err'])){
                $data['err'] = 'Please upload parking photo 3';
            }

            $other_data['notification_count'] = $this->userModel->getNotificationCount();

            if ($other_data['notification_count'] < 10)
                $other_data['notification_count'] = '0'.$other_data['notification_count'];


            // Validate address
            if (empty($data['address']) and $data['err'] == ''){
                $data['err'] = 'Please enter address';
            }

            // Validate district
            if (empty($data['district']) and $data['err'] == ''){
                $data['err'] = 'Please select district';
            }

            $province = ['Northern' => ['Jaffna', 'Kilinochchi', 'Mannar', 'Mullaitivu', 'Vavuniya'], 'North Western' => ['Kurunegala', 'Puttalam'], 'Western' => ['Colombo', 'Gampaha', 'Kalutara'], 'North Central' => ['Anuradhapura', 'Polonnaruwa'], 'Central' => ['Kandy', 'Matale', 'Nuwara Eliya'], 'Sabaragamuwa' => ['Kegalle', 'Ratnapura'], 'Southern' => ['Galle', 'Matara', 'Hambantota'], 'Uva' => ['Badulla', 'Monaragala'], 'Eastern' => ['Ampara', 'Batticaloa', 'Trincomalee']];
            $flag = 0;
            foreach ($province as $key => $value){
                if (in_array($data['district'], $value)){
                    $data['province'] = $key;
                    $flag = 1;
                    break;
                }
            }

            if ($flag == 0){
                $data['err'] = 'Invalid District';
            }

            // Validation is completed and no error found*/
            if (empty($data['err'])){
                // Register land
                if ($this->landModel->registerLand($data) && $this->userModel->addNotification('Land registration request from '.$_SESSION['user_name'], 'landRegistration', $this->landModel->getLandID($data['name']), 0)){
                    $this->aboutSecurityOfficer($data);
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view($_SESSION['user_type'].'/lands/create', $data, $other_data);
            }

        } else {
            // Initial form data
            $data = [
                'name' => '',
                'city' => '',
                'street' => '',
                'deed' => '',
                'car' => '',
                'bike' => '',
                'threeWheel' => '',
                'contactNo' => '',
                'address' => '',
                'district' => '',
                'cover' => '',
                'image1' => '',
                'image2' => '',
                'image3' => '',
                'longitude' => '',
                'latitude' => '',
                'err' => ''
            ];

            $other_data['notification_count'] = $this->userModel->getNotificationCount();

            if ($other_data['notification_count'] < 10)
                $other_data['notification_count'] = '0'.$other_data['notification_count'];


            // Load view
            $this->view($_SESSION['user_type'].'/lands/create', $data, $other_data);
        }
    }

    // Remove Land
    public function landRemove(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name'])
            ];

            // Delete the land
            if ($this->landModel->removeLand($data)){
                redirect('parkingOwner/lands');
            } else {
                die('Something went wrong');
            }
        }
    }

    // Update Land
    public function landUpdateForm($land_ID = null, $land_name = null){
        if (sizeof($_GET) > 1){
            $data = [
                'name' => trim($_GET['name']),
                'id' => trim($_GET['id'])
            ];
    
            redirect('land/landUpdateForm/'.$data['id'].'/'.$data['name']);
        }
        else{
            $data = [
                'name' => $land_name,
                'id' => $land_ID
            ];

            $prices = $this->landModel->viewToBeUpdatedLand($data);
            

            $data = [
                'name' => $prices[0]->name,
                'city' => $prices[0]->city,
                'street' => $prices[0]->street,
                'deed' => $prices[0]->deed,
                'car' => $prices[0]->car,
                'bike' => $prices[0]->bike,
                'threeWheel' => $prices[0]->threeWheel,
                'contactNo' => $prices[0]->contactNo,
                'err' => '',
            ];

            $this->view('parkingOwner/lands/update', $data);
        }
    }

    public function landUpdate(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'old_name' => trim($_POST['old_name']),
                'city' => trim($_POST['city']),
                'street' => trim($_POST['street']),
                'deed' => trim($_POST['deed']),
                'car' => trim($_POST['car']),
                'bike' => trim($_POST['bike']),
                'threeWheel' => trim($_POST['threeWheel']),
                'contactNo' => trim($_POST['contactNo']),
                'err' => ''
            ];

            // Validate data
            // Validate email
            if (empty($data['name'])){
                $data['err'] = 'Please enter name';
            } else {
                // Check name
                if ($data['name'] != $data['old_name'] and $this->landModel->findLandByName($data['name'])){
                    $data['err'] = 'Name cannot be duplicate';
                }
            }

            if (empty($data['city'])){
                $data['err'] = 'Please enter city';
            }

            if (empty($data['street'])){
                $data['err'] = 'Please enter street';
            }

            if (empty($data['deed'])){
                $data['err'] = 'Please enter deed';
            }

            if (!preg_match('/^(0|\d+)$/', $data['car'])){
                $data['err'] = 'Invalid data type for cars';
            }

            if (!preg_match('/^(0|\d+)$/', $data['bike'])){
                $data['err'] = 'Invalid data type for bikes';
            }

            if (!preg_match('/^(0|\d+)$/', $data['threeWheel'])) {
                $data['err'] = 'Invalid data type for three wheels';
            }


            if (empty($data['contactNo'])){
                $data['err'] = 'Please enter contactNo';
            } else if(!preg_match('/^(0\d{9}|[1-9]\d{8}|\+94\d{7})$/', $data['contactNo'])) {
                $data['err'] = 'Invalid contact number format';
            }

            // Validation is completed and no error found
            if (empty($data['err'])){
                // Register Land
                if ($this->landModel->updateLand($data)){
                    redirect('parkingOwner/lands');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('parkingOwner/lands/update', $data);
            }
        }
    }

    // Success property register page
    public function successPropertyRegister($land_ID = null){
        $data['id'] = $land_ID;
        $land = $this->landModel->viewLand($land_ID);

        $notifications['list'] = $this->userModel->viewNotifications();
        $notifications['notification_count'] = $this->userModel->getNotificationCount();

        if ($notifications['notification_count'] < 10)
            $notifications['notification_count'] = '0'.$notifications['notification_count'];

        $this->view('parkingOwner/lands/successPropertyRegister', $land, $notifications);
    }

    // ------------------------------ Price ------------------------------
    // View all lands
    public function prices($land_ID = null){
        if (sizeof($_GET) > 1){
            $data = [
                'id' => trim($_GET['id'])
            ];
    
            redirect('land/prices/'.$data['id'].'/'.$data['name']);
        }
        else{
            $data = [
                'id' => $land_ID
            ];

            $prices = $this->landModel->viewPrice($data);

            $prices['notification_count'] = $this->userModel->getNotificationCount();

            if ($prices['notification_count'] < 10)
                $prices['notification_count'] = '0'.$prices['notification_count'];

            $this->view('parkingOwner/prices', $data, $prices);
        }
    }

    // ------------------------------------ Securities -------------------------------------
    // Search securities
    public function securitySearch($landID){
        $data = $this->securityModel->viewAvailableSecurities();

        $other_data['id'] = $landID;
        $other_data['district'] = $this->landModel->getLandDistrict($landID);
        $other_data['province'] = $this->landModel->getLandProvince($landID);

        $pendingSec = $this->securityModel->getSecurityPendingList($landID);

        $other_data['pending_securities'] = array();
        foreach ($pendingSec as $sec){
            $other_data['pending_securities'][] = $sec->sid;
        }

        $other_data['notification_count'] = $this->userModel->getNotificationCount();

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('parkingOwner/securities/add', $data, $other_data);
    }

    // Send request for security
    public function sendRequest(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $landID = trim($_POST['landID']);
            $securityID = trim($_POST['securityID']);

            // Send request
            if ($this->securityModel->sendRequest($landID, $securityID) && $this->userModel->addNotification('Land request from '.$this->landModel->getLandName($landID), 'securityRequest', $landID, $securityID)){
                redirect('land/securitySearch/'.$landID);
            } else {
                die('Something went wrong');
            }
        }
    }

    // Cancel request for security
    public function cancelRequest(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $landID = trim($_POST['landID']);
            $securityID = trim($_POST['securityID']);

            // Send request
            if ($this->securityModel->cancelRequest($landID, $securityID) && $this->userModel->removeNotification('securityRequest', $landID, $securityID)){
                redirect('land/securitySearch/'.$landID);
            } else {
                die('Something went wrong');
            }
        }
    }

    // View security
    public function viewSecurity($land_ID = null, $security_ID = null, $notification_id = null){

        // die(print_r($land_ID));
        if ($notification_id != null)
            $this->userModel->markAsRead($notification_id);

        if (sizeof($_GET) > 1){
            $data = [
                'id' => trim($_GET['id'])
            ];

            redirect('land/viewSecurity/'.$data['id']);
        }
        else{
            if($security_ID == null){
                $data = [
                    'lid' => 0,
                    'id' => $land_ID
                ];

                $security = $this->securityModel->viewSecurityProfile($data);

                $security['notification_count'] = $this->userModel->getNotificationCount();

                if ($security['notification_count'] < 10)
                    $security['notification_count'] = '0'.$security['notification_count'];

                $this->view('parkingOwner/securities/viewProfile', $data, $security);
            }
            else{
                $data = [
                    'id' => $security_ID,
                    'lid' => $land_ID
                ];
                // die(print_r($data));
                $security = $this->securityModel->viewSecurityProfile($data);

                $pendingSec = $this->securityModel->getSecurityPendingList($land_ID);

                $security['pending_securities'] = array();
                foreach ($pendingSec as $sec){
                    $security['pending_securities'][] = $sec->sid;
                }

                $security['notification_count'] = $this->userModel->getNotificationCount();

                if ($security['notification_count'] < 10)
                    $security['notification_count'] = '0'.$security['notification_count'];

                $this->view('parkingOwner/securities/viewProfile', $data, $security);
            }
        }
    }

    public function viewReviewsAndComplaints($land_ID){
        $other_data = $this->landModel->viewReviews($land_ID);
        $data = $this->landModel->viewComplaints($land_ID);

        $this->view('parkingOwner/reviewAndComplaints', $data, $other_data);
    }
}