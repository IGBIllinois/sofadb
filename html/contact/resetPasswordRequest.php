<?php


require_once("../../conf/settings.inc.php");
require_once("../include/main.inc.php");

if(isset($_SERVER['CONTEXT_PREFIX'])) {
    $root_url = $_SERVER['CONTEXT_PREFIX'];
    
} else {
    $root_url = ROOT_URL;
}

$contactURL = "https://". $_SERVER['HTTP_HOST']. $root_url. "/contact/";

?>
<title>SOFA Forensic Anthropology Case Database (FADAMA)</title>


<!-- // Load Javascipt -->
</head>

<body>
<div id="top">
<div id="header"><a href="#"><img src="../images/customLogo.gif" width="351" height="147" /></a></div>

<div id="title">
<h1>Forensic Anthropology Case Database (FADAMA)</h1>
</div>

<div id="hline">
<hr size="3" />
</div>

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

// Token expiration
$expires = new DateTime('NOW');
$expires->add(new DateInterval('PT24H')); // 24 hours

// Delete any existing tokens for this user
$db->get_update_result("DELETE from password_reset where email=:email", 
        array("email"=>$email));

// Insert reset token into database
$insert = $db->get_insert_result("insert into password_reset (email, selector, token, expires) VALUES (:email, :selector, :token, :expires)",
    array(
        'email'     =>  $email,
        'selector'  =>  $selector, 
        'token'     =>  password_hash($validator, PASSWORD_DEFAULT),
        'expires'   =>  $expires->format('U'),
    ));
        
        // send email

// Recipient
$to = $email;

// Subject
$subject = 'SOFADB password reset link';

// Message
$message = 'We recieved a password reset request. The link to reset your password is below. ';
$message .= 'If you did not make this request, you can ignore this email</p>';
$message .= '<p>Here is your password reset link:</br>';
$message .= sprintf('<a href="%s">%s</a></p>', $url, $url);
$message .= '<p>Thanks!</p>';

// Headers
$headers = "From: " . FROM_EMAIL . " <" . FROM_EMAIL . ">\r\n";
$headers .= "Reply-To: " . ADMIN_EMAIL . "\r\n";
$headers .= "Content-type: text/html\r\n";

// Send email
$sent = mail($to, $subject, $message, $headers);

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
<br><label class="label" for="email">Email Address*</label><input id="email" type="text" name="email" size="30" maxlength="160" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" >
<input name="resetsubmit" id="resetsubmit" type="submit" value="Send email"/>
<?php

echo("</form>");
}


echo("<BR><a href='../index.php'>Back to Main Page</A>");
    
require_once('../include/footer.php');

?>