<?php
require('../../Settings.php');
require('../../autoloader.php');

session_start();

$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


if(isset($_POST["objName"]) && $_SESSION["Tobo"]) {
	print_r($post);
	echo "<pre>";
	print_r($_SESSION);
	echo "</pre>";
	
	
	
	
	// print_R($object);
	
	new Trigger(
		'SubObj',
		'insert',//action
		"insert",//method
		array(
			SubObj::fromState(
				array(
					"id" 	=> "",
					"name"	=> $_POST["objName"],
					"budg"	=> Budget::fromState(
						array(
							"budgCode" 	=> $_SESSION["BudgetCode"],
							"tobo" 		=> Tobo::fromState(
								array(
									"tobo" => $_SESSION["Tobo"],
									"name" => "insert"
								)
							),
							"budgName"	=> "insert"
						)
					),
					"perm"	=> "",
					"year"	=> "2018",
					"sum"	=> $post["objSum"]
				)
			)
		)
	);
}

?>