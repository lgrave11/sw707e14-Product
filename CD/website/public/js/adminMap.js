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

function updateMarkers() {
    var result = $.ajax({
        url: "/Ajax/GetBicyclePositions",
    }).success(function() {
        var j = $.parseJSON(result.responseText);

        if(mark.length != j.length){
            for(i = 0; i < j.length; i++) {
                infowindow.push(new google.maps.InfoWindow(
                    { content: '<div id="content">' +
                        '<h2 id="firstHeading" class="firstHeading" style="margin-bottom:-10px; white-space: nowrap; line-height:1.35;overflow:hidden;">ID: ' + j[i]["bicycle_id"] + '</h2>' + 
                        '<div id="bodyContent"><p style="white-space: nowrap; line-height:1.35;overflow:hidden;">Latitude: ' + j[i]["latitude"] +
                        '<br>Longitude: ' + j[i]["longitude"],
                    })
                );

                mark.push(new google.maps.Marker(
                    { 
                        map:map, 
                        draggable:false, 
                        position: new google.maps.LatLng(j[i]["latitude"],j[i]["longitude"]), 
                        icon: bicycleimage 
                    }));
                google.maps.event.addListener(mark[i], 'click', infoHelper(mark[i],infowindow[i],map));
            }
        }

        for(i = 0; i < j.length; i++) {
            mark[i].setPosition(new google.maps.LatLng(j[i]["latitude"],j[i]["longitude"]));
        }
        setTimeout(function() {updateMarkers();}, 1);
    });
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
        }
}

window.onload = initialize;