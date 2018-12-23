<?php
interface IComesMapper
{
   public function findById($id);
   public function findAll(array $conditions = array());

   // public function insert(ICome $outc);
   public function delete($id);
}
?>