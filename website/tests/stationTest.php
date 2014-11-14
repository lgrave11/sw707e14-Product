<?php
class AccountTest extends PHPUnit_Framework_TestCase
{
	
	public function testFieldsAreAssigned()
	{
		//Arrange
		$station = new Station(1, "test station name", "test address", 57.1, 9.2);

		//Act - nothing here

		//Assert
		$this->assertEquals(1, $station->station_id);
		$this->assertEquals("test station name", $station->name);
		$this->assertEquals("test address", $station->address);
		$this->assertEquals(57.1, $station->latitude);
		$this->assertEquals(9.2, $station->longitude);
	}
}