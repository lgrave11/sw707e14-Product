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
		echo "\nDone with Create Test";
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
		$testread = $bookingservice->read(54679);

		//Act
		$stmt = $this->db->prepare("SELECT booking_id, start_time, start_station, password, for_user, used_bicycle FROM booking WHERE booking_id = ?");
		$stmt->bind_param("i", $booking->booking_id);
		$stmt->execute();
		$stmt->bind_result($id, $start_time, $start_station, $password, $for_user, $used_bicycle);
        $stmt->fetch();
        $stmt->close();

        $testbooking = $bookingservice->read($booking);
        $testbooking2 = new Booking($id, $start_time, $start_station, $password, $for_user, $used_bicycle);
        //Test
		$this->assertEquals($testbooking2, $testbooking);
		$this->assertNull($testread);

		//Cleanup
		$bookingservice->delete($booking);
		echo "\nDone with Read test";
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
	
}

