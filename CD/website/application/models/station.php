<?php

class Station{
    public $station_id;
    public $name;
    public $address;
    public $longitude;
    public $latitude;

    function __construct($station_id, $name, $address, $latitude, $longitude){
        $this->station_id = $station_id;
        $this->name = $name;
        $this->address = $address;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
    }
}

?>