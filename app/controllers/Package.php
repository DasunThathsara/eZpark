<?php
class Package extends Controller
{
    public function __construct()
    {
        $this->middleware = new AuthMiddleware();
        $this->middleware->checkAccess(['parkingOwner', 'security']);
        $this->parkingOwnerModel = $this->model('ParkingOwnerModel');
    }

    public function viewPackages($parking_ID = null){
        $data = [
            'id' => $parking_ID,
            'name' => ''
        ];

        $packages = $this->parkingOwnerModel->viewPackages($data);

        $packages['notification_count'] = 0;

        if ($packages['notification_count'] < 10)
            $packages['notification_count'] = '0'.$packages['notification_count'];

        $this->view('parkingOwner/packages/viewPackage', $data, $packages);
    }

    // Register Package
    // public function packageRegister($parking_ID = null){
    //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //         // Submitted form data
    //         // input data
    //         $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    //         $data = [
    //             'id' => trim($_POST['id']),
    //             'vehicle_type' => trim($_POST['vehicle_type']),
    //             'package_price' => trim($_POST['package_price']),
    //             'package_type' => trim($_POST['package_type']),
    //             'err' => ''
    //         ];
    //         // die(print_r($data));
    //         // Validate data
    //         // Validate package type
    //         if (empty($data['package_type'])) {
    //             $data['err'] = 'Please select package type';
    //         } else if ($data['package_type'] != 'weekly' and $data['package_type'] != 'monthly') {
    //             $data['err'] = 'Invalid package type';
    //         }

    //         // Validate package price
    //         if (empty($data['package_price'])) {
    //             $data['err'] = 'Please enter price';
    //         }
           
    //         if (empty($data['vehicle_type'])) {
    //             $data['err'] = 'Please select vehicle type';
    //         } else if ($data['vehicle_type'] != 'car' and $data['vehicle_type'] != 'bike' and $data['vehicle_type'] != '3wheel') {
    //             $data['err'] = 'Invalid vehicle type';
    //         }

    //         // Validation is completed and no error found
    //         if (empty($data['err']) && $this->parkingOwnerModel->checkPackage($data)) {
    //             // Register package
    //             if ($this->parkingOwnerModel->registerPackage($data)) {
    //                 redirect('parkingOwner/packages/'.$data['id'].'/'.$data['name']);
    //                 die(print_r($data)); 
    //             } else {
    //                 die('Something went wrong');
    //             }
    //         } else {

    //             $other_data['notification_count'] = 0;

    //             if ($other_data['notification_count'] < 10)
    //                 $other_data['notification_count'] = '0'.$other_data['notification_count'];
    //             // Load view with errors
    //             $data['err'] = 'Already created package';
    //             // die(print_r($data)); 
    //             $this->view('parkingOwner/packages/create', $data , $other_data);
    //         }

    //     } else {
    //         // Initial form data
    //         $data = [
    //             'id' => $parking_ID,
    //             'vehicle_type' => '',
    //             'package_price' => '',
    //             'package_type' => '',
    //             'err' => ''
    //         ];

    //         $other_data['notification_count'] = 0;

    //         if ($other_data['notification_count'] < 10)
    //             $other_data['notification_count'] = '0'.$other_data['notification_count'];

    //         // Load view
    //         $this->view('parkingOwner/packages/create', $data, $other_data);
    //     }
    // }

