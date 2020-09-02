<?php
$title = "Forensic Anthropology Case Database (FADAMA) - Confirm";

require_once('../../include/header_user.php');
$errors = 0;
$error_messages = array();
echo("<div id='searchregion'>");
echo("<div id='searchform'>");
echo('<fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend class="boldlegend">Confirm</legend>');

if(isset($_POST['exportsubmit'])) {
    $submitid = "exportsubmit";
} else if (isset($_POST['exportall'])) {
    $submitid = "exportall";
} else if (isset($_POST['exportMy'])) {
    $submitid = "exportMy";
}

if(isset($_POST['submit_consent'])) {
    if(!isset($_POST['data']) ||
            !isset($_POST['credit']) ||
            !isset($_POST['conduct']) ||
            !isset($_POST['terms'])) {
        $errors++;
        $error_messages[] = "You must agree to all of the terms before submitting.";
    }
    if(!isset($_POST['name']) || $_POST['name'] == "") {
        $errors++;
        $error_messages[] = "Please input a name.";
    }
    if(!isset($_POST['email']) || 
            !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors++;
        $error_messages[] = "Please input a valid email address.";
    }
    
    if($errors == 0) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        
        require_once('exportdata.php');
        die();

        
    } else {
        foreach($error_messages as $error) {
            echo("- $error<BR>");
        }
        echo("<BR>");
    }
}
    
echo("<form action='confirm.php?".$_SERVER['QUERY_STRING']."' method=POST name='confirmform'>");
echo <<<_END

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
_END;

echo("
<table>
    <tr><td>Name:</td><td><input type='text' name='name' id='name'></td></tr>
    <tr><td>Email:</td><td><input type='text' name='email' id='email'></td></tr>
</table>
<BR>
<input name='$submitid' id='$submitid' type='submit' value='Export Case Data'></p>
<BR>    
</form>
<a href='index.php'>Back to search</a><BR><BR>
</fieldset>
</div></div>

");
