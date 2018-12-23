<?php

abstract Class AbstractController
{
	protected $props;
	
	public function __construct( $props) {
		$this->props = $props;
		// print_r($this->props);
	}
	
	// protected static $credentials = array();
	
	protected function setSessionVars($sessVarNm, $varValue) {
		if(isset($_SESSION)) {
			$_SESSION[$sessVarNm] = $varValue;
		}
	}
}