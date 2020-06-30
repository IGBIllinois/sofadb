<?php
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}

require_once("../conf/settings.inc.php");
require_once("include/main.inc.php");
ob_start();
 session_start();
  session_regenerate_id();
  if(isset($_SESSION['loggedin']))
  {
  if($_SESSION['loggedin']==1 &&$_SESSION['permissionstatus']==1)
{header('Location: ' . './user/index.php');}
elseif($_SESSION['loggedin']==1 &&$_SESSION['permissionstatus']=2){header('Location: ' . './admin/index.php');}
elseif($_SESSION['loggedin']==1)
{echo '<p>Your account is not activated yet. <a href="contact/index.php">Contact</a> the administrator if you registered more than 48 hours ago.</p>';
}}

if(isset($_SERVER['CONTEXT_PREFIX'])) {
    $root_url = $_SERVER['CONTEXT_PREFIX'];
    
} else {
    $root_url = ROOT_URL;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>SOFA Forensic Anthropology Case Database (FADAMA)</title>

        
<!-- JS -->
	
<script type="text/javascript" src='vendor/components/jquery/jquery.js'></script>
<script type="text/javascript" src='vendor/components/jqueryui/jquery-ui.js'></script>

<!-- CSS -->
<link rel="stylesheet" href="css/style.css"  type="text/css" />
<link rel="stylesheet" type="text/css" href="css/jquery.multiselect.css" />
<link rel="stylesheet" type="text/css" href="vendor/components/jqueryui/themes/base/jquery-ui.css" />


</head>

<body>
<div id="top" class='new_header'>

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
  
 
<?php 
  
// This section processes submissions from the login form.
// Check if the form has been submitted:

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// Validate the email address:
	if (!empty($_POST['email'])) {
            $e = trim($_POST['email']);

	} else {
            $e = FALSE;
            echo '<p class="error">You forgot to enter your email address.</p>';

	}
        if (!empty($_POST['psword'])) {
            $p = trim($_POST['psword']);
            
            $chk_result = member::verify_user_new($db, $e, $p);
            if($chk_result) {
                $member = new member($db);
                $member = member::load_member_by_name($db, $e);
            } else {
                // try old way
                $s = SALT;
                $hash=md5($s . $p);
                if ($e && $hash){//if no problems
                    // Retrieve the user_id, first_name and user_level for that email/password combination:
                    $member = new member($db);
                    
                    $result = $member->load_info_by_name($e, $hash);
                    // reset to new version
                    $member->reset_password($p);

                }
            }
	} else {
            $p = FALSE;
            echo '<p class="error">You forgot to enter your password.</p>';
	}
if($member != null && $member->get_uname() != null && $member->get_permissionstatus() >= 0) {
// Start the session, fetch the record and insert the three values in an array

    $_SESSION['permissionstatus'] = (int) $member->get_permissionstatus(); // Ensure that the user level is an integer
    if ($_SESSION['permissionstatus']!=0) {

        $_SESSION['loggedin']=1;
        $_SESSION['created']=time();
        $_SESSION['lastactivity']=time();
        $_SESSION['id'] = $member->get_id();

        $member->update_login_time();

    } else {
        // Registered, but not approved yet
        echo '<p>Your account is not activated yet. <a href="contact/index.php">Contact</a> the administrator if you registered more than 48 hours ago.</p>';
        $tmp=1;
    }

if(isset($_SESSION['loggedin'])){

    if($_SESSION['loggedin']==1 &&$_SESSION['permissionstatus']==1) {
        header('Location: ' . './user/index.php');
       
    }
    elseif($_SESSION['loggedin']==1 &&$_SESSION['permissionstatus']==2){
        header('Location: ' . './admin/index.php');
        
    }
    
} else { // No match was made.
    if(!$tmp){
        echo '<p class="error">The email address and password entered do not match our records.<br>Perhaps you need to register, click the Register button on the header menu</p>';
    }
}
} else { // No match was made.
    echo '<p class="error">The email address and password entered do not match our records.<br>Perhaps you need to register, click the Register button on the header menu</p>';
}
}


?>
  
  
  <div id="login">
    <div id="wrappertop"></div>

		<div id="wrappermiddle">

			<h2>Login</h2>
<form action="index.php" method="post">
			<div id="username_input">

				<div id="username_inputleft"></div>

				<div id="username_inputmiddle">
				
					<input type="text" name="email" id="url" value="E-mail Address" onclick="this.value = ''">
					<img id="url_user" src="./images/mailicon.png" alt="">
				
				</div>

				<div id="username_inputright"></div>

			</div>

			<div id="password_input">

				<div id="password_inputleft"></div>

				<div id="password_inputmiddle">
				
					<input type="password" name="psword" id="url" value="Password" onclick="this.value = ''">
					<img id="url_password" src="./images/passicon.png" alt="">
				
				</div>

				<div id="password_inputright"></div>

			</div>

			<div id="submit">
			
				<!--<input type="image" src="./images/submit_hover_new.png" name="submit" id="submit1" value="Sign In">-->
				<input type="image" src="./images/submit_new.png" name="submit" id="submit2" value="Sign In">
				</form>
			</div>


			<div id="links_left">
                            
			<a href="contact/resetPasswordRequest.php">Forgot your Password?</a> |

                        <a href="contact/index.php">Contact Us</a> |
                        
                        <a href="faq.php">FAQ</a> |
                        
			<a href="register.php">Not a Member Yet?</a></div>

                       
		</div>

		<div id="wrapperbottom"></div>
  
  
<?php
require_once("include/footer.php");
?>