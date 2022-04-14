<?php
require_once('../include/header_admin.php') ;
?>

  <div id="memberregion"> <h2 style="text-align:center">List of members</h2> 
  <?php 
// This script retrieves all the records from the users table.

//set the number of rows per display page
$pagerows = PAGEROWS;
$all_members = member::get_members($db);
$memberid=$session->get_var('id');
$member = new member($db, $memberid);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    if (isset($_POST['delsubmit']))
    {
        if(!isset($_POST['delid'])) {
            echo("Please select a member to delete.");
        } else {
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
           $txt_message = functions::renderTwigTemplate('email/user_delete.txt.twig', $params);
           $html_message = functions::renderTwigTemplate('email/user_delete.html.twig', $params);

           $retval = $emailer->send_email($from, $subject, $txt_message, $html_message);
           if( $retval == true )  
           {
              echo "Message sent successfully."; 

           }
           else
           {
              echo "Error: Message could not be sent.";
           }
        }
    } else if(isset($_POST['changeStatusSubmit'])) {
        
        if(!isset($_POST['user_id'])) {
            echo("Please select a member to delete.<BR>");
        } else if(!isset($_POST['delid'])) {
            echo("Please select a proper status to change to.<BR>");
        } else {
            $memberid = $_POST['user_id'];
            $status = $_POST['status'];
            $changemember = new member($db, $memberid);
            $changemember->set_permission($status);
        }
    } else {
        // Nothing posted
    }
} else {
    // Not posted
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
    if($status == member::PERMISSION_UNVERIFIED) {
        $perm_status = "Email not yet verified";
    }else if($status == member::PERMISSION_USER) {
        $perm_status = "User";
    }else if($status == member::PERMISSION_REQUESTED) {
        $perm_status = "Not yet registered";
    } else if($status == member::PERMISSION_ADMIN) {
        $perm_status = "Admin";
    } else {
        $perm_status = "Unknown";
    }
	echo '<tr>
        <td><form method=post action="./editprofile/index.php" name=editprofile id=editprofile><input type=hidden name=edit_member_id value=' . $member->get_id().'><input name=editsubmit type=submit value=Edit></form></td>    
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
        if($member->get_permissionstatus() == member::PERMISSION_ADMIN) {
            // Change to regular user
            $form = "<form action=index.php name=changestatus id=changestatus method=POST>"
                    . "<input type=hidden name='status' value='1'>"
                    . "<input type=hidden name='user_id' value='".$member->get_id()."'>"
                    . "<input type=submit name=changeStatusSubmit value='Make regular user'>"
                    . "</form>";    
            echo($form);
        } else if($member->get_permissionstatus() == member::PERMISSION_USER) {
            // Change to admin
            $form = "<form action=index.php name=changestatus id=changestatus method=POST>"
                    . "<input type=hidden name='status' value='2'>"
                    . "<input type=hidden name='user_id' value='".$member->get_id()."'>"
                    . "<input type=submit name=changeStatusSubmit value='Make Admin'>"
                    . "</form>";   
            echo($form);
        } else {
            
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
} 

$total_members = count($all_members);

echo "<p>Total membership: $total_members</p>";
$current_page = ($start/$pagerows) + 1;

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

if ($pages > 1) {
    echo '<p>';
    echo '</p>';
} else {
    
}
?>

  </div>

</div>
<?php
    require_once("../include/footer.php");
?>

