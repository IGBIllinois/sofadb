<?php
require_once("../../include/header_admin.php");

?>

  <div id="memberregion"> <h2 style="text-align:center">Activate Members</h2> 
  <?php 
// This script retrieves all the records from the users table.

//activate user if link clicked
if (isset($_GET['id']))
{ 
$idactivate=intval($_GET['id']);
if(isset($_GET['deny'])) {
    // decline this user
    $member = new member($db, $idactivate);
$result = $member->set_permission('0');


if($result['RESULT'] == FALSE) 
{
    echo '<p class="error">Activation failed. We apologize for any inconvenience.</p>';
    
} else {
       //$to = $emailrow['uname'];
    $to = $member->get_uname();
$admin_email = ADMIN_EMAIL;

   $subject = "FADAMA Membership Denied";
   $message = "Your request for FADAMA membership was denied. For more information please review our policies on membership requirements.\n\nThank you,\nFADAMA Database Committee";
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
    
} else {
$member = new member($db, $idactivate);
$result = $member->set_permission(1);


if($result['RESULT'] == FALSE) 
{
    echo '<p class="error">Activation failed. We apologize for any inconvenience.</p>';
    
} else {



//$emailrow = $result[0];
   //$admin_email="hughesc@illinois.edu";
   //$to = $emailrow['uname'];
   $to = $member->get_uname();
$admin_email = ADMIN_EMAIL;

   $subject = "FADAMA Membership Approved";
   //$message = "Dear ".$member->get_firstname()." ".$member->get_lastname.",\n Welcome to the SOFA Database. Your account is now activated and you can add cases, search the database, and download case information from the database.\n Best regards,\n SOFA DB ADMIN\n http://www.sofadb.org";
   $message = "Dear New FADAMA Member, \n
              Your membership request has been approved. You may access          
               the database at http://sofainc.org/sofadb/. You can both 
               download case data and submit case data to be added to the  
               database.  Please review our FAQ, Database 
               Policies and Practices, and User Tutorial
               to help get you started. ";
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
}
}

//set the number of rows per display page
$pagerows = PAGEROWS;

// Has the total number of pagess already been calculated?
if (isset($_GET['p']) && is_numeric
($_GET['p'])) {//already been calculated
$pages=$_GET['p'];
}else{//use the next block of code to calculate the number of pages
//First, check for the total number of records
    $inactive_members = member::get_members_permission($db, 0);
    $num_inactive_members = count($inactive_members);


//Now calculate the number of pages
if ($num_inactive_members > $pagerows){ //if the number of records will fill more than one page
//Calculatethe number of pages and round the result up to the nearest integer
$pages = ceil ($num_inactive_members/$pagerows);
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

// Table header.

echo '<div class="scroll"><table id="hortable" summary="List of members">
    <thead>
    	<tr>
		    <th scope="col">Activate</th>
                    <th scope="col">Deny</th>
            <th scope="col">Last Name</th>
            <th scope="col">First Name</th>
            <th scope="col">Email</th>
            <th scope="col">Institution</th>
			<th scope="col">Date Registered</th>
            
            
			
        </tr>
    </thead>
    <tbody>';
    	


// Fetch and print all the records:

foreach($inactive_members as $inactive_member) {
	echo '<tr>
	<td><a href="index.php?id=' . $inactive_member->get_id() . '">Activate</a></td>
	<td><a href="index.php?deny=1&id=' . $inactive_member->get_id() . '">Deny</a></td>
	<td>' . $inactive_member->get_lastname() . '</td>
	<td>' . $inactive_member->get_firstname() . '</td>
	<td>' . $inactive_member->get_uname() . '</td>
	<td>' . $inactive_member->get_institution() . '</td>
	<td>' . $inactive_member->get_dateregistered() . '</td>
	

	

	</tr>';
	}
	echo '</tbody></table></div>'; // Close the table.


$num_inactive_members = count($inactive_members);
echo "<p>Total unactivated members: $num_inactive_members</p>";
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


