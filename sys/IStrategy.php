<?php
abstract class IStrategy
{
	CONST TOBO 		= "Tobo";
	CONST BUDGETS 	= "Budgets";
	
	protected static $method;
	protected static $entity;	
	
	protected static $entities = array();
	
	protected static $fetchStyle;	
	
	protected static $dbh;
	
	private static $isConnected = 0;
	
	public function setMethod($method) {
		self::$method = $method;
	}
	
	public function setFetchStyle($fetchStyle) {
		self::$fetchStyle = $fetchStyle;
	}
	
	public static function dbhGet() {
		print_r(self::$dbh);
	}
	
	protected static function buildMappers($key) {
		
		
		
		// print_r($key);
		// print_r(get_declared_classes());

		if(class_exists($key, true)) {
			// print_r(class_exists($key, true));
			// print_r($key);
		}
		
		$tobo 		= new ToboMapper(self::$dbh);
		$budg 		= new BudgetMapper(self::$dbh, $tobo);
		$obj 		= new SubObjMapper(self::$dbh, $tobo, $budg);
		$inc 		= new IncMapper(self::$dbh, $obj);
		$incMonth 	= new ByMonthMapper(self::$dbh);
		$outc 		= new ComesMapper(self::$dbh);
		$rep 		= new SubvMapper(self::$dbh, $budg);
		
		$mappers = array(
			"ToboMapper" 		=> $tobo,
			"BudgetMapper" 		=> $budg,
			"SubObjMapper" 		=> $obj,
			"IncMapper" 		=> $inc,
			"ByMonthMapper" 	=> $incMonth,
			"ComesMapper"		=> $outc,
			"SubvMapper"		=> $rep,
		);
		
		if(isset($mappers[$key])){
			return $mappers[$key];
		}
	}
	
	public function setEntity($entity) {
		self::$entity = $entity;
	}
	
	protected abstract function algorithm(array $dataArray);
	
	protected function newModel() {
		return new SqlServerPdoAdapter();
	}
	
}
?>
