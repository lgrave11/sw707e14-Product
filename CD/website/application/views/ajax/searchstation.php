<?php
foreach($stations as $station){
	echo '<span onclick="SelectStationFromList(\'' . $station->name . '\')" class="searchresulttext">' . $station->name . '</span>';
}
?>