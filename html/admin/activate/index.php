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

    $to = $member->get_uname();
    $params = array("username"=>($member->get_firstname() . " " . $member->get_lastname()));
    $from_email = FROM_EMAIL;
    $subject = "FADAMA Membership Denied";
    $message = functions::renderTwigTemplate('email/request_denied.html.twig', $params);
    $header = "From:".$from_email."\r\n";

   $retval = mail ($to,$subject,$message,$header);

   if( $retval == true )  
   {
     
	echo "Email sent to ". $member->get_uname().".";
        
        // Delete user
        $curr_user = new member($db, $_SESSION['id']);
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
//Declare which record to start with
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
<?php
    require_once("../../include/footer.php");
?>


