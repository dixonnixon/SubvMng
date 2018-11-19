<?php
abstract class AbstractDataMapper
{
	protected $adapter;
	protected $entityTable;
	protected $fnNm;
	
	public function __construct(IDataBaseAdapter $adapter) {
		$this->adapter = $adapter;
	}
	
	public function getAdapter() {
		return $this->adapter;
	}
	
	public function setFnNm($fnNm) {
		$this->fnNm = $fnNm;
	}
	
	public function findById($idValue) {
		
		$this->adapter->select(
			$this->entityTable,
			$idValue
		);
		
		if (!$row = $this->adapter->fetch()) {
			echo "<pre>Значення: <br>";
			print_r($idValue);
			echo "відсутні в таблиці {$this->entityTable}</pre>";
			return;
		}
		return array($this->createEntity($row));
	}
	
	public function findAll(array $conditions = array()) {
		$entities = array();
		$this->adapter->select($this->entityTable, $conditions);
		$rows = $this->adapter->fetchAll();
		if ($rows) {
			foreach ($rows as $row) {
				$entities[] = $this->createEntity($row);
			}
		}
		return $entities;
	}
	
	public function selectFn(array $conditions = array()) {
		$this->entityTable = $this->fnNm;;
		$entities = array();
		$this->adapter->selectFn($this->entityTable, $conditions);
		$rows = $this->adapter->fetchAll();
		if ($rows) {
			foreach ($rows as $row) {
				$entities[] = $this->createEntity($row);
			}
		}
		return $entities;
	}

	abstract protected function createEntity(array $row);
}
	
?>