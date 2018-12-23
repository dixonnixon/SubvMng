<?php
require('../../Settings.php');
require('../../autoloader.php');

session_start();


if(isset($_POST["addComes"]) && $_SESSION["Tobo"]) {
	$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
	
	$dataT = explode("/", $post["date"]);
	
	$dataSql = '\'' . $dataT[2] . "-" . $dataT[1] . "-" . $dataT[0] . '\'';
	
	echo "<pre>";
	print_r($_SESSION);
	print_r($post);
	echo "</pre>";

	$ByMonth = array();
			$method = "ProcCUD";
		
			$params = array(
				$_SESSION["type"],
				$_SESSION["ObjId"],
				$dataSql,
				$post["Sum"]
			);

	new Trigger(
		"Comes",
		'insert',
		$method,
		array($params)
	);
}

?>