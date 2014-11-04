
$(function() { 
    var type = $('#usageperspective option:selected').val();
    UpdateUsageContent(capitaliseFirstLetter(type)); 
});

function UpdateSelectList() {
    var type = $('#usageperspective option:selected').val();
    $("select[name='StationBicycleList']").load('/ajax/get'+capitaliseFirstLetter(type)+'Options');
}

function UpdateUsageContent() {
    var timer = setTimeout(function() { $('#loading').show(); }, 500);
    var type = $('#usageperspective option:selected').val();
    var id = $("select[name='StationBicycleList'] option:selected").val();
    $('#usagecontent').load('/ajax/get'+capitaliseFirstLetter(type)+'UsageContent/'+encodeURIComponent(id), function() { clearTimeout(timer); $('#loading').hide(); } );
}

function capitaliseFirstLetter(string)
{
    return string.charAt(0).toUpperCase() + string.slice(1);
}
