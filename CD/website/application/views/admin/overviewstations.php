<?php
	ViewHelper::printError('overviewstations');
	ViewHelper::printSuccess('overviewstations');
?>



<script>
var ids = [<?php foreach($allStationInformation as $station) { echo $station->station_id; echo ","; } ?>];
</script>

<div style="margin: auto">
<input style="display:block; margin:auto;" class="button" type="button" onclick="updateAllStationStatus();" name="Check All Status" value="Check All Status">
</div>

<div class="overviewStations">


<?php
foreach($allStationInformation as $station){

    echo '<fieldset><legend><b>' . $station->name . '</b></legend>';
    echo '<ul>';
    echo '<li> Status: <strong style="color:gray;" class="status" id="station' . $station->station_id . '">Not Checked</strong></li>';
    echo '<li> Station ID: ' . $station->station_id . '</li>';
    echo '<li> Latitude: ' . $station->latitude . '</li>';
    echo '<li> Longitude: ' . $station->longitude . '</li>';
    echo '<li> Total Docks: ' . $station->allDocksCount . '</li>';
    echo '<li> Available Docks: ' . $station->availableDocks . '</li>';
    echo '<li> Available Bicycles: ' . $station->availableBicycles . '</li>';
    echo '<li> Locked Bicycles: ' . $station->lockedBicycles . '</li>';
    echo '<input class="button" type="button" onclick="updateStationStatus('.$station->station_id.')" name="Check Status" value="Check Status">';
    echo '<ul>';
    echo '</fieldset>';
}

 ?>
</div>