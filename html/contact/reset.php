<?php
$title="Reset Password";
require_once("../../conf/settings.inc.php");
require_once("../include/header_general.php");
require_once("../include/main.inc.php");
$contactURL = "https://". $_SERVER['HTTP_HOST']. $root_url. "/contact/";
?>
<div id="wrapper" style="width:20%">
<?php
$success = false;
if(isset($_POST['submitpass'])) {
    
    $psword1 = $_POST['psword1'];
    $psword2 = $_POST['psword2'];
    
    if($psword1 == $psword2) {
        if($psword1 == null || $psword1 == "") {
            $success = false;
            echo("Please fill out the password fields.<BR>");
        } else {

            $p = trim($_POST['psword1']);
            
            $validator = $_POST['validator'];
            $selector = $_POST['selector'];    
            $result = functions::reset_password($db, $selector, $validator, $p);    

            echo($result['MESSAGE']);
            $success = $result['RESULT'];
        }
 
    } else {
        $success = false;
        echo("The passwords do not match. Please try again.<BR>");

    }    

}
if(!$success) {
// Check for tokens
$selector = filter_input(INPUT_GET, 'selector');
$validator = filter_input(INPUT_GET, 'validator');
$queryString = $_SERVER['QUERY_STRING'];
if ( false !== ctype_xdigit( $selector ) && false !== ctype_xdigit( $validator ) ) :
?>
    <form action="reset.php? <?php echo $queryString;?>" method="post">
        <input type="hidden" name="selector" value="<?php echo $selector; ?>">
        <input type="hidden" name="validator" value="<?php echo $validator; ?>">
        <input type="password" class="text" name="psword1" placeholder="Enter your new password" required><BR>
        <input type="password" class="text" name="psword2" placeholder="Retype Password" required>
        <BR>
        <input type="submit" name="submitpass" id="submitpass" class="submit" value="Submit">
    </form>
<?php endif; 

}


?>
</div>
  <script language="JavaScript" type="text/javascript"
    xml:space="preserve">//<![CDATA[
//You should create the validator only after the definition of the HTML form
  var frmvalidator  = new Validator("registration");
  
 frmvalidator.EnableOnPageErrorDisplaySingleBox();
  frmvalidator.EnableMsgsTogether();
  
     frmvalidator.addValidation("psword1","req","Please enter a password");
   
      frmvalidator.addValidation("psword2","req","Please confirm your password");
      
  </script>
  
  <?php
  require_once('../include/footer.php');
  ?>