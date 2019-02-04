<?php 
require_once("../../include/header_user.php");
require_once('../../include/session_user.php') ;
?>

<BR/>
  <h1 class="cntr">Edit Profile</h1>
  
  
  <div id="phperror">
  <?php

$memberid=$_SESSION['id'];
$q="SELECT * FROM members WHERE id=$memberid";

$mresult=mysqli_query($dbcon,$q);
if(!$mresult)
{echo 'Could not load user data from database';exit();}

$memberdata=mysqli_fetch_array($mresult);

// Connect to the database.
// This code inserts a record into the users table
// Has the form been submitted?
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$errors = array(); // Start an array to hold the errors
	$pwdflag=0;
	$pwmatch=0;
	// Check for a title:
	if (empty($_POST['title2'])) {
		$errors[] = 'You forgot to enter your title.';
	} else {
		$title = mysqli_real_escape_string($dbcon, trim($_POST['title2']));
	}
	// Check for a first name:
	if (empty($_POST['fname'])) {
		$errors[] = 'You forgot to enter your first name.';
	} else {
			$fn = mysqli_real_escape_string($dbcon, trim($_POST['fname']));
	}
	// Check for a last name:
	if (empty($_POST['lname'])) {
		$errors[] = 'You forgot to enter your last name.';
	} else {
		$ln = mysqli_real_escape_string($dbcon, trim($_POST['lname']));
	}
	// Check for an email address:
	if (!empty($_POST['email'])) {
		if ($_POST['email'] != $_POST['email2']) {
			$errors[] = 'Your two email addresses did not match.';
		} else {
			$e = mysqli_real_escape_string($dbcon, trim($_POST['email']));
		}
	} else {
		$errors[] = 'You forgot to enter your email address.';
	}
	$slt = SALT;
	$passold =  $_POST['psword3'];
	$hashold=md5($slt . $passold);
	if(empty($_POST['psword3']))
	{$errors[] = 'You must enter your current password into the Old/Current password box to update your profile.';
	}
	elseif ($memberdata['pwd']==$hashold) {
		$pwdmatch=1;}
	else {$pwmatch=0;
	$errors[] = 'Incorrect old/current password. Old/current password required to make changes.';
	}
	// Check for a password and match it against the confirmed password:
	if (!empty($_POST['psword1'])) {
		
		if ($_POST['psword1'] != $_POST['psword2']) {
			$errors[] = 'Your two new passwords did not match.';
		} else {
			$p = mysqli_real_escape_string($dbcon, trim($_POST['psword1']));$pwdflag=1;
			$s = SALT;
			$hashnew=md5($s . $p);
		}
	}
	
	if (empty($_POST['institution'])) {
		$errors[] = 'You forgot to enter your institution.';
	} else {
		$inst = trim($_POST['institution']);
	}

	
	// Check for address1:
	if (empty($_POST['addr1'])) {
		$errors[] = 'You forgot to enter your address.';
	} else {
		$ad1 = mysqli_real_escape_string($dbcon, trim($_POST['addr1']));
	}
	// Check for address2:
		if (!empty($_POST['addr2'])) {
		$ad2 = mysqli_real_escape_string($dbcon, trim($_POST['addr2']));
}else{
$ad2 = NULL;
	}
	// Check for city:
	if (empty($_POST['city'])) {
		$errors[] = 'You forgot to enter your City.';
	} else {
		$cty = mysqli_real_escape_string($dbcon, trim($_POST['city']));
	}
