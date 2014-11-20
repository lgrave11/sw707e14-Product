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
        Tools::requireAdmin();
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
        Tools::requireAdmin();
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


    public function RouteHistory($arr = array()) 
    {
        Tools::requireAdmin();
        $navbarChosen = "Route History";
        $this->title = "Route History";
        $currentPage = substr($_SERVER["REQUEST_URI"], 1);

        $bicycleService = new bicycleService($this->db);
        $bicycles = $bicycleService->readAllBicyclesWithRoute();
        
        $list = array_map(function($b) { return $b->bicycle_id; }, $bicycles);

        $jsFiles = ["routesMap", "admin.datetimepicker", "tinycolor"];
        require 'application/views/_templates/adminheader.php';
        require 'application/views/admin/mapRoutes.php';
        require 'application/views/_templates/footer.php';
    }
    
    public function routesHistoryForm() 
    {
        Tools::requireAdmin();
        $currentPage = substr($_SERVER["REQUEST_URI"], 1);
        if (empty($_POST['bicycles']) || empty($_POST['fromdate']) || empty($_POST['todate'])){
            $this->error("Please fill in all fields", "mapRoutes");
            header("Location: /Admin/RouteHistory");
            exit();
        }
        
        $fromdateSplit = preg_split("/[\s:\/]+/", $_POST['fromdate']);
        $todateSplit = preg_split("/[\s:\/]+/", $_POST['todate']);
        if (count($fromdateSplit) != 5 || !is_numeric($fromdateSplit[3]) || !is_numeric($fromdateSplit[4])){
            $this->error("Please fill in correct information", "mapRoutes");
            header("Location: /Admin/RouteHistory");
            exit();
        }
        
        if (count($todateSplit) != 5 | !is_numeric($todateSplit[3]) || !is_numeric($todateSplit[4])){
            $this->error("Please fill in correct information", "mapRoutes");
            header("Location: /Admin/RouteHistory");
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
        $this->RouteHistory($allRoutes);
    }
    
    public function usageHistory() {
        Tools::requireAdmin();
        
        $navbarChosen = "Usage History";
        $this->title = "Usage History";
        $currentPage = substr($_SERVER["REQUEST_URI"], 1);
        $bicycleservice = $this->loadModel("bicycleservice");
        $stationservice = $this->loadModel("stationservice");
        
        $list = array_map(function($b) { return $b->bicycle_id; }, $bicycleservice->readAll());
        
        $jsFiles = ["admin.datetimepicker", "usagehistory", "d3.min"];
        require 'application/views/_templates/adminheader.php';
        require 'application/views/admin/usagehistory.php';
        require 'application/views/_templates/footer.php';
    }

    public function graphTest() {
        Tools::requireAdmin();
        $jsFiles = ["d3.min", "graphtest"];

        require 'application/views/_templates/adminheader.php';
        require 'application/views/admin/graphtest.php';
        require 'application/views/_templates/footer.php';
    }
    
    public function addRemove() 
    {
        Tools::requireAdmin();
        $jsFiles = ["removeStation", "jquery-ui.min"];
        $navbarChosen = "Add/Remove";
        $this->title = "Add/Remove";
        $currentPage = substr($_SERVER["REQUEST_URI"], 1);
        
        $accountService = new AccountService($this->db);
        $allAccounts = array_map(function($a) { return $a->username; }, $accountService->readAllAccounts());
        $allAccounts = array_filter($allAccounts, function($username) { return $username != $_SESSION['login_user']; });
        
        $bicycleService = new BicycleService($this->db);
        $allBicycles = $bicycleService->readAllBicycles();
        
        $stationService = new StationService($this->db);
        $allStations = $stationService->readAllStations();
        
        $dockService = new DockService($this->db);
        $allDocks = $dockService->readAllDocksWithoutBicycleWithStationName();
        
        require 'application/views/_templates/adminheader.php';
        require 'application/views/admin/addRemove.php';
        require 'application/views/_templates/footer.php';
    }
    
    public function removeUserForm() 
    {
        Tools::requireAdmin();
        $jsFiles = [];
        $navbarChosen = "Add/Remove";
        $this->title = "Add/Remove";
        $currentPage = substr($_SERVER["REQUEST_URI"], 1);
        $accountService = new AccountService($this->db);
        $allAccounts = array_map(function($a) { return $a->username; }, $accountService->readAllAccounts());
        $allAccounts = array_filter($allAccounts, function($username) { return $username != $_SESSION['login_user']; });
        
        if(empty($_POST['users']) || !in_array($_POST['users'], $allAccounts) || $_POST['users'] == $_SESSION['login_user']) 
        {
            $this->error('User selected for removal is invalid or empty', 'addRemove');
        }
        
        if(!($this->hasErrors('addRemove'))) 
        {
            $account = $accountService->read($_POST['users']);
            if($accountService->delete($account))
                $this->success('User ' . $account->username . ' has been removed', 'addRemove');
            else
                $this->error('An error occurred', 'addRemove');
        }
        
        header("Location: /Admin/AddRemove");
    }
    
    public function addNewUserForm() 
    {
        Tools::requireAdmin();
        $jsFiles = [];
        $navbarChosen = "Add/Remove";
        $this->title = "Add/Remove";
        $currentPage = substr($_SERVER["REQUEST_URI"], 1);
        
        if(empty($_POST['username'])){
            $this->error('Username field is empty', 'addRemove');
        }
        if(empty($_POST['password'])){
            $this->error('Password field is empty', 'addRemove');
        }
        if(empty($_POST['passwordconfirm']))
        {
            $this->error('Confirm Password field is empty', 'addRemove');
        }
        if($_POST['password'] != $_POST['passwordconfirm'])
        {
            $this->error('Passwords are not equal', 'addRemove');
        }
        if(empty($_POST['email']))
        {
            $this->error('Email field is empty', 'addRemove');
        }
        if(empty($_POST['phone']))
        {
            $this->error('Phone field is empty', 'addRemove');
        }
        if(empty($_POST['role']) || ($_POST['role'] != "admin" && $_POST['role'] != "user")) 
        {
            $this->error('Role field is invalid or empty', 'addRemove');
        }
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        {
            $this->error('Invalid email', 'addRemove');
        }
        if(!filter_var($_POST['phone'], FILTER_VALIDATE_INT))
        {
            $this->error('Invalid phone number', 'addRemove');   
        }


        if(!($this->hasErrors('addRemove')))
        {
            $accountservice = new AccountService($this->db);

            if($accountservice->create(new Account($_POST['username'], $_POST['password'], $_POST['email'], $_POST['phone'], null, null, $_POST['role'])) == null)
            {
                $this->error('An error occurred creating a user.', 'addRemove');
            }
            else
            {
                $this->success('User ' . $_POST['username'] . ' has been created.', 'addRemove');
            }
        }
        
        header("Location: /Admin/AddRemove");
    }
    
    public function addBicycle() 
    {
        Tools::requireAdmin();
        $jsFiles = [];
        $navbarChosen = "Add/Remove";
        $this->title = "Add/Remove";
        $currentPage = substr($_SERVER["REQUEST_URI"], 1);
        $bicycleService = new BicycleService($this->db);
        
        $newBicycle = $bicycleService->create(new Bicycle(null,null,null));
        if(!empty($newBicycle))
            $this->success('Bicycle ' . $newBicycle->bicycle_id . ' has been added', 'addRemove');
        else
            $this->error('An error occurred', 'addRemove');
        
        header("Location: /Admin/AddRemove");
    }
    
    public function removeBicycle() 
    {
        Tools::requireAdmin();
        $jsFiles = [];
        $navbarChosen = "Add/Remove";
        $this->title = "Add/Remove";
        $currentPage = substr($_SERVER["REQUEST_URI"], 1);
        $bicycleService = new BicycleService($this->db);
        $bicycles = $bicycleService->readAllBicycles();
        
        if(empty($_POST['bicycles']) || !in_array($_POST['bicycles'], array_map(function($a) {return $a->bicycle_id; }, $bicycles))) 
        {
            $this->error('Bicycle selected for removal is invalid or empty', 'addRemove');
        }
        
        if(!($this->hasErrors('addRemove'))) 
        {
            $bicycle = $bicycleService->read($_POST['bicycles']);
            if($bicycleService->delete($bicycle))
                $this->success('Bicycle ' . $bicycle->bicycle_id . ' has been removed', 'addRemove');
            else
                $this->error('An error occurred', 'addRemove');
        }
        
        header("Location: /Admin/AddRemove");
    }
    
    public function addDock() 
    {
        Tools::requireAdmin();
        $jsFiles = [];
        $navbarChosen = "Add/Remove";
        $this->title = "Add/Remove";
        $currentPage = substr($_SERVER["REQUEST_URI"], 1);
        $dockService = new DockService($this->db);
        $stationService = new StationService($this->db);
        $allStations = $stationService->readAllStations();
        
        if(empty($_POST['docksStation']) || !in_array($_POST['docksStation'], array_map(function($a){return $a->station_id;}, $allStations)))
            $this->error('Station selected for dock is invalid or empty','addRemove');
                
        if(!($this->hasErrors('addRemove'))) 
        {
            $newDock = $dockService->create(new Dock(null, $_POST['docksStation'],null));
            if(!empty($newDock))
                $this->success('Dock ' . $newDock->dock_id . ' has been added to station ' . $stationService->read($_POST['docksStation'])->name, 'addRemove');
            else
                $this->error('An error occurred', 'addRemove');
        }
        
        header("Location: /Admin/AddRemove");
    }
    
    public function removeDock() 
    {
        Tools::requireAdmin();
        $jsFiles = [];
        $navbarChosen = "Add/Remove";
        $this->title = "Add/Remove";
        $currentPage = substr($_SERVER["REQUEST_URI"], 1);

        $dockService = new DockService($this->db);
        $allDocks = $dockService->readAllDocksWithoutBicycleWithStationName();
        
        if(empty($_POST['docksRemove']) || !in_array($_POST['docksRemove'], array_map(function($a) {return $a->dock_id; }, $allDocks))) 
        {
            $this->error('Dock selected for removal is invalid or empty', 'addRemove');
        }
        
        if(!($this->hasErrors('addRemove'))) 
        {
            $dock = $dockService->read($_POST['docksRemove']);
            if($dockService->delete($dock))
                $this->success('Dock ' . $dock->dock_id . ' has been removed', 'addRemove');
            else
                $this->error('An error occurred', 'addRemove');
        }
        
        header("Location: /Admin/AddRemove");
    }
    
    public function addStation(){
        Tools::requireAdmin();
        $jsFiles = [];
        $navbarChosen = "Add/Remove";
        $this->title = "Add/Remove";
        $currentPage = substr($_SERVER["REQUEST_URI"], 1);
        
        if(empty($_POST['name'])){
            $this->error('Name field is empty', 'addRemove');
        }
        if(empty($_POST['latitude'])){
            $this->error('Latitude field is empty', 'addRemove');
        }
        if(empty($_POST['longitude']))
        {
            $this->error('Longitude field is empty', 'addRemove');
        }
        if(empty($_POST['ipaddress']))
        {
            $this->error('IP Address field is empty', 'addRemove');
        }

        if(!($this->hasErrors('addRemove')))
        {
            $stationService = new StationService($this->db);

            if($stationService->create(new Station(null, $_POST['name'], null, $_POST['latitude'], $_POST['longitude'])) == null)
            {
                $this->error('An error occurred creating a station.', 'addRemove');
            }
            else
            {
                $this->success('Station ' . $_POST['name'] . ' has been created.', 'addRemove');
            }
        }
        
        header("Location: /Admin/AddRemove");
    }
    
    public function removeStation(){
        Tools::requireAdmin();
        $jsFiles = [];
        $navbarChosen = "Add/Remove";
        $this->title = "Add/Remove";
        $currentPage = substr($_SERVER["REQUEST_URI"], 1);
        $stationService = new StationService($this->db);
        $stations = $stationService->readAllStations();
        
        $dockService = new DockService($this->db);
        
        $bookingService = new BookingService($this->db);
        
        if(empty($_POST['stationRemove']) || !in_array($_POST['stationRemove'], array_map(function($a) {return $a->station_id; }, $stations))) 
        {
            $this->error('Bicycle selected for removal is invalid or empty', 'addRemove');
        }
        
        if(!($this->hasErrors('addRemove'))) 
        {
            $station = $stationService->read($_POST['stationRemove']);
            if($stationService->delete($station)){
                $docks = $dockService->readAllDocksForStation($station->station_id);
                foreach($docks as $d)
                {
                    $dockService->delete($d);
                }
                $bookings = $bookingService->getActiveBookingsForStation($station->station_id);
                foreach($bookings as $b) 
                {
                    $bookingService->deleteActiveBooking($b);
                }
                $this->success('Station ' . $station->name . ' and ' . count($docks) . ' docks have been removed', 'addRemove');
            }
            else
                $this->error('An error occurred', 'addRemove');
        }
        
        header("Location: /Admin/AddRemove");
    }
    
}
?>
