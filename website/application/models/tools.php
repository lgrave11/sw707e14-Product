<?php
class Tools {
	public static function isLoggedIn(){
		if(isset($_SESSION['login_user'])){
			return true;
		} else {
			return false;
		}
	}

	public static function requireLogin(){
		if(!isset($_SESSION['login_user'])){
			header("Location: /");
			exit();
		}
	}

	public static function includeCSS(){
		$files = scandir('public/css');
		foreach ($files as $file){
			if (substr($file, 0, 1) != "."){
				echo '<link rel="stylesheet" type="text/css" href="/public/css/'.$file.'">';
			}
		}
	}

	public static function includeJS(){
		$files = scandir('public/js');
		echo '<script type="text/javascript" src="public/js/jquery.js"></script>
<script type="text/javascript" src="public/js/jquery.datetimepicker.js"></script>
';
		foreach ($files as $file){
			if (substr($file, 0, 1) != "." && substr($file, 0, 6) != "jquery"){
				echo '<script type="text/javascript" src="/public/js/'.$file.'"></script>';
			}
		}
	}
	
	public static function validateEmail($email) {
	    return filter_var($email, FILTER_VALIDATE_EMAIL);
	}
	
	public static function validatePhone($phone) {
	    return preg_match("[\+[0-9]{2}]?[0-9]*", $phone);
	}
	
	public static function validateUsername($username) {
	    return strlen($username) <= 50;
	}
	
	public static function validateBookingPw($password) {
	    return ctype_alpha($password) && strlen($password) <= 6;
	}
}
?>
