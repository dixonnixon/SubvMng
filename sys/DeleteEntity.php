<?php
error_reporting(E_ALL);
ini_set("display_errors","1");

class DeleteEntity extends IStrategy
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
		$entityMapper = self::$entity . "Mapper";
		$Mapper = self::buildMappers(self::$entity . "Mapper");
		
		if($Mapper) {
			switch(self::$method) {
				case("ProcCUD"):
					if(self::$entity == "Comes") {
							
						$procNm = 'sp_DeleteCome';
						$Mapper->setProcNm($procNm);
					}
			}
		}
		// print_r($dataArray);
		// print_r($dataArray);
		//тут повинен передаватись об`єкт
		$result = &$Mapper->{self::$method} ($dataArray);
		
		$budget= "";
		(!empty($_SESSION["BudgetCode"]))
		?$budget="&BudgetCode={$_SESSION["BudgetCode"]}"
		:"";
		
		$objId= "";
		(!empty($_SESSION["ObjId"]))
		?$objId="&ObjId={$_SESSION["ObjId"]}"
		:"";
		
		$month= "";
		(!empty($_SESSION["ObjRegDt"]))
		?$month="&ObjRegDt={$_SESSION["ObjRegDt"]}"
		:"";
		
		$year= "";
		if(!empty($_SESSION["year"]))
		{
			// $date = new DateTime($_SESSION["ObjRegDt"]);
			$year = "&year={$_SESSION["year"]}";
		} else {
			$year = "";
		}
		
		$type= "";
		(!empty($_SESSION["type"]))
		?$type="&type={$_SESSION["type"]}"
		:"";
		
		
		// print_r($result);
		//треба реалізувати повертання ІД при складеному РК
		//зараз повертає 0
		$ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
		$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
		// echo "<pre>";
		// print_R($ajax);
		// print_R($_SERVER);
		// echo "</pre>";
		
		if($ajax && $result > 0) {
			return $result;
		} elseif ($result > 0 || !$result) {
			$site = Settings::$PROJECTNAME;
			header("Location: http://" 
			. "{$_SERVER["SERVER_NAME"]}/{$site}"
			. "/index.php?CRUD=View"
			. "&entity={$_SESSION["Entity"]}&Tobo={$_SESSION["Tobo"]}{$budget}{$type}{$objId}{$year}");
		}
	}
}

?>