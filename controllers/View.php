<?php
error_reporting(E_ALL);

class View extends AbstractController
{
	public function Tobo() {
		
		$name = __FUNCTION__;
		
		switch(ControllerCreator::getTobo())
		{
			case '1800':
				$method = "FindAll";
				$params = array();
				break;
			default:
				$method = "selectFn";
				$params = array($name => ControllerCreator::getTobo());
				
		}
		
		$toboData = new Trigger(
			$name,
			'select',
			$method,
			$params
		);
		
		$hendlerPath = 
			Settings::$FORM_HENDLERS . "exportReport.php";
		
		
		
		return array(
			"vars" => array(
				"name" 	=> $name,
				"action"=> $hendlerPath
			),
			"data" => $toboData->get()
		);
	}
	
	public function Budgets() 
	{
		if(!preg_match('/^\d{4}$/', $this->props["Tobo"])) {return;}
		
		$this->setSessionVars("Tobo", ControllerCreator::getTobo());
		
		
		//complex logic here))))
		if(ControllerCreator::getTobo() == 1800) {
			$param = array("Tobo" => $this->props["Tobo"]);
			$this->setSessionVars("Tobo", $this->props["Tobo"]);
		} elseif($this->props["Tobo"] == 1800) {
			$param = array("Tobo" => 1800);
			$this->setSessionVars("Tobo", 1800);
		} else {
			$param = array("Tobo" => ControllerCreator::getTobo());
			$this->setSessionVars("Tobo", $param["Tobo"]);
		}
		
		$name = "Budget";
		
		$Budgets = new Trigger(
			$name,
			'select',
			"FindAll",
			$param
		);
		
		return array(
			"name" => $name, 
			"data" => array(
				"Budgets" 	=> $Budgets->get()
			)
		);
	}

	public function Objects()
	{
		
		(!empty($_GET["year"])) 
		? $year = $_GET["year"]
		: $year = date('Y');
		
		if(!preg_match('/^\d{4}$/', $this->props["Tobo"])) {return;}
			
		if(!empty($this->props["BudgetCode"]) && !preg_match('/^\d{10}$/', $this->props["BudgetCode"])) {return;}
		
		$method = "";
		$params = array();
		$toboPerm = array();
		
		
		//логіка доступу до об'єктів
		if(ControllerCreator::getTobo() == 1800) {
			$this->setSessionVars("Tobo", $this->props["Tobo"]);
			$this->setSessionVars("BudgetCode", $this->props["BudgetCode"]);
			$this->setSessionVars(
				"Entity", $this->props["entity"] 
			);
			$method = "FindAll";
			$params = array("budgCode" => $this->props["BudgetCode"]);
			
			$Tobo = new Trigger(
				"Tobo",
				"select",
				"FindAll",
				array()
			);

				

			foreach($Tobo->get() as $tobo)
			{	$toboPerm[$tobo->getTobo()] = 0;	}	
			// print_r($toboPerm);



		} elseif($this->props["Tobo"] == 1800) {
			$method = "selectFn";
			$this->setSessionVars(
				"Entity", ControllerCreator::getTobo()
			);
			$params = array(ControllerCreator::getTobo());
		} elseif($this->props["Tobo"] == ControllerCreator::getTobo()) {
			$method = "FindAll";
			$params = array("budgCode" => $this->props["BudgetCode"]);
		} else {
			echo "Ввели неправильний параметр";
			return;
		}
		
		$name = "SubObj";
		
		$hendlerPath = 
				Settings::$FORM_HENDLERS . "addObjectForm.php";
		
		
		
		$Budget = new Trigger(
			"Budget",
			"select",
			"FindById",
			array($this->props["BudgetCode"])
		);
		
		$Objects = new Trigger(
			$name,
			'select',
			$method,
			$params
		);
		
		// echo "<pre>";
		// print_r( $Objects->get());
		// echo "</pre>";
		
		return array(
			"vars" => array(
				"name" 		=> "Comes",
				"year" 		=> $year,
				"action"	=> $hendlerPath
			),
			"data" => array(
				// "Tobo"		=> $toboPerm,
				"Budget"  	=> $Budget->get(),
				"Objects" 	=> $Objects->get(),			
			)
		);
	}
	
	// public function Incomes()
	// {
		// (!empty($_GET["year"])) 
		// ? $year = $_GET["year"]
		// : $year = date('Y');
		
		// $name = "Inc";
		// $method = "selectFn";
		// $params = array(
			// "subObjId" => $this->props["ObjId"]
		// );
		
		// $Object = new Trigger(
			// "SubObj",
			// 'select',
			// "findById",
			// array($this->props["ObjId"])
		// );
		
		// $Incomes = new Trigger(
			// $name,
			// 'select',
			// $method,
			// $params
		// );
		
		// $hendlerPath = 
				// Settings::$FORM_HENDLERS . "addIncomeForm.php";
				
		// $remIncomes 	= array();
		// $provIncomes 	= array();
		
		// // echo "<pre>";
		// // print_r($Incomes->get());
		// // echo "</pre>";
		
