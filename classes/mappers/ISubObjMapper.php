<?php
interface ISubObjMapper
{
   public function findById($id);
   public function findAll(array $conditions = array());

   public function insert(ISubObj $subObj);
   public function delete($id);
}
?>