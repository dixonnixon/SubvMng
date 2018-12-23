<?php
interface IIncMapper
{
   public function findById($id);
   public function findAll(array $conditions = array());

   public function insert(ISubObj $subObj);
   public function delete($id);
}
?>