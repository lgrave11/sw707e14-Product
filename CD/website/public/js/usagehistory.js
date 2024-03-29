


function UpdateSelectList() {
    var type = $('#usageperspective option:selected').val();
    if (type == "Traffic"){
        $("#selectlistlabel h2").html("");
        $("select[name='StationBicycleList']").hide();
    } else {
        $("#selectlistlabel h2").html("Choose " + type);
        $("select[name='StationBicycleList']").show().load('/ajax/get'+capitaliseFirstLetter(type)+'Options');
    }
    
    
}

function UpdateUsageContent() {
    var timer = setTimeout(function() { $('#loading').show(); }, 500);
    var type = $('#usageperspective option:selected').val();
    var id = $("select[name='StationBicycleList'] option:selected").attr('value');
    
    var fromtimeRawSplit = $("#admin_fromdatepicker").val().split('/');
    var fromtime = Date.parse(fromtimeRawSplit[1] + '/' + fromtimeRawSplit[0] + '/' + fromtimeRawSplit[2]) / 1000;
    
    var totimeRawSplit = $("#admin_todatepicker").val().split('/');
    var totime = Date.parse(totimeRawSplit[1] + '/' + totimeRawSplit[0] + '/' + totimeRawSplit[2]) / 1000;
    
    $('#usagecontent').load('/ajax/get'+capitaliseFirstLetter(type)+'UsageContent/'+encodeURIComponent(id)+'/'+fromtime+'/'+totime, 
                            function(response, status, xhr) {
                                clearTimeout(timer);
                                //alert(status);
                                $('#loading').hide(); 
                                if (type == "Station") {
                                    AmCharts.handleLoad();
                                } else if (type == "Traffic"){

                                }
                            });
    
    
}

function capitaliseFirstLetter(string)
{
    return string.charAt(0).toUpperCase() + string.slice(1);
}
