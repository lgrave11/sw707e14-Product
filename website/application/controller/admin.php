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
        $this->title = "Admin";
        $currentPage = substr($_SERVER["REQUEST_URI"], 1);

        $bicycleService = new bicycleService($this->db);
        $bicycles = $bicycleService->readAll();

        require 'application/views/_templates/header.php';
        require 'application/views/admin/mapRoutes.php';
        require 'application/views/_templates/footer.php';
    }
    
    public function usageHistory() {
        Tools::requireAdmin();
        
        $this->title = "Usage History";
        $bicycleservice = $this->loadModel("bicycleservice");
        $stationservice = $this->loadModel("stationservice");
        
        $list = array_map(function($b) { return $b->bicycle_id; }, $bicycleservice->readAll());
        
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
