<?php
class Users extends Controller{
    public function __construct(){
        $this->userModel = $this->model('UserModel');
        $this->landModel = $this->model('LandModel');
    }


    // User registration form
    public function register(){
        $data = [
            'title' => 'Register'
        ];
        $this->view('users/register', $data);
    }


    // Parking owner registration form
    public function parkingOwnerRegister(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'username' => trim($_POST['username']),
                'confirm_password' => trim($_POST['confirm_password']),
                'user_type' => trim($_POST['user_type']),
                'contact_no' => trim($_POST['contact_no']),
                'err' => ''
            ];

            // Validate data
            // Validate name
            if (empty($data['name'])){
                $data['err'] = 'Please enter name';
            }

            // Validate email
            if (empty($data['email'])){
                $data['err'] = 'Please enter email';
            } else {
                // Check email
                if ($this->userModel->findUserByEmail($data['email'])){
                    $data['err'] = 'Email is already taken';
                }
            }

            // Validate username
            if (empty($data['username'])){
                $data['err'] = 'Please enter username';
            } else {
                // Check email
                if ($this->userModel->findUserByUsername($data['username'])){
                    $data['err'] = 'Username is already taken';
                }
            }

            // Validate password
            if (empty($data['password'])){
                $data['err'] = 'Please enter password';
            } elseif (strlen($data['password']) < 6){
                $data['err'] = 'Password must be at least 6 characters';
            }

            // Validate confirm password
            if (empty($data['confirm_password'])){
                $data['err'] = 'Please confirm password';
            } else {
                if ($data['password'] != $data['confirm_password']){
                    $data['err'] = 'Passwords do not match';
                }
            }

            // Validate user type
            if (empty($data['user_type'])){
                $data['err'] = 'Please select user type';
            }

            // Validate contact number
            if (empty($data['contact_no'])){
                $data['err'] = 'Please enter contact number';
            }

