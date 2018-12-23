<?php
class SubvMapper extends AbstractDataMapper implements ISubvMapper
{
	protected $objectMapper;
	protected $budgetMapper;
	protected $entityTable;
	
	// protected $fnNm;
	
	public function __construct(IDataBaseAdapter $adapter, IBudgetMapper $budgetMapper)
	{
		$this->budgetMapper = $budgetMapper;
		parent::__construct($adapter);
		
	}
	
	public function setFnNm($fnNm) {
		$this->fnNm = $fnNm;
	}
	
	
	protected function createEntity(array $row) 
	{
		
		
		// $budget = $this->budgetMapper->findById(array($row["budgCode"]));
		
		// $tobo = ControllerCreator::getTobo();
		// // $objTobo = $budget->getTobo()->getTobo();
		// // print_r($objTobo);
		// // print_r($row);
		
		// //заповнюємо рядок дозволів
		// if($tobo == "1800" ) {
			// foreach($this->selectPerm($row["subObjId"]) as $tb) {
				// $perm[$tb] = 1;
			// }
		// }
		
		$Budget = NULL;
		
		$bname = "";
		// echo $row["budgCode"];
		if($row["budgCode"] !== '0' ) {
			$Budget = $this->budgetMapper->findById(array($row["budgCode"]));
			$bname = $Budget->getName();
		}
		
		
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
		$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			
			return array(
				// "tobo" 		=> $row["tobo"], 
				"budgCode" 	=> $row["budgCode"], 
				"budgName" 	=> $bname, 
				"ObjName"	=> $row["ObjName"],
				"SumYear"	=> $row["SumYear"],
				"SumProv"	=> $row["SumProv"],
				"FactSum"	=> $row["FactSum"],
				"Fact"		=> $row["Fact"],
				"OutSum"	=> $row["OutSum"]
			);
		}
			
        return 
			array(
				// "tobo" 		=> $row["tobo"], 
				"budgCode" 	=> $row["budgCode"], 
				"budgName" 	=> $bname, 
				"ObjName"	=> $row["ObjName"],
				"SumYear"	=> $row["SumYear"],
				"SumProv"	=> $row["SumProv"],
				"FactSum"	=> $row["FactSum"],
				"Fact"		=> $row["Fact"],
				"OutSum"	=> $row["OutSum"]
			);
    }
}
?>