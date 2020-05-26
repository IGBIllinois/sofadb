<?php


  if(isset($_SESSION['loggedin']))
  {
     require_once("include/session.inc.php"); 
     
  } else {
       session_start();
  }
  require_once("include/main.inc.php");
  require_once("../conf/settings.inc.php");

$errors = array();

if(isset($_POST['agree'])) {
    if(!isset($_POST['agree_to_terms'])) {
        $errors[] = ("You must agree to the terms of service.");
        $_GET['form'] = true;
    } else {
        $member = new member($db, $_SESSION['id']);
        echo("A");
        $member->update_terms_agreement(true);
        echo("SUCCESS!");
    if($member->get_permissionstatus() == 2) {
        $_SESSION['permissionstatus'] = 2;

        header("Location: ./admin/index.php");
    } else {
        $_SESSION['permissionstatus'] = 1;
        header("Location: ./user/index.php");
    }
    }
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Terms and Conditions</title>
<!-- CSS -->
 <link href="css/style.css" rel="stylesheet" type="text/css" />
 <link rel="stylesheet" type="text/css" href="/css/jquery.multiselect.css" />

<script type="text/javascript" src="vendor/components/jquery/jquery.js"></script>
<script type="text/javascript" src="vendor/components/jquery-ui/ui/minified/jquery-ui.min.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<!-- // Load Javascipt -->
</head>

<body>
<div id="top">
<div id="header"><a href="#"><img src="images/customLogo.gif" width="351" height="147" /></a></div>

<div id="title">
<h1>Forensic Anthropology Database<BR>for Assessing Methods Accuracy (FADAMA)</h1>
</div>

<div id="hline">
<hr size="3" />
</div>

<div id="wrapper" style="width:80%">
<?php
if(count($errors) > 0) {
    foreach($errors as $error) {
        echo($error . "<BR>");
    }
    echo("<BR>");
}
?>
I agree to the terms of service.
<?php  

if(isset($_GET['form'])) {
    echo("<BR>");
    echo("<form action='terms_of_service.php' method=POST name='agree' id='agree'>");
   echo('<input type="checkbox" name="agree_to_terms" id="agree_to_terms"> I agree to the terms of service.') ;
   echo("<BR>");
   echo('<input name="agree" id="agree" type="submit" value="Agree to terms"/>');
    echo("</form>");
}
?>
</div>
<?php 
    require_once("include/footer.php");
?>
