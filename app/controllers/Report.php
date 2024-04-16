<?php
class Report extends Controller {
    public function __construct(){
        $this->middleware = new AuthMiddleware();
        // Only parkingOwner are allowed to access driver pages
        $this->middleware->checkAccess(['parkingOwner']);
        $this->parkingOwnerModel = $this->model('parkingOwnerModel');
        // $this->landModel = $this->model('LandModel');
    }

    public function viewReport($land_ID = null,$start_DATE = null , $end_DATE = null){

        $landId =  $_POST['landID'];
        $sTime =  $_POST['startDate'];
        $eTime =  $_POST['endDate'];

        $arr['landid'] = $landId;
        $arr['sdate'] = $sTime;
        $arr['edate'] = $eTime;

        $data = $this->parkingOwnerModel->viewReport($arr);

        echo json_encode($data);

        // die(print_r($data));
        // $this->view('parkingOwner/report', $data);
    }
    
}