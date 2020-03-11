<?php 
require_once('../include/header_user.php') ;

?>
    
  <div id="caseregion"> <h1 class="cntr">My Cases</h1>
  <?php 
// This script retrieves all the records from the users table.

//set the number of rows per display page
$pagerows = PAGEROWS;
$memberid=$_SESSION['id'];
$member = new member($db, $memberid);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

//delete case here, decrement total cases and numsubmitted from members. Remove from cases table by id, remove from membercasetable, remove methods from
if (isset($_POST['delsubmit']))
{
    $deleteid=$_POST['delid'];
    $del_case = new sofa_case($db, $deleteid);
    $result = $del_case->delete_case();

      if ($result['RESULT'] == FALSE) 
        { 
        // If it did not run OK
                        // Error message:
                        echo '<h2>System Error</h2>
                        <p class="error">Did not delete case. We apologize for any inconvenience.</p>'; 
                        // Debugging message:
                        echo '<p>' . $db->errorInfo[2] . '<br/><br/>Query: ' . $q . '</p>';
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

$all_cases = sofa_case::get_member_cases($db, $memberid);
$records = count($all_cases);
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

if(isset($_GET['id']))
{
	$casesubid=$_GET['id'];
	$status=$_GET['status'];
	
	$this_case = new sofa_case($db, $casesubid);
	
        $this_case->submit_case($status);
        


unset($_GET['id']);
unset($_GET['status']);

header('Location: ' . './index.php');exit();
}

$total_cases = sofa_case::get_member_cases($db, $memberid);
$curr_cases = sofa_case::get_member_cases($db, $memberid, $start, $pagerows); 
$num_cases = count($total_cases);

if ($num_cases >= 0) { // If it ran OK, display the records.
// Table header.



$current_page = ($start/$pagerows) + 1;
if ($pages==1) {
	if ($num_cases>0){
		$startingrecord=1;
	}
	else {
		$startingrecord=0;
	}
	$endingrecord=$num_cases;
}
elseif (
	$current_page!= $pages) {
	$startingrecord=($current_page-1)*$pagerows+1;
	$endingrecord=($current_page)*$pagerows;
}
else {
	$startingrecord=($current_page-1)*$pagerows+1;
	$endingrecord=$num_cases;
}



echo "<p class='dbresults'>Total number of cases: $num_cases. Showing records  $startingrecord - $endingrecord </p>";
echo("<p class='dbresults'>You have ".$member->get_num_unsubmitted_cases(). " unsubmitted cases.</p>");
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
			<th scope="col">Edit</th>
                        <th scope="col">Delete</th>
			<th scope="col">Submit</th>
			<th scope="col">Case Year</th>
            <th scope="col">Case Number</th>
            <th scope="col">Case Agency</th>
            <th scope="col">Date Modified</th>
			<th scope="col">Date Submitted to FADAMA</th>
           
			
        </tr>
    </thead>
    <tbody>';
    	


// Fetch and print all the records:
foreach($curr_cases as $case) {
	echo '<tr>';
	
	echo '<td><a href="./editcase/index.php?id=' . $case->get_id()  . '">Edit</a></td>';
        //<BR>(<a href="./editcase/index_v2.php?id=' . $case->get_id()  . '">Edit_v2</a>)</td>';

        echo '<td>
	<form action="index.php" method="post" id="deletedata" onsubmit="return confirm(\'This will permanently delete this case and all data associated with it.\nDo you really want to delete this case?\')">
	<input name="delid" type="hidden" value="'.$case->get_id().'"/>
	<input name="delsubmit" type="submit" value="Delete" /> </form>
	</td>';
                
	if($case->get_submissionstatus()==1)
	{
	echo '<td><a href="./index.php?id=' . $case->get_id() . '&status=0">Withdraw</a></td>';
	}
	else{echo '<td><a href="./index.php?id=' . $case->get_id() . '&status=1">Submit</a></td>';}
	
	echo '<td>' . $case->get_caseyear() . '</td>
	<td>' . $case->get_casenumber() . '</td>
	<td>' . $case->get_caseagency() . '</td>
        <td>' . $case->get_datemodified() . '</td>
	<td>' . $case->get_datesubmitted() . '</td>
	
	

	</tr>';
	}
	echo '</tbody></table></div>'; // Close the table.
} else { // If it did not run OK.
// Public message:
	echo '<p class="error">The current record could not be retrieved. We apologize for any inconvenience.</p>';
	// Debugging message:
	echo '<p>' . $db->error_info()[2] . '<br><br>' .  '</p>';
} // End of if ($result). Now display the total number of records/members.


$current_page = ($start/$pagerows) + 1;
if ($pages==1) {
	if ($num_cases>0){
		$startingrecord=1;
	}
	else {
		$startingrecord=0;
	}
	$endingrecord=$num_cases;
}
elseif (
	$current_page!= $pages) {
	$startingrecord=($current_page-1)*$pagerows+1;
	$endingrecord=($current_page)*$pagerows;
}
else {
	$startingrecord=($current_page-1)*$pagerows+1;
	$endingrecord=$num_cases;
}

echo "<p class='dbresults'>Total number of cases: $num_cases. Showing records  $startingrecord - $endingrecord </p>";
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

?>

    </div>
  
  
<?php
require_once("../include/footer.php");
?>