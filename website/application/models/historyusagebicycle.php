<?php
class HistoryUsageBicycle {
    public $id;
    public $bicycle_id;
    public $start_station;
    public $start_time;
    public $end_station;
    public $end_time;
    public $booking_id;

    function __construct($id, $bicycle_id, $start_station, $start_time, $end_station, $end_time, $booking_id){
        $this->id = $id;
        $this->bicycle_id = $bicycle_id;
        $this->start_station = $start_station;
        $this->start_time = $start_time;
        $this->end_station = $end_station;
        $this->end_time = $end_time;
        $this->booking_id = $booking_id;
    }
}

?>