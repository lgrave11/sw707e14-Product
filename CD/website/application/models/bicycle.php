<?php
class Bicycle
{
    public $bicycle_id = null;
    public $longitude = null;
    public $latitude = null;

    function __construct($bicycle_id, $latitude, $longitude){
        $this->bicycle_id = $bicycle_id;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
    }
}

?>