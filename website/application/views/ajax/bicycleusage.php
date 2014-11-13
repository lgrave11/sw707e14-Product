<div id="graph" style="display: inline-block;"></div>
<div style="float: right; width: 365px; text-align: left; font-size:12px;">
    <h2 id="stationName"></h2>
    <table id="stationData" style="border-spacing:0px; line-height:20px; margin-right:5px;">
    </table>
</div>
<script>

var width = 520,
    height = 520,
    outerRadius = Math.min(width, height) / 2 - 10,
    innerRadius = outerRadius - 24;

var formatPercent = function(val) { return Math.round(val); };//d3.format(".1%");

var arc = d3.svg.arc()
    .innerRadius(innerRadius)
    .outerRadius(outerRadius);

var layout = d3.layout.chord()
    .padding(.04)
    .sortSubgroups(d3.descending)
    .sortChords(d3.ascending);

var path = d3.svg.chord()
    .radius(innerRadius);
    
var data = [];

var svg = d3.select("#graph").append("svg")
    .attr("width", width)
    .attr("height", height)
  .append("g")
    .attr("id", "circle")
    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

svg.append("circle")
    .attr("r", outerRadius);

d3.csv("/ajax/usagegraphnames/", function(cities) {
  d3.json("/ajax/usagegraph/<?php echo $fromtime; ?>/<?php echo $totime; ?>", function(matrix) {

    // Compute the chord layout.
    layout.matrix(matrix);

    // Add a group per neighborhood.
    var group = svg.selectAll(".group")
        .data(layout.groups)
      .enter().append("g")
        .attr("class", "group")
        .on("mouseover", mouseover)
        .on("click", stationClick);

    // Add a mouseover title.
    group.append("title").text(function(d, i) {
      return cities[i].name + ": " + formatPercent(d.value) + " bicycles left this station";

    });

    // Add the group arc.
    var groupPath = group.append("path")
        .attr("id", function(d, i) { return "group" + i; })
        .attr("d", arc)
        .style("fill", function(d, i) { return cities[i].color; });

    // Add a text label.
    var groupText = group.append("text")
        .attr("x", 6)
        .attr("dy", 15);

    //groupText.append("textPath")
    //    .attr("xlink:href", function(d, i) { return "#group" + i; })
    //    .text(function(d, i) { return cities[i].name; });

    // Remove the labels that don't fit. :(
    groupText.filter(function(d, i) { return groupPath[0][i].getTotalLength() / 2 - 16 < this.getComputedTextLength(); })
        .remove();

    // Add the chords.
    var chord = svg.selectAll(".chord")
        .data(layout.chords)
      .enter().append("path")
        .attr("class", "chord")
        .style("fill", function(d) { return cities[d.source.index].color; })
        .attr("d", path);

    // Add an elaborate mouseover title for each chord.
    chord.append("title").text(function(d) {
      data.push(d);
      return cities[d.source.index].name
          + " → " + cities[d.target.index].name
          + ": " + formatPercent(d.source.value)
          + "\n" + cities[d.target.index].name
          + " → " + cities[d.source.index].name
          + ": " + formatPercent(d.target.value);
    });
    

    function mouseover(d, i) {
      chord.classed("fade", function(p) {
        return p.source.index != i
            && p.target.index != i;
      });
    }
    
    function stationClick(d, i) {
        $("#stationName").html(cities[i].name);
        $("#stationData").empty();
        data.forEach(function(entry) {
            if (entry.target.index == i) {
                $("#stationData").append("<tr style=\"margin-bottom: 10px;\"><td style=\"width:330px;  border-bottom: 1px dotted gray;\">"+cities[entry.source.index].name
                      + " → " + cities[entry.target.index].name
                      + "</td> <td style=\"border-bottom: 1px dotted gray;\"><b>" + formatPercent(entry.source.value)
                      +"</b></td></tr>");
            }
            if (entry.source.index == i) {
                $("#stationData").append("<tr style=\"margin-bottom: 10px;\"><td style=\"width:330px;  border-bottom: 1px dotted gray;\">"
                      + cities[entry.target.index].name
                      + " → " + cities[entry.source.index].name
                      + "</td> <td style=\"border-bottom: 1px dotted gray;\"><b>" + formatPercent(entry.target.value)+"</b></td></li>");
            }
        });
        
        $("#stationData").append("<tr style=\"margin-bottom: 10px;\"><td>&nbsp;</td><td>&nbsp;</td></tr>");
        
        data.forEach(function(entry) {
            if (entry.target.index == i) {
                $("#stationData").append("<tr style=\"margin-bottom: 10px; border-bottom: 1px solid gray;\"><td style=\"width:330px;  border-bottom: 1px dotted gray;\">"
                      + cities[entry.target.index].name
                      + " → " + cities[entry.source.index].name
                      + "</td> <td style=\"border-bottom: 1px dotted gray;\"><b>" + formatPercent(entry.target.value) + "</b></td></tr>");
            }
            if (entry.source.index == i) {
                $("#stationData").append("<tr style=\"margin-bottom: 10px; border-bottom: 1px solid gray;\"><td style=\"width:330px;  border-bottom: 1px dotted gray;\">"
                      +cities[entry.source.index].name
                      + " → " + cities[entry.target.index].name
                      + "</td> <td style=\"border-bottom: 1px dotted gray;\"> <b>" + formatPercent(entry.source.value)+"</b></td></tr>");
            }
        });
        
        
    }
  });
});

</script>
