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
			if ($file != '..' && $file != '.'){
				echo '<link rel="stylesheet" type="text/css" href="/public/css/'.$file.'">
';
			}
		}
	}
}
?>