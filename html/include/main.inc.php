<?php

$root_dir = $_SERVER['SERVER_NAME'] . $_SERVER['CONTEXT_PREFIX'];
$ds = DIRECTORY_SEPARATOR;

$filepath = __DIR__ . "$ds..$ds..$ds";

require_once($filepath. "conf". $ds. 'settings.inc.php');
require_once($filepath . "conf". $ds. 'app.inc.php');

error_reporting(0);

set_include_path(get_include_path().";".$filepath."libs".$db.";".$filepath."conf".$db.";");

function my_autoloader($class_name) {
global $filepath;
global $ds;

	if(file_exists($filepath."libs".$ds.$class_name . ".class.inc.php")) {

		require_once $filepath."libs".$ds.$class_name . '.class.inc.php';
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
