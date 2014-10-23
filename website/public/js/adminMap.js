var aalborg = new google.maps.LatLng(57.037835, 9.940895);
var mark = [];
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

    map = new google.maps.Map(document.getElementById('map-canvasFullSize'), mapOptions);
    updateMarkers();
}

function updateMarkers() {
    var result = $.ajax({
        url: "/Ajax/GetBicyclePositions"
    }).success(function() {
        setAllMap(null);
        var j = $.parseJSON(result.responseText);
        for(i = 0; i < j.length; i++) {
            mark.push(
                new google.maps.Marker(
                    { 
                        map:map, 
                        draggable:false, 
                        position: new google.maps.LatLng(j[i]["latitude"], j[i]["longitude"]), 
                        icon: bicycleimage }
                    )
                );
        }
        setTimeout(function() {updateMarkers();}, 1000);
    });
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
