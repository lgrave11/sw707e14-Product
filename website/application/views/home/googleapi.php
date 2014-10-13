<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script>
      var aalborg = new google.maps.LatLng(57.040835, 9.935895
);
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
    echo "infowindow.push(new google.maps.InfoWindow({content: "<div style=\"overflow:hidden;white-space:nowrap;\"><b>" . $station->name . "</b><br /> Available Bicycles: " . $stationService->readAllAvailableBicyclesForStation($station) . "<br/> Available Docks: " . $stationService->readAllAvailableDocksForStation($station) . "</div>'}));\n";
  }

?>

      function initialize() {
        var mapOptions = {
          zoom: 13,
          center: aalborg
        };


        map = new google.maps.Map(document.getElementById('map-canvas'),
                mapOptions);

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
          
        }

        <?php
          $i = 0;
          foreach ($stations as $station){
            echo "google.maps.event.addListener(mark[" . $i . "], 'click', function() {
              for(i = 0; i < infowindow.length; i++){infowindow[i].close();}
              infowindow[" . $i . "].open(map,mark[" . $i . "]);});\n";
            $i++;
          }
        ?>  
      }

      function helperBounce(i, func)
      {
        return function(){func(i)}
      }

      function toggleBounce(marker) {
        for(i = 0; i < mark.length; i++){
          mark[i].setAnimation(null);
        }

        if (marker.getAnimation() != null) {
          marker.setAnimation(null);
        } else {
          marker.setAnimation(google.maps.Animation.BOUNCE);
        }
      }

      google.maps.event.addDomListener(window, 'load', initialize);

    </script>
