var aalborg = new google.maps.LatLng(57.037835, 9.940895);
var mark = [];
var infowindow = [];
var map;

var bicycleimage = {
    url: '/public/images/bicycleMarker.png',
    // This marker is 20 pixels wide by 32 pixels tall.
    size: new google.maps.Size(10, 10),
    // The origin for this image is 0,0.
    origin: new google.maps.Point(0,0),
    // The anchor for this image is the base of the flagpole at 0,32.
    anchor: new google.maps.Point(5, 5),
    };

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
    
    var positionsLatLng = [];
    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
    for(var i = 0; i < coords.length; i++) 
    {
        var latlng = new google.maps.LatLng(coords[i]["latitude"], coords[i]["longitude"]);
        positionsLatLng.push(latlng);
    }

    var routePath = new google.maps.Polyline({
      path: positionsLatLng,
      geodesic: true,
      strokeColor: getRandomColor(),
      strokeOpacity: 1.0,
      strokeWeight: 2
    });
    
    for(var i; i < positionsLatLng.length; i++) 
    {
        var marker = new google.maps.Marker(
                    { 
                        map:map, 
                        draggable:false, 
                        position: positionsLatLng[i], 
                        icon: bicycleimage,
                        }
                    );
        mark.push(marker);
        var iw = new google.maps.InfoWindow({
            content: i.toString()
        });
        infowindow.push(iw);
        
        google.maps.event.addListener(marker, 'click', infoHelper(marker, iw, map));
    }
    routePath.setMap(map);
}

function getRandomColor() {
    var letters = '0123456789ABCDEF'.split('');
    var color = '#';
    for (var i = 0; i < 6; i++ ) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

function infoHelper(marker, info, map){
    return function(){ info.open(map,marker); }
}

// Sets the map on all markers in the array.
function setAllMap(map) {
  for (var i = 0; i < mark.length; i++) {
    mark[i].setMap(map);
  }
  mark = [];
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
