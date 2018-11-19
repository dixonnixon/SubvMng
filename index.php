<?php
error_reporting(E_ALL);
ini_set("display_errors", "1");
require_once("Settings.php");
require_once("autoloader.php");

date_default_timezone_set("Europe/Kiev");

$obj = new SubObj();
$obj->setName("Build1");
echo $obj->getName();

// $date = ;


// var_dump($date);

// var_dump(new DateTime());
$obj->setDate(new DateTime());

echo "<pre>";
print_r($obj);
echo "</pre>";

$model = new SqlServerPdoAdapter();
$dbh = $model->startConnection();

$subObjMapper = new SubObjMapper($dbh);
$subObjMapper->insert($obj);
?>