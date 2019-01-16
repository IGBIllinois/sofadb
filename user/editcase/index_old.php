<?php 
session_start();
if(!isset($_SESSION['loggedin']))
{header('Location: ' . '../../index.php');
exit();
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
<link href="../../css/styleTemplate.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <script type='text/javascript' src='gen_validatorv4.js'></script>

<title>Edit Case Information</title>


<!-- // Load Javascipt -->
</head>

<body>
<div id="top">
<div id="header"><a href="#"><img src="../../images/customLogo.gif" width="351" height="147" /></a></div>

<div id="title">
<h1>Forensic Case Database</h1>
</div>

<div id="hline">
<hr size="3" />
</div>

<div id="navbar">
  <ul>
    <li><a href="../../">Home</a></li>
    <li><a href="../index.php">My Account</a></li>
    <li><a href="../../logout.php">Logout</a></li>
    <li><a href="../../contact/">Contact Us</a></li>
  </ul>
</div>
<div id="templatecontainer">
 
  <br/>
  <h1 class="cntr">Edit Case Information</h1>

<div id="leftnav"><h2 style="color:#00C ;font-weight: bold;font-size: 16pt;">Control Panel</h2>
<ul>
    <li><a href="../index.php">My Cases</a></li>
    <li><a href=".index.php">Add Case</a></li>
    <li><a href="../deletecase/">Delete Case</a></li>
    <li><a href="../searchdb/?search=1">Search Database</a></li>
     <li><a href="../editprofile/">Edit Profile</a></li>

</ul>
 </div>


  <?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/mysqli_connect.php'); // Connect to the database.


if(isset($_GET['id']))
{$caseeditid=$_GET['id'];
$_SESSION['caseid']=$caseeditid;
$q="SELECT * FROM cases WHERE id=$caseeditid";

$mresult=mysqli_query($dbcon,$q);
if(!$mresult)
{echo 'Could not load user data from database';exit();}

$casedata=mysqli_fetch_array($mresult);}
elseif(!isset($_SESSION['caseid']))
{ header ("location: ../index.php"); exit();}
elseif(isset($_SESSION['caseid']))
{
	$caseeditid=$_SESSION['caseid'];
	$q="SELECT * FROM cases WHERE id=$caseeditid";

$mresult=mysqli_query($dbcon,$q);
if(!$mresult)
{echo 'Could not load user data from database';exit();}

$casedata=mysqli_fetch_array($mresult);
	
	}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$errors = array(); // Start an array to hold the errors
	// Check for a casenumber:
	if (empty($_POST['casenumber'])) {
		$errors[] = 'You must enter a casenumber to save.';
	} 
    else {
		$casenum = mysqli_real_escape_string($dbcon, trim($_POST['casenumber']));
	}
	// Check for a casename:
	if (empty($_POST['casename'])) {
		$errors[] = 'You must enter a case name to save.';
	} 
    else {
			$casenam = mysqli_real_escape_string($dbcon, trim($_POST['casename']));
	}
    
    
	// Check for a case agency:
	if (empty($_POST['caseagency'])) {
		$caseag=NULL;
        
	} 
    else {
		$caseag = mysqli_real_escape_string($dbcon, trim($_POST['caseagency']));
	}
	
    // Check for a FA sex
    if (empty($_POST['fasex'])) {
		$fasex=NULL;
	} 
    else {
		$fasex = mysqli_real_escape_string($dbcon, trim($_POST['fasex']));
	}
	
	
    
       	//check for a FA age 2 first!
	if (empty($_POST['faage2'])) {
		$faage2=NULL;
        $faageunits2=NULL;
	} 
    else {
		$faage2 = trim($_POST['faage2']);
        $faageunits2 = mysqli_real_escape_string($dbcon, trim($_POST['faageunits2']));
	}
    
    
    //check for a FA age 1
	if (empty($_POST['faage'])) {
		$faage=NULL;
        $faageunits=NULL;
        $faage2=NULL;
        $faageunits2=NULL;
	} 
    else {
		$faage = trim($_POST['faage']);
        $faageunits = mysqli_real_escape_string($dbcon, trim($_POST['faageunits']));
	}

	
  //check for a FA stature 2 first 
	if (empty($_POST['fastature2'])) {
		
        $fastature2=NULL;
	} 
    else {
		$fastature2 = trim($_POST['fastature2']);
        
	}


	//check for a FA stature
	if (empty($_POST['fastature'])) {
		$fastature=NULL;
        $fastature2=NULL;
        $fastatureunits=NULL;
	} 
    else {
		$fastature = trim($_POST['fastature']);
        $fastatureunits = mysqli_real_escape_string($dbcon, trim($_POST['fastatureunits']));
	}


  // Check for a id sex
    if (empty($_POST['idsex'])) {
		$idsex=NULL;
	} 
    else {
		$idsex = mysqli_real_escape_string($dbcon, trim($_POST['idsex']));
	}


  //check for a id age 
	if (empty($_POST['idage'])) {
		$idage=NULL;
        $idageunits=NULL;
        
	} 
    else {
		$idage = trim($_POST['idage']);
        $idageunits = mysqli_real_escape_string($dbcon, trim($_POST['idageunits']));
	}



	//check for a id stature
	if (empty($_POST['idstature'])) {
		$idstature=NULL;
        $idstatureunits=NULL;
	} 
    else {
		$idstature = trim($_POST['idstature']);
        $idstatureunits = mysqli_real_escape_string($dbcon, trim($_POST['idstatureunits']));
	}
   
   
   //check for a id source
	if (empty($_POST['idsource'])) {
		$idsource=NULL;
        
	} 
    else {
		
        $idsource = mysqli_real_escape_string($dbcon, trim($_POST['idsource']));
	}
    
    //check for a  casenotes
	if (empty($_POST['casenotes'])) {
		$casenotes=NULL;
        
	} 
    else {
		
        $casenotes = mysqli_real_escape_string($dbcon, trim($_POST['casenotes']));
	}
	
    
      
    if(isset($_POST['farace_asian']))
	{
      $faAs=$_POST['farace_asian'];
	}
	else{$faAs=0;}
	
	 if(isset($_POST['farace_black']))
	{
      $faBl=$_POST['farace_black'];
	}
	else{$faBl=0;}
	
     if(isset($_POST['farace_white']))
	{
      $faWh=$_POST['farace_white'];
	}
	else{$faWh=0;}
	
	 if(isset($_POST['farace_hispanic']))
	{
      $faHi=$_POST['farace_hispanic'];
	}
	else{$faHi=0;}
	
   if(isset($_POST['farace_native']))
	{
      $faNa=$_POST['farace_native'];
	}
	else{$faNa=0;}
  
   if(isset($_POST['farace_white']))
	{
      $faWh=$_POST['farace_white'];
	}
	else{$faWh=0;}
   
    if(isset($_POST['farace_other']))
	{
      $faOt=$_POST['farace_other'];
	}
	else{$faOt=0;}
  
    
    if (empty($_POST['farace_othertext'])) {
		$faothertext=NULL;
        
	} 
    else {
		
        $faothertext = mysqli_real_escape_string($dbcon, trim($_POST['farace_othertext']));
	}
    
    if(($faOt==0 && $faothertext)||($faOt==1 && !$faothertext))
	{$errors[] = 'You must Check the Other box and enter text.';}
    
    
    
    
    
      
    if(isset($_POST['race_asian']))
	{
      $idAs=$_POST['race_asian'];
	}
	else{$idAs=0;}
	
	 if(isset($_POST['race_black']))
	{
      $idBl=$_POST['race_black'];
	}
	else{$idBl=0;}
	
     if(isset($_POST['race_white']))
	{
      $idWh=$_POST['race_white'];
	}
	else{$idWh=0;}
	
	 if(isset($_POST['race_hispanic']))
	{
      $idHi=$_POST['race_hispanic'];
	}
	else{$idHi=0;}
	
   if(isset($_POST['race_native']))
	{
      $idNa=$_POST['race_native'];
	}
	else{$idNa=0;}
  
   if(isset($_POST['race_white']))
	{
      $idWh=$_POST['race_white'];
	}
	else{$idWh=0;}
   
    if(isset($_POST['race_other']))
	{
      $idOt=$_POST['race_other'];
	  
	}
	else{$idOt=0;}
  
    
    if (empty($_POST['idrace_othertext'])) {
		$idothertext=NULL;
        
	} 
    else {
		
        $idothertext = mysqli_real_escape_string($dbcon, trim($_POST['idrace_othertext']));
	
	}
    
    if(($idOt==0 && $idothertext)||($idOt==1 && !$idothertext))
	{$errors[] = 'You must Check the Other box and enter text.';}
    
    
    
    
		if (empty($errors)) 
        { // If there were no errors
		//Determine whether the case has already been registered	
		$memberid=$_SESSION['id'];

      $caseeditid=$_SESSION['caseid'];
		$q = "SELECT id FROM cases WHERE memberid='$memberid' AND casename='$casenam' AND casenumber='$casenum' AND id!='$caseeditid'";
		$result=mysqli_query ($dbcon, $q) ; 	
			
            if (mysqli_num_rows($result) == 0)
            {//The case has not been registered already 
			// Make the query:
		
        	$q = "UPDATE cases SET casename='$casenam',casenumber='$casenum',caseagency='$caseag',fasex='$fasex',faage='$faage',faage2='$faage2',faageunits='$faageunits', faageunits2='$faageunits2',fastature='$fastature',fastature2='$fastature2',fastatureunits='$fastatureunits',idsex='$idsex',idage='$idage',idageunits='$idageunits',idsource='$idsource',idstature='$idstature',idstatureunits='$idstatureunits',casenotes='$casenotes',datemodified=NOW(),faancestryas='$faAs',faancestryeuro='$faWh',faancestryaf='$faBl',faancestryna='$faNa',faancestryhi='$faHi',faancestryot='$faOt',faancestryottext='$faothertext',idraceas='$idAs',idraceaf='$idBl',idracewh='$idWh',idracehi='$idHi',idracena='$idNa',idraceot='$idOt',idraceottext='$idothertext' WHERE id='$caseeditid'";
			
			 
				
			$result = @mysqli_query ($dbcon, $q); // Run the query.
		$inid=mysql_insert_id();
     
        		if (!$result) 
                { // If it ran OK.
                // If it did not run OK
				// Error message:
				echo '<h2>System Error</h2>
				<p class="error">Registration failed because of a system error. We apologize for any inconvenience.</p>'; 
				// Debugging message:
				echo '<p>' . mysqli_error($dbcon) . '<br/><br/>Query: ' . $q . '</p>';
                exit();
                }
                
        
       		
        		 
       
       			unset($_SESSION['caseid']); 
                header ("location: ../index.php"); exit();
				
                 
       	   mysqli_close($dbcon); // Close the database connection
			// Include the footer and stop the script
		  
			exit();
		}
	else
    	{//The email address is already registered
		echo	'<p class="error">The case name and number are not acceptable because it is already registered</p>';
		}//end already registered if
	} 
    else
     { // Report the errors.
		echo '<h2>Error!</h2>
		<p class="error">The following error(s) occurred:<br/>';
		foreach ($errors as $msg) 
        { // Print each error.
			echo " - $msg<br/>\n";
		}
		echo '</p><h3>Please try again.</h3><p><br/></p>';
	   }// End of else (empty($errors))
} // End of the main Submit conditional.
?>
  



  <div id="caseform">
    <form action="index.php" method="post" id="casedata">
    
    
  <fieldset style="border: solid 2px #cc0000;overflow: hidden;" class="roundedborder">
    
    
  <fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend>General Case Information</legend>
    
  <label class="label" for="casenumber">Case Number</label><input id="casenumber" type="text" name="casenumber" size="30" maxlength="30" value="<?php if (isset($casedata['casenumber'])) echo $casedata['casenumber']; ?>"/>
  <br />
    
  <label class="label" for="caseagency">Case Agency</label><input id="caseagency" type="text" name="caseagency" size="30" maxlength="30" value="<?php if (isset($casedata['caseagency'])) echo $casedata['caseagency']; ?>"/>
  <br />
    
  <label class="label" for="casename">Case Nickname</label><input id="casename" type="text" name="casename" size="30" maxlength="30" value="<?php if (isset($casedata['casename'])) echo $casedata['casename']; ?>"/>
    
    
  </fieldset>
    
  <fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend> Biological Profile: Forensic Anthropology Case Estimation</legend>
    
    
  <label class="label" for="fasex">Sex</label>
  <select name="fasex">
    <option value="">- Select -</option>
    <option value="Female"<?php if (isset($casedata['fasex']) AND ($casedata['fasex'] == 'Female')) echo ' selected="selected"'; ?>>Female</option>
    <option value="Probable Female"<?php if (isset($casedata['fasex']) AND ($casedata['fasex'] == 'Probable Female')) echo ' selected="selected"'; ?>>Probable Female</option>
    <option value="Indeterminate"<?php if (isset($casedata['fasex']) AND ($casedata['fasex'] == 'Indeterminate')) echo ' selected="selected"'; ?>>Indeterminate</option>
    <option value="Probable Male"<?php if (isset($casedata['fasex']) AND ($casedata['fasex'] == 'Probable Male')) echo ' selected="selected"'; ?>>Probable Male</option>
    <option value="Male"<?php if (isset($casedata['fasex']) AND ($casedata['fasex'] == 'Male')) echo ' selected="selected"'; ?>>Male</option>
    </select>
    
    
    
    <br/><label class="label" for="faage">Age</label><input id="faage" type="text" name="faage" size="5" maxlength="5" value="<?php if (isset($casedata['faage'])) echo $casedata['faage']; ?>"/>
    
    <select name="faageunits">
      <option value="years">years</option>
      <option value="months"<?php if (isset($casedata['faageunits']) AND ($casedata['faageunits'] == 'months')) echo ' selected="selected"'; ?>>months</option>
      <option value="fetalmonths"<?php if (isset($casedata['faageunits']) AND ($casedata['faageunits'] == 'fetalmonths')) echo ' selected="selected"'; ?>>fetal months</option>
      </select>&nbsp; to &nbsp;
    
    <input id="faage2" type="text" name="faage2" size="5" maxlength="5" value="<?php if (isset($casedata['faage2'])) echo $casedata['faage2']; ?>"/>
    
    <select name="faageunits2">
      <option value="years">years</option>
      <option value="months"<?php if (isset($casedata['faageunits2']) AND ($casedata['faageunits2'] == 'months')) echo ' selected="selected"'; ?>>months</option>
      <option value="fetalmonths"<?php if (isset($casedata['faageunits2']) AND ($casedata['faageunits2'] == 'fetalmonths')) echo ' selected="selected"'; ?>>fetal months</option>
      </select>
    
    
    
    <br/><label class="label" for="faancestry">Ancestry</label>
    <input type="checkbox" name="farace_asian" value="1" <?php if (isset($casedata['faancestryas'])AND $casedata['faancestryas'] == 1) echo ' checked'; ?>/>Asian/Pacific Islander
    <input type="checkbox" name="farace_black" value="1" <?php if (isset($casedata['faancestryaf']) AND $casedata['faancestryaf'] == 1) echo ' checked'; ?>/>Black/African-American
    <input type="checkbox" name="farace_hispanic" value="1" <?php if (isset($casedata['faancestryhi']) AND $casedata['faancestryhi'] == 1) echo ' checked'; ?>/>Hispanic<br />
    <label class="label" for="faancestry2"></label>
    <input type="checkbox" name="farace_native" value="1" <?php if (isset($casedata['faancestryna']) AND $casedata['faancestryna'] == 1) echo ' checked'; ?>/>Native American
    <input type="checkbox" name="farace_white" value="1" <?php if (isset($casedata['faancestryeuro']) AND $casedata['faancestryeuro'] == 1) echo ' checked'; ?> />White
    <input type="checkbox" name="farace_other" value="1" <?php if (isset($casedata['faancestryot']) AND $casedata['faancestryot'] == 1) echo ' checked'; ?>/>Other: &nbsp; <input id="farace_othertext" type="text" name="farace_othertext" size="18" maxlength="30" value="<?php if (isset($casedata['faancestryottext'])) echo $casedata['faancestryottext']; ?>"/>
    
    
    
    <br/><label class="label" for="fastature">Stature</label><input id="fastature" type="text" name="fastature" size="6" maxlength="8" value="<?php if (isset($casedata['fastature'])) echo $casedata['fastature']; ?>"/>  &nbsp; to &nbsp;
    
    <input id="fastature2" type="text" name="fastature2" size="6" maxlength="8" value="<?php if (isset($casedata['fastature2'])) echo $casedata['fastature2']; ?>"/>  <select name="fastatureunits">
      <option value="in">inches</option>
      <option value="cm"<?php if (isset($casedata['fastatureunits']) AND ($casedata['fastatureunits'] == 'cm')) echo ' selected="selected"'; ?>/>cm</option>
      </select>
    
    
    </fieldset>
    
    <fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend>Biological Profile: Actual Identified Information</legend>
      
      <label class="label" for="idsex">Sex</label>
      <select name="idsex">
        <option value="">- Select -</option>
        <option value="Female"<?php if (isset($casedata['idsex']) AND ($casedata['idsex'] == 'Female')) echo ' selected="selected"'; ?>>Female</option>
        <option value="Male"<?php if (isset($casedata['idsex']) AND ($casedata['idsex'] == 'Male')) echo ' selected="selected"'; ?>>Male</option>
        </select>
      
      
      <br/><label class="label" for="idage">Age</label><input id="idage" type="text" name="idage" size="5" maxlength="5" value="<?php if (isset($casedata['idage'])) echo $casedata['idage']; ?>"/>
      <select name="idageunits">
        <option value="years">years</option>
        <option value="months"<?php if (isset($casedata['idageunits']) AND ($casedata['idageunits'] == 'months')) echo ' selected="selected"'; ?>>months</option>
        <option value="fmonths"<?php if (isset($casedata['idageunits']) AND ($casedata['idageunits'] == 'fmonths')) echo ' selected="selected"'; ?>>fetal months</option>
        </select> 
      
      
      
      
      
      <br/><label class="label" for="idrace">Race/Ethnicity</label>
      <input type="checkbox" name="race_asian" value="1" <?php if (isset($casedata['idraceas']) AND $casedata['idraceas'] == 1) echo ' checked'; ?>/>Asian/Pacific Islander
      <input type="checkbox" name="race_black" value="1" <?php if (isset($casedata['idraceaf'])  AND $casedata['idraceaf'] == 1) echo ' checked'; ?>/>Black/African-American
      <input type="checkbox" name="race_hispanic" value="1" <?php if (isset($casedata['idracehi']) AND $casedata['idracehi'] == 1) echo ' checked'; ?>/>Hispanic<br />
      <label class="label" for="idrace2"></label>
      <input type="checkbox" name="race_native" value="1" <?php if (isset($casedata['idracena']) AND $casedata['idracena'] == 1) echo ' checked'; ?>/>Native American
      <input type="checkbox" name="race_white" value="1" <?php if (isset($casedata['idracewh']) AND $casedata['idracewh'] == 1) echo ' checked'; ?>/>White
      <input type="checkbox" name="race_other" value="1" <?php if (isset($casedata['idraceot']) AND $casedata['idraceot'] == 1) echo ' checked'; ?> />Other: &nbsp; <input id="idrace_othertext" type="text" name="idrace_othertext" size="18" maxlength="30" value="<?php if (isset($casedata['idraceottext'])) echo $casedata['idraceottext']; ?>"/>
      
      
      <br/><label class="label" for="idstature">Stature</label><input id="idstature" type="text" name="idstature" size="6" maxlength="8" value="<?php if (isset($casedata['idstature'])) echo $casedata['idstature']; ?>" />
      
      <select name="idstatureunits">
        <option value="in">inches</option>
        <option value="cm"<?php if (isset($casedata['idstatureunits']) AND ($casedata['idstatureunits'] == 'cm')) echo ' selected="selected"'; ?>>cm</option>
        </select>
      
      <br />
      
      <br/><label class="label" for="idsource">Information Source</label><input id="idsource" type="text" name="idsource" size="30" maxlength="60" value="<?php if (isset($casedata['idsource'])) echo $casedata['idsource']; ?>" /><br />
      
  </fieldset>
    <fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend>Case Notes</legend>
      <label class="label" for="casenotes"></label>
      <textarea name="casenotes" cols="55" rows="7"><?php if (isset($casedata['casenotes'])) echo $casedata['casenotes']; ?></textarea>
      
      
     
      
      
      
      
      </fieldset>
     <div id="casedata_errorloc" class="errorlocation">
    </div>
    
  <br />	<br /> <label class="label" for="savecase">Click here to save case</label>
    <input name="savecase" id="savecase" type="submit" value="Save Case"/>
    
    
    </fieldset>
 
  </form>
    
    
    <script language="JavaScript" type="text/javascript"
    xml:space="preserve">//<![CDATA[
//You should create the validator only after the definition of the HTML form
  var frmvalidator  = new Validator("casedata");
  
  frmvalidator.EnableOnPageErrorDisplaySingleBox();
   frmvalidator.EnableMsgsTogether();
 
 
  frmvalidator.addValidation("casenumber","req","You must provide a case number");
 
  
  frmvalidator.addValidation("casename","req","You must provide a nickname for the case");

  
   frmvalidator.addValidation("faage","numeric","Ages must be entered as a number");
   
  frmvalidator.addValidation("faage2","numeric","Ages must be entered as a number");
  
   frmvalidator.addValidation("fastature","numeric","Statures must be entered as a number");
   
  frmvalidator.addValidation("fastature2","numeric","Statures must be entered as a number");
  
  frmvalidator.addValidation("idage","numeric","Ages must be entered as a number");
   
  frmvalidator.addValidation("idstature","numeric","Statures must be entered as a number");
    
	//]]></script>
    
</div>
  






 </div>






<div id="footer">Copyright 2014 by <a href="http://www.sofainc.org/" target="_blank">SOFA</a>.</div>
</div>




</body>
</html>

