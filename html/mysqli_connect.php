<?php 
// This creates a connection to the logindb database and to MySQL, 
// It also sets the encoding.
// Set the access details as constants:
require_once("../conf/settings.inc.php");

// Make the connection:
$dbcon = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );

// Set the encoding...
mysqli_set_charset($dbcon, 'utf8');

echo("OK");
?>