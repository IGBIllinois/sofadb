<?php

 require('../../include/session_user.php') ;


?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">



<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Case Database Search</title>
<link href="../../css/styleTemplateMod.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <script type='text/javascript' src='gen_validatorv4.js'></script>




<!-- // Load Javascipt -->
</head>

<body>
<div id="top">
<div id="header"><a href="http://www.sofainc.org" target="_blank"><img src="../../images/customLogo.gif" width="351" height="147" alt="SOFA"/></a></div>

<div id="title">
<h1>Forensic Case Database</h1>
</div>

<div id="hline">
<hr size="3" />
</div>

<div id="navbar">
  <ul>
    <li><a href="../../">Home</a></li>
    <li><a href="../index.php">My Cases</a></li>
    <li><a href="../../logout.php">Logout</a></li>
    <li><a href="../../contact/">Contact Us</a></li>
  </ul>
</div>

<div id="hline">
<hr size="3" />
</div>

<div id="templatecontainer"> 
  </br>
  <h1 class="cntr">Search Cases</h1>
  
  <div class="navigation">

        <ul class="menu">
        
        <li><a class="active" href="../"><svg class="home" width="30px" height="30px" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><path d="M419.492,275.815v166.213H300.725v-90.33h-89.451v90.33H92.507V275.815H50L256,69.972l206,205.844H419.492 z M394.072,88.472h-47.917v38.311l47.917,48.023V88.472z"/></svg><span title="Home">My Cases</span></a></li>
        
        <li><a href="../addcase/"><svg class="contact" width="30px" height="30px" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 30 30" enable-background="new 0 0 30 30" xml:space="preserve"><path d="M11.8,8.3h-1.8V6.5c0-0.7,0.6-1.2,1.2-1.2h7.4c0.7,0,1.2,0.6,1.2,1.2v1.8h-1.8v-1c0-0.2-0.2-0.4-0.4-0.4h-5.5c-0.2,0-0.4,0.2-0.4,0.4C11.8,7.3,11.8,8.3,11.8,8.3z"/>

<rect x="2.9" y="9.4" width="24.1" height="15.3"/>

<text transform="matrix(1 0 0 1 11.5 20.375)" fill="#FFFFFF" font-family="'MyriadPro-Regular'" font-size="12">+</text></svg><span title="About">Add Case</span></a></li>

<li>
<a href="../deletecase/">
<svg class="work" width="30px" height="30px" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 30 30" enable-background="new 0 0 30 30" xml:space="preserve"><path d="M11.8,8.3h-1.8V6.5c0-0.7,0.6-1.2,1.2-1.2h7.4c0.7,0,1.2,0.6,1.2,1.2v1.8h-1.8v-1c0-0.2-0.2-0.4-0.4-0.4h-5.5c-0.2,0-0.4,0.2-0.4,0.4C11.8,7.3,11.8,8.3,11.8,8.3z"/>
<rect x="2.9" y="9.4" width="24.1" height="15.3"/>
<text transform="matrix(1 0 0 1 12.5 22.375)" fill="#FFFFFF" font-family="'MyriadPro-Regular'" font-size="18">-</text></svg><span title="Work">Delete</span></a></li>

<li><a href="./?search=1">
<svg class="search" width="30px" height="30px" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 30 30" enable-background="new 0 0 30 30" xml:space="preserve"><path d="M11.8,8.3h-1.8V6.5c0-0.7,0.6-1.2,1.2-1.2h7.4c0.7,0,1.2,0.6,1.2,1.2v1.8h-1.8v-1c0-0.2-0.2-0.4-0.4-0.4h-5.5c-0.2,0-0.4,0.2-0.4,0.4C11.8,7.3,11.8,8.3,11.8,8.3z"/>

<rect x="2.9" y="9.4" width="24.1" height="15.3"/>

<text transform="matrix(1 0 0 1 12.5 22.375)" fill="#FFFFFF" font-family="'MyriadPro-Regular'" font-size="14">?</text></svg><span title="Work">Search</span></a></li>



<li><a href="../editprofile/"><svg class="about" width="30px" height="30px" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><path d="M407.448,360.474c-59.036-13.617-113.989-25.541-87.375-75.717 c81.01-152.729,21.473-234.406-64.072-234.406c-87.231,0-145.303,84.812-64.072,234.406c27.412,50.482-29.608,62.393-87.375,75.717 c-59.012,13.609-54.473,44.723-54.473,101.176h411.838C461.919,405.196,466.458,374.083,407.448,360.474z"/></svg><span title="About">Profile</span></a></li>



