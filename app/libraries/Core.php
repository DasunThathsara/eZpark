<?php
    class Core {
        // URL format --> /controller/method/params
        protected $currentController = 'PageModel';
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

                // Check whether the method exists in the controller or not
                if (isset($url[1])){
                    if (method_exists($this->currentController, $url[1])){
                        $this->currentMethod = $url[1];
                        unset($url[1]);
                    } else {
                        // Method does not exist, display 404 error
                        $this->currentController->pageNotFound();
                        return;
                    }
                }

                // Get parameter list
                $this->param = $url ? array_values($url) : [];

                // Call method and pass the parameter list
                call_user_func_array([$this->currentController, $this->currentMethod], $this->param);
            }
            else {
                // Controller does not exist, display 404 error
                $this->currentController = new Controller();
                $this->currentController->pageNotFound();
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