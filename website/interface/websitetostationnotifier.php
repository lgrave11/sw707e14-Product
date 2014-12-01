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
        
        public static function notifyStationDockChanged($action, $station_id, $dock_id) 
        {
            if($action == "addDock" || $action == "removeDock") 
            {
                $message = self::makeJsonDock($action, $station_id, $dock_id);
                $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
                $ip = self::getStationIP($station_id);
                
                if(self::checkIpOnline($ip, self::$port)){
                    $sock_data = socket_connect($sock, $ip, self::$port);
                    $sock_data = socket_write($sock, $message);
                    socket_close($sock);
                    return true;
                }                
            }
            return false;
            
        }
        
        public static function notifyStationBooking($station_id, $booking_id, $start_time, $password)
        {
            $message = self::makeJson("booking", $station_id, $booking_id, $start_time, $password);
            $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            $ip = self::getStationIP($station_id);

            if(self::checkIpOnline($ip, self::$port)){
                $sock_data = socket_connect($sock, $ip, self::$port);
                // $sock_data = socket_set_option($sock, SOL_SOCKET, SO_BROADCAST);
                $sock_data = socket_write($sock, $message);
                socket_close($sock);
                return true;
            }
            return false;

        }
    
        public static function notifyStationUnbooking($station_id, $booking_id)
        {
            $message = self::makeJson("unbooking", $station_id, $booking_id, null, null);  
            $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            $ip = self::getStationIP($station_id);

            if(self::checkIpOnline($ip, self::$port)){
                $sock_data = socket_connect($sock, $ip, self::$port);
                // $sock_data = socket_set_option($sock, SOL_SOCKET, SO_BROADCAST);
                $sock_data = socket_write($sock, $message);
                socket_close($sock);
                return true;
            }

            return false;
        }
        
        // Returns true if online, false if offline.
        public static function checkStationStatus($station_id){
            $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            $ip = self::getStationIP($station_id);

            if(self::checkIpOnline($ip, self::$port)){
                return true;
            }

            return false;
        }

        private static function checkIpOnline($ip, $port){
            error_reporting(0);
            $errno;
            $errstr;
            return fsockopen($ip, $port, $errno, $errstr, 5);
        }
        
        private static function makeJsonDock($action, $station_id, $dock_id) 
        {
            $to_add_class = new stdclass();
            $to_add_class->action = $action;
            $to_add_class->station_id = $station_id;
            $to_add_class->dock_id = $dock_id;
            
            return json_encode($to_add_class);
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

        private static function getStationIP($station_id){
            $db = mysqli_connect('localhost', 'sw707e14', 'saledes', 'bicycle-db');
            mysqli_set_charset($db, "utf8");

            $stmt = $db->prepare("SELECT ipaddress FROM station WHERE station_id = ?");
            $stmt->bind_param("i",$station_id);
            $stmt->execute();
            $stmt->bind_result($station_ip);
            $stmt->fetch();
            $stmt->close();
            return $station_ip;
        }
    }
?>