<?php
class Users extends Controller{
    public function __construct(){
        $this->userModel = $this->model('UserModel');
    }

    public function register(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Submitted form data
            // input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
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

            // Validation is completed and no error found
            if (empty($data['err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register user
                if ($this->userModel->register($data)){
                    die('register_success');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('users/register', $data);
            }

        } else {
            // Initial form data
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'err' => '',
            ];

            // Load view
            $this->view('users/register', $data);
        }
    }

    public function login(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Form is submitting
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Input data
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'err' => ''
            ];

            // Validate data
            // Validate email
            if (empty($data['email'])){
                $data['err'] = 'Please enter email';
            }
            else{
                if ($this->userModel->findUserByEmail($data['email'])){
                    // User found

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
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if ($loggedInUser){
                    // Create session
                    die('Success');
                }
                else{
                    $data['err'] = 'Password incorrect';

                    // Load view with errors
                    $this->view('users/login', $data);
                }
            }
            else{
                // Load view with errors
                $this->view('users/login', $data);
            }
        }
        else{
            // Initial form load
            $data = [
                'email' => '',
                'password' => '',
                'err' => ''
            ];

            // Load view
            $this->view('users/login', $data);
        }
    }
}