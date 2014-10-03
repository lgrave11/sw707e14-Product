<?php

class Dock{
	public $dock_id;
	public $station_id;
	public $holds_bicycle;

	function __construct($dock_id, $station_id, $holds_bicycle){
		$this->dock_id = $dock_id;
		$this->station_id = $station_id;
		$this->holds_bicycle = $holds_bicycle;
	}
}

?>