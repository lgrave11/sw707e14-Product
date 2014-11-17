<?php
require '../website/application/config/config.php';
class AccountServiceTest extends PHPUnit_Framework_TestCase
{

	private $db = null;
	function __construct(){
		parent::__construct();
		$this->db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die("fejl");
		print_r($this->db);
        mysqli_set_charset($this->db, "utf8");

	}

	public function testCreate()
	{
		//arrange
		$AccountService = new AccountService($this->db);
		$account = new Account("myspecialtestusername", "mytestpassword", "myspecialtestmail@gmail.com", "01020304", null, null, "user");
		$badaccount = new Account("", "mytestpassword", "myspecialtestmail@gmail.com", "01020304", null, null, "user");
		//Clean up just in case
		$AccountService->delete($account);

		//Act
		$result = $AccountService->create($account);
		
		//Test

		$this->assertNotEquals($result, null);
		$this->assertEquals($account->username, $result->username);
		$this->assertEquals(true, password_verify("mytestpassword", $result->password));
		$this->assertEquals("myspecialtestmail@gmail.com", $result->email);
		$this->assertEquals("01020304", $result->phone);
		$this->assertEquals(null, $result->token);
		$this->assertEquals(null, $result->reset_time);
		$this->assertEquals("user", $result->role);

		//Test when account already exists
		$result = $AccountService->create($account);
		$this->assertEquals(null, $result);

		//Clean up
		$AccountService->delete($account);
	}


	public function testRead()
	{
		//arrange
		$AccountService = new AccountService($this->db);
		$account = new Account("myspecialtestusername", "mytestpassword", "myspecialtestmail@gmail.com", "01020304", null, null, "user");
		//Clean up just in case
		$AccountService->delete($account);	

		//create the user in the database so it can be read
		$AccountService->create($account);

		//Act
		$result = $AccountService->read($account->username);

		//Test
		$this->assertEquals(null, $AccountService->read(""));
		$this->assertEquals(null, $AccountService->read(null));
		$this->assertEquals(null, $AccountService->read("this is a lame name"));

		//clean up
		$AccountService->delete($account);
	}

	public function testReadFromEmail()
	{
				//arrange
		$AccountService = new AccountService($this->db);
		$account = new Account("myspecialtestusername", "mytestpassword", "myspecialtestmail@gmail.com", "01020304", null, null, "user");
		//Clean up just in case
		$AccountService->delete($account);	

		//create the user in the database so it can be read
		$AccountService->create($account);

		//Act
		$result = $AccountService->readFromEmail($account->email);

		//Test
		$this->assertEquals(null, $AccountService->readFromEmail(""));
		$this->assertEquals(null, $AccountService->readFromEmail(null));
		$this->assertEquals(null, $AccountService->readFromEmail("thisisalameemail@gmail.com"));

		//clean up
		$AccountService->delete($account);
	}

	public function testUpdate()
	{
		$AccountService = new AccountService($this->db);
		$account = new Account("myspecialtestusername", "mytestpassword", "myspecialtestmail@gmail.com", "01020304", null, null, "user");

		$AccountService->delete($account);
		$AccountService->create($account);

		//TESTS
		//first is validate construct
		$result = $AccountService->update($account);
		$this->assertNotEquals(null, $result);

		//now with an invalid account
		$invalidaccount = clone $account;
		$invalidaccount->username = "";

		$result = $AccountService->update($invalidaccount);
		$this->assertEquals(null, $result);

		//Now for testing of updatus of each field.

		//password field
		$account->password = "newpassword";
		$AccountService->update($account);
		$result = $AccountService->read($account->username);
		$this->assertEquals(true, password_verify("newpassword", $result->password));

		//email
		$account->email = "newmail@gmail.com";
		$AccountService->update($account);
		$result = $AccountService->read($account->username);
		$this->assertEquals("newmail@gmail.com", $result->email);

		//phone
		$account->phone = "01010101";
		$AccountService->update($account);
		$result = $AccountService->read($account->username);
		$this->assertEquals("01010101", $result->phone);

		//token
		$account->token = "specialtoken";
		$AccountService->update($account);
		$result = $AccountService->read($account->username);
		$this->assertEquals("specialtoken", $result->token);


		$account->reset_time = 222;
		$AccountService->update($account);
		$result = $AccountService->read($account->username);
		$this->assertEquals(222, $result->reset_time);

		$AccountService->delete($account);
	}

