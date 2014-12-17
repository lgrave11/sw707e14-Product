var mks = [];

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
        center: new google.maps.LatLng(56.5,9.5),
        panControl: false,
        zoomControlOptions: {
            style: google.maps.ZoomControlStyle.LARGE,
            position: google.maps.ControlPosition.RIGHT_TOP,
        },
    };
    var map = new google.maps.Map(document.getElementById('map-canvasFullSize'), mapOptions);
    
    for(var i = 0; i < markers.length; i++) 
    {
        var marker = new google.maps.Marker(
        { 
            map:map, 
            draggable:false, 
            position: new google.maps.LatLng(markers[i]["latitude"], markers[i]["longitude"]),
            icon: bicycleimage
        });
        mks.push(marker);
    }
    var mc = new MarkerClusterer(map, mks);
}

window.onload = initialize;