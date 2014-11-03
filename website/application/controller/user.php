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
        if(Tools::isLoggedIn()){
            header("Location: /");
        }
        else{
            header("Location: /User/login");
        }
        exit();
    }

    public function viewHistory(){
        $this->title = "View History";
        $currentPage = substr($_SERVER["REQUEST_URI"], 1);
        $bookingservice = new BookingService($this->db);

        $bookings = $bookingservice->getBookings($_SESSION['login_user']);

        require 'application/views/_templates/header.php';
        require 'application/views/user/history.php';
        require 'application/views/_templates/footer.php';
    }

    public function logout()
    {
        $this->title = "Logout";
        if(Tools::isLoggedIn()){
            unset($_SESSION['login_user']);
            session_destroy();
        }


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
        if(Tools::isLoggedIn()) 
        {
            if ($target=="") {
                header("Location: /");
                exit();
            }
            else {
                header("Location:".$target);
                exit();
            }
        }
        require 'application/views/_templates/header.php';

        $accountService = new AccountService($this->db);
        
        if(isset($_POST['submit']))
        {
            if(!empty($_POST['username']) && !empty($_POST['password']))
            {
                if($accountService->verifyLogin($_POST['username'], $_POST['password']))
                    {
                        session_regenerate_id(true);
                        error_log(json_encode($target));
                        $_SESSION['login_user']= $_POST['username'];
                        
                        /* TODO: Only temporary, since we need to handle admin differently */
                        $_SESSION['admin_user'] = $_POST['username'];
                        
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
                $this->error('An error happened creating a user.', 'createuser');
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
        $account = $accountservice->read($_SESSION['login_user']);
        if (!$this->hasErrors('changepassword')) {
            $updated_account = new Account($_SESSION['login_user'], password_hash($_POST['newpass1'], PASSWORD_DEFAULT), $account->email, $account->phone);
            $accountservice->update($updated_account);
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

        if($accountservice->emailExists($_POST['email']))
        {
            $this->error('Email already exists.', 'accountinfo');
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

    /**
     * All this is very insecure, but not a focus so we don't care.
     */
    public function forgotPassword()
    {
        $this->title = "Forgot your password?";

        require 'application/views/_templates/header.php';
        require 'application/views/user/forgotpassword.php';
        require 'application/views/_templates/footer.php';
    }

    public function forgotPasswordForm()
    {
        $this->title = "Forgot your password?";
        $email = $_POST["email"];
        $accountservice = new AccountService($this->db);
        $account = $accountservice->readFromEmail($_POST["email"]);
        if($account != null) {
            $account->token = Tools::randomString(64);
            $account->reset_time = strtotime("+10 minutes");
            $accountservice->update($account);
            // Ugh fuck GET.
            header('Location: /User/ResetPassword/'. $account->token . '/' .  $email);
            exit();
        }
        else {
            header('Location: /User/ForgotPassword/');
            exit();
        }
    }

    public function resetPassword($token, $email)
    {
        $this->title = "Reset your password";
        $accountservice = new AccountService($this->db);
        $account = $accountservice->readFromEmail($email);
        if($account != null) {
            if(time() < $account->reset_time && $account->token == $token)
            {
                require 'application/views/_templates/header.php';
                require 'application/views/user/resetpassword.php';
                require 'application/views/_templates/footer.php';
            }
            else {
                $this->error('There was an error in your link.', 'resetpassword');
                header('Location: /User/ForgotPassword/');
                exit();
            }
        }
        else {
            $this->error('The email was incorrect.', 'resetpassword');
            header('Location: /User/ForgotPassword/');
            exit();
        }
    }

    public function resetPasswordForm()
    {
        $accountservice = new AccountService($this->db);
        $account = $accountservice->readFromEmail($_POST["email"]);
        if($account != null) {
            if(time() < $account->reset_time && $account->token == $_POST["token"])
            {
                $account->password = password_hash($_POST["password"], PASSWORD_DEFAULT);
                $account->token = null;
                $account->reset_time = null;
                $accountservice->update($account);
                $this->success('Password was successfully updated.', 'resetpassword');
                header('Location: /User/Login/');
                exit();
            }
            else
            {
                $account->token = null;
                $account->reset_time = null;
                $accountservice->update($account);
                $this->error('There was an error in the token or your link has expired.', 'resetpassword');
                header('Location: /User/ForgotPassword/');
                exit();
            }
        }
        $this->error('The email was incorrect.', 'resetpassword');
        header('Location: /User/ForgotPassword/');
        exit();
    }

    
}
