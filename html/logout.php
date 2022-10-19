<?php 

require_once(__DIR__ . "/include/main.inc.php");
$session = new \IGBIllinois\session(settings::get_session_name());
$session->destroy_session();
unset($_POST);
header('Location: login.php');
?>