<li><a href="../../logout.php"><svg class="lab" width="30px" height="30px" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="202 16 539 524" enable-background="new 202 16 539 524" xml:space="preserve"><g>

	<path d="M586.9,508.9H311.5c-43.2,0-81-37.8-81-81V128.2c0-45.9,37.8-81,81-81h275.4c45.9,0,81,35.1,81,81v299.7C667.9,471.1,632.8,508.9,586.9,508.9z"/>

	<path fill="#000000" d="M667.8,376.2c-32.3,44.3-85.5,73.3-145.7,73.3c-98.4,0-178.2-77.4-178.2-172.8s79.8-172.8,178.2-172.8c60.1,0,113.2,28.8,145.5,73"/>

	<polygon  points="406,230.8 406,344.2 546.4,344.2 546.4,419.8 727.3,287.5 568,155.2 568,225.4 	"/>

</g></svg><span title="Lab">Logout</span></a></li>
</ul>


    </div>


 <div id="searchregion"> 
 
 
  
  

<div name="searchresults">
 <?php 
  
  
  $error=0;
  
  if (isset($_GET['search']))
  {unset($_SESSION['searched']);
  unset($_SESSION['searchstring']);}
  
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	  
       require('exportdata.php');
  }
		  
	  if ($_SERVER['REQUEST_METHOD'] == 'GET'){//not export
	  $first=0;
	 require_once($_SERVER['DOCUMENT_ROOT'].'/mysqli_connect.php');
	 
	 	if (!empty($_GET['mID'])) 
		{
		$searchstring="memberid=".mysqli_real_escape_string($dbcon, trim($_GET['mID']));
		$fmID=$_GET['mID'];
		$first=1;
		} 
	
	
	
	
	
		if (!empty($_GET['cyear'])) 
		{
			if($_GET['yearrange']==1){$yearstring = ">=";}
			elseif($_GET['yearrange']==2){$yearstring = "<=";}
			else{$yearstring = "=";}
			
			$fyear=$_GET['cyear'];
			if($first==0)
			{
			$first=1;
		    $searchstring="caseyear ".$yearstring." ".mysqli_real_escape_string($dbcon, trim($_GET['cyear'])) ." ";}
			else{
				if ($_GET['andor']==1)
				{$searchstring=$searchstring ." AND caseyear".$yearstring." ".mysqli_real_escape_string($dbcon, trim($_GET['cyear'])) ." ";}
				else{ $searchstring=$searchstring ." OR caseyear".$yearstring." ".mysqli_real_escape_string($dbcon, trim($_GET['cyear'])) ." ";}
				
				
				}
			
			
			
		}
	
	
	if (!empty($_GET['cnum'])) 
		{
			$fnum=$_GET['cnum'];
			
			if ($first==0)
			{$first=1;
		    $searchstring="casenumber LIKE '%".mysqli_real_escape_string($dbcon, trim($_GET['cnum'])) ."%'";}
			else{
				if ($_GET['andor']==1)
				{$searchstring=$searchstring ." AND casenumber LIKE '%".mysqli_real_escape_string($dbcon, trim($_GET['cnum'])) ."%'";}
				else{$searchstring=$searchstring ." OR casenumber LIKE '%".mysqli_real_escape_string($dbcon, trim($_GET['cnum'])) ."%'";}
				
				}
			}
		
		if (!empty($_GET['cagency'])) 
		{
			$fagency=$_GET['cagency'];
			
			if ($first==0)
			{$first=1;
		    $searchstring="caseagency LIKE '%".mysqli_real_escape_string($dbcon, trim($_GET['cagency'])) ."%'";}
			else{
				if ($_GET['andor']==1)
				{$searchstring=$searchstring ." AND caseagency LIKE '%".mysqli_real_escape_string($dbcon, trim($_GET['cagency'])) ."%'";}
				else{$searchstring=$searchstring ." OR caseagency LIKE '%".mysqli_real_escape_string($dbcon, trim($_GET['cagency'])) ."%'";}
				
				}
			}
		
		
		
	
	
	if (!empty($_GET['region'])) 
		{
			if ($first==0)
			{$first=1;
		    $searchstring="members.region=".mysqli_real_escape_string($dbcon, trim($_GET['region'])) ;
		}
			else{
				if ($_GET['andor']==1)
				{$searchstring=$searchstring ." AND members.region=".mysqli_real_escape_string($dbcon, trim($_GET['region']));}
				else{$searchstring=$searchstring ." OR members.region=".mysqli_real_escape_string($dbcon, trim($_GET['region']));}
				
				}
			}
	
	if ($first==0 )
	{echo 'Please enter at least one search criterion';$error=1;}
	  
	
	  
if(!$error){//if error start	  
// This script retrieves all the records from the users table.
 // Connect to the database.
//set the number of rows per display page
$pagerows = 20;

// Has the total number of pagess already been calculated?
if (isset($_GET['p']) && is_numeric
($_GET['p'])) {//already been calculated
$pages=$_GET['p'];
}else{//use the next block of code to calculate the number of pages
//First, check for the total number of records
$q = "SELECT COUNT(memberid) FROM cases WHERE ($searchstring) AND submissionstatus=1";

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
// Make the query: THIS SQL statement is messed up
$q = "SELECT cases.id AS id, casenumber, caseyear, caseagency, memberid, DATE_FORMAT(datesubmitted, '%M %d, %Y') AS subdat FROM cases, members WHERE members.id=cases.memberid AND ($searchstring) AND submissionstatus=1 ORDER BY caseyear ASC LIMIT $start, $pagerows";		

 

$result = @mysqli_query ($dbcon, $q); // Run the query.
$members = mysqli_num_rows($result);


//This sql statement is messed up, it doesn't work when region is part of the search string
$q="SELECT regions.name FROM cases, members, regions WHERE regions.id=members.region AND members.id=cases.memberid AND ($searchstring) AND cases.submissionstatus=1 ORDER BY cases.caseyear ASC";
$regionresult=@mysqli_query ($dbcon, $q);
$regrows=mysqli_num_rows($regionresult);


if ($result && $members && $regionresult && $regrows) { // If it ran OK, display the records.
// Table header.

$q = "SELECT COUNT(memberid) FROM cases WHERE ($searchstring) AND submissionstatus=1";
$resultP = @mysqli_query ($dbcon, $q);
$row = @mysqli_fetch_array ($resultP, MYSQLI_NUM);
$cases = $row[0];


$current_page = ($start/$pagerows) + 1;
if ($pages==1)
{$startingrecord=1;
$endingrecord=$cases;}
elseif ($current_page!= $pages)
{$startingrecord=($current_page-1)*$pagerows+1;
$endingrecord=($current_page)*$pagerows;}
else
{$startingrecord=($current_page-1)*$pagerows+1;
$endingrecord=$cases;}



echo "<p class='dbresults'>Total number of search results: $cases. Showing records  $startingrecord - $endingrecord </p>";
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

echo '<br/> <a href="index.php?search=1">Search Again</a>';
echo '<form action="index.php" method="post" id="export">
<br/><p>Click here to export results to CSV File
   <input name="exportsubmit" id="exportsubmit" type="submit" value="Export Case Data"/></p>
   </form>';

echo '<div class="scroll"><table id="hortable" summary="List of cases">
    <thead>
    	<tr>
		    <th scope="col">View</th>
            <th scope="col">Member ID</th>
			<th scope="col">Case Year</th>
            <th scope="col">Case Number</th>
            <th scope="col">Case Agency</th>
			<th scope="col">Region</th>
            <th scope="col">Date Submitted</th>
           
			
        </tr>
    </thead>
    <tbody>';
    	


// Fetch and print all the records:
$regcount=1;
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	$rrow=mysqli_fetch_array($regionresult, MYSQLI_ASSOC);
	$regcount=$regcount+1;
	echo '<tr>
	<td><a href="../viewcase.php?id=' . $row['id'] . '">View</a></td>
	<td>' . $row['memberid'] . '</td>
	<td>' . $row['caseyear'] . '</td>
	<td>' . $row['casenumber'] . '</td>
	<td>' . $row['caseagency'] . '</td>
	<td>' . $rrow['name'] . '</td>
	<td>' . $row['subdat'] . '</td>
	
	

	</tr>';
	}
	echo '</tbody></table></div>'; 
	
	
	// Close the table.
	mysqli_free_result ($result); // Free up the resources.	
} else { // If it did not run OK.
// Public message:
	echo '<p class="error">No records found.  </p>';
	
	
	
	$_SESSION['searched']=1;
unset($_GET['search']);
echo '<br/> <a href="index.php?search=1">Search Again</a>';
exit();
} // End of if ($result). 


$q = "SELECT COUNT(memberid) FROM cases WHERE ($searchstring) AND submissionstatus=1";
$result = @mysqli_query ($dbcon, $q);
$row = @mysqli_fetch_array ($result, MYSQLI_NUM);
$cases = $row[0];

$current_page = ($start/$pagerows) + 1;
if ($pages==1)
{$startingrecord=1;
$endingrecord=$cases;}
elseif ($current_page!= $pages)
{$startingrecord=($current_page-1)*$pagerows+1;
$endingrecord=($current_page)*$pagerows;}
else
{$startingrecord=($current_page-1)*$pagerows+1;
$endingrecord=$cases;}



echo "<p class='dbresults'>Total number of search results: $cases. Showing records  $startingrecord - $endingrecord </p>";




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
$_SESSION['searched']=1;
$_SESSION['searchstring']=$searchstring;
unset($_GET['search']);

  }//end on error
  
	  }//end export else
  
  //end main submit
