<?php
interface IBudget {
    public function setCode($id);
    public function getCode();
	
	public function setTobo(ITobo $tobo);
    public function getTobo();
	
	public function setName($budg);
    public function getName();
	
}

?>