<?php
require '../website/application/config/config.php';
class BookingTest extends PHPUnit_Framework_TestCase
{
	private $db = null;
	function __construct(){
	parent::__construct();
	$this->db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	    mysqli_set_charset($this->db, "utf8");

	}


	public function testBooking()
	{
		//Arange
		$account = new Account("username", "password", "mymail@mydomain.com", "01020304", "mytoken", "myresettime", "user");
		$booking = new Booking(12345, 1415690764, 16, 456189, $account->username, 158);

		//Test assign
		$this->assertEquals($booking->booking_id, 12345);
		$this->assertEquals($booking->start_time, 1415690764);
		$this->assertEquals($booking->start_station, 16);
		$this->assertEquals($booking->password, 456189);
		$this->assertEquals($booking->for_user, $account->username);
		$this->assertEquals($booking->used_bicycle, 158);
	}

	public function testCreate()
	{
		//Arange
		$account = new Account("username", "password", "mymail@mydomain.com", "01020304", "mytoken", "myresettime", "user");
		$accountservice = new AccountService($this->db);
		$accountservice->create($account);
		$booking = new Booking(null, 1415690764, 16, 456189, $account->username, null);
		$bookingservice = new BookingService($this->db);
		$booking = $bookingservice->create($booking);
		$booking2 = new Booking(null, 1415690764, 16, 456189, $account->username);
		$booking3 = $bookingservice->create(clone $booking2);
		
		$testcreate = $bookingservice->create(13456);

		//Act
		$stmt = $this->db->prepare("SELECT booking_id, start_time, start_station, password, for_user, used_bicycle FROM booking WHERE booking_id = ?");
        $stmt->bind_param("i", $booking->booking_id);
		$stmt->execute();
		$stmt->bind_result($id, $start_time, $start_station, $password, $for_user, $used_bicycle);
        $stmt->fetch();
        $stmt->close();

		$testbooking = new Booking($id, $start_time, $start_station, $password, $for_user, $used_bicycle);


		//Test create
		$this->assertEquals($booking, $testbooking);
		$this->assertNull($testcreate);
		$this->assertNotEquals($booking2->booking_id, $booking3->booking_id);

		//Clean up
		$bookingservice->delete($booking);
		$bookingservice->delete($booking3);
		$accountservice->delete($account);
	}

	public function testRead()
	{
		//Arange
		$account = new Account("username", "password", "mymail@mydomain.com", "01020304", "mytoken", "myresettime", "user");
		$accountservice = new AccountService($this->db);
		$accountservice->create($account);
		$booking = new Booking(null, 1415690764, 16, 456189, $account->username, null);
		$bookingservice = new BookingService($this->db);
		$booking = $bookingservice->create($booking);
		$testread = $bookingservice->read("hej");

		//Act
		$stmt = $this->db->prepare("SELECT booking_id, start_time, start_station, password, for_user, used_bicycle FROM booking WHERE booking_id = ?");
		$stmt->bind_param("i", $booking->booking_id);
		$stmt->execute();
		$stmt->bind_result($id, $start_time, $start_station, $password, $for_user, $used_bicycle);
        $stmt->fetch();
        $stmt->close();

        $testbooking = $bookingservice->read($booking->booking_id);
        $testbooking2 = new Booking($id, $start_time, $start_station, $password, $for_user, $used_bicycle);
        //Test
		$this->assertEquals($testbooking2, $testbooking);
		$this->assertNull($testread);

		//Cleanup
		$bookingservice->delete($booking);
		
	}

