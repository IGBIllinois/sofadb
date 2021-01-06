<?php

if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}

require_once('main.inc.php');
require_once('session.inc.php');

if(isset($_SERVER['CONTEXT_PREFIX'])) {
    $root_url = $_SERVER['CONTEXT_PREFIX'];
    
} else {
    $root_url = ROOT_URL;
}

try {
    $member = new member($db, $session->get_var('id'));

    if(!$member->get_agree_to_terms()) {

        header('Location: ' . $root_url .'/terms_of_service.php');

    }
} catch(Exception $e) {
    echo("ERROR: Cannot find terms of service page.");
}

if($session->get_var('loggedin')==1 && $session->get_var('permissionstatus')==PERMISSION_ADMIN) {
    
}
elseif($session->get_var('loggedin')==1 && $session->get_var('permissionstatus')==PERMISSION_USER) {
    // If they're a user, redirect to the user page.
    header('Location: ' . $root_url.'/user/index.php');
    exit();
} elseif($session->get_var('loggedin')==1) {
    echo '<p>Your account is not activated yet. <a href="contact/index.php">Contact</a> the administrator if you registered more than 48 hours ago.</p>';

    $session->destroy_session();
    header('Location: ' .  $root_url);
    exit();
} else {
    
}

?>



<!DOCTYPE html >
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Forensic Anthropology Case Database (FADAMA) - Admin</title>
<link href="<?php echo($root_url) ?>/css/style.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

 <link href="<?php echo($root_url) ?>/css/style.css" rel="stylesheet" type="text/css" />
 <link rel="stylesheet" type="text/css" href="<?php echo($root_url) ?>/css/jquery.multiselect.css" />

<link rel="stylesheet" type="text/css" href="<?php echo($root_url) ?>/vendor/components/jqueryui/themes/base/jquery-ui.css" />

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />


<!-- Javascript -->
  <script type='text/javascript' src='<?php echo($root_url) ?>/js/gen_validatorv4.js'></script>


<script type="text/javascript" src="<?php echo($root_url) ?>/vendor/components/jquery/jquery.js"></script>
<script type="text/javascript" src="<?php echo($root_url) ?>/vendor/components/jqueryui/jquery-ui.min.js"></script>


<script type="text/javascript" src="<?php echo($root_url) ?>/js/jquery.multiselect.js"></script>

<script type="text/javascript" src="<?php echo($root_url) ?>/js/sofa_javascript.js"></script>

<script type="text/javascript" src="<?php echo($root_url) ?>/js/jquery.are-you-sure.js"></script>

</head>


<body>
<div id="top" class='header'>

    <div class='header_logo'>
            <img class='align_left' src="<?php echo($root_url) ?>/images/header.png">
    </div>
            <table style='float:right'><tr><td class='align_center' >
              <a href="http://www.sofainc.org" target="_blank"><img  src="<?php echo($root_url) ?>/images/sofaLogo.png"></a>
            </td></tr><tr><td class='align_center' >
              <a href="https://illinois.edu" target="_blank"><img src="<?php echo($root_url) ?>/images/illinois.png"></a>
            </td></tr><tr><td class='align_center' >
              <a href="https://www.csufresno.edu" target="_blank"><img src="<?php echo($root_url) ?>/images/fresnostate.png"></a>
            </td></tr></table>


</div>
    
<div id="hline">
<hr size="3" />
</div>
    
<div id="navbar">
  <ul>
    <li><a href="<?php echo($root_url) ?>/">Home</a></li>
    
    <li><a href="<?php echo($root_url) ?>/logout.php">Logout</a></li>
    <li><a href="<?php echo($root_url) ?>/contact/">Contact Us</a></li>
    <li class="noHover"><a class="noHover">&nbsp;</a></li>
  </ul>
    <BR>
</div>
    

<div id="templatecontainer"><h1 style="text-align:center">Admin Tools</h1>
  <div id="leftnav"><h2 style="color:#00C ;font-weight: bold;font-size: 16pt;">Control Panel</h2>
  <ul>
    <li><a href="<?php echo($root_url) ?>/admin/activate/index.php">Activate Members</a></li>
    <li><a href="<?php echo($root_url) ?>/admin/index.php">Member List</a></li>
    <li><a href="<?php echo($root_url) ?>/admin/membersearch/?search=1">Search Members</a></li>
    <li><a href="<?php echo($root_url) ?>/admin/methods/">Methods</a></li>    
    <li><a href="<?php echo($root_url) ?>/admin/admin_reports.php">Reports</a></li> 
    <li><a href="<?php echo($root_url) ?>/admin/email.php">Send email</a></li> 
    <li><a href="<?php echo($root_url) ?>/admin/admin_notes.php">Admin notes</a></li>
    <li><a href="<?php echo($root_url) ?>/admin/user_view.php">User View</a></li>
    
  </ul>
    </div>