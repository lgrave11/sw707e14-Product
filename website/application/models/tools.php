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
				echo '<link rel="stylesheet" type="text/css" href="/public/css/'.$file.'">
';
			}
		}
	}

	public static function includeJS(){
		$files = scandir('public/js');
		foreach ($files as $file){
			if (substr($file, 0, 1) != "."){
				echo '<script type="text/javascript" src="public/js/'.$file.'"></script>
';
			}
		}
	}
}
?>