		// foreach($Incomes->get() as $inc => $val) {
			// $incFond = $val->getFond();
			// if($incFond !== "") {
				// $remIncomes[] = $val;
				// continue;
			// }
			// $provIncomes[] 	=  $val;
		// }
		
		// $this->setSessionVars(
				// "ObjId", $this->props["ObjId"]
			// );
				
		// return array(
			// "vars" => array(
				// "name" 		=> "Incomes",
				// "year" 		=> $year,
				// "action"	=> $hendlerPath
			// ),
			// "data" => array(
				// "Object"  	=> $Object->get(),
				// "Rems" 		=> $remIncomes,		
				// "Provs" 	=> $provIncomes		
			// )
		// );
	// }
	
	public function ByMonths() 
	{
		$this->setSessionVars(
				"ObjId", $this->props["ObjId"]
			);
		$this->setSessionVars(
			"type", $this->props["type"]
		);
			
		
		// print_r($_SESSION["ObjId"]);
		
		$name = "ByMonth";
		
		// $cols,
		// 	array(
		// 		":incId" => $req["incId"],
		// 		":date"  => $req["MONTH(date)"]
		// 	)

		
		
		$Object = new Trigger(
			"SubObj",
			'select',
			"findById",
			array($_SESSION["ObjId"])
		);

		// $idInTbl = new Trigger(
			// $name,
			// 'select',
			// 'chechIdInEntities',
			// array($this->props["ObjId"])
		// );

		// print_r($idInTbl->get());
		// $isEmpty = $idInTbl->get();

		// if(!empty($isEmpty)) {
			$ByMonth = array();
			$method = "Proc";
		
			$params = array(
				$this->props["type"],
				$_SESSION["ObjId"]
			);

			$ByMonth = new Trigger(
				$name,
				'select',
				$method,
				$params
			);
		// }

		// print_r($ByMonth->get());
		
		return array(
		
			"vars" => array(
				"name" => "Comes",
				// "year" => $year
			),
			"data" => array(
				"OutcByMo" => $ByMonth->get(),
				// "OutcByMo" => $OutcomesByMonth,
				"Object"  	=> $Object->get()			
			)
		);
	}
	
	// public function FactByMonth() 
	// {
		// $this->setSessionVars(
				// "incId", $this->props["incId"]
			// );
		// // print_r($_SESSION["ObjId"]);
		
		// $name = "IncByMonth";
		// $method = "selectFnFact";
		// $params = array(
			// "subObjId" 	=> $_SESSION["ObjId"],
			// "year"		=> $this->props["year"]
		// );
		
		
		
		// $OutcomesByMonth = new Trigger(
			// $name,
			// 'select',
			// $method,
			// $params
		// );
		
		// $Object = new Trigger(
			// "SubObj",
			// 'select',
			// "findById",
			// array($_SESSION["ObjId"])
		// );
		
		// return array(
		
			// "vars" => array(
				// "name" => "Comes",
				// // "year" => $year
			// ),
			// "data" => array(
				// "OutcByMo" => $OutcomesByMonth->get(),
				// "Object"  	=> $Object->get()			
			// )
		// );
	// }
	
	// public function ProvidedByMonth() 
	// {
		// $this->setSessionVars(
				// "incId", $this->props["incId"]
			// );
		// // print_r($_SESSION["ObjId"]);
		
		// $name = "IncByMonth";
		// $method = "selectFnProv";
		// $params = array(
			// "subObjId" 	=> $_SESSION["ObjId"],
			// "year"		=> $this->props["year"]
		// );
		
		
		
		// $OutcomesByMonth = new Trigger(
			// $name,
			// 'select',
			// $method,
			// $params
		// );
		
		// $Object = new Trigger(
			// "SubObj",
			// 'select',
			// "findById",
			// array($_SESSION["ObjId"])
		// );
		
		// return array(
		
			// "vars" => array(
				// "name" => "Comes",
				// // "year" => $year
			// ),
			// "data" => array(
				// "OutcByMo" => $OutcomesByMonth->get(),
				// "Object"  	=> $Object->get()			
			// )
		// );
	// }
	
	public function Comes() 
	{
		$name = __FUNCTION__;
		
		$this->setSessionVars(
			"Entity", $this->props["entity"] 
		);
		
		// $this->setSessionVars(
			// "month", $this->props["month"] 
		// );
		
		$this->setSessionVars(
			"type", $this->props["type"]
		);
		
		//print_r($_SESSION["type"]);
		
		$comes = new Trigger(
			$name,
			'select',
			"ProcSelect",
			array(
				'\'' . $_SESSION["type"] . '\'',
				(int) $this->props["ObjId"]
			)
		);
		
		$this->setSessionVars(
			"ObjId", $this->props["ObjId"]
		);
		
		$hendlerPath = 
			Settings::$FORM_HENDLERS . "addComesForm.php";		
						
		$Object = new Trigger(
			"SubObj",
			'select',
			"findById",
			array($_SESSION["ObjId"])
		);
				
		return array(
		
			"vars" => array(
				"name" => "Come",
				"action"	=> $hendlerPath
				// "year" => $year
			),
			"data" => array(
				"Comes" 	=> $comes->get(),
				"Object"  	=> $Object->get()			
			)
		);
	}
}

?>