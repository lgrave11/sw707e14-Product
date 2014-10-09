<!DOCTYPE html>
<html onclick="CloseSearch()">
<head>
<meta charset="UTF-8">
	<?php
		Tools::includeCSS();
	?>
<title>Title of the document</title>
<?php
if (isset($currentPage) && ($currentPage == "" || $currentPage == "home")){
	include("application/views/home/googleapi.php");
}
?>
</head>

<body>
	<div id="container">
	<div id="navbar">
		<table border="0" cellpadding="0" cellspacing="0">
			<tr>
			<td>
				<a href="/">Overview</a>
			</td>
			<td>
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
			<td>
				<a href="/Home/About/">About</a>
			</td>
			<td>
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