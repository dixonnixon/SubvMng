<?php
interface ISubvMapper
{
	public function findById($id);
	public function findAll(array $conditions = array());

}
?>