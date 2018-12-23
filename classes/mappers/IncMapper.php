<?php
class IncMapper extends AbstractDataMapper implements IIncMapper
{
    protected $entityRems = "YearRems";
    protected $entityProvs = "YearProvs";
	private $objMapper;
	
    public function __construct(IDataBaseAdapter $adapter,
	ISubObjMapper $objMapper) {
		$this->objMapper 	= $objMapper;
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
	
	// public function findAllByYear($req) {
		// // print_r($req);
		// $this->adapter->selectSimple(
			// $this->entityTable,
			// array("budgCode"),
			// array(
				// ":budgCode" => $req["budgCode"]
			// )
		// );
		
		// if (!$rows = $this->adapter->fetchAll()) 
			// return new NullSubObj;
		
		
		// // fetch entity objects
		
		// if ($rows) {
			// foreach ($rows as $row) {
				// // print_r($row);
				// // echo "<br>";
				// $entities[] = $this->createEntity($row);
			// }
		// }
		
		// //check permssions of objects by Tobo
		// $this->adapter->select(
			// $this->entityPerm,
			// array("tobo" => $row["tobo"])
		// );
		
		// $perm = $this->adapter->fetchAll(PDO::FETCH_COLUMN, 0);

		// if($perm) {
			// foreach($perm as $subObjId) {
				// $this->adapter->selectSimple(
					// $this->entityTable,
					// array("subObjId"),
					// array(
						// ":subObjId" => $subObjId
					// )
				// );
				// $permObjs = $this->adapter->fetchAll();
				// $entities[] = $this->createEntity($permObjs[0]);
			// }
		// }
		// return $entities;
		
	// }
	
	// public function insertPerm(ISubObj $subObj, $tobo) {
		// if($subObj instanceof NullSubObj) 
		// {
			// echo "<pre>";
			// echo "Спроба надати дозвіл на неіснуючий об`єкт";
			// echo "</pre>";
			// return;
		// }
		
		// $params = array(
			// "subObjId"	=> $subObj->getId(),
			// "tobo"		=> $tobo
		// );
		
		// if(is_array($tobo)) {
			// return $this->adapter->insertManyToOne(
				// $this->entityPerm,
				// $params
			// );
		// }
		
		// return $this->adapter->insert(
				// $this->entityPerm,
				// $params
			// );
		
	// }
	
	//function is to delete spec view permissions
	// public function deletePerm(ISubObj $subObj, $tobo) {
		// if($subObj instanceof NullSubObj) 
		// {
			// echo "<pre>";
			// echo "Спроба видалити дозвіл на неіснуючий об`єкт";
			// echo "</pre>";
			// return;
		// }
		// // print_r($subObj->id);
		
		// if(is_array($tobo)) {
			
			// //filter value except tobo=1800
			// // $tobo = array_filter($tobo, function($k) {
				// // return $k !== '1800';
			// // });
			
			// $toboStr = "";
			// foreach($tobo as $key => $value) {
				// $toboT[]=  "tobo = {$value}";
			// }
			
			// $toboStr = implode(" OR ", $toboT);
			// return $this->adapter->deleteManyFromOne(
				// $this->entityPerm,
				// $toboStr
			// );
		// }
		
		// // if($tobo == '1800') {return 0;}
			
		// return $this->adapter->delete(
			// $this->entityPerm, 
			// "subObjId = {$subObj->id} AND tobo = {$tobo}"
		// );	
	// }public function deletePerm(ISubObj $subObj, $tobo) {
		// if($subObj instanceof NullSubObj) 
		// {
			// echo "<pre>";
			// echo "Спроба видалити дозвіл на неіснуючий об`єкт";
			// echo "</pre>";
			// return;
		// }
		// // print_r($subObj->id);
		
		// if(is_array($tobo)) {
			
			// //filter value except tobo=1800
			// // $tobo = array_filter($tobo, function($k) {
				// // return $k !== '1800';
			// // });
			
			// $toboStr = "";
			// foreach($tobo as $key => $value) {
				// $toboT[]=  "tobo = {$value}";
			// }
			
			// $toboStr = implode(" OR ", $toboT);
			// return $this->adapter->deleteManyFromOne(
				// $this->entityPerm,
				// $toboStr
			// );
		// }
		
		// // if($tobo == '1800') {return 0;}
			
		// return $this->adapter->delete(
			// $this->entityPerm, 
			// "subObjId = {$subObj->id} AND tobo = {$tobo}"
		// );	
	// }
	
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
		
		
		//)))
		$this->entityTable = "fn_ProvsByObj";
		$this->adapter->selectFn($this->entityTable, $conditions);
		$rows = $this->adapter->fetchAll();
		if ($rows) {
			foreach ($rows as $row) {
				$entities[] = $this->createEntity($row);
			}
		}
		
		return $entities;
	}

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
		(!isset($row["fond"])) ? $row["fond"]="" : $row["fond"];
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
		$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			return array(
				"id" 	=> $row["subObjId"], 
				"inc" 	=> $row["incId"], 
				"date"	=> $row["date"], 
				"sum"	=> $row["sum"], 
				"fond"	=> $row["fond"], 
			);
		}
			
        return Income::fromstate(
			array(
				"id" 	=> $row["subObjId"], 
				"inc" 	=> $row["incId"], 
				"date"	=> $row["date"], 
				"sum"	=> $row["sum"], 
				"fond"	=> $row["fond"], 
			)
		);
    }
}

?>