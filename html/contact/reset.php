<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once("../../conf/settings.inc.php");
require_once("../include/main.inc.php");
?>
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

<?php
if(isset($_POST['submitpass'])) {
    echo("SUBMITTING...<BR>");
    $p = trim($_POST['psword1']);
    $s = SALT;
    $hash=md5($s . $p);
    $validator = $_POST['validator'];
    $selector = $_POST['selector'];    
    $result = functions::reset_password($db, $selector, $validator, $hash);    
    
    echo($result['MESSAGE']);
        

} else {
// Check for tokens
$selector = filter_input(INPUT_GET, 'selector');
$validator = filter_input(INPUT_GET, 'validator');

if ( false !== ctype_xdigit( $selector ) && false !== ctype_xdigit( $validator ) ) :
?>
    <form action="reset.php" method="post">
        <input type="hidden" name="selector" value="<?php echo $selector; ?>">
        <input type="hidden" name="validator" value="<?php echo $validator; ?>">
        <input type="password" class="text" name="psword1" placeholder="Enter your new password" required><BR>
        <input type="password" class="text" name="psword2" placeholder="Retype Password" required>
        <input type="submit" name="submitpass" id="submitpass" class="submit" value="Submit">
    </form>
<?php endif; 

}

?>

  <script language="JavaScript" type="text/javascript"
    xml:space="preserve">//<![CDATA[
//You should create the validator only after the definition of the HTML form
  var frmvalidator  = new Validator("registration");
  
 frmvalidator.EnableOnPageErrorDisplaySingleBox();
  frmvalidator.EnableMsgsTogether();
  
     frmvalidator.addValidation("psword1","req","Please enter a password");
   
      frmvalidator.addValidation("psword2","req","Please confirm your password");
      
  </script>