<?php

class AccountService implements iService
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

	public function create($account)
	{
		$stmt = $this->db->prepare("INSERT INTO  account(username, password, salt) VALUES (?, ?, ?)");
		$salt = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 64);
		$hashedPassword = $this->hashPassword($account->password, $salt);
		$stmt->bind_param("sss", $account->username, $hashedPassword, $salt);
		$stmt->execute();
		$stmt->close();
        return new Account($username, $hashedPassword, $salt);
	}

	private function hashPassword($password, $salt)
	{
		return hash('sha256', $password . $salt);
	}

	public function read($account)
    {
    	$stmt = $this->db->prepare("SELECT username, password, salt FROM account WHERE username = ?");
    	$stmt->bind_param("s", $account->username);
    	$stmt->execute();
    	$stmt->bind_result($user, $password, $salt);
    	$stmt->fetch();
    	$stmt->close();

        return new Account($account->username, $password, $salt);
    }

    public function update($account)
    {
    	//lookup salt
    	$stmt = $this->db->prepare("SELECT salt from account WHERE username = ?");
    	$stmt->bind_param("s", $account->username);
    	$stmt->execute();
    	$stmt->bind_result($salt);
    	$stmt->fetch();
    	$stmt->close();

    	//Do the update
    	$stmt = $this->db->prepare("UPDATE account SET password = ? WHERE username = ?");
    	$hashedPassword = $this->hashedPassword($account->password, $salt)
    	$stmt->bind_param("s", $hashedPassword);
    	$stmt->execute();
    	$stmt->close();

        return new Account($account->username, $hashedPassword, $salt);
    }

    /**
    * deletes user based on the username
    * @param $username the username
    */
    public function delete($account)
    {
    	$stmt = $this->db->prepare("DELETE FROM account WHERE username = ?");
    	$stmt->bind_param("s",$account->username);
    	$stmt->execute();
    	$stmt->close();
    }

}

?>