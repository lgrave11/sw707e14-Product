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
    	$stmt->bind_result($station_id, $name, $address, $latitude, $longitude);
    	$stmt->fetch();
    	$returnStation = new Station($station_id, $name, $address, $latitude, $longitude);
    	$stmt->close();
    	return $returnStation;
    }

    public function readAllStations(){
    	$returnArray = array();
    	$stmt = $this->db->prepare("SELECT * FROM station");
    	$stmt->execute();
    	$stmt->bind_result($station_id, $name, $address, $latitude, $longitude);
    	while($stmt->fetch()){
    		$returnArray[$station_id] = new Station($station_id, $name, $address, $latitude, $longitude);
    	}
    	$stmt->close();
    	return $returnArray;
    }

    /*public function readAllDocksForStation($station){
        $returnArray = array();
        $stmt = $this->db->prepare("SELECT * FROM dock WHERE station_id = ?");
        $stmt->bind_param("i", $station->station_id);
        $stmt->execute();
        $stmt->bind_result($dock_id, $station_id, $holds_bicycle);
        while($stmt->fetch()){
            $returnArray[$dock_id] = new Dock($dock_id, $station_id, $holds_bicycle);
        }
        $stmt->close();
        return $returnArray;
    }*/
    
    public function readAllAvailableBicyclesForStation($station){
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM dock WHERE station_id = ? AND holds_bicycle IS NOT NULL");
        $stmt->bind_param("i", $station->station_id);
        $stmt->execute();
        $stmt->bind_result($countBicycles);
        $stmt->fetch();
        $stmt->close();

        $time_now = mktime(date("H"),date("i"),date("s"),date("n"), date("j"),date("Y"));
        $time_midnight = mktime(23,59,59,date("n"),date("j"),date("Y"));
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM booking WHERE start_station = ? AND start_time BETWEEN ? AND ?");
        $stmt->bind_param("iii",$station->station_id, $time_now, $time_midnight);
        $stmt->execute();
        $stmt->bind_result($countBookings);
        $stmt->fetch();
        $stmt->close();
        return $countBicycles - $countBookings;
    }

    public function readAllAvailableDocksForStation($station){
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM dock WHERE station_id = ? AND holds_bicycle IS NULL");
        $stmt->bind_param("i", $station->station_id);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
        return $count;
    }

    public function searchStation($name = ""){
        $returnArray = array();
        $name = mysqli_real_escape_string($this->db, $name);
        $stmt = $this->db->prepare("SELECT station_id, name FROM station WHERE name LIKE '%".$name."%' ORDER BY levenshtein('".$name."', name)");
        $stmt->execute();
        $stmt->bind_result($station_id, $name);
        while($stmt->fetch()){
            $returnArray[$station_id] = new Station($station_id, $name, NULL, NULL, NULL);
        }
        $stmt->close();
        return $returnArray;
    }

    public function create($station){
        $stmt = $this->db->prepare("INSERT INTO station(station_id, name, address, longitude, latitude) VALUES (?,?,?,?,?)");
        $stmt->bind_param("issff", $station->station_id, $station->name, $station->address, $station->longitude, $station->latitude);
        $stmt->execute();
        $stmt->close();
        return $station;
    }

        public function update($station){
        $stmt = $this->db->prepare("UPDATE station set name = ?, address = ?, longitude = ?, latitude = ? WHERE station_id = ?");
        $stmt->bind_param("ssffi", $station->name, $station->address, $station->longitude, $station->latitude, $station->station_id);
        $stmt->execute();
        $stmt->close();
        return $dock;
    }

    public function delete($station){
        $stmt = $this->db->prepare("DELETE FROM station WHERE station_id = ?");
        $stmt->bind_param("i", $station->station_id);
        $stmt->execute();
        $stmt->close();
    }

    public function validate($station){
        // TODO: length of station name?
        return true;
    }
}

?>
