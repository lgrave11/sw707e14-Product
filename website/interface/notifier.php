<?php

    
    function notifyStationBooking($station_id, $booking_id){
        $station_ips = array("127.0.0.1","192.168.1.226","192.168.1.266");
        $port = 10000;
        $message = "station_id:" . $station_id . ";" . "booking:" . $booking_id . ";"; 
        $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        $sock_data = socket_connect($sock, $station_ips[$station_id - 1], $port);
       // $sock_data = socket_set_option($sock, SOL_SOCKET, SO_BROADCAST);
        $sock_data = socket_write($sock, $message);
        socket_close($sock);
    }
    
    //this is dirty :)
    if(function_exists($_GET['f'])) {
        $_GET['f'](1, 1);
    }
?>