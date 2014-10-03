<?php
interface iService {
	private validate($object);
	public create($object);
	public update($object);
	public read($id);
	public delete($object);
}
?>