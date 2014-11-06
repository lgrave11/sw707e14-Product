<?php

class HistoryUsageStationService implements iService
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
        $stmt = $this->db->prepare("SELECT * FROM historyusagestation");
        $stmt->execute();
        $stmt->bind_result($id, $station_id, $time, $num_bicycle);
        while($stmt->fetch()){
            array_push($returnArray, new HistoryUsageStation($id, $station_id, $time, $num_bicycle));
        }
        return $returnArray;
    }

    public function readAllHistoryForStation($historyusagestation, $fromtime, $totime){
        $returnArray = array();
        $stmt = $this->db->prepare("SELECT * FROM historyusagestation WHERE station_id = ? AND time BETWEEN ? AND ?");
        $stmt->bind_param("i", $historyusagestation->station_id, $fromtime, $totime);
        $stmt->execute();
        $stmt->bind_result($id, $station_id, $time, $num_bicycle);
        while($stmt->fetch()){
            array_push($returnArray, new HistoryUsageStation($id, $station_id, date("d/m/Y H:i:s", $time), $num_bicycle));
        }
        return $returnArray;
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

    public function delete($historyusagestation){
        $stmt = $this->db->prepare("DELETE FROM historyusagestation WHERE id = ?");
        $stmt->bind_param("i", $historyusagestation->id);
        $stmt->execute();
        $stmt->close();
    }

    public function create($object) {

    }

    public function update($object) {

    }

    public function validate($historyusagestation){
        // TODO: length of station name?
        return true;
    }
}

?>
