<?php
interface IToboMapper
{
   public function findById($id);
   public function findAll(array $conditions = array());

   public function insert(ITobo $tobo);
   public function delete($id);
}
?>