<?php

abstract Class AbstractController
{
	protected $props;
	
	public function __construct( $props) {
		$this->props = $props;

		print_r($_SESSION);
		print_r($this->props);

		echo http_build_query($this->props) . "\n";
		// $this->setSessionVars("PrevEntity", $_SESSION["Entity"]);
		echo "<pre>";
		echo "</pre>";
		
	}

	
	// protected static $credentials = array();
	
	protected function setSessionVars($sessVarNm, $varValue) {
		if(isset($_SESSION)) {
			$_SESSION[$sessVarNm] = $varValue;
		}
	}
}