<?php


  if(isset($_SESSION['loggedin']))
  {
     require_once("include/session.inc.php"); 
  } else {
       session_start();
  }
require_once("../conf/settings.inc.php");
require_once("../conf/app.inc.php");
require_once("include/main.inc.php");


?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Register</title>
<!-- CSS -->
 <link href="<?php echo(ROOT_URL) ?>/css/style.css" rel="stylesheet" type="text/css" />
 <link rel="stylesheet" type="text/css" href="/css/jquery.multiselect.css" />

 <!-- JS -->
<script type="text/javascript" src="vendor/components/jquery/jquery.js"></script>
<script type="text/javascript" src="vendor/components/jquery-ui/ui/minified/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/gen_validatorv4.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />


<title>SOFA Forensic Anthropology Case Database (FADAMA)</title>


<!-- // Load Javascipt -->
</head>

<body>
<div id="top">
<div id="header"><a href="#"><img src="images/customLogo.gif" width="351" height="147" /></a></div>

<div id="title">
<h1>Forensic Anthropology Case Database (FADAMA)</h1>
</div>

<div id="hline">
<hr size="3" />
</div>



<div id="navbar">
  <ul>
    <li><a href="<?php echo(ROOT_URL);?>">Home</a></li>
<?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==1) {
?>
    <li><a href="<?php echo(ROOT_URL) ?>/user/searchdb/?search=1">Search</a></li>
    <li><a href="<?php echo(ROOT_URL) ?>/faq.php">FAQ</a></li>
    <li><a href="<?php echo(ROOT_URL) ?>/contact/">Contact Us</a></li>
<?php

    }
?>
  </ul>
</div>

<div id="hline">
<hr size="3" />
</div>

<?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==1) {
?>
    
<div id="navigation"></div>
<?php

    }
?>
<div id="templatecontainer"> 
     <div id="caseform">
  </br>
  <h1 class="cntr">Membership Registration</h1>
  
  <?php
// This code inserts a record into the users table
// Has the form been submitted?
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$errors = array(); // Start an array to hold the errors
	// Check for a title:
	if (empty($_POST['title2'])) {
		$errors[] = 'You forgot to enter your title.';
	} else {
		$title = trim($_POST['title2']);
	}
	// Check for a first name:
	if (empty($_POST['fname'])) {
		$errors[] = 'You forgot to enter your first name.';
	} else {
			$fn = trim($_POST['fname']);
	}
	// Check for a last name:
	if (empty($_POST['lname'])) {
		$errors[] = 'You forgot to enter your last name.';
	} else {
		$ln = trim($_POST['lname']);
	}
        /*
         * // Check if email is valid
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email address '".$_POST['email']."' is not considered valid.\n";
        }
         * 
         */
	// Check for an email address:
	if (!empty($_POST['email'])) {
		if ($_POST['email'] != $_POST['email2']) {
			$errors[] = 'Your two email addresses did not match.';
		} else {
			$e = trim($_POST['email']);
		}
	} else {
		$errors[] = 'You forgot to enter your email address.';
	}
	
	
	
	// Check for a password and match it against the confirmed password:
	if (!empty($_POST['psword1'])) {
		if ($_POST['psword1'] != $_POST['psword2']) {
			$errors[] = 'Your two passwords did not match.';
		} else {
			$p = trim($_POST['psword1']);
                        $s = SALT;
                        $hash=md5($s . $p);
		}
	} else {
		$errors[] = 'You forgot to enter your password.';
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
		$ad1 = trim($_POST['addr1']);
	}
	// Check for address2:
	if (!empty($_POST['addr2'])) {
		$ad2 = trim($_POST['addr2']);
        }else{
            $ad2 = NULL;
	}
	// Check for city:
	if (empty($_POST['city'])) {
		$errors[] = 'You forgot to enter your City.';
	} else {
		$cty = trim($_POST['city']);
	}
