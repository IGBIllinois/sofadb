<?php
/** Allows a user to reset their password
 * 
 */

$title="Reset Password";
require_once("../include/main.inc.php");
require_once("../include/header_general.php");

$contactURL = "https://". $_SERVER['HTTP_HOST']. $root_url. "/contact/";
?>
<div id="wrapper" style="width:20%">
<?php
$success = false;
if(isset($_POST['submitpass'])) {
    // Reset user's password
    
    $psword1 = trim($_POST['psword1']);
    $psword2 = trim($_POST['psword2']);
    
    if($psword1 == $psword2) {
        // Check if new passwords match
        
        if(($psword1 == null) || ($psword1 == "") || ($psword2 == null) || ($psword2 == "")) {
            $success = false;
            echo("Please fill out the password fields.<BR>");
	} 
	else {
    
            $validator = $_POST['validator'];
            $selector = $_POST['selector'];    
            $result = functions::reset_password($db, $selector, $validator, $psword1);    

            echo($result['MESSAGE']);
            $success = $result['RESULT'];
        }
 
    } else {
        $success = false;
        echo("The passwords do not match. Please try again.<BR>");

    }    

}
if(!$success) {
    // They haven't posted yet, or there was an error, so redraw the form
// Check for tokens
$selector = filter_input(INPUT_GET, 'selector');
$validator = filter_input(INPUT_GET, 'validator');
$queryString = $_SERVER['QUERY_STRING'];
if ( false !== ctype_xdigit( $selector ) && false !== ctype_xdigit( $validator ) ) :
?>
<form name='passreset' id='passreset' action="reset.php?<?php echo $queryString;?>" method="post">
	<input type="hidden" name="selector" value="<?php echo $selector; ?>">
        <input type="hidden" name="validator" value="<?php echo $validator; ?>">
        <input type="password" size='40' class="text" name="psword1" placeholder="Enter your new password" required>
        <br><input type="password" size='40' class="text" name="psword2" placeholder="Retype Password" required>
        <p><input type="submit" name="submitpass" id="submitpass" class="submit" value="Submit">
</form>
    
<?php 

    endif; 

}
?>
    
</div>
  
<?php require_once('../include/footer.php'); ?>
