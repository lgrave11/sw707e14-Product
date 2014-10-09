<?php

class ViewHelper
{

	public static function printError($name)
	{
		if(isset($_SESSION[$name.'_error']))
		{
			for($i = 0; $i < count($_SESSION[$name.'_error']);$i++)
			{
				echo '<div class="error">'.$_SESSION[$name.'_error'][$i].'</div><br />';
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
				echo '<div class="success">'.$_SESSION[$name.'_success'][$i].'</div><br />';
			}
			unset($_SESSION[$name.'_success']);
		}
	}
	
	public static function printMessages($name) {
	    ViewHelper::printError($name);
	    ViewHelper::printSuccess($name);
	}
}

?>
