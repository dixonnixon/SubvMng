<?php
require('../../Settings.php');
require('../../autoloader.php');
session_start();


// print_r($_POST);
if(!empty($_SESSION["ObjId"])) {
	$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
	
	// print_r($_SESSION);
	// $Tobo = new Trigger(
		// "Tobo",
		// 'select',
		// "findById",
		// array("Tobo" => $_SESSION["Tobo"])
	// );
	
	// $toboData = $Tobo->get();
	// // print_r($toboData);
	
	// $tobo = new Tobo(
		// $toboData[0]["ToboName"],
		// $toboData[0]["Tobo"]
	// );
	
	
	// $budget = new Budget(
		// $tobo,
		// $post["BudgetName"],
		// $post["BudgetCode"],
		// array()
	// );
	
	
	// $object = new SubObj(
		// $_SESSION["ObjId"],
		// $post["ObjectName"],
		// Budget::fromState(
			// array(
				// $_SESSION["BudgetCode"]
			// )
		// ),
		// $post["ObjYear"],
		// $post["ObjectSumYear"]
	// );
	// echo "<pre>";
	
	// print_r($_SESSION["ObjID"]);
	// print_r($object->getObjID());
	// print_r($object->getObjName());
	// print_r($object->getSumYear());
	
	
	new Trigger(
		"SubObj",
		'update',
		"update",
		array(SubObj::fromState(
				array(
					"id" 	=> $_SESSION["ObjId"],
					"name"	=> $post["ObjectName"],
					"budg"	=> Budget::fromState(
						array(
							"budgCode" 	=> $_SESSION["BudgetCode"],
							"tobo" 		=> Tobo::fromState(
								array(
									"tobo" => $_SESSION["Tobo"],
									"name" => "update"
								)
							),
							"budgName"	=> "update"
						)
					),
					"perm"	=> "",
					"year"	=> "2018",
					"sum"	=> $post["ObjectSumYear"]
				)
			))
	);
}

?>