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