?>





 </div>

<div id="searchform">

<?php 

if(!isset($fmID)) $fmID="";
if(!isset($fyear)) $fyear="";
if(!isset($fnumber)) $fnum="";
if(!isset($fagency)) $fagency="";


if (!isset($_SESSION['searched']))
{
echo <<<_END
<form action="index.php" method="get" id="search">


<fieldset style="border: solid 2px #cc0000;overflow: hidden;" class="roundedborder">


<fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend class="boldlegend">Search By Member ID</legend>
<br><label class="label" for="mID">Member ID</label><input id="mID" type="text" name="mID" size="3" maxlength="5" value="$fmID">

</fieldset>

<fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend class="boldlegend">Search By Identification Information</legend>




	<br><label class="label" for="cyear">Case Year</label><input id="cyear" type="text" name="cyear" size="5" maxlength="4" value="$fyear"> <select name="yearrange" id="yearrange">
	<option value="1">On or After</option>
	<option value="2">On or Before</option>
	<option value="3">Only</option>
	</select>
	<br>
  
    <label class="label" for="cnum">Case Number</label><input id="cnum" type="text" name="cnum" size="30" maxlength="40" value="$fnum">
    
    
	<br> 
    <label class="label" for="cagency">Case Agency</label><input id="cagency" type="text" name="cagency" size="30" maxlength="60" value="$fagency" >
    
   
           
           <br/>
           <label class="label" for="region">Region of Practice</label>
	<select name="region" id="region">
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
   <div id="search_errorloc" class="errorlocation">
            </div>
   
    </fieldset>
	
	<fieldset style="border: solid 2px #cc0000;overflow: hidden;" class="roundedborder">
	<fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend class="boldlegend">Export All Cases</legend>
<br><input id="exportall" type="button" name="exportall">
</fieldset>
	<br>
	</fieldset>

</form>

<script language="JavaScript" type="text/javascript"
    xml:space="preserve">//<![CDATA[
//You should create the validator only after the definition of the HTML form
  var frmvalidator  = new Validator("search");
  
 frmvalidator.EnableOnPageErrorDisplaySingleBox();
  frmvalidator.EnableMsgsTogether();
 
 
  
 // frmvalidator.addValidation("casename","req","You must provide a nickname for the case");


	frmvalidator.addValidation("cyear","gt=1900","Case Year must be post-1900");
 
  frmvalidator.addValidation("cyear","maxlen=4","Year must be entered in YYYY format");
  frmvalidator.addValidation("cyear","numeric", "Year must be an integer number");
  frmvalidator.addValidation("mID","numeric","Member ID must be an integer number");
  
  
 
 
 // frmvalidator.addValidation("fname","req","Please enter your First Name");
 // frmvalidator.addValidation("fname","maxlen=20",	"Max length for FirstName is 20");
 // frmvalidator.addValidation("fname","alpha","Alphabetic chars only");
  
  //frmvalidator.addValidation("email","email");
  
   
   //frmvalidator.addValidation("pcode","numeric","Zip code must be a number");
    
//]]></script>





_END;
} ?>


  
  
  
  </div>










</div></div>
<div id="footer">Copyright 2014 by <a href="http://www.sofainc.org/" target="_blank">SOFA</a>.</div>
</div>




</body>
</html>

