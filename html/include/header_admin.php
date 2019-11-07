<?php

if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}

require_once(__DIR__ . "\..\..\conf\settings.inc.php");
require_once('main.inc.php');
require_once('session.inc.php');

if(isset($_SERVER['CONTEXT_PREFIX'])) {
    $root_url = $_SERVER['CONTEXT_PREFIX'];
    
} else {
    $root_url = ROOT_URL;
}


  if($_SESSION['loggedin']==1 &&$_SESSION['permissionstatus']==2)
{}
elseif($_SESSION['loggedin']==1 &&$_SESSION['permissionstatus']==1)
{
    // If they're a user, redirect to the user page.
    header('Location: ' . $root_url.'/user/index.php');
exit();
}
elseif($_SESSION['loggedin']==1)
{echo '<p>Your account is not activated yet. <a href="contact/index.php">Contact</a> the administrator if you registered more than 48 hours ago.</p>';
    $_SESSION=array();
    session_destroy();
    header('Location: ' .  $root_url);
    exit();
}

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Activate Members</title>
<link href="<?php echo($root_url) ?>/css/styleTemplateMod.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />



<!-- // Load Javascipt -->
</head>


<body>
<div id="top">
<div id="header"><a href="#"><img src="<?php echo($root_url) ?>/images/customLogo.gif" width="351" height="147" alt="SOFA" /></a></div>

<div id="title">
<h1>Forensic Anthropology Case Database (FADAMA)</h1>
</div>

<div id="hline">
<hr size="3" />
</div>

<div id="navbar">
  <ul>
    <li><a href="<?php echo($root_url) ?>/">Home</a></li>
    <li><a href="<?php echo($root_url) ?>">My Account</a></li>
    <li><a href="<?php echo($root_url) ?>/logout.php">Logout</a></li>
    <li><a href="<?php echo($root_url) ?>/contact/">Contact Us</a></li>
  </ul>
</div>
<div id="templatecontainer"><h1 style="text-align:center">Admin Tools</h1>
  <div id="leftnav"><h2 style="color:#00C ;font-weight: bold;font-size: 16pt;">Control Panel</h2>
  <ul>
    <li><a href="<?php echo($root_url) ?>/admin/activate/index.php">Activate Members</a></li>
    <li><a href="<?php echo($root_url) ?>/admin/index.php">Member List</a></li>
    <li><a href="<?php echo($root_url) ?>/admin/membersearch/?search=1">Search Members</a></li>
    <li><a href="<?php echo($root_url) ?>/admin/methods/">Methods</a></li>    
    
  </ul>
    </div>