	public function testDelete()
	{
				//arrange
		$AccountService = new AccountService($this->db);
		$account = new Account("myspecialtestusername", "mytestpassword", "myspecialtestmail@gmail.com", "01020304", null, null, "user");
		$badaccount = new Account("", "mytestpassword", "myspecialtestmail@gmail.com", "01020304", null, null, "user");
		
		//Clean up just in case
		$AccountService->delete($account);

		//Act
		$AccountService->create($account);
		
		//Test
		$result = $AccountService->delete($badaccount);
		$this->assertEquals(false, $result);

		$result = $AccountService->delete($account);
		$this->assertEquals(true, $result);

		$result = $AccountService->read($account->username);
		$this->assertEquals(null, $result);
	}

	public function testVerifyLogin()
	{
		$AccountService = new AccountService($this->db);
		$account = new Account("myspecialtestusername", "mytestpassword", "myspecialtestmail@gmail.com", "01020304", null, null, "user");
		
		//Clean up just in case
		$AccountService->delete($account);

		//Act
		$AccountService->create($account);
		
		//Test
		$result = $AccountService->verifyLogin($account->username, $account->password);
		$this->assertEquals(true, $result);

		$result = $AccountService->verifyLogin("Incorrect username", $account->password);
		$this->assertEquals(false, $result);

		$result = $AccountService->verifyLogin($account->username, "incorrect password");
		$this->assertEquals(false, $result);

		$result = $AccountService->verifyLogin("incorrect username", "incorrect password");
		$this->assertEquals(false, $result);
		$AccountService->delete($account);
	}

	public function testEmailExists()
	{
		$AccountService = new AccountService($this->db);
		$account = new Account("myspecialtestusername", "mytestpassword", "myspecialtestmail@gmail.com", "01020304", null, null, "user");
		
		//Clean up just in case
		$AccountService->delete($account);

		//Act
		$AccountService->create($account);
		
		//Test
		$result = $AccountService->emailExists($account->email);
		$this->assertEquals(true, $result);

		$result = $AccountService->emailExists("ddsaffasfdidsfafsadfdsfaiojdsiodsaojidsidsiodsdsfiojsfjio@adjoidfascbjiorhdfjiod.dk");
		$this->assertEquals(false, $result);


		$AccountService->delete($account);
	}

	public function testValidate()
	{
		$AccountService = new AccountService($this->db);
		$account = new Account("myspecialtestusername", "mytestpassword", "myspecialtestmail@gmail.com", "01020304", null, null, "user");
		
		//should pass all tests
		$result = $AccountService->validate($account);
		$this->assertEquals(true, $result);

		//bad empty username
		$accountwithbadusername = clone $account;
		$accountwithbadusername->username = "";
		$result = $AccountService->validate($accountwithbadusername);
		$this->assertEquals(false, $result);

		$accountwithbadusername->username = str_pad("a", 51, "x");
		$result = $AccountService->validate($accountwithbadusername);
		$this->assertEquals(false, $result);

		$accountwithbademail = clone $account;
		$accountwithbademail->email = "thisisnotanemail";
		$result = $AccountService->validate($accountwithbademail);
		$this->assertEquals(false, $result);

		$accountwithbadphone = clone $account;
		$accountwithbadphone->phone = "thisisnotaphonenumber";
		$result = $AccountService->validate($accountwithbadphone);
		$this->assertEquals(false, $result);

	}

}