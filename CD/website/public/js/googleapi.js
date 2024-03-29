var aalborg = new google.maps.LatLng(57.037835, 9.940895);
var mark = [];
var infowindow = [];
var map;
var image = {
    url: 'public/images/marker.png',
    size: new google.maps.Size(25, 33),
    origin: new google.maps.Point(0,0),
    anchor: new google.maps.Point(0, 32),
    };

function initialize() {
    var mapOptions = {
        zoom: 13,
        center: aalborg,
        panControl: false,
        zoomControlOptions: {
            style: google.maps.ZoomControlStyle.LARGE,
            position: google.maps.ControlPosition.RIGHT_TOP,
        }
    };

    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

    getTheStations();
    
}

function getTheStations() {
    $.ajaxSetup({async: false});

    var freeBicycleList
    var freeDockList
    $.get("/Ajax/getFreeBicyclesList/",function(data){
        freeBicycleList = $.parseJSON(data);
    });
    $.get("/Ajax/getFreeDocksList/",function(data){
        freeDockList = $.parseJSON(data);
    });

    $.get("/Ajax/getStations", function(data) {
        var stations = $.parseJSON(data);
        for(i = 0; i < stations.length; i++){
            var name = stations[i]["name"];
            var info = new google.maps.InfoWindow(
                        { content: '<div id="content">' +
                                   '<h2 id="firstHeading" class="firstHeading" style="margin-bottom:-10px; white-space: nowrap; line-height:1.35;overflow:hidden;">' + name + '</h2>' + 
                        '<div id="bodyContent"><p style="white-space: nowrap; line-height:1.35;overflow:hidden;">Available Bicycles: ' + freeBicycleList[i+1] +
                        '<br>Empty Docks: ' + freeDockList[i+1] + '</p></div></div>',
                        });
            
            
            var marker = new google.maps.Marker({
                map:map,
                draggable:false,
                animation: google.maps.Animation.DROP,
                position: new google.maps.LatLng(stations[i]["latitude"],stations[i]["longitude"]),
                title: stations[i]["name"],
                icon: image
            });
            
            google.maps.event.addListener(marker, 'click', helperBounce(marker,toggleBounce));
            google.maps.event.addListener(marker, 'click', helperSelectStation(SelectStationFromList, marker.title));
            google.maps.event.addListener(marker, 'click', infoHelper(marker,info,map));
            infowindow.push(info);
            mark.push(marker);
        }
    });
}

function addToFreeBicycles(data) 
{
    freeBicycles.push(data);
}

function addToFreeDocks(data) 
{
    freeDocks.push(data);
}

function infoHelper(marker, info, maper){
    return function(){
            closeAllInfoWindows();
            info.open(maper,marker);
            google.maps.event.addListener(info, 'closeclick',function(){
                stopAllBouncing();
            })};
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
    var index = mark.indexOf(marker);
    infowindow[index].open(map, marker);
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
