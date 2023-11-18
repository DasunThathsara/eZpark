<?php
class LandCapacity extends Controller
{
    public function __construct()
    {
        $this->middleware = new AuthMiddleware();
        // Only parkingOwners are allowed to access parkingOwner pages
        $this->middleware->checkAccess(['parkingOwner']);
        $this->parkingOwnerModel = $this->model('ParkingOwnerModel');
    }

    // View capacity
    public function viewCapacity($parking_ID = null, $parking_name = null){
        $data = [
            'id' => $parking_ID,
            'name' => $parking_name
        ];

        $capacity = $this->parkingOwnerModel->viewCapacity($data);

        $this->view('parkingOwner/capacity/viewCapacity', $data, $capacity);
    }
}
