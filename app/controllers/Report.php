<?php
class Report extends Controller {
    public function __construct(){
        $this->middleware = new AuthMiddleware();
        // Only parkingOwner are allowed to access driver pages
        $this->middleware->checkAccess(['parkingOwner']);
        $this->parkingOwnerModel = $this->model('parkingOwnerModel');
        // $this->landModel = $this->model('LandModel');
    }

    public function viewReport($land_ID = null){

        $landId =  $_POST['landID'];

        $arr['landid'] = $landId;

        $data = $this->parkingOwnerModel->viewReport($arr);

        echo json_encode($data);

        // die(print_r($data));
        // $this->view('parkingOwner/report', $data);
    }
    
}