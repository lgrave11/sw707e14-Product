<?php
require_once '../website/application/config/config.php';
class BicycleServiceTest extends PHPUnit_Framework_TestCase
{
	private $db = null;

 	function __construct(){
  		parent::__construct();

  		$this->db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        mysqli_set_charset($this->db, "utf8");
 	}

	public function testValidate(){
		$bicycleService = new BicycleService($this->db);

		//TEST NULL VALUES
		$b = $bicycleService->validate(new Bicycle(null,null,null));
		$this->assertEquals(true, $b);
		$b = $bicycleService->validate(new Bicycle(null, 1,null));
		$this->assertEquals(true, $b);
		$b = $bicycleService->validate(new Bicycle(null, null, 1));
		$this->assertEquals(true, $b);

		//TEST LATITUDE VALUE
		$b = $bicycleService->validate(new Bicycle(null, -100, 50));
		$this->assertEquals(false, $b);
		$b = $bicycleService->validate(new Bicycle(null, -1, 50));
		$this->assertEquals(false, $b);
		$b = $bicycleService->validate(new Bicycle(null, 0, 50));
		$this->assertEquals(true, $b);
		$b = $bicycleService->validate(new Bicycle(null, 50, 50));
		$this->assertEquals(true, $b);
		$b = $bicycleService->validate(new Bicycle(null, 90, 50));
		$this->assertEquals(true, $b);
		$b = $bicycleService->validate(new Bicycle(null, 91, 50));
		$this->assertEquals(false, $b);
		$b = $bicycleService->validate(new Bicycle(null, 120, 50));
		$this->assertEquals(false, $b);
		$b = $bicycleService->validate(new Bicycle(null, "Hello World", 50));
		$this->assertEquals(false, $b);
		$b = $bicycleService->validate(new Bicycle(null, "50", 50));
		$this->assertEquals(true, $b);


		//TEST LONGITUDE VALUE
		$b = $bicycleService->validate(new bicycle(null, 50, -100));
		$this->assertEquals(false, $b);
		$b = $bicycleService->validate(new bicycle(null, 50, -1));
		$this->assertEquals(false, $b);
		$b = $bicycleService->validate(new bicycle(null, 50, 0));
		$this->assertEquals(true, $b);
		$b = $bicycleService->validate(new bicycle(null, 50, 50));
		$this->assertEquals(true, $b);
		$b = $bicycleService->validate(new bicycle(null, 50, 90));
		$this->assertEquals(true, $b);
		$b = $bicycleService->validate(new bicycle(null, 50, 91));
		$this->assertEquals(false, $b);
		$b = $bicycleService->validate(new bicycle(null, 50, 120));
		$this->assertEquals(false, $b);
		$b = $bicycleService->validate(new bicycle(null, 50, "Hello World"));
		$this->assertEquals(false, $b);
		$b = $bicycleService->validate(new bicycle(null, 50, "50"));
		$this->assertEquals(true, $b);
	}

	public function testCreate(){
		$bicycleService = new BicycleService($this->db);

		//TEST IF BICYCLE IS CREATED WHEN VALIDATE FAILS
		$b = $bicycleService->create(new Bicycle(null, -1, -1));
		$this->assertEquals(null, $b);

		//TEST WHEN BICYCLE IS RETURNED
		$b = $bicycleService->create(new Bicycle(null,50,50));
		$bicycleService->testDelete($b);
		$this->assertGreaterThan(0, $b->bicycle_id);
		$this->assertEquals(50,$b->latitude);
		$this->assertEquals(50,$b->longitude);
	}

	public function testRead(){
		$bicycleService = new BicycleService($this->db);

		$created = $bicycleService->create(new Bicycle(null, 50, 50));
		$b = $bicycleService->read($created->bicycle_id);
		$bicycleService->testDelete($created);
		$this->assertEquals($created->bicycle_id,$b->bicycle_id);
		$this->assertEquals($created->latitude, $b->latitude);
		$this->assertEquals($created->longitude, $b->longitude);

		$b = $bicycleService->read(12300);
		$this->assertEquals(null,$b);
	}

