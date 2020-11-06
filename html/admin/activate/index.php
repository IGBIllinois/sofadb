<?php
require_once("../../include/header_admin.php");

?>

  <div id="memberregion"> <h2 style="text-align:center">Activate Members</h2> 
  <?php 
// This script retrieves all the records from the users table.

if (isset($_POST['id'])) {
    $idactivate=intval($_POST['id']);

    if(isset($_POST['deny'])) {
        // decline this user
        $member = new member($db, $idactivate);
        $result = $member->set_permission('0');


    if($result['RESULT'] == FALSE) 
    {
        echo '<p class="error">Activation failed. We apologize for any inconvenience.</p>';

    } else {

        $to = $member->get_uname();
        $params = array("username"=>($member->get_firstname() . " " . $member->get_lastname()));
        $from_email = FROM_EMAIL;
        $subject = "FADAMA Membership Denied";
        $message = functions::renderTwigTemplate('email/request_denied.html.twig', $params);
        $header = "From:".$from_email."\r\n";

       $retval = mail ($to,$subject,$message,$header);

       if( $retval == true )  {

            echo "Email sent to ". $member->get_uname().".";

            // Delete user
            $curr_user = new member($db, $session->get_var('id'));
            $curr_user->delete_member($idactivate);
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

            $to = $member->get_uname();
            $from_email = FROM_EMAIL;
            $subject = "FADAMA Membership Approved";

            $params = array("url"=>($_SERVER['HTTP_HOST']. $_SERVER['CONTEXT_PREFIX']));
            $message = functions::renderTwigTemplate("email/request_approved.html.twig", $params);
            $header = "From:".$from_email."\r\n";
            $retval = mail ($to,$subject,$message,$header);

            if( $retval == true )  
            {
              echo "User activated. Activation email sent to ".$to;

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

$inactive_members = member::get_members_permission($db, 0);

// Has the total number of pages already been calculated?
if (isset($_POST['p']) && is_numeric ($_POST['p'])) { //already been calculated
    $pages=$_POST['p'];
} else { //use the next block of code to calculate the number of pages

    //First, check for the total number of records
    $num_inactive_members = count($inactive_members);

    //Now calculate the number of pages
    if ($num_inactive_members > $pagerows){ //if the number of records will fill more than one page
    //Calculate the number of pages and round the result up to the nearest integer
        $pages = ceil ($num_inactive_members/$pagerows);
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
        <td><form method=POST action=index.php name=activateform><input type=hidden name=id value='.$inactive_member->get_id().'><input type=submit name=activatesubmit value="Activate"></form></td>
	<td><a href="index.php?deny=1&id=' . $inactive_member->get_id() . '">Deny</a></td>
        <td><form method=POST action=index.php name=activateform><input type="hidden" name="deny" value="1"><input type=hidden name="id" value="'.$inactive_member->get_id().'"><input type=submit name=activatesubmit value="Deny"></form></td>

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
$current_page = ($start/$pagerows) + 1;

if ($current_page != 1) {
   // Create a Previous Link
    echo("<form method=post action=index.php name='regsubmit'>"
            . "<input type=submit value='Previous Page'>"
            . "<input type=hidden name='p' value=$pages>"
            . "<input type=hidden name='s' value=".($start-$pagerows).">"
            . "<input type=hidden name=querystring value='".$session->get_var('querystring')."'>"
            . "</form>");
} else {
    
}

if ($current_page != $pages) {
//Create a Next link
    echo("<form method=post action=index.php name='regsubmit'>"
            . "<input type=submit value='Next Page'>"
            . "<input type=hidden name='p' value=$pages>"
            . "<input type=hidden name='s' value=".($start+$pagerows).">"
            . "<input type=hidden name=querystring value='".$session->get_var('querystring')."'>"
            . "</form>");
} else {
}
?>

  </div>

</div>
<?php
    require_once("../../include/footer.php");
?>


