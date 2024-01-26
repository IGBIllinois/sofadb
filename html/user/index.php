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
	if (isset($_POST['delsubmit'])) {
		$deleteid=$_POST['delid'];
		$del_case = new sofa_case($db, $deleteid);
		$result = $del_case->delete_case();
		if ($result['RESULT'] == FALSE)  {
			// If it did not run OK
			// Error message:
			echo '<h2>System Error</h2>
			<p class="error">Did not delete case. We apologize for any inconvenience.</p>'; 
        		exit();
		}
	}
}




//Declare which record to start with
$start = 0;
if (isset($_GET['start']) && is_numeric($_GET['start'])) {
    $start = $_GET['start'];
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
$pages_url = "index.php";
$pages_html = html::get_pages_html($pages_url,$num_cases,$start,PAGEROWS);
$startrecord = $start + 1;
$endrecord = $start + PAGEROWS;
if ($endrecord > $num_cases) {
	$endrecord = $num_cases;
}
$case_html = "";
// Fetch and print all the records:
if ($num_cases) {
	foreach($curr_cases as $case) {
		$case_html .= '<tr>';
		$case_html .= "<td><form method=post action='./editcase/index.php' name='editprofile' id='editprofile'>";
		$case_html .= "<input type=hidden name=caseid value='" . $case->get_id() . "'><input name='editsubmit' type='submit' value='Edit'></form></td>";
		$case_html .= "<td><form action='index.php' method='post' id='deletedata' ";
		$case_html .= "onsubmit=\"return confirm(\'This will permanently delete this case and all data associated with it.\nDo you really want to delete this case?\')\">";
		$case_html .= "<input name='delid' type='hidden' value='" . $case->get_id() ."'>";
		$case_html .= "<input name='delsubmit' type='submit' value='Delete'></form>";
		$case_html .= "</td>";
                
		if($case->get_submissionstatus() == 1) {
			$case_html .= "<td><form method=POST action=index.php>";
			$case_html .= "<input type=hidden name=id value='".$case->get_id()."'>";
        	        $case_html .= "<input type=hidden name=status value=0>";
			$case_html .= "<input type=submit value=Withdraw></form></td>";
		}
		else {
			$case_html .= "<td><form method=POST action=index.php>";
			$case_html .= "<input type=hidden name=id value='".$case->get_id()."'>";
			$case_html .= "<input type=hidden name=status value=1>";
			$case_html .= "<input type=submit value=Submit></form></td>";
	        }
        
		$case_html .= "<td>" . htmlentities($case->get_caseyear()) . "</td>";
		$case_html .= "<td>" . htmlentities($case->get_casenumber()) . "</td>";
		$case_html .= "<td>" . htmlentities($case->get_caseagency()) . "</td>";
		$case_html .= "<td>" . htmlentities($case->get_datemodified()) . "</td>";
		if ($case->get_datesubmitted() != null) {
			$case_html .= "<td>" . htmlentities($case->get_datesubmitted()) . "</td>";
		}
		else {
			$case_html .= "<td>&nbsp;</td>";
		}
		$case_html .= "</tr>";
	}
}

else {
	$case_html = "<td colspan='6'>No Cases</td>";
} 

?>

	<p class='dbresults'>You have <?php echo $member->get_num_unsubmitted_cases(); ?> unsubmitted cases. Showing records <?php echo $startrecord . " - " . $endrecord; ?></p>
<p class='dbresults'>Total number of cases: <?php echo $num_cases; ?>.</p>

<table id="hortable" summary="List of cases">
<thead><tr>
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
</tr></thead>
<tbody>

<?php echo $case_html; ?>
</tbody>
</table>
</div>
<?php echo $pages_html; ?>  
<?php
require_once("../include/footer.php");
?>
