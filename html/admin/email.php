<?php
$title = "Email";
require_once "../include/header_admin.php";


?>

    
  <form method="post" name="emailall">
  <?php 
  
   if($_SERVER['REQUEST_METHOD'] == 'POST') {
       
        $admin_email = ADMIN_EMAIL;

        $from = $_POST['emailentry'];
        $subject = $_POST['subject'];

        $message = $_POST['emailmessage'];
        $header = "From:".$from."\r\n";

        $real_emails_array = functions::get_emails($db);
        $real_emails = implode(",",$real_emails_array);
        $test_emails_array = array("mbach@igb.illinois.edu", "m_g_bach@yahoo.com", "klatuujunk@yahoo.com", "test@test.test");
        $test_emails = implode(",", $test_emails_array);
        
        $header .= "Bcc:$test_emails\r\n";

        $retval = mail($from, $subject, $message, $header);
        if( $retval == true )  
        {
           echo "Message sent successfully.<BR>"; 

        }
        else
        {
           echo "Error: Message could not be sent.<BR>";
        }
   }

    echo("<fieldset>");
    echo("Submitting this form will send an email to all database users.");

    echo '<div id="contactentry"><label for="emailentry">Your Email Address:</label> <input name="emailentry" id="emailentry" type="text" size="32" maxlength="200" /></div>
    <div id="contactname">
      <label for="subject">Subject:</label>    
      <input name="subject" id="subject" type="text" size="40" maxlength="200" /></div>
    <div id="contactmessage"><label for="emailmessage">Message:</label><br />
  <textarea name="emailmessage" id="emailmessage" cols="60" rows="30">
</textarea></div>
<BR>
    <input name="SendMessage" type="submit" value="Send Email"/></div><BR>';
   echo("</fieldset>");
    ?>
	
	</form>



<?php
    require_once("../include/footer.php");
?>
