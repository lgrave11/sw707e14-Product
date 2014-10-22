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

            WebsiteToStationNotifier::notifyStationBooking($booking->start_station, $booking->booking_id, $booking->start_time, $booking->password);

            return $booking;
        }
        else
        {
            return null;
        }
    }

    public function read($booking)
    {
        if(validate($booking))
        {
            $stmt = $this->db->prepare("SELECT booking_id, start_time, start_station, password, for_user FROM booking WHERE booking_id = ?");
            $stmt->bind_param("i", $booking->booking_id);
            $stmt->execute();
            $stmt->bind_result($id, $start_time, $start_station, $password, $for_user);
            $stmt->fetch();
            $stmt->close();

            return new Booking($id, $start_time, $start_station, $password, $for_user);
        }
        else
        {
            return null;
        }
    }

    public function update($booking)
    {
        if(validate($booking))
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
        deleteActiveBooking($booking->booking_id,$booking->for_user);
    }

    /**
     * @param $booking Booking
     * @return bool
     */
    public function validate($booking)
    {
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
            $start_station = $stationservice->readStation($booking->start_station);
            if(empty($start_station))
            {
                $valid = false;
            }
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
            $returnArray[$start_time] = new Booking(null, $start_time, $station_name, null, null);
        }
        $stmt->close();

        return $returnArray;
    }

    public function getActiveBookings($username)
    {
        $returnArray = array();
        $stmt = $this->db->prepare("SELECT booking_id, start_time, start_station, password, for_user, name FROM booking, station
                                    WHERE for_user = ? AND start_station = station_id AND password IS NOT NULL
                                    ORDER BY start_time DESC");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($booking_id, $start_time, $start_station, $password, $for_user, $station_name);
        while($stmt->fetch()){
            $returnArray[$booking_id] = array(new Booking($booking_id, $start_time, $start_station, $password, $for_user), $station_name);

        }
        $stmt->close();

        return $returnArray;
    }

    public function deleteActiveBooking($booking_id, $username)
    {
    	$stmt = $this->db->prepare ("SELECT start_station FROM booking where booking_id = ?");
    	$stmt->bind_param("i", $booking_id);
    	$stmt->execute();
    	$stmt->bind_result($station_id);
    	$stmt->fetch();
    	$stmt->close();

        $stmt = $this->db->prepare("DELETE FROM booking WHERE booking_id = ? AND for_user = ?");
        $stmt->bind_param("is", $booking_id, $username);
        $stmt->execute();
        $rowsDeleted = $stmt->affected_rows;
        $stmt->close();

		WebsiteToStationNotifier::notifyStationUnbooking($station_id, $booking_id);

        return $rowsDeleted;
    }
}
?>
