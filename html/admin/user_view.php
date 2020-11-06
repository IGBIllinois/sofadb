<?php
require_once('../include/header_admin.php') ;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$member = new member($db, $session->get_var('id'));

if($member->get_permissionstatus() == 2) {
    $session->set_session_var('permissionstatus', 1);
    
    header("Location: ../user/index.php");
}

?>