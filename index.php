<?php
header('Content-type: text/html; charset=utf-8');
session_start();

error_reporting(E_ALL);
ini_set("display_errors", "1");
require_once("Settings.php");
require_once("autoloader.php");

date_default_timezone_set("Europe/Kiev");

try 
{
	$bootstrap = new Bootstrap($_GET);
	$controller = $bootstrap->createController();
	


	$ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
	$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
	if (!$ajax && $controller) {
		echo (string) $controller->getHeaderText();
		echo (string) $controller->getContent();
		echo (string) $controller->getFooterText();
	} elseif($controller) {
		print (string) $controller->getAjax();
	}

} catch (Exception $e) {
	$trace = $e->getTrace();
	$message = $e->getMessage();
	echo "<pre>";
		
		print_r($message);
		print_r($trace);
		print_r(debug_backtrace());
	echo "</pre>";
}


// $model = new SqlServerPdoAdapter();
// $dbh = $model->startConnection();

// $ToboMapper = new ToboMapper($dbh);
// $BudgetMapper = new BudgetMapper($dbh, $ToboMapper);
// $subObjMapper = new SubObjMapper($dbh, $ToboMapper, $BudgetMapper);


// $tobo1 = $ToboMapper->findById("1809");
// $budg1 = $BudgetMapper->findById("5900000000");
// $objT1 = $subObjMapper->findById("8");

// echo "<pre>";
// print_r($tobo1);
// print_r($budg1);
// print_r($objT1);

// $obj = new SubObj();
// $obj->setName("Build1");
// $obj->setTobo($tobo1);
// $obj->setBudget("5900000000");
// $obj->setDateObj(new DateTime());
// $obj->setPerm(array("1813", "1856"));

// print_r($obj);


// $idTest = $subObjMapper->insert($obj);
// var_dump($idTest);

// $subObjMapper->delete("8");

// $subObjMapper->insertPerm($objT1, array("1800", "1807"));
// $subObjMapper->insertPerm($objT1, "1816");

// $deleted = $subObjMapper->deletePerm($objT1, array("1800", "1805", "1816"));

// $deleted = $subObjMapper->deletePerm($objT1, array("1800", "1805", "1816"));

// $deleted = $subObjMapper->deletePerm($objT1, "1808");

// var_dump($deleted);
?>