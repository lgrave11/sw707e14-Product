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

	public function validate($booking)
	{
	    $valid = true;
	    
	    if (!empty($booking->password)) {
	        if (!Tools::validateBookingPw($booking->password))
	            $valid = false;
	    }
	    
	    // TODO: Check that the start station exists
	    // TODO: Check that the user exists
	    // TODO: Check? start time?
		return $valid;
	}
}
?>