	public function testUpdate()
	{
		//Arange
		$account = new Account("username", "password", "mymail@mydomain.com", "01020304", "mytoken", "myresettime", "user");
		$accountservice = new AccountService($this->db);
		$accountservice->create($account);
		$booking = new Booking(null, 1415690764, 16, 456189, $account->username, null);
		$bookingservice = new BookingService($this->db);
		$booking2 = $bookingservice->create(clone $booking);
		$booking2->start_time = 1415702765;
		$booking3 = $bookingservice->update(clone $booking2);
		
		//Act
		$stmt = $this->db->prepare("SELECT booking_id, start_time, start_station, password, for_user, used_bicycle FROM booking WHERE booking_id = ?");
		$stmt->bind_param("i", $booking3->booking_id);
		$stmt->execute();
		$stmt->bind_result($id, $start_time, $start_station, $password, $for_user, $used_bicycle);
        $stmt->fetch();
        $stmt->close();

        $booking4 = new Booking($id, $start_time, $start_station, $password, $for_user, $used_bicycle);

        //Test
        $this->assertNotEquals($booking, $booking2);
        $this->assertNotEquals($booking, $booking3);
        $this->assertNotEquals($booking, $booking4);
        $this->assertEquals($booking2, $booking3);
        $this->assertEquals($booking3, $booking4);
        $this->assertEquals($booking4->start_time, 1415702765);


        //Cleanup
        $accountservice->delete($account);
        $bookingservice->delete($booking2);

	}

	public function testDelete()
	{
		//Arange
		$account = new Account("username", "password", "mymail@mydomain.com", "01020304", "mytoken", "myresettime", "user");
		$accountservice = new AccountService($this->db);
		$accountservice->create($account);
		$booking = new Booking(null, 1415690764, 16, 456189, $account->username, null);
		$bookingservice = new BookingService($this->db);
		$booking = $bookingservice->create($booking);

		$booking2 = $bookingservice->read($booking->booking_id);
		$bookingservice->delete($booking);
		$booking3 = $bookingservice->read($booking_booking_id);

		//Test
		$this->assertNotEquals($booking2,$booking3);
		$this->assertNull($booking3->booking_id);
		$this->assertNull($booking3->start_time);
		$this->assertNull($booking3->start_station);
		$this->assertNull($booking3->password);
		$this->assertNull($booking3->for_user);
		$this->assertNull($booking3->used_bicycle);

		//Cleanup
		$accountservice->delete($account);
	}

	public function testValidate()
	{
		//Arange
		$account = new Account("username", "password", "mymail@mydomain.com", "01020304", "mytoken", "myresettime", "user");
		$accountservice = new AccountService($this->db);
		$accountservice->create($account);
		$booking = new Booking(null, 1415690764, 16, 456189, $account->username, null);
		$bookingservice = new BookingService($this->db);
		$booking = $bookingservice->create($booking);

		$test = $bookingservice->validate($booking);
		//Instance data
		$testInstance = $bookingservice->validate(12345);
		$testInstance2 = $bookingservice->validate("12345");
		
		//Stationdata
		$stationdata1 = new Booking(null, 141580764, 1032, 456189, $account->username, null);
		$stationdata2 = new Booking(null, 141580764, null, 456189, $account->username, null);
		$teststation1 = $bookingservice->validate($stationdata1);
		$teststation2 = $bookingservice->validate($stationdata2);

		//NumberofBicycles
		$stationservice = new StationService($this->db);
		$station = new Station(516, "TestStation", "Test 1337", 57.0134052, 9.988917);
		$stationservice->create($station);
		$bicycledata = new Booking(null, 1415690764, 516, 456189, $account->username, null);
		$bicyletest = $bookingservice->validate($bicycledata);


		//User
		$userdata1 = new Booking(null, 141580764, 16, 456189, null, null);
		$userdata2 = new Booking(null, 141580764, 16, 456189, "hshjfbks9652ugsfos9uifspghs", null);
		$testUser1 = $bookingservice->validate($userdata1);
		$testUser2 = $bookingservice->validate($userdata2);

		//Time, more to come
		$timedata1 = new Booking(null, null, 16, 456189, $account->username, null);


		$testtime1 = $bookingservice->validate($timedata1);


		//Test
		$this->assertTrue($test);
		$this->assertFalse($testInstance);
		$this->assertFalse($testInstance2);
		$this->assertFalse($teststation1);
		$this->assertFalse($teststation2);
		$this->assertFalse($bicyletest);
		$this->assertFalse($testUser1);
		$this->assertFalse($testUser2);
		$this->assertFalse($testtime1);


		//Cleanup
		$stationservice->deleteForTest($station);
		$bookingservice->delete($booking);
		$accountservice->delete($account);
	}


