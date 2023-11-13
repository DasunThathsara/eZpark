<?php
    class Controller{
        // To load the model
        public function model($model){
            require_once '../app/models/'.$model.'.php';

            // Instantiate the model and pass it to the controller member variable
            return new $model();
        }

        // To load the view
        public function view($view, $data = [], $other_data = []){
            if (file_exists('../app/views/'.$view.'.php')){
                require_once '../app/views/'.$view.'.php';
            }
            else{
                die('Corresponding view does not exist');
            }
        }

        // 404 Error
        public function pageNotFound(){
            http_response_code(404);
            $this->view('404');
        }
    }