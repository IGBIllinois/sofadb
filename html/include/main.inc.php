<?php

if(file_exists('../../../conf/settings.inc.php')) {
require_once('../../../conf/settings.inc.php');
} else if(file_exists('../../conf/settings.inc.php')) {
    require_once('../../conf/settings.inc.php');
}else if(file_exists('../conf/settings.inc.php')) {
    require_once('../conf/settings.inc.php');
}

ini_set('display_errors',1);

set_include_path(get_include_path().";../libs;../conf;");

function my_autoloader($class_name) {

    $paths = array("../libs/", "../../libs/", "../../../libs/");

    foreach($paths as $path)
	if(file_exists($path . $class_name . ".class.inc.php")) {
		require_once $path .$class_name . '.class.inc.php';
	}


}
spl_autoload_register('my_autoloader');


// Make the connection:
$dbcon = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );

// database class
$db = new db(DB_HOST, DB_NAME, DB_USER, DB_PASSWORD) OR die ('Could not connect to MySQL' );

// Set the encoding...
mysqli_set_charset($dbcon, 'utf8');

// These lines allow a user to hit the Back button and return to a previously
// submitted form
ini_set('session.cache_limiter','public');
session_cache_limiter(false);

$pagerows = PAGEROWS;

?>
