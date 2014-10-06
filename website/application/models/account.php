<?php
class Account
{
	public $username = null;
	public $password = null;
	public $salt = null;

	function __construct($username, $password, $salt){
		$this->username = $username;
		$this->password = $password;
		$this->salt = $salt;
	}
}


?>