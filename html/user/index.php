<?php 
$title = "Forensic Anthropology Case Database (FADAMA) -  My Cases";
require_once('../include/header_user.php') ;

?>

  <div id="caseregion"> <h1 class="cntr">My Cases</h1>
  <?php 
// This script retrieves all the records from the users table.

//set the number of rows per display page
$pagerows = PAGEROWS;
$memberid=$session->get_var('id');
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


// Has the total number of pages already been calculated?
if (isset($_POST['p']) && is_numeric ($_POST['p'])) { //already been calculated
    $pages=$_POST['p'];
} else { //use the next block of code to calculate the number of pages
//First, check for the total number of records

    $records = count($all_members);

    //Now calculate the number of pages
    if ($records > $pagerows){ //if the number of records will fill more than one page
    //Calculate the number of pages and round the result up to the nearest integer
        $pages = ceil ($records/$pagerows);
    }else{
        $pages = 1;
    }

}//page check finished

//Declare which record to start with
if (isset($_POST['s']) && is_numeric($_POST['s'])) {//already been calculated
    $start = $_POST['s'];
}else{
    $start = 0;
}

if(isset($_POST['id']))
{
    // Add a new case
    $casesubid=$_POST['id'];
    $status=$_POST['status'];

    $this_case = new sofa_case($db, $casesubid);

    if($memberid != $this_case->get_memberid()) {
        echo("You do not have permission to submit this case.");
    } else {
        $result = $this_case->submit_case($status);
        echo($result['MESSAGE']);
    }

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
if ($current_page != 1) {
   // Create a Previous Link
    echo("<form class='inline' method=post action=index.php name='regsubmit'>"
            . "<input type=submit value='Previous Page'>"
            . "<input type=hidden name='p' value=$pages>"
            . "<input type=hidden name='s' value=".($start-$pagerows).">"
            . "<input type=hidden name=querystring value='".$session->get_var('querystring')."'>"
            . "</form>");
} else {
    
}

if ($current_page != $pages) {
//Create a Next link
    echo("<form class='inline' method=post action=index.php name='regsubmit'>"
            . "<input type=submit value='Next Page'>"
            . "<input type=hidden name='p' value=$pages>"
            . "<input type=hidden name='s' value=".($start+$pagerows).">"
            . "<input type=hidden name=querystring value='".$session->get_var('querystring')."'>"
            . "</form>");
} else {
}
}



echo '<div class="scroll"><table id="hortable" summary="List of cases">
    <thead>
    	<tr>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
            <th scope="col" width="12%">Submit
                <span class="tooltip"><img class="img-bottom" src="../images/tooltip.png">
                <span class="tooltiptext">When you "submit" your case data, it becomes part of FADAMA and accessible to all members. </span>
                </span>                          
            </th>
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
	
        echo('<td><form method=post action="./editcase/index.php" name=editprofile id=editprofile><input type=hidden name=caseid value=' . $case->get_id().'><input name=editsubmit type=submit value=Edit></form></td>'); 

        echo '<td>
	<form action="index.php" method="post" id="deletedata" onsubmit="return confirm(\'This will permanently delete this case and all data associated with it.\nDo you really want to delete this case?\')">
	<input name="delid" type="hidden" value="'.$case->get_id().'"/>
	<input name="delsubmit" type="submit" value="Delete" /> </form>
	</td>';
                
	if($case->get_submissionstatus()==1)
	{
            echo("<td>"
                    . "<form method=POST action=index.php>"
                    . "<input type=hidden name=id value='".$case->get_id()."'>"
                    . "<input type=hidden name=status value=0>"
                    . "<input type=submit value=Withdraw>"
                    . "</form>"
                    . "</td>");
	}
	else{
            echo("<td>"
                    . "<form method=POST action=index.php>"
                    . "<input type=hidden name=id value='".$case->get_id()."'>"
                    . "<input type=hidden name=status value=1>"
                    . "<input type=submit value=Submit>"
                    . "</form>"
                    . "</td>");
        }
        
	
	echo '<td>' . htmlentities($case->get_caseyear()) . '</td>
	<td>' . htmlentities($case->get_casenumber()) . '</td>
	<td>' . htmlentities($case->get_caseagency()) . '</td>
        <td>' . htmlentities($case->get_datemodified()) . '</td>
	<td>' . htmlentities($case->get_datesubmitted()) . '</td>
	
	

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
	} else {
		$startingrecord=0;
	}
	$endingrecord=$num_cases;
} elseif (
	$current_page!= $pages) {
	$startingrecord=($current_page-1)*$pagerows+1;
	$endingrecord=($current_page)*$pagerows;
} else {
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
    } else {
        
    }
//Create a Next link
    if ($current_page != $pages) {
        echo '<a href="index.php?s=' . ($start + $pagerows) . '&p=' . $pages . '">Next Page</a> ';
        echo '&nbsp; &nbsp; &nbsp; &nbsp;';
    } else {
        
    }
echo '</p>';
}

?>

    </div>
  
  
<?php
require_once("../include/footer.php");
?>