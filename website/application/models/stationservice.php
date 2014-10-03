<?php

class StationService implements iService
{
	private $db = null;
	
	function __construct($db) {
        try {
            $this->db = $db;
        } catch (Exception $e) {
            exit('Database connection could not be established.');
        }
    }

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

    public function create($station){
        $stmt = $this->db->prepare("INSERT INTO station(station_id, name, address) VALUES (?,?,?)");
        $stmt->bind_param("iii", $station->station_id, $station->name, $station->address);
        $stmt->execute();
        $stmt->close();
        return $station;
    }

        public function update($station){
        $stmt = $this->db->prepare("UPDATE station set name = ?, address = ? WHERE station_id = ?");
        $stmt->bind_param("iii", $station->name, $station->address, $station->station_id);
        $stmt->execute();
        $stmt->close();
        return $dock;
    }

    public function delete($station){
        $stmt = $this->db->prepare("DELETE FROM station WHERE station_id = ?")
        $stmt->bind_param("i", $station->station_id);
        $stmt->execute();
        $stmt->close();
    }
}

?>