<?php
error_reporting(E_ALL);
ini_set("display_errors","1");

class FindEntity extends IStrategy
{
	private $tableMaster;
	private $joinMaster;

	private $query;
	// private $dbh;
	
	
	
	public function algorithm(array $dataArray) {
		$fnNm = NULL;
		
		$model = $this->newModel();	
		self::$dbh = $model->startConnection();
		
		// print_r(self::$entity);
		$Mapper = self::buildMappers(self::$entity . "Mapper");
		// // echo "<pre>";
		// print_r(self::$entity);
		// print_r($dataArray);
		// print_R($Mapper);
		if($Mapper) {
			switch(self::$method) {
				case("selectFn"):
					if(self::$entity == "Tobo") {
						
						$fnNm = 'fn_check_ToboPerm';
						$Mapper->setFnNm($fnNm);
					}
					
					if(self::$entity == "Inc") {
						
						$fnNm = 'fn_RemsByObj';
						$Mapper->setFnNm($fnNm);
					}
				
					if(self::$entity == "SubObj") {
						
						$fnNm = 'fn_check_ObjPerm';
						$Mapper->setFnNm($fnNm);
					}
					
					if(self::$entity == "Subv") {
						
						$fnNm = 'reportSubv';
						$Mapper->setFnNm($fnNm);
					}
					
					if(self::$entity == "Report") {
						
						$fnNm = 'reportSubv';
						$Mapper->setFnNm($fnNm);
					}
					break;	

				case("ProcSelect"):
					if(self::$entity == "Comes") {
						$procNm = 'sp_SelectComes';
						$Mapper->setProcNm($procNm);
					}
					
					if(self::$entity == "ByMonth") {
							
						$procNm = 'groupMonth';
						$Mapper->setProcNm($procNm);
					}
					break;	
					
				case("ProcSelectSingle"):
					if(self::$entity == "Comes") {
						$procNm = 'sp_SelectCome';
						$Mapper->setProcNm($procNm);
					}			
				
			}
			return $Mapper->{self::$method} ($dataArray);
		}
		

		return 0;
		
		
	}
}

?>