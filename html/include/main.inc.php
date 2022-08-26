<?php

require_once __DIR__ .'/../../vendor/autoload.php';
require_once(__DIR__ .'/../../libs/functions.class.inc.php');

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use IGBIllinois\email;


$root_dir = $_SERVER['SERVER_NAME'] . $_SERVER['CONTEXT_PREFIX'];
$ds = DIRECTORY_SEPARATOR;

$filepath = __DIR__ . "$ds..$ds..$ds";

require_once($filepath. "conf". $ds. 'settings.inc.php');
require_once($filepath . "conf". $ds. 'app.inc.php');

date_default_timezone_set(TIMEZONE);


/** Automatically load classes from /libs folder
 * 
 * @global string $filepath
 * @global type $ds
 * @param type $class_name Class name to load
 */
function my_autoloader($class_name) {
    global $filepath;
    global $ds;
    if(file_exists($filepath."libs".$ds.$class_name . ".class.inc.php")) {
            require_once $filepath."libs".$ds.$class_name . '.class.inc.php';
    } else {

    }
}

spl_autoload_register('my_autoloader');

if (settings::get_debug()) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
}


if(isset($_SERVER['CONTEXT_PREFIX'])) {
    $root_url = $_SERVER['CONTEXT_PREFIX'];
    
} else {
    $root_url = ROOT_URL;
}


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

$session = new \IGBIllinois\session(SESSION_NAME);


// These lines allow a user to hit the Back button and return to a previously
// submitted form


?>
