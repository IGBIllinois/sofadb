<?php
set_time_limit(0);
$title = "Forensic Anthropology Case Database (FADAMA) - Confirm";
require_once(__DIR__ . '/../../include/main.inc.php');
require_once(__DIR__ . '/../../include/session.inc.php') ;

$errors = 0;
$error_messages = array();

if(isset($_POST['exportsubmit'])) {
    // export cases based on search
    $submitid = "exportsubmit";
} else if (isset($_POST['exportall'])) {
    // export all cases
    $submitid = "exportall";
} else if (isset($_POST['exportMy'])) {
    // export only user's cases
    $submitid = "exportMy";
}
    

if(isset($_POST['submit_consent'])) {
    // Check that all terms have been agreed to
    if(!isset($_POST['data']) ||
        !isset($_POST['credit']) ||
        !isset($_POST['conduct']) ||
        !isset($_POST['terms'])) {
        $errors++;
        $error_messages[] = "You must agree to all of the terms before submitting.";
    } else {
        
    }
    if(!isset($_POST['name']) || $_POST['name'] == "") {
        $errors++;
        $error_messages[] = "Please input a name.";
    } else {
        
    }
    if(!isset($_POST['email']) || 
        !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors++;
        $error_messages[] = "Please input a valid email address.";
    } else {
        
    }
    
    if($errors == 0) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        
        require_once('exportdata.php');
        die();

        
    } else {
        echo("Error:<BR>");
        foreach($error_messages as $error) {
            echo("- $error<BR>");
        }
        echo("<BR>");
    }
}
require_once('../../include/header_user.php');

?>

<div id='searchregion'>
<div id='searchform'>
<fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend class="boldlegend">Confirm</legend>

<form action='confirm.php' method='POST' name='confirmform'>

<?php
// Re-add the POST search variables to this form
foreach($_POST as $key=>$value) {
    echo("<input type=hidden name='" .$key . "' value='" . $value . "'>");
}

?>

<input type=hidden value='submit_consent' name="submit_consent" id='submit_consent'>
<BR>
<input type="checkbox" name="data" id="data"> I will only use any data I download for scientific, educational or research purposes
<BR>
<input type="checkbox" name= "credit" id="credit">I will credit this database with any publications and share with the developers any publications that stem from its use. Please use the following citation:
<BR><BR>
<blockquote class=blockquote1>Hughes, CE and Juarez CA. 2018. Learning from Our Casework: The Forensic Anthropology Database for Assessing Methods Accuracy (FADAMA). NIJ 2018-DU-BX-0213.</blockquote>
<BR>
<input type="checkbox" name="conduct" id="conduct">I will not conduct any research that attempts to identify decedents, agencies, or practitioners linked to case data.
<BR>
<input type="checkbox" name="terms" id="terms"> By checking this box, I hereby agree to be bound by the terms and conditions contained within the agreement.
<BR>
<BR>

<table>
    <tr><td>Name:</td><td><input type='text' name='name' id='name'></td></tr>
    <tr><td>Email:</td><td><input type='text' name='email' id='email'></td></tr>
</table>
<BR>
<input name='<?php echo $submitid; ?>' id='<?php echo $submitid; ?>' type='submit' value='Export Case Data'></p>
<BR>    
</form>
<a href='index.php'>Back to search</a><BR><BR>
</fieldset>
</div></div>

