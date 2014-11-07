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
        if(validate($bicycle))
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
        if(isset($bicycle_id))
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

    /**
     * updates location based on given id
     * @param $bicycle Bicycle
     * @return Bicycle the updated Bicycle object
     */
    public function update($bicycle)
    {
        if(validate($bicycle))
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
        if(validate($bicycle))
        {
            $stmt = $this->db->prepare("DELETE FROM bicycle WHERE bicycle_id = ?");
            $stmt->bind_param("i",$bicycle->id);
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

        if(!empty($bicycle->longitude) && !empty($bicycle->longitude))
        {
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
