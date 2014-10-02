<?php

class Dock{
	public $station_id;
	public $dock_id;
	public $holds_bicycle;

	function __construct($station_id, $dock_id, $holds_bicycle){
		$this->station_id = $station_id;
		$this->dock_id = $dock_id;
		$this->holds_bicycle = $holds_bicycle;
	}
}

?>