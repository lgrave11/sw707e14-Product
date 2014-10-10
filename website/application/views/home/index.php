<?php
	viewHelper::printSuccess('home');
?>

<div id="map-container">
<div id="map-canvas"></div>
<div id="mapinfo">
	<div style="position: relative;">
		<input type="text" id="searchstation" name="searchstation" class="searchbox" placeholder="Search" oninput="SearchStation();MouseOverSearch();" onfocus="ShowSearch();MouseOverSearch();" onmouseover="ShowSearch();MouseOverSearch();" onmouseout="MouseLeaveSearch()" autocomplete="off" /><br />
		<div id="searchresult" onmouseover="MouseOverSearch()" onmouseout="MouseLeaveSearch()"></div>
		<h1>Book</h1>
		Station:<br />
		<select name="station" id="stations" style="width: 243px;">
		<option value="1">Test</option>
		<option value="1">Test</option>
		<option value="1">Aalborg Zoo</option>
		<option value="1">Test</option>
		<option value="1">Test</option>
		</select><br /><br />
		Time for booking:<br />
		<input id="hourpicker" type="text" readonly name="hour" value="<?php echo ViewHelper::printHour(); ?>" style="width: 25px" />:<input id="minutepicker" type="text" readonly name="minute" value="<?php echo ViewHelper::printMinute(); ?>" style="width: 25px" />-<input id="datepicker" type="text" readonly name="date" style="width: 75px" />
	</div>
</div>
</div>