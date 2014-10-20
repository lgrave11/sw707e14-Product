<?php 
    class WebsiteToStationNotifier
    {
        static $station_ips = array("127.0.0.1","192.168.1.226","192.168.1.266");
        static $port = 10000;
        
        public static function notifyStationBooking($station_id, $booking_id)
        {
            $message = "station_id:" . $station_id . ";" . "booking:" . $booking_id . ";"; 
            $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            $sock_data = socket_connect($sock, self::$station_ips[$station_id - 1], self::$port);
           // $sock_data = socket_set_option($sock, SOL_SOCKET, SO_BROADCAST);
            $sock_data = socket_write($sock, $message);
            socket_close($sock);
        }
    
        public static function notifyStationUnbooking($station_id, $booking_id)
        {
            $message = "station_id:" . $station_id . ";" . "unbooking:" . $booking_id . ";"; 
            $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            $sock_data = socket_connect($sock, self::$station_ips[$station_id - 1], self::$port);
           // $sock_data = socket_set_option($sock, SOL_SOCKET, SO_BROADCAST);
            $sock_data = socket_write($sock, $message);
            socket_close($sock);
        }
    }
?>