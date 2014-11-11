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
		$booking = new booking(12345, 1415690764, 16, 456189, $account->username, 158);

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
		$accountservice = new accountservice($this->db);
		$accountservice->create($account);
		$booking = new booking(12345, 1415690764, 16, 456189, $account->username, 158);
		$bookingservice = new bookingservice($this->db);
		$bookingservice->create($booking);
		
		$testcreate = $bookingservice->create(13456);

		//Act
		$stmt = $this->db->prepare("SELECT booking_id, start_time, start_station, password, for_user, used_bicycle FROM booking WHERE booking_id = 12345");
		$stmt->execute();
		$stmt->bind_result($id, $start_time, $start_station, $password, $for_user, $used_bicycle);
        $stmt->fetch();
        $stmt->close();

		$testbooking = new booking($id, $start_time, $start_station, $password, $for_user, $used_bicycle);

		//Test create
		$this->assertEquals($booking, $testbooking);
		//$this->assertNull($testcreate);

		//Clean up
		$bookingservice->delete($booking);

	}

	public function testRead()
	{
		//Arange
		$account = new Account("username", "password", "mymail@mydomain.com", "01020304", "mytoken", "myresettime", "user");
		$booking = new booking(12345, 1415690764, 16, 456189, $account->username, 158);
		$bookingservice = new bookingservice($this->db);
		$bookingservice->create($booking);
		$testread = $bookingservice->read(54679);

		//Act
		$stmt = $this->db->prepare("SELECT booking_id, start_time, start_station, password, for_user, used_bicycle FROM booking WHERE booking_id = 12345");
		$stmt->execute();
		$stmt->bind_result($id, $start_time, $start_station, $password, $for_user, $used_bicycle);
        $stmt->fetch();
        $stmt->close();

        $testbooking = $bookingservice->read($booking);

        //Test
		$this->assertEquals($booking, $testbooking);
		$this->assertNull($testread);
	}
	



}

?>