<div id="chart" style="height: 400px; width: 880px;"></div>
<div style="0 auto;"><p style="text-align: center;font-size:14px;"><b>Time</b></p></div>

<script type="text/javascript" src="/public/js/amcharts.js"></script>
<script type="text/javascript" src="/public/js/serial.js"></script>
<script type="text/javascript">
	AmCharts.ready(function() {
		var chartData = <?php echo json_encode($stationHistory); ?>;
        var chart = AmCharts.makeChart("chart", {
            "type": "serial",
            "categoryField": "time",
            "pathToImages": "http://cdn.amcharts.com/lib/3/images/", // required for grips
            "mouseWheelZoomEnabled":true,
            "borderAlpha": 0,
            "valueAxes": [{
                "axisAlpha": 0.2,
                "dashLength": 1,
                "position": "left",
                "integersOnly": true,
                "title": "Bicycles"
            }],
            "chartCursor": {
                "cursorPosition": "mouse"
            },
            "graphs": [{
                "id": "g1",
                "valueField": "num_bicycles",
                "type": "line",
                "bullet": "round",
                "balloonText": "[[category]]<br /><b><span style='font-size:14px;'>Bicycles: [[value]]</span></b>"
            }],
            "categoryAxis": {
                "labelsEnabled": false
            },
            "dataProvider": chartData
        });
	});
</script>
