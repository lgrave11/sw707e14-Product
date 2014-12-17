<?php
function classAutoloader($class) {
	$file = 'application/models/' . strtolower($class) . '.php';
	if(is_file($file)) 
	{
		include $file;
	}
    
}

function interfaceAutoloader($className){
	$file = 'interface/' . strtolower($className) . '.php';
	if(is_file($file)) 
	{
		include $file;
	}
	
}

spl_autoload_register('classAutoloader');
spl_autoload_register('interfaceAutoloader');
?>