<?php
	viewHelper::printSuccess('home');
?>
<script type="text/javascript">
    var coords = <?php echo json_encode($arr); ?>;
</script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script src="/public/js/routesMap.js"></script>

<div id="map-container">
<div id="map-canvas"></div>
<form action="/Admin/MapRoutesForm/" method="post">
	<h2>Bicycles</h2>
	
	<select name="bicycles">
        <?php
            echo ViewHelper::GenerateHTMLSelectOptions($list);
        ?>
    </select><br />
	<div id="freebicycles"></div>
	<br />
	<?php
		if (Tools::isLoggedIn()){
			?>
	<h2>From Time:</h2>
	Date: <input id="admin_fromdatepicker" type="text" readonly name="fromdate" value="<?php echo ViewHelper::printDate(); ?>" style="width: 75px; text-align: center;" />
	Time: <input id="admin_fromhourpicker" type="text" readonly name="fromhour" value="<?php echo ViewHelper::printHour(); ?>" style="width: 25px; text-align: center;" />:
	       <input id="admin_fromminutepicker" type="text" readonly name="fromminute" value="<?php echo ViewHelper::printMinute(); ?>" style="width: 25px;  text-align: center;" />
	<h2>To Time:</h2>
	Date: <input id="admin_todatepicker" type="text" readonly name="todate" value="<?php echo ViewHelper::printDate(); ?>" style="width: 75px; text-align: center;" />
	Time: <input id="admin_tohourpicker" type="text" readonly name="tohour" value="<?php echo ViewHelper::printHour(); ?>" style="width: 25px; text-align: center;" />:
	      <input id="admin_tominutepicker" type="text" readonly name="tominute" value="<?php echo ViewHelper::printMinute(); ?>" style="width: 25px;  text-align: center;" />
	
	<?php
		}
	?>

	<div class="centerblock"><br />
	<?php
		if (Tools::isLoggedIn()){
			echo '<input type="submit" value="Show Route" class="button" />';
		} else {
			echo '<a href="/User/Login/">Login</a>';
		}
	?>
	</div>
</form>

</div>
