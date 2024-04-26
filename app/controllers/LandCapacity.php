<?php
class LandCapacity extends Controller
{
    public function __construct()
    {
        $this->middleware = new AuthMiddleware();
        $this->middleware->checkAccess(['parkingOwner','merchandiser','security']);
        $this->landModel = $this->model('LandModel');
        $this->userModel = $this->model('UserModel');
    }

    // View capacity
    public function viewCapacity($parking_ID = null){
        $data = [
            'id' => $parking_ID,
            'name' => ''
        ];

        // die(print_r($data));
        $capacity = $this->landModel->viewCapacity($data);

        $capacity['notification_count'] = $this->userModel->getNotificationCount();

        if ($capacity['notification_count'] < 10)
            $capacity['notification_count'] = '0'.$capacity['notification_count'];
        
        if ($_SESSION['user_type'] == 'security'){
            $this->view('parkingOwner/capacity/viewCapacity', $data, $capacity);
        }else{    
            $this->view($_SESSION['user_type'].'/capacity/viewCapacity', $data, $capacity);
        }
        
    }

    public function capacityUpdateForm($land_ID = null, $vehicle_type = null){
        if (sizeof($_GET) > 1){
            $data = [
                'name' => trim($_GET['name']),
                'id' => trim($_GET['id']),
                'vehicle_type' => trim($_GET['vehicle_type'])
            ];

            // die(print_r($data));
            redirect('landCapacity/capacityUpdateForm/'.$data['id'].'/'.$data['vehicle_type']);
        }
        else{
            $data = [
                'id' => $land_ID,
                'vehicle_type' => $vehicle_type
            ];


            $capacity = $this->landModel->viewCapacity($data);

            $other_data['notification_count'] = $this->userModel->getNotificationCount();

            if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];


            if ($data['vehicle_type'] == 'car'){
                $data = [
                    'id' => $land_ID,
                    'vehicle_type' => $vehicle_type,
                    'capacity' => $capacity[0]->car,
                    'requestedCapacity' => $capacity[0]->requestedCar
                ];
            }
            else if ($data['vehicle_type'] == 'bike'){
                $data = [
                    'id' => $land_ID,
                    'vehicle_type' => $vehicle_type,
                    'capacity' => $capacity[0]->bike,
                    'requestedCapacity' => $capacity[0]->requestedBike
                ];
            }
            else if ($data['vehicle_type'] == 'threeWheel'){
                $data = [
                    'id' => $land_ID,
                    'vehicle_type' => $vehicle_type,
                    'capacity' => $capacity[0]->threeWheel,
                    'requestedCapacity' => $capacity[0]->requestedThreeWheel
                ];
            }

            if ($_SESSION['user_type'] == 'security'){
                $this->view('parkingOwner/capacity/update', $data, $other_data);
            }else{    
                $this->view($_SESSION['user_type'].'/capacity/update', $data, $other_data);
            }
        }
    }

    public function requestedCapacityUpdateForm($land_ID = null, $vehicle_type = null ){

            $data = [
                'id' => $land_ID,
                'vehicle_type' => $vehicle_type,
                'err' => ''
            ];

            
            $capacity = $this->landModel->viewCapacity($data);

            // die(print_r($capacity[0]->requestedCar));

            $other_data['notification_count'] = $this->userModel->getNotificationCount();

            if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];


            if ($data['vehicle_type'] == 'car'){
                $data = [
                    'id' => $land_ID,
                    'vehicle_type' => $vehicle_type,
                    'capacity' => $capacity[0]->car,
                    'requestedCapacity' => $capacity[0]->requestedCar
                ];
            }
            else if ($data['vehicle_type'] == 'bike'){
                $data = [
                    'id' => $land_ID,
                    'vehicle_type' => $vehicle_type,
                    'capacity' => $capacity[0]->bike,
                    'requestedCapacity' => $capacity[0]->requestedBike
                ];
            }
            else if ($data['vehicle_type'] == 'threeWheel'){
                $data = [
                    'id' => $land_ID,
                    'vehicle_type' => $vehicle_type,
                    'capacity' => $capacity[0]->threeWheel,
                    'requestedCapacity' => $capacity[0]->requestedThreeWheel
                ];
            }

                // die(print_r($other_data));
                $this->view('parkingOwner/capacity/requestedUpdate', $data, $other_data);
    }

    public function capacityUpdate(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $other_data['notification_count'] = $this->userModel->getNotificationCount();

            if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

            $data = [
                'id' => trim($_POST['id']),
                'vehicle_type' => trim($_POST['vehicle_type']),
                'capacity' => trim($_POST['capacity']),
                'requestedCapacity' => trim($_POST['requestedCapacity']),
                'err' => ''
            ];

            // Validate data
            if (empty($data['capacity']) && $data['capacity'] != 0) {
                $data['err'] = 'Please enter capacity';
            } else if (!is_numeric($data['capacity']) || $data['capacity'] < 0) {
                $data['err'] = 'Capacity should be a positive number';
            }

            // Validate vehicle type
            if (empty($data['vehicle_type'])) {
                $data['err'] = 'Please select vehicle type';
            } else if ($data['vehicle_type'] != 'car' and $data['vehicle_type'] != 'bike' and $data['vehicle_type'] != 'threeWheel') {
                $data['err'] = 'Invalid vehicle type';
            }

            // Validation is completed and no error found
            if (empty($data['err'])) {
                if ($this->landModel->updateCapacity($data)) {
                    redirect('LandCapacity/viewCapacity/'.$data['id'].'/'.$data['name']);
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors

                if ($_SESSION['user_type'] == 'security'){
                    $this->view('parkingOwner/capacity/update', $data, $other_data);
                }else{    
                    $this->view($_SESSION['user_type'].'/capacity/update', $data, $other_data);
                }
            }
        }
    }

    public function requestCapacityUpdate(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $requestedCapacity = $_POST['requestedCapacity'];
            $capacity = $_POST['capacity'];
            $land_ID = $_POST['id'];
            $owner_id = $this->landModel->getLandOwnerID($_POST['id']);

            // die(print_r($requestedCapacity));
            $other_data['notification_count'] = $this->userModel->getNotificationCount();

            if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

            $data = [
                'id' => trim($_POST['id']),
                'capacity' => trim($_POST['capacity']),
                'vehicle_type' => trim($_POST['vehicle_type']),
                'requestedCapacity' => trim($_POST['requestedCapacity']),
                'err' => ''
            ];

            if (empty($data['requestedCapacity']) && $data['requestedCapacity'] != 0) {
                $data['err'] = 'Please enter capacity';
            } else if (!is_numeric($data['requestedCapacity']) || $data['requestedCapacity'] < 0) {
                $data['err'] = 'Capacity should be a positive number';
                // die(print_r($data));
            }
        
            if (empty($data['err'])) {
                // die(print_r($data));
                $this->landModel->updateRequestedCapacity($data);
                $this->userModel->addNotification('Request to Change Capacity in (Land ID = '.$land_ID.') from '.$_SESSION['user_name'], 'requestChangeCapacity', $_SESSION['user_id'], $owner_id, $land_ID.'/'.$data['vehicle_type']);
                redirect('landCapacity/capacityUpdateForm/'.$data['id'].'/'.$data['vehicle_type']);    

            } else {
                // Load view with errors
                $this->view('parkingOwner/capacity/update', $data , $other_data);
            }

        }            
    }

    public function acceptRequestedCapacity(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            
            $other_data['notification_count'] = $this->userModel->getNotificationCount();

            if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

            $data = [
                'id' => trim($_POST['id']),
                'vehicle_type' => trim($_POST['vehicle_type']),
                'requestedCapacity' => trim($_POST['requestedCapacity']),
                'err' => ''
            ];

            // Validation is completed and no error found
            if (empty($data['err'])) {
                // die(print_r($data));
                if ($this->landModel->acceptRequestedCapacity($data)) {
                    redirect('LandCapacity/viewCapacity/'.$data['id'].'/'.$data['name']);
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors

                $this->view('parkingOwner/capacity/update', $data ,$other_data);
            }
        }
    }

    public function rejectRequestedCapacity(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $other_data['notification_count'] = $this->userModel->getNotificationCount();

            if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

            $data = [
                'id' => trim($_POST['id']),
                'vehicle_type' => trim($_POST['vehicle_type']),
                'requestedCapacity' => trim($_POST['requestedCapacity']),
                'err' => ''
            ];

            if (empty($data['err'])) {
                
                if ($this->landModel->rejectRequestedCapacity($data)) {
                    redirect('LandCapacity/viewCapacity/'.$data['id'].'/'.$data['name']);
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors

                $this->view('parkingOwner/capacity/update', $data ,$other_data);
            }
        }
    }
}
