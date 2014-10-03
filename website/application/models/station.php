<?php

class Station{
	public $station_id;
	public $name;
	public $address;

	function __construct($station_id, $name, $address){
		$this->station_id = $station_id;
		$this->name = $name;
		$this->address = $address;
	}
}

?>