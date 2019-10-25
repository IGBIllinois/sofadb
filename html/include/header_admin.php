<?php

if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}

/*
if(file_exists('../../../conf/settings.inc.php')) {
require_once('../../../conf/settings.inc.php');
} else if('../../conf/settings.inc.php') {
    require_once('../../conf/settings.inc.php');
}
 * 
 */
require_once(__DIR__ . "\..\..\conf\settings.inc.php");
require_once('main.inc.php');
require_once('session_admin.php');

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Activate Members</title>
<link href="<?php echo(ROOT_URL) ?>/css/styleTemplateMod.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />



<!-- // Load Javascipt -->
</head>


<body>
<div id="top">
<div id="header"><a href="#"><img src="<?php echo(ROOT_URL) ?>/images/customLogo.gif" width="351" height="147" alt="SOFA" /></a></div>

<div id="title">
<h1>Forensic Anthropology Case Database (FADAMA)</h1>
</div>

<div id="hline">
<hr size="3" />
</div>

<div id="navbar">
  <ul>
    <li><a href="<?php echo(ROOT_URL) ?>/">Home</a></li>
    <li><a href="<?php echo(ROOT_URL) ?>">My Account</a></li>
    <li><a href="<?php echo(ROOT_URL) ?>/logout.php">Logout</a></li>
    <li><a href="<?php echo(ROOT_URL) ?>/contact/">Contact Us</a></li>
  </ul>
</div>
<div id="templatecontainer"><h1 style="text-align:center">Admin Tools</h1>
  <div id="leftnav"><h2 style="color:#00C ;font-weight: bold;font-size: 16pt;">Control Panel</h2>
  <ul>
    <li><a href="<?php echo(ROOT_URL) ?>/admin/activate/index.php">Activate Members</a></li>
    <li><a href="<?php echo(ROOT_URL) ?>/admin/index.php">Member List</a></li>
    <li><a href="<?php echo(ROOT_URL) ?>/admin/membersearch/?search=1">Search Members</a></li>
    <!--
    <li><a href="<?php echo(ROOT_URL) ?>/admin/editprofile/">Edit Member Profiles</a></li>
    <li><a href="<?php echo(ROOT_URL) ?>/admin/editcase/">Edit Case Data</a></li>
    <li><a href="<?php echo(ROOT_URL) ?>/admin/searchdb/">Search Database</a></li>
    -->
    <li><a href="<?php echo(ROOT_URL) ?>/admin/methods/">Methods</a></li>    
    
  </ul>
    </div>