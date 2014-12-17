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

    /**
     * Read a station based on id.
     * @param $station_id
     * @return Station|null
     */
    public function read($id)
    {
        $returnStation = null;
        $stmt = $this->db->prepare("SELECT station_id, name, address, latitude, longitude, COUNT(*) FROM station WHERE station_id = ? AND deleted = false");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($station_id, $name, $address, $latitude, $longitude, $count);
        $stmt->fetch();
        $stmt->close();
        if($count == 1)
        {
            $returnStation = new Station($station_id, $name, $address, $latitude, $longitude);
        }
        return $returnStation;
    }

    public function readAllStations($readDeleted = false){
    	$returnArray = array();
        $stmt = null;
        if ($readDeleted){
            $stmt = $this->db->prepare("SELECT station_id, name, address, latitude, longitude FROM station");
        } else {
            $stmt = $this->db->prepare("SELECT station_id, name, address, latitude, longitude FROM station WHERE deleted = false");
        }
    	
    	$stmt->execute();
    	$stmt->bind_result($station_id, $name, $address, $latitude, $longitude);
    	while($stmt->fetch()){
    		$returnArray[] = new Station($station_id, $name, $address, $latitude, $longitude);
    	}
    	$stmt->close();
    	return $returnArray;
    }
    
    public function readAllAvailableBicycles(){
        $bicycleArray = array();
        $stmt = $this->db->prepare("SELECT SUM(CASE WHEN holds_bicycle IS NOT NULL then 1 else 0 END), station_id FROM dock GROUP BY station_id");
        $stmt->execute();
        $stmt->bind_result($countBicycles, $station_id);
        while($stmt->fetch()){
            $bicycleArray[$station_id] = $countBicycles;
        }
        $stmt->close();
        
        $stmt = $this->db->prepare("SELECT DISTINCT station_id FROM station WHERE station_id NOT IN (SELECT DISTINCT station_id FROM dock) AND deleted = false");
        $stmt->execute();
        $stmt->bind_result($station_id);
        while($stmt->fetch())
        {
            $bicycleArray[$station_id] = 0;
        }
        $stmt->close();

        $bookingArray = array();
        $hour_back = time() - 3600;
        $hour_forward = time() + 3600;
        $stmt = $this->db->prepare("SELECT COUNT(*), start_station FROM booking WHERE password IS NOT NULL AND start_time BETWEEN ? AND ? GROUP BY start_station");
        $stmt->bind_param("ii", $hour_back, $hour_forward);
        $stmt->execute();
        $stmt->bind_result($countBookings, $start_station);
        while($stmt->fetch()){
            $bookingArray[$start_station] = $countBookings;
        }
        $stmt->close();

        $returnArray = array();
        foreach ($bicycleArray as $id => $counts) {
            $returnArray[$id] = $counts;
        }
        foreach($bookingArray as $id => $counts){
            $returnArray[$id] = $returnArray[$id] - $counts;
        }

        return $returnArray;
    }

    public function readAllAvailableDocks(){
        $returnArray = array();
        $stmt = $this->db->prepare("SELECT SUM(CASE WHEN holds_bicycle IS NULL then 1 else 0 END),station_id FROM dock GROUP BY station_id");
        $stmt->execute();
        $stmt->bind_result($count, $station);
        while($stmt->fetch()){
            $returnArray[$station] = $count;
        }
        $stmt->close();

        $stmt = $this->db->prepare("SELECT DISTINCT station_id FROM station WHERE station_id NOT IN (SELECT DISTINCT station_id FROM dock) AND deleted = false");
        $stmt->execute();
        $stmt->bind_result($station_id);
        while($stmt->fetch())
        {
            $returnArray[$station_id] = 0;
        }
        $stmt->close();
        return $returnArray;
    }

    public function readStationMapping(){
        $returnArray = array();
        $i = 0;
        $stmt = $this->db->prepare("SELECT station_id FROM station ORDER BY station_id");
        $stmt->execute();
        $stmt->bind_result($station_id);
        while($stmt->fetch()){
            $returnArray[$station_id] = $i;
            $i++;
        }
        $stmt->close();
        return $returnArray;
    }

    public function searchStation($name = ""){
        $returnArray = array();
        $name = mysqli_real_escape_string($this->db, $name);
        $stmt = $this->db->prepare("SELECT station_id, name FROM station WHERE deleted = false AND name LIKE '%".$name."%' ORDER BY levenshtein('".$name."', name)");
        $stmt->execute();
        $stmt->bind_result($station_id, $name);
        while($stmt->fetch()){
            $returnArray[$station_id] = new Station($station_id, $name,null,null,null);
        }
        $stmt->close();
        return $returnArray;
    }

    public function create($station){
        $stmt = $this->db->prepare("INSERT INTO station(station_id, name, address, longitude, latitude) VALUES (?,?,?,?,?)");
        $stmt->bind_param("issdd", $station->station_id, $station->name, $station->address, $station->longitude, $station->latitude);
        $stmt->execute();
        $stmt->close();
        return $station;
    }

    public function update($station){
        $stmt = $this->db->prepare("UPDATE station set name = ?, address = ?, longitude = ?, latitude = ? WHERE station_id = ?");
        $stmt->bind_param("ssddi", $station->name, $station->address, $station->longitude, $station->latitude, $station->station_id);
        $stmt->execute();
        $stmt->close();
        return $station;
    }

    public function delete($station){
        if($this->validate($station))
        {
            $stmt = $this->db->prepare("UPDATE station SET deleted = true WHERE station_id = ?");
            $stmt->bind_param("i", $station->station_id);
            $stmt->execute();
            $stmt->close();
            return true;
        }
        return false;
    }

    public function deleteForTest($station){
        if($this->validate($station))
        {
            $stmt = $this->db->prepare("DELETE FROM station WHERE station_id = ?");
            $stmt->bind_param("i", $station->station_id);
            $stmt->execute();
            $stmt->close();
            return true;
        }
        return false;
    }

    public function validate($station){
        // TODO: length of station name?
        return true;
    }
}

?>
