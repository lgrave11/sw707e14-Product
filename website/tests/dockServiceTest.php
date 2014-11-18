<?php
require '../website/application/config/config.php';
class DockServiceTest extends PHPUnit_Framework_TestCase
{
	private $db = null;

 	function __construct(){
  		parent::__construct();
  		$this->db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        mysqli_set_charset($this->db, "utf8");
 	}
    
    public function testReadAllDocksForStation() 
    {
        $dockService = new DockService($this->db);
        $d = $dockService->create(new Dock(null, 2, null));
        $allDocksInStation = $dockService->readAllDocksForStation(2);
        $this->assertContainsOnlyInstancesOf("Dock", $allDocksInStation);
        
        $allDocksMapped = array_map(function($x) {return json_encode($x); }, $allDocksInStation);
        $this->assertContains(json_encode($d), $allDocksMapped);
        $dockService->delete($d);
    }

    public function testReadAllDocks() 
    {
        $dockService = new DockService($this->db);
        $d = $dockService->create(new Dock(null, 2, null));
        $allDocks = $dockService->readAllDocks();
        $this->assertContainsOnlyInstancesOf("Dock", $allDocks);
        $allDocksMapped = array_map(function($x) {return json_encode($x); }, $allDocks);
        $this->assertContains(json_encode($d), $allDocksMapped);
        $dockService->delete($d);
    }
    
    public function testCreate(){
		$dockService = new DockService($this->db);

		//TEST IF DOCK IS CREATED WHEN VALIDATE FAILS
		$d = $dockService->create(new Dock(null, null, null));
		$this->assertEquals(null, $d);

		//TEST WHEN DOCK IS RETURNED
		$d = $dockService->create(new Dock(null,2,null));
		$dockService->delete($d);
        $this->assertTrue(is_numeric($d->dock_id), true);
		$this->assertEquals(2,$d->station_id);
	}
    
    public function testUpdate() 
    {
        $dockService = new DockService($this->db);
        $d = $dockService->create(new Dock(null, 2, null));
        $d->holds_bicycle = 175;
        $d = $dockService->update($d);
        $this->assertEquals(175, $d->holds_bicycle);
        $dockService->delete($d);
    }
    
    public function testDelete() 
    {
        $dockService = new DockService($this->db);
        $d = $dockService->create(new Dock(null, 2, null));
        $deleted = $dockService->delete($d);
        $this->assertEquals(true, $deleted);
        $d = $dockService->create(new Dock(null, 999, null));
        $deleted = $dockService->delete($d);
        $this->assertEquals(false, $deleted);
    }
    
	public function testValidate(){
		$dockService = new DockService($this->db);

		//TEST NULL VALUES
		$d = $dockService->validate(new Dock(null,null,null));
		$this->assertEquals(false, $d);
		$d = $dockService->validate(new Dock(null, 1,null));
		$this->assertEquals(true, $d);
		$d = $dockService->validate(new Dock(null, 1, 1));
		$this->assertEquals(true, $d);
        $d = $dockService->validate(new Dock(null, null, 1));
		$this->assertEquals(false, $d);
	}
}
?>