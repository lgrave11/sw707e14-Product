<?php

class ViewHelper
{

	public static function printError($name)
	{
		if(isset($_SESSION[$name.'_error']))
		{
			echo count($_SESSION[$name.'_error']);
			for($i = 0; $i < count($_SESSION[$name.'_error']);$i++)
			{
				echo '<div id="error">'.$_SESSION[$name.'_error'][$i].'</div><br>';
			}
			unset($_SESSION[$name.'_error']);
		}
	}

		public static function printError($name)
	{
		if(isset($_SESSION[$name.'_succes']))
		{
			echo count($_SESSION[$name.'_succes']);
			for($i = 0; $i < count($_SESSION[$name.'_succes']);$i++)
			{
				echo '<div id="success">'.$_SESSION[$name.'_succes'][$i].'</div><br>';
			}
			unset($_SESSION[$name.'_succes']);
		}
	}
}

?>