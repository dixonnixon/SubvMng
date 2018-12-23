<?php
class Report extends AbstractController
{
	public function Subv() 
	{
		$ListAllObjects = false;
		
		if(isset($this->props["Tobo"]) && isset($_GET["Tobo"])
		&& (ControllerCreator::getTobo() == $this->props["Tobo"])) {
			
			$hendlerPath = 
				Settings::$FORM_HENDLERS . "exportReport.php";	
			
			$this->setSessionVars("Tobo", $this->props["Tobo"]);
			
			return array(
				"vars" => array(
					"name" 	=> __FUNCTION__,
					"action"=> $hendlerPath
				),
				"data" => array()
			);
		}
		
		return ;
	}
}

?>