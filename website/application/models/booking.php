<?php

class Booking{
	public $booking_id;
	public $start_time;
	public $start_station;
	public $password;
	public $for_user;

	function __construct($booking_id, $start_time, $start_station, $password, $for_user){
		$this->booking_id = $booking_id;
		$this->start_time = $start_time;
		$this->start_station = $start_station;
		$this->password = $password;
		$this->for_user = $for_user;
	}
}

?>
