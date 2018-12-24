<?php
//containerClass for Controllers and утримування 18хх-юзер
abstract class ControllerCreator
{
	private static $credentials;
	
	private static $comanda;
	private static $entity;
	private static $CRUD;
	
	private static $mapperNm;
	
	private static $method;
	
	protected $root;
	
	// abstract function getHeaderText();
	// abstract function getEncoder();
	// abstract function getFooterText();
	
	private $props = array(); 
	private static $instance;
	
	private function __construct() {
		$this->setCredentials();
		// print_r($_SERVER["REQUEST_URI"]);
		// print_r($_SERVER);
	}
	
	private function setCredentials() {
		// $credentials = explode("\\", $_SERVER["AUTH_USER"]);
		// $creds = explode("-", $credentials[1]);
		// $user = $creds[1];
		// $tobo = (int) $creds[0];
		$user = "Gladenko";
		$tobo = 1800;
		//тут задається перевірка серверної змінної ІІS
		//"AUTH_USER"
		if(!preg_match('/^\d{4}$/', $tobo)) {
			echo "<pre>";
				print_r($_SERVER["AUTH_USER"]);
			echo "</pre>";
			throw new Exception("Невірна серверна змінна \$_SERVER[\"AUTH_USER\"]");
			return;
		}
		
		// print_r($tobo);
		
		//написать є тобо в списку тобо із БД
		//якщо немає то завершить застосунок
		
		self::$credentials = array(
			"usr" 	=> $user,
			"tobo" 	=> $tobo
		);
		
		// self::$method = "FindAll";
		
		// if($tobo != 1800) {
			// self::$method = "FindById";
		// }
	}
	
	
	
	// public static function getQueryParameter($paramName) {
		// echo "<pre>";
		// print_r(get_class_vars(__CLASS__));		
		// echo "</pre>";
	// }
	
	public static function getMethod() {
		return self::$method;
	}
	
	public static function getTobo() {
		return self::$credentials["tobo"];
	}
	
	public static function getUser() {
		return self::$credentials["usr"];
	}
	
	public function setRoot() {
		$this->root = Settings::$ASSETS;
	}
	
	public static function getInstance($instanceName) {
		
		//зробить обробку щоб крім класов типу Viewer ніхто не завантажувався
		//якщо немає класу загрузчика і він визначений
		if(empty(self::$instance) && class_exists($instanceName)) {
			if(get_parent_class($instanceName) == __CLASS__) {
				self::$instance = new $instanceName();
				self::$instance->setRoot();
				return self::$instance;
			}
			return;
		}
		// return;
	}
	
	public function setProperty($propName, $value) {
		
		$filterdVal = htmlspecialchars(
			trim($value),
			ENT_QUOTES
		);
		
		// echo "<pre>";
		// print_r(get_class_vars(__CLASS__));
		// echo "</pre>";
		if(array_key_exists(
			$propName,
			get_class_vars(__CLASS__))
		) {
			self::$$propName = $filterdVal;
		}
		$this->props[$propName] = $filterdVal;
		
		if($propName == 'entity') {
			// print_r($propName);
			// print_r($filterdVal);
			self::$mapperNm = $filterdVal . "Mapper";
			
		}
	}
	
	public static function getEntity() {
		return self::$entity;
	}
	
	public static function getMapperNm() {
		return self::$mapperNm;
	}
	
	public static function getCrud() {
		return self::$CRUD;
	}
	
	
	public function getClassOP($key) {
		$controllerName = $this->props[$key];
	}
	
	public function getContent() {
		//if class exists
		$class = new $this->props["CRUD"]($this->props);
		if(method_exists($class, $this->props["entity"])) {
			$res = $class->{$this->props["entity"]}();
			
			
			$viewPath = Settings::$APP_ROOT . "/views/" 
				. $this->props["CRUD"] . $this->props["entity"] . ".php";
				
			// print_r($viewPath);
			if(is_file($viewPath) && file_exists($viewPath) && isset($res["data"]))
				include_once($viewPath);
			return;
		}
		
		
		header("Location: /" . SETTINGS::$PROJECTNAME);
	}
	
	public function getAjax() {
		
		//Налаштувати доступ!!!!!!!
		// $ListAllObjects = false;
		// if(ControllerCreator::getTobo() == 1800) {
				// $ListAllObjects = true;
			// }
			
		
		// if(isset($this->props["Tobo"]) && isset($_REQUEST["Tobo"])
			// && ($ListAllObjects == true || ControllerCreator::getTobo() == $this->props["Tobo"])) {
			if($_REQUEST["CRUD"] == "View") {
				$name = $_REQUEST["entity"];
				$method = $_REQUEST["method"];
				unset($_REQUEST["CRUD"]);
				unset($_REQUEST["method"]);
				unset($_REQUEST["entity"]);
				// print_r($_REQUEST); 
				
				foreach($_REQUEST as $key => $val) {
					$param[$key] =  htmlspecialchars(trim($val), ENT_QUOTES);
				}
				
				// $param = array(
					// $_REQUEST
				// );
				// return JSON_ENCODE($param);
				$res = new Trigger(
					$name,
					'select',
					"{$method}",
					$param
				);
				
				
				
				return JSON_ENCODE($res->get());
			}
			
			if($_REQUEST["CRUD"] == "Vidalennya") {
				$name = $_REQUEST["entity"];
				unset($_REQUEST["entity"]);
				
				foreach($_REQUEST as $key => $val) {
					$param[$key] =  htmlspecialchars(trim($val), ENT_QUOTES);
				}
				
				$res = new Trigger(
					$name,
					'delete',
					"delete",
					$param
				);
				
				
				return JSON_ENCODE(array("count" => $res->get()));
			}
			
			if($_REQUEST["CRUD"] == "Report") {
				$name = $_REQUEST["entity"];
				$method = $_REQUEST["method"];
				unset($_REQUEST["CRUD"]);
				unset($_REQUEST["method"]);
				unset($_REQUEST["entity"]);

				
				foreach($_REQUEST as $key => $val) {
					$param[$key] =  htmlspecialchars(trim($val), ENT_QUOTES);
				}
				
				$res = new Trigger(
					$name,
					'select',
					"{$method}",
					$param
				);
				
				
				return JSON_ENCODE($res->get());
			}
			
			$file = __FILE__;
			$method = __METHOD__;
			
			return "Непередбачувана відповідь 0_0
			або невірний контролер: {$_REQUEST["CRUD"]} у файлі {$file} ";
		// }
	}
	
}

?>