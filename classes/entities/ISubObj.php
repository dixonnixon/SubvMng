<?php
interface ISubObj {
	public function setId($id);
	public function getId();
	
    public function setName($name);
    public function getName();
	
	public function setBudget(IBudget $budg);
    public function getBudget();	
}


?>