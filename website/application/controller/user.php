<?php
class User extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function index()
    {
        Tools::requireLogin();
        require 'application/views/_templates/header.php';
        echo "du er logget ind, her er en bruger side";
        require 'application/views/_templates/footer.php';
    }

    public function logout()
    {
        session_destroy();
        if(Tools::isLoggedIn())
            unset($_SESSION['login_user']);

        header("Location: /");
        exit();
    }
    public function login()
    {
        
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
                    {
                        $this->error('You provided a wrong username or password', 'login');
                        header("Location: /User/Login/");
                        exit();
                    }
            }
            else
            {
                $this->error('Please insert a username and password', 'login'); 
                header("Location: /User/Login/");
                exit();
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
        if(Tools::isLoggedIn())
            return true;

        $username=$_POST['username'];
        $password=$_POST['password'];
        $accountservice = $this->loadModel("AccountService");

        return $accountservice->verifyLogin($username, $password);
        
    }

    public function changepassword()
    {
        $_POST["currpass"];
        $_POST["newpass1"];
        $_POST["newpass2"];
        header("location: /user/editprofile");
    }

    public function editprofile()
    {
        $username="Poul Hansen";
        $email="Poul@test.dk";
        $phone="12345678";
        require 'application/views/_templates/header.php';
        require 'application/views/user/editprofile.php';
        require 'application/views/_templates/footer.php';
    }



    
}
