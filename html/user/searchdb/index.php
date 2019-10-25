<?php
require_once('../../include/header_user.php');
 require_once('../../include/session_user.php') ;
?>

<BR/>
  <h1 class="cntr">Search Cases</h1>

 <div id="searchregion"> 
 
 
  
  

<div name="searchresults">
 <?php 
  
 $memberid=$_SESSION['id'];

  $error=0;
  
  if (isset($_GET['search']))
  {unset($_SESSION['searched']);
  unset($_SESSION['searchstring']);}
  
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	  
       require('exportdata.php');
  }
		  
	if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['search'] != 1){//not export
	  $first=0;
          $race_array = array();
          foreach($_GET['race'] as $race=>$value) {
              $race_array[$value] = $race;
          }
          $case_data = array(
              "memberId"=>$_GET['mID'],
              "caseYear"=>$_GET['cyear'],
              "caseNumber"=>$_GET['cnum'],
              "caseAgency"=>$_GET['cagency'],
              "region"=>$_GET['region'],
              "idsex"=>$_GET['sexid'],
              "idage1"=>$_GET['ageid1'],
              "idage2"=>$_GET['ageid2'],
              "statureid1"=>$_GET['statureid1'],
              "statureid2"=>$_GET['statureid2'],
              "race"=>$race_array,
              "est_sex"=>$_GET['est_sex'],
              "est_age"=>$_GET['est_age'],
              "est_stat"=>$_GET['est_stat'],
              "est_anc"=>$_GET['est_anc'],
              "conjuction"=>$_GET['andor']
                  );
              
              $case_results = sofa_case::search_cases($db, $memberid, $case_data);
              
              //sofa_case::write_report($db, $case_results);
              
          

	
	  
if(!$error){//if error start	  
// This script retrieves all the records from the users table.
 // Connect to the database.
//set the number of rows per display page

if (isset($_SESSION['searchstring']) && isset($_SESSION['searched'])){$searchstring=$_SESSION['searchstring'];}

$pagerows = PAGEROWS;

// Has the total number of pagess already been calculated?
if (isset($_GET['p']) && is_numeric
($_GET['p'])) 
{//already been calculated
$pages=$_GET['p'];}
else{//use the next block of code to calculate the number of pages
//First, check for the total number of records
$q = "SELECT COUNT(memberid) FROM cases WHERE ($searchstring) AND submissionstatus=1";

$result = @mysqli_query ($dbcon, $q);
$row = @mysqli_fetch_array ($result, MYSQLI_NUM);
$records = $row[0];
//Now calculate the number of pages
if ($records > $pagerows){ //if the number of records will fill more than one page
//Calculatethe number of pages and round the result up to the nearest integer
$pages = ceil ($records/$pagerows);}
else{
$pages = 1;
}
}//page check finished

//Declare which record to start with
if (isset($_GET['s']) && is_numeric
($_GET['s'])) 
{//already been calculated
$start = $_GET['s'];
}
else{
$start = 0;
}
// Make the query: THIS SQL statement is messed up [true?]
/*
$q = "SELECT cases.id AS id, casenumber, caseyear, caseagency, memberid, DATE_FORMAT(datesubmitted, '%M %d, %Y') AS subdat FROM cases, members WHERE members.id=cases.memberid AND ($searchstring) AND submissionstatus=1 ORDER BY caseyear ASC LIMIT $start, $pagerows";		

echo("<BR>orig query = $q<BR>"); 

$result = @mysqli_query ($dbcon, $q); // Run the query.
$members = mysqli_num_rows($result);


//This sql statement is messed up, it doesn't work when region is part of the search string [true?]
$q="SELECT regions.name FROM cases, members, regions WHERE regions.id=members.region AND members.id=cases.memberid AND ($searchstring) AND cases.submissionstatus=1 ORDER BY cases.caseyear ASC";
$regionresult=@mysqli_query ($dbcon, $q);
$regrows=mysqli_num_rows($regionresult);
*/

//if ($result && $members && $regionresult && $regrows) { // If it ran OK, display the records.
// Table header.
/*
$q = "SELECT COUNT(memberid) FROM cases WHERE ($searchstring) AND submissionstatus=1";
$resultP = @mysqli_query ($dbcon, $q);
$row = @mysqli_fetch_array ($resultP, MYSQLI_NUM);
$cases = $row[0];
*/
if(count($case_results) > 0) {
$cases = count($case_results);
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
			<th scope="col">Case ID</th>
            <th scope="col">Case Year</th>
            <th scope="col">Date Submitted</th>
             </tr>
    </thead>
    <tbody>';
    	


// Fetch and print all the records:
$regcount=1;
foreach($case_results as $case) {
	$regcount=$regcount+1;
	echo '<tr>
	<td><a href="../editcase/index.php?id=' . $case->get_id() . '">View</a></td>
	<td>' . $case->get_casenumber() . '</td>
	<td>' . $case->get_caseyear(). '</td>
	<td>' . $case->get_datesubmitted() . '</td>
	</tr>';    
}
echo '</tbody></table></div>'; 

} 
else { // If it did not run OK.
// Public message:
	echo '<p class="error">No records found.  </p>';
	
	
	
	$_SESSION['searched']=1;
unset($_GET['search']);
echo '<br/> <a href="index.php?search=1">Search Again</a>';
exit();
} // End of if ($result). 



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


if(!isset($fyear)) $fyear="";
if(!isset($fageid1)) $fageid1="";
if(!isset($fageid2)) $fageid2="";


if (!isset($_SESSION['searched']))
{
echo <<<_END
<form action="index.php" method="get" id="search">


<fieldset style="border: solid 2px #cc0000;overflow: hidden;" class="roundedborder">




	<br>
   <fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend class="boldlegend">Search By Identification Information</legend>
    
    <br><label class="label" for="sexid">Identified Sex</label>
	<select name="sexid" id="sexid">
	<option value="">- Select -</option>
	<option value="Male">Male</option>
	<option value="Female">Female</option>
	</select>



 <br><label class="label" for="ageid1">Range of Identified Ages</label><input id="ageid1" type="text" name="ageid1" size="5" maxlength="5" value="$fageid1"/>&nbsp; to &nbsp;
    <input id="ageid2" type="text" name="ageid2" size="5" maxlength="5" value="$fageid2"/>
    <select name="ageidunits">
      <option value="years">years</option>
      <option value="months">months</option>
      <option value="fmonths">fetal months</option>
      </select>
    
     <br><label class="label" for="statureid1">Range of Identified Statures</label><input id="statureid1" type="text" name="statureid1" size="5" maxlength="8" value=""/>&nbsp; to &nbsp;
    <input id="statureid2" type="text" name="statureid2" size="5" maxlength="8" value=""/>  <label>inches</label>
      
        <br><label class="label" for="idrace">Identified Races/Ethnicities</label>
      <input type="checkbox" name="race[]" value="as" id="raceAs"/>Asian/Pacific Islander
      <input type="checkbox" name="race[]" value="af" id="raceAf"/>Black/African-American<br>
      <label class="label" for="idrace2"></label>
      <input type="checkbox" name="race[]" value="hi" id="raceHi"/>Hispanic
      <input type="checkbox" name="race[]" value="na" id="raceNa"/>Native American<br>
      <label class="label" for="idrace3"></label>
      <input type="checkbox" name="race[]" value="wh" id="raceWh"/>White
      <input type="checkbox" name="race[]" value="ot" id="raceOt"/>Other<br/><br>
           
    
    
      
           
	   </fieldset>  
	<br>
     <fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend class="boldlegend">Search By Forensic Anthropology Report Information</legend>
	 <br><label class="label" for="cyear">Case Year</label><input id="cyear" type="text" name="cyear" size="5" maxlength="4" value="$fyear"> <select name="yearrange" id="yearrange">
	<option value="1">On or After</option>
	<option value="2">On or Before</option>
	<option value="3">Only</option>
	</select>
      <br><label class="label" for="methodest">Practioner Estimated</label>
      <input type="checkbox" name="est_sex" value="1" />Sex
      <input type="checkbox" name="est_age" value="1" />Age
      <input type="checkbox" name="est_anc" value="1" />Ancestry
       <input type="checkbox" name="est_stat" value="1" />Stature<br /><br>
     </fieldset>  
    
<br> 
   <div id="search_errorloc" class="errorlocation">
            </div>
   
    </fieldset>
	<br >
	<fieldset style="border: solid 2px #cc0000;overflow: hidden;" class="roundedborder">
	<fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend class="boldlegend">Search Options</legend>
 <br><label class="label" for="searchtype">List Cases That Meet:</label>
  <select name="andor">
	<option value="1">All Selected Criteria</option>
	<option value="2">At Least One of Selected Criteria</option></select> <br ><br>
<label class="label" for="regsubmit">Click here to search</label>
   <input name="regsubmit" id="regsubmit" type="submit" class="showybutton" value="Search"/><br />
   
    
<br>
</fieldset>
	<br>
	</fieldset>
<br>

</form>


<form action="index.php" method="post" id="export">

<fieldset style="border: solid 2px #cc0000;overflow: hidden;" class="roundedborder">
	<fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend class="boldlegend">Export Database</legend>
<br>
<span><label class="label" for="exportall">Click here to export all cases</label><input name="exportall" type="submit" id="exportall" title="Export All" value="Export All"></span><br>


<br>
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
 frmvalidator.addValidation("ageid1","gt=0","First age must be larger than zero");
  frmvalidator.addValidation("ageid2","gt=0","Second age must be larger than zero");
 frmvalidator.addValidation("statureid1","gt=0","First stature must be larger than zero");
  frmvalidator.addValidation("statureid2","gt=0","Second stature must be larger than zero");
 
 	frmvalidator.addValidation("statureid2","geelmnt=statureid1","The second stature should be larger or equal to the first.");
frmvalidator.addValidation("ageid2","geelmnt=ageid1","The second age should be larger or equal to the first.");
  frmvalidator.addValidation("cyear","maxlen=4","Year must be entered in YYYY format");
  frmvalidator.addValidation("cyear","numeric", "Year must be an integer number");
  frmvalidator.addValidation("ageid1","numeric", "First age must be a number");
   frmvalidator.addValidation("ageid2","numeric", "Second age must be a number");
   frmvalidator.addValidation("statureid1","numeric", "First stature must be a number");
   frmvalidator.addValidation("statureid2","numeric", "Second stature must be a number");
  frmvalidator.addValidation("mID","numeric","Member ID must be an integer number");
  
  
 
 
 // frmvalidator.addValidation("fname","req","Please enter your First Name");
 // frmvalidator.addValidation("fname","maxlen=20",	"Max length for FirstName is 20");
 // frmvalidator.addValidation("fname","alpha","Alphabetic chars only");
  
  //frmvalidator.addValidation("email","email");
  
   
   //frmvalidator.addValidation("pcode","numeric","Zip code must be a number");
    
//]]>
</script>





_END;
} 
?>


  
  
  
  </div>










</div></div>
<div id="footer">Copyright 2014 by <a href="http://www.sofainc.org/" target="_blank">SOFA</a>.</div>
</div>




</body>
</html>

