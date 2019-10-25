<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php


  if(isset($_SESSION['loggedin']))
  {
     require_once("../include/session_user.php"); 
  } else {
       session_start();
  }
    require_once("../../conf/settings.inc.php");

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Contact Us</title>
<link href="../css/styleTemplateMod.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <script type='text/javascript' src='scripts/gen_validatorv31.js'></script>

<title>SOFA Forensic Anthropology Case Database (FADAMA)</title>


<!-- // Load Javascipt -->
</head>

<body>
<div id="top">
<div id="header"><a href="#"><img src="../images/customLogo.gif" width="351" height="147" /></a></div>

<div id="title">
<h1>Forensic Anthropology Case Database (FADAMA)</h1>
</div>

<div id="hline">
<hr size="3" />
</div>


<div id="navbar">
  <ul>
    <li><a href="<?php echo(ROOT_URL);?>">Home</a></li>
<?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==1) {
?>
    <li><a href="<?php echo(ROOT_URL) ?>/user/searchdb/?search=1">Search</a></li>
    <li><a href="<?php echo(ROOT_URL) ?>/faq.php">FAQ</a></li>
    <li><a href="<?php echo(ROOT_URL) ?>/contact/">Contact Us</a></li>
<?php

    }
?>
  </ul>
</div>

<div id="hline">
<hr size="3" />
</div>

<div id="templatecontainer">
  <form method="post" name="contactus">
  <?php 
   if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
	 //$admin_email="hughesc@illinois.edu";
       $admin_email = ADMIN_EMAIL;
    $to = $admin_email;
    $from = FROM_EMAIL;
  //$from = "admin@sofainc.org";
   $subject = "SOFA DB ADMIN ALERT: Comments and Questions";
   $message = $_POST['emailmessage']."\n From email:A ".$_POST['emailentry']."and Name: A ".$_POST['nameentry'];
   $header = "From:".$from."\r\n";
   $retval = mail ($to,$subject,$message,$header);
   if( $retval == true )  
   {
      echo "Message sent successfully."; //<a href=../../>[Go Back]</a>";
	  
   }
   else
   {
      echo "Error: Message could not be sent.";
   }
   }
else{
    
    echo '<div id="contactentry"><label for="emailentry">Your Email Address:</label> <input name="emailentry" id="emailentry" type="text" size="32" maxlength="200" /></div>
    <div id="contactname">
      <label for="nameentry">Your Name:</label>    
      <input name="nameentry" id="nameentry" type="text" size="40" maxlength="200" /></div>
    <div id="contactmessage"><label for="emailmessage">Comments and Questions:</label><br />
  <textarea name="emailmessage" id="emailmessage" cols="60" rows="30">Leave Name and Email fields blank if you want to send an anonymous message.

If requesting a password reset put the words Password Reset into the comments. 

If requesting the addition of a method not currently available in the database, fill out the following information to include in your message:
Author(s):
Year:
Article/Chapter title:
Biological profile component (age, sex, stature or ancestry):
Bone(s) used by method:</textarea></div>
    <div id="contactsend"><input name="SendMessage" type="submit" /></div>';} ?>
	
	</form>
</div>
<div id="footer">Copyright 2014 by <a href="http://www.sofainc.org/" target="_blank">SOFA</a>.</div>
</div>




</body>
</html>

