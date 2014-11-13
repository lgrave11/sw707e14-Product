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
            $stmt = $this->db->prepare("INSERT INTO account(username, password, email, phone, token, reset_time, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $hashedPassword = password_hash($account->password, PASSWORD_DEFAULT);
            $stmt->bind_param("sssssis", $account->username, $hashedPassword, $account->email, $account->phone, $account->token, $account->reset_time, $account->role);
            $stmt->execute();
            $stmt->close();
            return new Account($account->username, $hashedPassword, $account->email, $account->phone, $account->token, $account->reset_time, $account->role);
        }
        else
        {
            return null;
        }
    }
    
    /**
     * Read all accounts.
    */
    public function readAllAccounts() 
    {
        $returnAccounts = array();
        $stmt = $this->db->prepare("SELECT username, password, email, phone, token, reset_time, role FROM account");
        $stmt->execute();
        $stmt->bind_result($user, $password, $email, $phone, $token, $reset_time, $role);
        while($stmt->fetch()){
            $returnAccounts[] = new Account($user, $password, $email, $phone, $token, $reset_time, $role);
        }
        $stmt->close();
        return $returnAccounts;
    }

    /**
     * Read an account based on a username.
     * @param $username
     * @return Account|null
     */
    public function read($username)
    {
        $returnAccount = null;
        if(!empty($username))
        {
            $stmt = $this->db->prepare("SELECT username, password, email, phone, token, reset_time, role, COUNT(*) FROM account WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result($user, $password, $email, $phone, $token, $reset_time, $role, $count);
            $stmt->fetch();
            $stmt->close();
            if($count == 1) {
                $returnAccount = new Account($user, $password, $email, $phone, $token, $reset_time, $role);
            }

        }

        return $returnAccount;

    }

    /**
     * Read an account based on an email.
     * @param $email
     * @return Account|null
     */
    public function readFromEmail($email)
    {
        $returnAccount = null;
        if(!empty($email))
        {
            $stmt = $this->db->prepare("SELECT username, password, email, phone, token, reset_time, role, COUNT(*) FROM account WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($user, $password, $email, $phone, $token, $reset_time, $role,  $count);
            $stmt->fetch();
            $stmt->close();
            if($count == 1) {
                $returnAccount = new Account($user, $password, $email, $phone, $token, $reset_time, $role);
            }

        }

        return $returnAccount;

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
            $flag = true;
            if($this->read($account->username)->password == $account->password)
            {
                $flag = false;
            }
            $hashedPassword = $account->password;
            if($flag)
                $hashedPassword = password_hash($account->password, PASSWORD_DEFAULT);
            //Do the update
            $stmt = $this->db->prepare("UPDATE account SET password = ?, email = ?, phone = ?, token = ?, reset_time = ? WHERE username = ?");
            $stmt->bind_param("ssssis", $hashedPassword, $account->email, $account->phone, $account->token, $account->reset_time, $account->username);
            $stmt->execute();
            $stmt->close();

            return new Account($account->username, $hashedPassword, $account->email, $account->phone, $account->token, $account->reset_time, $account->role);
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

            return password_verify($password, $passwordHashed);

    }

    public function emailExists($email){
        $stmt = $this->db->prepare("SELECT email FROM account WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($result);
        $stmt->fetch();
        $stmt->close();

        if($result == null){
            return false;
        }
        return true;
    }

    /**
     * Validate an account.
     * @param $account The account to be validated.
     * @return bool Whether the account was valid or not.
     */
    public function validate($account)
    {
        $valid = true;
        if(empty($account->username))
        {
            $valid = false;
        }
        if (!empty($account->username) )
        {
            if (!Tools::validateUsername($account->username))
            {
                $valid = false;
            }
        }
        if (!empty($account->email)) {
            if (!Tools::validateEmail($account->email)){
                $valid = false;
            }
        }
        if (!empty($account->phone)) {
            if (!Tools::validatePhone($account->phone)){
                $valid = false;
            }
        }

        return $valid;
    }

}

?>

