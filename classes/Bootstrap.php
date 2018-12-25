<?php
class Bootstrap 
{
	private $comanda;
	private $crud;
	private $entity;
	private $id;
	private $request;
	

	public function __construct($request) {
		$this->request = $request;
		if(empty($this->request['comanda'])){
			$this->comanda = 'Viewer';
		} else {
			$this->comanda = $this->request['comanda'];
		}
		
		if(empty($this->request['CRUD'])){
			$this->request['CRUD'] = 'ShowAll';
		} else {
			$this->crud = $this->request['CRUD'];
		}
		
		if(empty($this->request['entity'])){
			$this->request['entity'] = 'Show';
		} else {
			$this->entity = $this->request['entity'];
		}
		
		if(!empty($this->request['id'])) {
			$this->id = $this->request['id'];
		} 
	}
	
	public function createController() {
		//сінглтон на конторлер
		$controller = ControllerCreator::getInstance($this->comanda);
		
		// var_dump($controller);
		//передаєм в сінглтон параметри 
		if(!is_null($controller)) {
			foreach($this->request as $prop => $value) {
				$controller->setProperty($prop, $value);
			}
		
		//додаєм 1 параметр яки не заданий за замовченням 
		//в рядку адреси
			$controller->setProperty('comanda', $this->comanda);
		
			return $controller;
		}
		header("Location: index.php");
		return;
	}
	
}
?>