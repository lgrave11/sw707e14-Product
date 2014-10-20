<?php
class Account
{
    public $username = null;
    public $password = null;
    public $email = null;
    public $phone = null;

    function __construct($username, $password, $email, $phone){
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->phone = $phone;
    }
}


?>
