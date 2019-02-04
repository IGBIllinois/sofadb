<?php

require('../../include/session_admin.php');

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Activate Members</title>
<link href="../../css/styleTemplate.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />



<!-- // Load Javascipt -->
</head>


<body>
<div id="top">
<div id="header"><a href="#"><img src="../../images/customLogo.gif" width="351" height="147" alt="SOFA" /></a></div>

<div id="title">
<h1>Forensic Case Database</h1>
</div>

<div id="hline">
<hr size="3" />
</div>

<div id="navbar">
  <ul>
    <li><a href="../../">Home</a></li>
    <li><a href="../">My Account</a></li>
    <li><a href="../../logout.php">Logout</a></li>
    <li><a href="../../contact/">Contact Us</a></li>
  </ul>
</div>
<div id="templatecontainer"><h1 style="text-align:center">Admin Tools</h1>
  <div id="leftnav"><h2 style="color:#00C ;font-weight: bold;font-size: 16pt;">Control Panel</h2>
  <ul>
    <li><a href="./">Activate Members</a></li>
    <li><a href="../">Member List</a></li>
    <li><a href="../membersearch/?search=1">Search Members</a></li>
    <li><a href="../editprofile/">Edit Member Profiles</a></li>
    <li><a href="../editcase/">Edit Case Data</a></li>
    <li><a href="../searchdb/">Search Database</a></li>
    
    
  </ul>
    </div>
  <div id="memberregion"> <h2 style="text-align:center">Activate Members</h2> 
  <?php 
// This script retrieves all the records from the users table.
require($_SERVER['DOCUMENT_ROOT'].'/mysqli_connect.php'); // Connect to the database.

//activate user if link clicked
if (isset($_GET['id']))
{ 
$idactivate=intval($_GET['id']);

$q="UPDATE members SET permissionstatus=1 WHERE id=$idactivate";

$result = @mysqli_query ($dbcon, $q);
if(!$result)
{echo '<p class="error">Activation failed. We apologize for any inconvenience.</p>';}

$q="SELECT * FROM members WHERE id=$idactivate";
$result=@mysqli_query($dbcon,$q);
if(!result)
{echo '<p class="error">Activation email not sent, email not extracted from database. We apologize for any inconvenience.</p>';}

$emailrow = mysqli_fetch_array($result, MYSQLI_ASSOC);

   $admin_email="hughesc@illinois.edu";
   $to = $emailrow['uname'];
   $subject = "SOFA Database Account Activated";
   $message = "Dear ".$emailrow['firstname']." ".$emailrow['lastname'].",\n Welcome to the SOFA Database. Your account is now activated and you can add cases, search the database, and download case information from the database.\n Best regards,\n SOFA DB ADMIN\n http://www.sofadb.org";
   $header = "From:".$admin_email."\r\n";
   $retval = mail ($to,$subject,$message,$header);
   if( $retval == true )  
   {
     
	  
   }
   else
   {
      echo "Error: Activation Email could not be sent.";
   }


}


//set the number of rows per display page
$pagerows = 20;

// Has the total number of pagess already been calculated?
if (isset($_GET['p']) && is_numeric
($_GET['p'])) {//already been calculated
$pages=$_GET['p'];
}else{//use the next block of code to calculate the number of pages
//First, check for the total number of records
$q = "SELECT COUNT(id) FROM members WHERE permissionstatus=0";

$result = @mysqli_query ($dbcon, $q);
$row = @mysqli_fetch_array ($result, MYSQLI_NUM);
$records = $row[0];

//Now calculate the number of pages
if ($records > $pagerows){ //if the number of records will fill more than one page
//Calculatethe number of pages and round the result up to the nearest integer
$pages = ceil ($records/$pagerows);
}else{
$pages = 1;
}
}//page check finished
//Decalre which record to start with
if (isset($_GET['s']) && is_numeric
($_GET['s'])) {//already been calculated
$start = $_GET['s'];
}else{
$start = 0;
}
// Make the query:
$q = "SELECT lastname, firstname, uname, institution, DATE_FORMAT(dateregistered, '%M %d, %Y') AS regdat, id  FROM members WHERE permissionstatus=0";		

 

$result = @mysqli_query ($dbcon, $q); // Run the query.
$members = mysqli_num_rows($result);
if ($result) { // If it ran OK, display the records.
// Table header.





echo '<div class="scroll"><table id="hortable" summary="List of members">
    <thead>
    	<tr>
		    <th scope="col">Activate</th>
            <th scope="col">Last Name</th>
            <th scope="col">First Name</th>
            <th scope="col">Email</th>
            <th scope="col">Institution</th>
			<th scope="col">Date Registered</th>
            
            
			
        </tr>
    </thead>
    <tbody>';
    	


// Fetch and print all the records:
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	echo '<tr>
	<td><a href="index.php?id=' . $row['id'] . '">Activate</a></td>
	
	<td>' . $row['lastname'] . '</td>
	<td>' . $row['firstname'] . '</td>
	<td>' . $row['uname'] . '</td>
	<td>' . $row['institution'] . '</td>
	<td>' . $row['regdat'] . '</td>
	

	

	</tr>';
	}
	echo '</tbody></table></div>'; // Close the table.
	mysqli_free_result ($result); // Free up the resources.	
} else { // If it did not run OK.
// Public message:
	echo '<p class="error">The current record could not be retrieved. We apologize for any inconvenience.</p>';
	// Debugging message:
	echo '<p>' . mysqli_error($dbcon) . '<br><br>Query: ' . $q . '</p>';
} // End of if ($result). Now display the total number of records/members.
$q = "SELECT COUNT(id) FROM members WHERE permissionstatus=0";
$result = @mysqli_query ($dbcon, $q);
$row = @mysqli_fetch_array ($result, MYSQLI_NUM);
$members = $row[0];
mysqli_close($dbcon); // Close the database connection.
echo "<p>Total unactivated members: $members</p>";
if ($pages > 1) {
echo '<p>';
//What number is the current page?
$current_page = ($start/$pagerows) + 1;
//If the page is not the first page then create a Previous link
if ($current_page != 1) {
echo '<a href="index.php?s=' . ($start - $pagerows) . '&p=' . $pages . '">Previous</a> ';
}
//Create a Next link
if ($current_page != $pages) {
echo '<a href="index.php?s=' . ($start + $pagerows) . '&p=' . $pages . '">Next</a> ';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
}
echo '</p>';
}
?>
  
  
  
  
  
  </div>
  
  
  
  
</div>
<div id="footer">Copyright 2014 by <a href="http://www.sofainc.org/" target="_blank">SOFA</a>.
    <a href="http://validator.w3.org/check?uri=referer"><img
      src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Transitional" height="31" width="88" /></a>
  </div>
</div>




</body>
</html>

