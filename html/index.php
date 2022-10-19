<?php

if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}

require_once("include/main.inc.php");
require_once("include/session.inc.php");

if($session->get_var('loggedin')== 1 && $session->get_var('permissionstatus') == member::PERMISSION_USER){
        header('Location: ' . './user/index.php');

}
elseif($session->get_var('loggedin')== 1 && $session->get_var('permissionstatus') == member::PERMISSION_ADMIN) {
        header('Location: ' . './admin/index.php');

}
elseif($session->get_var('loggedin')==1) {
        echo '<p>Your account is not activated yet. <a href="contact/index.php">Contact</a> the administrator if you registered more than 48 hours ago.</p>';
}
else {
	header('Location: login.php');
}

    
  


