<?php
require_once __DIR__ .'/../vendor/autoload.php';
require_once(__DIR__ .'/../../libs/functions.class.inc.php');

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

$root_dir = $_SERVER['SERVER_NAME'] . $_SERVER['CONTEXT_PREFIX'];
$ds = DIRECTORY_SEPARATOR;

$filepath = __DIR__ . "$ds..$ds..$ds";

require_once($filepath. "conf". $ds. 'settings.inc.php');
require_once($filepath . "conf". $ds. 'app.inc.php');

error_reporting(0);


function my_autoloader($class_name) {
global $filepath;
global $ds;

	if(file_exists($filepath."libs".$ds.$class_name . ".class.inc.php")) {

		require_once $filepath."libs".$ds.$class_name . '.class.inc.php';
	}


}
spl_autoload_register('my_autoloader');

// Initialize Twig
try {
    $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../templates');
    $twig = new \Twig\Environment($loader, array());
    } catch(Exception $e) {
        echo($e->getMessage());
        echo($e->getTraceAsString());
}


// database class
$db = new db(DB_HOST, DB_NAME, DB_USER, DB_PASSWORD) OR die ('Could not connect to MySQL' );

// These lines allow a user to hit the Back button and return to a previously
// submitted form
ini_set('session.cache_limiter','public');
session_cache_limiter(false);

$pagerows = PAGEROWS;

?>