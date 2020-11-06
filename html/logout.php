<?php 
require_once("../conf/settings.inc.php");
require_once("include/main.inc.php");
$session->destroy_session();
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