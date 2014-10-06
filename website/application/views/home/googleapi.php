<style>
#map-canvas {
  height: 600px;
  margin: 10px;
  padding: 10px
}
</style>
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

<?php
  foreach ($stations as $station){
    echo "stations.push(new google.maps.LatLng(" . $station->latitude . ", " . $station->longitude . "));\n";
    echo "titles.push(\"" . $station->name . "\");\n";
    echo "infowindow.push(new google.maps.InfoWindow({content: '<div style=\"overflow:hidden;white-space:nowrap;\"><b>" . $station->name . "</b><br /> Available Bicycles: " . $stationService->readAllAvailableDocksForStation($station) . "<br/> Available Docks: " . $stationService->readAllUnavailableDocksForStation($station) . "</div>'}));\n";
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
            title: titles[i]
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