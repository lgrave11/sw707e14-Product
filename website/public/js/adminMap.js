var aalborg = new google.maps.LatLng(57.037835, 9.940895);
var mark = [];
var map;
var geocoder;
var infowindow = [];
var address = [];
var openedInfoWindow;

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
    geocoder = new google.maps.Geocoder();
    
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
    map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(document.getElementById('map-legend'));

    var legend = document.getElementById('map-legend');

	var div = $("<div style='width: 10px;height: 10px;background-image: url(/public/images/bicycleMarker.png);float:left;margin-right:5px;margin-bottom:5px;'></div>" + 
				"<div style='float:right;margin-right:5px;'>Bicycle</div>").appendTo(legend);

    updateMarkers();
    
    
    google.maps.event.addListener(map, 'idle', function() {
        $("#map-legend").css("display", "inline");
    });
}

function getAddress(lat, lng, bicycleId, callback) 
{
    return geocoder.geocode({"latLng":new google.maps.LatLng(lat, lng)}, function(results, status){
                if (status == google.maps.GeocoderStatus.OK) {
                    callback(lat, lng, bicycleId, results[0].formatted_address);
                }
                else{
                    callback(lat,lng,bicycleId, "");
                }
            });
}

function CreateMarker(lat, lng, bicycleId, address){
    var info = new google.maps.InfoWindow(
                { content: '<div id="content">' +
                    '<h2 id="firstHeading" class="firstHeading" style="margin-bottom:-10px; white-space: nowrap; line-height:1.35;overflow:hidden;">ID: ' + bicycleId + '</h2>' + 
                    '<div id="bodyContent"><p style="white-space: nowrap; line-height:1.35;overflow:hidden;">Latitude: ' + lat +
                    '<br>Longitude: ' + lng + 
                    '<br>' + address + '</p></div></div>',
                });
    marker = new google.maps.Marker(
            { 
                map:map, 
                draggable:false, 
                position: new google.maps.LatLng(lat, lng), 
                icon: bicycleimage }
        );
    mark.push(marker);
    infowindow.push(info);
    google.maps.event.addListener(marker, 'click', infoHelper(marker,info,map));
}

function updateMarkers() {
    setAllMap(null);
    infowindow = [];
    var result = $.ajax({
        url: "/Ajax/GetBicyclePositions",
    }).success(function() {
    	if(mark.length >= j || mark.length == 0)
            var j = $.parseJSON(result.responseText);
        for(i = 0; i < j.length; i++) {
            getAddress(j[i]["latitude"],j[i]["longitude"], j[i]["bicycle_id"], CreateMarker);
        }
        if(openedInfoWindow != null){
            infowindow[openedInfoWindow[0]].open(map,mark[openedInfoWindow[1]]);
        }
        setTimeout(function() {updateMarkers();}, 10000);
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

function infoHelper(marker, info, maper){
    return function(){
            closeAllInfoWindows();
            info.open(maper,marker);
            openedInfoWindow = [mark.indexOf(marker), infowindow.indexOf(info)];
            google.maps.event.addListener(info, 'closeclick',function(){
                stopAllBouncing();
            })};
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

window.onload = initialize;