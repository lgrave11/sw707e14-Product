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

        require 'application/views/_templates/adminheader.php';
        require 'application/views/admin/admin.php';
        require 'application/views/_templates/footer.php';
    }


    public function mapRoutes() 
    {
        $this->title = "Map Routes";
        $currentPage = substr($_SERVER["REQUEST_URI"], 1);

        $bicycleService = new bicycleService($this->db);
        $bicycles = $bicycleService->readAll();
        
        $list = array_map(function($b) { return $b->bicycle_id; }, $bicycles);

        require 'application/views/_templates/adminheader.php';
        require 'application/views/admin/mapRoutes.php';
        require 'application/views/_templates/footer.php';
    }
    
    public function mapRoutesForm() 
    {
        $this->title = "Map Routes";
        $currentPage = substr($_SERVER["REQUEST_URI"], 1);
        if (empty($_POST['bicycles']) || empty($_POST['fromdate']) || empty($_POST['todate']) || empty($_POST['fromhour']) || empty($_POST['tohour']) || empty($_POST['fromminute']) || empty($_POST['tominute'])){
            $this->error("Please fill in all fields", "mapRoutes");
            header("Location: /Admin/MapRoutes");
            exit();
        }
        
        $fromdateSplit = explode("/", $_POST['fromdate']);
        $todateSplit = explode("/", $_POST['todate']);

        if (!is_numeric($_POST['fromhour']) || !is_numeric($_POST['fromminute']) || !is_numeric($_POST['bicycles']) || count($fromdateSplit) != 3){
            $this->error("Please fill in correct information", "mapRoutes");
            header("Location: /Admin/MapRoutes");
            exit();
        }
        
        if (!is_numeric($_POST['tohour']) || !is_numeric($_POST['tominute']) || count($todateSplit) != 3){
            $this->error("Please fill in correct information", "mapRoutes");
            header("Location: /Admin/MapRoutes");
            exit();
        }
        
        $fromtime = mktime($_POST['fromhour'], $_POST['fromminute'], 0, $fromdateSplit[1], $fromdateSplit[0], $fromdateSplit[2]);
        $totime = mktime($_POST['tohour'], $_POST['tominute'], 0, $todateSplit[1], $todateSplit[0], $todateSplit[2]);
        
        $bicycleService = new bicycleService($this->db);
        $bicycles = $bicycleService->readBicyclePositions($_POST['bicycles'], $fromtime, $totime);
        
        var_dump($bicycles);
        
        //header('Location: /')
    }
    
    public function usageHistory() {
        Tools::requireAdmin();
        
        $this->title = "Usage History";
        $bicycleservice = $this->loadModel("bicycleservice");
        $stationservice = $this->loadModel("stationservice");
        
        $list = array_map(function($b) { return $b->id; }, $bicycleservice->readAll());
        
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
