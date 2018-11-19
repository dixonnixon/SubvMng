<?php
error_reporting(E_ALL);
ini_set("display_errors","1");
class UniversalConnect implements IConnectInfo
{
	private static $server = IConnectInfo::HOST;
	private static $currentDB = IConnectInfo::DBNAME;
	private static $user = IConnectInfo::UNAME;
	private static $pass = IConnectInfo::PW;
	private static $hookup;
	
	public static function doConnect($test) {
		
			$options = array(
				// PDO::ATTR_PERSISTENT => true,
				PDO::ATTR_ERRMODE    => PDO::ERRMODE_EXCEPTION
			);
			
			if(!self::$hookup && is_null(self::$hookup)) {
				try {
					self::$hookup = new PDO(
						"sqlsrv:Server=" . self::$server . ";Database=" . self::$currentDB,
						self::$user, 
						self::$pass
						,
						$options
					);
				} catch(PDOException $e) {
					echo $e->getMessage();
					exit;
				}
			
				if(self::$hookup) {
					($test == "test") ? print "Connection successfull: " : "";
				} else {
					echo('<br>The Reason is: ' . self::$hookup->errorCode() . "<br>");
					echo "<pre>";
					print_r(self::$hookup->errorInfo());
					echo "</pre>";
				}
			}
			return self::$hookup;
			
		
		
	}
	
		
	
}

?>