<?php 
    class WebsiteToStationNotifier
    {
        static $station_ips = array("127.0.0.1","127.0.0.1","127.0.0.1",//1-3
                                    "127.0.0.1","127.0.0.1","127.0.0.1",//4-6
                                    "127.0.0.1","127.0.0.1","127.0.0.1",//7-9
                                    "127.0.0.1","127.0.0.1","127.0.0.1",//10-12
                                    "127.0.0.1","127.0.0.1","127.0.0.1",//13-15
                                    "127.0.0.1","127.0.0.1","127.0.0.1",//16-18
                                    "127.0.0.1","127.0.0.1","127.0.0.1");//19-21
        static $port = 10000;
        
        public static function notifyStationBooking($station_id, $booking_id, $start_time, $password)
        {
            $message = self::makeJson("booking", $station_id, $booking_id, $start_time, $password);

            $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            $sock_data = socket_connect($sock, self::$station_ips[$station_id - 1], self::$port);
           // $sock_data = socket_set_option($sock, SOL_SOCKET, SO_BROADCAST);
            $sock_data = socket_write($sock, $message);
            socket_close($sock);
        }
    
        public static function notifyStationUnbooking($station_id, $booking_id)
        {
            $message = self::makeJson("unbooking", $station_id, $booking_id);
            
            $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            $sock_data = socket_connect($sock, self::$station_ips[$station_id - 1], self::$port);
           // $sock_data = socket_set_option($sock, SOL_SOCKET, SO_BROADCAST);
            $sock_data = socket_write($sock, $message);
            socket_close($sock);
        }

        private static function makeJson($action, $station_id, $booking_id, $start_time, $password)
        {
            $to_add_class = new stdclass();
            $to_add_class->action = $action;
            $to_add_class->start_station = $station_id;
            $to_add_class->booking_id = $booking_id;
            if($action == "booking")
            {
            	$to_add_class->start_time = $start_time;
            	$to_add_class->password = $password;
            }
            
            return json_encode($to_add_class);
        }
    }
?>