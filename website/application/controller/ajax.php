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
    
    public function getStationOptions() {
        $stationservice = new StationService($this->db);
        $stations = $stationservice->readAllStations();
        foreach ($stations as $station) {
            echo ViewHelper::generateHTMLSelectOption($station->name, array('value'=>$station->station_id));
        }
    }
    
    public function getBicycleOptions() {
        $bicycleservice = new BicycleService($this->db);
        $bicycles = array_map(function($b) { return $b->bicycle_id; }, $bicycleservice->readAll());
        foreach ($bicycles as $bicycle) {
            echo ViewHelper::generateHTMLSelectOption($bicycle, array('value'=>$bicycle));
        }
    }

    public function getFreeBicyclesList() {
        $stationService = new StationService($this->db);
        echo json_encode($stationService->readAllAvailableBicycles());

    }

    public function getFreeDocksList() {
    	$stationService = new StationService($this->db);
    	echo json_encode($stationService->readAllAvailableDocks());
    }
    
    public function getStationUsageContent($id, $fromtime, $totime) {
        Tools::requireAdmin();
        $historyUsageStationService = new historyUsageStationService($this->db);
        $historyUsageStation = new HistoryUsageStation(null, $id, null, null);
        $stationHistory = $historyUsageStationService->readAllHistoryForStation($historyUsageStation, $fromtime, $totime);
        print_r($stationHistory);
        require 'application/views/ajax/graph.php';
    }
    
    public function getBicycleUsageContent($id, $fromtime, $totime) {
        Tools::requireAdmin();
        
        $historyusagebicycleservice = new HistoryUsageBicycleService($this->db);
        $stationservice = new StationService($this->db);
        $bicycleData = array();
        
        $historyData = $historyusagebicycleservice->readHistoryBetween($id, $fromtime, $totime);
        
        foreach ($historyData as $data) {
            $station = $stationservice->readStation($data->station_id);
            $obj = new StdClass();
            $obj->station_name = $station->station_name;
            $obj->start_time = date('d/m/Y H:i:s', $data->start_time);
            $obj->end_time = date('d/m/Y H:i:s', $data->end_time);
            $bicycleData[] = $obj;
        }
        
        require 'application/views/ajax/bicycleusage.php';
    }
    
    public function getStationHistory($station_id) {
        Tools::requireAdmin();
        

    }   
}
?>
