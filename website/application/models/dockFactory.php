<?php

class DockFactory{
	private $db = null;

	function __construct($db) {
        try {
            $this->db = $db;
        } catch (Exception $e) {
            exit('Database connection could not be established.');
        }
    }

    public function readHoldsBicycle($dock_id, $station_id){
    	$stmt = $this->db->prepare("SELECT holds_bicycle FROM dock WHERE dock_id = ? AND station_id = ?");
    	$stmt->bind_param("ii", $dock_id, $station_id);
    	$stmt->execute();
    	$stmt->bind_result($holds_bicycle);
    	$stmt->fetch();
    	$returnDock = new Dock($station_id, $dock_id, $holds_bicycle);
    	$stmt->close();
    	return $returnDock;
    }

    public function readAllDocksForStation($station_id){
    	$returnArray = array();
    	$stmt = $this->db->prepare("SELECT * FROM dock WHERE station_id = ?");
    	$stmt->bind_param("i", $station_id);
    	$stmt->execute();
    	$stmt->bind_result($station_id, $dock_id, $holds_bicycle);
    	while($stmt->fetch()){
    		$returnArray[$dock_id] = new Dock($station_id, $dock_id, $holds_bicycle);
    	}
    	$stmt->close();
    	return $returnArray;
    }
    
	/* Later usage maybe
    public function readAllAvailableDocksForStation($station_id, $holds_bicycle){
    	$returnArray = array();
    	$stmt = $this->db->prepare("SELECT * FROM dock WHERE station_id = ? AND holds_bicycle = ?");
    	$stmt->bind_param("ii", $station_id, $holds);
    	$stmt->execute();
    	$stmt->bind_result($station_id, $dock_id, $holds_bicycle);
    	while($stmt->fetch()){
    		$returnArray[$dock_id] = new Dock($station_id, $dock_id, $holds_bicycle);
    	}
    	$stmt->close();
    	return $returnArray;
    }*/

    public function readAllDocks(){
    	$returnArray = array();
    	$stmt = $this->db->prepare("SELECT * FROM dock");
    	$stmt->bind_param();
    	$stmt->execute();
    	$stmt->bind_result($station_id, $dock_id, $holds_bicycle);
    	while($stmt->fetch()){
    		$returnArray[$dock_id] = new Dock($station_id, $dock_id, $holds_bicycle);
    	}
    	$stmt->close();
    	return $returnArray;
    }
}
?>