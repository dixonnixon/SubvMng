<?php
class Delete extends AbstractController
{
	public function Come() {
		if(!empty($this->props["id"])
			&& !empty($this->props["type"])) 
		{
			$hendlerPath = 
				Settings::$FORM_HENDLERS 
				. "changeComeForm.php";
		}
		
		$Come = new Trigger(
			"Comes",
			'select',
			"ProcSelectSingle",
			array(
				'\'' . $_SESSION["type"] . '\'',
				$this->props["id"]
			)
		);
		
		$ComeData 	= $Come->get();
		print_r($ComeData);
		
		$Come = new Trigger(
			"Comes",
			'delete',
			"ProcCUD",
			array(
				'\'' . $_SESSION["type"] . '\'',
				$this->props["id"],
				'\'' . $ComeData[0]->getDate(). '\''
			)
		);
	}
}

?>