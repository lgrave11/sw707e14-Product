<?php

//create read update delete
class BicycleFactory
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
	public function create()
	{
		$stmt = $this->db->prepare("INSERT INTO bicycle() VALUES ()");
		$stmt->execute();
		$id = $this->db->insert_id;
		$stmt->close();

        return new Bicycle($id, null, null);
	}

	/**
	* reads location based on given id
	* @param $id bicycle id
    * @return Bicycle object
	*/
    public function read($id)
    {
    	$stmt = $this->db->prepare("SELECT bicycle_id, longitude, latitude FROM bicycle WHERE bicycle_id=?");
    	$stmt->bind_param("i", $id);
    	$stmt->execute();
    	$stmt->bind_result($bicycle_id, $longitude, $latitude);
    	$stmt->fetch();
    	$stmt->close();

        return new Bicycle($bicycle_id, $longitude, $latitude);
    }

    /**
    * updates location based on given id
	* @param $id bicycle id
	* @param $longitude the longitude
	* @param $latitude the latitude
    * @return an updated Bicycle object
    */
    public function update($id, $longitude, $latitude)
    {
    	$stmt = $this->db->prepare("UPDATE bicycle SET longitude = ?, latitude = ? WHERE bicycle_id = ?");
    	$stmt->bind_param("ddi",$longitude, $latitude);
    	$stmt->execute();
    	$stmt->close();

        return new Bicycle($id, $longitude, $latitude);
    }

    /**
    * deletes bicycle based on the id
    * @param $id bicycle id
    */
    public function delete($id)
    {
    	$stmt = $this->db->prepare("DELETE FROM bicycle WHERE bicycle_id = ?");
    	$stmt->bind_param("i",$id);
    	$stmt->execute();
    	$stmt->close();
    }

}

?>