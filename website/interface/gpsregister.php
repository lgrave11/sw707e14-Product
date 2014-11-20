<?php
    require_once('lib/nusoap.php'); // basic include.. must go at the top
   
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'bicycle-db');
    define('DB_USER', 'sw707e14');
    define('DB_PASS', 'saledes');
    $db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    mysqli_set_charset($db, "utf8");
   
   
    $server = new soap_server(); // the soap object from the include above.
    $SERVICE_NAMESPACE = "urn:GPS_Service"; // create a namespace to run under.

    $server->soap_defencoding = 'UTF-8';
    $server->decode_utf8 = false;
    $server->encode_utf8 = true;

    //we need to assign this somehow

    // this has many input parameters but we only need two: the service name and the namespace
    $server->configureWSDL('GPS_Service', $SERVICE_NAMESPACE);

    $server->register('RegisterGPS',
        array('bicycle_id' => 'xsd:int',
              'latitude' => 'xsd:float',
              'longitude' => 'xsd:float'),
        array('return' => 'xsd:boolean'),
        $SERVICE_NAMESPACE,
        $SERVICE_NAMESPACE . '#soapaction',
        'rpc',
        'literal',
        'Updates location of bicycle'
    );
    function RegisterGPS($bicycle_id, $latitude, $longitude)
    {
        global $db;
        
        $stmt = $db->prepare("UPDATE bicycle SET latitude = ?, longitude = ? WHERE bicycle_id = ?");
        $stmt->bind_param("ddi", $latitude, $longitude, $bicycle_id);
        $stmt->execute();
        $stmt->close();
        
        $stmt = $db->prepare("INSERT INTO historylocationbicycle(bicycle_id, timeforlocation, latitude, longitude) VALUES (?,?,?,?)");
        $stmt->bind_param("iidd", $bicycle_id, time(), $latitude, $longitude);
        $stmt->execute();
        $stmt->close();
        return true;
    }
        
   

    //This processes the request and returns a result.
    ob_clean();
    $HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
    $server->service(trim($HTTP_RAW_POST_DATA)); 

?>



