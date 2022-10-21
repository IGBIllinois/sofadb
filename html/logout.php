<?php 

require_once(__DIR__ . "/include/main.inc.php");
$session = new \IGBIllinois\session(settings::get_session_name());
$log->send_log("User: " . $session->get_var('username') . ": Logged Out");
$session->destroy_session();

unset($_POST);
header('Location: login.php');
?>

