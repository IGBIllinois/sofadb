<!DOCTYPE html >
<?php


  if(isset($_SESSION['loggedin']))
  {
     require_once("../include/session.inc.php"); 
  } else {
       session_start();
  }
    require_once("../../conf/settings.inc.php");
    
if(isset($_SERVER['CONTEXT_PREFIX'])) {
    $root_url = $_SERVER['CONTEXT_PREFIX'];
    
} else {
    $root_url = ROOT_URL;
}
?>

<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>
    <?php
        echo $title;
    ?>
</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<!-- // Load Javascipt -->
</head>

<body>
<div id="top">
<div id="header"><a href="http://www.sofainc.org" target="_blank"><img src="../images/customLogo.gif" width="351" height="147" /></a></div>

<div id="title">
<h1>Forensic Anthropology Database<BR>for Assessing Methods Accuracy (FADAMA)</h1>
</div>

<div id="hline">
<hr size="3" />
</div>


<div id="navbar">
  <ul>

<?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==1) {
?>
    <li><a href="../index.php">My Cases</a></li>
    <li><a href="../user/searchdb/?search=1">Search</a></li>
    <li><a href="../faq.php">FAQ</a></li>
    <li><a href="../contact/">Contact Us</a></li>
<?php

    } else {
?>
    <li><a href="../index.php">Home</a></li>
<?php 
    }
?>
  </ul>
</div>

<div id="hline">
<hr size="3" />
</div>