<?php
interface IBudgetMapper
{
   public function findById($id);
   public function findAll(array $conditions = array());

   // public function insert(IBudbget $budget);
   // public function delete($id);
   
   public function update(IBudbget $budget);
}
?>