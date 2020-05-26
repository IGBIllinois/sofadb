<?php
require_once('../include/header_admin.php') ;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$member = new member($db, $_SESSION['id']);

if($member->get_permissionstatus() == 2) {
    $_SESSION['permissionstatus'] = 1;
    
    header("Location: ../user/index.php");
}

?>