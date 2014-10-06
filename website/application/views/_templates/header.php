<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="/public/css/style.css">
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
			<td onclick="navigateTo('home/about')">
				About
			</td>
			<td>
				Status
			</td>
			<td>
				Book
			</td>
			<td>
				Profile
			</td>
			<td>
				Login
			</td>
			</tr>
		</table>
	</div>