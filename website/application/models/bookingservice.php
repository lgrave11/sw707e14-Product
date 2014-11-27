<?php
class BookingService implements iService
{
    private $db = null;

    function __construct($database){
        try{
            $this->db = $database;
        }
        catch(Exception $ex){
            exit("Unable to connect to database " . $ex);
        }
    }

    public function create($booking)
    {
        if($this->validate($booking))
        {
            $stmt = $this->db->prepare("INSERT INTO booking(start_time, start_station, password, for_user) VALUES (?,?,?,?)");
            $stmt->bind_param("iiss",
                $booking->start_time,
                $booking->start_station,
                $booking->password,
                $booking->for_user);

            $stmt->execute();
            $booking->booking_id = $stmt->insert_id;
            $stmt->close();

            if(!WebsiteToStationNotifier::notifyStationBooking($booking->start_station, $booking->booking_id, $booking->start_time, $booking->password)){
            	$this->delete($booking);
            	return null;
            }

            return $booking;
        }
        else
        {
            return null;
        }
    }

    public function read($id)
    {
        if(is_numeric($id))
        {
            $stmt = $this->db->prepare("SELECT booking_id, start_time, start_station, password, for_user, used_bicycle FROM booking WHERE booking_id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->bind_result($booking_id, $start_time, $start_station, $password, $for_user, $used_bicycle);
            $stmt->fetch();
            $stmt->close();

            return new Booking($booking_id, $start_time, $start_station, $password, $for_user, $used_bicycle);
        }
        else
        {
            return null;
        }
    }

    public function update($booking)
    {
        
        if($this->validate($booking))
        {
            
            $stmt = $this->db->prepare("UPDATE booking set start_time = ?, password = ?, for_user = ? WHERE booking_id = ?");
            $stmt->bind_param("sssi",
                $booking->start_time,
                $booking->password,
                $booking->for_user,
                $booking->booking_id);
            $stmt->execute();
            $stmt->close();
            
            return $booking;
        }
        else
        {
            return null;
        }
    }

    public function delete($booking)
    {
        return $this->deleteActiveBooking($booking->booking_id) > 0;
    }

    /**
     * @param $booking Booking
     * @return bool
     */
    public function validate($booking)
    {
        //checks if types match
        if (!($booking instanceof booking)) {
            return false;
        }

        $valid = true;
        // Check if password is valid.
        if (!empty($booking->password)) {
            if (!Tools::validateBookingPw($booking->password))
                $valid = false;
        }

        // Check if start station exists.
        $stationservice = new StationService($this->db);
        if(empty($booking->start_station))
        {
            $valid = false;
        }
        else
        {
            $start_station = $stationservice->read($booking->start_station);
            if(empty($start_station))
            {
                $valid = false;
            }
        }
        // Check if any bicycles are available for booking.
        $amount_of_bicycles = $stationservice->readAllAvailableBicycles()[$booking->start_station];
        if($amount_of_bicycles <= 0)
        {
            $valid = false;
        }

        // Check if user exists.
        $accountservice = new AccountService($this->db);
        if(empty($booking->for_user))
        {
            $valid = false;
        }
        else
        {
            $for_user = $accountservice->read($booking->for_user);
            if(empty($for_user))
            {
               $valid = false;
            }
        }

        // Check that start time is valid.
        // TODO: Check? start time? How?
        if(empty($booking->start_time)) {
            $valid = false;
        }

        return $valid;
    }


    public function getOldBookings($username)
    {
        $returnArray = array();
        $stmt = $this->db->prepare("SELECT start_time, name FROM booking, station
                                    WHERE for_user = ? AND start_station = station_id AND start_time < ?
                                    ORDER BY start_time DESC");
        $currtime = time();
        $stmt->bind_param("si", $username, $currtime);
        $stmt->execute();
        $stmt->bind_result($start_time, $station_name);
        while($stmt->fetch()){
            $returnArray[$start_time] = new Booking(null, $start_time, $station_name, null, null, null);
        }
        $stmt->close();

        return $returnArray;
    }

    /**
     * Get all bookings for a specific user.
     * @param $username
     * @return array All the bookings for that user.
     */
    public function getBookings($username)
    {
        $returnArray = array();
        $stmt = $this->db->prepare("SELECT start_time, name FROM booking, station
                                    WHERE for_user = ? AND start_station = station_id
                                    ORDER BY start_time DESC");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($start_time, $station_name);
        while($stmt->fetch()){
            $returnArray[$start_time] = new Booking(null, $start_time, $station_name, null, null, null);
        }
        $stmt->close();

        return $returnArray;
    }
    
    public function getActiveBookingsForStation($station_id) 
    {
        $returnArray = array();
        $stmt = $this->db->prepare("SELECT booking_id, start_time, start_station, password, for_user, name, used_bicycle FROM booking, station
        WHERE start_station = ? AND password IS NOT NULL
        ORDER BY start_time ASC");
        $stmt->bind_param("s", $station_id);
        $stmt->execute();
        $stmt->bind_result($booking_id, $start_time, $start_station, $password, $for_user, $station_name, $used_bicycle);
        while($stmt->fetch()){
            $returnArray[$booking_id] = array(new Booking($booking_id, $start_time, $start_station, $password, $for_user, $used_bicycle), $station_name);
            
        }
        $stmt->close();
        
        return $returnArray;
    }

    public function getActiveBookings($username)
    {
        $returnArray = array();
        $stmt = $this->db->prepare("SELECT booking_id, start_time, start_station, password, for_user, name, used_bicycle FROM booking, station
                                    WHERE for_user = ? AND start_station = station_id AND password IS NOT NULL
                                    ORDER BY start_time ASC");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($booking_id, $start_time, $start_station, $password, $for_user, $station_name, $used_bicycle);
        while($stmt->fetch()){
            $returnArray[$booking_id] = array(new Booking($booking_id, $start_time, $start_station, $password, $for_user, $used_bicycle), $station_name);

        }
        $stmt->close();

        return $returnArray;
    }

    public function deleteActiveBooking($booking_id)
    {
        
    	$stmt = $this->db->prepare ("SELECT start_station FROM booking where booking_id = ?");
    	$stmt->bind_param("i", $booking_id);
    	$stmt->execute();
    	$stmt->bind_result($station_id);
    	$stmt->fetch();
    	$stmt->close();
        if(WebsiteToStationNotifier::notifyStationUnbooking($station_id, $booking_id)){
	        $stmt = $this->db->prepare("DELETE FROM booking WHERE booking_id = ?");
	        $stmt->bind_param("i", $booking_id);
	        $stmt->execute();
	        $rowsDeleted = $stmt->affected_rows;
	        $stmt->close();
	        return $rowsDeleted;
        }
     
        return 0;
    }
}
?>
