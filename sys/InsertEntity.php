<?php
error_reporting(E_ALL);
ini_set("display_errors","1");

class InsertEntity extends IStrategy
{
	private $tableMaster;
	private $joinMaster;

	private $query;
	
	public function algorithm(array $dataArray) {
		// echo "<pre>";
		// echo __FUNCTION__;
		$model = $this->newModel();	
		self::$dbh = $model->startConnection();
		// print_r(self::$entity );
		
		
		
		$Mapper = self::buildMappers(self::$entity . "Mapper");
		
		if($Mapper) {
			switch(self::$method) {
				case("ProcCUD"):
					if(self::$entity == "Comes") {
							
						$procNm = 'sp_InsertCome';
						$Mapper->setProcNm($procNm);
					}
			}
		}
	
		// print_r($dataArray);
		echo "<pre>";
		print_r($dataArray);
		echo "</pre>";
		//тут повинен передаватись об`єкт
		
		$result = &$Mapper->{self::$method} ($dataArray[0]);
		
		$budget= "";
		(!empty($_SESSION["BudgetCode"]))
		?$budget="&BudgetCode={$_SESSION["BudgetCode"]}"
		:"";
		
		$objId= "";
		(!empty($_SESSION["ObjId"]))
		?$objId="&ObjId={$_SESSION["ObjId"]}"
		:"";
		
		$type= "";
		if(!empty($_SESSION["type"]))
		{
			$type = "&type={$_SESSION["type"]}";
		} else {
			$type = "";
		}
		
		$year= "";
		if(!empty($_SESSION["year"]))
		{
			$year = "&year={$_SESSION["year"]}";
		} else {
			$year = "";
		}
		
		$month= "";
		if(!empty($_SESSION["month"]))
		{
			$month = "&month={$_SESSION["month"]}";
		} else {
			$month = "";
		}
		
		// echo "res:\n\r";
		// print_r($result);
		// echo "sess:\n\r";
		// print_r($_SESSION);
		// echo "post:\n\r";
		// print_r($_POST);
		// $site = Settings::$PROJECTNAME;
		// // print_r("{$_SERVER["SERVER_NAME"]}/{$site}"
			// . "/index.php?CRUD=Pereglyad"
			// . "&entity={$_SESSION["Entity"]}&Tobo={$_SESSION["Tobo"]}{$budget}{$objId}{$year}");
		//треба реалізувати повертання ІД при складеному РК
		//зараз повертає 0
		// print_r(gettype($result));
		// if($result && is_int($result)) {
			$site = Settings::$PROJECTNAME;
			echo "Location: http://{$_SERVER["HTTP_HOST"]}/{$site}/index.php?CRUD=View&entity={$_SESSION["Entity"]}&Tobo={$_SESSION["Tobo"]}{$budget}{$objId}{$year}";
			header("Location: http://{$_SERVER["HTTP_HOST"]}/{$site}/index.php?CRUD=View&entity={$_SESSION["Entity"]}&Tobo={$_SESSION["Tobo"]}{$budget}{$type}{$objId}{$year}{$month}");
			return;
			
		// }
	}
}

?>