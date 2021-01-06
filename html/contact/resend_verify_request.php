<?php
$title="Email Verification";
require_once "../include/header_general.php";
require_once "../include/main.inc.php";

echo('<div id="wrapper" style="width:500px">');
if(isset($_POST["verify"])) {
    
    if(empty($_POST["email"]) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        echo("Please enter a valid email.");
    } else {
        $email = $_POST["email"];
        
        
        if(!member::member_exists($db, $email)) {
            echo("That email was not found. Please try again, or contact the administration for assistance.");
        } else {
            // Validate the email address:

            if (!empty($_POST['password'])) {
                $p = trim($_POST['password']);

                $chk_result = member::verify_user_new($db, $email, $p);
                if($chk_result) {
                    $selector = bin2hex(random_bytes(8));
                    $token = random_bytes(32);
                    $validator = bin2hex($token);
                    functions::send_register_email($db, $email, $selector, $validator, $root_url);
                    echo("An email has been sent to the address you provided. Please check the message and follow the instructions to activate your account.");
                } else {
                    // try old way
                    $s = SALT;
                    $hash=md5($s . $p);
                    if ($e && $hash){//if no problems
                        
                        $selector = bin2hex(random_bytes(8));
                        $token = random_bytes(32);
                        $validator = bin2hex($token);
                        functions::send_register_email($db, $email, $selector, $validator, $root_url);
                        echo("An email has been sent to the address you provided. Please check the message and follow the instructions to activate your account.");

                    } else {
                        echo("Your email and password don't match. Please try again, or contact the administration if you continue to experience problems.");
                    }
                }
            } else {
                $p = FALSE;
                echo '<p class="error">Please enter your password.</p>';
            }
            
        }
    }
} else {
    echo("Please enter the email and password you used when registering. If you experiencing problems, please contact the administration.");
}

echo("<form name='verify_email' id='verify_email' method=POST action=resend_verify_request.php>");
echo("<table><tr><td>");
echo("Email address:</td><td><input type=email name=email id=email>");
echo("</td><td><tr><td>");
echo("Password:</td><td><input type=password name=password id=password>");
echo("</td></tr></table>");
echo("<input type=submit name=verify id=verify value='Submit'>");
echo("</form>");
echo("</div>");
require_once "../include/footer.php";
