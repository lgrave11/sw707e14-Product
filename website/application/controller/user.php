<?php
class User extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function index()
    {
        $this->title = "User";
        Tools::requireLogin();
        require 'application/views/_templates/header.php';
        echo "du er logget ind, her er en bruger side";
        require 'application/views/_templates/footer.php';
    }

    public function viewHistory(){
        $this->title = "View History";
        $currentPage = substr($_SERVER["REQUEST_URI"], 1);
        $accountService = new AccountService($this->db);

        $bookings = $accountService->getBookings($_SESSION['login_user']);

        require 'application/views/_templates/header.php';
        require 'application/views/user/history.php';
        require 'application/views/_templates/footer.php';
    }

    public function logout()
    {
        $this->title = "Logout";
        session_destroy();
        if(Tools::isLoggedIn())
            unset($_SESSION['login_user']);

        header("Location: /");
        exit();
    }
    public function login()
    {
        $this->title = "Login";
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

    public function validate()
    {
        $this->title = "Validate";
        if(Tools::isLoggedIn())
            return true;

        $username=$_POST['username'];
        $password=$_POST['password'];
        $accountservice = new AccountService($this->db);

        return $accountservice->verifyLogin($username, $password);
        
    }

    public function createUser()
    {
        $this->title = "Create User";
        if(isset($_POST['submit']))
        {
            if(empty($_POST['username'])){
                $this->error('Username field is empty', 'createuser');
            }
            if(empty($_POST['password'])){
                $this->error('Password field is empty', 'createuser');
            }
            if(empty($_POST['passwordconfirm']))
            {
                $this->error('Confirm Password field is empty', 'createuser');
            }
            if($_POST['password'] != $_POST['passwordconfirm'])
            {
                $this->error('Passwords are not equal', 'createuser');
            }
            if(empty($_POST['email']))
            {
                $this->error('Email field is empty', 'createuser');
            }
            if(empty($_POST['phone']))
            {
                $this->error('Phone field is empty', 'createuser');
            }
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
            {
                $this->error('Invalid email', 'createuser');
            }
            if(!filter_var($_POST['phone'], FILTER_VALIDATE_INT))
            {
                $this->error('Invalid phone number', 'createuser');   
            }


            if($this->hasErrors('createuser'))
            {
                header("Location: /User/CreateUser/");
                exit();
            }

            $accountservice = new AccountService($this->db);

            if($accountservice->create(new Account($_POST['username'], $_POST['password'], $_POST['email'], $_POST['phone'])) == null)
            {
                $this->error('A user already exists with the given username', 'createuser');
                header("Location: /User/CreateUser/");
                exit();
            }
            else
            {
                $this->success('User ' . $_POST['username'] . ' has been created.', 'home');
                $_SESSION['login_user']= $_POST['username'];
                header("Location: /");
                exit();
            }
        }
        else
        {
            require 'application/views/_templates/header.php';
            require 'application/views/user/createprofile.php';
        }
        
        require 'application/views/_templates/footer.php';
    }

    public function changepassword()
    {
        $this->title = "Change Password";
        Tools::requireLogin();
        $accountservice = new AccountService($this->db);
        
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
        $this->title = "Edit Profile";
        Tools::requireLogin();
        $accountservice = new AccountService($this->db);
        
        $user = $accountservice->read($_SESSION['login_user']);
        
        $username= $user->username;
        $email= $user->email;
        $phone= $user->phone;
        
        require 'application/views/_templates/header.php';
        require 'application/views/user/editprofile.php';
        require 'application/views/_templates/footer.php';
    }

    public function changeAccountInfo() {
        $this->title = "Change Account Information";
        Tools::requireLogin();
        $accountservice = new AccountService($this->db);
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
