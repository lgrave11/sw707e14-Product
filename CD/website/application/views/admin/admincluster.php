<?php
	viewHelper::printSuccess('home');
?>
<script>
    var markers = <?php echo json_encode($positions); ?>    
</script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/src/markerclusterer.js"></script>
<script src="/public/js/adminCluster.js"></script>

<div id="map-container">
<div id="map-legend"></div>
<div id="map-canvasFullSize"></div>
</div>