            // Validation is completed and no error found
            if (empty($data['err'])){
                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register user
                if ($this->userModel->register($data)){
                    redirect('users/emailVerify/'.$data['username']);
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('users/parkingOwnerRegister', $data);
            }
        } else {
            // Initial form data
            $data = [
                'name' => '',
                'email' => '',
                'username' => '',
                'password' => '',
                'confirm_password' => '',
                'user_type' => '',
                'contact_no' => '',
                'err' => '',
            ];

            // Load view
            $this->view('users/parkingOwnerRegister', $data);
        }
    }


    // Driver registration form
    public function driverRegister(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'username' => trim($_POST['username']),
                'confirm_password' => trim($_POST['confirm_password']),
                'user_type' => trim($_POST['user_type']),
                'contact_no' => trim($_POST['contact_no']),
                'err' => ''
            ];

            // Validate data
            // Validate name
            if (empty($data['name'])){
                $data['err'] = 'Please enter name';
            }

            // Validate email
            if (empty($data['email'])){
                $data['err'] = 'Please enter email';
            } else {
                // Check email
                if ($this->userModel->findUserByEmail($data['email'])){
                    $data['err'] = 'Email is already taken';
                }
            }

            // Validate username
            if (empty($data['username'])){
                $data['err'] = 'Please enter username';
            } else {
                // Check email
                if ($this->userModel->findUserByUsername($data['username'])){
                    $data['err'] = 'Username is already taken';
                }
            }

            // Validate password
            if (empty($data['password'])){
                $data['err'] = 'Please enter password';
            } elseif (strlen($data['password']) < 6){
                $data['err'] = 'Password must be at least 6 characters';
            }

            // Validate confirm password
            if (empty($data['confirm_password'])){
                $data['err'] = 'Please confirm password';
            } else {
                if ($data['password'] != $data['confirm_password']){
                    $data['err'] = 'Passwords do not match';
                }
            }

            // Validate user type
            if (empty($data['user_type'])){
                $data['err'] = 'Please select user type';
            }

            // Validate contact number
            if (empty($data['contact_no'])){
                $data['err'] = 'Please enter contact number';
            }

            // Validation is completed and no error found
            if (empty($data['err'])){
                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register user
                if ($this->userModel->register($data)){
                    redirect('users/emailVerify/'.$data['username']);
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('users/driverRegister', $data);
            }

        } else {
            // Initial form data
            $data = [
                'name' => '',
                'email' => '',
                'username' => '',
                'password' => '',
                'confirm_password' => '',
                'user_type' => '',
                'contact_no' => '',
                'err' => '',
            ];

            // Load view
            $this->view('users/driverRegister', $data);
        }
    }

    // PMerchandiser registration form
    public function merchandiserRegister(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'username' => trim($_POST['username']),
                'confirm_password' => trim($_POST['confirm_password']),
                'user_type' => trim($_POST['user_type']),
                'contact_no' => trim($_POST['contact_no']),
                'website' => trim($_POST['website']),
                'merchantName' => trim($_POST['merchantName']),
                'merchantType' => trim($_POST['merchantType']),
                'err' => ''
            ];

            // Validate data
            // Validate name
            if (empty($data['name'])){
                $data['err'] = 'Please enter name';
            }

            // Validate email
            if (empty($data['email'])){
                $data['err'] = 'Please enter email';
            } else {
                // Check email
                if ($this->userModel->findUserByEmail($data['email'])){
                    $data['err'] = 'Email is already taken';
                }
            }

            // Validate username
            if (empty($data['username'])){
                $data['err'] = 'Please enter username';
            } else {
                // Check email
                if ($this->userModel->findUserByUsername($data['username'])){
                    $data['err'] = 'Username is already taken';
                }
            }

            // Validate password
            if (empty($data['password'])){
                $data['err'] = 'Please enter password';
            } elseif (strlen($data['password']) < 6){
                $data['err'] = 'Password must be at least 6 characters';
            }

            // Validate confirm password
            if (empty($data['confirm_password'])){
                $data['err'] = 'Please confirm password';
            } else {
                if ($data['password'] != $data['confirm_password']){
                    $data['err'] = 'Passwords do not match';
                }
            }

            // Validate user type
            if (empty($data['user_type'])){
                $data['err'] = 'Please select user type';
            }

            // Validate contact number
            if (empty($data['contact_no'])){
                $data['err'] = 'Please enter contact number';
            }

            // Validation is completed and no error found
            if (empty($data['err'])){
                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register user
                if ($this->userModel->register($data)){
                    redirect('users/emailVerify/'.$data['username']);
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('users/merchandiserRegister', $data);
            }

        } else {
            // Initial form data
            $data = [
                'name' => '',
                'email' => '',
                'username' => '',
                'password' => '',
                'confirm_password' => '',
                'user_type' => '',
                'contact_no' => '',
                'website' => '',
                'merchantName' => '',
                'merchantType' => '',
                'err' => '',
            ];

            // Load view
            $this->view('users/merchandiserRegister', $data);
        }
    }

    // Security registration form
    public function securityRegister(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'username' => trim($_POST['username']),
                'confirm_password' => trim($_POST['confirm_password']),
                'user_type' => trim($_POST['user_type']),
                'contact_no' => trim($_POST['contact_no']),
                'NIC' => trim($_POST['NIC']),
                'experience' => trim($_POST['experience']),
                'city' => trim($_POST['city']),
                'address' => trim($_POST['address']),
                'err' => ''
            ];

            // Validate data
            // Validate name
            if (empty($data['name'])){
                $data['err'] = 'Please enter name';
            }

            // Validate email
            if (empty($data['email']) and $data['err'] == ''){
                $data['err'] = 'Please enter email';
            } else {
                // Check email
                if ($this->userModel->findUserByEmail($data['email']) and $data['err'] == ''){
                    $data['err'] = 'Email is already taken';
                }
            }

            // Validate username
            if (empty($data['username']) and $data['err'] == ''){
                $data['err'] = 'Please enter username';
            } else {
                // Check email
                if ($this->userModel->findUserByUsername($data['username']) and $data['err'] == ''){
                    $data['err'] = 'Username is already taken';
                }
            }

            // Validate password
            if (empty($data['password']) and $data['err'] == ''){
                $data['err'] = 'Please enter password';
            } elseif (strlen($data['password']) < 6 and $data['err'] == ''){
                $data['err'] = 'Password must be at least 6 characters';
            }

            // Validate confirm password
            if (empty($data['confirm_password']) and $data['err'] == ''){
                $data['err'] = 'Please confirm password';
            } else {
                if ($data['password'] != $data['confirm_password'] and $data['err'] == ''){
                    $data['err'] = 'Passwords do not match';
                }
            }

            // Validate user type
            if (empty($data['user_type']) and $data['err'] == ''){
                $data['err'] = 'Please select user type';
            }

            // Validate contact number
            if (empty($data['contact_no']) and $data['err'] == '' and $data['err'] == ''){
                $data['err'] = 'Please enter contact number';
            }

            // Validate NIC
            if (empty($data['NIC']) and $data['err'] == ''){
                $data['err'] = 'Please enter NIC';
            }
            else if (strlen($data['NIC']) == 10 and ($data['NIC'][9] == 'V' or $data['NIC'][9] == 'v')){
                $data['err'] = '';
            }
            else if (strlen($data['NIC']) == 12 and ctype_digit($data['NIC'])){
                $data['err'] = '';
            }
            else{
                $data['err'] = 'Invalid NIC';
            }

            // Validate address
            if (empty($data['address']) and $data['err'] == ''){
                $data['err'] = 'Please enter address';
            }

            // Validate city
            if (empty($data['city']) and $data['err'] == ''){
                $data['err'] = 'Please select city';
            }

            $province = ['Northern' => ['Jaffna', 'Kilinochchi', 'Mannar', 'Mullaitivu', 'Vavuniya'], 'North Western' => ['Kurunegala', 'Puttalam'], 'Western' => ['Colombo', 'Gampaha', 'Kalutara'], 'North Central' => ['Anuradhapura', 'Polonnaruwa'], 'Central' => ['Kandy', 'Matale', 'Nuwara Eliya'], 'Sabaragamuwa' => ['Kegalle', 'Ratnapura'], 'Southern' => ['Galle', 'Matara', 'Hambantota'], 'Uva' => ['Badulla', 'Monaragala'], 'Eastern' => ['Ampara', 'Batticaloa', 'Trincomalee']];
            $flag = 0;
            foreach ($province as $key => $value){
                if (in_array($data['city'], $value)){
                    $data['province'] = $key;
                    $flag = 1;
                    break;
                }
            }

            if ($flag == 0){
                $data['err'] = 'Invalid District';
            }

            // Validation is completed and no error found
            if (empty($data['err'])){
                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register user
                if ($this->userModel->register($data)){
                    redirect('users/emailVerify/'.$data['username']);
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('users/securityRegister', $data);
            }

        } else {
            // Initial form data
            $data = [
                'name' => '',
                'email' => '',
                'username' => '',
                'password' => '',
                'confirm_password' => '',
                'user_type' => '',
                'contact_no' => '',
                'NIC' => '',
                'experience' => '',
                'err' => '',
                'city' => '',
                'address' => ''
            ];

            // Load view
            $this->view('users/securityRegister', $data);
        }
    }

    // Admin registration form
    public function adminRegister(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'username' => trim($_POST['username']),
                'confirm_password' => trim($_POST['confirm_password']),
                'user_type' => 'admin',
                'contact_no' => trim($_POST['contact_no']),
                'err' => ''
            ];

            // Validate data
            // Validate name
            if (empty($data['name'])){
                $data['err'] = 'Please enter name';
            }

            // Validate email
            if (empty($data['email'])){
                $data['err'] = 'Please enter email';
            } else {
                // Check email
                if ($this->userModel->findUserByEmail($data['email'])){
                    $data['err'] = 'Email is already taken';
                }
            }

            // Validate username
            if (empty($data['username'])){
                $data['err'] = 'Please enter username';
            } else {
                // Check email
                if ($this->userModel->findUserByUsername($data['username'])){
                    $data['err'] = 'Username is already taken';
                }
            }

            // Validate password
            if (empty($data['password'])){
                $data['err'] = 'Please enter password';
            } elseif (strlen($data['password']) < 6){
                $data['err'] = 'Password must be at least 6 characters';
            }

            // Validate confirm password
            if (empty($data['confirm_password'])){
                $data['err'] = 'Please confirm password';
            } else {
                if ($data['password'] != $data['confirm_password']){
                    $data['err'] = 'Passwords do not match';
                }
            }

            // Validate contact number
            if (empty($data['contact_no'])){
                $data['err'] = 'Please enter contact number';
            }

            // Validation is completed and no error found
            if (empty($data['err'])){
                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register user
                if ($this->userModel->register($data)){
                    redirect('superAdmin/viewAdmins');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('superAdmin/admins/add', $data);
            }

        }
    }

    public function verifiedMessage(){
        // Initial form load
        $data = [
            'email' => '',
            'username' => '',
            'password' => '',
            'err' => ''
        ];

        // Load view
        $this->view('users/verifiedMessage', $data);
    }

    public function emailVerify($username = null){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Form is submitting
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Input data
            $data = [
                'email' => trim($_POST['email']),
                'username' => trim($_POST['email']),
                'otp' => trim($_POST['otp']),
                'err' => ''
            ];

            // Validate data
            // Validate email
            if (empty($data['email'])){
                $data['err'] = 'Please enter email';
            }
            else{
                if ($this->userModel->findUserByEmailV($data['email'], 0) or $this->userModel->findUserByUsernameV($data['username'], 0)){
                    // User found
                }
                else{
                    // User not found
                    $data['err'] = 'No user found';
                }
            }

            // Validate password
            if (empty($data['otp'])){
                $data['err'] = 'Invalid OTP';
            }

            $user_data = $this->userModel->getUserByUsername($data['username']);

            $date1 = new DateTime($user_data->otpTime);
            $date2 = new DateTime(date("Y-m-d H:i:s"));

            $interval = $date1->diff($date2);

            if ($interval->format('%i') > 5){
                $data['err'] = 'OTP expired';
            }


            // Check if error is empty
            if (empty($data['err'])){
                // log the user

                if ($user_data){
                    if ($user_data->otp == $data['otp']){
                        $this->userModel->updateStatus($user_data->id);
                        redirect('users/verifiedMessage');
                    }
                    else{
                        $user_data->err = 'Incorrect OTP';

                        // Load view with errors
                        $this->view('users/emailVerify', $user_data);
                    }
                }
                else{
                    $user_data->err = 'Incorrect OTP';

                    // Load view with errors
                    $this->view('users/emailVerify', $user_data);
                }
            }
            else{
                // Load view with errors
                $user_data->err = $data['err'];
                $this->view('users/emailVerify', $user_data);
            }
        }
        else{
            // Initial form load
            $data = $this->userModel->getUserByUsername($username);

            if ($data->status == 1){
                redirect('users/login');
            }
            else{
                $this->view('users/emailVerify', $data);
            }

        }
    }

    public function resendOTP($username = null){
        $fetched_data = $this->userModel->getUserByUsername($username);
        $data = [
            'email' => $fetched_data->email,
            'name' => $fetched_data->name,
            'id' => $fetched_data->id
        ];

        $this->userModel->resendOTP($data);

        $this->emailVerify($username);
    }

    public function login(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Unban users according to the time
            $this->userModel->UnbanAccordingTime();

            // Form is submitting
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Input data
            $data = [
                'email' => trim($_POST['email']),
                'username' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'remember_me' => isset($_POST['remember_me']),
                'err' => ''
            ];

            // Validate data
            // Validate email
            if (empty($data['email'])){
                $data['err'] = 'Please enter email';
            }
            else{
                if ($this->userModel->findUserByEmailV($data['email'], 1) or $this->userModel->findUserByUsernameV($data['username'], 1)){
                    // nothin changed
                }
                // Check user is ban, active or not
                else if($this->userModel->checkStatus($data['email']) == 2){
                    $data['err'] = 'You have no access to login';
                }
                else if($this->userModel->checkStatus($data['email']) == 5) {
                    $data['err'] = 'User was inactive'; 
                }
                else{
                    // User not found
                    $data['err'] = 'No user found';
                }
            }

            // Validate password
            if (empty($data['password'])){
                $data['err'] = 'Please enter password';
            }

            // Check if error is empty
            if (empty($data['err'])){
                // log the user
                $loggedInUser = $this->userModel->login($data['email'], $data['password'], $data['username']);
                if ($loggedInUser){
                    // Create session
                    $this->createUserSession($loggedInUser);

                    // If "Remember Me" is checked, set a cookie
                    if ($data['remember_me']) {
                        $this->setRememberMeCookie($loggedInUser->id);
                    }
                }
                else{
                    $data['err'] = 'Password incorrect';

                    // Load view with errors
                    $this->view('users/login', $data);
                }
            }
            else{
                 $this->view('users/login', $data);
                }
            }
        
        else{
            // Unban users according to the time
            $this->userModel->UnbanAccordingTime();

            // Initial form load
            $data = [
                'email' => '',
                'username' => '',
                'password' => '',
                'err' => ''
            ];

            // Load view
            $this->view('users/login', $data);
        }
    }

    // Function to set a "Remember Me" cookie
    private function setRememberMeCookie($userId) {
        // Generate a unique token or identifier
        $token = uniqid();

        // Store the token in the database (you may need to create a "remember_tokens" table for this)
        $this->userModel->storeRememberToken($userId, $token);

        // Set a cookie with the token (you may want to set an expiration time)
        setcookie('remember_me', $token, time() + 3600 * 24 * 30, '/');
    }

    // Create the session
    public function createUserSession($user){
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['username'] = $user->username;
        $_SESSION['user_name'] = $user->name;
        $_SESSION['user_type'] = $user->userType;
        $_SESSION['contact_no'] = $user->contactNo;
        $_SESSION['profile_photo'] = $user->profilePhoto;

        redirect($_SESSION['user_type'].'/index');
    }

    // Logout function
    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['username']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_type']);
        unset($_SESSION['contact_no']);
        unset($_SESSION['profile_photo']);

        session_destroy();

        redirect('users/login');
    }

    // Check if user is logged in
    public function isLoggedIn(){
        if (isset($_SESSION['user_id'])){
            return true;
        }
        else{
            return false;
        }
    }

    // Check if user is logged in
    public function checkLogin() {
        if (!isset($_SESSION['user_id'])) {
            redirect('users/login');
        } else {
            $userType = $_SESSION['user_type'];
            switch ($userType) {
                case 'driver':
                    redirect('driver/index');
                    break;
                case 'parkingOwner':
                    redirect('parkingOwner/index');
                    break;
                case 'security':
                    redirect('security/index');
                    break;
                case 'merchandiser':
                    redirect('merchandiser/index');
                    break;
                case 'superAdmin':
                    redirect('superAdmin/index');
                    break;
                default:
                    redirect('pages/index');
            }
        }
    }

    public function viewProfile(){
        $data = [
            'title' => 'Profile',
            'email' => $_SESSION['user_email'],
            'username' => $_SESSION['username'],
            'name' => $_SESSION['user_name'],
            'contact_no' => $_SESSION['contact_no'],
            'profile_photo' => $_SESSION['profile_photo']
        ];

        $other_data['notification_count'] = $this->landModel->getUnVerifyLandCount();

        if ($other_data['notification_count'] < 10)
            $other_data['notification_count'] = '0'.$other_data['notification_count'];

        $this->view('users/profile', $data, $other_data);
    }

    public function imgUpload($profile_photo){
        $data = [
            'profile_photo' => '',
            'err' => ''
        ];

        $img_name = $_FILES[$profile_photo]['name'];
        $img_size = $_FILES[$profile_photo]['size'];
        $tmp_name = $_FILES[$profile_photo]['tmp_name'];
        $error = $_FILES[$profile_photo]['error'];

        if ($error === 0){
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);

            $allowed_exs = array("jpg", "jpeg", "png");

            if (in_array($img_ex_lc, $allowed_exs)){
                // Move into mag_img folder
                $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                $img_upload_path = PUBLICROOT.'/profile_pics/'.$new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);

                $data['profile_photo'] = $new_img_name;
                return $data;
            }

            else{
                $data['err'] = "You can't upload files of this type";
                return $data;
            }
        }
    }

    public function profilePhotoRemove(){
        if ($this->userModel->removeProfilePhoto()){
            $img_path = PUBLICROOT.'/profile_pics/'.$_SESSION['profile_photo'];
            if (file_exists($img_path)) {
                unlink($img_path);
            }
            $_SESSION['profile_photo'] = '';
            redirect($_SESSION['user_type'].'/index');
        } else {
            die('Something went wrong');
        }
    }

    public function updateProfile(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'username' => trim($_POST['username']),
                'contact_no' => trim($_POST['contact_no']),
                'profile_photo' => '',
                'err' => ''
            ];

            if(isset($_FILES['profile_photo'])){
                $img_details = $this->imgUpload('profile_photo');
                $data['profile_photo'] = $img_details['profile_photo'];
                $data['err'] = $img_details['err'];
            }

            // Validate data
            // Validate name
            if (empty($data['name'])){
                $data['err'] = 'Please enter name';
            }

            // Validate email
            if (empty($data['email'])){
                $data['err'] = 'Please enter email';
            } else {
                // Check email
                if ($data['email'] != $_SESSION['user_email'] and $this->userModel->findUserByEmail($data['email'])){
                    $data['err'] = 'Email is already taken';
                }
            }

            // Validate username
            if (empty($data['username'])){
                $data['err'] = 'Please enter username';
            } else {
                // Check email
                if ($data['username'] != $_SESSION['username'] and $this->userModel->findUserByUsername($data['username'])){
                    $data['err'] = 'Username is already taken';
                }
            }

            // Validate contact number
            if (empty($data['contact_no'])){
                $data['err'] = 'Please enter contact number';
            }

