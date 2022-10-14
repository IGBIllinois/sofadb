<?php
$title="Reset Password Request";
require_once "../include/header_general.php";
require_once "../include/main.inc.php";
$contactURL = "https://". $_SERVER['HTTP_HOST']. $root_url. "/contact/";
?>
<div id="wrapper" style="width:500px">
<?php

$success = false;

if(isset($_POST['resetsubmit'])) {
    $email = $_POST['email'];
    if($email == null || $email == "" || (!filter_var($email, FILTER_VALIDATE_EMAIL))) {
        echo("Please enter a valid email address.<BR>");
        
    } else if(!member::member_exists($db, $email)) {
        echo("The given email address was not found as a registered user.<BR>");
    }
    else {
    // Create tokens
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);
    $validator = bin2hex($token);

    $url = sprintf('%sreset.php?%s', $contactURL, http_build_query([
        'selector' => $selector,
        'validator' => $validator
    ]));

    // Adds an entry to the password reset table. Selector and Validator are used to verify
    $insert = functions::update_password_request($db, $email, $selector, $validator);

    // send email

    $to = $email;
    $subject = 'FADAMA password reset link';

    $user = member::load_member_by_name($db, $email);
    $name = $user->get_firstname() . " ". $user->get_lastname();

    $params = array ("url"=>$url,
                     "name"=>$name,
                     "from_email"=>settings::get_from_email());

    $txt_message = functions::renderTwigTemplate('email/change_password.txt.twig', $params);
    $html_message = functions::renderTwigTemplate('email/change_password.html.twig', $params);

    // Send email
    $emailer = new \IGBIllinois\email(settings::get_smtp_host(), 
	    settings::get_smtp_port(),
    		settings::get_smtp_username(),
		settings::get_smtp_password()
    );
	$emailer->set_replyto_emails(settings::get_admin_email());
    $emailer->set_to_emails($to);
    $sent = $emailer->send_email(settings::get_from_email(), $subject, $txt_message, $html_message);

        if($sent) {
        echo("An email has been sent to $to with a link to reset the password for that account.");
            $success = true;
        }
        else {
            echo("An error occurred. The message was not sent.<BR>");
        }

    }
}
    
if(!$success) {
    echo("<form method='POST' action='resetPasswordRequest.php'>");
    echo("Please enter the email you used as your username when you registered:<BR>Submitting the form will send a link to the specified address.");
?>
    <br><BR>
    <B>Email Address* </B>
    <input id="email" type="text" name="email" size="30" maxlength="160" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" >
<BR>
<input name="resetsubmit" id="resetsubmit" type="submit" value="Send email"/>
<?php

echo("</form>");
} else {
   // Errors
}

echo("<BR><a href='../index.php'>Back to Main Page</A>");
    
echo("</div>");
require_once('../include/footer.php');

?>
