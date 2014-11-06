<?php

class HistoryUsageStation {
    public $id;
    public $station_id;
    public $time;
    public $num_bicycles;

    function __construct($id, $station_id, $time, $num_bicycles){
        $this->id = $id;
        $this->station_id = $station_id;
        $this->time = $time;
        $this->num_bicycles = $num_bicycles;
    }
}

?>