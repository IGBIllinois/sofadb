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

if(isset($_POST['regsubmit'])) {
        if(empty($_POST['signature'])) {
            $errors[] = "You must provide a signature.";
            $agree_to_terms = false;
            $_GET['form'] = true;
        } else {
            $signature = $_POST['signature'];
        }
        
        if(empty($_POST['signature_date'])) {
            $errors[] = "You must provide a signature date.";
            $agree_to_terms = false;
            $_GET['form'] = true;
        } else {
            $signature_date = $_POST['signature_date'];
        }
        
        if(!empty($signature) && !empty($signature_date)) {
            $agree_to_terms = true;
        } else {
            $agree_to_terms = false;
        }
        
    if($agree_to_terms) {
        $member = new member($db, $_SESSION['id']);
        $member->update_terms_agreement($signature, $signature_date, true);

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

<!DOCTYPE html>
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Terms and Conditions</title>
<!-- CSS -->
 <link href="css/style.css" rel="stylesheet" type="text/css" />
 <link rel="stylesheet" type="text/css" href="/css/jquery.multiselect.css" />

<script type="text/javascript" src="vendor/components/jquery/jquery.js"></script>
<script type="text/javascript" src="vendor/components/jquery-ui/ui/minified/jquery-ui.min.js"></script>
<script type="text/javascript" src='js/jquery.are-you-sure.js'></script>
<script type="text/javascript" src='js/sofa_javascript.js'></script>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<!-- // Load Javascipt -->
</head>

<body>
<div id="top" class='header'>

    <div class='header_logo'>
            <img class='align_left' src="images/header.png">
    </div>
            <table style='float:right'><tr><td class='align_center' >
              <a href="http://www.sofainc.org" target="_blank"><img  src="images/sofaLogo.png"></a>
            </td></tr><tr><td class='align_center' >
              <a href="https://illinois.edu" target="_blank"><img src="images/illinois.png"></a>
            </td></tr><tr><td class='align_center' >
              <a href="https://www.csufresno.edu" target="_blank"><img src="images/fresnostate.png"></a>
            </td></tr></table>


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

<?php  

if(isset($_GET['form'])) {
    echo("<BR>");
    echo("<fieldset style='border: solid 1px #000000;overflow: hidden;' class='roundedborder'><legend class='boldlegend'>Terms of Service</legend>");
    echo("<form action='terms_of_service.php' method=POST name='agree' id='agree'>");

    echo('     <BR>

         Please review FADAMA\'s Terms of Service, Privacy Notice, and Contributor License Agreement <U><a href="docs/FADMA_FINAL combined CLA_ToS_Privacy Notice.docx" target="_blank" onclick="enableAfterClick(\'signature\');">here</a></U>.
     <BR><BR>
             By signing below, I acknowledge that I have read and agree to the Terms of Service, Privacy Notice, and Contributor License Agreement.<BR><BR>
                     <label class="label" for="signature">Signature (Type your full name):</label><input type="text" name="signature" id="signature" disabled> <i>(activated once the link above has been clicked)</i><BR>
             <label class="label" for="signature_date">Date:</label><input type="date" name="signature_date" id="signature_date">
<br/><br/>


  <br />	<label class="label" for="regsubmit">Click here to register</label>
    <input name="regsubmit" id="regsubmit" type="submit" value="Register"/>
    <BR><BR>');
            
    echo("</form>");
    echo("</fieldset>");

}
?>
</div>
<?php 
    require_once("include/footer.php");
?>
