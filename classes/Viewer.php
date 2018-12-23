<?php
class Viewer extends ControllerCreator 
{
	private $encoder;
	
	
	
	function getHeaderText() {
		
		$css = $this->getCrud();
		$URL = Settings::$BOOTFILE;
		$entity = $this->getEntity();
		$tobo = $this->getTobo();
		
		
		$ProvReportView = "?CRUD=Report&entity=Subv&Tobo={$tobo}";
		$depView = "?CRUD=View&entity=Tobo";
		
		$libs = 
<<<LIBS
<link href="{$this->root}css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="{$this->root}css/bootstrap-theme.min.css" rel="stylesheet" type="text/css">
<link href="{$this->root}css/Main.css" rel="stylesheet" type="text/css">
LIBS;
		$jQcss = 
<<<ADDLIB
	<link href="{$this->root}css/jquery-ui.min.css" rel="stylesheet" type="text/css">
ADDLIB;

		$jQValidatecss = 
<<<ADDLIB
	<link href="{$this->root}css/screen.css" rel="stylesheet" type="text/css">
ADDLIB;

		$currentCascadeSheet = "";
		
		if(file_exists(APP_ROOT . DS ."assets".DS."css".DS. $css  . ".css")) {
			$currentCascadeSheet =  
<<<CURR
	<link href="{$this->root}css/{$css}.css" rel="stylesheet">
CURR;
		}
		
		switch($css) {
			case ("View"):
				if($this->getEntity() == "Objects"
				|| $this->getEntity() == "Tobo"
				|| $this->getEntity() == "Budgets"
				|| $this->getEntity() == "Comes"
				|| $this->getEntity() == "SummarySubt") {
					$libs .= $jQcss;
				}
			break;
			case ("Vnesennya"):
			if(
				$this->getEntity() == "Objects") {
					$libs .= $jQcss;
					$libs .= $jQValidatecss;
					
				}
			break;
			case ("Zmina"):
				if($this->getEntity() == "MonthObjects"
				|| $this->getEntity() == "Objects")
				{
					$libs .= $jQcss;
					$libs .= $jQValidatecss;
				}
			break;
			case ("Report"):
				if($this->getEntity() == "Subv")
				{
					$libs .= $jQcss;
					$libs .= $jQValidatecss;
				}
		}
		
		return 
<<<HEADER
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Відділ Видатків</title>
    {$libs}
	{$currentCascadeSheet}
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navagation">
	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</button>
	<div id="navbar" class="navbar-collapse collapse MainMenu{$css}">
		<ul class="nav navbar-nav">
			<li><a href="{$URL}{$ProvReportView}">
				<span aria-hidden="true"></span> Зведена Інформація 2018</a>
			</li>
			<li><a href="{$URL}{$depView}">
				<span aria-hidden="true"></span> Список управлінь області</a> 
			</li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			
		</ul>
	</div>
</nav>
<div class="container">
HEADER;
	}
	
	// function getEncoder() {

	// }
	
	function getFooterText() {
		$project = Settings::$PROJECTNAME;
		
		$scripts = 
<<<SCRIPTS
	<!--[if lt IE 9] -->
	<script src="{$this->root}js/jquery-1.12.4.min.js"></script>
	<!--[endif] -->
	<!--[if gte IE 9]>
	<script src="{$this->root}js/jquery-3.1.1.min.js"></script>
	<![endif]-->
	<script src="{$this->root}js/bootstrap.min.js"></script>
SCRIPTS;
		$jQjs = 
<<<ADDLIB
	<script src="{$this->root}js/jquery-ui.min.js"></script>
ADDLIB;
		$momentjs = 
<<<ADDLIB
	<script src="{$this->root}js/moment-with-locales.min.js"></script>
ADDLIB;

		$jQValidation = 
<<<ADDLIB
	<script src="{$this->root}js/jquery.validate.min.js"></script>
ADDLIB;
		
		$libs = "";
		$js = $this->getCrud();
		$entity = $this->getEntity();
		switch($js) {
			case ("View"):
				if($entity == "Objects"
				|| $this->getEntity() == "Tobo"
				|| $this->getEntity() == "Budgets"
				|| $this->getEntity() == "Comes"
				|| $this->getEntity() == "SummarySubt")
					$scripts .= $jQjs;

			break;
			case ("Vnesennya"):
				if($entity == "Objects")
					$scripts .= $jQjs;
					$scripts .= $jQValidation;
					
			break;
			case ("Zmina"):
				if($this->getEntity() == "MonthObjects"
				|| $this->getEntity() == "Object"
				) {
					$scripts .= $jQjs;
					$scripts .= $jQValidation;
				}
					
			break;
			case ("Report"):
				if($this->getEntity() == "Subv")
				{
					$scripts .= $jQjs;
					$scripts .= $jQValidation;
					$scripts .= $momentjs;
				}
		}
		
		$currentScript = "";
		// echo APP_ROOT . DS ."assets".DS."js".DS. $js . $entity . ".js";
		if(file_exists(APP_ROOT . DS ."assets".DS."js".DS. $js . $entity . ".js")) {
			
			$currentScript =  
<<<CURR
	<script src="{$this->root}js/{$js}{$entity}.js"></script>
CURR;
		}
		

		
		return <<<FOOTER
	</div>
		{$scripts}
		<script src="{$this->root}js/Main.js"></script>
		{$currentScript}
		<script>
			if (storageAvailable('sessionStorage')) {
				sessionStorage.setItem(
					"root", 
					"/{$project}/"
				);
				
			}
			else {
				$('body').prepend("<h1>Браузер не підтримує SessionStorage </h1>")
			}
		</script>
		
</body>
</html>
FOOTER;
	}
	
	public function __toString() {
		return __CLASS__;
	}
}

?>