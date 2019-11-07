<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/maintemplate.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Password Reset</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>SOFA Forensic Anthropology Case Database (FADAMA)</title>

<!-- JS -->
	
<script type="text/javascript" src='vendor/components/jquery/jquery.js'></script>
<script type="text/javascript" src='vendor/components/jquery-ui/jquery-ui.js'></script>

<!-- CSS -->
<link href="<?php echo($root_url) ?>/css/styleTemplateMod.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/jquery.multiselect.css" />
<link rel="stylesheet" type="text/css" href="vendor/components/jqueryui/themes/base/jquery-ui.css" />


<script>


$(document).ready(function(){

$("#submit1").hover(
function() {
$(this).animate({"opacity": "0"}, "slow");
},
function() {
$(this).animate({"opacity": "1"}, "slow");
});
});


</script>


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
    <li><a href="../index.php">Home</a></li>
    <li><a href="#">My Account</a></li>
    <li><a href="#">Logout</a></li>
    <li><a href="../contact/index.php">Contact Us</a></li>
  </ul>
</div>
<!-- InstanceBeginEditable name="EditRegion1" -->
<div id="templatecontainer"><br />
<h1>Password Reset</h1>
  <div id="resetemail"><label>Your Email Address:</label><input name="resetemailcontainer" type="text" size="40" maxlength="200" /> <input name="passwordresetbutton" type="reset" /> </div>
  <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
</div>
<!-- InstanceEndEditable -->

<?php 
    require_once("include/footer.php");
?>
