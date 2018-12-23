<?php
class BudgetMapper extends AbstractDataMapper implements IBudgetMapper
{
    protected $toboMapper;
    protected $entityTable = "Budgets";

    // public function __construct(DatabaseAdapterInterface $adapter,
    //     CommentMapperInterface $commenMapper) {
    //     $this->commentMapper = $commenMapper;
    //     parent::__construct($adapter);
    // }

    public function __construct(IDataBaseAdapter $adapter,
	IToboMapper $toboMapper) {
		$this->toboMapper = $toboMapper;
        parent::__construct($adapter);
    }

    // public function insert(IBudget $tobo) 
	// {
        // $tobo->id = $this->adapter->insert(
            // $this->entityTable,
            // array(
                // "tobo"     => $tobo->getTobo(),
                // "toboName" => $tobo->getName(),
            // )
        // );

        // return $tobo->id;
    // }
	
	public function findById($id) {
		// print_r($id);
		$this->adapter->select(
			$this->entityTable,
			array("budgCode" => $id[0])
		);
		
		if (!$row = $this->adapter->fetch()) 
		{
			echo "<pre>Значення: budgCode  = ";
			print_r($id);
			echo "<br>відсутні в таблиці {$this->entityTable}</pre>";
			return null;
		}
		return $this->createEntity($row);
	}
	
	public function update(IBudbget $budget) {
		
	}

    // public function delete($id) {
        // if ($id instanceof ITobo) {
            // $id = $id->id;
        // }

        // return $this->adapter->delete(
			// $this->entityTable, 
			// "tobo = {$id}"
		// );
        
    // }

    protected function createEntity(array $row) 
	{
		$tobo = $this->toboMapper->findById(array($row["tobo"]));
		
		
        return Budget::fromState(
			array(
				"budgCode" 	=> $row["budgCode"], 
				"tobo" 		=> $tobo, 
				"budgName" 	=> $row["budgName"], 
			)
		);
    }
}

?>