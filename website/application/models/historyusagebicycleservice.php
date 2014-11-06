<?php

class HistoryUsageBicycleService implements iService
{
	private $db = null;
	
	function __construct($db) {
        try {
            $this->db = $db;
        } catch (Exception $e) {
            exit('Database connection could not be established.');
        }
    }

    public function readAllHistory(){
        $returnArray = array();
        $stmt = $this->db->prepare("SELECT * FROM historyusagebicycle");
        $stmt->execute();
        $stmt->bind_result($id, $bicycle_id, $start_station, $start_time, $end_station, $end_time, $booking_id);
        while($stmt->fetch()){
            array_push($returnArray, new HistoryUsageBicycle($id, $bicycle_id, $start_station, $start_time, $end_station, $end_time, $booking_id));
        }
        return $returnArray;
    }

    public function readAllHistoryForBicycle($historyusagebicycle){
        $returnArray = array();
        $stmt = $this->db->prepare("SELECT * FROM historyusagebicycle WHERE bicycle_id = ?");
        $stmt->bind_param("i", $historyusagebicycle->bicycle_id);
        $stmt->execute();
        $stmt->bind_result($id, $bicycle_id, $start_station, $start_time, $end_station, $end_time, $booking_id);
        while($stmt->fetch()){
            array_push($returnArray, new HistoryUsageBicycle($id, $bicycle_id, $start_station, $start_time, $end_station, $end_time, $booking_id));
        }
        return $returnArray;
    }
    
    public function readHistoryBetween($bicycle_id, $fromtime, $totime) {
        $returnArray = array();
        $stmt = $this->db->prepare("SELECT * FROM historyusagebicycle WHERE bicycle_id = ? AND start_time >= ? AND end_time <= ?");
        $stmt->bind_param("iii", $bicycle_id, $fromtime, $totime);
        $stmt->execute();
        $stmt->bind_result($id, $bicycle_id, $start_station, $start_time, $end_station, $end_time, $booking_id);
        
        while($stmt->fetch()) {
            array_push($returnArray, new HistoryUsageBicycle($id, $bicycle_id, $start_station, $start_time, $end_station, $end_time, $booking_id));
        }
        
        $stmt->free_result();
        $stmt->close();
        
        return $returnArray;
    }
    
    public function create($obj) {
    
    }
    
    public function update($obj) {
    
    }

    /* NYI
    public function create($station){
        $stmt = $this->db->prepare("INSERT INTO station(station_id, name, address, longitude, latitude) VALUES (?,?,?,?,?)");
        $stmt->bind_param("issff", $station->station_id, $station->name, $station->address, $station->longitude, $station->latitude);
        $stmt->execute();
        $stmt->close();
        return $station;
    }
    */

    /* NYI
    public function update($station){
        $stmt = $this->db->prepare("UPDATE station set name = ?, address = ?, longitude = ?, latitude = ? WHERE station_id = ?");
        $stmt->bind_param("ssffi", $station->name, $station->address, $station->longitude, $station->latitude, $station->station_id);
        $stmt->execute();
        $stmt->close();
        return $dock;
    }
    */

    public function delete($historyusagebicycle){
        $stmt = $this->db->prepare("DELETE FROM historyusagebicycle WHERE id = ?");
        $stmt->bind_param("i", $historyusagebicycle->id);
        $stmt->execute();
        $stmt->close();
    }

    public function validate($historyusagebicycle){
        // TODO: length of station name?
        return true;
    }
}

?>
