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

    /**
     * Create an account in the database.
     * @param $account
     * @return Account|null
     */
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
            $stmt = $this->db->prepare("INSERT INTO account(username, password, email, phone) VALUES (?, ?, ?, ?)");
            $hashedPassword = password_hash($account->password, PASSWORD_DEFAULT);
            $stmt->bind_param("ssss", $account->username, $hashedPassword, $account->email, $account->phone);
            $stmt->execute();
            $stmt->close();
            return new Account($account->username, $hashedPassword, $account->email, $account->phone);
        }
        else
        {
            return null;
        }
    }

    /**
     * Read an account based on a username.
     * @param $username
     * @return Account|null
     */
    public function read($username)
    {
        if(!empty($username))
        {
            $stmt = $this->db->prepare("SELECT username, password, email, phone FROM account WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result($user, $password, $email, $phone);
            $stmt->fetch();
            $stmt->close();
            return new Account($user, $password, $email, $phone);
        }
        else
        {
            return null;
        }

    }

    /**
     * Update an account.
     * @param $account
     * @return Account|null the updated account.
     */
    public function update($account)
    {
        if($this->validate($account))
        {
            //Do the update
            $stmt = $this->db->prepare("UPDATE account SET password = ?, email = ?, phone = ? WHERE username = ?");
            $stmt->bind_param("ssss", $account->password, $account->email, $account->phone, $account->username);
            $stmt->execute();
            $stmt->close();

            return new Account($account->username, $account->password, $account->email, $account->phone);
        }
        else
        {
            return null;
        }
    }

    /**
     * deletes user based on the username
     * @param $account The account.
     * @return bool Whether the account was deleted or not
     */
    public function delete($account)
    {
        if($this->validate($account))
        {
            $stmt = $this->db->prepare("DELETE FROM account WHERE username = ?");
            $stmt->bind_param("s", $account->username);
            $stmt->execute();
            $stmt->close();
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Verify a login based on a username and password.
     * @param $username
     * @param $password
     * @return bool Whether the login was verified or not.
     */
    public function verifyLogin($username, $password)
    {
            $stmt = $this->db->prepare("SELECT password FROM account WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result($passwordHashed);
            $stmt->fetch();
            $stmt->close();

            if(password_verify($password, $passwordHashed))
            {
                return true;
            }
            else
            {
                return false;
            }

    }

    /**
     * Validate an account.
     * @param $account The account to be validated.
     * @return bool Whether the account was valid or not.
     */
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

    /**
     * Get all bookings for a specific user.
     * @param $username
     * @return array All the bookings for that user.
     */
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
