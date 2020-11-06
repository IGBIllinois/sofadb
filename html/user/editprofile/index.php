<?php 
$title = "Forensic Anthropology Case Database (FADAMA) - Edit Profile";
require_once("../../include/header_user.php");
require_once('../../include/session.inc.php') ;
?>

<BR/>
  <h1 class="cntr">Edit Profile</h1>
  
  
  <div id="phperror">
  <?php

$memberid=$session->get_var('id');
$edit_member = new member($db, $memberid);

// Connect to the database.
// This code inserts a record into the users table
// Has the form been submitted?

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if(isset($_POST['deleteSelf'])) {
        if(isset($_POST['deleteConfirm'])) {
            echo("<span style='padding-left:100px; display:block;'>");
            $del_member = new member($db, $memberid);
            $params = array("uname"=>$del_member->get_uname());

            echo("A notification has been sent to the administrators. You will be notified when your account is deleted.");

            $admin_email = ADMIN_EMAIL;              
            $to = $admin_email;

            $from= FROM_EMAIL;
            $subject = "FADAMA DB ADMIN ALERT: Delete user request";
            $message = functions::renderTwigTemplate('email/user_delete_self_request.html.twig', $params);

            $header = "From:".$from."\r\n";
            $retval = mail($to,$subject,$message,$header);

            echo("</span>");
        } else {
            echo("You must agree to the terms before requesting your account to be deleted.");
        }
    } else {
	$errors = array(); // Start an array to hold the errors
	// Check for password
        $pwd3 = $_POST['psword3'];
        if(!member::verify_user_new($db, $edit_member->get_uname(), $pwd3)) {
            $errors[] = "Your Old/Current password is incorrect.";
        }   
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
        
        // Check for existing email
        if(member::member_exists($db, $_POST['email'])) {
            $chk_mem = member::load_member_by_name($db, $_POST['email']);
            if($chk_mem->get_id() != $memberid) {
                $errors[] = "A user with that email already exists.";
            }
        }
                
	
	
	
	// Check for a password and match it against the confirmed password:
	if (!empty($_POST['psword1']) && !$_POST['psword1'] == "") {
            $pwdflag = 1;
		if ($_POST['psword1'] != $_POST['psword2']) {
			$errors[] = 'Your two passwords did not match.';
		} else {
			$p = trim($_POST['psword1']);
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
		$degree=NULL;
		//$errors[] = 'You forgot to enter your level of education earned';
	} else {
		$degree = trim($_POST['degree']);
	}
	
	if (!empty($_POST['degreeyear'])) {
		$degreeyear = trim($_POST['degreeyear']);
	} else {
		$degreeyear =NULL;
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
            "id"=>$edit_member->get_id(),
            "uname"=>$e,
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
            "sponsor_affiliation"=>$sponsor_affiliation);

	
	if (empty($errors)) { // If there were no errors

		// Make the query:
	
			
            if($pwdflag==1){
                $result = $edit_member->update_member($db, $params, $p);
            } else {
                $result = $edit_member->update_member($db, $params);
            }

            if ($result) { // If it ran OK.
		ob_start();
                echo('<span style="padding-left:100px; display:block;"><h2>User info updated successfully,<BR></span>');
                $edit_member = new member($db, $memberid);
		} else { // If it did not run OK
		// Error message:
			echo '<h2>System Error</h2>
			<p class="error">Registration failed because of a system error. We apologize for any inconvenience.</p>'; 
			// Debugging message:
			echo '<p>' . $result['MESSAGE'] . '<br><br>Query: ' . $q . '</p>';
		} // End of if ($result)

		// Include the footer and stop the script
		  
		

	} else { // Report the errors.
		echo '<span style="padding-left:100px; 
    display:block;"><h2>Error!</h2>
		<p class="error">The following error(s) occurred:<br>';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br>\n";
		}
		echo '</p><h3>Please try again.</h3><p><br></p></span>';
		}// End of if (empty($errors))
    }
} // End of the main Submit conditional.

