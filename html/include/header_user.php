<?php 

if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}

if(isset($_SERVER['CONTEXT_PREFIX'])) {
    $root_url = $_SERVER['CONTEXT_PREFIX'];
    
} else {
    $root_url = ROOT_URL;
}

require_once('session.inc.php') ;
require_once('main.inc.php');

if($_SESSION['loggedin']==1 &&$_SESSION['permissionstatus']==1)
{}
elseif($_SESSION['loggedin']==1 &&$_SESSION['permissionstatus']==2)
{
    // If they're admin, redirect to the admin page
    header('Location: ' . $root_url.'/admin/index.php');
exit();
}

elseif($_SESSION['loggedin']==1)
{echo '<p>Your account is not activated yet. <a href="'.$root_url.'/contact/index.php">Contact</a> the administrator if you registered more than 48 hours ago.</p>';
    $_SESSION=array();
    session_destroy();
    header('Location: ' .  $root_url);
    exit();
}
try {
    $member = new member($db, $_SESSION['id']);
if(!$member->get_agree_to_terms()) {
    header('Location: ' . '../terms_of_service.php?form=true');
}
} catch(Exception $e) {
    echo("ERROR: Cannot find terms of service page.");
}

?>

<!DOCTYPE html >
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
    if(!isset($title)) {
        $title = "Forensic Anthropology Case Database (FADAMA) - My Account";
    }
    ?>
<title><?php echo $title ?></title>

<!-- CSS -->
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

<!--
jQuery Plugin: Are-You-Sure (Dirty Form Detection)
https://github.com/codedance/jquery.AreYouSure/

Copyright (c) 2012-2014, Chris Dance - PaperCut Software http://www.papercut.com/
Dual licensed under the MIT or GPL Version 2 licenses.
http://jquery.org/license
-->
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
    <li><a href="<?php echo($root_url) ?>/">My Cases</a></li>
    <li><a href="<?php echo($root_url) ?>/user/searchdb/index.php?search=1">Search</a></li>
    <li><a href="<?php echo($root_url) ?>/faq.php">FAQ</a></li>
    <li><a href="<?php echo($root_url) ?>/contact/">Contact Us</a></li>
  </ul>
</div>

<div id="hline">
<hr size="3" />
</div>


<div id="templatecontainer">
  
  
    
    <div class="navigation">

        <ul class="menu">
        
        <li><a class="active" href="<?php echo($root_url) ?>"><svg class="home" width="30px" height="30px" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><path d="M419.492,275.815v166.213H300.725v-90.33h-89.451v90.33H92.507V275.815H50L256,69.972l206,205.844H419.492 z M394.072,88.472h-47.917v38.311l47.917,48.023V88.472z"/></svg><span title="Home">My Cases</span></a></li>
        
        <li><a href="<?php echo($root_url) ?>/user/addcase/"><svg class="contact" width="30px" height="30px" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 30 30" enable-background="new 0 0 30 30" xml:space="preserve"><path d="M11.8,8.3h-1.8V6.5c0-0.7,0.6-1.2,1.2-1.2h7.4c0.7,0,1.2,0.6,1.2,1.2v1.8h-1.8v-1c0-0.2-0.2-0.4-0.4-0.4h-5.5c-0.2,0-0.4,0.2-0.4,0.4C11.8,7.3,11.8,8.3,11.8,8.3z"/>

<rect x="2.9" y="9.4" width="24.1" height="15.3"/>

<text transform="matrix(1 0 0 1 11.5 20.375)" fill="#FFFFFF" font-family="'MyriadPro-Regular'" font-size="12">+</text></svg><span title="About">Add Case</span></a></li>

<li><a href="<?php echo($root_url) ?>/user/searchdb/?search=1">
<svg class="search" width="30px" height="30px" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 30 30" enable-background="new 0 0 30 30" xml:space="preserve"><path d="M11.8,8.3h-1.8V6.5c0-0.7,0.6-1.2,1.2-1.2h7.4c0.7,0,1.2,0.6,1.2,1.2v1.8h-1.8v-1c0-0.2-0.2-0.4-0.4-0.4h-5.5c-0.2,0-0.4,0.2-0.4,0.4C11.8,7.3,11.8,8.3,11.8,8.3z"/>

<rect x="2.9" y="9.4" width="24.1" height="15.3"/>

<text transform="matrix(1 0 0 1 12.5 22.375)" fill="#FFFFFF" font-family="'MyriadPro-Regular'" font-size="14">?</text></svg><span title="Work">Search</span></a></li>



<li><a href="<?php echo($root_url) ?>/user/editprofile/"><svg class="about" width="30px" height="30px" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><path d="M407.448,360.474c-59.036-13.617-113.989-25.541-87.375-75.717 c81.01-152.729,21.473-234.406-64.072-234.406c-87.231,0-145.303,84.812-64.072,234.406c27.412,50.482-29.608,62.393-87.375,75.717 c-59.012,13.609-54.473,44.723-54.473,101.176h411.838C461.919,405.196,466.458,374.083,407.448,360.474z"/></svg><span title="About">Profile</span></a></li>



<?php
$member = new member($db, $_SESSION['id']);
if($member->get_permissionstatus() == 2) {
    ?>
<li>
    <a href="<?php echo($root_url) ?>/user/admin_view.php"><svg class="view" width="30px" height="30px" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
        
        <path d="M407.448,360.474c-59.036-13.617-113.989-25.541-87.375-75.717 c81.01-152.729,21.473-234.406-64.072-234.406c-87.231,0-145.303,84.812-64.072,234.406c27.412,50.482-29.608,62.393-87.375,75.717 c-59.012,13.609-54.473,44.723-54.473,101.176h411.838C461.919,405.196,466.458,374.083,407.448,360.474z"/>
        
        </svg>
        <span title="View">Admin View</span></a></li>

<?php
}
?>
        
<li><a href="<?php echo($root_url) ?>/logout.php"><svg class="lab" width="30px" height="30px" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="202 16 539 524" enable-background="new 202 16 539 524" xml:space="preserve"><g>

	<path d="M586.9,508.9H311.5c-43.2,0-81-37.8-81-81V128.2c0-45.9,37.8-81,81-81h275.4c45.9,0,81,35.1,81,81v299.7C667.9,471.1,632.8,508.9,586.9,508.9z"/>

	<path fill="#000000" d="M667.8,376.2c-32.3,44.3-85.5,73.3-145.7,73.3c-98.4,0-178.2-77.4-178.2-172.8s79.8-172.8,178.2-172.8c60.1,0,113.2,28.8,145.5,73"/>

	<polygon  points="406,230.8 406,344.2 546.4,344.2 546.4,419.8 727.3,287.5 568,155.2 568,225.4 	"/>

</g></svg><span title="Lab">Logout</span></a></li>

</ul>


    </div>
    
    