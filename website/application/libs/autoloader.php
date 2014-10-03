<?php
function classAutoloader($class) {
    include 'application/models/' . strtolower($class) . '.php';
}

spl_autoload_register('classAutoloader');
?>