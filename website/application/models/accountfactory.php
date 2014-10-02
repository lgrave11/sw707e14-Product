<?php

class AccountFactory
{
	$db = null;

	function __construct($database){
		try{
			$this->db = $database;
		}
		catch(Exception $ex){
			exit("Unable to connect to database " . $ex);
		}
	}

	public function create($username, $password)
	{
		$stmt = $this->db->prepare("INSERT INTO  account(username, password, salt) VALUES (?, ?, ?)");
		$salt = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 64);
		$hashedPassword = $this->hashPassword($password, $salt);
		$stmt->bind_param("sss", $username, $hashedPassword, $salt);
		$stmt->execute();
		$stmt->close();
        return new Account($username, $hashedPassword, $salt);
	}

	private function hashPassword($password, $salt)
	{
		return hash('sha256', $password . $salt);
	}

	public function read($username)
    {
    	$stmt = $this->db->prepare("SELECT username, password, salt FROM account WHERE username = ?");
    	$stmt->bind_param("s", $username);
    	$stmt->execute();
    	$stmt->bind_result($user, $password, $salt);
    	$stmt->fetch();
    	$stmt->close();

        return new Account($username, $password, $salt);
    }

    public function update($username, $password)
    {
    	//lookup salt
    	$stmt = $this->db->prepare("SELECT salt from account WHERE username = ?");
    	$stmt->bind_param("s", $username);
    	$stmt->execute();
    	$stmt->bind_result($salt);
    	$stmt->fetch();
    	$stmt->close();

    	//Do the update
    	$stmt = $this->db->prepare("UPDATE account SET password = ? WHERE username = ?");
    	$hashedPassword = $this->hashedPassword($password, $salt)
    	$stmt->bind_param("s", $hashedPassword);
    	$stmt->execute();
    	$stmt->close();

        return new Account($username, $hashedPassword, $salt);
    }

    /**
    * deletes user based on the username
    * @param $username the username
    */
    public function delete($username)
    {
    	$stmt = $this->db->prepare("DELETE FROM account WHERE username = ?");
    	$stmt->bind_param("s",$username);
    	$stmt->execute();
    	$stmt->close();
    }

}

?>