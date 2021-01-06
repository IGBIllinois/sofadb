<?php
require_once('../include/header_admin.php') ;

/* 
 * Change from an Admin view to a User view
 */

$member = new member($db, $session->get_var('id'));

if($member->get_permissionstatus() == PERMISSION_ADMIN) {
    // Only change if user has admin permissions
    $session->set_session_var('permissionstatus', PERMISSION_USER);
    
    header("Location: ../user/index.php");
}

?>