// Check for the county:
	if (empty($_POST['state'])) {
		$errors[] = 'You forgot to enter your state.';
	} else {
		$state = mysqli_real_escape_string($dbcon, trim($_POST['state']));
	}	
	// Check for the post code:
	if (empty($_POST['pcode'])) {
		$errors[] = 'You forgot to enter your postal (ZIP) code.';
	} else {
		$pcode = mysqli_real_escape_string($dbcon, trim($_POST['pcode']));
	}
	// Check for the phone number:
		if (!empty($_POST['phone'])) {
		$ph = mysqli_real_escape_string($dbcon, trim($_POST['phone']));
}else{
$ph = NULL;
	}
	
	if (empty($_POST['degree'])) {
		$degree=NULL;
		//$errors[] = 'You forgot to enter your highest degree earned';
	} else {
		$degree = mysqli_real_escape_string($dbcon, trim($_POST['degree']));
	}
	
	if (empty($_POST['degreeyear'])) {
		//$errors[] = 'You forgot to enter the year you earned your degree.';
		$degreeyear=NULL;
	} else {
		$degreeyear = mysqli_real_escape_string($dbcon, trim($_POST['degreeyear']));
	}
	
	if (empty($_POST['fieldofstudy'])) {
	//	$errors[] = 'You forgot to enter your field of study.';
	$field=NULL;
	} else {
		$field = mysqli_real_escape_string($dbcon, trim($_POST['fieldofstudy']));
	}
	
	if (!isset($_POST['yearsexp'])) {
	//	$errors[] = 'You forgot to enter your years of experience.';
	$exp=NULL;
	} else {
		$exp = mysqli_real_escape_string($dbcon, trim($_POST['yearsexp']));
	}
	
	if (!isset($_POST['casesperyear'])) {
	//	$errors[] = 'You forgot to enter your average number of cases per year.';
	$cases=NULL;
	} else {
		$cases = mysqli_real_escape_string($dbcon, trim($_POST['casesperyear']));
	}
	
	if (empty($_POST['region'])) {
		$errors[] = 'You forgot to enter your region of practice.';
	} else {
		$region = mysqli_real_escape_string($dbcon, trim($_POST['region']));
	}
	
	if (empty($_POST['aafs'])) {
		$errors[] = 'You forgot to enter your AAFS Membership Status';
	} else {
		$aafs = mysqli_real_escape_string($dbcon, trim($_POST['aafs']));
	}
	
	
		if($e!=$memberdata['uname'])
	{		$q = "SELECT id FROM members WHERE uname = '$e' ";
$result=mysqli_query ($dbcon, $q) ; 	
if (mysqli_num_rows($result) != 0){$errors[] = 'This email address is already registered. Please enter a different email address.';}
	}
	
	if (empty($errors)) { // If there were no errors

		// Make the query:
	
			
			if($pwdflag==1){
		$q = "UPDATE members SET uname='$e',firstname='$fn',lastname='$ln',title='$title',degree='$degree',degreeyear='$degreeyear',fieldofstudy='$field',aafsstatus='$aafs', institution='$inst',yearsexperience='$exp',caseperyear='$cases',region='$region', mailaddress='$ad1',mailaddress2='$ad2',city='$cty',state='$state',zip='$pcode',phone='$ph', pwd='$hashnew' WHERE id='$memberid'";	}
		else
		{$q = "UPDATE members SET uname='$e',firstname='$fn',lastname='$ln',title='$title',degree='$degree',degreeyear='$degreeyear',fieldofstudy='$field',aafsstatus='$aafs', institution='$inst',yearsexperience='$exp',caseperyear='$cases',region='$region', mailaddress='$ad1',mailaddress2='$ad2',city='$cty',state='$state',zip='$pcode',phone='$ph' WHERE id='$memberid'";
			
			}
			
		$result = @mysqli_query ($dbcon, $q); // Run the query.
		if ($result) { // If it ran OK.
		ob_start();
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

	} else { // Report the errors.
		echo '<span style="padding-left:100px; 
    display:block;"><h2>Error!</h2>
		<p class="error">The following error(s) occurred:<br>';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br>\n";
		}
		echo '</p><h3>Please try again.</h3><p><br></p></span>';
		}// End of if (empty($errors))
} // End of the main Submit conditional.
?></div>
  
  
  
  <div id="editform">
  <form action="index.php" method="post" id="registration">
    
    
  <fieldset style="border: solid 2px #cc0000;overflow: hidden;" class="roundedborder">
  <fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend class="boldlegend">Basic Information</legend>
    
    
 <center><strong class="outsidetext">* indicates required field</strong></center>
     <br><label class="label" for="fname">First Name*</label><input id="fname" type="text" name="fname" size="30" maxlength="30" value="<?php if (isset($memberdata['firstname'])) echo $memberdata['firstname']; ?>">
    <br><label class="label" for="lname">Last Name*</label><input id="lname" type="text" name="lname" size="30" maxlength="40" value="<?php if (isset($memberdata['lastname'])) echo $memberdata['lastname']; ?>">
    <br><label class="label" for="email">Email Address*</label><input id="email" type="text" name="email" size="30" maxlength="160" value="<?php if (isset($memberdata['uname'])) echo $memberdata['uname']; ?>" >
    <br><label class="label" for="email">Confirm Email Address*</label><input id="email2" type="text" name="email2" size="30" maxlength="160" value="<?php if (isset($memberdata['uname'])) echo $memberdata['uname']; ?>" > 
    
    <br><label class="label" for="psword3">Old/Current Password*</label><input id="psword3" type="password" name="psword3" size="12" maxlength="50" value="" >
    <br><label class="label" for="psword1">New Password</label><input id="psword1" type="password" name="psword1" size="12" maxlength="50" value="" >
    <br><label class="label" for="psword2">Confirm New Password</label><input id="psword2" type="password" name="psword2" size="12" maxlength="50" value="" ><br /><br></fieldset>
    
    <fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend class="boldlegend">Current Address</legend>
      <br> <label class="label" for="title2">Job Title*</label><input id="title2" type="text" name="title2" size="30" maxlength="100" value="<?php if (isset($memberdata['title'])) echo $memberdata['title']; ?>">
  <br><label class="label" for="institution">Institution*</label><input id="institution" type="text" name="institution" size="30" maxlength="100" value="<?php if (isset($memberdata['institution'])) echo $memberdata['institution']; ?>" > 
      <br><label class="label" for="addr1">Address*</label><input id="addr1" type="text" name="addr1" size="30" maxlength="100" value="<?php if (isset($memberdata['mailaddress'])) echo $memberdata['mailaddress']; ?>">
      <br><label class="label" for="addr2">Address</label><input id="addr2" type="text" name="addr2" size="30" maxlength="100" value="<?php if (isset($memberdata['mailaddress2'])) echo $memberdata['mailaddress2']; ?>">
      <br><label class="label" for="city">City*</label><input id="city" type="text" name="city" size="30" maxlength="100" value="<?php if (isset($memberdata['city'])) echo $memberdata['city']; ?>">
      <br><label class="label" for="state">State*</label><input id="state" type="text" name="state" size="30" maxlength="30" value="<?php if (isset($memberdata['state'])) echo $memberdata['state']; ?>">
      <br><label class="label" for="pcode">Postal (ZIP) Code*</label><input id="pcode" type="text" name="pcode" size="15" maxlength="15" value="<?php if (isset($memberdata['zip'])) echo $memberdata['zip']; ?>">
      <br><label class="label" for="phone">Telephone</label><input id="phone" type="text" name="phone" size="30" maxlength="30" value="<?php if (isset($memberdata['phone'])) echo $memberdata['phone']; ?>"><br /><br>
      
  </fieldset>
    <fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend class="boldlegend">Education and Experience</legend><br><center><strong class="outsidetext">** indicates information that may be downloaded by users for research purposes</strong></center>
     <br> <label class="label" for="aafs">AAFS Membership Status*</label>
      <select name="aafs">
        <option value="">- Select -</option>
        <option value="1"<?php if (isset($memberdata['aafsstatus']) AND ($memberdata['aafsstatus'] == '1')) echo ' selected="selected"'; ?>>Student Affiliate</option>
        <option value="2"<?php if (isset($memberdata['aafsstatus']) AND ($memberdata['aafsstatus'] == '2')) echo ' selected="selected"'; ?>>Trainee Affiliate</option>
        <option value="3"<?php if (isset($memberdata['aafsstatus']) AND ($memberdata['aafsstatus'] == '3')) echo ' selected="selected"'; ?>>Associate Member</option>
        <option value="5"<?php if (isset($memberdata['aafsstatus']) AND ($memberdata['aafsstatus'] == '5')) echo ' selected="selected"'; ?>>Member</option>
        <option value="6"<?php if (isset($memberdata['aafsstatus']) AND ($memberdata['aafsstatus'] == '6')) echo ' selected="selected"'; ?>>Fellow</option>
        
        <option value="4"<?php if (isset($memberdata['aafsstatus']) AND ($memberdata['aafsstatus'] == '4')) echo ' selected="selected"'; ?>>Not A Member</option>
        </select>
         <br><label class="label" for="region">Region of Practice*</label>
      <select name="region">
        <option value="">- Select -</option>
        <option value="1"<?php if (isset($memberdata['region']) AND ($memberdata['region'] == '1')) echo ' selected="selected"'; ?>>Northeast</option>
        <option value="2"<?php if (isset($memberdata['region']) AND ($memberdata['region'] == '2')) echo ' selected="selected"'; ?>>West</option>
        <option value="3"<?php if (isset($memberdata['region']) AND ($memberdata['region'] == '3')) echo ' selected="selected"'; ?>>Midwest</option>
        <option value="4"<?php if (isset($memberdata['region']) AND ($memberdata['region'] == '4')) echo ' selected="selected"'; ?>>South</option>
        </select>
        
    
      <br><label class="label" for="degree">Education**</label>
      <select name="degree">
        <option value="">- Select -</option>
        <option value="None"<?php if (isset($memberdata['degree']) AND ($memberdata['degree'] == 'None')) echo ' selected="selected"'; ?>>None</option>
        <option value="BS"<?php if (isset($memberdata['degree']) AND ($memberdata['degree'] == 'BS')) echo ' selected="selected"'; ?>>Bachelor of Science or Arts</option>
        <option value="MS"<?php if (isset($memberdata['degree']) AND ($memberdata['degree'] == 'MS')) echo ' selected="selected"'; ?>>Masters Degree</option>
        <option value="Phd"<?php if (isset($memberdata['degree']) AND ($memberdata['degree'] == 'Phd')) echo ' selected="selected"'; ?>>Phd</option>
        </select>
      <br><label class="label" for="degreeyear">Year Earned (YYYY format)**</label><input id="degreeyear" type="text" name="degreeyear" size="30" maxlength="4" value="<?php if (isset($memberdata['degreeyear'])) echo $memberdata['degreeyear']; ?>" >
      <br><label class="label" for="fieldofstudy">Field of Study</label><input id="fieldofstudy" type="text" name="fieldofstudy" size="30" maxlength="60" value="<?php if (isset($memberdata['fieldofstudy'])) echo $memberdata['fieldofstudy']; ?>" >
      
      <br><label class="label" for="yearsexp">Years of Forensic Casework</label><input id="yearsexp" type="text" name="yearsexp" size="30" maxlength="3" value="<?php if (isset($memberdata['yearsexperience'])) echo $memberdata['yearsexperience']; ?>" >
      
      <br><label class="label" for="casesperyear">Average Number of Cases/Year**</label><input id="casesperyear" type="text" name="casesperyear" size="30" maxlength="8" value="<?php if (isset($memberdata['caseperyear'])) echo $memberdata['caseperyear']; ?>" ><br /><br>
     
      
    
      
      
      
      </fieldset>
    
  <br />	<br /> <label class="label" for="regsubmit">Click here to update</label>
    <input name="regsubmit" id="regsubmit" type="submit" value="Update Profile"/>
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
 
 
  frmvalidator.addValidation("fname","req","Please enter your First Name");
  frmvalidator.addValidation("fname","maxlen=20",	"Max length for FirstName is 20");
  frmvalidator.addValidation("fname","alpha","Alphabetic chars only in first name");
  
  frmvalidator.addValidation("lname","req","Please enter your Last Name");
  frmvalidator.addValidation("lname","maxlen=20","Max length is 20");
  frmvalidator.addValidation("lname","alpha","Alphabetic chars only in last name");
  
  frmvalidator.addValidation("email","maxlen=50");
  frmvalidator.addValidation("email","req","Please enter your email address");
  frmvalidator.addValidation("email","email");
  
   frmvalidator.addValidation("psword3","req","You must enter your current password in the Old Password box to update profile");
  
  
  frmvalidator.addValidation("institution","req","Please enter your institution");
  frmvalidator.addValidation("addr1","req","Please enter your address");
  frmvalidator.addValidation("city","req","Please enter your city");
 
	
	frmvalidator.addValidation("state","req","Please enter your state");
  
   frmvalidator.addValidation("pcode","req","Please enter your zip code");
  
   frmvalidator.addValidation("pcode","numeric","Zip code must be a number");
    frmvalidator.addValidation("phone","numeric","Phone number must be a number");
  
  //frmvalidator.addValidation("degree","req","Please select your highest degree earned");
 
 // frmvalidator.addValidation("degreeyear","req","Please enter your degree year");
 
 
  frmvalidator.addValidation("degreeyear","maxlen=4");
  frmvalidator.addValidation("degreeyear","minlen=4");
  frmvalidator.addValidation("degreeyear","numeric", "Degree year must be a number in YYYY format");
   frmvalidator.addValidation("degreeyear","gt=1900");
  
  
  // frmvalidator.addValidation("fieldofstudy","req","Please enter your field of study");
   
 //  frmvalidator.addValidation("yearsexp","req","Please enter your years of experience");
   frmvalidator.addValidation("yearsexp","numeric","Years experience must be a number");
    frmvalidator.addValidation("yearsexp","gt=-1","Years experience must be greater than or equal to zero");
   
  // frmvalidator.addValidation("casesperyear","req","Please enter your average number of cases per year");
   frmvalidator.addValidation("casesperyear","numeric","Cases per year must be a number");
   frmvalidator.addValidation("casesperyear","gt=-1","Cases per year must be greater than or equal to zero");
   
   frmvalidator.addValidation("region","req","Please select your region");
   
   frmvalidator.addValidation("aafs","req","Please select your AAFS membership status");

//]]></script>
    
    
<?php
require_once("../../include/footer.php");
?>

