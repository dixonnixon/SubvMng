<?php
DEFINE("DS", Settings::$DS);
DEFINE("APP_ROOT", Settings::$APP_ROOT);

function class_loader($class_name) {
	$dirs = array(
		APP_ROOT . DS . 'classes'. DS . 'entities'. DS,
		APP_ROOT . DS . 'classes'. DS . 'mappers'. DS,
		APP_ROOT . DS . 'classes'. DS,
		APP_ROOT . DS . 'sys'. DS
		// APP_ROOT . DS . 'view'. DS,
		// APP_ROOT . DS . 'models'. DS,
		// APP_ROOT . DS . 'reports'. DS,
		// APP_ROOT . DS . 'mappers'. DS,
		// APP_ROOT . DS . 'controllers'. DS,
		
		// APP_ROOT . DS . 'sys/triggers'. DS,
		// APP_ROOT . DS . 'classes' . DS . 'Helpers' . DS,		
		// APP_ROOT . DS . 'classes' . DS . 'entityServices' . DS,		
		// APP_ROOT . DS . 'sys' . DS . 'export' . DS,		
		// APP_ROOT . DS
	);
	
	foreach($dirs as $dir) {
		if(file_exists($dir . strtolower($class_name) . '.php')) {
			require_once($dir . strtolower($class_name) . '.php');
		} else {
			continue;
		}
	}
}

spl_autoload_register('class_loader');

?>