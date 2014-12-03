requests = [];

function abortRequests() 
{
    requests.forEach(function(x) {
        x.abort();
    });
}

function updateAllStationStatus() 
{
    ids.forEach(function(x) {
        updateStationStatus(x)
    });
    $("a").click(abortRequests);
}

function updateStationStatus(station_id) {
    var result = $.ajax({
        url: "/Ajax/GetStationStatus/" + station_id,
        
    }).success(function() {
        console.log(result.responseText);
        if(result.responseText == "Online") 
        {
            $("#station" + station_id+".status").html("Online");
            $("#station" + station_id+".status").css("color", "green");
        }
        else 
        {
            $("#station" + station_id+".status").html("Offline");
            $("#station" + station_id+".status").css("color", "red");
        }
        
    });
    requests.push(result);
    
}