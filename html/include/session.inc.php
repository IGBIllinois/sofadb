<?php
require_once("main.inc.php");

 if($session == null) {
     $session=new \IGBIllinois\session(SESSION_NAME);
 }
$login_user = "";


//If not logged in
if (($session->get_var('loggedin'))) {
    if($session->get_var('permissionstatus') == PERMISSION_REQUESTED) {

        echo '<p>Your account is not activated yet. <a href="contact/index.php">Contact</a> the administrator if you registered more than 48 hours ago.</p>';
        $session->destroy_session();
        header('Location: ' .  $_SERVER['CONTEXT_PREFIX']);
        exit();
    } else if($_SESSION['loggedin']==1 && $_SESSION['permissionstatus'] == PERMISSION_UNVERIFIED) {

        echo '<p>Your email has not been verified. Click <a href="contact/resend_verify_request.php">here</a> to resend a verfication message. <a href="contact/index.php">Contact</a> the administrator if you have verified more than 48 hours ago.</p>';
        $_SESSION=array();
        session_destroy();
        header('Location: ' .  $_SERVER['CONTEXT_PREFIX']);
        exit();
    }
    elseif (time() > (intval($session->get_var('timeout')) + intval(SESSION_TIMEOUT))) {
        // Timed out
        header('Location: '.$root_url.'/logout.php');
    }
    //If IP address is different
    elseif ($_SERVER['REMOTE_ADDR'] != $session->get_var('ipaddress')) {
        header('Location: '.$root_url.'/logout.php');
    } else {
        //Reset Timeout
    $session_vars = array('timeout'=>time());
    $session->set_session_var('timeout', time());
        
    }
} else {
    // Go pack to login page
   header('Location: '.$root_url.'/index.php');
}
  


