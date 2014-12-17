<?php
echo "name,color\n";
$id = 0;
foreach ($stations as $name){
	echo $name->name . "," . $colors[$id] . "\n";
	$id++;
}
?>