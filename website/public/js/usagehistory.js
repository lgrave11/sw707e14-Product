
$(function() { 
    UpdateUsageContent(); 
});

function UpdateSelectList() {
    var type = $('#usageperspective option:selected').val();
    $("select[name='StationBicycleList']").load('/ajax/get'+capitaliseFirstLetter(type)+'Options');
}

function UpdateUsageContent() {
    var timer = setTimeout(function() { $('#loading').show(); }, 500);
    var type = $('#usageperspective option:selected').val();
    var id = $("select[name='StationBicycleList'] option:selected").attr('value');
    var fromtime = Date.parse($("#admin_fromdatepicker").val()) / 1000;
    var totime = Date.parse($("#admin_todatepicker").val()) / 1000;
    $('#usagecontent').load('/ajax/get'+capitaliseFirstLetter(type)+'UsageContent/'+encodeURIComponent(id)+'/'+fromtime+'/'+totime, function() { clearTimeout(timer); $('#loading').hide(); } );
}

function capitaliseFirstLetter(string)
{
    return string.charAt(0).toUpperCase() + string.slice(1);
}