// Check for the county:
	if (empty($_POST['state'])) {
		$errors[] = 'You forgot to enter your state.';
	} else {
		$state = trim($_POST['state']);
	}	
	// Check for the post code:
	if (empty($_POST['pcode'])) {
		$errors[] = 'You forgot to enter your postal (ZIP) code.';
	} else {
		$pcode = trim($_POST['pcode']);
	}
	// Check for the phone number:
	if (!empty($_POST['phone'])) {
		$ph = trim($_POST['phone']);
        }else{
            $ph = NULL;
	}
	
	if (empty($_POST['region'])) {
		$errors[] = 'You forgot to enter your region of practice.';
	} else {
		$region = trim($_POST['region']);
	}
	
	if (empty($_POST['aafs'])) {
		$errors[] = 'You forgot to enter your AAFS Membership Status';
	} else {
		$aafs = trim($_POST['aafs']);
	}
	
	
	
	if (empty($_POST['degree'])) {
		$degree="";
	} else {
		$degree = trim($_POST['degree']);
	}
	
	if (!empty($_POST['degreeyear'])) {
		$degreeyear = trim($_POST['degreeyear']);
	} else {
                $degreeyear = 0;
	}
	
	if (!empty($_POST['fieldofstudy'])) {
		$field = trim($_POST['fieldofstudy']);
	} else {
		$field="";
	}
	
	if (!empty($_POST['yearsexp'])) {
		$exp = trim($_POST['yearsexp']);
	} else {
		$exp=0;
	}
	
	if (!empty($_POST['casesperyear'])) {
		$cases = trim($_POST['casesperyear']);
	} else {
                $cases=0;	
	}
        
        if (!empty($_POST['affiliation'])) {
		$affiliation = trim($_POST['affiliation']);
	} else {
		$affiliation="";
	}
        
        if (!empty($_POST['sponsor'])) {
		$sponsor = trim($_POST['sponsor']);
	} else {
		$sponsor="";
	}
        
        if (!empty($_POST['sponsor_email'])) {
		$sponsor_email = trim($_POST['sponsor_email']);
	} else {
		$sponsor_email="";
	}
        
        if (!empty($_POST['sponsor_affiliation'])) {
		$sponsor_affiliation = trim($_POST['sponsor_affiliation']);
	} else {
		$sponsor_affiliation="";
	}
        
        $params = array(
            "uname"=>$e,
            "pwd"=>$hash,
            "firstname"=>$fn,
            "lastname"=>$ln,
            "title"=>$title,
            "degree"=>$degree,
            "degreeyear"=>$degreeyear,
            "fieldofstudy"=>$field,
            "aafsstatus"=>$aafs,
            "institution"=>$inst,
            "yearsexperience"=>$exp,
            "caseperyear"=>$cases,
            "region"=>$region,
            "mailaddress1"=>$ad1,
            "mailaddress2"=>$ad2,
            "city"=>$cty,
            "state"=>$state,
            "zip"=>$pcode,
            "phone"=>$ph,
            "affiliation"=>$affiliation,
            "sponsor"=>$sponsor,
            "sponsor_email"=>$sponsor_email,
            "sponsor_affiliation"=>$sponsor_affiliation);
 

	
	if (empty($errors)) { // If there were no errors
//Determine whether the email address has already been registered	

   $member_exists = member::member_exists($db, $e);       

   if(!$member_exists) {

        $result = member::add_member($db, $params);
        if($result['RESULT'] == TRUE) {
            echo($result['MESSAGE']);
	  //$admin_email="hughesc@illinois.edu";
      $admin_email = ADMIN_EMAIL;              
      $to = $admin_email;
   //$from="admin@sofainc.org";
      $from= $admin_email;
   $subject = "FADAMA DB ADMIN ALERT: Activate new user";
   $message = "New User:".$fn." ".$ln." is requesting activation.\n Email address is:".$e."\n\n";
   
   $message .= "User data:\n".
            "Email: $e\n" .
            "First Name: $fn\n".
            "Last Name: $ln\n".
            "Title: $title\n".
            "Degree: $degree\n".
            "Degree Year: $degreeyear\n".
            "Field of Study: $field\n".
            "AAFS Status: $aafs\n".
            "Institution: $inst\n".
            "Years of Experience: $exp\n".
            "Cases per year: $cases\n".
            "Region: $region\n".
            "Address 1: $ad1\n".
            "Address 2: $ad2\n".
            "City: $cty\n".
            "State: $state\n".
            "Zip: $pcode\n".
            "Phone: $ph\n".
            "Affiliation: $affiliation\n".
            "Sponsor: $sponsor\n".
            "Sponsor email: $sponsor_email\n".
            "Sponsor affiliation: $sponsor_affiliation\n";
           
           
   $header = "From:".$from."\r\n";
   $retval = mail($to,$subject,$message,$header);
   
   // Also email user
   $user_to = $e;
   $user_subject = "FADAMA Membership Request";
   $user_message = "Thank you for requesting membership approval to FADAMA. Your request is under review and may take up to 1 week to be approved.";
   $user_header = "From:".$admin_email."\r\n";
   
   $user_retval = mail($user_to, $user_subject, $user_message, $user_header);
   
   if( $retval == true )  
   {
     echo("Thank you for requesting membership approval to FADAMA. Your request is under review and may take up to 1 week to be approved.");
	  
   }
   else
   {
      echo "Error: Activation Email Not Sent Contact Administrator.";
   }
	
	
	
		
		} else { // If it did not run OK
		// Error message:
			echo '<h2>System Error</h2>
			<p class="error">Registration failed because of a system error. We apologize for any inconvenience.</p>'; 
			// Debugging message:
			echo '<p>' . $result['MESSAGE']. '</p>';
		} // End of if ($result)

		// Include the footer and stop the script
		  
		exit();
}else{//The email address is already registered
echo	'<p class="error">The email address is not acceptable because it is already registered</p>';
}
	} else { // Report the errors.
		echo '<h2>Error!</h2>
		<p class="error">The following error(s) occurred:<br>';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br>\n";
		}
		echo '</p><h3>Please try again.</h3><p><br></p>';
		}// End of if (empty($errors))
}// End of the main Submit conditional.
?>
  
  
  
  
  <div id="registerform">
  <form action="register.php" method="post" id="registration">
    
    
  <fieldset style="border: solid 2px #cc0000;overflow: hidden;" class="roundedborder">
  <fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend class="boldlegend">Basic Information</legend>
    
    
     <center><strong class="outsidetext">* indicates required field</strong></center>
  <br>  <label class="label" for="fname">First Name*</label><input id="fname" type="text" name="fname" size="30" maxlength="30" value="<?php if (isset($_POST['fname'])) echo $_POST['fname']; ?>">
    <br><label class="label" for="lname">Last Name*</label><input id="lname" type="text" name="lname" size="30" maxlength="40" value="<?php if (isset($_POST['lname'])) echo $_POST['lname']; ?>">
    <br><label class="label" for="email">Email Address*</label><input id="email" type="text" name="email" size="30" maxlength="160" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" >
    <br><label class="label" for="email">Confirm Email Address*</label><input id="email2" type="text" name="email2" size="30" maxlength="160" value="<?php if (isset($_POST['email2'])) echo $_POST['email2']; ?>" > 
    
    
    <br><label class="label" for="psword1">Password*</label><input id="psword1" type="password" name="psword1" size="12" maxlength="50" value="<?php if (isset($_POST['psword1'])) echo $_POST['psword1']; ?>" >
    <br><label class="label" for="psword2">Confirm Password*</label><input id="psword2" type="password" name="psword2" size="12" maxlength="50" value="<?php if (isset($_POST['psword2'])) echo $_POST['psword2']; ?>" ><br /><br></fieldset>
    
    <fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend class="boldlegend">Current Address</legend>
     <br > <label class="label" for="title2">Job Title*</label><input id="title2" type="text" name="title2" size="30" maxlength="100" value="<?php if (isset($_POST['title2'])) echo $_POST['title2']; ?>"><br>
      <label class="label" for="institution">Institution*</label><input id="institution" type="text" name="institution" size="30" maxlength="100" value="<?php if (isset($_POST['institution'])) echo $_POST['institution']; ?>" > 
      <br><label class="label" for="addr1">Address*</label><input id="addr1" type="text" name="addr1" size="30" maxlength="100" value="<?php if (isset($_POST['addr1'])) echo $_POST['addr1']; ?>">
      <br><label class="label" for="addr2">Address</label><input id="addr2" type="text" name="addr2" size="30" maxlength="100" value="<?php if (isset($_POST['addr2'])) echo $_POST['addr2']; ?>">
      <br><label class="label" for="city">City*</label><input id="city" type="text" name="city" size="30" maxlength="100" value="<?php if (isset($_POST['city'])) echo $_POST['city']; ?>">
      <br><label class="label" for="county">State*</label><input id="state" type="text" name="state" size="30" maxlength="30" value="<?php if (isset($_POST['state'])) echo $_POST['state']; ?>">
      <br><label class="label" for="pcode">Postal (ZIP) Code*</label><input id="pcode" type="text" name="pcode" size="15" maxlength="15" value="<?php if (isset($_POST['pcode'])) echo $_POST['pcode']; ?>">
      <br><label class="label" for="phone">Telephone</label><input id="phone" type="text" name="phone" size="30" maxlength="30" value="<?php if (isset($_POST['phone'])) echo $_POST['phone']; ?>"><br /><br>
      
  </fieldset>
    <fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend class="boldlegend">Education and Experience</legend>
      <center><strong class="outsidetext">** indicates information that may be downloaded by users for research purposes</strong></center>
      <br ><label class="label" for="aafs">AAFS Membership Status*</label>
      <select name="aafs">
        <option value="">- Select -</option>
        <option value="1"<?php if (isset($_POST['aafs']) AND ($_POST['aafs'] == '1')) echo ' selected="selected"'; ?>>Student Affiliate</option>
        <option value="2"<?php if (isset($_POST['aafs']) AND ($_POST['aafs'] == '2')) echo ' selected="selected"'; ?>>Trainee Affiliate</option>
        <option value="3"<?php if (isset($_POST['aafs']) AND ($_POST['aafs'] == '3')) echo ' selected="selected"'; ?>>Associate Member</option>
        <option value="5"<?php if (isset($_POST['aafs']) AND ($_POST['aafs'] == '5')) echo ' selected="selected"'; ?>>Member</option>
        <option value="6"<?php if (isset($_POST['aafs']) AND ($_POST['aafs'] == '6')) echo ' selected="selected"'; ?>>Fellow</option>
        <option value="4"<?php if (isset($_POST['aafs']) AND ($_POST['aafs'] == '4')) echo ' selected="selected"'; ?>>Not A Member</option>
        
        
        </select>
      
      <br><label class="label" for="region">Current Region of Practice*</label>
      <select name="region">
        <option value="">- Select -</option>
        <option value="1"<?php if (isset($_POST['region']) AND ($_POST['region'] == '1')) echo ' selected="selected"'; ?>>Northeast</option>
        <option value="2"<?php if (isset($_POST['region']) AND ($_POST['region'] == '2')) echo ' selected="selected"'; ?>>West</option>
        <option value="3"<?php if (isset($_POST['region']) AND ($_POST['region'] == '3')) echo ' selected="selected"'; ?>>Midwest</option>
        <option value="4"<?php if (isset($_POST['region']) AND ($_POST['region'] == '4')) echo ' selected="selected"'; ?>>South</option>
        </select>
      <br><label class="label" for="degree">Education**</label>
      <select name="degree">
        <option value="">- Select -</option>
        <option value="None"<?php if (isset($_POST['degree']) AND ($_POST['degree'] == 'None')) echo ' selected="selected"'; ?>>None</option>
        <option value="BS"<?php if (isset($_POST['degree']) AND ($_POST['degree'] == 'BS')) echo ' selected="selected"'; ?>>Bachelor of Science or Arts</option>
        <option value="MS"<?php if (isset($_POST['degree']) AND ($_POST['degree'] == 'MS')) echo ' selected="selected"'; ?>>Masters Degree</option>
        <option value="Phd"<?php if (isset($_POST['degree']) AND ($_POST['degree'] == 'Phd')) echo ' selected="selected"'; ?>>Phd</option>
        </select>
      <br><label class="label" for="degreeyear">Year Earned (YYYY format)**</label><input id="degreeyear" type="text" name="degreeyear" size="30" maxlength="4" value="<?php if (isset($_POST['degreeyear'])) echo $_POST['degreeyear']; ?>" >
      <br><label class="label" for="fieldofstudy">Field of Study</label><input id="fieldofstudy" type="text" name="fieldofstudy" size="30" maxlength="60" value="<?php if (isset($_POST['fieldofstudy'])) echo $_POST['fieldofstudy']; ?>" >
      
      
      <br><label class="label" for="yearsexp">Years of Forensic Casework</label><input id="yearsexp" type="text" name="yearsexp" size="30" maxlength="3" value="<?php if (isset($_POST['yearsexp'])) echo $_POST['yearsexp']; ?>" >
      
      <br><label class="label" for="casesperyear">Average Number of Cases/Year**</label><input id="casesperyear" type="text" name="casesperyear" size="30" maxlength="8" value="<?php if (isset($_POST['casesperyear'])) echo $_POST['casesperyear']; ?>" ><br />
                  
      <br><label class="label" for="affiliation">Other Forensic Governing Body Affiliation (e.g. FASE, ALAF):</label><input id="affiliation" type="text" name="affiliation" size="30"  value="<?php if (isset($_POST['affiliation'])) echo $_POST['affiliation']; ?>" >
        <br>If you aren't a member of a forensic governing body, you are required to have a sponsor in order to access FADAMA. Fill out their name, email, and affiliated membership in the space below
        <br><label class="label" for="sponsor">Sponsor:</label><input id="sponsor" type="text" name="sponsor" size="30" value="<?php if (isset($_POST['sponsor'])) echo $_POST['sponsor']; ?>" >
        <br><label class="label" for="sponsor_email">Sponsor Email:</label><input id="sponsor_email" type="text" name="sponsor_email" size="30" value="<?php if (isset($_POST['sponsor_email'])) echo $_POST['sponsor_email']; ?>" >
        <br><label class="label" for="sponsor_affiliation">Sponsor Affiliation:</label><input id="sponsor" type="text" name="sponsor_affiliation" size="30"  value="<?php if (isset($_POST['sponsor_affiliation'])) echo $_POST['sponsor_affiliation']; ?>" >
                <BR><BR>
      
      
      
      
      </fieldset>
 <fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend class="boldlegend">Code of Conduct for Database Usage</legend>
