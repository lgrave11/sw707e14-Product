<?php
class BookingService implements iService
{
	$db = null;

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

	public function read($booking_id)
	{
		$stmt = $this->db->prepare("SELECT booking_id, start_time, start_station, password, for_user FROM booking WHERE booking_id = ?");
		$stmt->bind_param("i", $booking_id);
		$stmt->execute();
		$stmt->bind_result($id, $start_time, $start_station, $password, $for_user);
		$stmt->fetch();
		$stmt->close();

		return new Booking($id, $start_time, $start_station, $password, $for_user);
	}

	public function update($booking)
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

	public function delete($booking)
	{
		$stmt = $this->db->prepare("DELETE FROM booking WHERE booking_id = ?");
		$stmt->bind_param("i", $booking->booking_id);
		$stmt->execute();
		$stmt->close();
	}

	private function validate($booking)
	{
		return true;
	}
}
?>