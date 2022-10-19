<?php

require_once __DIR__ . "/main.inc.php";

ini_set('session.cache_limiter','public');
session_cache_limiter(false);

$session = new \IGBIllinois\session(settings::get_session_name());

//If logged in
if (($session->get_var('loggedin'))) {

	//Timed Out
	if (time() > (intval($session->get_var('timeout')) + intval(settings::get_session_timeout()))) {
                header('Location: '.$root_url.'/logout.php');
        }
        //If IP address is different
	elseif ($_SERVER['REMOTE_ADDR'] != $session->get_var('ipaddress')) {
                header('Location: '.$root_url.'/logout.php');
        }

	elseif($session->get_var('permissionstatus') == member::PERMISSION_REQUESTED) {
		echo '<p>Your account is not activated yet. <a href="contact/index.php">Contact</a> the administrator if you registered more than 48 hours ago.</p>';
		$session->destroy_session();
		header('Location: ' .  $_SERVER['CONTEXT_PREFIX']);
		exit();
	}
	elseif($_SESSION['loggedin']==1 && $_SESSION['permissionstatus'] == member::PERMISSION_UNVERIFIED) {

		echo '<p>Your email has not been verified. Click <a href="contact/resend_verify_request.php">here</a> to resend a verfication message. <a href="contact/index.php">Contact</a> the administrator if you have verified more than 48 hours ago.</p>';
		$session->destroy_sessino();
		header('Location: ' .  $_SERVER['CONTEXT_PREFIX']);
		exit();
	}
	else {
		//Reset Timeout
		$session_vars = array('timeout'=>time());
		$session->set_session_var('timeout', time());
        
	}
}
else {
	// Go pack to login page
	header('Location: '.$root_url.'/index.php');
}
  


