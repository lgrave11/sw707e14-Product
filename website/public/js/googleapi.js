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
        },
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

            var info = new google.maps.InfoWindow(//{ content: contentString});
                        { content: '<div><h2 style="margin-bottom:-10px;">' + stations[i]["name"] + '</h2>' +
                        '<div id="bodyContent"><p> Available Bicycles: '   + freeBicycleList[i+1] + 
                        '</br> Available Docks: ' + freeDockList[i+1] + '</p></div></div>'});
            
            
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