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
    
    public function read($id){
        $stmt = $this->db->prepare("SELECT * FROM dock WHERE dock_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($dock_id, $station_id, $holds_bicycle);
        $stmt->fetch();
        return new Dock($dock_id, $station_id, $holds_bicycle);
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
    
    public function readAllDocksWithoutBicycleWithStationName(){
        $returnArray = array();
        $stmt = $this->db->prepare("SELECT dock.dock_id, dock.station_id, dock.holds_bicycle, station.name FROM dock, station WHERE dock.holds_bicycle IS NULL AND station.station_id = dock.station_id AND station.deleted = false");
        $stmt->execute();
        $stmt->bind_result($dock_id, $station_id, $holds_bicycle, $name);
        while($stmt->fetch()){
            $cls = new stdclass();
            $cls->dock_id = $dock_id;
            $cls->station_id = $station_id;
            $cls->holds_bicycle = $holds_bicycle;
            $cls->name = $name;
            $returnArray[] = $cls;
        }
        $stmt->close();
        return $returnArray;
    }

    public function create($dock){
        if($this->validate($dock))
        {
            $stmt = $this->db->prepare("INSERT INTO dock(station_id) VALUES (?)");
            $stmt->bind_param("i", $dock->station_id);
            $stmt->execute();
            $id = $this->db->insert_id;
            $stmt->close();

            WebsiteToStationNotifier::notifyStationDockChanged("addDock", $dock->station_id, $id);
            return new Dock($id, $dock->station_id, null);
        }
        else
        {
            return null;
        }
    }

    public function update($dock){
        if($this->validate($dock))
        {
            // Cannot change the station id for a dock, add a new dock instead.
            $stmt = $this->db->prepare("UPDATE dock SET holds_bicycle = ? WHERE dock_id = ?");
            $stmt->bind_param("ii", $dock->holds_bicycle, $dock->dock_id);
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
        if($this->validate($dock))
        {
            $stmt = $this->db->prepare("DELETE FROM dock WHERE dock_id = ? AND station_id = ?");
            $stmt->bind_param("ii", $dock->dock_id, $dock->station_id);
            $stmt->execute();
            $stmt->close();
            WebsiteToStationNotifier::notifyStationDockChanged("removeDock", $dock->station_id, $dock->dock_id);
            return true;
        }
        else
        {
            return false;
        }
    }

    public function validate($dock)
    {
        $valid = true;
        // Check that the station exists
        $stationservice = new StationService($this->db);
        if(empty($dock->station_id))
        {
            $valid = false;
        }
        else
        {
            $station = $stationservice->read($dock->station_id);
            if(empty($station))
            {
                $valid = false;
            }
        }
        return $valid;
    }
}
?>
