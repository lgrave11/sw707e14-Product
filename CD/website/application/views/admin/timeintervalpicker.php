<?php
		if (Tools::isLoggedIn()){
			?>
	<h2>From Time:</h2>
    
	Date: <input id="admin_fromdatepicker" type="text" readonly name="fromdate" value="<?php echo ViewHelper::getDateTime(); ?>" style="width: 100px; text-align: center;" />
	<h2>To Time:</h2>
	Date: <input id="admin_todatepicker" type="text" readonly name="todate" value="<?php echo ViewHelper::getDateTime(); ?>" style="width: 100px; text-align: center;" />
	
	<?php
		}
	?>