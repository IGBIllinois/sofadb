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


$insert = functions::update_password_request($db, $email, $selector, $validator);

// send email

$to = $email;
$subject = 'FADAMA password reset link';

$user = member::load_member_by_name($db, $email);
$name = $user->get_firstname() . " ". $user->get_lastname();

$params = array ("url"=>$url,
                 "name"=>$name,
                 "from_email"=>FROM_EMAIL);

$message = renderTwigTemplate('email/change_password.html.twig', $params);

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