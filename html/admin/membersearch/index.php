<?php

 require_once('../../include/header_admin.php') ;


?>

  <div id="memberregion"> <h2 style="text-align:center">Search List of Members</h2> 
 
 
  
  

<div name="searchresults">
 <?php 

$id=null;
$first_name = null;
$last_name = null;
$email = null;
$institution = null;
$region = null;
$andor = " AND ";

  $error=0;

  $params = array();
 

if ($_SERVER['REQUEST_METHOD'] == 'POST'  ) {
      // new params
      $search_values = array();

    $id = (empty($_POST['mID']) ? null : $_POST['mID']);
    $first_name = (empty($_POST['fname']) ? null : $_POST['fname']);
    $last_name = (empty($_POST['lname']) ? null : $_POST['lname']);
    $email = (empty($_POST['email']) ? null : $_POST['email']);
    $institution = (empty($_POST['institution']) ? null : $_POST['institution']);
    $region = (empty($_POST['region']) ? null : $_POST['region']);
    $andor = ($_POST['andor'] == 1) ? " AND " : " OR ";

    if ($id == null &&
            $first_name == null &&
            $last_name == null &&
            $email == null &&
            $institution == null &&
            $region == null)
    {
        echo 'Please enter at least one search criterion';
        $error=1;

    }
	  
	  
if(!$error){//if error start	  
// This script retrieves all the records from the users table.

    $found_members = member::search_members($db, $id, $first_name, $last_name, $email, $institution, $region, $andor);
    $num_members = count($found_members);
    //set the number of rows per display page
    $pagerows = PAGEROWS;

    // Has the total number of pages already been calculated?
    if (isset($_POST['p']) && is_numeric ($_POST['p'])) { //already been calculated
        $pages=$_POST['p'];
    } else { //use the next block of code to calculate the number of pages
        //First, check for the total number of records
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


// Make the query:

if ($num_members > -1) { // If it ran OK, display the records.
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
foreach($found_members as $found_member) {
	echo '<tr>
        <td><form method=post action="../editprofile/index.php" name=editprofile id=editprofile><input type=hidden name=edit_member_id value=' . $found_member->get_id().'><input name=editsubmit type=submit value=Edit></form></td>
	<td><form action="../index.php" method="post" id="deletemember" onsubmit="return confirm(\'Do you really want to delete this member?\nAll member data and cases associated with this user will be deleted.\')">
	<input name="delid" type="hidden" value="'.$found_member->get_id().'"/>
	<input name="delsubmit" type="submit" value="Delete" /> </form>
	</td>
	<td>' . $found_member->get_lastname() . '</td>
	<td>' . $found_member->get_firstname(). '</td>
	<td>' . $found_member->get_uname() . '</td>
	<td>' . $found_member->get_institution(). '</td>
	<td>' . $found_member->get_dateregistered() . '</td>
	<td>' . $found_member->get_lastlogin() . '</td>
	<td>' . $found_member->get_permissionstatus(). '</td>
	<td>' . $found_member->get_totalcases() . '</td>
	

	</tr>';
	}
	echo '</tbody></table></div>'; // Close the table.
} else { // If it did not run OK.
// Public message:
	echo '<p class="error">No records found.  </p>';
	// Debugging message:
	$session->set_session_variable('searched', 1);

        echo '<br/> <a href="index.php?search=1">Search Again</a>';
        exit();
} // End of if ($result). Now display the total number of records/members.

echo "<p>Total number of search results: $num_members</p>";
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
$session->set_session_variable('searched', 1);

echo '<br/> <a href="index.php?search=1">Search Again</a>';
  }//end on error
}


?>





 </div>

<div id="registerform">

<?php 

if(!isset($fmID)) $fmID="";
if(!isset($ffname)) $ffname="";
if(!isset($flname)) $flname="";
if(!isset($finstitution)) $finstitution="";
if(!isset($femail)) $femail="";


$result = $session->get_var('searched');

if( $result == false || $result != 1)
{
echo <<<_END
<form action="index.php" method="post" id="registration">


<fieldset style="border: solid 2px #cc0000;overflow: hidden;" class="roundedborder">


<fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend>Search By Member ID</legend>
<br><label class="label" for="mID">Member ID</label><input id="mID" type="text" name="mID" size="3" maxlength="5" value="$fmID">

</fieldset>

<fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend>Search By Identification Information</legend>




	<br><label class="label" for="fname">First Name</label><input id="fname" type="text" name="fname" size="30" maxlength="30" value="$ffname">
	<br>
  
    <label class="label" for="lname">Last Name</label><input id="lname" type="text" name="lname" size="30" maxlength="40" value="$flname">
    
    
	<br> 
    <label class="label" for="email">Email Address</label><input id="email" type="text" name="email" size="30" maxlength="60" value="$femail" >
    
    <br/> <label class="label" for="institution">Institution</label><input id="institution" type="text" name="institution" size="30" maxlength="60" value="$finstitution" > 
 
   
             
        
           <br>
           
           
           <label class="label" for="region">Region of Practice</label>
	<select name="region">
	<option value="">- Select -</option>
	<option value="1">Northeast</option>
	<option value="2">West</option>
	<option value="3">Midwest</option>
	<option value="4">South</option>
	</select>
    
     
	
	</select>
 
 </fieldset>
	
   
   
           
           
    
    
           
	
	
<br />	<br /> 
<label class="label" for="searchtype">Type of search:</label>
  <select name="andor">
	<option value="1">And</option>
	<option value="2">Or</option></select>

<label class="label" for="regsubmit">Click here to search</label>
   <input name="regsubmit" id="regsubmit" type="submit" value="Search"/>
   <div id="registration_errorloc" class="errorlocation">
            </div>
   
    </fieldset>

</form>

<script language="JavaScript" type="text/javascript"
    xml:space="preserve">//<![CDATA[
//You should create the validator only after the definition of the HTML form
  var frmvalidator  = new Validator("registration");
  
 frmvalidator.EnableOnPageErrorDisplaySingleBox();
  frmvalidator.EnableMsgsTogether();
 
 
 // frmvalidator.addValidation("fname","req","Please enter your First Name");
 // frmvalidator.addValidation("fname","maxlen=20",	"Max length for FirstName is 20");
 // frmvalidator.addValidation("fname","alpha","Alphabetic chars only");
  
  //frmvalidator.addValidation("email","email");
  
   
   //frmvalidator.addValidation("pcode","numeric","Zip code must be a number");
    
//]]></script>





_END;
} 


?>


  
  
  
  </div>





 </div>
<?php
    require_once("../../include/footer.php");
?>


