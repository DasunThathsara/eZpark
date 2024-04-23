<?php
class LandCapacity extends Controller
{
    public function __construct()
    {
        $this->middleware = new AuthMiddleware();
        // Only parkingOwners are allowed to access parkingOwner pages
        $this->middleware->checkAccess(['parkingOwner','merchandiser']);
        $this->landModel = $this->model('LandModel');
    }

    // View capacity
    public function viewCapacity($parking_ID = null){
        $data = [
            'id' => $parking_ID,
            'name' => ''
        ];

        $capacity = $this->landModel->viewCapacity($data);

        $capacity['notification_count'] = 0;

        if ($capacity['notification_count'] < 10)
            $capacity['notification_count'] = '0'.$capacity['notification_count'];

        $this->view('parkingOwner/capacity/viewCapacity', $data, $capacity);
        
    }

    public function capacityUpdateForm($land_ID = null, $vehicle_type = null){
        if (sizeof($_GET) > 1){
            $data = [
                'name' => trim($_GET['name']),
                'id' => trim($_GET['id']),
                'vehicle_type' => trim($_GET['vehicle_type'])
            ];

            redirect('landCapacity/capacityUpdateForm/'.$data['id'].'/'.$data['vehicle_type']);
        }
        else{
            $data = [
                'id' => $land_ID,
                'vehicle_type' => $vehicle_type
            ];


            $capacity = $this->landModel->viewCapacity($data);

            $other_data['notification_count'] = 0;

            if ($other_data['notification_count'] < 10)
                $other_data['notification_count'] = '0'.$other_data['notification_count'];

            if ($data['vehicle_type'] == 'car'){
                $data = [
                    'id' => $land_ID,
                    'vehicle_type' => $vehicle_type,
                    'capacity' => $capacity[0]->car
                ];
            }
            else if ($data['vehicle_type'] == 'bike'){
                $data = [
                    'id' => $land_ID,
                    'vehicle_type' => $vehicle_type,
                    'capacity' => $capacity[0]->bike
                ];
            }
            else if ($data['vehicle_type'] == 'threeWheel'){
                $data = [
                    'id' => $land_ID,
                    'vehicle_type' => $vehicle_type,
                    'capacity' => $capacity[0]->threeWheel
                ];
            }

            $this->view('parkingOwner/capacity/update', $data, $other_data);
        }
    }

    public function capacityUpdate(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => trim($_POST['id']),
                'name' => trim($_POST['name']),
                'vehicle_type' => trim($_POST['vehicle_type']),
                'capacity' => trim($_POST['capacity']),
                'err' => ''
            ];

            // Validate data
            // Validate package type
            if (empty($data['capacity']) && $data['capacity'] != 0) {
                $data['err'] = 'Please enter capacity';
            } else if (!is_numeric($data['capacity'])) {
                $data['err'] = 'Capacity should be a number';
            }

            // Validate vehicle type
            if (empty($data['vehicle_type'])) {
                $data['err'] = 'Please select vehicle type';
            } else if ($data['vehicle_type'] != 'car' and $data['vehicle_type'] != 'bike' and $data['vehicle_type'] != 'threeWheel') {
                $data['err'] = 'Invalid vehicle type';
            }

            // Validation is completed and no error found
            if (empty($data['err'])) {
                // Register package
                if ($this->landModel->updateCapacity($data)) {
                    redirect('LandCapacity/viewCapacity/'.$data['id'].'/'.$data['name']);
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
//                die(print_r($data));
                $this->view('parkingOwner/capacity/update', $data);
            }
        }
    }
}
