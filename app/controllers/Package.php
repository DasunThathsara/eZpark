<?php
class Package extends Controller
{
    public function __construct()
    {
        $this->middleware = new AuthMiddleware();
        // Only parkingOwners are allowed to access parkingOwner pages
        $this->middleware->checkAccess(['parkingOwner']);
        $this->parkingOwnerModel = $this->model('ParkingOwnerModel');
    }

    // Register Package
    public function packageRegister($parking_ID = null, $parking_name = null){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => trim($_POST['id']),
                'name' => trim($_POST['name']),
                'vehicle_type' => trim($_POST['vehicle_type']),
                'package_price' => trim($_POST['package_price']),
                'package_type' => trim($_POST['package_type']),
                'err' => ''
            ];

            // Validate data
            // Validate package type
            if (empty($data['package_type'])) {
                $data['err'] = 'Please select package type';
            } else if ($data['package_type'] != 'weekly' and $data['package_type'] != 'monthly') {
                $data['err'] = 'Invalid package type';
            }

            // Validate package price
            if (empty($data['package_price'])) {
                $data['err'] = 'Please enter price';
            } 
           
            // Validate vehicle type
            if (empty($data['vehicle_type'])) {
                $data['err'] = 'Please select vehicle type';
            } else if ($data['vehicle_type'] != 'car' and $data['vehicle_type'] != 'bike' and $data['vehicle_type'] != '3wheel') {
                $data['err'] = 'Invalid vehicle type';
            }

            if ($this->parkingOwnerModel->findPackage($data['id'], $data['package_type'], $data['vehicle_type'])){
                $data['err'] = 'Package cannot be duplicate';
            }

            // Validation is completed and no error found
            if (empty($data['err'])) {
                // Register package
                if ($this->parkingOwnerModel->registerPackage($data)) {
                    redirect('parkingOwner/packages/'.$data['id'].'/'.$data['name']);
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('parkingOwner/packages/create', $data);
            }

        } else {
            // Initial form data
            $data = [
                'id' => $parking_ID,
                'name'=> $parking_name,
                'vehicle_type' => '',
                'package_price' => '',
                'package_type' => '',
                'err' => ''
            ];

            // Load view
            $this->view('parkingOwner/packages/create', $data);
        }
    }

    // Remove package
    public function packageRemove(){
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

    public function packageUpdateForm($land_ID = null, $land_name = null, $package_type = null, $vehicle_type = null){
        if (sizeof($_GET) > 1){
            $data = [
                'name' => trim($_GET['name']),
                'id' => trim($_GET['id']),
                'package_type' => trim($_GET['package_type']),
                'vehicle_type' => trim($_GET['vehicle_type'])
            ];

            redirect('package/packageUpdateForm/'.$data['id'].'/'.$data['name'].'/'.$data['package_type'].'/'.$data['vehicle_type']);
        }
        else{
            $data = [
                'name' => $land_name,
                'id' => $land_ID,
                'package_type' => $package_type,
                'vehicle_type' => $vehicle_type
            ];

            $package = $this->parkingOwnerModel->viewToBeUpdatedPackage($data);


            $data = [
                'id' => $package[0]->pid,
                'name' => $land_name,
                'package_type' => $package[0]->name,
                'vehicle_type' => $package[0]->packageType,
                'package_price' => $package[0]->price,
                'err' => ''
            ];

            $this->view('parkingOwner/packages/update', $data);
        }
    }

    public function packageUpdate()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => trim($_POST['id']),
                'name' => trim($_POST['name']),
                'vehicle_type' => trim($_POST['vehicle_type']),
                'old_vehicle_type' => trim($_POST['old_vehicle_type']),
                'package_price' => trim($_POST['package_price']),
                'package_type' => trim($_POST['package_type']),
                'old_package_type' => trim($_POST['old_package_type']),
                'err' => ''
            ];

            // Validate data
            // Validate package type
            if (empty($data['package_type'])) {
                $data['err'] = 'Please select package type';
            } else if ($data['package_type'] != 'weekly' and $data['package_type'] != 'monthly') {
                $data['err'] = 'Invalid package type';
            }

            // Validate package price
            if (empty($data['package_price'])) {
                $data['err'] = 'Please enter price';
            } 
           
            // Validate vehicle type
            if (empty($data['vehicle_type'])) {
                $data['err'] = 'Please select vehicle type';
            } else if ($data['vehicle_type'] != 'car' and $data['vehicle_type'] != 'bike' and $data['vehicle_type'] != '3wheel') {
                $data['err'] = 'Invalid vehicle type';
            }

            if($data['old_vehicle_type'] != $data['vehicle_type'] or $data['old_package_type'] != $data['package_type']){
                if ($this->parkingOwnerModel->findPackage($data['id'], $data['package_type'], $data['vehicle_type'])){
                    $data['err'] = 'Package cannot be duplicate';
                }
            }
            
            

            // Validation is completed and no error found
            if (empty($data['err'])) {
                // Register package
                if ($this->parkingOwnerModel->updatePackage($data)) {
                    redirect('parkingOwner/packages/'.$data['id'].'/'.$data['name']);
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('parkingOwner/packages/update', $data);
            }
        }
    }

}
