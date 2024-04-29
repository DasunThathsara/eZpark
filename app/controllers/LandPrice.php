<?php
class LandPrice extends Controller
{
    public function __construct()
    {
        $this->middleware = new AuthMiddleware();
        // Only parkingOwners are allowed to access parkingOwner pages
        $this->middleware->checkAccess(['parkingOwner']);
        $this->landModel = $this->model('LandModel');
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
            if ($this->landModel->removePackage($data)) {
                redirect('parkingOwner/packages/'.$data['id'].'/'.$data['name']);
            } else {
                die('Something went wrong');
            }
        }
    }

    // Update package
    public function packageUpdateForm(){
        if (sizeof($_GET) > 1){
            $data = [
                'name' => trim($_GET['name']),
                'id' => trim($_GET['id']),
                'package_type' => trim($_GET['package_type']),
                'vehicle_type' => trim($_GET['vehicle_type'])
            ];

            redirect('package/packageUpdateForm/'.$data['id'].'/'.$data['package_type'].'/'.$data['vehicle_type']);
        }
        else{
            $data = [
                'id' => $land_ID,
                'package_type' => $package_type,
                'vehicle_type' => $vehicle_type
            ];

            $package = $this->parkingOwnerModel->viewToBeUpdatedPackage($data);

            $other_data['notification_count'] = $this->userModel->getNotificationCount();

            if ($other_data['notification_count'] < 10)
                $other_data['notification_count'] = '0'.$other_data['notification_count'];

            $data = [
                'id' => $package[0]->pid,
                'package_type' => $package[0]->name,
                'vehicle_type' => $package[0]->packageType,
                'package_price' => $package[0]->price,
                'err' => ''
            ];

            $this->view('parkingOwner/packages/update', $data, $other_data);
        }
    }
    public function priceUpdateForm($land_ID = null, $package_type = null){
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $data = [
                'id' => trim($_GET['id']),
                'pid' => trim($_GET['pid']),
                'vehicle_type' => trim($_GET['vehicle_type']),
                'hour_price' => trim($_GET['hour_price']),
                'additional_hour_price' => trim($_GET['additional_hour_price']),
                'err' => ''
            ];

            $prices = $this->landModel->viewPrice($data);

            $prices['notification_count'] = $this->userModel->getNotificationCount();

            if ($prices['notification_count'] < 10)
                $prices['notification_count'] = '0'.$prices['notification_count'];


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
                'vehicle_type' => trim($_POST['vehicle_type']),
                'hour_price' => trim($_POST['hour_price']),
                'additional_hour_price' => trim($_POST['additional_hour_price']),
                'err' => ''
            ];

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
            }else if($data['hour_price']<0 or !ctype_digit(strval($data['hour_price']))){
                $data['err'] = 'Plese enter a positive number';
            }

            // Validate additional hour price
            if (empty($data['additional_hour_price'])) {
                $data['err'] = 'Please enter additional hour price';
            }else if($data['additional_hour_price']<0 or !ctype_digit(strval($data['additional_hour_price']))){
                $data['err'] = 'Plese enter a positive number';
            }

            // Validation is completed and no error found
            if (empty($data['err'])) {
                // Register package
                if ($this->landModel->updatePrice($data)) {
                    redirect('land/prices/'.$data['id']);
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $prices = $this->landModel->viewPrice($data);
                
            

                $prices['notification_count'] = $this->userModel->getNotificationCount();

                if ($prices['notification_count'] < 10)
                    $prices['notification_count'] = '0'.$prices['notification_count'];

                $this->view('parkingOwner/prices/update', $data, $prices);
            }
        }
    }

}
