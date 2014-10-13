<?php
    $station_ips = array("192.168.1.226","192.168.1.226","192.168.1.266");
    $port = 10000;
    
    function notifyStationBooking($station_id){
        $message = "station_id:" . $station_id . ";" . "booking"; 
        $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        $sock_data = socket_connect($sock,station_ips[station_id - 1], $port);
        $sock_data = socket_set_option($sock, SOL_SOCKET, SO_BROADCAST, 1);
        $sock_data = socket_write($sock, $message);
        socket_close($sock);
    }
?>