By requesting registration to the FADAMA Database, I agree to the following guidelines of professional conduct:
<br/><br/>
<ol>
  <li>I shall seek and obtain permission from my institution to submit anonymous casework data to the FADAMA Database.</li><br/>
  <li>I shall cooperate with other professionals in the forensic sciences to promote the advancement of forensic anthropology through scientific research. Knowledge of any new discoveries, developments or techniques applicable to the forensic sciences shall be shared with the peer community.</li><br/>
  <li>I shall make examinations of FADAMA Database data utilizing generally accepted scientific techniques and methods which are reliable and accurate with appropriate standards, controls, and statistical frameworks.
</li><br/>
<li>I shall at all times demonstrate respect for human remains and authority, to include all aspects of recovery, analysis, data collection, research, teaching and proper disposition in accordance with applicable country, province, state, and local laws.
 </li>
</ol>
	</fieldset>

    <?php echo("Email should go to ".ADMIN_EMAIL."<BR>"); ?>
  <br />	<br /> <label class="label" for="regsubmit">Click here to register</label>
    <input name="regsubmit" id="regsubmit" type="submit" value="Register"/>
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
  
   frmvalidator.addValidation("psword1","req","Please enter a password");
   
      frmvalidator.addValidation("psword2","req","Please confirm your password");
  
  
  frmvalidator.addValidation("institution","req","Please enter your institution");
  frmvalidator.addValidation("addr1","req","Please enter your address");
  frmvalidator.addValidation("city","req","Please enter your city");
 
	
	frmvalidator.addValidation("state","req","Please enter your state");
  
   frmvalidator.addValidation("pcode","req","Please enter your zip code");
  
   frmvalidator.addValidation("pcode","numeric","Zip code must be a number");
    frmvalidator.addValidation("phone","numeric","Phone number must be a number");
  
 // frmvalidator.addValidation("degree","req","Please select your highest degree earned");
 
 // frmvalidator.addValidation("degreeyear","req","Please enter your degree year");
  frmvalidator.addValidation("degreeyear","gt=1900","Degree must be post-1900");
 
  frmvalidator.addValidation("degreeyear","maxlen=4");
  frmvalidator.addValidation("degreeyear","numeric","Degree year must be a number");
  
 
  
  
  
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
    
    
  </div>
  
  
  
<?php 
    require_once("include/footer.php");
?>
