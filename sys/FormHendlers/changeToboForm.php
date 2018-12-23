<?php
require('../../Settings.php');
require('../../autoloader.php');
session_start();

print_r($_POST);
if(!empty($_POST["Tobo"])) {
	$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

	$tobo = new Tobo(
		$post["ToboName"],
		$post["Tobo"]
	);

	print_r($post);
	print_r($tobo);


	new Trigger(
		"Tobo",
		'update',
		"update",
		array(
			Tobo::fromState(
				array(
					"tobo" => $post["Tobo"],
					"name" => $post["ToboName"]
				)
			)
		)
	);
}

?>