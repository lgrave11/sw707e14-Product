<div id="map-canvas"></div>
<div id="mapinfo">
	<div style="position: relative;">
		<input type="text" id="searchstation" name="searchstation" class="searchbox" placeholder="Search" oninput="SearchStation();MouseOverSearch();" onfocus="ShowSearch();MouseOverSearch();" onmouseover="ShowSearch();MouseOverSearch();" onmouseout="MouseLeaveSearch()" autocomplete="off" /><br />
		<div id="searchresult" onmouseover="MouseOverSearch()" onmouseout="MouseLeaveSearch()"></div>
	</div>
</div>