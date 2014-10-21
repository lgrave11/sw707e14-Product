<?php
function classAutoloader($class) {
    include 'application/models/' . strtolower($class) . '.php';
}

function interfaceAutoloader($className){
	include 'interface/' . strtolower($className) . '.php';
}

spl_autoload_register('classAutoloader');
spl_autoload_register('interfaceAutoloader');
?>