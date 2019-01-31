<?php

ini_set('display_errors',1);

set_include_path(get_include_path().";../libs;../conf;");
require($_SERVER['DOCUMENT_ROOT'].'/mysqli_connect.php'); // Connect to the database.


function my_autoloader($class_name) {
	if(file_exists("../../libs/" . $class_name . ".class.inc.php")) {
		require_once "../../libs/" .$class_name . '.class.inc.php';
	}

}
spl_autoload_register('my_autoloader');


// These lines allow a user to hit the Back button and return to a previously
// submitted form
ini_set('session.cache_limiter','public');
session_cache_limiter(false);

?>
