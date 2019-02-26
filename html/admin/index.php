<?php
//require_once('../include/session_admin.php') ;
require_once('../include/header_admin.php') ;
?>

  <div id="memberregion"> <h2 style="text-align:center">List of members</h2> 
  <?php 
// This script retrieves all the records from the users table.

//set the number of rows per display page
$pagerows = PAGEROWS;
$all_members = member::get_members($db);

// Has the total number of pages already been calculated?
if (isset($_GET['p']) && is_numeric ($_GET['p'])) { //already been calculated
$pages=$_GET['p'];
} else { //use the next block of code to calculate the number of pages
//First, check for the total number of records

$records = count($all_members);

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
$q = "SELECT lastname, firstname, uname, institution, DATE_FORMAT(dateregistered, '%M %d, %Y') AS regdat, DATE_FORMAT(lastlogin, '%M %d, %Y') AS logdat, permissionstatus, id, totalcases FROM members ORDER BY dateregistered DESC LIMIT $start, $pagerows";		

$all_members = member::get_members($db);
$members = member::get_members($db, $start, $pagerows);
$total_members = count($all_members);


if (count($members)>0)  { // If it ran OK, display the records.
// Table header.





echo '<div class="scroll"><table id="hortable" summary="List of members">
    <thead>
    	<tr>
		    <th scope="col">Edit</th>
            <th scope="col">Delete</th>
        	<th scope="col">Last Name</th>
            <th scope="col">First Name</th>
            <th scope="col">Email</th>
            <th scope="col">Institution</th>
			<th scope="col">Date Registered</th>
            <th scope="col">Last Login</th>
            <th scope="col">Access</th>
            <th scope="col">Total Cases</th>
			
        </tr>
    </thead>
    <tbody>';
    	


// Fetch and print all the records:
foreach($members as $member) {
	echo '<tr>
	<td><a href="edit_record.php?id=' . $member->get_id() . '">Edit</a></td>
	<td><a href="delete_record.php?id=' . $member->get_id() . '">Delete</a></td>
	<td>' . $member->get_lastname() . '</td>
	<td>' . $member->get_firstname() . '</td>
	<td>' . $member->get_uname() . '</td>
	<td>' . $member->get_institution() . '</td>
	<td>' . $member->get_dateregistered() . '</td>
	<td>' . $member->get_lastlogin() . '</td>
	<td>' . $member->get_permissionstatus() . '</td>
	<td>' . $member->get_totalcases() . '</td>
	

	</tr>';
	}
	echo '</tbody></table></div>'; // Close the table.
} else { // If it did not run OK.
// Public message:
	echo '<p class="error">The current record could not be retrieved. We apologize for any inconvenience.</p>';
	// Debugging message:
	echo '<p>' . $db->errorInfo[2]. '<br><br>Query: ' . $q . '</p>';
} // End of if ($result). Now display the total number of records/members.

$total_members = count($all_members);

echo "<p>Total membership: $total_members</p>";
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

