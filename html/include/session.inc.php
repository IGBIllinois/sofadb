<?php

 session_start();
 session_regenerate_id();
 ob_start();
 
if(isset($_SESSION['loggedin'])) {
    if($_SESSION['loggedin']==1 && $_SESSION['permissionstatus'] == 0) {

        echo '<p>Your account is not activated yet. <a href="contact/index.php">Contact</a> the administrator if you registered more than 48 hours ago.</p>';
        $_SESSION=array();
        session_destroy();
        header('Location: ' .  ROOT_URL);
        exit();
    }

  } else {
    $_SESSION=array();
    session_destroy();
    header('Location: ' . ROOT_URL);
    exit();

  }

