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
<title>Add Case</title>
<link href="../../css/styleTemplate.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <script type='text/javascript' src='gen_validatorv4.js'></script>

<title>SOFA Forensic Case Database</title>


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
    <li><a href="#">My Account</a></li>
    <li><a href="../../logout.php">Logout</a></li>
    <li><a href="../../contact/">Contact Us</a></li>
  </ul>
</div>
<div id="templatecontainer">
  
  </br>
  <h1 class="cntr">Case Information</h1>
  <?php
require ($_SERVER['DOCUMENT_ROOT'].'/mysqli_connect.php'); // Connect to the database.


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
	
	
	
	if (empty($errors)) { // If there were no errors
//Determine whether the email address has already been registered	
$memberid=$_SESSION['id'];


$q = "SELECT id FROM cases WHERE memberid='$memberid' AND casename='$casenam' AND casenumber='$casenum'";
$result=mysqli_query ($dbcon, $q) ; 	
if (mysqli_num_rows($result) == 0){//The case has not been registered already 
		// Make the query:
		
        $q = "INSERT INTO cases (id,casename, casenumber,memberid,caseagency,fasex,faage,faage2,faageunits,faageunits2,fastature,fastature2,fastatureunits,idsex,idage,idageunits,idstature,idstatureunits,idsource,casenotes,datestarted,datemodified,submissionstatus) VALUES (' ', '$casenam', '$casenum','$memberid','$caseag','$fasex','$faage','$faage2','$faageunits','$faageunits2','$fastature','$fastature2','$fastatureunits','$idsex','$idage','$idageunits','$idstature','$idstatureunits','$idsource','$casenotes',NOW(),NOW(),'0')";	
		$result = @mysqli_query ($dbcon, $q); // Run the query.
		if ($result) { // If it ran OK.
		header ("location: ../index.php"); 
		exit();
		} else { // If it did not run OK
		// Error message:
			echo '<h2>System Error</h2>
			<p class="error">Registration failed because of a system error. We apologize for any inconvenience.</p>'; 
			// Debugging message:
			echo '<p>' . mysqli_error($dbcon) . '<br><br>Query: ' . $q . '</p>';
		} // End of if ($result)
		mysqli_close($dbcon); // Close the database connection
		// Include the footer and stop the script
		  
		exit();
}else{//The email address is already registered
echo	'<p class="error">The case name and number are not acceptable because it is already registered</p>';
}
	} else { // Report the errors.
		echo '<h2>Error!</h2>
		<p class="error">The following error(s) occurred:<br>';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br>\n";
		}
		echo '</p><h3>Please try again.</h3><p><br></p>';
		}// End of if (empty($errors))
} // End of the main Submit conditional.
?>
  

<div id="leftnav"><h2 style="color:#00C ;font-weight: bold;font-size: 16pt;">Control Panel</h2>
<ul>
    <li><a href="index.php">My Cases</a></li>
    <li><a href="addcase/index.php">Add Case</a></li>
    <li><a href="editprofile/index.php">Edit Profile</a></li>
    <li><a href="../contact/">Search Database</a></li>

