<?php
class BicycleTest extends PHPUNIT_Framework_TestCase
{
	public function testbicycleConstructor(){

		$bicycle =  new Bicycle(17,13.2,5.9);

		$b = $bicycle;
		$this->assertEquals(17, $b->bicycle_id);
		$this->assertEquals(13.2, $b->latitude);
		$this->assertEquals(5.9, $b->longitude);
	}
}
?>	