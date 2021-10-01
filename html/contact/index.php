<?php
$title="Contact Us";
require_once "../include/header_general.php";
?>

<div id="templatecontainer">
  <form method="post" name="contactus">
  <?php 
  $errors = array();
  $email = "";
  $name = "";
  $message = "";
   if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
       
    if(!isset($_POST['captcha'])) {
        $errors[] = ("Please enter captcha text.<BR>");
        $session->unset_var("captcha_text");
    } else {
        $captcha_text = $session->get_var("captcha_text");
        $input = $_POST['captcha'];
        $email = $_POST['emailentry'];
        $name = $_POST['nameentry'];
        $message = $_POST['emailmessage'];
            
        if($captcha_text == $input) {
            // Captcha matches, send email
            $session->unset_var("captcha_text");

            if(!isset($_POST['emailentry']) || $_POST['emailentry'] == "") {
                $errors[] = "You must enter your email address.";
            }
            else if (!filter_var($_POST['emailentry'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = "You must enter a valid email address.";
            } else {
                // Okay email
            }
            
            if(!isset($_POST['nameentry']) || $_POST['nameentry'] == "") {
                $errors[] = "Please enter your name.";
            }
            
            if(count($errors) > 0) {
                echo("<div class=error>");
                foreach($errors as $error) {
                    echo($error ."<BR>");
                }
                echo("</div>");
            } else {
             $admin_email = ADMIN_EMAIL;
             $to = $admin_email;
             $from = FROM_EMAIL;

            $subject = "SOFA DB ADMIN ALERT: Comments and Questions";
            $message = $_POST['emailmessage'];
            $emailmessage = $_POST['emailmessage']."\n From email: ".$_POST['emailentry']." and Name: ".$_POST['nameentry'];
            $header = "From:".$from."\r\n";
            $retval = mail ($to,$subject,$emailmessage,$header);
            if( $retval == true )  
            {
               echo("<div class=ok>");
               echo "Message sent successfully."; 
               echo("</div>");
            }
            else
            {
               echo("<div class=error>");
               echo "Error: Message could not be sent.";
               echo("</div>");
            }
         }
        } else {
                echo("<div class=error>");
                echo("Your captcha input doesn't match the text. The email has not been sent. Please try again.<BR>");
                echo("</div>");
                
                 $session->unset_var("captcha_text");
             }
         }
}
    
    echo '<div id="contactentry"><label for="emailentry">Your Email Address:</label> <input name="emailentry" id="emailentry" type="email" size="32" maxlength="200" value="'.$email.'"/></div>
    <div id="contactname">
      <label for="nameentry">Your Name:</label>    
      <input name="nameentry" id="nameentry" type="text" size="40" maxlength="200" value="'.$name.'"/></div>
    <div id="contactmessage"><label for="emailmessage">Comments and Questions:</label><br />
    
  <textarea name="emailmessage" id="emailmessage" cols="60" rows="30" placeholder="If requesting the addition of a method not currently available in the database, fill out the following information to include in your message:
Author(s):
Year:
Article/Chapter title:
Biological profile component (age, sex, stature or ancestry):
Bone(s) used by method:">'.
(($message !== "") ? $message : ""
           
) .
            
'
</textarea>
<BR>
<label for="captcha">Please Enter the Captcha Text</label><BR>
    <img src="../include/captcha_image.php" alt="CAPTCHA" class="captcha-image"><i class="fas fa-redo refresh-captcha"></i>
    <br>
    <input type="text" id="captcha" name="captcha">
    
</div>

<div id="contactsend"><input name="SendMessage" type="submit" value="Send Email"/></div>'; 

?>
	
	</form>
</div>
<?php
    require_once("../include/footer.php");
?>

