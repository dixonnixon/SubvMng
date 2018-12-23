<?php
Class NullSubObj implements ISubObj
{
    public function setId($id) {}
    public function getId() {}

    public function setName($name) {}
    public function getName() {}
	
	public function setTobo(ITobo $tobo) {}
    public function getTobo() {}
	
	public function setBudget(IBudget $budg) {}
    public function getBudget() {}
	
	public function setDateObj($date) {}
    public function getDateObj() {}
}

?>