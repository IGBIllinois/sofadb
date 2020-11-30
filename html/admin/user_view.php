<?php
require_once('../include/header_admin.php') ;

/* 
 * Change from an Admin view to a User view
 */

$member = new member($db, $session->get_var('id'));

if($member->get_permissionstatus() == 2) {
    // Only change if user has admin permissions
    $session->set_session_var('permissionstatus', 1);
    
    header("Location: ../user/index.php");
}

?>