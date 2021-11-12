<?php

/** Allows an Admin to send an email to all users. Should only be used
 * sparingly, for important announcements
 * 
 */

$title = "Forensic Anthropology Case Database (FADAMA) - Email";
require_once "../include/header_admin.php";


?>

    
  <form method="post" name="emailall">
  <?php 
  
   if($_SERVER['REQUEST_METHOD'] == 'POST') {
       
        $admin_email = ADMIN_EMAIL;

        $memberid = $session->get_var('id');
        $curr_user = new member($db, $memberid);
        $from = $curr_user->get_uname();
        $subject = $_POST['subject'];

        $message = $_POST['emailmessage'];
        
        $emails_array = functions::get_emails($db);
        
        $emailer->set_bcc_emails($emails_array);
        $retval = $emailer->send_emai(FROM_EMAIL, $subject, $message);
        
        if( $retval == true )  
        {
           echo "Message sent successfully.<BR>"; 

        }
        else
        {
           echo "Error: Message could not be sent.<BR>";
        }
   } else {
       
   }

    echo("<fieldset>");
    echo("Submitting this form will send an email to all database users.");

    echo '<div id="contactname">
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
