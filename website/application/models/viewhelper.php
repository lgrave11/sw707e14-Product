<?php

class ViewHelper
{

	public static function printError($name)
	{
		if(isset($_SESSION[$name.'_error']))
		{
			for($i = 0; $i < count($_SESSION[$name.'_error']);$i++)
			{
				echo '<div class="error">'.$_SESSION[$name.'_error'][$i].'</div>';
			}
			unset($_SESSION[$name.'_error']);
		}
	}

	public static function printSuccess($name)
	{
		if(isset($_SESSION[$name.'_success']))
		{
			for($i = 0; $i < count($_SESSION[$name.'_success']);$i++)
			{
				echo '<div class="success">'.$_SESSION[$name.'_success'][$i].'</div>';
			}
			unset($_SESSION[$name.'_success']);
		}
	}
	
	public static function printMessages($name) {
	    ViewHelper::printError($name);
	    ViewHelper::printSuccess($name);
	}

	public static function printHour(){
		$currentTime = time();
		if (date("i") >= 55)
		{
			$hour = date("H", ($currentTime + 3600));
		} else {
			$hour = date("H");
		}
		return $hour;
	}

	public static function printMinute(){
		if (date("i") >= 55)
		{
			$minute = "00";
		} else {
			$minute = 5 * round(date("i") / 5);
		}
		return str_pad($minute, 2, 0, STR_PAD_LEFT);
	}
}

?>
