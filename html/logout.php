<?php 
ob_start();
session_start();
$_SESSION=array();
session_destroy();
header('Location: ' . './index.php');
?>


<!DOCTYPE html >
<html>




<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body>
Logging out...
</body>

</html>
<? ob_end_flush(); ?>