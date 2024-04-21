<?php
class Report extends Controller {
    public function __construct(){
        $this->middleware = new AuthMiddleware();
        // Only parkingOwner are allowed to access driver pages
        //$this->middleware->checkAccess(['parkingOwner']);
        // $this->middleware->checkAccess(['merchandiser']);
        $this->middleware->checkAccess(['parkingOwner', 'merchandiser']);
        $this->parkingOwnerModel = $this->model('ParkingOwnerModel');
        $this->merchandiserModel = $this->model('MerchandiserModel');
        // $this->landModel = $this->model('LandModel');
    }

    public function viewReport($land_ID = null,$start_DATE = null , $end_DATE = null){

        $landId =  $_POST['landID'];
        $sTime =  $_POST['startDate'];
        $eTime =  $_POST['endDate'];

        $arr['landid'] = $landId;
        $arr['sdate'] = $sTime;
        $arr['edate'] = $eTime;

        if ($_SESSION['user_type'] == 'merchandiser'){
            $data = $this->merchandiserModel->viewReport($arr);
        }
        else if ($_SESSION['user_type'] == 'parkingOwner'){
            $data = $this->parkingOwnerModel->viewReport($arr);
        }
        

        echo json_encode($data);
    }
}