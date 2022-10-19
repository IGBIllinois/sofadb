<?php

if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}

require_once("include/main.inc.php");
// This section processes submissions from the login form.
// Check if the form has been submitted:
$message = "";

if (isset($_POST['login'])) {
	$email = trim($_POST['email']);
	$password = trim($_POST['psword']);
	$error = false;
	// Validate the email address:
	if ($email == "") {
		$error = true;
		$message = '<p class="error">You forgot to enter your email address.</p>';
	}
	if ($password == "") {
		$error = true;
		$message .= '<p class="error">You forgot to enter your password.</p>';
	}

	if ($error == false) {
		if(member::authenticate($db, $email, $password)) {
			$member = new member($db);
			$member = member::load_member_by_name($db, $email);
			if($member != null && $member->get_uname() != null && $member->get_permissionstatus() >= member::PERMISSION_REQUESTED) {
				// Start the session, fetch the record and insert the three values in an array
				$session = new \IGBIllinois\session(settings::get_session_name());
				$session_vars = array(
                                                'loggedin'=>1,
                                                'permissionstatus'=> $member->get_permissionstatus(),
                                                'created'=>time(),
                                                'lastactivity'=>time(),
                                                'timeout'=>time(),
                                                'id'=>$member->get_id(),
                                                'ipaddress'=>$_SERVER['REMOTE_ADDR']
				);
				switch($member->get_permissionstatus()) {
					case member::PERMISSION_USER:
						$session->set_session($session_vars);
						$member->update_login_time();
                                                header('Location: ' . './user/index.php');
                                                break;
					case member::PERMISSION_ADMIN:
						$session->set_session($session_vars);
	                                        $member->update_login_time();
                                                header('Location: ' . './admin/index.php');
						break;
					case member::PERMISSION_REQUESTED:
						$message = "<p>Your account is not activated yet. <a href='contact/index.php'>Contact</a> the administrator if you registered more than 48 hours ago.</p>";
						break;
                                        case member::PERMISSION_UNVERIFIED:
                                                $message = "<p>The email you provided has not yet been verified. Please check the email provided during registration and follow its instructions.</p>";
                                                $message .= "To resend the verification email, please <a href='contact/resend_verify_request.php'>click here</a>.";
                                                break;
                                }
			}
			else { 
		       		$message .= '<p class="error">The email address and password entered do not match our records.<br>Perhaps you need to register, click the Register button on the header menu</p>';
        
			}
		} 
	
		else { //Invalid username/password
			$message = "<p class='error'>The email address and password entered do not match our records.<br>Perhaps you need to register, click the Register button on the header menu</p>";
		}
	}
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Forensic Anthropology Case Database (FADAMA)</title>
 
<!-- JS -->
<script type="text/javascript" src='vendor/components/jquery/jquery.js'></script>
<script type="text/javascript" src='vendor/components/jqueryui/jquery-ui.js'></script>

<!-- CSS -->
<link rel="stylesheet" href="css/style.css"  type="text/css" />
<link rel="stylesheet" type="text/css" href="css/jquery.multiselect.css" />
<link rel="stylesheet" type="text/css" href="vendor/components/jqueryui/themes/base/jquery-ui.css" />


</head>

<body OnLoad="document.login.email.focus();">
<?php
if (settings::get_debug()) {
        echo "<div class='debug'>DEBUG MODE - Errors will be shown</div>";

}
?>
<div id="top" class='header'>

    <div class='header_logo'>
            <img class='align_left' src="images/header.png">
    </div>
            <table style='float:right'><tr><td class='align_center' >
              <a href="http://www.sofainc.org" target="_blank"><img  src="<?php echo($root_url) ?>/images/sofaLogo.png"></a>
            </td></tr><tr><td class='align_center' >
              <a href="https://illinois.edu" target="_blank"><img src="<?php echo($root_url) ?>/images/illinois.png"></a>
            </td></tr><tr><td class='align_center' >
              <a href="https://www.csufresno.edu" target="_blank"><img src="<?php echo($root_url) ?>/images/fresnostate.png"></a>
            </td></tr></table>


</div>

  <div id="wrapper">


<div id="login">
<div id="wrappertop"></div>
<div id="wrappermiddle">
	<h2>Login</h2>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name='login'>
		<div id="username_input">
			<div id="username_inputleft"></div>
			<div id="username_inputmiddle">
				<input type="text" name="email" id="url" placeholder="E-mail Address" onclick="this.value = ''" 
					tabindex="1" value='<?php if (isset($_POST['email'])) { echo $_POST['email']; }?>'>
				<img id="url_user" src="./images/mailicon.png" alt="">
				
			</div>
			<div id="username_inputright"></div>
		</div>

		<div id="password_input">
			<div id="password_inputleft"></div>
			<div id="password_inputmiddle">
				<input type="password" name="psword" id="url" value="" onclick="this.value = ''" tabindex="2">
				<img id="url_password" src="./images/passicon.png" alt="">
				
			</div>
			<div id="password_inputright"></div>

		</div>

		<div id="submit">
			<input type='hidden' name='login' value='login'>
			<input type="image" src="./images/submit.png" name="submit" id="submit2" value="Sign In" tabindex="3">
		</div>

		<div id="links_left">
			<a href="contact/resetPasswordRequest.php">Forgot your Password?</a> |
                        <a href="contact/index.php">Contact Us</a> |
                        <a href="faq.php">FAQ</a> |
			<a href="register.php">Not a Member Yet?</a></div>
		</div>
		<div id="wrapperbottom"></div>
	</form>  
  
<?php

if (isset($message)) {
	echo $message;
}
require_once("include/footer.php");
?>
