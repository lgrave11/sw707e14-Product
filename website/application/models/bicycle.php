<?php
class Bicycle
{
	private $bicycle_id = null;
	private $longitude = null;
	private $latitude = null;

	function __construct($bicycle_id, $longitude, $latitude){
		$this->bicycle_id = $bicycle_id;
		$this->longitude = $longitude;
		$this->latitude = $latitude;
	}
}

?>