<?php
require_once('../include/header_admin.php') ;
?>

  <div id="memberregion"> <h2 style="text-align:center">List of members</h2> 
  <?php 
// This script retrieves all the records from the users table.

//set the number of rows per display page
$pagerows = PAGEROWS;
$all_members = member::get_members($db);
$memberid=$_SESSION['id'];
$member = new member($db, $memberid);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


if (isset($_POST['delsubmit']))
{
    // Delete the user, and all associated case data
    $deleteid=$_POST['delid'];
    $del_member = new member($db, $deleteid);
    $user_email = $del_member->get_uname();
    $full_name = $del_member->get_firstname() . " ".$del_member->get_lastname();
    $result = $member->delete_member($deleteid);
    
    

      if ($result['RESULT'] == FALSE) 
        { 
        // If it did not run OK
        // Error message:
        echo '<h2>System Error</h2>
        <p class="error">Did not delete member. We apologize for any inconvenience.</p>'; 
        // Debugging message:
        echo '<p>' . $result['MESSAGE'] . '<br/><br/>:' . $result['MESSAGE'] . '</p>';
        exit();
        } else {
            echo($result['MESSAGE']);
        }
        
        // Send email
        
        $admin_email = ADMIN_EMAIL;
        $to = $user_email;
        $from = FROM_EMAIL;
        $params = array("full_name"=>$full_name);

       $subject = "SOFA DB ADMIN ALERT: Delete User Account";
       $message = functions::renderTwigTemplate('email/user_delete.html.twig', $params);

       $header = "From:".$from."\r\n";
       $retval = mail ($to,$subject,$message,$header);
       if( $retval == true )  
       {
          echo "Message sent successfully."; 

       }
       else
       {
          echo "Error: Message could not be sent.";
       }
} else if(isset($_POST['changeStatusSubmit'])) {
    
    $memberid = $_POST['user_id'];
    $status = $_POST['status'];
    $changemember = new member($db, $memberid);
    $changemember->set_permission($status);
}
}


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
            <th scope="col">Agree to TOS</th>
            <th scope="col">Access Type</th>
            <th scope="col">Total Cases</th>
            <th scope="col"></th>
			
        </tr>
    </thead>
    <tbody>';
    	


// Fetch and print all the records:
foreach($members as $member) {
    $status = $member->get_permissionstatus();
    $perm_status = "User";
    if($status == 0) {
        $perm_status = "Not yet registered";
    } else if($status == 2) {
        $perm_status = "Admin";
    }
	echo '<tr>
	<td><a href="./editprofile/index.php?edit_member_id=' . $member->get_id() . '">Edit</a></td>
	<td><form action="./index.php" method="post" id="deletemember" onsubmit="return confirm(\'Do you really want to delete this member?\nAll member data and cases associated with this user will be deleted.\')">
	<input name="delid" type="hidden" value="'.$member->get_id().'"/>
	<input name="delsubmit" type="submit" value="Delete" /> </form>
	</td>
	<td>' . $member->get_lastname() . '</td>
	<td>' . $member->get_firstname() . '</td>
	<td>' . $member->get_uname() . '</td>
	<td>' . $member->get_institution() . '</td>
	<td>' . $member->get_dateregistered() . '</td>
	<td>' . $member->get_lastlogin() . '</td>
        <td>' . ($member->get_agree_to_terms() ? "Yes" : "No") . '</td>
	<td>' . $perm_status . '</td>
	<td>' . $member->get_totalcases() . '</td>';
        echo("<td>");
        if($member->get_permissionstatus() == 2) {
            // Change to regular user
            $form = "<form action=index.php name=changestatus id=changestatus method=POST>"
                    . "<input type=hidden name='status' value='1'>"
                    . "<input type=hidden name='user_id' value='".$member->get_id()."'>"
                    . "<input type=submit name=changeStatusSubmit value='Make regular user'>"
                    . "</form>";    
            echo($form);
        } else if($member->get_permissionstatus() == 1) {
            // Change to admin
            $form = "<form action=index.php name=changestatus id=changestatus method=POST>"
                    . "<input type=hidden name='status' value='2'>"
                    . "<input type=hidden name='user_id' value='".$member->get_id()."'>"
                    . "<input type=submit name=changeStatusSubmit value='Make Admin'>"
                    . "</form>";   
            echo($form);
        }
        
	echo("</td>");

	echo('</tr>');
	}
	echo '</tbody></table></div>'; // Close the table.
} else { // If it did not run OK.
// Public message:
	echo '<p class="error">The current record could not be retrieved. We apologize for any inconvenience.</p>';
	// Debugging message:
	echo '<p>' . $db->errorInfo[2]. '<br></p>';
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
<?php
    require_once("../include/footer.php");
?>

