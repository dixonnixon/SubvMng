<?php
error_reporting(E_ALL);
ini_set("display_errors","1");

class UpdateEntity extends IStrategy
{
	private $tableMaster;
	private $joinMaster;

	private $query;
	// private $dbh;
	
	public function algorithm(array $dataArray) {
		// echo "<pre>";
		// session_start();
		// print_r($_SESSION);
		$model = $this->newModel();	
		self::$dbh = $model->startConnection();
		// print_r(self::$entity );
		$entityMapper = self::$entity . "Mapper";
		$Mapper = self::buildMappers(self::$entity . "Mapper");
		// print_r($dataArray);
		// print_r($dataArray);
		//тут повинен передаватись об`єкт
		// print_r($dataArray[0]);
		//Повертає кількість змінених рядків в БД
		
		if($Mapper) {
			switch(self::$method) {
				case("ProcCUD"):
					if(self::$entity == "Comes") {
							
						$procNm = 'sp_UpdateCome';
						$Mapper->setProcNm($procNm);
					}
			}
		}
		
		// print_r($dataArray);
		

		$result = $Mapper->{self::$method} ($dataArray[0]);
		
		$budget= "";
		(!empty($_SESSION["BudgetCode"]))
		?$budget="&BudgetCode={$_SESSION["BudgetCode"]}"
		:"";
		
		$objId= "";
		(!empty($_SESSION["ObjId"]))
		?$objId="&ObjId={$_SESSION["ObjId"]}"
		:"";
		
		$type= "";
		(!empty($_SESSION["type"]))
		?$type="&type={$_SESSION["type"]}"
		:"";
		
		// $date = $dataArray[0]->getObjRegDt();
		// print_r($date);
		// var_dump($date);
		
		// $year = "";
		// (!empty($date)) 
		// ? $year = "&year=" . substr($date, 0, 4) : "";
		// print_r($year);
		
		// if($result > 0) {
			// $site = Settings::$PROJECTNAME;
			// header("Location: http://" 
			// . "{$_SERVER["SERVER_NAME"]}/{$site}"
			// . "/index.php?CRUD=Pereglyad"
			// . "&entity={$_SESSION["Entity"]}&Tobo={$_SESSION["Tobo"]}{$budget}{$objId}{$year}");
		// }
		if($result > 0) {
			$site = Settings::$PROJECTNAME;
			header("Location: http://" 
			. "{$_SERVER["SERVER_NAME"]}/{$site}"
			. "/index.php?CRUD=View"
			. "&entity={$_SESSION["Entity"]}&Tobo={$_SESSION["Tobo"]}{$budget}{$objId}{$type}");
		}
		echo "Bad request";
	}
}

?>