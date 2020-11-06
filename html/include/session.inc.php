<?php
require_once("main.inc.php");

 if($session == null) {
     $session=new session(SESSION_NAME);
 }
$login_user = "";


//If not logged in
if (($session->get_var('loggedin'))) {
    if($session->get_var('permissionstatus') == 0) {

        echo '<p>Your account is not activated yet. <a href="contact/index.php">Contact</a> the administrator if you registered more than 48 hours ago.</p>';
        $session->destroy_session();
        header('Location: ' .  $_SERVER['CONTEXT_PREFIX']);
        exit();
    }
    elseif (time() > (intval($session->get_var('timeout')) + intval(SESSION_TIMEOUT))) {
        header('Location: '.$root_url.'/logout.php');
    }
    //If IP address is different
    elseif ($_SERVER['REMOTE_ADDR'] != $session->get_var('ipaddress')) {
        header('Location: '.$root_url.'/logout.php');
    } else {
        
    }
} else {
    //Reset Timeout
    $session_vars = array('timeout'=>time());
    $session->set_session($session_vars);
}
  