	public function testReadAllBicyclesWithRoute(){
		$bicycleService = new BicycleService($this->db);
		$b = $bicycleService->create(new Bicycle(null, 50, 50));
		$stmt = $this->db->prepare("INSERT INTO historyusagelocation(bicycle_id,timeforlocation,latitude,longitude) VALUE (?,100,50,50)");
		$stmt->bind_param("i",$b->bicycle_id);
		$stmt->execute();
		$stmt->close();

		$array = $bicycleService->readAllBicyclesWithRoute();

		$stmt = $this->db->prepare("DELETE FROM historyusagelocation WHERE bicycle_id = ?");
		$stmt->bind_param("i",$b->bicycle_id);
		$stmt->execute();
		$stmt->close();
		$bicycleService->testDelete($b);
		$this->assertContainsOnlyInstancesOf('Bicycle',$array);
        $allBicyclesMapped = array_map(function($x) {return json_encode($x); }, $array);
        $this->assertContains(json_encode(new Bicycle($b->bicycle_id,null,null)), $allBicyclesMapped);
	}

	public function testReadAll(){
		$bicycleService = new BicycleService($this->db);

		$b = $bicycleService->readAll();
		$this->assertContainsOnlyInstancesOf('Bicycle',$b);
	}

	public function testReadBicyclePositions(){
		$bicycleService = new BicycleService($this->db);

		$b = $bicycleService->create(new Bicycle(null, 50, 50));
		$stmt = $this->db->prepare("INSERT INTO historyusagelocation(bicycle_id,timeforlocation,latitude,longitude) VALUE (?,?,50,50)");
        $t = time();
		$stmt->bind_param("ii",$b->bicycle_id, $t);
		$stmt->execute();
		$stmt->close();

		$fromTime = $t - 60;
		$toTime = $t + 60;
		$array = $bicycleService->readBicyclePositions($b->bicycle_id,$fromTime,$toTime);
		
		$stmt = $this->db->prepare("DELETE FROM historyusagelocation WHERE bicycle_id = ?");
		$stmt->bind_param("i",$b->bicycle_id);
		$stmt->execute();
		$stmt->close();
		$bicycleService->testDelete($b);

		$this->assertContainsOnlyInstancesOf('stdClass',$array);
	}

	public function testReadBicycleBookingPairs(){
		$bicycleService = new BicycleService($this->db);
		$bookingService = new BookingService($this->db);
		$accountService = new AccountService($this->db);

		$bicycle = $bicycleService->create(new Bicycle(null,50,50));
		$account = $accountService->create(new Account("TestUser", "TestPassword","Test@Email.com","99999999","myToken",10));
		$booking = $bookingService->create(new Booking(null, 10, 10, 123456, $account->username));
		$stmt = $this->db->prepare("INSERT INTO historyusagebicycle(bicycle_id,booking_id,start_time) VALUES (?,?,0)");
        $stmt->bind_param("ii", $bicycle->bicycle_id,$booking->booking_id);
        $stmt->execute();
        $id = $this->db->insert_id;
        $stmt->close();

		$array = $bicycleService->readBicycleBookingPairs();

		$stmt = $this->db->prepare("DELETE FROM historyusagebicycle WHERE id = ?");
		$stmt->bind_param("i",$id);
		$stmt->execute();
		$stmt->close();
		$bookingService->delete($booking);
		$accountService->delete($account);
		$bicycleService->testDelete($bicycle);
		
		$this->assertContainsOnlyInstancesOf('stdClass',$array);
	}

	public function testUpdate(){
		$bicycleService = new BicycleService($this->db);
		$bicycle = $bicycleService->create(new Bicycle(null,50,50));

		$testbicycle = new Bicycle($bicycle->bicycle_id,70,70);
		$newbicycle = $bicycleService->update($testbicycle);
		$bicycleService->testDelete($bicycle);
		$this->assertEquals(70,$newbicycle->latitude);
		$this->assertEquals(70,$newbicycle->longitude);
	}
    
}
?>