<div style="border: 1px solid black;">
<div id="chart" style="height: 400px; width: 880px;"></div>
</div>

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
                "balloonText": "[[category]]<br /><b><span style='font-size:14px;'>Bicycles: [[value]]</span></b>"
            }],
            "categoryAxis": {
                "labelsEnabled": false
            },
            "dataProvider": chartData
        });
	});
</script>