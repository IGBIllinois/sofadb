<?php 
require_once('../../include/header_user.php');
?>
  <div id="caseregion"> <h1 class="cntr">My Cases</h1>
  <?php 

$memberid=$_SESSION['id'];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

//delete case here, decrement total cases and numsubmitted from members. Remove from cases table by id, remove from membercasetable, remove methods from
if (isset($_POST['delsubmit']))
{
	$deleteid=$_POST['delid'];
	$q="UPDATE cases SET submissionstatus=-1 WHERE memberid=$memberid AND id=$deleteid";
	$result = mysqli_query ($dbcon, $q);
	  if (!$result) 
                { // If it ran OK.
                // If it did not run OK
				// Error message:
				echo '<h2>System Error</h2>
				<p class="error">Did not delete case. We apologize for any inconvenience.</p>'; 
				// Debugging message:
				echo '<p>' . mysqli_error($dbcon) . '<br/><br/>Query: ' . $q . '</p>';
                exit();
                }
}
}



// Has the total number of pagess already been calculated?
if (isset($_GET['p']) && is_numeric
($_GET['p'])) {//already been calculated
$pages=$_GET['p'];
}else{//use the next block of code to calculate the number of pages
//First, check for the total number of records
$q = "SELECT COUNT(id) FROM cases WHERE memberid=$memberid AND submissionstatus>=0";

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
$q = "SELECT id, casename, caseyear, casenumber, caseagency,submissionstatus,  DATE_FORMAT(datemodified, '%M %d, %Y') AS moddat, DATE_FORMAT(datesubmitted, '%M %d, %Y') AS subdat FROM cases WHERE memberid=$memberid AND submissionstatus>=0 ORDER BY datemodified DESC LIMIT $start, $pagerows";		

 

$result = @mysqli_query ($dbcon, $q); // Run the query.
$members = mysqli_num_rows($result);
if ($result) { // If it ran OK, display the records.
// Table header.

$q = "SELECT COUNT(id) FROM cases WHERE memberid=$memberid AND submissionstatus>=0";
$resultP = @mysqli_query ($dbcon, $q);
$row = @mysqli_fetch_array ($resultP, MYSQLI_NUM);
$cases = $row[0];

$current_page = ($start/$pagerows) + 1;
if ($pages==1)
{if ($cases>0){$startingrecord=1;}
else {$startingrecord=0;}
$endingrecord=$cases;}
elseif ($current_page!= $pages)
{$startingrecord=($current_page-1)*$pagerows+1;
$endingrecord=($current_page)*$pagerows;}
else
{$startingrecord=($current_page-1)*$pagerows+1;
$endingrecord=$cases;}



echo "<p class='dbresults'>Total number of cases: $cases. Showing records  $startingrecord - $endingrecord </p>";




if ($pages > 1) {
echo '<p>';
//What number is the current page?
$current_page = ($start/$pagerows) + 1;
//If the page is not the first page then create a Previous link
if ($current_page != 1) {
echo '<a href="index.php?s=' . ($start - $pagerows) . '&p=' . $pages . '">Previous Page</a> ';
}
//Create a Next link
if ($current_page != $pages) {
echo '<a href="index.php?s=' . ($start + $pagerows) . '&p=' . $pages . '">Next Page</a> ';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
}
echo '</p>';
}



echo '<div class="scroll"><table id="hortable" summary="List of cases">
    <thead>
    	<tr>
		    <th scope="col">View</th>
			<th scope="col">Delete</th>
			<th scope="col">Case Year</th>
			<th scope="col">Case Number</th>
            <th scope="col">Case Agency</th>
            <th scope="col">Date Modified</th>
			<th scope="col">Date Submitted</th>
           
			
        </tr>
    </thead>
    <tbody>';
    	


// Fetch and print all the records:
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	echo '<tr>
	<td><a href="../viewcase.php?id=' . $row['id'] . '">View</a></td>';
	
	echo '<td>
	<form action="index.php" method="post" id="deletedata" onsubmit="return confirm(\'Do you really want to delete this case?\')">
	<input name="delid" type="hidden" value="'.$row['id'].'"/>
	<input name="delsubmit" type="submit" value="Delete" /> </form>
	</td>';
	
	
	
	
	
	echo 
	'<td>' . $row['caseyear'] . '</td> 
	<td>' . $row['casenumber'] . '</td>
	<td>' . $row['caseagency'] . '</td>
    <td>' . $row['moddat'] . '</td>
	<td>' . $row['subdat'] . '</td>
	
	

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
$q = "SELECT COUNT(id) FROM cases WHERE memberid=$memberid AND submissionstatus>=0";
$result = @mysqli_query ($dbcon, $q);
$row = @mysqli_fetch_array ($result, MYSQLI_NUM);
$cases = $row[0];

$current_page = ($start/$pagerows) + 1;
if ($pages==1)
{if ($cases>0){$startingrecord=1;}
else {$startingrecord=0;}
$endingrecord=$cases;}
elseif ($current_page!= $pages)
{$startingrecord=($current_page-1)*$pagerows+1;
$endingrecord=($current_page)*$pagerows;}
else
{$startingrecord=($current_page-1)*$pagerows+1;
$endingrecord=$cases;}



echo "<p class='dbresults'>Total number of cases: $cases. Showing records  $startingrecord - $endingrecord </p>";




if ($pages > 1) {
echo '<p>';
//What number is the current page?
$current_page = ($start/$pagerows) + 1;
//If the page is not the first page then create a Previous link
if ($current_page != 1) {
echo '<a href="index.php?s=' . ($start - $pagerows) . '&p=' . $pages . '">Previous Page</a> ';
}
//Create a Next link
if ($current_page != $pages) {
echo '<a href="index.php?s=' . ($start + $pagerows) . '&p=' . $pages . '">Next Page</a> ';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
}
echo '</p>';
}

mysqli_close($dbcon); // Close the database connection.

require_once("../../include/footer.php");
?>
    
 
