<?php
class ToboMapper extends AbstractDataMapper implements IToboMapper
{

    protected $entityTable = "Tobo";

    public function __construct(IDataBaseAdapter $adapter) {
        parent::__construct($adapter);
    }

    public function insert(ITobo $tobo) 
	{
        $tobo->id = $this->adapter->insert(
            $this->entityTable,
            array(
                "tobo"     => $tobo->getTobo(),
                "toboName" => $tobo->getName(),
            )
        );

        return $tobo->id;
    }
	
	public function update(ITobo $tobo) 
	{
		// print_r($tobo->getToboCode());
		//Повертає кількість змінених рядків в БД
		return $this->adapter->update(
			$this->entityTable, 
			array(
				"Tobo" 		=> $tobo->getTobo(),
				"ToboName" 	=> $tobo->getName(),
			),
			"Tobo = " . $tobo->getTobo()
		);
	}
	
	public function findById($id) {
		// print_r($id);
		$this->adapter->select(
			$this->entityTable,
			array("tobo" => $id[0])
		);
		
		if (!$row = $this->adapter->fetch()) 
		{
			echo "<pre>Значення: subObjId  = ";
			print_r($id);
			echo "<br>відсутні в таблиці {$this->entityTable}</pre>";
			return null;
		}
		return $this->createEntity($row);
	}
	
	

    public function delete($id) {
        if ($id instanceof ITobo) {
            $id = $id->id;
        }

        return $this->adapter->delete(
			$this->entityTable, 
			"tobo = {$id}"
		);
        
    }

    protected function createEntity(array $row) 
	{
		
        return Tobo::fromState(
			array(
				"tobo" 	=> $row["tobo"], 
				"name" 	=> $row["toboName"], 
			)
		);
    }
}

?>