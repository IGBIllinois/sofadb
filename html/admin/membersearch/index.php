<?php

 require_once('../../include/header_admin.php') ;


?>

  <div id="memberregion"> <h2 style="text-align:center">Search List of Members</h2> 
 
 
  
  

<div name="searchresults">
 <?php 
  $error=0;
  
  if (isset($_GET['search']))
  {unset($_SESSION['searched']);}
  $params = array();
  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	  
	 
	 	if (!empty($_GET['mID'])) 
		{
		//$searchstring="id=".mysqli_real_escape_string($dbcon, trim($_GET['mID']));
		$fmID=$_GET['mID'];
                $params['mID'] = "%".$fmID."%";
                $searchstring=" id=:mid ";
		} 
	else {//else mID
		$first=0;
	
	
	
	
		if (!empty($_GET['fname'])) 
		{
			$first=1;
		    $searchstring=" firstname LIKE :fname ";
			
			$ffname=$_GET['fname'];
                        $params['fname'] = "%".$ffname."%";
			
		}
	
	
	if (!empty($_GET['lname'])) 
		{
			$flname=$_GET['lname'];
			$params['lname'] = "%".$flname."%";
			if ($first==0) {
                            $first=1;
                            $searchstring="lastname LIKE :lname";
                            
                        } else {
				if ($_GET['andor']==1) {
                                    $searchstring=$searchstring ." AND lastname LIKE :lname";
                                    
                                } else {
                                    $searchstring=$searchstring ." OR lastname LIKE :lname";}
				
				}
			}
		
		if (!empty($_GET['email'])) 
		{
                    $email = $_GET['email'];
                    $params['email'] = "%".$email."%";
			if ($first==0){
                            $first=1;
                            $searchstring=" uname LIKE :email ";}
			else{
				if ($_GET['andor']==1)
				{
                                    $searchstring=$searchstring ." AND uname LIKE :email";}
				else{
                                    $searchstring=$searchstring ." OR uname LIKE :email";}
				
				}
			}
		
		
		if (!empty($_GET['institution'])) 
		{
                    $institution = $_GET['institution'];
                    $params['institution'] = "%".$institution."%";
			if ($first==0)
			{
                            $first=1;
                            
                        $searchstring=" institution LIKE :institution ";}
			else{
				if ($_GET['andor']==1)
				{$searchstring=$searchstring ." AND institution LIKE :institution ";}
				else{$searchstring=$searchstring ." OR institution LIKE :institution ";}
				
				}
			}
	
	
	if (!empty($_GET['region'])) 
		{
                    $region = $_GET['region'];
                    $params['region'] = "%".$region."%";
			if ($first==0)
			{$first=1;
		    $searchstring="region= :region " ;
                    
                        }
			else{
				if ($_GET['andor']==1)
				{$searchstring=$searchstring ." AND region=:region " ;}
				else{
                                    $searchstring=$searchstring ." OR region= :region ";
                                }
				
				}
			}
	
	if ($first==0)
	{echo 'Please enter at least one search criterion';$error=1;}
	  
	}//end of mID else
	  
if(!$error){//if error start	  
// This script retrieves all the records from the users table.
 // Connect to the database.
//set the number of rows per display page
$pagerows = PAGEROWS;

// Has the total number of pagess already been calculated?
if (isset($_GET['p']) && is_numeric
($_GET['p'])) {//already been calculated
$pages=$_GET['p'];
}else{//use the next block of code to calculate the number of pages
//First, check for the total number of records
//$q = "SELECT COUNT(id) FROM members WHERE $searchstring";
    
$query = "SELECT * from members WHERE $searchstring ";

$found_members = member::search_members($db, $query, $params);
$num_members = count($found_members);

//Now calculate the number of pages
if ($num_members > $pagerows){ //if the number of records will fill more than one page
//Calculatethe number of pages and round the result up to the nearest integer
$pages = ceil ($num_members/$pagerows);
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
//while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
foreach($found_members as $found_member) {
	echo '<tr>
	<td><a href="edit_record.php?id=' . $found_member->get_id() . '">Edit</a></td>
	<td><a href="delete_record.php?id=' . $found_member->get_id() . '">Delete</a></td>
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
		$_SESSION['searched']=1;
unset($_GET['search']);
echo '<br/> <a href="index.php?search=1">Search Again</a>';
exit();
} // End of if ($result). Now display the total number of records/members.

echo "<p>Total number of search results: $num_members</p>";
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
$_SESSION['searched']=1;
unset($_GET['search']);
echo '<br/> <a href="index.php?search=1">Search Again</a>';
  }//end on error
  }//end main submit
?>





 </div>

<div id="registerform">

<?php 

if(!isset($fmID)) $fmID="";
if(!isset($ffname)) $ffname="";
if(!isset($flname)) $flname="";
if(!isset($finstitution)) $finstitution="";
if(!isset($femail)) $femail="";

if (!isset($_SESSION['searched']))
{
echo <<<_END
<form action="index.php" method="get" id="registration">


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
} ?>


  
  
  
  </div>





 </div>
<div id="footer">Copyright 2014 by <a href="http://www.sofainc.org/" target="_blank">SOFA</a>.</div>
</div>




</body>
</html>
