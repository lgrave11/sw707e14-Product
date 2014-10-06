<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script>
      var aalborg = new google.maps.LatLng(57.045107, 9.922334);
      var marker;
      var map;
      var stations = [];
<?php
  
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Marker Animations</title>
    <style>
      html, body, #map-canvas {
        height: 88%;
        margin: 10px;
        padding: 10px
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script>
      var aalborg = new google.maps.LatLng(57.045107, 9.922334);
      var marker;
      var map;
      var stations = [new google.maps.LatLng(57.045107, 9.922334), new google.maps.LatLng(57.054484, 9.898279), new google.maps.LatLng(57.044484, 9.98279)];
      var titles = ["First station", "This is the second", "I'm number three"];
      var mark = [];

      function initialize() {
        var mapOptions = {
          zoom: 13,
          center: aalborg
        };

        var contentString = '<div id="content">'+
          '<div id="siteNotice">'+
          '</div>'+
          '<h1 id="firstHeading" class="firstHeading">Uluru</h1>'+
          '<div id="bodyContent">'+
          '<p><b>Uluru</b>, also referred to as <b>Ayers Rock</b>, is a large ' +
          'sandstone rock formation in the southern part of the '+
          'Northern Territory, central Australia. It lies 335&#160;km (208&#160;mi) '+
          'south west of the nearest large town, Alice Springs; 450&#160;km '+
          '(280&#160;mi) by road. Kata Tjuta and Uluru are the two major '+
          'features of the Uluru - Kata Tjuta National Park. Uluru is '+
          'sacred to the Pitjantjatjara and Yankunytjatjara, the '+
          'Aboriginal people of the area. It has many springs, waterholes, '+
          'rock caves and ancient paintings. Uluru is listed as a World '+
          'Heritage Site.</p>'+
          '<p>Attribution: Uluru, <a href="http://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">'+
          'http://en.wikipedia.org/w/index.php?title=Uluru</a> '+
          '(last visited June 22, 2009).</p>'+
          '</div>'+
          '</div>';

        var infowindow = new google.maps.InfoWindow({content: contentString});

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
        }

        for(j = 0; j < mark.length; j++){
          google.maps.event.addListener(mark[j], 'click', helperBounce(mark[j],toggleBounce));
          //google.maps.event.addListener(mark[j], 'click', helperInfoWindow(infowindow.open,map, mark[j]));
        } 
        google.maps.event.addListener(mark[0], 'click', function() {infowindow.open(map,mark[0]);});

      }

      function helperInfoWindow(func, map, marker){
        return function(){func(map,marker)};
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
  </head>
  <body>
    <div id="map-canvas"></div>
  </body>
</html>