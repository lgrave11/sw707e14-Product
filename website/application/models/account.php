<?php
class Account
{
	$username = null;
	$password = null;
	$salt = null;

	function __construct($username, $password, $salt){
		$this->username = $username;
		$this->password = $password;
		$this->salt = $salt;
	}
}


?>