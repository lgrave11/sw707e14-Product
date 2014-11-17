<?php
class Ajax extends Controller {
    public function index(){
        header("Location: /");
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
        $navbarChosen = "";
        $hubs = new HistoryUsageBicycleService($this->db);
        $stationService = new StationService($this->db);
        $hist = $hubs->readHistoryBetween($fromtime, $totime);
        $stationMapping = $stationService->readStationMapping();
        $a = array_pad(array(), count($stationMapping), array_pad(array(), count($stationMapping), 0));

        foreach($hist as $h)
        {
            $a[$stationMapping[$h->start_station]][$stationMapping[$h->end_station]]++;
        }
        
        if (empty($hist)) {
            require 'application/views/ajax/nousagedata.php';
        } else {
            require 'application/views/ajax/bicycleusage.php';
        }
    }

    public function usageGraphNames() {
        Tools::requireAdmin();
        $colors = array('#FF0000', '#FF4900', '#FF9200', '#FFDB00', '#DBFF00', '#92FF00', '#49FF00', '#00FF00', '#00FF49', '#00FF92', '#00FFDB', '#00DBFF', '#0092FF', '#0049FF', '#0000FF', '#4900FF', '#9200FF', '#DB00FF', '#FF00DB', '#FF0092', '#FF0049');
        //$colors = $this->distinctColors(40);
        
        $colors = array();
        for ($i = 0; $i < 40; $i++){
            array_push($colors, "#".dechex(mt_rand(50,255)).dechex(mt_rand(50,255)).dechex(mt_rand(50,255)));
        }
        $stationService = new StationService($this->db);
        $stations = $stationService->readAllStations(true);

        require 'application/views/ajax/usagegraphnames.php';
    }

    public function distinctColors($count) {
        $colors = array();
        for($hue = 0; $hue < 360; $hue += 360 / $count) {
            array_push($colors, $this->hsvToRgb($hue, 100, 100));
        }
        return $colors;
    }

    public function hsvToRgb($h, $s, $v) {
                
        // Make sure our arguments stay in-range
        $h = max(0, min(360, $h));
        $s = max(0, min(100, $s));
        $v = max(0, min(100, $v));
        
        // We accept saturation and value arguments from 0 to 100 because that's
        // how Photoshop represents those values. Internally, however, the
        // saturation and value are calculated from a range of 0 to 1. We make
        // That conversion here.
        $s /= 100;
        $v /= 100;
        
        if($s == 0) {
            // Achromatic (grey)
            $r = $g = $b = $v;
            return array(round($r * 255), round($g * 255), round($b * 255));
        }
        
        $h /= 60; // sector 0 to 5
        $i = floor($h);
        $f = $h - $i; // factorial part of h
        $p = $v * (1 - $s);
        $q = $v * (1 - $s * $f);
        $t = $v * (1 - $s * (1 - $f));

        switch($i) {
            case 0:
                $r = $v;
                $g = $t;
                $b = $p;
                break;
                
            case 1:
                $r = $q;
                $g = $v;
                $b = $p;
                break;
                
            case 2:
                $r = $p;
                $g = $v;
                $b = $t;
                break;
                
            case 3:
                $r = $p;
                $g = $q;
                $b = $v;
                break;
                
            case 4:
                $r = $t;
                $g = $p;
                $b = $v;
                break;
                
            default: // case 5:
                $r = $v;
                $g = $p;
                $b = $q;
        }
        
        return "#" . str_pad(dechex(round($r * 255)), 2, 0, STR_PAD_LEFT) . str_pad(dechex(round($g * 255)), 2, 0, STR_PAD_LEFT) . str_pad(dechex(round($b * 255)), 2, 0, STR_PAD_LEFT);
    }
}
?>
