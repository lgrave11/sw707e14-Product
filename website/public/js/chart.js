var chartData2 = [{"time":1415258958,"num_bicycles":6},{"time":1415260376,"num_bicycles":7}];

var chartData;

function setJSONData(data){
    //alert(data);
    chartData = eval(data);
}

AmCharts.ready(function() {
    $.get( "/Ajax/GetStationHistory/2/", function( data ) {
        //alert(data);
        setJSONData(data);
        var chart = AmCharts.makeChart("chart", {
            "type": "serial",
            "categoryField": "time",
            "pathToImages": "http://cdn.amcharts.com/lib/3/images/", // required for grips
            "mouseWheelZoomEnabled":true,
            "valueAxes": [{
                "axisAlpha": 0.2,
                "dashLength": 1,
                "position": "left"
            }],
            "chartCursor": {
                "cursorPosition": "mouse"
            },
            "valueAxes": [{
                "title": "Bicycles"
            }],
            "graphs": [{
                "id": "g1",
                "valueField": "num_bicycles",
                "type": "line",
                "bullet": "round",
                "balloonText": "[[category]]<br /><b><span style='font-size:14px;'>value: [[value]]</span></b>"
            }],
            "categoryAxis": {
                "labelsEnabled": false
            },
            "dataProvider": chartData
        });
    });
    //alert(getJSONData());
    
});