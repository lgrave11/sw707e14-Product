<?php
class Tools {
	public static function isLoggedIn(){
		if(isset($_SESSION['login_user'])){
			return true;
		} else {
			return false;
		}
	}

	public static requireLogin(){
		if(!isset($_SESSION['login_user'])){
			header("Location: /");
			exit();
		}
	}
}
?>