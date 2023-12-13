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

    public function viewPackages($parking_ID = null, $parking_name = null){
        $data = [
            'id' => $parking_ID,
            'name' => $parking_name
        ];

        $packages = $this->parkingOwnerModel->viewPackages($data);

        $this->view('parkingOwner/packages/viewPackage', $data, $packages);
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
                'price' => trim($_POST['price']),
                'packageType' => trim($_POST['package_type']),
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
           
            if (empty($data['packageType'])) {
                $data['err'] = 'Please select package type';
            } else if ($data['packageType'] != 'car' and $data['packageType'] != 'bike' and $data['packageType'] != '3wheel') {
                $data['err'] = 'Invalid package type';
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
                'pname' => '',
                'name' => '',
                'price' => '',
                'packageType' => '',
                'err' => '',
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
                'pid' => trim($_POST['pid'])
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
                'name' => trim($_POST['name']),
                'price' => trim($_POST['price']),
                'packageType' => trim($_POST['package_type']),
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
                'price' => trim($_POST['price']),
                'packageType' => trim($_POST['package_type']),
                'err' => ''
            ];

            // Validate data
            // Validate email
            if (empty($data['name'])) {
                $data['err'] = 'Please select package name';
            } else if ($data['name'] != 'weekly' and $data['name'] != 'monthly') {
                $data['err'] = 'Invalid package name';
            }

            // Validate package price
            if (empty($data['package_price'])) {
                $data['err'] = 'Please enter price';
            } 
           
            if (empty($data['packageType'])) {
                $data['err'] = 'Please select package type';
            } else if ($data['packageType'] != 'car' and $data['packageType'] != 'bike' and $data['packageType'] != '3wheel') {
                $data['err'] = 'Invalid package type';
            }
            // Validation is completed and no error found
            if (empty($data['err'])) {
                // Register package
                if ($this->parkingOwnerModel->updatePackage($data)) {
                    redirect('package/viewPackages/'.$data['id'].'/'.$data['name']);
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
