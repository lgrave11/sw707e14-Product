<?php
	viewHelper::printSuccess('home');
?>
<script type="text/javascript">
    var coords = <?php echo json_encode($arr); ?>;
</script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?libraries=geometry&sensor=true"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script src="/public/js/routesMap.js"></script>

<div id="map-container">
<div id="map-canvas"></div>
<?php
	ViewHelper::printError('bookingRoutes');
	ViewHelper::printSuccess('bookingRoutes');
?>
<form action="/Admin/BookingRoutesForm/" method="post">
	<h2>Bicycles</h2>
	<select size=<?php echo (count($list) > 5 ? 5 : count($list)); ?> style='height: 100%;' name="bicycle_id" id="bookingRoutesSelect">
        <?php
            foreach($list as $l) 
            {
                echo ViewHelper::generateHTMLSelectOption($l);
            }
            
        ?>
    </select><br />
	<br />

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
<div id="map-legend"></div>