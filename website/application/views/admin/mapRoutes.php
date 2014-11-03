<?php
	viewHelper::printSuccess('home');
?>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script src="/public/js/routesMap.js"></script>

<div id="map-container">
<div id="map-canvas"></div>
<form action="/Home/Book/" method="post">
	<h2>Bicycle Routes</h2>
	
	<select name="bicycle" id="bicycles" style="width: 243px;" onchange="UpdateMarker()">
	<option value="0" disabled selected>- Select Bicycle -</option>
	<?php
	foreach($bicycles as $bicycle){
		echo '<option value="'.$station->station_id.'">'.$station->name.'</option>';
	}
	?>
	</select><br />
	<div id="freebicycles"></div>
	<br />
	<?php
		if (Tools::isLoggedIn()){
			?>
	<h2>From Time:</h2>
	Date: <input id="datepicker" type="text" readonly name="fromdate" value="<?php echo ViewHelper::printDate(); ?>" style="width: 75px; text-align: center;" />
	Time: <input id="hourpicker" type="text" readonly name="fromhour" value="<?php echo ViewHelper::printHour(); ?>" style="width: 25px; text-align: center;" />:
	       <input id="minutepicker" type="text" readonly name="fromminute" value="<?php echo ViewHelper::printMinute(); ?>" style="width: 25px;  text-align: center;" />
	<h2>To Time:</h2>
	Date: <input id="datepicker" type="text" readonly name="todate" value="<?php echo ViewHelper::printDate(); ?>" style="width: 75px; text-align: center;" />
	Time: <input id="hourpicker" type="text" readonly name="tohour" value="<?php echo ViewHelper::printHour(); ?>" style="width: 25px; text-align: center;" />:
	      <input id="minutepicker" type="text" readonly name="tominute" value="<?php echo ViewHelper::printMinute(); ?>" style="width: 25px;  text-align: center;" />
	
	<?php
		}
	?>

	<div class="centerblock"><br />
	<?php
		if (Tools::isLoggedIn()){
			echo '<input type="submit" value="Show Map" class="button" />';
		} else {
			echo '<a href="/User/Login/">Login</a>';
		}
	?>
	</div>
</form>

</div>
