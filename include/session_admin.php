<?php

 session_start();
 session_regenerate_id();
  ob_start();
  if(isset($_SESSION['loggedin']))
  {
  if($_SESSION['loggedin']==1 &&$_SESSION['permissionstatus']==2)
{}
elseif($_SESSION['loggedin']==1 &&$_SESSION['permissionstatus']==1)
{header('Location: ' . $_SERVER['DOCUMENT_ROOT'].'/user/index.php');
exit();
}
elseif($_SESSION['loggedin']==1)
{echo '<p>Your account is not activated yet. <a href="contact/index.php">Contact</a> the administrator if you registered more than 48 hours ago.</p>';
$_SESSION=array();
session_destroy();
header('Location: ' . $_SERVER['DOCUMENT_ROOT']);
exit();
}
}
else{
	$_SESSION=array();
session_destroy();
	header('Location: ' . $_SERVER['DOCUMENT_ROOT']);
exit();}