//            die(print_r($data));

            // Validation is completed and no error found
            if (empty($data['err'])){
                // Update user
                if ($this->userModel->updateProfile($data)){
                    $_SESSION['user_email'] = $data['email'];
                    $_SESSION['username'] = $data['username'];
                    $_SESSION['user_name'] = $data['name'];
                    $_SESSION['contact_no'] = $data['contact_no'];
                    $_SESSION['profile_photo'] = $data['profile_photo'];
                    redirect($_SESSION['user_type'].'/index');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('users/profile', $data);
            }

        } else {
            // Initial form data
            $data = [
                'name' => '',
                'email' => '',
                'username' => '',
                'contact_no' => '',
                'err' => '',
            ];

            // Load view
            $this->view('users/viewProfile', $data);
        }
    }

    // View notifications
    public function notifications() {
        $data = [
            'title' => 'Notifications',
            'notifications' => 0
        ];

        $notifications['list'] = $this->userModel->viewNotifications();
        $notifications['notification_count'] = $this->userModel->getNotificationCount();

        if ($notifications['notification_count'] < 10)
            $notifications['notification_count'] = '0'.$notifications['notification_count'];

        $this->view('users/notifications', $data, $notifications);
    }

    // Remove notification
    public function removeNotification() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $id = trim($_POST['id']);
            if ($this->userModel->removeNotificationByID($id)) {
                redirect('users/notifications');
            } else {
                die('Something went wrong');
            }
        }
    }

    // Mark as read notification
    public function markAsReadNotification() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $id = trim($_POST['id']);
            if ($this->userModel->markAsRead($id)) {
                redirect('users/notifications');
            } else {
                die('Something went wrong');
            }
        }
    }
}
