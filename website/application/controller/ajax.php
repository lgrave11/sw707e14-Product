<?php
class Ajax extends Controller {
    public function index(){
    }

    public function searchStation($query = ""){
        $stationService = new StationService($this->db);

        $stations = $stationService->searchStation($query);
        require 'application/views/ajax/searchstation.php';
    }

    public function getBicyclePositions() 
    {
        $bicycleService = new BicycleService($this->db);
        $bicycles = $bicycleService->readAll();
        
        echo json_encode($bicycles);
    }

    public function getStations(){
    	$stationService = new StationService($this->db);
    	$stations = $stationService->readAllStations();

    	echo json_encode($stations);
    }

    public function getFreeBicyclesList(){
        $stationService = new StationService($this->db);
        echo json_encode($stationService->readAllAvailableBicycles());

    }

    public function getFreeDocksList(){
    	$stationService = new StationService($this->db);
    	echo json_encode($stationService->readAllAvailableDocks());
    }
}
?>