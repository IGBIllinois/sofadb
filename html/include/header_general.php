<?php
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
	$location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	header('HTTP/1.1 301 Moved Permanently');
	header('Location: ' . $location);
	exit;
}

require_once("main.inc.php");

if(isset($_SERVER['CONTEXT_PREFIX'])) {
    $root_url = $_SERVER['CONTEXT_PREFIX'];
    
} else {
    $root_url = ROOT_URL;
}

$session = new \IGBIllinois\session(settings::get_session_name());


?>
<!DOCTYPE html>
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
<link rel="stylesheet" type="text/css" href="<?php echo($root_url) ?>/vendor/components/font-awesome/css/all.min.css" />

<!-- Javascript -->
<script type='text/javascript' src='<?php echo($root_url) ?>/js/gen_validatorv4.js'></script>
<script type="text/javascript" src="<?php echo($root_url) ?>/vendor/components/jquery/jquery.js"></script>
<script type="text/javascript" src="<?php echo($root_url) ?>/vendor/components/jqueryui/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo($root_url) ?>/js/jquery.multiselect.js"></script>
<script type="text/javascript" src="<?php echo($root_url) ?>/js/sofa_javascript.js"></script>
<script type="text/javascript" src="<?php echo($root_url) ?>/js/jquery.are-you-sure.js"></script>
  
</head>

<body>
<?php
if (settings::get_debug()) {
        echo "<div class='debug'>DEBUG MODE - Errors will be shown</div>";

}
?>
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
    if(isset($session) && $session->get_var('loggedin') == 1 && $session->get_var('permissionstatus') == member::PERMISSION_USER) {
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
