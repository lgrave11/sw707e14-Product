var mouseoversearch = false;

function SearchStation(){
	if ($('#searchstation').val() != ""){
		$("#searchresult").load("/Ajax/SearchStation/" + $('#searchstation').val(), function(){
			$("#searchresult").show();
		});
	} else {
		$("#searchresult").hide();
		$("#searchresult").text("");
	}
}

function MouseOverSearch(){
	mouseoversearch = true;
}

function MouseLeaveSearch(){
	mouseoversearch = false;
	setTimeout(CloseSearch, 1000);
}

function CloseSearch(){
	if (mouseoversearch == false){
		$("#searchresult").hide();
	}
}

function ShowSearch(){
	if ($("#searchresult").text() != ""){
		$("#searchresult").show();
	}
}

function SelectStationFromList(station){
	$("#stations option").filter(function() {
	    //may want to use $.trim in here
	    mouseoversearch = false;
	    $("#searchresult").hide();
	    $("#searchstation").val('');
	    return $(this).text() == station;
	}).prop('selected', true);
	UpdateMarker();
}

function ReadAvailableBicycles(stationName){
	$("#stations option").filter(function() {
	    if ($(this).text() == stationName){
	    	$("#freebicycles").load("/Ajax/FreeBicycles/"+ $(this).val());
	    }
	})
}

function UpdateMarker(){
	var chosenStation = $("#stations").find(':selected').text();
	for (i = 0; i < mark.length; i++){
		if (mark[i].title == chosenStation){
			closeAllAndBounce(mark[i]);
			break;
		}
	}
	ReadAvailableBicycles(chosenStation);
}