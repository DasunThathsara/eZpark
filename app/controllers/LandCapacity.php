<?php
class LandCapacity extends Controller
{
    public function __construct()
    {
        $this->middleware = new AuthMiddleware();
        // Only parkingOwners are allowed to access parkingOwner pages
        $this->middleware->checkAccess(['parkingOwner']);
        $this->parkingOwnerModel = $this->model('ParkingOwnerModel');
    }

    // View capacity
    public function viewCapacity($parking_ID = null, $parking_name = null){
        $data = [
            'id' => $parking_ID,
            'name' => $parking_name
        ];

        $capacity = $this->parkingOwnerModel->viewCapacity($data);

        $this->view('parkingOwner/capacity/viewCapacity', $data, $capacity);
    }

    public function capacityUpdateForm($land_ID = null, $land_name = null, $vehicle_type = null){
        if (sizeof($_GET) > 1){
            $data = [
                'name' => trim($_GET['name']),
                'id' => trim($_GET['id']),
                'vehicle_type' => trim($_GET['vehicle_type'])
            ];

            redirect('landCapacity/capacityUpdateForm/'.$data['id'].'/'.$data['name'].'/'.$data['vehicle_type']);
        }
        else{
            $data = [
                'name' => $land_name,
                'id' => $land_ID,
                'vehicle_type' => $vehicle_type
            ];


            $capacity = $this->parkingOwnerModel->viewCapacity($data);

            if ($data['vehicle_type'] == 'car'){
                $data = [
                    'name' => $land_name,
                    'id' => $land_ID,
                    'vehicle_type' => $vehicle_type,
                    'capacity' => $capacity[0]->car
                ];
            }
            else if ($data['vehicle_type'] == 'bike'){
                $data = [
                    'name' => $land_name,
                    'id' => $land_ID,
                    'vehicle_type' => $vehicle_type,
                    'capacity' => $capacity[0]->bike
                ];
            }
            else if ($data['vehicle_type'] == 'threeWheel'){
                $data = [
                    'name' => $land_name,
                    'id' => $land_ID,
                    'vehicle_type' => $vehicle_type,
                    'capacity' => $capacity[0]->threeWheel
                ];
            }

            $this->view('parkingOwner/capacity/update', $data);
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
            if (empty($data['capacity'])) {
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
                if ($this->parkingOwnerModel->updateCapacity($data)) {
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
