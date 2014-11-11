<?php
class BicycleServiceTest extends PHPUnit_Framework_TestCase
{
	private $db = null;

 	function __construct(){
  		parent::__construct();
  		require '../website/application/config/config.php';
  		$this->db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        mysqli_set_charset($this->db, "utf8");
 	}

	public function testValidate(){
		$bicycleService = new BicycleService($this->db);

		//TEST NULL VALUES
		$b = $bicycleService->validate(new bicycle(null,null,null));
		$this->assertEquals(true, $b);
		$b = $bicycleService->validate(new bicycle(null, 1,null));
		$this->assertEquals(true, $b);
		$b = $bicycleService->validate(new bicycle(null, null, 1));
		$this->assertEquals(true, $b);

		//TEST LATITUDE VALUE
		$b = $bicycleService->validate(new bicycle(null, -100, 50));
		$this->assertEquals(false, $b);
		$b = $bicycleService->validate(new bicycle(null, -1, 50));
		$this->assertEquals(false, $b);
		$b = $bicycleService->validate(new bicycle(null, 0, 50));
		$this->assertEquals(true, $b);
		$b = $bicycleService->validate(new bicycle(null, 50, 50));
		$this->assertEquals(true, $b);
		$b = $bicycleService->validate(new bicycle(null, 90, 50));
		$this->assertEquals(true, $b);
		$b = $bicycleService->validate(new bicycle(null, 91, 50));
		$this->assertEquals(false, $b);
		$b = $bicycleService->validate(new bicycle(null, 120, 50));
		$this->assertEquals(false, $b);
		$b = $bicycleService->validate(new bicycle(null, "Hello World", 50));
		$this->assertEquals(false, $b);
		$b = $bicycleService->validate(new bicycle(null, "50", 50));
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
		$b = $bicycleService->validate(new bicycle(null, -1, -1));
		$this->assertEquals(null, $b);

		//TEST WHEN BICYCLE IS RETURNED
		$b = $bicycleService->create(new bicycle(null,50,50));
		$bicycleService->delete($b);
		$this->assertEquals(50,$b->latitude);
		$this->assertEquals(50,$b->longitude);
	}
}
?>