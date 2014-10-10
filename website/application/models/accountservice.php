<?php

class AccountService implements iService
{
	private $db = null;

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
        $stmt = $this->db->prepare("SELECT count(*) FROM account WHERE username = ?");
        $stmt->bind_param("s", $account->username);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if($count > 0)
            return null;

        if($this->validate($account))
        {
    		$stmt = $this->db->prepare("INSERT INTO  account(username, password, salt, email, phone) VALUES (?, ?, ?, ?, ?)");
    		$salt = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 64);
    		$hashedPassword = $this->hashPassword($account->password, $salt);
    		$stmt->bind_param("sssss", $account->username, $hashedPassword, $salt, $account->email, $account->phone);
    		$stmt->execute();
    		$stmt->close();
            return new Account($account->username, $hashedPassword, $account->email, $account->phone, $salt);
        }
        else
        {
            return null;
        }
	}

	private function hashPassword($password, $salt)
	{
		return hash('sha256', $password . $salt);
	}

	public function read($username)
    {
        if(!empty($username))
        {
        	$stmt = $this->db->prepare("SELECT username, password, salt, email, phone FROM account WHERE username = ?");
        	$stmt->bind_param("s", $username);
        	$stmt->execute();
        	$stmt->bind_result($user, $password, $salt, $email, $phone);
        	$stmt->fetch();
        	$stmt->close();
            return new Account($user, $password, $email, $phone, $salt);
        }
        else
        {
            return null;
        }
        
    }

    public function update($account)
    {
        if($this->validate($account))
        {
        	//lookup salt
        	$stmt = $this->db->prepare("SELECT salt from account WHERE username = ?");
        	$stmt->bind_param("s", $account->username);
        	$stmt->execute();
        	$stmt->bind_result($salt);
        	$stmt->fetch();
        	$stmt->close();

        	//Do the update
        	$stmt = $this->db->prepare("UPDATE account SET password = ?, email = ?, phone = ? WHERE username = ?");
        	$stmt->bind_param("ssss", $account->password, $account->email, $account->phone, $account->username);
        	$stmt->execute();
        	$stmt->close();

            return new Account($account->username, $hashedPassword, $salt);
        }
        else
        {
            return null;
        }
    }

    /**
    * deletes user based on the username
    * @param $username the username
    */
    public function delete($account)
    {
        if($this->validate($account))
        {
        	$stmt = $this->db->prepare("DELETE FROM account WHERE username = ?");
        	$stmt->bind_param("s",$account->username);
        	$stmt->execute();
        	$stmt->close();
            return true;
        }
        else
        {
            return false;
        }
    }

    public function verifyLogin($username, $password)
    {
            //lookup salt
            $stmt = $this->db->prepare("SELECT salt from account WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result($salt);
            $stmt->fetch();
            $stmt->close();


            if($salt == null)
                return false;
            $stmt = $this->db->prepare("SELECT password FROM account WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result($passwordhashed);
            $stmt->fetch();
            $stmt->close();
            
            if($passwordhashed == $this->hashPassword($password, $salt))
            {
                return true;
            }
            else
            {
                return false;
            }

    }

    public function validate($account)
    {
        $valid = true;
        
        if (!empty($account->username)) {
            if (!Tools::validateUsername($account->username))
                $valid = false;
        }
        if (!empty($account->email)) {
            if (!Tools::validateEmail($account->email))
                $valid = false;
        }
        if (!empty($account->phone)) {
            if (!Tools::validatePhone($account->phone)) 
                $valid = false;
        }
        
        return $valid;
    }

    public function getBookings($username)
    {
        $returnArray = array();
        $stmt = $this->db->prepare("SELECT start_time, name FROM booking, station
                                    WHERE for_user = ? AND start_station = station_id
                                    ORDER BY start_time DESC");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($start_time, $station_name);
        while($stmt->fetch()){
            $returnArray[$start_time] = new Booking(null, $start_time, $station_name, null, null);
        }
        $stmt->close();

        return $returnArray;
    }

}

?>
