<?php 
ob_start();
require_once '../website/interface/gpsregister.php';
ob_end_clean();
class GPSRegisterTest extends PHPUnit_Framework_TestCase 
{   
    private $db = null;

 	function __construct(){
  		parent::__construct();
  		$this->db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        mysqli_set_charset($this->db, "utf8");
 	}

    public function testRegisterGPS() 
    {

        $bicycleService = new BicycleService($this->db);

        $id = 1;
        $latitude = 57.0134052;
        $longitude = 9.988917;
        $time = time();
        $prevTime = $time - 1;
        $nextTime = $time + 1;

        $oldhistory = $bicycleService->readBicyclePositions($id, 0, time());
        $this->assertTrue(RegisterGPS($id, $latitude, $longitude));

        $newhistory = $bicycleService->readBicyclePositions($id, 0, time());
        $this->assertEquals(count($oldhistory), count($newhistory) -1);


        $bicycle = $bicycleService->read($id);

        $this->assertEquals($id, $bicycle->bicycle_id);
        $this->assertLessThan(0.00005, abs($latitude - $bicycle->latitude));
        $this->assertLessThan(0.00005, abs($longitude- $bicycle->longitude));

        $bicycleLocation = $bicycleService->readBicyclePositions($id, $prevTime, $nextTime);
        $this->assertLessThan(0.00005, abs($latitude - $bicycleLocation[0]->latitude));
        $this->assertLessThan(0.00005, abs($longitude- $bicycleLocation[0]->longitude));
    }
    
    
}
?>