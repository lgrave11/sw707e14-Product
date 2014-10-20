<?php
class Account
{
    public $username = null;
    public $password = null;
    public $email = null;
    public $phone = null;
    public $token = null;
    public $reset_time = null;

    function __construct($username, $password, $email, $phone, $token, $reset_time){
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->phone = $phone;
        $this->token = $token;
        $this->reset_time = $reset_time;
    }
}


?>
