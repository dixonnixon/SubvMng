<?php

class Change extends AbstractController
{
	public function Tobo() {
		if(isset($this->props["Tobo"]) && isset($_GET["Tobo"]) && ControllerCreator::getTobo() == 1800) {
			$Tobo = new Trigger(
				__FUNCTION__,
				'select',
				"findById",
				array($_GET["Tobo"])
			);
		}
		
		$this->setSessionVars(
			"Entity", $this->props["entity"]
		);
		
		$this->setSessionVars(
			"Tobo", $this->props["Tobo"]
		);
		
		$toboData = $Tobo->get();
			// print_r($toboData);
			
		$hendlerPath = 
			Settings::$FORM_HENDLERS . "changeToboForm.php";
		return array(
			"vars" => array(
				"name" 		=> __FUNCTION__, 
				"action"	=> $hendlerPath
			),
			"data" => $toboData
		);
	}
	
	public function Object() 
	{
		if(isset($this->props["Budget"]) 
			&& !empty($this->props["ObjId"])) 
		{

			if(ControllerCreator::getTobo() == 1800) {
				// $this->setSessionVars("Tobo", $this->props["Tobo"]);
				$this->setSessionVars("Budget", $this->props["Budget"]);
				$this->setSessionVars(
					"Entity", $this->props["entity"] 
				);
				$method = "FindAll";
				$params = array("budgCode" => $this->props["Budget"]);
				
				$Tobo = new Trigger(
					"Tobo",
					"select",
					"FindAll",
					array()
				);
				foreach($Tobo->get() as $tobo)
				{	$toboPerm[$tobo->getTobo()] = 0;	}	
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
			
			$hendlerPath = 
				Settings::$FORM_HENDLERS 
				. "changeObjectForm.php";
				
			$Object = new Trigger(
				"SubObj",
				'select',
				"findById",
				array($this->props["ObjId"])
			);
			
			$objectData = $Object->get();
			// print_r($objectData);
			
			$this->setSessionVars(
				"Entity", __FUNCTION__ . "s"
			);
			
			$this->setSessionVars(
				"BudgetCode", $objectData->getBudget()->getCode()
				);
				
			$this->setSessionVars(
				"ObjId", $objectData->getId()
			);
			// echo "<pre>";
			// print_r($objectData);
			// print_r($objectData->getBudget()->getTobo()->getTobo());
			// echo "</pre>";


			return array(
				"vars" => array(
					"name" 		=> __FUNCTION__, 
					"action"	=> $hendlerPath
				),
				"data" => $objectData
			);
		}
	}
	
	public function Come() 
	{
		if(!empty($this->props["id"])
			&& !empty($this->props["type"])) 
		{
			$hendlerPath = 
				Settings::$FORM_HENDLERS 
				. "changeComeForm.php";
		}
		
		$Object = new Trigger(
			"SubObj",
			'select',
			"findById",
			array($_SESSION["ObjId"])
		);
		
		$Come = new Trigger(
			"Comes",
			'select',
			"ProcSelectSingle",
			array(
				'\'' . $_SESSION["type"] . '\'',
				$this->props["id"]
			)
		);
		
		$objectData = $Object->get();
		$ComeData 	= $Come->get();
		
		
		
		$this->setSessionVars(
			"Entity", __FUNCTION__ . "s"
		);
		
		$this->setSessionVars(
			"Comedate", '\'' .$ComeData[0]->getDate(). '\''
		);
		
		$this->setSessionVars(
			"id", $this->props["id"]
		);
		
		
			
		
		// print_r($objectData);
		// print_r($Come->get());
		return array(
			"vars" => array(
				"name" 		=> __FUNCTION__, 
				"action"	=> $hendlerPath
			),
			"data" => array(
				"Object" => $objectData,
				"Come"	 => $Come->get()
			)
		);
	}
}

?>