</ul>
 </div>

  <div id="caseform">
    <form action="index.php" method="post" id="casedata">
    
    
  <fieldset style="border: solid 2px #cc0000;overflow: hidden;" class="roundedborder">
    
    
  <fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend>General Case Information</legend>
    
  <label class="label" for="casenumber">Case Number</label><input id="casenumber" type="text" name="casenumber" size="30" maxlength="30" value="<?php if (isset($_POST['casenumber'])) echo $_POST['casenumber']; ?>">
  <br />
    
  <label class="label" for="caseagency">Case Agency</label><input id="caseagency" type="text" name="caseagency" size="30" maxlength="30" value="<?php if (isset($_POST['caseagency'])) echo $_POST['caseagency']; ?>">
  <br />
    
  <label class="label" for="casename">Case Nickname</label><input id="casename" type="text" name="casename" size="30" maxlength="30" value="<?php if (isset($_POST['casename'])) echo $_POST['casename']; ?>">
    
    
  </fieldset>
    
  <fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend> Biological Profile: Forensic Anthropology Case Estimation</legend>
    
    
  <label class="label" for="fasex">Sex</label>
  <select name="fasex">
    <option value="">- Select -</option>
    <option value="Female"<?php if (isset($_POST['fasex']) AND ($_POST['fasex'] == 'Female')) echo ' selected="selected"'; ?>>Female</option>
    <option value="Probable Femail"<?php if (isset($_POST['fasex']) AND ($_POST['fasex'] == 'Probable Female')) echo ' selected="selected"'; ?>>Probable Female</option>
    <option value="Indeterminate"<?php if (isset($_POST['fasex']) AND ($_POST['fasex'] == 'Indeterminate')) echo ' selected="selected"'; ?>>Indeterminate</option>
    <option value="Probable Male"<?php if (isset($_POST['fasex']) AND ($_POST['fasex'] == 'Probable Male')) echo ' selected="selected"'; ?>>Probable Male</option>
    <option value="Male"<?php if (isset($_POST['fasex']) AND ($_POST['fasex'] == 'Male')) echo ' selected="selected"'; ?>>Male</option>
    </select>
    
    
    
    <br><label class="label" for="faage">Age</label><input id="faage" type="text" name="faage" size="5" maxlength="5" value="<?php if (isset($_POST['faage'])) echo $_POST['faage']; ?>">
    
    <select name="faageunits">
      <option value="years">years</option>
      <option value="months"<?php if (isset($_POST['faageunits']) AND ($_POST['faageunits'] == 'months')) echo ' selected="selected"'; ?>>months</option>
      <option value="fetalmonths"<?php if (isset($_POST['faageunits']) AND ($_POST['faageunits'] == 'fetalmonths')) echo ' selected="selected"'; ?>>fetal months</option>
      </select>&nbsp; to &nbsp;
    
    <input id="faage2" type="text" name="faage2" size="5" maxlength="5" value="<?php if (isset($_POST['faage2'])) echo $_POST['faage2']; ?>">
    
    <select name="faageunits2">
      <option value="years">years</option>
      <option value="months"<?php if (isset($_POST['faageunits2']) AND ($_POST['faageunits2'] == 'months')) echo ' selected="selected"'; ?>>months</option>
      <option value="fetalmonths"<?php if (isset($_POST['faageunits2']) AND ($_POST['faageunits2'] == 'fetalmonths')) echo ' selected="selected"'; ?>>fetal months</option>
      </select>
    
    
    
    <br><label class="label" for="faancestry">Ancestry</label>
    <input type="checkbox" name="farace_asian" value="<?php echo $_POST['farace_asian'];?>" />Asian/Pacific Islander
    <input type="checkbox" name="farace_black" value="<?php echo $_POST['farace_black'];?>" />Black/African-American
    <input type="checkbox" name="farace_hispanic" value="<?php echo $_POST['farace_hispanic'];?>" />Hispanic<br />
    <label class="label" for="faancestry2"></label>
    <input type="checkbox" name="farace_native" value="<?php echo $_POST['race_native'];?>" />Native American
    <input type="checkbox" name="farace_white" value="<?php echo $_POST['race_white'];?>" />White
    <input type="checkbox" name="farace_other" value="<?php echo $_POST['race_other'];?>" />Other: &nbsp; <input id="race_othertext" type="text" name="farace_othertext" size="18" maxlength="30" value="<?php if (isset($_POST['race_othertext'])) echo $_POST['race_othertext']; ?>">
    
    
    
    <br><label class="label" for="fastature">Stature</label><input id="fastature" type="text" name="fastature" size="6" maxlength="8" value="<?php if (isset($_POST['fastature'])) echo $_POST['fastature']; ?>" >  &nbsp; to &nbsp;
    
    <input id="fastature2" type="text" name="fastature2" size="6" maxlength="8" value="<?php if (isset($_POST['fastature2'])) echo $_POST['fastature2']; ?>" >  <select name="fastatureunits">
      <option value="in">inches</option>
      <option value="cm"<?php if (isset($_POST['fastatureunits']) AND ($_POST['fastatureunits'] == 'cm')) echo ' selected="selected"'; ?>>cm</option>
      </select>
    
    
    </fieldset>
    
    <fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend>Biological Profile: Actual Identified Information</legend>
      
      <label class="label" for="idsex">Sex</label>
      <select name="idsex">
        <option value="">- Select -</option>
        <option value="Female"<?php if (isset($_POST['idsex']) AND ($_POST['idsex'] == 'Female')) echo ' selected="selected"'; ?>>Female</option>
        <option value="Male"<?php if (isset($_POST['idsex']) AND ($_POST['idsex'] == 'Male')) echo ' selected="selected"'; ?>>Male</option>
        </select>
      
      
      <br><label class="label" for="idage">Age</label><input id="idage" type="text" name="idage" size="5" maxlength="5" value="<?php if (isset($_POST['idage'])) echo $_POST['idage']; ?>">
      <select name="idageunits">
        <option value="years">years</option>
        <option value="months"<?php if (isset($_POST['idageunits']) AND ($_POST['idageunits'] == 'months')) echo ' selected="selected"'; ?>>months</option>
        <option value="fmonths"<?php if (isset($_POST['idageunits']) AND ($_POST['idageunits'] == 'fmonths')) echo ' selected="selected"'; ?>>fetal months</option>
        </select> 
      
      
      
      
      
      <br><label class="label" for="idrace">Race/Ethnicity</label>
      <input type="checkbox" name="race_asian" value="<?php echo $_POST['race_asian'];?>" />Asian/Pacific Islander
      <input type="checkbox" name="race_black" value="<?php echo $_POST['race_black'];?>" />Black/African-American
      <input type="checkbox" name="race_hispanic" value="<?php echo $_POST['race_hispanic'];?>" />Hispanic<br />
      <label class="label" for="idrace2"></label>
      <input type="checkbox" name="race_native" value="<?php echo $_POST['race_native'];?>" />Native American
      <input type="checkbox" name="race_white" value="<?php echo $_POST['race_white'];?>" />White
      <input type="checkbox" name="race_other" value="<?php echo $_POST['race_other'];?>" />Other: &nbsp; <input id="race_othertext" type="text" name="race_othertext" size="18" maxlength="30" value="<?php if (isset($_POST['race_othertext'])) echo $_POST['race_othertext']; ?>">
      
      
      <br><label class="label" for="idstature">Stature</label><input id="idstature" type="text" name="idstature" size="6" maxlength="8" value="<?php if (isset($_POST['idstature'])) echo $_POST['idstature']; ?>" >
      
      <select name="idstatureunits">
        <option value="in">inches</option>
        <option value="cm"<?php if (isset($_POST['idstatureunits']) AND ($_POST['idstatureunits'] == 'cm')) echo ' selected="selected"'; ?>>cm</option>
        </select>
      
      <br />
      
      <br><label class="label" for="idsource">Information Source</label><input id="idsource" type="text" name="idsource" size="30" maxlength="60" value="<?php if (isset($_POST['idsource'])) echo $_POST['idsource']; ?>" ><br />
      
  </fieldset>
    <fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend>Case Notes</legend>
      <label class="label" for="casenotes"></label>
      <textarea name="casenotes" cols="55" rows="7" value="<?php if (isset($_POST['casenotes'])) echo $_POST['casenotes']; ?>"></textarea> 
      
      
      
      
      
      
      
      </fieldset>
    
  <br />	<br /> <label class="label" for="savecase">Click here to register</label>
    <input name="savecase" id="savecase" type="submit" value="Save Case"/>
    
    
    </fieldset>
  <div id="casedata_errorloc">
    </div>
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
  
  <div id="rightnav"> right nav </div>
  
</div>
<div id="footer">Copyright 2014 by <a href="http://www.sofainc.org/" target="_blank">SOFA</a>.</div>
</div>




</body>
</html>

