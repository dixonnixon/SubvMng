<?php
class ClientData
{
	public function insert($entity, $method, $data = array()) {

		$Finder = new InsertEntity();
		
		$Finder->setEntity($entity);
		$Finder->setMethod($method);
		
		$context = new Context($Finder);
		return $context->algorithm($data);
	}
	
	
	
	public function select($entity, $method, $data = array()) {
		$Finder = new FindEntity();
		// echo $entity;
		// echo "tt";
		$Finder->setEntity($entity);
		$Finder->setMethod($method);
		
		$context = new Context($Finder);
		return $context->algorithm($data);
	}
	
	
	
	public function update($entity, $method, $data = array()) {
		$Finder = new UpdateEntity();
		
		$Finder->setEntity($entity);
		$Finder->setMethod($method);
		
		$context = new Context($Finder);
		return $context->algorithm($data);
	}
	
	public function delete($entity, $method, $data = array()) {
		$Finder = new DeleteEntity();
		
		$Finder->setEntity($entity);
		$Finder->setMethod($method);
		
		$context = new Context($Finder);
		return $context->algorithm($data);
	}
}
?>