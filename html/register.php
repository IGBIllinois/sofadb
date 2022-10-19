<?php
$title = "Forensic Anthropology Case Database (FADAMA) - Register";

require_once("include/main.inc.php");

if(isset($session) && $session->get_var('loggedin') == 1) {
	require_once("include/session.inc.php"); 
}
else {
       session_start();
}

require_once(__DIR__ . "/include/header_general.php");

if(isset($session) && $session->get_var('loggedin') == 1) {
	echo "<div id='navigation'></div>";
}

?>

    
<div> 
  </br>
    
  <h1 class="cntr">Membership Registration</h1>
  
  <?php
// This code inserts a record into the users table
// Has the form been submitted?
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
    echo('<div id="wrapper" style="width:500px">');
	$errors = array(); // Start an array to hold the errors
	// Check for a title:

        
        if(empty($_POST['signature'])) {
            $errors[] = "You must provide a signature.";
            $agree_to_terms = false;
        } else {
            $signature = $_POST['signature'];
        }
        
        if(empty($_POST['signature_date'])) {
            $errors[] = "You must provide a signature date.";
            $agree_to_terms = false;
        } else {
            $sig_date = $_POST['signature_date'];
            $sig_date_split = explode("-", $sig_date);
            if(!checkdate($sig_date_split[1],$sig_date_split[2],$sig_date_split[0])) {
                $errors[] = "Please enter a valid date.";
            } else {
                $signature_date = $_POST['signature_date'];
            }
        }
        
        if(!empty($signature) && !empty($signature_date)) {
            $agree_to_terms = true;
        } else {
            $agree_to_terms = false;
        }
        
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
                        $hash=password_hash($p,PASSWORD_DEFAULT );
                        
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
            "sponsor_affiliation"=>$sponsor_affiliation,
            "agree_to_terms"=>$agree_to_terms,
            "signature"=>$signature,
            "signature_date"=>$signature_date);
 
	
        if (empty($errors)) { // If there were no errors
        //Determine whether the email address has already been registered	

            $member_exists = member::member_exists($db, $e);       

            if(!$member_exists) {

                 $result = member::add_member($db, $params);
                 if($result['RESULT'] == TRUE) {

                   $admin_email = ADMIN_EMAIL;              
                   $to = $admin_email;

                   $from= FROM_EMAIL;


                    // Create tokens
                    $selector = bin2hex(random_bytes(8));
                    $token = random_bytes(32);
                    $validator = bin2hex($token);
                    try {

			// Send email to the address the user provided
                        $return_val = functions::send_register_email($db, $e, $selector, $validator, $root_url);

                    } catch(Exception $e) {
                        echo($e->getTraceAsString());
                    }
                    echo($return_val["MESSAGE"]);

            } else { // If it did not run OK
                 // Error message:
                echo '<h2>System Error</h2>
                <p class="error">Registration failed because of a system error. We apologize for any inconvenience.</p>'; 
                // Debugging message:
                echo '<p>' . $result['MESSAGE']. '</p>';
            } // End of if ($result)

     // Include the footer and stop the script

     exit();
     
    } else{//The email address is already registered
        echo '<p class="error">The email address is not acceptable because it is already registered</p>';
    }
    } else { // Report the errors.
        echo '
            <p class="error"><B>Error!</B><BR>The following error(s) occurred:<br>';
        foreach ($errors as $msg) { // Print each error.
            echo " - $msg<br>\n";
        }
        echo '</p><h3>Please try again.</h3><p><br></p>';
    }// End of if (empty($errors))
} catch(Exception $e) {
    // End of the main Submit conditional.
    echo("ERROR:".$e->getTraceAsString());
}
}
echo("</div>");
?>
  
  
  
  
  <div id="registerform" style="width:60%;padding-left:20%">
  <form action="register.php" method="post" id="registration">
    
    
  <fieldset style="border: solid 2px #cc0000;overflow: hidden;" class="roundedborder">
  <fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend class="boldlegend">Basic Information</legend>
      <BR>
      FADAMA is a free database for the broader forensic community, including researchers and practitioners at all levels of experience and education.  In order to ensure that individuals requesting FADAMA access are part of the forensic community, personal information and credentials are requested as part of this vetting process.  If you have questions or concerns about any part of this application please <a href='./contact/index.php' target='_blank'>Contact Us</a>.
      <BR>
      <BR>
    
     <center><strong class="outsidetext">* indicates required field</strong></center>
  <br>  <label class="label" for="fname">First Name*</label><input id="fname" type="text" name="fname" size="30" maxlength="30" value="<?php if (isset($_POST['fname'])) echo $_POST['fname']; ?>">
    <br><label class="label" for="lname">Last Name*</label><input id="lname" type="text" name="lname" size="30" maxlength="40" value="<?php if (isset($_POST['lname'])) echo $_POST['lname']; ?>">
    <br><label class="label" for="email">Institutional/Agency Email*</label><input id="email" type="email" name="email" size="30" maxlength="160" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" >
    <br><label class="label" for="email">Confirm Email Address*</label><input id="email2" type="email" name="email2" size="30" maxlength="160" value="<?php if (isset($_POST['email2'])) echo $_POST['email2']; ?>" > 
    
    
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
        <option value="1"<?php if (isset($_POST['region']) AND ($_POST['region'] == '1')) echo ' selected="selected"'; ?>>U.S. Northeast</option>
        <option value="2"<?php if (isset($_POST['region']) AND ($_POST['region'] == '2')) echo ' selected="selected"'; ?>>U.S. West</option>
        <option value="3"<?php if (isset($_POST['region']) AND ($_POST['region'] == '3')) echo ' selected="selected"'; ?>>U.S. Midwest</option>
        <option value="4"<?php if (isset($_POST['region']) AND ($_POST['region'] == '4')) echo ' selected="selected"'; ?>>U.S. South</option>
        <option value="5"<?php if (isset($_POST['region']) AND ($_POST['region'] == '5')) echo ' selected="selected"'; ?>>Africa</option>
        <option value="6"<?php if (isset($_POST['region']) AND ($_POST['region'] == '6')) echo ' selected="selected"'; ?>>Asia Pacific</option>
        <option value="7"<?php if (isset($_POST['region']) AND ($_POST['region'] == '7')) echo ' selected="selected"'; ?>>Central America</option>
        <option value="8"<?php if (isset($_POST['region']) AND ($_POST['region'] == '8')) echo ' selected="selected"'; ?>>Canada</option>
        <option value="9"<?php if (isset($_POST['region']) AND ($_POST['region'] == '9')) echo ' selected="selected"'; ?>>Caribbean</option>
        <option value="10"<?php if (isset($_POST['region']) AND ($_POST['region'] == '10')) echo ' selected="selected"'; ?>>Europe</option>
        <option value="11"<?php if (isset($_POST['region']) AND ($_POST['region'] == '11')) echo ' selected="selected"'; ?>>Middle East</option>
        <option value="12"<?php if (isset($_POST['region']) AND ($_POST['region'] == '12')) echo ' selected="selected"'; ?>>South America</option>
        
        
        </select>
      <br><label class="label" for="degree">Education*</label>
      <select name="degree">
        <option value="">- Select -</option>
        <option value="None"<?php if (isset($_POST['degree']) AND ($_POST['degree'] == 'None')) echo ' selected="selected"'; ?>>None</option>
        <option value="BS"<?php if (isset($_POST['degree']) AND ($_POST['degree'] == 'BS')) echo ' selected="selected"'; ?>>Bachelor of Science or Arts</option>
        <option value="MS"<?php if (isset($_POST['degree']) AND ($_POST['degree'] == 'MS')) echo ' selected="selected"'; ?>>Masters Degree</option>
        <option value="Phd"<?php if (isset($_POST['degree']) AND ($_POST['degree'] == 'Phd')) echo ' selected="selected"'; ?>>Phd</option>
        </select>
      <br><label class="label" for="degreeyear">Year Earned (YYYY format)*</label><input id="degreeyear" type="text" name="degreeyear" size="30" maxlength="4" value="<?php if (isset($_POST['degreeyear'])) echo $_POST['degreeyear']; ?>" >
      <br><label class="label" for="fieldofstudy">Field of Study</label><input id="fieldofstudy" type="text" name="fieldofstudy" size="30" maxlength="60" value="<?php if (isset($_POST['fieldofstudy'])) echo $_POST['fieldofstudy']; ?>" >
          
      <br><label class="label" for="affiliation">Other Forensic Governing Body Affiliation (e.g. FASE, ALAF):</label><input id="affiliation" type="text" name="affiliation" size="30"  value="<?php if (isset($_POST['affiliation'])) echo $_POST['affiliation']; ?>" >
        <br>If you aren't a member of a forensic governing body, you are required to have a sponsor in order to access FADAMA. Fill out their name, email, and affiliated membership in the space below
        <br><label class="label" for="sponsor">Sponsor:</label><input id="sponsor" type="text" name="sponsor" size="30" value="<?php if (isset($_POST['sponsor'])) echo $_POST['sponsor']; ?>" >
        <br><label class="label" for="sponsor_email">Sponsor Email:</label><input id="sponsor_email" type="email" name="sponsor_email" size="30" value="<?php if (isset($_POST['sponsor_email'])) echo $_POST['sponsor_email']; ?>" >
        <br><label class="label" for="sponsor_affiliation">Sponsor Affiliation:</label><input id="sponsor_affiliation" type="text" name="sponsor_affiliation" size="30"  value="<?php if (isset($_POST['sponsor_affiliation'])) echo $_POST['sponsor_affiliation']; ?>" >
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
      
      
 <fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend class="boldlegend">Terms of Service</legend>
     <BR>
         Please review FADAMA's Terms of Service, Privacy Notice, and Contributor License Agreement <a href="docs/FADMA_FINAL combined CLA_ToS_Privacy Notice.docx" target="_blank" onclick="enableAfterClick('signature');">here</a>.
     <BR><BR>
             By signing below, I acknowledge that I have read and agree to the Terms of Service, Privacy Notice, and Contributor License Agreement.<BR><BR>
                     <label class="label" for="signature">Signature (Type your full name):</label><input type="text" name="signature" id="signature" disabled> <i>(activated once the link above has been clicked)</i><BR>
             <label class="label" for="signature_date">Date:</label><input type="date" name="signature_date" id="signature_date" placeholder="yyyy-mm-dd" pattern="(?:19|20)(?:(?:[13579][26]|[02468][048])-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))|(?:[0-9]{2}-(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-8])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:29|30))|(?:(?:0[13578]|1[02])-31)))" >
