<?php
class SubObjMapper extends AbstractDataMapper implements ISubObjMapper
{
    protected $toboMapper;
    protected $budgetMapper;
    protected $entityTable = "SubObjs";
    protected $entityPerm = "objPerms";

    // public function __construct(DatabaseAdapterInterface $adapter,
    //     CommentMapperInterface $commenMapper) {
    //     $this->commentMapper = $commenMapper;
    //     parent::__construct($adapter);
    // }
	
    public function __construct(IDataBaseAdapter $adapter,
	IToboMapper $toboMapper, IBudgetMapper $budgetMapper) {
		$this->toboMapper 	= $toboMapper;
		$this->budgetMapper = $budgetMapper;
        parent::__construct($adapter);
    }

    public function insert(ISubObj $subObj) 
	{
        $subObj->id = $this->adapter->insert(
            $this->entityTable,
            array(
                "name"  => $subObj->getName	(),
                "budgCode" => $subObj->getBudget()->getCode(),
                "year"     => $subObj->getYear	(),
                "sum"      => $subObj->getSum	(),
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
	
	private function selectPerm($id) {
		$this->adapter->selectSimple(
			$this->entityPerm,
			array("subObjId"),
			array(
				":subObjId" => $id
			)
		);
		if (!$rows = $this->adapter->fetchAll(PDO::FETCH_COLUMN, 0)) 
			return array();
		return $rows;
	}
	
	public function findAllByYear($req) {
		// print_r($req);
		$this->adapter->selectSimple(
			$this->entityTable,
			array("budgCode"),
			array(
				":budgCode" => $req["budgCode"]
			)
		);
		
		if (!$rows = $this->adapter->fetchAll()) 
			return new NullSubObj;
		
		
		// fetch entity objects
		
		if ($rows) {
			foreach ($rows as $row) {
				// print_r($row);
				// echo "<br>";
				$entities[] = $this->createEntity($row);
			}
		}
		
		//check permssions of objects by Tobo
		$this->adapter->select(
			$this->entityPerm,
			array("tobo" => $row["tobo"])
		);
		
		$perm = $this->adapter->fetchAll(PDO::FETCH_COLUMN, 0);

		if($perm) {
			foreach($perm as $subObjId) {
				$this->adapter->selectSimple(
					$this->entityTable,
					array("subObjId"),
					array(
						":subObjId" => $subObjId
					)
				);
				$permObjs = $this->adapter->fetchAll();
				$entities[] = $this->createEntity($permObjs[0]);
			}
		}
		return $entities;
		
	}
	
	public function insertPerm(ISubObj $subObj, $tobo) {
		if($subObj instanceof NullSubObj) 
		{
			echo "<pre>";
			echo "Спроба надати дозвіл на неіснуючий об`єкт";
			echo "</pre>";
			return;
		}
		
		$params = array(
			"subObjId"	=> $subObj->getId(),
			"tobo"		=> $tobo
		);
		
		if(is_array($tobo)) {
			return $this->adapter->insertManyToOne(
				$this->entityPerm,
				$params
			);
		}
		
		return $this->adapter->insert(
				$this->entityPerm,
				$params
			);
		
	}
	
	public function update(ISubObj $object) {
		//тимчасове рішення з Objects_vw_insert для вставки 
		//даних
		 // echo "<pre>";
		// print_r($object);
		
		return $this->adapter->update(
			$this->entityTable, 
			array(
				// "BudgetCode" => $budget->getBudgetCode(),
				"name" => $object->getName(),
				"sum" => $object->getSum(),
			),
			"budgCode = " . $object->getBudget()->getCode()
			. " AND subObjId = " . $object->getId()

			
		);
	}
	
	//function is to delete spec view permissions
	public function deletePerm(ISubObj $subObj, $tobo) {
		if($subObj instanceof NullSubObj) 
		{
			echo "<pre>";
			echo "Спроба видалити дозвіл на неіснуючий об`єкт";
			echo "</pre>";
			return;
		}
		// print_r($subObj->id);
		
		if(is_array($tobo)) {
			
			//filter value except tobo=1800
			// $tobo = array_filter($tobo, function($k) {
				// return $k !== '1800';
			// });
			
			$toboStr = "";
			foreach($tobo as $key => $value) {
				$toboT[]=  "tobo = {$value}";
			}
			
			$toboStr = implode(" OR ", $toboT);
			return $this->adapter->deleteManyFromOne(
				$this->entityPerm,
				$toboStr
			);
		}
		
		// if($tobo == '1800') {return 0;}
			
		return $this->adapter->delete(
			$this->entityPerm, 
			"subObjId = {$subObj->id} AND tobo = {$tobo}"
		);	
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
		$perm = array();
		// print_r($row);
		
		$budget = $this->budgetMapper->findById(array($row["budgCode"]));
		
		$tobo = ControllerCreator::getTobo();
		// $objTobo = $budget->getTobo()->getTobo();
		// print_r($objTobo);
		// print_r($row);
		
		//заповнюємо рядок дозволів
		if($tobo == "1800" ) {
			foreach($this->selectPerm($row["subObjId"]) as $tb) {
				$perm[$tb] = 1;
			}
		}
		
		
		
		
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
		$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			return array(
				"id" 	=> $row["subObjId"], 
				"name" 	=> $row["name"], 
				"budg"	=> $budget->getCode(),
				"perm"	=> $perm,
				"year"	=> $row["year"],
				"sum"	=> $row["sum"]
			);
		}
			
        return SubObj::fromState(
			array(
				"id" 	=> $row["subObjId"], 
				"name" 	=> $row["name"], 
				"budg"	=> $budget,
				"perm"	=> $perm,
				"year"	=> $row["year"],
				"sum"	=> $row["sum"]
			)
		);
    }
}

?>