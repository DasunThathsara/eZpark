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
    public function packageRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
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

            if (empty($data['price'])) {
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
                print_r($data);
                print_r($_SESSION['user_id']);
                if ($this->parkingOwnerModel->registerPackage($data)) {
                    redirect('parkingOwner/packages');
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
    public function packageRemove()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name'])
            ];

            // Delete the package
            if ($this->parkingOwnerModel->removePackage($data)) {
                redirect('parkingOwner/packages');
            } else {
                die('Something went wrong');
            }
        }
    }

    // Update package
    public function packageUpdateForm()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
                'name' => trim($_POST['name']),
                'old_name' => trim($_POST['old_name']),
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

            if (empty($data['price'])) {
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
                print_r($_SESSION['user_id']);
                if ($this->parkingOwnerModel->updatePackage($data)) {
                    redirect('parkingOwner/packages');
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
