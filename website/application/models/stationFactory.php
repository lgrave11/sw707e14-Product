<?php

class StationFactory extends BaseClass{

    public function readAddressForStation($station_id){
    	$stmt = $this->db->prepare("SELECT * FROM station WHERE station_id = ?");
    	$stmt->bind_param("i", $station_id);
    	$stmt->execute();
    	$stmt->bind_result($station_id, $name, $address);
    	$stmt->fetch();
    	$returnStation = new Station($station_id, $name, $address);
    	$stmt->close();
    	return $returnStation;
    }

    public function readAllStations(){
    	$returnArray = array();
    	$stmt = $this->db->prepare("SELECT * FROM station");
    	$stmt->bind_param();
    	$stmt->execute();
    	$stmt->bind_result($station_id, $name, $address);
    	while($stmt->fetch()){
    		$returnArray[$station_id] = new Station($station_id, $name, $address);
    	}
    	$stmt->close();
    	return $returnArray;
    }
}

?>