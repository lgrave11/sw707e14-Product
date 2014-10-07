<?php
class Account
{
	public $username = null;
	public $password = null;
	public $salt = null;
	public $email = null;
	public $phone = null;

	function __construct($username, $password, $email, $phone, $salt = null){
		$this->username = $username;
		$this->password = $password;
		$this->salt = $salt;
		$this->email = $email;
		$this->phone = $phone;
	}
}


?>
