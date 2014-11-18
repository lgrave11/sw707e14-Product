<?php 
require '../website/application/config/config.php';
require '../website/interface/stationtodbregister.php';
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

        $bookingService = new BookingService($this->db);

        $bicycle_id = 1;
        $station_id = 1;
        $time = time();

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
        echo "11";
        $dockService = new DockService($this->db);
        $histroyUsageBicycleService = new HistoryUsageBicycleService($this->db);
        $bookingService = new BookingService($this->db);
        echo "22";
        $station_id = 1;
        $bicycle_id = 100;
        $dock_id = 10;
        $time = time();
        echo "1";
        $dock = new Dock($dock_id, $station_id, $bicycle_id);
        $dockService->update($dock);
        echo "2";
        $booking = new Booking(0, $time, $station_id, "123456", "sw707e14");
        $booking = $bookingService->create($booking);
        echo "3";
        echo BicycleTaken($station_id, $bicycle_id, $booking->booking_id);
        //$this->assertTrue(BicycleTaken($station_id, $bicycle_id, $booking->booking_id));
        echo "4";
        
        $dockRead = $dockService->read($dock_id);

        $this->assertEquals(NULL, $dockRead->holds_bicycle);

        $historyUsage = $histroyUsageBicycleService->readHistoryBetween($time - 1, $time + 1);

        $this->assertEquals($historyUsage[0]->bicycle_id, $bicycle_id);
        $this->assertEquals($historyUsage[0]->start_station, $station_id);
        $this->assertEquals($historyUsage[0]->booking_id, $booking->booking_id);

        // 
        $this->assertTrue(BicycleTaken($station_id, $bicycle_id));
        $dockRead = $dockService->read($dock_id);
    }
}
?>