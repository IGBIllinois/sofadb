<?php

require_once __DIR__ .'/../vendor/autoload.php';
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

error_reporting(0);


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

if(isset($_SERVER['CONTEXT_PREFIX'])) {
    $root_url = $_SERVER['CONTEXT_PREFIX'];
    
} else {
    $root_url = ROOT_URL;
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

// Emailer object from igbillinois-php library
$emailer = new email(MAIL_HOST, MAIL_PORT);

$session = new session(SESSION_NAME);
$reply_emails = array();

$reply_emails = explode(",", ADMIN_EMAIL);
$emailer->set_replyto_emails($reply_emails);

// These lines allow a user to hit the Back button and return to a previously
// submitted form
ini_set('session.cache_limiter','public');
session_cache_limiter(false);

$pagerows = PAGEROWS;

?>