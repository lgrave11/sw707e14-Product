<?php

/**
 * Class Admin
 */

class Admin extends Controller
{
    public function index()
    {
        Tools::requireAdmin();
        
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


    public function mapRoutes($arr = array()) 
    {
        $this->title = "Map Routes";
        $currentPage = substr($_SERVER["REQUEST_URI"], 1);

        $bicycleService = new bicycleService($this->db);
        $bicycles = $bicycleService->readAll();
        
        $list = array_map(function($b) { return $b->bicycle_id; }, $bicycles);

        $jsFiles = ["routesMap", "admin.datetimepicker"];
        require 'application/views/_templates/adminheader.php';
        require 'application/views/admin/mapRoutes.php';
        require 'application/views/_templates/footer.php';
    }
    
    public function mapRoutesForm() 
    {
        $this->title = "Map Routes";
        $currentPage = substr($_SERVER["REQUEST_URI"], 1);
        if (empty($_POST['bicycles']) || empty($_POST['fromdate']) || empty($_POST['todate'])){
            $this->error("Please fill in all fields", "mapRoutes");
            header("Location: /Admin/MapRoutes");
            exit();
        }
        
        $fromdateSplit = preg_split("/[\s:\/]+/", $_POST['fromdate']);
        $todateSplit = preg_split("/[\s:\/]+/", $_POST['todate']);
        if (count($fromdateSplit) != 5 || !is_numeric($fromdateSplit[3]) || !is_numeric($fromdateSplit[4]) || !is_numeric($_POST['bicycles'])){
            $this->error("Please fill in correct information", "mapRoutes");
            header("Location: /Admin/MapRoutes");
            exit();
        }
        
        if (count($todateSplit) != 5 | !is_numeric($todateSplit[3]) || !is_numeric($todateSplit[4])){
            $this->error("Please fill in correct information", "mapRoutes");
            header("Location: /Admin/MapRoutes");
            exit();
        }
        
        $fromtime = mktime($fromdateSplit[3], $fromdateSplit[4], 0, $fromdateSplit[1], $fromdateSplit[0], $fromdateSplit[2]);
        $totime = mktime($todateSplit[3], $todateSplit[4], 0, $todateSplit[1], $todateSplit[0], $todateSplit[2]);
        
        $bicycleService = new bicycleService($this->db);
        $bicycles = $bicycleService->readBicyclePositions($_POST['bicycles'], $fromtime, $totime);
        $this->mapRoutes($bicycles);
    }
    
    public function usageHistory() {
        Tools::requireAdmin();
        
        $this->title = "Usage History";
        $bicycleservice = $this->loadModel("bicycleservice");
        $stationservice = $this->loadModel("stationservice");
        
        $list = array_map(function($b) { return $b->bicycle_id; }, $bicycleservice->readAll());
        
        $jsFiles = ["admin.datetimepicker", "amcharts", "usagehistory", "chart", "serial"];
        require 'application/views/_templates/adminheader.php';
        require 'application/views/admin/usagehistory.php';
        require 'application/views/_templates/footer.php';
    }

    public function graphTest(){
        

        require 'application/views/_templates/adminheader.php';
        require 'application/views/admin/graphtest.php';
        require 'application/views/_templates/footer.php';
    }

}
?>
