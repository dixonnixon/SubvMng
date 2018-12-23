<?php
class Trigger
{
	private $triger;
	private $IFresult;
	/*
	*в параметрі $data вказуємо значення якщо
	*це не $_POST переданий з форми
	*/
	public function __construct(
		$Entity, 
		$CRUD, 
		$method, 
		$data = array()
	) {
		$this->triger = new ClientData();
		$this->IFresult = 
			$this->triger->{$CRUD}($Entity, $method, $data);
	}
	
	public function get() {
		if($this->IFresult) {
			return $this->IFresult;			
		} 
		return array();
	}
}

?>