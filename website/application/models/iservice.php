<?php
interface iService {
	public function validate($object);
	public function create($object);
	public function update($object);
	public function delete($object);
}
?>