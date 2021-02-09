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
       $email = $_POST['emailentry'];
       $name = $_POST['nameentry'];
       $message = $_POST['emailmessage'];

       if(!isset($_POST['emailentry']) || $_POST['emailentry'] == "") {
           $errors[] = "You must enter your email address.";
       }
       else if (!filter_var($_POST['emailentry'], FILTER_VALIDATE_EMAIL)) {
           $errors[] = "You must enter a valid email address.";
       } else {
           // Okay email
       }
       if(count($errors) > 0) {
           foreach($errors as $error) {
               echo($error ."<BR>");
           }
       } else {
        $admin_email = ADMIN_EMAIL;
        $to = $admin_email;
        $from = FROM_EMAIL;

       $subject = "SOFA DB ADMIN ALERT: Comments and Questions";
       $message = $_POST['emailmessage']."\n From email: ".$_POST['emailentry']."and Name: ".$_POST['nameentry'];
       $header = "From:".$from."\r\n";
       $retval = mail ($to,$subject,$message,$header);
       if( $retval == true )  
       {
          echo "Message sent successfully."; 

       }
       else
       {
          echo "Error: Message could not be sent.";
       }
    }
}
    
    echo '<div id="contactentry"><label for="emailentry">Your Email Address:</label> <input name="emailentry" id="emailentry" type="email" size="32" maxlength="200" value="'.$email.'"/></div>
    <div id="contactname">
      <label for="nameentry">Your Name:</label>    
      <input name="nameentry" id="nameentry" type="text" size="40" maxlength="200" value="'.$name.'"/></div>
    <div id="contactmessage"><label for="emailmessage">Comments and Questions:</label><br />
  <textarea name="emailmessage" id="emailmessage" cols="60" rows="30" ">'.
(($message !== "") ? $message :
           
"If requesting the addition of a method not currently available in the database, fill out the following information to include in your message:
Author(s):
Year:
Article/Chapter title:
Biological profile component (age, sex, stature or ancestry):
Bone(s) used by method:") .
'</textarea></div>
    <div id="contactsend"><input name="SendMessage" type="submit" value="Send Email"/></div>'; 

?>
	
	</form>
</div>
<?php
    require_once("../include/footer.php");
?>

