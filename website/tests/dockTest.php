<?php
class DockTest extends PHPUNIT_Framework_TestCase
{
	public function testdockConstructor(){

		$d = new Dock(1,2,3);

		$this->assertEquals(1, $d->dock_id);
		$this->assertEquals(2, $d->station_id);
		$this->assertEquals(3, $d->holds_bicycle);
	}
}
?>	