<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/sofadb/conf/settings.inc.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/sofadb/conf/app.inc.php');
error_reporting(E_ERROR | E_PARSE);

ini_set('display_errors',1);

set_include_path(get_include_path().";../libs;../conf;");

function my_autoloader($class_name) {


    //foreach($paths as $path)
	if(file_exists($_SERVER['DOCUMENT_ROOT'].'/sofadb/libs/'. $class_name . ".class.inc.php")) {
		require_once $_SERVER['DOCUMENT_ROOT'].'/sofadb/libs/' .$class_name . '.class.inc.php';
	}


}
spl_autoload_register('my_autoloader');


// database class
$db = new db(DB_HOST, DB_NAME, DB_USER, DB_PASSWORD) OR die ('Could not connect to MySQL' );



// These lines allow a user to hit the Back button and return to a previously
// submitted form
ini_set('session.cache_limiter','public');
session_cache_limiter(false);

$pagerows = PAGEROWS;

?>
