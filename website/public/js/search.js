function SearchStation(){
	if ($('#searchstation').val() != ""){
		$("#searchresult").load("/Ajax/SearchStation/" + $('#searchstation').val(), function(){
			$("#searchresult").show();
		});
	} else {
		$("#searchresult").hide();
	}
}