<?php
class ByMonthMapper extends AbstractDataMapper implements IIncMapper
{
	
	protected $tables = array("ProvIncomes", "FactIncomes", "Outcomes");
	
	
      public function __construct(IDataBaseAdapter $adapter) {
        parent::__construct($adapter);
	}
	
	public function insert(ISubObj $subObj) 
	{
        $subObj->id = $this->adapter->insert(
            $this->entityTable,
            array(
                "objName"    => $subObj->getName	(),
                "tobo"    	 => 
					$subObj->getTobo()->getTobo(),
                "budgCode"   => $subObj->getBudget	(),
                "dateSub"    => $subObj->getDateObj	()
            )
        );
		
		$perm = $subObj->getPerm();
		//add inserting permissions
		if(!empty($perm) && isset($perm)) {
			$this->insertPerm($subObj, $perm);
		}

        return $subObj->id;
    }
	
	public function findById($id) {
		
		$this->adapter->select(
			$this->entityTable,
			array("subObjId" => $id[0])
		);
		
		if (!$row = $this->adapter->fetch()) 
		{
			echo "<pre>Значення: subObjId  = ";
			print_r($id);
			echo "<br>відсутні в таблиці {$this->entityTable}</pre>";
			return new NullSubObj;
		}
		return $this->createEntity($row);
	}
	
	public function selectFn(array $conditions = array()) {
		$this->entityTable = $this->fnNm;
		// print_r($this->entityTable);
		$entities = array();
		$this->adapter->selectFn($this->entityTable, $conditions);
		$rows = $this->adapter->fetchAll();
		if ($rows) {
			
			foreach ($rows as $row) {
				// print_r($row);
				$entities[] = $this->createEntity($row);
			}
		}
		
		
		return $entities;
	}
	
	// public function selectFnFact(array $conditions = array()) {
		// $this->entityTable = "fn_groupMonthF";
		// // print_r($this->entityTable);
		// $entities = array();
		// $this->adapter->selectFn($this->entityTable, $conditions);
		// $rows = $this->adapter->fetchAll();
		// if ($rows) {
			
			// foreach ($rows as $row) {
				// // print_r($row);
				// $entities[] = $this->createEntity($row);
			// }
		// }
		
		
		// return $entities;
	// }
	
	// public function selectFnProv(array $conditions = array()) {
		// $this->entityTable = "fn_groupMonthP";
		// // print_r($this->entityTable);
		// $entities = array();
		// $this->adapter->selectFn($this->entityTable, $conditions);
		// $rows = $this->adapter->fetchAll();
		// if ($rows) {
			
			// foreach ($rows as $row) {
				// // print_r($row);
				// $entities[] = $this->createEntity($row);
			// }
		// }
		
		
		// return $entities;
	// }

    public function delete($id) {
        if ($id instanceof ISubObj) {
            $id = $id->id;
        }

        return $this->adapter->delete(
			$this->entityTable, 
			"subObjId = {$id}"
		);
        
    }

    protected function createEntity(array $row) 
	{
		// print_r($row);
		// (!isset($row["fond"])) ? $row["fond"]="" : $row["fond"];
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
		$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			return array(
				"id" 	=> $row["subObjId"], 
				"month"	=> $row["month"], 
				"sum"	=> $row["sum"], 
			);
		}
			
        return ByMonth::fromstate(
			array(
				"id" 	=> $_SESSION["subObjId"], 
				"month"	=> $row["month"], 
				"sum"	=> $row["sum"]
			)
		);
    }
}

?>