	public function testGetBookings()
	{
		//Arange
		$account1 = new Account("username", "password", "mymail@mydomain.com", "01020304", "mytoken", "myresettime", "user");
		$account2 = new Account("Bro", "Baus", "mailstuff@stuff.com", "98687687", "theToken","da restettime", "user");
		$accountservice = new AccountService($this->db);
		$accountservice->create($account1);
		$accountservice->create($account2);
		$booking1 = new Booking(null, 1415690764, 16, 456189, $account1->username, null);
		$booking2 = new Booking(null, 1415734893, 1, 134796, $account2->username, null);
		$booking3 = new Booking(null, 1415846952, 3, 268796, $account2->username, null);
		$booking4 = new Booking(null, 1415691764, 2, 644934, $account2->username, null);
		$bookingservice = new BookingService($this->db);
		$booking1 = $bookingservice->create($booking1);
		$booking2 = $bookingservice->create($booking2);
		$booking3 = $bookingservice->create($booking3);
		$stationservice = new StationService($this->db);
		$station1 = $stationservice->readStation($booking1->start_station);
		$station2 = $stationservice->readStation($booking2->start_station);
		$station3 = $stationservice->readStation($booking3->start_station);
		$station4 = $stationservice->readStation($booking4->start_station);

		//Act
		$result1 = $bookingservice->getBookings($account2->username);
		$mappedresult1 = array_map(function($x) {return json_encode($x); }, $result1);

		$booking4 = $bookingservice->create($booking4);
		$result2 = $bookingservice->getBookings($account2->username);
		$mappedresult2 = array_map(function($x) {return json_encode($x); }, $result2);


		//Test
		$this->assertContains(json_encode(new Booking(null, $booking2->start_time, $station2->name, null, null, null)), $mappedresult1);
		$this->assertContains(json_encode(new Booking(null, $booking3->start_time, $station3->name, null, null, null)), $mappedresult1);
		$this->assertCount(2, $mappedresult1);

		$this->assertContains(json_encode(new Booking(null, $booking2->start_time, $station2->name, null, null, null)), $mappedresult2);
		$this->assertContains(json_encode(new Booking(null, $booking3->start_time, $station3->name, null, null, null)), $mappedresult2);
		$this->assertContains(json_encode(new Booking(null, $booking4->start_time, $station4->name, null, null, null)), $mappedresult2);
		$this->assertCount(3, $mappedresult2);

		//Cleanup
		$bookingservice->delete($booking1);
		$bookingservice->delete($booking2);
		$bookingservice->delete($booking3);
		$bookingservice->delete($booking4);
		$accountservice->delete($account1);
		$accountservice->delete($account2);

	}

	public function testGetActiveBooking()
	{
		//Arange
		$account1 = new Account("username", "password", "mymail@mydomain.com", "01020304", "mytoken", "myresettime", "user");
		$account2 = new Account("Bro", "Baus", "mailstuff@stuff.com", "98687687", "theToken","da restettime", "user");
		$accountservice = new AccountService($this->db);
		$accountservice->create($account1);
		$accountservice->create($account2);
		$booking1 = new Booking(null, 1415690764, 16, 456189, $account1->username, null);
		$booking2 = new Booking(null, 1415734893, 1, 134796, $account2->username, null);
		$booking3 = new Booking(null, 1415846952, 3, 268796, $account2->username, null);
		$booking4 = new Booking(null, 1415691764, 2, 644934, $account2->username, null);
		$bookingservice = new BookingService($this->db);
		$booking1 = $bookingservice->create($booking1);
		$booking2 = $bookingservice->create($booking2);
		$booking3 = $bookingservice->create($booking3);
		$stationservice = new StationService($this->db);
		$station1 = $stationservice->readStation($booking1->start_station);
		$station2 = $stationservice->readStation($booking2->start_station);
		$station3 = $stationservice->readStation($booking3->start_station);
		$station4 = $stationservice->readStation($booking4->start_station);

		//Act
		$result1 = $bookingservice->getActiveBookings($account2->username);
		$mappedresult1 = array_map(function($x) {return json_encode($x); }, $result1);
		$test1 = json_encode(array($booking2, $station2->name));
		$test2 = json_encode(array($booking3, $station3->name));
		
		$booking4 = $bookingservice->create($booking4);
		$result2 = $bookingservice->getActiveBookings($account2->username);
		$mappedresult2 = array_map(function($x) {return json_encode($x); }, $result2);
		$test3 = json_encode(array($booking4, $station4->name));

		//Test
		$this->assertContains($test1, $mappedresult1);
		$this->assertContains($test2, $mappedresult1);
		$this->assertCount(2, $mappedresult1);

		$this->assertContains($test1, $mappedresult2);
		$this->assertContains($test2, $mappedresult2);
		$this->assertContains($test3, $mappedresult2);
		$this->assertCount(3, $mappedresult2);

		//Cleanup
		$bookingservice->delete($booking1);
		$bookingservice->delete($booking2);
		$bookingservice->delete($booking3);
		$bookingservice->delete($booking4);
		$accountservice->delete($account1);
		$accountservice->delete($account2);

	}

