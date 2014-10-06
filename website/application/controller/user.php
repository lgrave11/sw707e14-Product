<?php
class User extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function index()
    {
    

        // load views. within the views we can echo out $songs and $amount_of_songs easily
        require 'application/views/_templates/header.php';
        require 'application/views/user/index.php';
        require 'application/views/_templates/footer.php';
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
