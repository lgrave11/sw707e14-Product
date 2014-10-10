<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script>
	var aalborg = new google.maps.LatLng(57.037835, 9.940895);
	var marker;
	var map;
	var stations = [];
	var titles = [];
	var mark = [];
	var map;
	var infowindow = [];
	var image = {
	    url: 'public/images/marker.png',
	    // This marker is 20 pixels wide by 32 pixels tall.
	    size: new google.maps.Size(25, 33),
	    // The origin for this image is 0,0.
	    origin: new google.maps.Point(0,0),
	    // The anchor for this image is the base of the flagpole at 0,32.
	    anchor: new google.maps.Point(0, 32),
		};

	<?php
	  	foreach ($stations as $station){
	    	echo "stations.push(new google.maps.LatLng(" . $station->latitude . ", " . $station->longitude . "));\n";
	    	echo "titles.push(\"" . $station->name . "\");\n";
	    	echo "infowindow.push(new google.maps.InfoWindow({content: '<div style=\"overflow:hidden;white-space:nowrap;\"><b>" . $station->name . "</b><br /> Available Bicycles: " . $stationService->readAllAvailableBicyclesForStation($station) . "<br/> Available Docks: " . $stationService->readAllAvailableDocksForStation($station) . "</div>'}));\n";
	  	}

	?>

	function initialize() {
	    var mapOptions = {
	        zoom: 13,
	      	center: aalborg,
	        panControl: false,
	        zoomControlOptions: {
	        	style: google.maps.ZoomControlStyle.LARGE,
	        	position: google.maps.ControlPosition.RIGHT_TOP,
	    	},
	    };

	    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

	    for(i = 0; i < stations.length; i++){
	    	mark.push(new google.maps.Marker({
	        	map:map,
	        	draggable:false,
	        	animation: google.maps.Animation.DROP,
	        	position: stations[i],
	        	title: titles[i],
	        	icon: image
	      	}));
	      	google.maps.event.addListener(mark[i], 'click', helperBounce(mark[i],toggleBounce));
	      	google.maps.event.addListener(mark[i], 'click', helperSelectStation(SelectStationFromList, mark[i].title));
	    }

		<?php
		  	for($i = 0; $i < count($stations); $i++){
		    	echo 
		        	"google.maps.event.addListener(mark[" . $i . "], 'click', function() {
		        		closeAllInfoWindows();
		          		infowindow[" . $i . "].open(map,mark[" . $i . "]);
		          		google.maps.event.addListener(infowindow[" . $i . "], 'closeclick',function(){
		          			stopAllBouncing();
		          		});
		      		});
					\n";
		  	}	
		?>  
	}

	function stopAllBouncing(){
		for(i = 0; i < mark.length; i++){
      		mark[i].setAnimation(null);
    	}
	}

	function closeAllInfoWindows() {
      	for(i = 0; i < infowindow.length; i++) 
      	{
      		infowindow[i].close();	
      	}
    }

  	function closeAllAndBounce(marker) {
  		closeAllInfoWindows();
  		toggleBounce(marker);
  	}

  	function helperSelectStation(func, name){
  		return function(){func(name)};
  	}

  	function helperBounce(i, func)
  	{
    	return function(){func(i)};
  	}

  	function toggleBounce(marker) {
  		stopAllBouncing();

    	if (marker.getAnimation() != null) {
      		marker.setAnimation(null);
    	} else {
      		marker.setAnimation(google.maps.Animation.BOUNCE);
    	}
  }

  google.maps.event.addDomListener(window, 'load', initialize);
</script>