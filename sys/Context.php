<?php
class Context
{
	private $strategy;
	private $dataPack;
	
	public function __construct(IStrategy $strategy) {
		$this->strategy = $strategy;
	}
	public function algorithm(array $dataArray) {
		$this->dataPack = &$dataArray;
		
		return $this->strategy->algorithm($this->dataPack);
	}
}
?>