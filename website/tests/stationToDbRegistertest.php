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
        $dockService = new DockService($this->db);
        $historyUsageBicycleService = new HistoryUsageBicycleService($this->db);
        $bookingService = new BookingService($this->db);

        $station_id = 1;
        $bicycle_id = 100;
        $dock_id = 10;
        $time = time();

        $dock = new Dock($dock_id, $station_id, $bicycle_id);
        $dockService->update($dock);

        $booking = new Booking(0, $time, $station_id, "123456", "sw707e14");
        $booking = $bookingService->create($booking);

        $stmt = $db->prepare("SELECT COUNT(*) FROM historyusagebicycle WHERE bicycle_id = ? AND start_station = ? AND start_time BETWEEN ? AND ?");
        $prevtime = $time - 2;
        $nexttime = $time + 2;
        $stmt->bind_param("iiii", $bicycle_id, $station_id, $prevtime, $nexttime);
        $stmt->execute();
        $stmt->bind_result($oldcount);
        $stmt->fetch();
        $stmt->close();

        $this->assertTrue(BicycleTaken($station_id, $bicycle_id, $booking->booking_id));
        
        $dockRead = $dockService->read($dock_id);

        $this->assertEquals(NULL, $dockRead->holds_bicycle);

        $stmt = $db->prepare("SELECT COUNT(*) FROM historyusagebicycle WHERE bicycle_id = ? AND start_station = ? AND start_time BETWEEN ? AND ?");
        $prevtime = $time - 2;
        $nexttime = $time + 2;
        $stmt->bind_param("iiii", $bicycle_id, $station_id, $prevtime, $nexttime);
        $stmt->execute();
        $stmt->bind_result($newcount);
        $stmt->fetch();
        $stmt->close();

        $this->assertEquals($oldcount + 1, $newcount);

        // 
        $this->assertTrue(BicycleTaken($station_id, $bicycle_id));
        $dockRead = $dockService->read($dock_id);
    }
}
?>