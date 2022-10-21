<?php

$include_paths = array(__DIR__ . '/../../libs');
set_include_path(get_include_path() . ":" . implode(':',$include_paths));
require_once __DIR__ . '/../../conf/app.inc.php';
require_once __DIR__ . '/../../conf/settings.inc.php';
require_once __DIR__ . '/../../vendor/autoload.php';


function my_autoloader($class_name) {
	if(file_exists(__DIR__ . "/../..//libs/" . $class_name . ".class.inc.php")) {
		require_once $class_name . '.class.inc.php';
	}
}

spl_autoload_register('my_autoloader');

date_default_timezone_set(settings::get_timezone());

if (settings::get_debug()) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
}


$root_url = ROOT_URL;


// database class
$db = new \IGBIllinois\db(settings::get_mysql_host(), 
	settings::get_mysql_database(),
	settings::get_mysql_user(),
	settings::get_mysql_password(),
	settings::get_mysql_ssl(),
	settings::get_mysql_port()
) OR die ('Could not connect to MySQL' );

$log = new \IGBIllinois\log(settings::get_log_enabled(),settings::get_logfile());

?>
