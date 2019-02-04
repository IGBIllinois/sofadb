<?php
require_once("../conf/settings.inc.php");
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
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>SOFA Forensic Case Database</title>
<script type="text/javascript" src="./js/jquery.js"></script>
	<script type="text/javascript" src="./js/jquery.query-2.1.7.js"></script>
	<script type="text/javascript" src="./js/rainbows.js"></script>
	<!-- // Load Javascipt -->

	<!-- Load stylesheets -->
	<link type="text/css" rel="stylesheet" href="css/style.css" media="screen" />
	<!-- // Load stylesheets -->
	



</head>

<body>
<div id="top">
  <div id="header"><a href="#"><img src="images/customLogo.gif" width="351" height="147" /></a></div>
 
 <div id="title">
    <h1>Forensic Case Database</h1>
 </div>
 
 <div id="hline">
   <hr size="3" />
 </div>
 
  <div id="wrapper">
  
 
<?php 
  
// This section processes submissions from the login form.
// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	//connect to database
	 require_once($_SERVER['DOCUMENT_ROOT'].'/mysqli_connect.php');
	// Validate the email address:
	if (!empty($_POST['email'])) {
			$e = mysqli_real_escape_string($dbcon, trim($_POST['email']));
	} else {
	$e = FALSE;
		echo '<p class="error">You forgot to enter your email address.</p>';
	}
	// Validate the password:
	if (!empty($_POST['psword'])) {
			$p = mysqli_real_escape_string($dbcon, trim($_POST['psword']));
// below added code:
$s = SALT;
$hash=md5($s . $p);
	} else {
	$p = FALSE;
		echo '<p class="error">You forgot to enter your password.</p>';
	}
	if ($e && $hash){//if no problems
// Retrieve the user_id, first_name and user_level for that email/password combination:
		$q = "SELECT id, uname, firstname, permissionstatus FROM members WHERE uname='$e' AND pwd='$hash'";	
			
//run the query and assign it to the variable $result
		$result = mysqli_query ($dbcon, $q); 
		
// Count the number of rows that match the email/password combination
	if (@mysqli_num_rows($result) == 1) {//The user input matched the database record
// Start the session, fetch the record and insert the three values in an array
		
		$_SESSION = mysqli_fetch_array ($result, MYSQLI_ASSOC);
$_SESSION['permissionstatus'] = (int) $_SESSION['permissionstatus']; // Ensure that the user level is an integer
if ($_SESSION['permissionstatus']!=0)
{$_SESSION['loggedin']=1;
$_SESSION['created']=time();
$_SESSION['lastactivity']=time();

$q = "UPDATE members SET lastlogin=NOW() WHERE uname='$e' AND pwd='$hash'";
$result = mysqli_query ($dbcon, $q);
if(!$result)
{'<p class="error">Could not update login data.</p>';
exit();}

}

if(isset($_SESSION['loggedin'])){
 if($_SESSION['loggedin']==1 &&$_SESSION['permissionstatus']==1)
{header('Location: ' . './user/index.php');}
elseif($_SESSION['loggedin']==1 &&$_SESSION['permissionstatus']=2){header('Location: ' . './admin/index.php');}}
elseif($_SESSION['permissionstatus']==0)
{echo '<p>Your account is not activated yet. <a href="contact/index.php">Contact</a> the administrator if you registered more than 48 hours ago.</p>';
}

//$url = ($_SESSION['permissionstatus'] === 1) ? 'user/index.php' : 'user/addcase/index.php'; // Use a ternary operation to set the URL
//header('Location: ' . $url); // Make  the browser load either the members� or the admin page



exit(); // Cancels the rest of the script.
	mysqli_free_result($result);
	mysqli_close($dbcon);
	} else { // No match was made.
	echo '<p class="error">The email address and password entered do not match our records.<br>Perhaps you need to register, click the Register button on the header menu</p>';
	}
	} else { // If there was a problem.
		echo '<p class="error">Please try again.</p>';
	}
	mysqli_close($dbcon);
	} // End of SUBMIT conditional.
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
			
				<input type="image" src="./images/submit_hover.png" name="submit" id="submit1" value="Sign In">
				<input type="image" src="./images/submit.png" name="submit" id="submit2" value="Sign In">
				</form>
			</div>


			<div id="links_left">

			<a href="contact/index.php">Forgot your Password?</a>

			</div>

			<div id="links_right"><a href="register/index.php">Not a Member Yet?</a></div>

		</div>

		<div id="wrapperbottom"></div>
  
  
<?php
require_once("include/footer.php");
?>