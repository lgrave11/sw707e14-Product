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
		if(validate($booking))
		{
			$stmt = $this->db->prepare("INSERT INTO booking(booking_id, start_time, start_station, password, for_user) VALUES (?,?,?,?,?)");
			$stmt->bind_param("isiss", 
				$booking->booking_id,
				$booking->start_time,
				$booking->start_station,
				$booking->password,
				$booking->for_user);

			$stmt->execute();
			$stmt->close();

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
		if(validate($booking))
		{
			$stmt = $this->db->prepare("DELETE FROM booking WHERE booking_id = ?");
			$stmt->bind_param("i", $booking->booking_id);
			$stmt->execute();
			$stmt->close();
			return true;
		}
		else
		{
			return false;
		}
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
}
?>
