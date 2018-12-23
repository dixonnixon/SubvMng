<?php
class ComesMapper extends AbstractDataMapper implements IComesMapper
{
	
    public function __construct(IDataBaseAdapter $adapter) {
		
        parent::__construct($adapter);
    }

    // public function insert(ICome $outc) 
	// {
        // $subObj->id = $this->adapter->insert(
            // $this->entityTable,
            // array(
                // "objName"    => $outc->getName(),
                // "tobo"    	 => $outc->getTobo()->getTobo(),
                // "budgCode"   => $outc->getBudget(),
                // "date"       => $outc->getDateObj()
            // )
        // );
		
		// $perm = $subObj->getPerm();
		// //add inserting permissions
		// if(!empty($perm) && isset($perm)) {
			// $this->insertPerm($subObj, $perm);
		// }

        // return $subObj->id;
    // }
	
	public function findById($id) {
		
		$this->adapter->select(
			$this->entityTable,
			array("id" => $id[0])
		);
		
		if (!$row = $this->adapter->fetch()) 
		{
			echo "<pre>Значення: outId  = ";
			print_r($id);
			echo "<br>відсутні в таблиці {$this->entityTable}</pre>";
			return new NullSubObj;
		}
		return $this->createEntity($row);
	}
	
	public function ProcCUD(array $conditions = array()) {
		// print_r($this->entityTable);
		$entities = array();
		return $this->adapter->Proc($this->procNm, $conditions);
	}
	
	public function ProcSelect(array $conditions = array()) {
		return parent::Proc($conditions);
	}
	
	public function ProcSelectSingle(array $conditions = array()) {
		return parent::Proc($conditions);
	}
	
	
	
	// public function findAllByMonthOut($req) {
		// $this->entityTable = "Outcomes";
		// $cols = array_keys($req);
		// $this->adapter->selectSimple(
			// $this->entityTable,
			// $cols,
			// array(
				// ":incId" => $req["incId"],
				// ":date"  => $req["MONTH(date)"]
			// )
		// );
		

		// if (!$rows = $this->adapter->fetchAll()) 
			// return;
		
		
		// // fetch entity objects
		
		// if ($rows) {
			// foreach ($rows as $row) {
				// // print_r($row);
				// // echo "<br>";
				// $entities[] = $this->createEntity($row);
			// }
		// }
		// return $entities;
	// }
	
	// public function findAllByMonthFact($req) {
		// $this->entityTable = "FactIncomes";
		// $cols = array_keys($req);
		// $this->adapter->selectSimple(
			// $this->entityTable,
			// $cols,
			// array(
				// ":incId" => $req["incId"],
				// ":date"  => $req["MONTH(date)"]
			// )
		// );
		

		// if (!$rows = $this->adapter->fetchAll()) 
			// return;
		
		
		// // fetch entity objects
		
		// if ($rows) {
			// foreach ($rows as $row) {
				// // print_r($row);
				// // echo "<br>";
				// $entities[] = $this->createEntity($row);
			// }
		// }
		// return $entities;
	// }
	
	// public function findAllByMonthProv($req) {
		// $this->entityTable = "ProvIncomes";
		// $cols = array_keys($req);
		// $this->adapter->selectSimple(
			// $this->entityTable,
			// $cols,
			// array(
				// ":incId" => $req["incId"],
				// ":date"  => $req["MONTH(date)"]
			// )
		// );
		

		// if (!$rows = $this->adapter->fetchAll()) 
			// return;
		
		
		// // fetch entity objects
		
		// if ($rows) {
			// foreach ($rows as $row) {
				// // print_r($row);
				// // echo "<br>";
				// $entities[] = $this->createEntity($row);
			// }
		// }
		// return $entities;
	// }
	
	
    public function delete($id) {
        if ($id instanceof IOutcome) {
            $id = $id->id;
        }

        return $this->adapter->delete(
			$this->entityTable, 
			"outId = {$id}"
		);
        
    }

    protected function createEntity(array $row) 
	{
		// print_r($row);
		(!isset($row["fond"])) ? $row["fond"]="" : $row["fond"];
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
		$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			return array(
				"id" 	=> $row["id"], 
				"ObjId" => $row["subObjId"], 
				"date"	=> $row["date"], 
				"sum"	=> $row["sum"]
			);
		}
			
        return Come::fromstate(
			array(
				"id" 	=> $row["id"], 
				"ObjId" => $row["subObjId"], 
				"date"	=> $row["date"], 
				"sum"	=> $row["sum"]
			)
		);
    }
}

?>