<?php
	viewHelper::printSuccess('home');
?>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script src="/public/js/googleapi.js"></script>
<div id="map-container">
	<div id="map-canvas"></div>
	<div id="mapinfo">
		<div class="centerblock">
			<h1>Book</h1>
            <div id="messages">
			<?php
	        	ViewHelper::printError('booking');
	        	ViewHelper::printSuccess('booking');
	        ?>
            </div>
			<form action="/Home/Book/" method="post">
				<h2>Station</h2>
				<input type="text" id="searchstation" name="searchstation" class="searchbox" placeholder="Search Station" oninput="SearchStation();MouseOverSearch();" onfocus="ShowSearch();MouseOverSearch();" onmouseover="ShowSearch();MouseOverSearch();" onmouseout="MouseLeaveSearch()" autocomplete="off" /><br />
				<div id="searchresult" onmouseover="MouseOverSearch()" onmouseout="MouseLeaveSearch()"></div>
				<select name="station" id="stations" style="width: 243px;" onchange="UpdateMarker()">
				<option value="0" disabled selected>- Select Station -</option>
				<?php
				foreach($stations as $station){
					echo '<option value="'.$station->station_id.'">'.$station->name.'</option>';
				}
				?>
				</select><br />
				<div id="freebicycles"></div>
				<br />
				<?php
					if (Tools::isLoggedIn()){
						?>
				<h2>Time for booking:</h2>
				Date: <input id="datepicker" type="text" readonly name="date" value="<?php echo ViewHelper::getDate(); ?>" style="width: 75px; text-align: center;" /> Time: <input id="hourpicker" type="text" readonly name="hour" value="<?php echo ViewHelper::getHour(); ?>" style="width: 25px; text-align: center;" />:<input id="minutepicker" type="text" readonly name="minute" value="<?php echo ViewHelper::getMinute(); ?>" style="width: 25px;  text-align: center;" />
				<?php
					}
				?>
				<div class="centerblock"><br />
				<?php
					if (Tools::isLoggedIn()){
						echo '<input type="submit" value="Book" class="button" />';
					} else {
						echo '<a href="/User/Login/">Login</a>';
					}
				?>
				</div>
			</form>
		</div>
        <div id="dialog-confirm"></div>
            <?php
            if(Tools::isLoggedIn())
            {
                echo '<h1 class="bookings-header centerblock">Active Bookings</h1>';
                echo '<div class="bookings centerblock">';
                foreach($activeBookings as $booking)
                {
                    echo '<h2>'.date("d-m-Y H:i", $booking[0]->start_time).'</h2>
                    <p class="active-booking">'.$booking[1].' <br>Kodeord: '.$booking[0]->password.'
                        <button class="centerblock button" onclick="fnUnbookDialog('.$booking[0]->booking_id.');" style="margin-top: 5px; margin-bottom: 5px;">Unbook</button>
                    </p>';
                }
                echo '</div>';
            }
            ?>
</div>
</div>