?></div>
  
  
  
  <div id="editform">
      
  <fieldset style="border: solid 2px #cc0000;overflow: hidden;" class="roundedborder">
   <form action="index.php" method="post" id="registration">
    <fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend class="boldlegend">Basic Information</legend>
    
    
 <center><strong class="outsidetext">* indicates required field</strong></center>
 <br><label class="label" for="fname">First Name*</label><input id="fname" type="text" name="fname" size="30" maxlength="30" value="<?php echo $edit_member->get_firstname(); ?>">
 <br><label class="label" for="lname">Last Name*</label><input id="lname" type="text" name="lname" size="30" maxlength="40" value="<?php echo $edit_member->get_lastname(); ?>">
    <br><label class="label" for="email">Email Address*</label><input id="email" type="text" name="email" size="30" maxlength="160" value="<?php echo $edit_member->get_uname(); ?>">
    <br><label class="label" for="email">Confirm Email Address*</label><input id="email2" type="text" name="email2" size="30" maxlength="160" value="<?php echo $edit_member->get_uname(); ?>">
    
    <br><label class="label" for="psword3">Old/Current Password*</label><input id="psword3" type="password" name="psword3" size="12" maxlength="50" value="" >
    <br><label class="label" for="psword1">New Password</label><input id="psword1" type="password" name="psword1" size="12" maxlength="50" value="" >
    <br><label class="label" for="psword2">Confirm New Password</label><input id="psword2" type="password" name="psword2" size="12" maxlength="50" value="" ><br /><br></fieldset>
    
    <fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend class="boldlegend">Current Address</legend>
        <br> <label class="label" for="title2">Job Title*</label><input id="title2" type="text" name="title2" size="30" maxlength="100" value="<?php echo $edit_member->get_title(); ?>">
        <br><label class="label" for="institution">Institution*</label><input id="institution" type="text" name="institution" size="30" maxlength="100" value="<?php echo $edit_member->get_institution(); ?>">
        <br><label class="label" for="addr1">Address*</label><input id="addr1" type="text" name="addr1" size="30" maxlength="100" value="<?php echo $edit_member->get_mailaddress(); ?>">
        <br><label class="label" for="addr2">Address</label><input id="addr2" type="text" name="addr2" size="30" maxlength="100" value="<?php echo $edit_member->get_mailaddress2(); ?>">
      <br><label class="label" for="city">City*</label><input id="city" type="text" name="city" size="30" maxlength="100" value="<?php echo $edit_member->get_city(); ?>">
      <br><label class="label" for="state">State*</label><input id="state" type="text" name="state" size="30" maxlength="30" value="<?php echo $edit_member->get_state(); ?>">
      <br><label class="label" for="pcode">Postal (ZIP) Code*</label><input id="pcode" type="text" name="pcode" size="15" maxlength="15" value="<?php echo $edit_member->get_zip(); ?>">
      <br><label class="label" for="phone">Telephone</label><input id="phone" type="text" name="phone" size="30" maxlength="30" value="<?php echo $edit_member->get_phone(); ?>"><br /><br>
      
  </fieldset>
    <fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend class="boldlegend">Education and Experience</legend>
        <br> <label class="label" for="aafs">AAFS Membership Status*</label>
      <select name="aafs">
        <option value="">- Select -</option>
        <option value="1"<?php if ($edit_member->get_aafsstatus() == 1) echo ' selected="selected"'; ?>>Student Affiliate</option>
        <option value="2"<?php if ($edit_member->get_aafsstatus() == 2) echo ' selected="selected"'; ?>>Trainee Affiliate</option>
        <option value="3"<?php if ($edit_member->get_aafsstatus() == 3) echo ' selected="selected"'; ?>>Associate Member</option>
        <option value="5"<?php if ($edit_member->get_aafsstatus() == 5) echo ' selected="selected"'; ?>>Member</option>
        <option value="6"<?php if ($edit_member->get_aafsstatus() == 6) echo ' selected="selected"'; ?>>Fellow</option>
        
        <option value="4"<?php if ($edit_member->get_aafsstatus() == 4) echo ' selected="selected"'; ?>>Not A Member</option>
        </select>
         <br><label class="label" for="region">Region of Practice*</label>
      <select name="region">
        <option value="">- Select -</option>
        <option value="1"<?php if ($edit_member->get_region() == 1) echo ' selected="selected"'; ?>>Northeast</option>
        <option value="2"<?php if ($edit_member->get_region() == 2) echo ' selected="selected"'; ?>>West</option>
        <option value="3"<?php if ($edit_member->get_region() == 3) echo ' selected="selected"'; ?>>Midwest</option>
        <option value="4"<?php if ($edit_member->get_region() == 4) echo ' selected="selected"'; ?>>South</option>
        </select>
        
    
      <br><label class="label" for="degree">Education*</label>
      <select name="degree">
        <option value="">- Select -</option>
        <option value="None"<?php if ($edit_member->get_degree() == "None") echo ' selected="selected"'; ?>>None</option>
        <option value="BS"<?php if ($edit_member->get_degree() == "BS")  echo ' selected="selected"'; ?>>Bachelor of Science or Arts</option>
        <option value="MS"<?php if ($edit_member->get_degree() == "MS")  echo ' selected="selected"'; ?>>Masters Degree</option>
        <option value="Phd"<?php if ($edit_member->get_degree() == "Phd")  echo ' selected="selected"'; ?>>Phd</option>
        </select>
      <br><label class="label" for="degreeyear">Year Earned (YYYY format)*</label><input id="degreeyear" type="text" name="degreeyear" size="30" maxlength="4" value="<?php echo $edit_member->get_degreeyear(); ?>" >
      <br><label class="label" for="fieldofstudy">Field of Study</label><input id="fieldofstudy" type="text" name="fieldofstudy" size="30" maxlength="60" value="<?php echo $edit_member->get_fieldofstudy(); ?>" >
      
            <br><label class="label" for="affiliation">Other Forensic Governing Body Affiliation (e.g. FASE, ALAF):</label><input id="affiliation" type="text" name="affiliation" size="30"  value="<?php echo $edit_member->get_affiliation(); ?>" >
        <br>If you aren't a member of a forensic governing body, you are required to have a sponsor in order to access FADAMA. Fill out their name, email, and affiliated membership in the space below
        <br><label class="label" for="sponsor">Sponsor:</label><input id="sponsor" type="text" name="sponsor" size="30" value="<?php echo $edit_member->get_sponsor(); ?>" >
        <br><label class="label" for="sponsor_email">Sponsor Email:</label><input id="sponsor_email" type="text" name="sponsor_email" size="30" value="<?php echo $edit_member->get_sponsor_email(); ?>" >
        <br><label class="label" for="sponsor_affiliation">Sponsor Affiliation:</label><input id="sponsor" type="text" name="sponsor_affiliation" size="30"  value="<?php echo $edit_member->get_sponsor_affiliation(); ?>" >
                <BR><BR>
      
    
      
      
      
      </fieldset>
    
  <br />	<br /> <label class="label" for="regsubmit">Click here to update</label>
    <input name="regsubmit" id="regsubmit" type="submit" value="Update Profile"/>
    <div id="registration_errorloc" class="errorlocation">
      </div>
  </form>
      <BR><BR>
      
        <fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend class="boldlegend">Delete Account</legend>
            <form action='index.php' method='POST' id='deleteSelfPost'>
                <BR>
                Submitting this form will send an email to the administrators requesting that they delete your account. You will be notified when the account has been deleted. Once complete, all case data associated with your user profile will be deleted and not appear in any future data downloads or data backups.  
                <BR><BR><input type='checkbox' name='deleteConfirm'>I agree to have this account deleted.<BR><BR>
                <input type='submit' id='deleteSelf' name='deleteSelf' value='Delete account'>
                <BR><BR>
            </form>
        </fieldset>
      <BR><BR>
    </fieldset>
    
 
      
    

    
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
 
 
  frmvalidator.addValidation("degreeyear","maxlen=4");
  frmvalidator.addValidation("degreeyear","minlen=4");
  frmvalidator.addValidation("degreeyear","numeric", "Degree year must be a number in YYYY format");
   frmvalidator.addValidation("degreeyear","gt=1900");

   frmvalidator.addValidation("region","req","Please select your region");
   
   frmvalidator.addValidation("aafs","req","Please select your AAFS membership status");

//]]></script>
    
    
<?php
require_once("../../include/footer.php");
?>

