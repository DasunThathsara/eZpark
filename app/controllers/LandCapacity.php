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

    // Remove package
    public function priceDelete(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => trim($_POST['id']),
                'name' => trim($_POST['name']),
                'package_type' => trim($_POST['package_type']),
                'vehicle_type' => trim($_POST['vehicle_type'])
            ];

            // Delete the package
            if ($this->parkingOwnerModel->removePackage($data)) {
                redirect('parkingOwner/packages/'.$data['id'].'/'.$data['name']);
            } else {
                die('Something went wrong');
            }
        }
    }

    // Update package
    public function priceUpdateForm(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'id' => trim($_POST['id']),
                'name' => trim($_POST['name']),
                'pid' => trim($_POST['pid']),
                'vehicle_type' => trim($_POST['vehicle_type']),
                'hour_price' => trim($_POST['hour_price']),
                'additional_hour_price' => trim($_POST['additional_hour_price']),
                'err' => ''
            ];

            $prices = $this->parkingOwnerModel->viewPrice($data);

            $this->view('parkingOwner/prices/update', $data, $prices);
        }
    }

    public function priceUpdate(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => trim($_POST['id']),
                'name' => trim($_POST['name']),
                'vehicle_type' => trim($_POST['vehicle_type']),
                'hour_price' => trim($_POST['hour_price']),
                'additional_hour_price' => trim($_POST['additional_hour_price']),
                'err' => ''
            ];

            // die(print_r($data));

            // Validate data
            // Validate vehicle type
            if (empty($data['vehicle_type'])) {
                $data['err'] = 'Please select vehicle type';
            } else if ($data['vehicle_type'] != 'car' and $data['vehicle_type'] != 'bike' and $data['vehicle_type'] != 'threeWheel') {
                $data['err'] = 'Invalid vehicle type';
            }

            // Validate hour price
            if (empty($data['hour_price'])) {
                $data['err'] = 'Please enter hour price';
            }

            // Validate additional hour price
            if (empty($data['additional_hour_price'])) {
                $data['err'] = 'Please enter additional hour price';
            }

            // if($data['old_vehicle_type'] != $data['vehicle_type'] or $data['old_package_type'] != $data['package_type']){
            //     if ($this->parkingOwnerModel->findPackage($data['id'], $data['package_type'], $data['vehicle_type'])){
            //         $data['err'] = 'Package cannot be duplicate';
            //     }
            // }



            // Validation is completed and no error found
            if (empty($data['err'])) {
                // Register package
                if ($this->parkingOwnerModel->updatePrice($data)) {
                    redirect('land/prices/'.$data['id'].'/'.$data['name']);
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $prices = $this->parkingOwnerModel->viewPrice($data);
                $this->view('parkingOwner/prices/update', $data, $prices);
            }
        }
    }

}
