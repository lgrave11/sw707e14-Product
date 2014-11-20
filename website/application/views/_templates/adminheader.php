<!DOCTYPE html>
<html onclick="CloseSearch()">
<head>
<meta charset="UTF-8">
<link rel="apple-touch-icon" sizes="57x57" href="/public/images/apple-touch-icon-57x57.png">
<link rel="apple-touch-icon" sizes="114x114" href="/public/images/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="72x72" href="/public/images/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="144x144" href="/public/images/apple-touch-icon-144x144.png">
<link rel="apple-touch-icon" sizes="60x60" href="/public/images/apple-touch-icon-60x60.png">
<link rel="apple-touch-icon" sizes="120x120" href="/public/images/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="76x76" href="/public/images/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="152x152" href="/public/images/apple-touch-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/public/images/apple-touch-icon-180x180.png">
<link rel="icon" type="image/png" href="/public/images/favicon-192x192.png" sizes="192x192">
<link rel="icon" type="image/png" href="/public/images/favicon-160x160.png" sizes="160x160">
<link rel="icon" type="image/png" href="/public/images/favicon-96x96.png" sizes="96x96">
<link rel="icon" type="image/png" href="/public/images/favicon-16x16.png" sizes="16x16">
<link rel="icon" type="image/png" href="/public/images/favicon-32x32.png" sizes="32x32">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/public/images/mstile-144x144.png">

<title><?php echo $this->title; ?> · Aalborg bycyklen</title>
<?php
	Tools::includeCSS();
?>
</head>

<body>
	<div id="container">
	<div id="navbar">
		<table>
			<tr>
            <?php if($navbarChosen == "GPS Tracking") {
			echo '<td id="selectedNav">';
            } else { echo '<td>'; }
            ?>
				<a href="/Admin/">GPS Tracking</a>
			</td>
            <?php if($navbarChosen == "Usage History") {
			echo '<td id="selectedNav">';
            } else { echo '<td>'; }
            ?>
				<a href="/Admin/UsageHistory">Usage History</a>
			</td>	
            <?php if($navbarChosen == "Map Routes") {
			echo '<td id="selectedNav">';
            } else { echo '<td>'; }
            ?>
				<a href="/Admin/MapRoutes">GPS Route History</a>
			</td>
            <?php if($navbarChosen == "Booking Routes") {
			echo '<td id="selectedNav">';
            } else { echo '<td>'; }
            ?>
				<a href="/Admin/BookingRoutes">GPS Booking History</a>
			</td>
            
            <?php if($navbarChosen == "Add/Remove") {
			echo '<td id="selectedNav">';
            } else { echo '<td>'; }
            ?>
				<a href="/Admin/AddRemove">Add/Remove</a>
			</td>
            <td>
                <a href="/">Home</a>
            </td>
			</tr>
		</table>
	</div>
<div id="sitecontent">