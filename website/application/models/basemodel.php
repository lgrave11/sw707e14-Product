<?php
class BaseClass {
	private $db = null;
	function __construct($database){
		$this->db = $database;
	}
}
?>