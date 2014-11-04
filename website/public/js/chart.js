var chartData = [{
        "country": "USA",
        "visits": 4252
    }, {
        "country": "China",
        "visits": 1882
    }, {
        "country": "Japan",
        "visits": 1809
    }, {
        "country": "Germany",
        "visits": 1322
    }, {
        "country": "UK",
        "visits": 1122
    }, {
        "country": "France",
        "visits": 1114
    }, {
        "country": "India",
        "visits": 984
    }, {
        "country": "Spain",
        "visits": 711
    }, {
        "country": "Netherlands",
        "visits": 665
    }, {
        "country": "Russia",
        "visits": 580
    }, {
        "country": "South Korea",
        "visits": 443
    }, {
        "country": "Canada",
        "visits": 441
    }, {
        "country": "Brazil",
        "visits": 395
    }, {
        "country": "Italy",
        "visits": 386
    }, {
        "country": "Australia",
        "visits": 384
    }, {
        "country": "Taiwan",
        "visits": 338
    }, {
        "country": "Poland",
        "visits": 328
    }];

AmCharts.ready(function() {
    
    var chart = AmCharts.makeChart("chart", {
        "type": "serial",
        "categoryField": "country",
        "pathToImages": "http://cdn.amcharts.com/lib/3/images/", // required for grips
        "mouseWheelZoomEnabled":true,
        "valueAxes": [{
            "axisAlpha": 0.2,
            "dashLength": 1,
            "position": "left"
        }],
        "chartScrollbar": {
            "updateOnReleaseOnly": true,
            "graph": "g1",
            "scrollbarHeight": 40
        },
        "chartCursor": {
            "cursorPosition": "mouse"
        },
        "valueAxes": [{
            "title": "Bicycles"
        }],
        "graphs": [{
            "id": "g1",
            "valueField": "visits",
            "type": "line",
            "bullet": "round",
            "balloonText": "[[category]]<br /><b><span style='font-size:14px;'>value: [[value]]</span></b>"
        }],
        "dataProvider": chartData
    })
});