	public function testGetOldBookings()
	{
		//Arange
		$account1 = new Account("username", "password", "mymail@mydomain.com", "01020304", "mytoken", "myresettime", "user");
		$account2 = new Account("Bro", "Baus", "mailstuff@stuff.com", "98687687", "theToken","da restettime", "user");
		$accountservice = new AccountService($this->db);
		$accountservice->create($account1);
		$accountservice->create($account2);
		$booking1 = new Booking(null, 1, 16, 456189, $account1->username, null); //1 2 3 and 4 are all small unix times :)
		$booking2 = new Booking(null, 2, 1, 134796, $account2->username, null);
		$booking3 = new Booking(null, 3, 3, 268796, $account2->username, null);
		$booking4 = new Booking(null, 4, 2, 644934, $account2->username, null);
		$booking5 = new Booking(null, 9999999999, 2, 644934, $account2->username, null);
		$bookingservice = new BookingService($this->db);
		$booking1 = $bookingservice->create($booking1);
		$booking2 = $bookingservice->create($booking2);
		$booking3 = $bookingservice->create($booking3);
		$booking5 = $bookingservice->create($booking5);
		$stationservice = new StationService($this->db);
		$station1 = $stationservice->readStation($booking1->start_station);
		$station2 = $stationservice->readStation($booking2->start_station);
		$station3 = $stationservice->readStation($booking3->start_station);
		$station4 = $stationservice->readStation($booking4->start_station);

		//Act
		$result1 = $bookingservice->getOldBookings($account2->username);
		$mappedresult1 = array_map(function($x) {return json_encode($x); }, $result1);

		$booking4 = $bookingservice->create($booking4);
		$result2 = $bookingservice->getOldBookings($account2->username);
		$mappedresult2 = array_map(function($x) {return json_encode($x); }, $result2);


		//Test
		$this->assertContains(json_encode(new Booking(null, $booking2->start_time, $station2->name, null, null, null)), $mappedresult1);
		$this->assertContains(json_encode(new Booking(null, $booking3->start_time, $station3->name, null, null, null)), $mappedresult1);
		$this->assertCount(2, $mappedresult1);

		$this->assertContains(json_encode(new Booking(null, $booking2->start_time, $station2->name, null, null, null)), $mappedresult2);
		$this->assertContains(json_encode(new Booking(null, $booking3->start_time, $station3->name, null, null, null)), $mappedresult2);
		$this->assertContains(json_encode(new Booking(null, $booking4->start_time, $station4->name, null, null, null)), $mappedresult2);
		$this->assertCount(3, $mappedresult2);

		//Cleanup
		$bookingservice->delete($booking1);
		$bookingservice->delete($booking2);
		$bookingservice->delete($booking3);
		$bookingservice->delete($booking4);
		$bookingservice->delete($booking5);
		$accountservice->delete($account1);
		$accountservice->delete($account2);
	}


	
}

