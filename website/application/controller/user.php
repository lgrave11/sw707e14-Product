<?php
class User extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function index()
    {
        if(!isset($_SESSION['login_user']))
        {
            header("Location: /User/Login/");
            exit();
        }
        require 'application/views/_templates/header.php';
        echo "du er logget ind, her er en bruger side";
        require 'application/views/_templates/footer.php';
    }

    public function login()
    {

        // load views. within the views we can echo out $songs and $amount_of_songs easily
        require 'application/views/_templates/header.php';
        
        if(isset($_POST['submit']))
        {
            if(!empty($_POST['username']) && !empty($_POST['password']))
            {
                if($this->validate())
                    {
                        session_regenerate_id(true);
                        $_SESSION['login_user']= $_POST['username'];
                        header("Location: /");
                        exit();
                    }
                else
                    echo "dit login er forkert";
            }
            else
            {
                echo "hov how";
            }
        }
        else
        {
            require 'application/views/user/index.php';
        }

        require 'application/views/_templates/footer.php';

    }

    public function dirtyCreateUser($username, $password)
    {
        $accountservice = $this->loadModel("AccountService");
        $accountservice->create(new Account($username, $password, null));

    }
    public function validate()
    {
        if(isset($_SESSION['login_user']))
            return true;

        $username=$_POST['username'];
        $password=$_POST['password'];
        $accountservice = $this->loadModel("AccountService");

        return $accountservice->verifyLogin($username, $password);
        
    }
    
}
