
$(function() { 
    var type = $('#usageperspective option:selected').val();
    UpdateUsageContent(type); 
});

function UpdateSelectList() {
    $("select[name='StationBicycleList']").load('/ajax/getStationNameOptions');
}

function UpdateUsageContent() {
    $('#loading').show();
    var type = $('#usageperspective option:selected').val();
    var id = $("select[name='StationBicycleList'] option:selected").val();
    $('#usagecontent').load('/ajax/get'+type+'UsageContent/'+encodeURIComponent(id), function() { $('#loading').hide(250); } );
}
