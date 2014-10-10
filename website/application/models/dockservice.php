<?php

class DockService implements iService{
	private $db = null;

	function __construct($db) {
        try {
            $this->db = $db;
        } catch (Exception $e) {
            exit('Database connection could not be established.');
        }
    }

    public function readHoldsBicycle($dock){
        if(validate($dock))
        {
        	$stmt = $this->db->prepare("SELECT holds_bicycle FROM dock WHERE dock_id = ? AND station_id = ?");
        	$stmt->bind_param("ii", $dock->dock_id, $dock->station_id);
        	$stmt->execute();
        	$stmt->bind_result($holds_bicycle);
        	$stmt->fetch();
        	$stmt->close();
        	return new Dock($dock->dock_id, $dock->station_id, $holds_bicycle);
        }
        else
        {
            return null;
        }
    }

    public function readAllDocksForStation($station_id){
    	$returnArray = array();
    	$stmt = $this->db->prepare("SELECT * FROM dock WHERE station_id = ?");
    	$stmt->bind_param("i", $station_id);
    	$stmt->execute();
    	$stmt->bind_result($dock_id, $station_id, $holds_bicycle);
    	while($stmt->fetch()){
    		$returnArray[$dock_id] = new Dock($dock_id, $station_id, $holds_bicycle);
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
    	$stmt->execute();
    	$stmt->bind_result($dock_id, $station_id, $holds_bicycle);
    	while($stmt->fetch()){
    		$returnArray[$dock_id] = new Dock($dock_id, $station_id, $holds_bicycle);
    	}
    	$stmt->close();
    	return $returnArray;
    }

    public function create($dock){
        if(validate($dock))
        {
        	$stmt = $this->db->prepare("INSERT INTO dock(station_id) VALUES (?)");
            $stmt->bind_param("i", $dock->station_id);
            $stmt->execute();
            $id = $this->db->insert_id;
            $stmt->close();

            return new Dock($station_id, $id, null);
        }
        else
        {
            return null;
        }
    }

    public function update($dock){
        if(validate($dock))
        {
        	$stmt = $this->db->prepare("UPDATE dock set station_id = ?, holds_bicycle = ? WHERE dock_id = ?");
        	$stmt->bind_param("iii", $dock->station_id, $dock->holds_bicycle, $dock->dock_id);
        	$stmt->execute();
        	$stmt->close();
        	return $dock;
        }
        else
        {
            return null;
        }
    }

    public function delete($dock){
        if(validate($dock))
        {
        	$stmt = $this->db->prepare("DELETE FROM dock WHERE dock_id = ?, station_id = ?");
        	$stmt->bind_param("ii", $dock->dock_id, $dock->station_id);
        	$stmt->execute();
        	$stmt->close();
            return true;
        }
        else
        {
            return false;
        }
    }

    public function validate($dock)
    {
        // TODO: Check that the station id exists
        return true;
    }
}
?>
