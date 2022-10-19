<?php
require_once("include/main.inc.php");

if(isset($session) && $session->get_var('loggedin') == 1) {
	require_once("include/session.inc.php"); 
     
}
else {
	$session = new \IGBIllinois\session(settings::get_session_name());
}

$errors = array();

if(isset($_POST['regsubmit'])) {
        if(empty($_POST['signature'])) {
            $errors[] = "You must provide a signature.";
            $agree_to_terms = false;
            unset($_POST['submitted']);
        } else {
            $signature = $_POST['signature'];
        }
        
        if(empty($_POST['signature_date'])) {
            $errors[] = "You must provide a signature date.";
            $agree_to_terms = false;
            unset($_POST['submitted']);
        } else {
            $signature_date = $_POST['signature_date'];
        }
        
        if(!empty($signature) && !empty($signature_date)) {
            $agree_to_terms = true;
        } else {
            $agree_to_terms = false;
        }
        
    if($agree_to_terms) {
        $member = new member($db, $session->get_var('id'));
        $member->update_terms_agreement($signature, $signature_date, true);

    if($member->get_permissionstatus() == member::PERMISSION_ADMIN) {
        $session->set_session_var('permissionstatus', member::PERMISSION_ADMIN);
        header("Location: ./admin/index.php");
        
    } else {
        $session->set_session_var('permissionstatus', member::PERMISSION_USER);
        header("Location: ./user/index.php");
    }
    }
}

require_once __DIR__ . "/include/header_general.php";
?>

<div id="wrapper" style="width:80%">
<?php
if(!isset($POST['submitted'])) {
    echo("<BR>");
    echo("<fieldset style='border: solid 1px #000000;overflow: hidden;' class='roundedborder'><legend class='boldlegend'>Terms of Service</legend>");
    echo("<form action='terms_of_service.php' method=POST name='agree' id='agree'>");
    echo("<input type=hidden name=submitted value=1>");
    echo('<BR>

        Please review FADAMA\'s Terms of Service, Privacy Notice, and Contributor License Agreement <U><a href="docs/FADMA_FINAL combined CLA_ToS_Privacy Notice.docx" target="_blank" onclick="enableAfterClick(\'signature\');">here</a></U>.
         <BR><BR>
            By signing below, I acknowledge that I have read and agree to the Terms of Service, Privacy Notice, and Contributor License Agreement.<BR><BR>
            <label class="label" for="signature">Signature (Type your full name):</label><input type="text" name="signature" id="signature" disabled> <i>(activated once the link above has been clicked)</i><BR>
            <label class="label" for="signature_date">Date:</label><input type="date" name="signature_date" id="signature_date">
            <br/><br/>


    <br /><label class="label" for="regsubmit">Click here to register</label>
    <input name="regsubmit" id="regsubmit" type="submit" value="Register"/>
    <BR><BR>');
            
    echo("</form>");
    echo("</fieldset>");

}
?>
</div>
<?php
if(count($errors) > 0) {
	foreach($errors as $error) {
		echo($error . "<BR>");
	}
	echo("<BR>");
}
    require_once("include/footer.php");
?>
