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

    $server->register('BicycleTakenWithBooking',
        array('station_id' => 'xsd:int',
              'bicycle_id' => 'xsd:int',
              'booking_id' => 'xsd:int'),
        array('return' => 'xsd:boolean'),
        $SERVICE_NAMESPACE,
        $SERVICE_NAMESPACE . '#soapaction',
        'rpc',
        'literal',
        'Registers that a given bicycle has been taken from a given station with a booking'
    );
    function BicycleTakenWithBooking($station_id, $bicycle_id, $booking_id)
    {
        global $db;
        $stmt = $db->prepare("UPDATE booking SET password = NULL WHERE booking_id = ? AND start_station = ?");
        $stmt->bind_param("ii", $booking_id, $station_id);
        $stmt->execute();
        $stmt->close();
        
        $stmt = $db->prepare("UPDATE dock SET holds_bicycle = NULL WHERE station_id = ? AND holds_bicycle = ?");
        $stmt->bind_param("ii", $station_id, $bicycle_id);
        $stmt->execute();
        $stmt->close();
        
        return true;
    }
        
    $server->register('BicycleTakenWithoutBooking',
        array('station_id' => 'xsd:int',
              'bicycle_id' => 'xsd:int'),
        array('return' => 'xsd:boolean'),
        $SERVICE_NAMESPACE,
        $SERVICE_NAMESPACE . '#soapaction',
        'rpc',
        'literal',
        'Registers that a given bicycle has been taken from a given station without a booking'
    );
    function BicycleTakenWithoutBooking($station_id, $bicycle_id)
    {   
        global $db;
        $stmt = $db->prepare("UPDATE dock SET holds_bicycle = NULL WHERE station_id = ? AND holds_bicycle = ?");
        $stmt->bind_param("ii", $station_id, $bicycle_id);
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
        
        return true;
    }


    //This processes the request and returns a result.
    ob_clean();
    $HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
    $server->service(trim($HTTP_RAW_POST_DATA)); 

?>



