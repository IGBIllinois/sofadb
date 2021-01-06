<!DOCTYPE html >
<?php

if(isset($_SERVER['CONTEXT_PREFIX'])) {
    $root_url = $_SERVER['CONTEXT_PREFIX'];
    
} else {
    $root_url = ROOT_URL;
}


  if(!isset($session) || $session->get_var('loggedin') != 1)
  {
     require_once("main.inc.php"); 
  } else {
       //session_start();
      require_once("main.inc.php"); 
      require_once("session.inc.php"); 
      $session = new session(SESSION_NAME);
  }
    //require_once("../../conf/settings.inc.php");
    
?>

<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
    if(!isset($title)) {
        $title = "Forensic Anthropology Case Database (FADAMA) - My Account";
    }
    ?>
<title><?php echo $title ?></title>

<!-- CSS -->
 <link href="<?php echo($root_url) ?>/css/style.css" rel="stylesheet" type="text/css" />
 <link rel="stylesheet" type="text/css" href="<?php echo($root_url) ?>/css/jquery.multiselect.css" />

<link rel="stylesheet" type="text/css" href="<?php echo($root_url) ?>/vendor/components/jqueryui/themes/base/jquery-ui.css" />

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />


<!-- Javascript -->
  <script type='text/javascript' src='<?php echo($root_url) ?>/js/gen_validatorv4.js'></script>


<script type="text/javascript" src="<?php echo($root_url) ?>/vendor/components/jquery/jquery.js"></script>
<script type="text/javascript" src="<?php echo($root_url) ?>/vendor/components/jqueryui/jquery-ui.min.js"></script>


<script type="text/javascript" src="<?php echo($root_url) ?>/js/jquery.multiselect.js"></script>

<script type="text/javascript" src="<?php echo($root_url) ?>/js/sofa_javascript.js"></script>

<!--
jQuery Plugin: Are-You-Sure (Dirty Form Detection)
https://github.com/codedance/jquery.AreYouSure/

Copyright (c) 2012-2014, Chris Dance - PaperCut Software http://www.papercut.com/
Dual licensed under the MIT or GPL Version 2 licenses.
http://jquery.org/license
-->
  <script type="text/javascript" src="<?php echo($root_url) ?>/js/jquery.are-you-sure.js"></script>
  


 </head>




<body>
<div id="top" class='header'>

    <div class='header_logo'>
            <img class='align_left' src="<?php echo($root_url) ?>/images/header.png">
    </div>
            <table style='float:right'><tr><td class='align_center' >
              <a href="http://www.sofainc.org" target="_blank"><img  src="<?php echo($root_url) ?>/images/sofaLogo.png"></a>
            </td></tr><tr><td class='align_center' >
              <a href="https://illinois.edu" target="_blank"><img src="<?php echo($root_url) ?>/images/illinois.png"></a>
            </td></tr><tr><td class='align_center' >
              <a href="https://www.csufresno.edu" target="_blank"><img src="<?php echo($root_url) ?>/images/fresnostate.png"></a>
            </td></tr></table>


</div>

<div id="hline">
<hr size="3" />
</div>


<div id="navbar">
  <ul>

<?php
    if(isset($session) && $session->get_var('loggedin') == 1 && $session->get_var('permissionstatus') == PERMISSION_USER) {
?>
    <li><a href="<?php echo($root_url)?>/index.php">My Cases</a></li>
    <li><a href="<?php echo($root_url)?>/user/searchdb/?search=1">Search</a></li>
    <li><a href="<?php echo($root_url)?>/faq.php">FAQ</a></li>
    <li><a href="<?php echo($root_url)?>/contact/">Contact Us</a></li>
<?php

    } else {
?>
    <li><a href="<?php echo($root_url)?>/index.php">Home</a></li>
<?php 
    }
?>
  </ul>
</div>

<div id="hline">
<hr size="3" />
</div>