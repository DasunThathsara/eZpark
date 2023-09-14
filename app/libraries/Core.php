<?php
    class Core {
        // URL format --> /controller/method/params
        protected $currentController = 'Pages';
        protected $currentMethod = 'index';
        protected $param = [];

        public function __construct(){
            $url = $this->getURL();
            // CHeck requested controller is existing in the controllers folder
            if (file_exists('../app/controllers/'.ucwords($url[0]).'.php')){
                // If the controller exists, then load it
                $this->currentController = ucwords($url[0]);

                // Unset the controller in the url
                unset($url[0]);

                // Call the controller
                require_once '../app/controllers/'.$this->currentController.'.php';

                // Instantiate the controller
                $this->currentController = new $this->currentController;
            }
        }

        public function getURL(){
            if (isset($_GET['url'])){
                $url = rtrim($_GET['url'], '/');
                $url = filter_var($url, FILTER_SANITIZE_URL);
                return explode('/', $url);
            }
        }
    }