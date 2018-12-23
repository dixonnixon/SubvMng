<?php
require('../../Settings.php');
require('../../autoloader.php');
session_start();


// print_r($_POST);
if(!empty($_SESSION["id"]) && !empty($_POST["submit"])) {
	$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
	
	print_r($post);
	
	new Trigger(
		"Comes",
		'update',
		"ProcCUD",
		array(
			array(
			'\'' . $_SESSION["type"] . '\'',
			$_SESSION["id"],
			$_SESSION["Comedate"],
			$post["Comesum"]
			)
		)
	);
}

?>