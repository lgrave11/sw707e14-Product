<?php

/**
 * Class Admin
 */

class Admin extends Controller
{
    public function index()
    {
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
    
    public function usageHistory() {
        
        require 'application/views/_templates/adminheader.php';
        require 'application/views/admin/usagehistory.php';
        require 'application/views/_templates/footer.php';
    }
}
?>
