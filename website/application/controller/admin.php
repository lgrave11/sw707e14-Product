<?php

/**
 * Class Admin
 */

class Admin extends Controller
{
    public function index()
    {
        Tools::requireAdmin();
        $navbarChosen = "GPS Tracking";
        $this->title = "Admin";
        $currentPage = substr($_SERVER["REQUEST_URI"], 1);

        $bicycleService = new bicycleService($this->db);
        $bicycles = $bicycleService->readAll();

        if (Tools::isLoggedIn()) {
            $bookingService = new BookingService($this->db);
            $activeBookings = $bookingService->getActiveBookings($_SESSION["login_user"]);

        }
        $jsFiles = ["adminMap"];
        require 'application/views/_templates/adminheader.php';
        require 'application/views/admin/admin.php';
        require 'application/views/_templates/footer.php';
    }

    public function bookingRoutes($arr = array()) 
    {
        $navbarChosen = "Booking Routes";
        $this->title = "Booking Routes";
        $currentPage = substr($_SERVER["REQUEST_URI"], 1);
        $bicycleService = new bicycleService($this->db);
        $bicyclesBookings = $bicycleService->readBicycleBookingPairs();
        $list = array();
        if(count($bicyclesBookings) > 0) 
        {
            foreach ($bicyclesBookings as $v) {
                if(!in_array($v->bicycle_id, $list)) 
                {
                    $list[] = $v->bicycle_id;
                }
                
            }
        }

        $jsFiles = ["bookingMap", "tinycolor"];
        require 'application/views/_templates/adminheader.php';
        require 'application/views/admin/bookingRoutes.php';
        require 'application/views/_templates/footer.php';

    }

    public function bookingRoutesForm() 
    {
        $navbarChosen = "Booking Routes";
        $this->title = "Booking Routes";
        $currentPage = substr($_SERVER["REQUEST_URI"], 1);
        if (empty($_POST['bicycle_id'])){
            $this->error("Please fill the bicycle id field", "bookingRoutes");
            header("Location: /Admin/BookingRoutes");
            exit();
        }
        $bicycleService = new bicycleService($this->db);
        $bicyclesBookings = $bicycleService->readBicycleBookingPairs();
        //var_dump($bicyclesBookings);
        $positions = array();
        foreach($bicyclesBookings as $bb) 
        {
            if($bb->bicycle_id == $_POST['bicycle_id'])
                $positions[$bb->booking_id] = $bicycleService->readBicyclePositionsWithBooking($bb->bicycle_id, $bb->booking_id);

        }
        $allRoutes = array();
        foreach ($positions as $key => $value) {
            $allRoutes[$key]["coordinates"] = $value;
            $allRoutes[$key]["color"] = ViewHelper::generateRandomColor($key);
        }
        $this->bookingRoutes($allRoutes);
    }


    public function mapRoutes($arr = array()) 
    {
        $navbarChosen = "Map Routes";
        $this->title = "Map Routes";
        $currentPage = substr($_SERVER["REQUEST_URI"], 1);

        $bicycleService = new bicycleService($this->db);
        $bicycles = $bicycleService->readAllBicyclesWithRoute();
        
        $list = array_map(function($b) { return $b->bicycle_id; }, $bicycles);

        $jsFiles = ["routesMap", "admin.datetimepicker", "tinycolor"];
        require 'application/views/_templates/adminheader.php';
        require 'application/views/admin/mapRoutes.php';
        require 'application/views/_templates/footer.php';
    }
    
    public function mapRoutesForm() 
    {
        $navbarChosen = "Map Routes";
        $this->title = "Map Routes";
        $currentPage = substr($_SERVER["REQUEST_URI"], 1);
        if (empty($_POST['bicycles']) || empty($_POST['fromdate']) || empty($_POST['todate'])){
            $this->error("Please fill in all fields", "mapRoutes");
            header("Location: /Admin/MapRoutes");
            exit();
        }
        
        $fromdateSplit = preg_split("/[\s:\/]+/", $_POST['fromdate']);
        $todateSplit = preg_split("/[\s:\/]+/", $_POST['todate']);
        if (count($fromdateSplit) != 5 || !is_numeric($fromdateSplit[3]) || !is_numeric($fromdateSplit[4])){
            $this->error("Please fill in correct information", "mapRoutes");
            header("Location: /Admin/MapRoutes");
            exit();
        }
        
        if (count($todateSplit) != 5 | !is_numeric($todateSplit[3]) || !is_numeric($todateSplit[4])){
            $this->error("Please fill in correct information", "mapRoutes");
            header("Location: /Admin/MapRoutes");
            exit();
        }
        
        //Hour, Minute, Second, Month, Day, Year
        $fromtime = mktime($fromdateSplit[3], $fromdateSplit[4], 0, $fromdateSplit[1], $fromdateSplit[0], $fromdateSplit[2]);
        $totime = mktime($todateSplit[3], $todateSplit[4], 0, $todateSplit[1], $todateSplit[0], $todateSplit[2]);
        
        $bicycleService = new bicycleService($this->db);
        $allRoutes = array();
        foreach($_POST['bicycles'] as $b) 
        {
            $allRoutes[$b]["coordinates"] = $bicycleService->readBicyclePositions($b, $fromtime, $totime);
            $allRoutes[$b]["color"] = ViewHelper::generateRandomColor($b, count($_POST['bicycles']));
        }
        $this->mapRoutes($allRoutes);
    }
    
    
    
    public function usageHistory() {
        Tools::requireAdmin();
        
        $navbarChosen = "Usage History";
        $this->title = "Usage History";
        $currentPage = substr($_SERVER["REQUEST_URI"], 1);
        $bicycleservice = $this->loadModel("bicycleservice");
        $stationservice = $this->loadModel("stationservice");
        
        $list = array_map(function($b) { return $b->bicycle_id; }, $bicycleservice->readAll());
        
        $jsFiles = ["admin.datetimepicker", "usagehistory"];
        require 'application/views/_templates/adminheader.php';
        require 'application/views/admin/usagehistory.php';
        require 'application/views/_templates/footer.php';
    }

    public function graphTest() {
        $jsFiles = ["d3.min", "graphtest"];

        require 'application/views/_templates/adminheader.php';
        require 'application/views/admin/graphtest.php';
        require 'application/views/_templates/footer.php';
    }

}
?>
