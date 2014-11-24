<?php

/**
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Home extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function index()
    {
        $navbarChosen = "Overview";
        $this->title = "Home";
        $currentPage = substr($_SERVER["REQUEST_URI"], 1);
        $stationService = new StationService($this->db);
        $stations = $stationService->readAllStations();

        if (Tools::isLoggedIn()) {
            $bookingService = new BookingService($this->db);
            $activeBookings = $bookingService->getActiveBookings($_SESSION["login_user"]);

        }

        $jsFiles = ["frontpage", "googleapi", "unbookDialog", "jquery-ui"];
        require 'application/views/_templates/header.php';
        require 'application/views/home/index.php';
        require 'application/views/_templates/footer.php';
    }

    public function unbook($booking_id)
    {
        Tools::requireLogin();
        $bookingService = new BookingService($this->db);

        $bookingService->deleteActiveBooking($booking_id, $_SESSION["login_user"]);
        header("Location: /");
        exit();
    }

    public function book()
    {
        Tools::requireLogin();

        $bookingService = new BookingService($this->db);

        if (empty($_POST['station']) || !is_numeric($_POST['station'])) 
        {
            $this->error("The station field is invalid", "booking");
            header("Location: /");
            exit();
        }
        
        if (empty($_POST['date'])) 
        {
            
            $this->error("The date field is invalid", "booking");
            header("Location: /");
            exit();
        }
        else 
        {
            $dateSplit = explode("/", $_POST['date']);
            if(count($dateSplit) != 3) 
            {
                $this->error("The date field is invalid", "booking");
                header("Location: /");
                exit();
            }
            
        }
        
        if (empty($_POST['hour']) || !is_numeric($_POST['hour'])) 
        {
            $this->error("The hour field is invalid", "booking");
            header("Location: /");
            exit();
        }
        
        if (empty($_POST['minute']) || !is_numeric($_POST['minute'])) 
        {
            $this->error("The minute field is invalid", "booking");
            header("Location: /");
            exit();
        }

        

        $time = mktime($_POST['hour'], $_POST['minute'], 0, $dateSplit[1], $dateSplit[0], $dateSplit[2]);

        $booking = new Booking(NULL, $time, $_POST['station'], mt_rand(100000, 999999), $_SESSION['login_user']);

        if ($bookingService->validate($booking)){
            if($bookingService->create($booking) != null){
                $this->success("A bicycle has been booked", "booking");
            }
            else{
                $this->error("The station is offline, but will be registered once the station gets online","booking");
            }
        } else {
            $this->error("The booking could not be validated", "booking");
        }
        header("Location: /");
        exit();
    }    
}
