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
			<?php if ($navbarChosen == "Overview"){
			echo '<td id="selectedNav">';
            } else { echo '<td>'; } ?>
				<a href="/">Overview</a>
			</td>
			<?php if ($navbarChosen == "Profile"){
			echo '<td id="selectedNav">';
            } else { echo '<td>'; } ?>
				<?php
					if(isset($_SESSION['login_user']))
					{
						echo "<a href=\"/User/EditProfile\">Profile</a>";
						
					}
					else
					{
						echo "<a href=\"/User/Login/?target=/User/EditProfile\">Profile</a>";
					}
				?>
			</td>			
			<?php if ($navbarChosen == "About"){
			echo '<td id="selectedNav">';
            } else { echo '<td>'; } ?>
				<a href="/About/">About</a>
			</td>
            <?php if ($navbarChosen == "Login"){
			echo '<td id="selectedNav">';
            } else { echo '<td>'; } ?>
				<?php
					if(isset($_SESSION['login_user']))
					{
						echo "<a href=\"/User/Logout\">Logout</a>";
						
					}
					else
					{
						echo "<a href=\"/User/Login\">Login</a>";
					}
				?>
				</td>
			</tr>
		</table>
	</div>