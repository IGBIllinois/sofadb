<?php
require_once('../include/main.inc.php') ;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$member = new member($db, $session->get_var('id'));
if($member->get_permissionstatus() == 2) {
    $session->set_session_var('permissionstatus', 2);

    header("Location: ../admin/index.php");
}

?>