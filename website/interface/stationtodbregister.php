<?php
    require_once('lib/nusoap.php'); // basic include.. must go at the top
   
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'bicycle-db');
    define('DB_USER', 'sw707e14');
    define('DB_PASS', 'saledes');
    $db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    mysqli_set_charset($db, "utf8");
   
   
    $server = new soap_server(); // the soap object from the include above.
    $SERVICE_NAMESPACE = "urn:StationToDB_Service"; // create a namespace to run under.

    $server->soap_defencoding = 'UTF-8';
    $server->decode_utf8 = false;
    $server->encode_utf8 = true;

    //we need to assign this somehow

    // this has many input parameters but we only need two: the service name and the namespace
    $server->configureWSDL('StationToDB_Service', $SERVICE_NAMESPACE);

    $server->register('BicycleWithBookingUnlocked',
        array('station_id' => 'xsd:int',
              'booking_id' => 'xsd:int'),
        array('return' => 'xsd:boolean'),
        $SERVICE_NAMESPACE,
        $SERVICE_NAMESPACE . '#soapaction',
        'rpc',
        'literal',
        'Registers that a given bicycle has been unlocked from a given station with a booking'
    );
    function BicycleWithBookingUnlocked($station_id, $booking_id)
    {
        global $db;
        $stmt = $db->prepare("UPDATE booking SET password = NULL WHERE booking_id = ? AND start_station = ?");
        $stmt->bind_param("ii", $booking_id, $station_id);
        $stmt->execute();
        $stmt->close();
        
        return true;
    }
        
    $server->register('BicycleTaken',
        array('station_id' => 'xsd:int',
              'bicycle_id' => 'xsd:int'),
        array('return' => 'xsd:boolean'),
        $SERVICE_NAMESPACE,
        $SERVICE_NAMESPACE . '#soapaction',
        'rpc',
        'literal',
        'Registers that a given bicycle has been taken from a given station, aka removed from dock'
    );
    function BicycleTaken($station_id, $bicycle_id)
    {   
        global $db;
        $stmt = $db->prepare("UPDATE dock SET holds_bicycle = NULL WHERE station_id = ? AND holds_bicycle = ?");
        $stmt->bind_param("ii", $station_id, $bicycle_id);
        $stmt->execute();
        $stmt->close();
        
        $stmt = $db->prepare("INSERT INTO historyusagebicycle (bicycle_id, start_station) VALUES (?, ?)");
        $stmt>bind_param("ii", $bicycle_id, $station_id);
        $stmt->execute();
        $stmt->close();
        return true;
    }
    
    $server->register('BicycleReturnedToDockAtStation',
        array('bicycle_id' => 'xsd:int',
              'station_id' => 'xsd:int',
              'dock_id'    => 'xsd:int'),
        array('return' => 'xsd:boolean'),
        $SERVICE_NAMESPACE,
        $SERVICE_NAMESPACE . '#soapaction',
        'rpc',
        'literal',
        'Registers that a given bicycle has arrived at a given dock at a given station'
    );
    function BicycleReturnedToDockAtStation($bicycle_id, $station_id, $dock_id)
    {
        global $db;
        $stmt = $db->prepare("UPDATE dock SET holds_bicycle = ? WHERE station_id = ? AND dock_id = ?");
        $stmt->bind_param("iii", $bicycle_id, $station_id, $dock_id);
        $stmt->execute();
        $stmt->close();

        $stmt = $db->prepare("UPDATE historyusagebicycle SET end_station = ? WHERE bicycle_id = ? AND end_station IS NULL");
        $stmt->bind_param("ii", $station_id, $bicycle_id);
        $stmt->execute();
        $stmt->close();
        
        return true;
    }

    $server->wsdl->addComplexType(
        'BookingObject',
        'complexType',
        'struct',
        'all',
        '',
        array(
            'booking_id' => array('name'=>'booking_id','type'=>'xsd:int'),
            'start_time' => array('name'=>'start_time','type'=>'xsd:int'),
            'start_station' => array('name'=>'start_station','type'=>'xsd:int'),
            'password' => array('name'=>'password','type'=>'xsd:string'),
            'for_user' => array('name'=>'for_user','type'=>'xsd:string')
        )
    );
    $server->register('getBookingWithId',
        array('booking_id' => 'xsd:int'),
        array('return' => 'tns:BookingObject'),
        $SERVICE_NAMESPACE,
        $SERVICE_NAMESPACE . '#soapaction',
        'rpc',
        'encoded',
        'Get booking with booking id'
    );
    function getBookingWithId($id)
    {
        global $db;
        $stmt = $db->prepare("SELECT booking_id, start_time, start_station, password, for_user FROM booking WHERE booking_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($booking_id, $start_time, $start_station, $password, $for_user);
        $stmt->fetch();
        $stmt->close();
        
        return array('booking_id' => $booking_id, 'start_time' => $start_time, 'start_station' => $start_station, 'password' => $password, 'for_user' => $for_user);
    }
    
    
    
    
    $server->wsdl->addComplexType(
        'BookingObjectArray',
        'complexType',
        'array',
        '',
        'SOAP-ENC:Array',
        array(),
        array(array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'xsd:string[]')),
        'xsd:string'
    );
    $server->register(
        'GetAllBookingsForStation',
        array('station_id' => 'xsd:int'),
        array('return' => 'tns:BookingObjectArray'),
        $SERVICE_NAMESPACE,
        $SERVICE_NAMESPACE . '#soapaction',
        'rpc',
        'encoded',
        'Get all bookings for station'
    );
    //in case you want to read everything.
    function GetAllBookingsForStation($station_id)
    {
        global $db;
        $stmt = $db->prepare("SELECT booking_id, start_time, start_station, password, for_user FROM booking WHERE start_station = ? AND password IS NOT NULL");
        $stmt->bind_param("i", $station_id);
        $stmt->execute();
        $stmt->bind_result($booking_id, $start_time, $start_station, $password, $for_user);
        
        $returnarray = array();
        while($stmt->fetch())
        {
            $to_add_class = new stdclass();
            $to_add_class->booking_id = $booking_id;
            $to_add_class->start_time = $start_time;
            $to_add_class->start_station = $start_station;
            $to_add_class->password = $password;
            $to_add_class->for_user = $for_user;
            
            $returnarray[] = json_encode($to_add_class);
        }
        $stmt->close();
        return $returnarray;
    }

    //This processes the request and returns a result.
    ob_clean();
    $HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
    $server->service(trim($HTTP_RAW_POST_DATA)); 

?>