<br/><br/>

	</fieldset>

  <br />	<label class="label" for="regsubmit">Click here to register</label>
    <input name="regsubmit" id="regsubmit" type="submit" value="Register"/>
    <BR><BR>
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
  frmvalidator.addValidation("sponsor_email","email");
  
   frmvalidator.addValidation("psword1","req","Please enter a password");
   frmvalidator.addValidation("psword2","req","Please confirm your password");
  
  
  frmvalidator.addValidation("institution","req","Please enter your institution");
  frmvalidator.addValidation("addr1","req","Please enter your address");
  frmvalidator.addValidation("city","req","Please enter your city");
 	
  frmvalidator.addValidation("state","req","Please enter your state");
  
  frmvalidator.addValidation("pcode","req","Please enter your zip code");
  
  frmvalidator.addValidation("phone","numeric","Phone number must be a number");
  
  frmvalidator.addValidation("degreeyear","gt=1900","Degree must be post-1900");
 
  frmvalidator.addValidation("degreeyear","maxlen=4");
  frmvalidator.addValidation("degreeyear","numeric","Degree year must be a number");

   frmvalidator.addValidation("region","req","Please select your region");
   
   frmvalidator.addValidation("aafs","req","Please select your AAFS membership status");
   
   frmvalidator.addValidation("signature","req","You must provide a signature.");
   frmvalidator.addValidation("signature_date","req","You must provide a signature date.");

//]]></script>
    
    
  
  
  
<?php 
    require_once("include/footer.php");
?>
