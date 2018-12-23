<?php
abstract class AbstractDataMapper
{
	protected $adapter;
	protected $entityTable;
	protected $fnNm;
	protected $procNm;
	
	
	public function __construct(IDataBaseAdapter $adapter) {
		$this->adapter = $adapter;
	}
	
	public function getAdapter() {
		return $this->adapter;
	}
	
	public function setFnNm($fnNm) {
		$this->fnNm = $fnNm;
	}

	public function setProcNm($proc) {
		$this->procNm = $proc;
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
		// print_r($rows);
		
		if ($rows) {
			foreach ($rows as $row) {
				$entities[] = $this->createEntity($row);
			}
		}
		
		return $entities;
	}
	
	public function selectFn(array $conditions = array()) {
		$this->entityTable = $this->fnNm;
		// print_r($this->entityTable);
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

	public function Proc(array $conditions = array()) {
		// print_r($this->entityTable);
		$entities = array();
		$this->adapter->Proc($this->procNm, $conditions);
		$rows = $this->adapter->fetchAll();
		if ($rows) {
			foreach ($rows as $row) {
				$entities[] = $this->createEntity($row);
			}
		}
		return $entities;
	}

	public function chechIdInEntities($id) {
		$res = array();
		foreach($this->tables as $tbl) {
			
			$this->adapter->selectProc(
				'sp_checkIdInTable',
				array($tbl, $id[0])
			);
			$fetch = $this->adapter->fetchAll();
			
			if(!empty($fetch[0]))
				$res[$tbl] = $fetch[0];
		}

		return $res;
	}

	abstract protected function createEntity(array $row);
}
	
?>