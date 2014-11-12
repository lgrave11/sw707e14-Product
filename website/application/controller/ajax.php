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
        if (empty($stationHistory)) {
            require 'application/views/ajax/nousagedata.php';
        } else {
            require 'application/views/ajax/graph.php';
        }
    }
    
    public function getTrafficUsageContent($id, $fromtime, $totime) {
        Tools::requireAdmin();
        /*
        $historyusagebicycleservice = new HistoryUsageBicycleService($this->db);
        $stationservice = new StationService($this->db);
        $bicycleData = array();
        
        $historyData = $historyusagebicycleservice->readHistoryBetween($id, $fromtime, $totime);
        
        foreach ($historyData as $data) {
            $start = $stationservice->readStation($data->start_station);
			$end = $stationservice->readStation($data->end_station);
            $obj = new StdClass();
            $obj->start_station = $start->name;
			$obj->start_time = date('d/m/Y H:i:s', $data->start_time);
			if (is_null($end)) {
				$obj->end_station = "";
				$obj->end_time = "";
			} else {
				$obj->end_station = $end->name;
				$obj->end_time = date('d/m/Y H:i:s', $data->end_time);
			}
            $bicycleData[] = $obj;
        }*/
        //if (empty($bicycleData)) {
        //    require 'application/views/ajax/nousagedata.php';
        //} else {
            require 'application/views/ajax/bicycleusage.php';
        //}
    }
    
    public function getStationHistory($station_id) {
        Tools::requireAdmin();
        

    }

    public function usageGraph($start_time, $end_time) {
        $navbarChosen = "";
        $count = 0;
        $hubs = new HistoryUsageBicycleService($this->db);
        $hist = $hubs->readHistoryBetween($start_time, $end_time);
        $a = array_pad(array(), 21, array_pad(array(), 21, 0));

        foreach($hist as $h)
        {
            $a[$h->start_station-1][$h->end_station-1]++;
            $count++;
        }

        for ($i = 0; $i < 21; $i++){
            for ($j = 0; $j < 21; $j++){
                if ($count != 0){
                    $a[$i][$j] = $a[$i][$j] / $count;
                }
            }
        }
        require 'application/views/ajax/usagegraph.php';
    }

    public function usageGraphNames() {
        $colors = array('#FF0000', '#FF4900', '#FF9200', '#FFDB00', '#DBFF00', '#92FF00', '#49FF00', '#00FF00', '#00FF49', '#00FF92', '#00FFDB', '#00DBFF', '#0092FF', '#0049FF', '#0000FF', '#4900FF', '#9200FF', '#DB00FF', '#FF00DB', '#FF0092', '#FF0049');

        $stationService = new StationService($this->db);
        $stations = $stationService->readAllStations();

        require 'application/views/ajax/usagegraphnames.php';
    }
}
?>
