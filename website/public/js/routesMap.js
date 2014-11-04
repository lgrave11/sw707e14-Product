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
    
    
    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
    for(var key in coords) 
    {
        var positionsLatLng = new Array();
        console.log(coords[key]);
        for(var i = 0; i < coords[key]["coordinates"].length; i++) 
        {
            var latlng = new google.maps.LatLng(coords[key]["coordinates"][i]["latitude"], coords[key]["coordinates"][i]["longitude"]);
            positionsLatLng.push(latlng);
        }

        var routePath = new google.maps.Polyline({
          path: positionsLatLng,
          geodesic: true,
          strokeColor: coords[key]["color"],
          strokeOpacity: 1.0,
          strokeWeight: 2
        });
        routePath.setMap(map);
        console.log(routePath);

    }
    
    /*for(var i; i < positionsLatLng.length; i++) 
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
    }*/
    
}

function getRandomColor() 
{
    var h = Math.floor(Math.random() * 360) + 1;
    var s = 75;
    var l = 50;
    var rgb = hslToRgb(h,s,l);
    return rgbToHex(rgb[0], rgb[1], rgb[2]);
    
}

function hslToRgb(h, s, l){
    var r, g, b;
    h = h / 360;
    s = s / 100;
    l = l / 100;

    if(s == 0){
        r = g = b = l; // achromatic
    }else{
        function hue2rgb(p, q, t){
            if(t < 0) t += 1;
            if(t > 1) t -= 1;
            if(t < 1/6) return p + (q - p) * 6 * t;
            if(t < 1/2) return q;
            if(t < 2/3) return p + (q - p) * (2/3 - t) * 6;
            return p;
        }

        var q = l < 0.5 ? l * (1 + s) : l + s - l * s;
        var p = 2 * l - q;
        r = hue2rgb(p, q, h + 1/3);
        g = hue2rgb(p, q, h);
        b = hue2rgb(p, q, h - 1/3);
    }

    return [Math.round(r * 255), Math.round(g * 255), Math.round(b * 255)];
}

function componentToHex(c) {
    var hex = c.toString(16);
    return hex.length == 1 ? "0" + hex : hex;
}

function rgbToHex(r, g, b) {
    return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);
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
