<?php

//create read update delete
class BicycleService implements iService
{
    private $db = null;

    function __construct($database){
        try{
            $this->db = $database;
        }
        catch(Exception $ex){
            exit("Unable to connect to database " . $ex);
        }
    }

    /**
     * Function that creates a new bicycle
     * @return the created object
     */
    public function create($bicycle)
    {
        if($this->validate($bicycle))
        {
            $stmt = $this->db->prepare("INSERT INTO bicycle(longitude, latitude) VALUES (?,?)");
            $stmt->bind_param("dd", $bicycle->longitude, $bicycle->latitude);
            $stmt->execute();
            $id = $this->db->insert_id;
            $stmt->close();
            return new Bicycle($id, $bicycle->latitude, $bicycle->longitude);
        }
        else
        {
            return null;
        }
    }

    /**
     * reads location based on given id
     * @param $id bicycle id
     * @return Bicycle object
     */
    public function read($id)
    {
        $stmt = $this->db->prepare("SELECT bicycle_id, latitude, longitude FROM bicycle WHERE bicycle_id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($bicycle_id, $latitude, $longitude);
        $stmt->fetch();
        $stmt->close();
        if(is_numeric($bicycle_id))
        {
            return new Bicycle($bicycle_id,$latitude, $longitude);
        }
        else
        {
            return null;
        }
    }

    // All bicycles should have a longitude and latitude after they have been used the first time.
    public function readAllBicyclesWithRoute(){
        $returnArray = array();
        $stmt = $this->db->prepare("SELECT DISTINCT bicycle_id FROM historylocationbicycle");
        $stmt->execute();
        $stmt->bind_result($bicycle_id);
        while($stmt->fetch()){
            $returnArray[] = new Bicycle($bicycle_id, null, null);
        }
        $stmt->close();
        return $returnArray;
    }

    public function readAll(){
        $returnArray = array();
        $stmt = $this->db->prepare("SELECT * FROM bicycle WHERE latitude IS NOT NULL AND longitude IS NOT NULL");
        $stmt->execute();
        $stmt->bind_result($bicycle_id, $latitude, $longitude);
        while($stmt->fetch()){
            $returnArray[] = new Bicycle($bicycle_id,$latitude, $longitude);
        }
        $stmt->close();
        return $returnArray;
    }
    
    public function readAllBicycles(){
        $returnArray = array();
        $stmt = $this->db->prepare("SELECT * FROM bicycle");
        $stmt->execute();
        $stmt->bind_result($bicycle_id, $latitude, $longitude);
        while($stmt->fetch()){
            $returnArray[] = new Bicycle($bicycle_id,$latitude, $longitude);
        }
        $stmt->close();
        return $returnArray;
    }
    
    public function readBicyclePositions($bicycle_id, $from_time, $to_time) 
    {
        $returnArray = array();
        $stmt = $this->db->prepare("SELECT latitude, longitude FROM historylocationbicycle WHERE bicycle_id = ? AND (timeforlocation BETWEEN FROM_UNIXTIME(?) AND FROM_UNIXTIME(?)) ORDER BY timeforlocation ASC");
        $stmt->bind_param("iii", $bicycle_id, $from_time, $to_time);
        $stmt->execute();
        $stmt->bind_result($latitude, $longitude);
        while($stmt->fetch()){
            $cls = new stdclass();
            $cls->latitude = $latitude;
            $cls->longitude = $longitude;
            $returnArray[] = $cls;
        }
        
        return $returnArray;
    }
    
    public function readBicycleBookingPairs()
    {
        $returnArray = array();
        $stmt = $this->db->prepare("SELECT DISTINCT bicycle_id, booking_id
                                    FROM historyusagebicycle
                                    WHERE booking_id IS NOT NULL AND booking_id != 0 AND bicycle_id IN (SELECT DISTINCT bicycle_id FROM historylocationbicycle)");
        $stmt->execute();
        $stmt->bind_result($bicycle_id, $booking_id);
        while($stmt->fetch()){
            $cls = new stdclass();
            $cls->bicycle_id = $bicycle_id;
            $cls->booking_id = $booking_id;
            $returnArray[] = $cls;
        }
        
        return $returnArray;
    }
    
    //THIS FUNCTION IS NOT TESTED! and mysql is terrible and whoever wrote it should feel bad
    public function readBicyclePositionsWithBooking($bicycle_id, $booking_id)
    {
        $returnArray = array();
        $stmt = $this->db->prepare("SELECT historylocationbicycle.latitude, historylocationbicycle.longitude 
                                    FROM historylocationbicycle JOIN historyusagebicycle ON historylocationbicycle.bicycle_id = historyusagebicycle.bicycle_id
                                    WHERE historyusagebicycle.booking_id IS NOT NULL AND historyusagebicycle.end_time IS NOT NULL AND
                                          historylocationbicycle.bicycle_id = ? AND historyusagebicycle.booking_id = ? AND
                                          historylocationbicycle.timeforlocation BETWEEN historyusagebicycle.start_time AND historyusagebicycle.end_time
                                    ORDER BY historylocationbicycle.timeforlocation ASC");             
        $stmt->bind_param("ii", $bicycle_id, $booking_id);
        $stmt->execute();
        $stmt->bind_result($latitude, $longitude);
        while($stmt->fetch()){
            $cls = new stdclass();
            $cls->latitude = $latitude;
            $cls->longitude = $longitude;
            $returnArray[] = $cls;
        }
        
        return $returnArray;
    }

    /**
     * updates location based on given id
     * @param $bicycle Bicycle
     * @return Bicycle the updated Bicycle object
     */
    public function update($bicycle)
    {
        if($this->validate($bicycle))
        {
            $stmt = $this->db->prepare("UPDATE bicycle SET longitude = ?, latitude = ? WHERE bicycle_id = ?");
            $stmt->bind_param("ddi",
                $bicycle->longitude,
                $bicycle->latitude,
                $bicycle->bicycle_id);
            $stmt->execute();
            $stmt->close();
            return $bicycle;
        }
        else
        {
            return null;
        }


    }

    /**
     * Deletes bicycle based on the id
     * @param $bicycle Bicycle
     * @return bool Whether or not the bicycle was deleted from the database.
     */
    public function delete($bicycle)
    {
        if($this->validate($bicycle))
        {
            $stmt = $this->db->prepare("DELETE FROM bicycle WHERE bicycle_id = ?");
            $stmt->bind_param("i",$bicycle->bicycle_id);
            $stmt->execute();
            $stmt->close();
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * @param $bicycle Bicycle
     * @return bool Whether or not the bicycle was validated.
     */
    public function validate($bicycle)
    {
        $valid = true;

        if(!empty($bicycle->longitude) && !empty($bicycle->latitude))
        {
            if(!is_numeric($bicycle->longitude) || !is_numeric($bicycle->latitude)){
                $valid = false;
            }
            if(!($bicycle->longitude >= 0.0 && $bicycle->longitude <= 90.0))
            {
                $valid = false;
            }
            if(!($bicycle->latitude >= 0.0 && $bicycle->latitude <= 90.0))
            {
                $valid = false;
            }
        }
        return $valid;
    }

}

?>
