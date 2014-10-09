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
        if (isset($_GET['target'])) {
            $target = $_GET['target'];
        }
        else{
            $target = "";
        }
        require 'application/views/_templates/header.php';

        if(isset($_POST['submit']))
        {
            if(!empty($_POST['username']) && !empty($_POST['password']))
            {
                if($this->validate())
                    {
                        session_regenerate_id(true);
                        error_log(json_encode($target));
                        $_SESSION['login_user']= $_POST['username'];
                        if ($target=="") {
                            header("Location: /");
                            exit();
                        }
                        else {
                            header("Location:".$target);
                            exit();
                        }
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
        $accountservice = new AccountService($this->db);
        $accountservice->create(new Account($username, $password, null));

    }
    public function validate()
    {
        if(Tools::isLoggedIn())
            return true;

        $username=$_POST['username'];
        $password=$_POST['password'];
        $accountservice = new AccountService($this->db);

        return $accountservice->verifyLogin($username, $password);
        
    }

    public function changepassword()
    {
        Tools::requireLogin();
        $accountservice = $this->loadModel('accountservice');
        
        /* Verify that the current password is correct */
        if (!($accountservice->verifyLogin($_SESSION['login_user'], $_POST['currpass']))) {
            $this->error('The current password is not correct', 'changepassword');
        }
        
        /* Verify that the new passwords are equal */
        if ($_POST['newpass1'] != $_POST['newpass2']) {
            $this->error('The new passwords does not agree', 'changepassword');
        }
        
        /* Update account */
        if (!$this->hasErrors('changepassword')) {
            $account = new Account($_SESSION['login_user'], $_POST['newpass1']);
            $accountservice->update($account);
            $this->success('Password changed', 'changepassword');
        }
        
        header('location: /user/editprofile');
    }

    public function editprofile()
    {
        Tools::requireLogin();
        $accountservice = $this->loadModel('accountservice');
        
        $user = $accountservice->read($_SESSION['login_user']);
        
        $username= $user->username;
        $email= $user->email;
        $phone= $user->phone;
        
        require 'application/views/_templates/header.php';
        require 'application/views/user/editprofile.php';
        require 'application/views/_templates/footer.php';
    }

    public function changeAccountInfo() {
        Tools::requireLogin();
        $accountservice = $this->loadModel('accountservice');
        $account = $accountservice->read($_SESSION['login_user']);
        
        if ($_POST['email'] != '') {
            $account->email = $_POST['email'];
        } else {
            $this->error('Empty email', 'accountinfo');
        }
        
        if ($_POST['phone'] != '') {
            $account->phone = $_POST['phone'];
        } else {
            $this->error('Empty phone number', 'accountinfo');
        }
        
        if (!$this->hasErrors('accountinfo')) {
            $accountservice->update($account);
            $this->success('Information saved', 'accountinfo');
        }
        
        header('Location: /User/EditProfile');
        
    }

    
}
