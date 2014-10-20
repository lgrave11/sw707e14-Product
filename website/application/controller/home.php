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
        $this->title = "Home";
        $currentPage = substr($_SERVER["REQUEST_URI"], 1);
        $stationService = new StationService($this->db);

        $stations = $stationService->readAllStations();

        if (Tools::isLoggedIn()) {
            $bookingService = new BookingService($this->db);
            $activeBookings = $bookingService->getActiveBookings($_SESSION["login_user"]);

        }

        // load views. within the views we can echo out $songs and $amount_of_songs easily
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

        if (empty($_POST['station']) || empty($_POST['date']) || empty($_POST['hour']) || empty($_POST['minute'])){
            $this->error("Please fill in all fields", "booking");
            header("Location: /");
            exit();
        }

        $dateSplit = explode("/", $_POST['date']);

        if (!is_numeric($_POST['hour']) || !is_numeric($_POST['minute']) || !is_numeric($_POST['station']) || count($dateSplit) != 3){
            $this->error("Please fill in correct information", "booking");
            header("Location: /");
            exit();
        }

        $time = mktime($_POST['hour'], $_POST['minute'], 0, $dateSplit[1], $dateSplit[0], $dateSplit[2]);

        $booking = new Booking(NULL, $time, $_POST['station'], mt_rand(100000, 999999), $_SESSION['login_user']);

        if ($bookingService->validate($booking)){
            $bookingService->create($booking);
            $this->success("A bicycle has been booked", "booking");
        } else {
            $this->error("The booking could not be validated", "booking");
        }

        header("Location: /");
        exit();
    }

    public function about()
    {
        $this->title = "About";
        require 'application/views/_templates/header.php';
        require 'application/views/home/about.php';
        require 'application/views/_templates/footer.php';
    }

    
}
