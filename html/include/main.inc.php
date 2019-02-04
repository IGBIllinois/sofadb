<?php

ini_set('display_errors',1);

set_include_path(get_include_path().";../libs;../conf;");

function my_autoloader($class_name) {
	if(file_exists("../../libs/" . $class_name . ".class.inc.php")) {
		require_once "../../libs/" .$class_name . '.class.inc.php';
	}

}
spl_autoload_register('my_autoloader');


// Make the connection:
$dbcon = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );

// Set the encoding...
mysqli_set_charset($dbcon, 'utf8');

// These lines allow a user to hit the Back button and return to a previously
// submitted form
ini_set('session.cache_limiter','public');
session_cache_limiter(false);

$pagerows = 20;

?>
