<?php
	viewHelper::printSuccess('home');
?>

<div id="map-container">
<div id="map-canvas"></div>
<div id="mapinfo">
	<div style="position: relative;">
		<input type="text" id="searchstation" name="searchstation" class="searchbox" placeholder="Search Station" oninput="SearchStation();MouseOverSearch();" onfocus="ShowSearch();MouseOverSearch();" onmouseover="ShowSearch();MouseOverSearch();" onmouseout="MouseLeaveSearch()" autocomplete="off" /><br />
		<div id="searchresult" onmouseover="MouseOverSearch()" onmouseout="MouseLeaveSearch()"></div>
		<h1>Book</h1>
		<?php
        	ViewHelper::printError('booking');
        	ViewHelper::printSuccess('booking');
        ?>
		<form action="/Home/Book/" method="post">
			Station:<br />
			<select name="station" id="stations" style="width: 243px;" onchange="UpdateMarker()">
			<option value="0" disabled selected>- Select Station -</option>
			<?php
			foreach($stations as $station){
				echo '<option value="'.$station->station_id.'">'.$station->name.'</option>';
			}
			?>
			</select><br />
			<div id="freebicycles"></div>
			<br />
			Time for booking:<br />
			Date: <input id="datepicker" type="text" readonly name="date" value="<?php echo ViewHelper::printDate(); ?>" style="width: 75px" /> Time: <input id="hourpicker" type="text" readonly name="hour" value="<?php echo ViewHelper::printHour(); ?>" style="width: 25px" />:<input id="minutepicker" type="text" readonly name="minute" value="<?php echo ViewHelper::printMinute(); ?>" style="width: 25px" />
			<div class="centerblock"><br />
			<?php
				if (Tools::isLoggedIn()){
					echo '<input type="submit" value="Book" />';
				} else {
					echo '<a href="/User/Login/">Login</a>';
				}
			?>
			</div>
		</form>
	</div>
</div>
</div>