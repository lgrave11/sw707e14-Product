<?php
	ViewHelper::printError('overviewstations');
	ViewHelper::printSuccess('overviewstations');
?>



<script>
var ids = [<?php foreach($allStationInformation as $station) { echo $station->station_id; echo ","; } ?>];
</script>

<div>

<?php
foreach($allStationInformation as $station){

    echo '<div><fieldset><legend><b>' . $station->name . '</b></legend>';
    echo '<ul>';
    echo '<li> Status: <strong style="color:red;" class="status" id="station' . $station->station_id . '">Offline</strong></li>';
    echo '<li> Latitude: ' . $station->latitude . '</li>';
    echo '<li> Longitude: ' . $station->longitude . '</li>';
    echo '<li> Total Docks: ' . $station->allDocksCount . '</li>';
    echo '<li> Available Docks: ' . $station->availableDocks . '</li>';
    echo '<li> Available Bicycles: ' . $station->availableBicycles . '</li>';
    echo '<li> Locked Bicycles: ' . $station->lockedBicycles . '</li>';
    
    
    echo '<u1>';
    echo '</fieldset></div>';
}

 ?>
</div>