<?php
class Ajax extends Controller {
    public function searchStation($query = ""){
        $stationService = new StationService($this->db);

        $stations = $stationService->searchStation($query);
        require 'application/views/ajax/searchstation.php';
    }

    public function freeBicycles($stationId){
        $stationService = new StationService($this->db);
        $station = new Station($stationId, null, null, null, null);
        $freeBicycles = $stationService->readAllAvailableBicyclesForStation($station);
        $freeDocks = $stationService->readAllAvailableDocksForStation($station);
        require 'application/views/ajax/freebicycles.php';
    }
}
?>