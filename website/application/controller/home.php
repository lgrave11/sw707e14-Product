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
    	
        // load views. within the views we can echo out $songs and $amount_of_songs easily
        require 'application/views/_templates/header.php';
        require 'application/views/home/index.php';
        require 'application/views/_templates/footer.php';
    }
    public function about()
    {
        $this->title = "About";
        require 'application/views/_templates/header.php';
        require 'application/views/home/about.php';
        require 'application/views/_templates/footer.php';
    }

    
}
