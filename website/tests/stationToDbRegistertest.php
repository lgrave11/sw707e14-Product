<?php 
//require '../website/application/config/config.php';
ob_start();
require '../website/interface/stationtodbregister.php';
ob_end_clean();
class StationToDbRegisterTest extends PHPUnit_Framework_TestCase 
{   
    private $db = null;

 	function __construct(){
  		parent::__construct();
  		$this->db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        mysqli_set_charset($this->db, "utf8");
 	}

    public function testBicycleWithBookingUnlocked() 
    {
        global $db;
        $db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        mysqli_set_charset($db, "utf8");
        $bookingService = new BookingService($this->db);
        $bicycle_id = 1;
        $station_id = 1;
        $time = time();
        $stmt = $db->prepare("DELETE FROM booking WHERE password = 123456 AND for_user = 'sw707e14'");
        $stmt->execute();
        $stmt->close();
        $booking = new Booking(0, $time, $station_id, "123456", "sw707e14");
        $booking = $bookingService->create($booking);
        $this->assertTrue(BicycleWithBookingUnlocked($station_id, $booking->booking_id, $bicycle_id));
        $bookingRead = $bookingService->read($booking->booking_id);
        $this->assertEquals($booking->booking_id, $bookingRead->booking_id);
        $this->assertEquals(NULL, $bookingRead->password);
        $this->assertEquals($bicycle_id, $bookingRead->used_bicycle);
        $bookingService->delete($bookingRead);
    }
    

    public function testBicycleTaken(){
    	global $db;
    	$db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    	mysqli_set_charset($db, "utf8");
        
        $bicycleService = new BicycleService($this->db);
        $bicycle = $bicycleService->create(new Bicycle(null,1,1));
        $result1 = BicycleTaken(-1, $bicycle->bicycle_id);

        BicycleReturnedToDockAtStation($bicycle->bicycle_id, 1);

        $oldcount = GetCurrentBicycleCount(1);

        $result2 = BicycleTaken(1, $bicycle->bicycle_id);
        $newcount = GetCurrentBicycleCount(1);

        $stmt = $db->prepare("SELECT count(*) FROM historyusagebicycle WHERE bicycle_id = ? AND start_station = 1");
        $stmt->bind_param("i", $bicycle->bicycle_id);
        $stmt->execute();
        $stmt->bind_result($numusagebicycle);
        $stmt->fetch();
        $stmt->close();

        $bicycleService->testDelete($bicycle);
        $this->assertFalse($result1); 
        $this->assertTrue($result2);
        $this->assertEquals($oldcount - 1, $newcount);

        $this->assertEquals(1, $numusagebicycle);

    }



    public function testGetCurrentBicycleCount()
    {
       
        global $db;
        $db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        mysqli_set_charset($db, "utf8");
     
        $oldnum = GetCurrentBicycleCount(1);
        $bicycleService = new BicycleService($this->db);
        $bicycle = $bicycleService->create(new Bicycle(null,1,1));

        BicycleReturnedToDockAtStation($bicycle->bicycle_id, 1);
        $newnum = GetCurrentBicycleCount(1);
        BicycleTaken(1, $bicycle->bicycle_id);
        $bicycleService->testDelete($bicycle);

        $this->assertEquals($oldnum + 1, $newnum);

    }

    public function testBicycleReturnedToDockAtStation(){
        global $db;
        $db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        mysqli_set_charset($db, "utf8");
     
        
        $bicycleService = new BicycleService($this->db);
        $bicycle = $bicycleService->create(new Bicycle(null,1,1));
        BicycleReturnedToDockAtStation($bicycle->bicycle_id, 1);
        BicycleTaken(1, $bicycle->bicycle_id);
        //old results
        $oldnum = GetCurrentBicycleCount(1);

        $stmt = $db->prepare("SELECT end_station FROM historyusagebicycle WHERE bicycle_id = ? AND start_station = 1");
        $stmt->bind_param("i", $bicycle->bicycle_id);
        $stmt->execute();
        $stmt->bind_result($oldendstation);
        $stmt->fetch();
        $stmt->close();

        //action
        BicycleReturnedToDockAtStation($bicycle->bicycle_id, 1);


        //new results
        $newnum = GetCurrentBicycleCount(1);
        $stmt = $db->prepare("SELECT end_station FROM historyusagebicycle WHERE bicycle_id = ? AND start_station = 1");
        $stmt->bind_param("i", $bicycle->bicycle_id);
        $stmt->execute();
        $stmt->bind_result($newendstation);
        $stmt->fetch();
        $stmt->close();

        $stmt = $db->prepare("SELECT dock_id FROM dock WHERE holds_bicycle = ?");
        $stmt->bind_param("i", $bicycle->bicycle_id);
        $stmt->execute();
        $stmt->bind_result($dockid);
        $stmt->fetch();
        $stmt->close();


        //cleanup
        $bicycleService->testDelete($bicycle);


        //assserts
        $this->assertEquals($oldnum + 1, $newnum);
        $this->assertEquals(null, $oldendstation);
        $this->assertNotEquals(null, $newendstation);
        $this->assertNotEquals(null, $dockid);
    }

    public function testgetBookingWithId()
    {
        global $db;
        $db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        mysqli_set_charset($db, "utf8");


        $bookingService = new BookingService($this->db);
        $time = time();
        $booking = new Booking(0, $time, 1, "123456", "sw707e14");
        $booking = $bookingService->create($booking);

        $result = getBookingWithId($booking->booking_id);

        $bookingService->delete($booking, true);

        $array = array('booking_id' => $booking->booking_id, 'start_time' => $booking->start_time, 'start_station' => $booking->start_station, 'password' => $booking->password, 'for_user' => $booking->for_user);

        $this->assertEquals($array, $result);

    }

    public function testGetAllBookingsForStation()
    {
        global $db;
        $db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        mysqli_set_charset($db, "utf8");

        $oldcount = count(GetAllBookingsForStation(1));

        $bookingService = new BookingService($this->db);
        $time = time();
        $booking = new Booking(0, $time, 1, "123456", "sw707e14");
        $booking = $bookingService->create($booking);

        $newcount = count(GetAllBookingsForStation(1));

        $bookingService->delete($booking, true);

        $this->assertEquals($oldcount + 1, $newcount);

    }
}
?>