    public function packageRegister($parking_ID = null){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Submitted form data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
            $data = [
                'id' => trim($_POST['id']),
                'vehicle_type' => trim($_POST['vehicle_type']),
                'package_price' => trim($_POST['package_price']),
                'package_type' => trim($_POST['package_type']),
                'err' => ''
            ];

            // Validate package type
            if (empty($data['package_type'])) {
                $data['err'] = 'Please select package type';
            } else if (!in_array($data['package_type'], ['weekly', 'monthly'])) {
                $data['err'] = 'Invalid package type';
            }
    
            // Validate package price
            if (empty($data['package_price'])) {
                $data['err'] = 'Please enter price';
            }
    
            // Validate vehicle type
            if (empty($data['vehicle_type'])) {
                $data['err'] = 'Please select vehicle type';
            } else if (!in_array($data['vehicle_type'], ['car', 'bike', '3wheel'])) {
                $data['err'] = 'Invalid vehicle type';
            }
    
            // Check if the package already exists
            if (empty($data['err']) && !$this->parkingOwnerModel->checkPackage($data)) {
                $data['err'] = 'Package already exists';
            }
    
            // If no error, register the package
            if (empty($data['err'])) {
                if ($this->parkingOwnerModel->registerPackage($data)) {
                    // Redirect or display success message
                    redirect('parkingOwner/packages/'.$data['id'].'/'.$data['name']);
                } else {
                    // Handle database error
                    $data['err'] = 'Something went wrong.';
                }
            }
    
            // Load view with errors
            $this->view('parkingOwner/packages/create', $data);
        } else {
            // Initial form data (GET request)
            $data = [
                'id' => $parking_ID,
                'vehicle_type' => '',
                'package_price' => '',
                'package_type' => '',
                'err' => ''
            ];
    
            $other_data['notification_count'] = 0;
            
            if ($other_data['notification_count'] < 10) {
                $other_data['notification_count'] = '0'.$other_data['notification_count'];
            }
    
            // Load view
            $this->view('parkingOwner/packages/create', $data, $other_data);
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
                'package_type' => trim($_POST['package_type']),
                'vehicle_type' => trim($_POST['vehicle_type']),
            ];

            // die(print_r($data));
            // Delete the package
            if ($this->parkingOwnerModel->removePackage($data)) {
                redirect('parkingOwner/packages/'.$data['id'].'/'.$data['package_type']);
            } else {
                die('Something went wrong');
            }
        }
    }

    public function packageUpdateForm($land_ID = null, $package_type = null, $vehicle_type = null){
        if (sizeof($_GET) > 1){
            $data = [
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

            $other_data['notification_count'] = 0;

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
            // die(print_r($data));
        }
    }

    public function packageUpdate()
    {
        $other_data['notification_count'] = 0;
            
        if ($other_data['notification_count'] < 10) {
            $other_data['notification_count'] = '0'.$other_data['notification_count'];
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => isset($_POST['id']) ? trim($_POST['id']) : '',
                'vehicle_type' => isset($_POST['vehicle_type']) ? trim($_POST['vehicle_type']) : '',
                'old_vehicle_type' => isset($_POST['old_vehicle_type']) ? trim($_POST['old_vehicle_type']) : '',
                'package_price' => isset($_POST['package_price']) ? trim($_POST['package_price']) : '',
                'package_type' => isset($_POST['package_type']) ? trim($_POST['package_type']) : '',
                'old_package_type' => isset($_POST['old_package_type']) ? trim($_POST['old_package_type']) : '',
                'err' => isset($data['err']) ? $data['err'] : ''
            ];
            // die(print_r($data));
            
            // Validate data
            // Validate email
            if (empty($data['package_type'])) {
                $data['err'] = 'Please select package name';
            } else if ($data['package_type'] != 'weekly' and $data['package_type'] != 'monthly') {
                $data['err'] = 'Invalid package name';
            }

            // Validate package price
            if (empty($data['package_price'])) {
                $data['err'] = 'Please enter price';
            } 
           
            if (empty($data['vehicle_type'])) {
                $data['err'] = 'Please select package type';
            } else if ($data['vehicle_type'] != 'car' and $data['vehicle_type'] != 'bike' and $data['vehicle_type'] != '3wheel') {
                $data['err'] = 'Invalid package type';
            }

            // Check if the package already exists
            if (empty($data['err']) && !$this->parkingOwnerModel->checkPackage($data)) {
                $data['err'] = 'Package already exists';
            }
            // Validation is completed and no error found
            if (empty($data['err'])) {
                // Register package
                if ($this->parkingOwnerModel->updatePackage($data)) {
                    redirect('package/viewPackages/'.$data['id'].'/'.$data['package_type']);
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('parkingOwner/packages/update', $data , $other_data);
            }
        }
    }

}
