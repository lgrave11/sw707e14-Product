<?php
class AccountTest extends PHPUnit_Framework_TestCase
{
	
	public function testFieldsAreAssigned()
	{
		//Arrange
		$account = new Account("username", "password", "mymail@mydomain.com", "01020304", "mytoken", "myresettime", "user");

		//Act - nothing here

		//Assert
		$this->assertEquals($account->username, "username");
		$this->assertEquals($account->password, "password");
		$this->assertEquals($account->email, "mymail@mydomain.com");
		$this->assertEquals($account->phone, "01020304");
		$this->assertEquals($account->token, "mytoken");
		$this->assertEquals($account->reset_time, "myresettime");
		$this->assertEquals($account->role, "user");

	}
}