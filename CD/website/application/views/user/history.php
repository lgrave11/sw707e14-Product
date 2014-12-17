<table id="historytable">
<tr>
<th class = "historyth">
	Start Time
</th>
<th class = "historyth">
	Start Station
</th>
</tr>
<?php
	foreach ($bookings as $book) {
		echo "<tr><td>".date('d F Y H:i:s',$book->start_time)."</td><td>".$book->start_station."</td></tr>";
	}
?>
</table>		