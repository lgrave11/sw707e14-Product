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
<?php
	ViewHelper::printError('mapRoutes');
	ViewHelper::printSuccess('mapRoutes');
?>
<form action="/Admin/MapRoutesForm/" method="post">
	<h2>Bicycles</h2>
	
	<select name="bicycles[]" multiple id="mapRoutesSelect">
        <?php
            echo ViewHelper::GenerateHTMLSelectOptions($list);
        ?>
    </select><br />
	<br />
	<?php require 'application/views/admin/timeintervalpicker.php'; ?>

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
