<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>
<?php 
     $admin_email="hughesc@illinois.edu";
    $to = $admin_email;
   $subject = "SOFA DB ADMIN ALERT: Comments and Questions";
   $message = $_POST['emailmessage']."\n From email:A ".$_POST['emailentry']."and Name: A ".$_POST['nameentry'];
   $header = "From:".$_POST['emailentry']."\r\n";
   $retval = mail ($to,$subject,$message,$header);
   if( $retval == true )  
   {
      echo "Message sent successfully."; //<a href=../../>[Go Back]</a>";
	  
   }
   else
   {
      echo "Error: Message could not be sent.";
   }
?>
<body>
</body>
</html>

