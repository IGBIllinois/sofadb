<?php 
$addcase = 1;
require('../../include/header_user.php') ;
 
 if(!isset($_SESSION['num_methods']))
 { $_SESSION['num_methods']=0;}

?>


<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Add Case</title>

</head>


  <br/>
  <h1 class="cntr">Case Information</h1>

  <?php


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$errors = array(); // Start an array to hold the errors
	// Check for a casenumber:
        if (empty($_POST['certify_permission']) || empty($_POST['certify_no_info'])) {
		$errors[] = 'You are required to check the Submission Permissions in order to proceed.';
	} 
 
	if (empty($_POST['casenumber'])) {
		$errors[] = 'You must enter a case number to save.';
	} 
    else {
                $casenum = trim($_POST['casenumber']);
	}
	// Check for a casename:
	if (!empty($_POST['casename'])) {
            $casename = trim($_POST['casename']);
	} 
    else {
		$casename="";
	}
    
	
	if (empty($_POST['caseyear'])) {
		$errors[] = 'You must enter a case year to save.';
	} 
    else {
        $caseyear = trim($_POST['caseyear']);
	}
	
    
	// Check for a case agency:
	if (empty($_POST['caseagency'])) {
		$caseag=NULL;
        
	} 
    else {
        $caseag = trim($_POST['caseagency']);
	}
	
    // Check for a FA sex
    if (empty($_POST['fasex'])) {
		$fasex=NULL;
	} 
    else {
        
                $fasex = trim($_POST['fasex']);
	}
	
	
    
       	//check for a FA age 2 first!
	if (empty($_POST['faage2'])) {
            $faage2=NULL;
            $faageunits2=NULL;
	} 
    else {
            $faage2_test = trim($_POST['faage2']);
            if(!is_numeric($faage2_test)) {
                $errors[] = "Forensic Anthropology estimated age must be numeric.";
            } else {
                if($faage2_test > MAXAGE) {
                    $errors[] = "Forensic Anthropology estimated age must be less than ".MAXAGE.".";
                } else {
                    $faage2 = $faage2_test;
                    $faageunits2 = trim($_POST['faageunits2']);
                }
            }
	}
    
    
    //check for a FA age 1
	if (empty($_POST['faage'])) {
		$faage=NULL;
        $faageunits=NULL;
        $faage2=NULL;
        $faageunits2=NULL;
	} 
    else {
            $faage_test = trim($_POST['faage']);
            if(!is_numeric($faage_test)) {
                $errors[] = "Forensic Anthropology estimated age must be numeric.";
            } else {
                if($faage_test > MAXAGE) {
                    $errors[] = "Forensic Anthropology estimated age must be less than ".MAXAGE.".";
                } else {
                    $faage = trim($_POST['faage']);
                    $faageunits = trim($_POST['faageunits']);
                }
            }
	}

	
  //check for a FA stature 2 first 
	if (empty($_POST['fastature2'])) {
		
        $fastature2=NULL;
	} 
    else {
        $fastature2_test = trim($_POST['fastature2']);
        if(!is_numeric($faage2_test)) {
            $errors[] = "Forensic Anthropology estimated stature must be numeric.";
        } else {
            $fastature2 = trim($_POST['fastature2']);
	}
    }


	//check for a FA stature
	if (empty($_POST['fastature'])) {
            $fastature=NULL;
            $fastature2=NULL;
            $fastatureunits=NULL;
	} 
        else {
            $fastature_test = trim($_POST['fastature']);
            if(!is_numeric($fastature_test)) {
                $errors[] = "Forensic Anthropology estimated stature must be numeric.";
            } else {

                    $fastature = trim($_POST['fastature']);
                    $fastatureunits = trim($_POST['fastatureunits']);
            }
    }


  // Check for a id sex
    if (empty($_POST['idsex'])) {
		$idsex=NULL;
	} 
    else {
                $idsex = trim($_POST['idsex']);
                if($idsex == "Other") {
                    $idsex = trim($_POST['idsexother']);
                    
                }
	}


  //check for a id age 
	if (empty($_POST['idage'])) {
            $idage=NULL;
            $idageunits=NULL;
        
	} 
    else {
            $idage_test = trim($_POST['idage']);
            if(!is_numeric($idage_test)) {
                $errors[] = "Identified age must be numeric.";
            } else {
                if($idage_test > MAXAGE) {
                    $errors[] = "Identified age must be less than ".MAXAGE.".";
                } else {
                    $idage = trim($_POST['idage']);
                    $idageunits = trim($_POST['idageunits']);
                }
            }
	}



	//check for a id stature
	if (empty($_POST['idstature'])) {
		$idstature=NULL;
        $idstatureunits=NULL;
	} 
    else {
        $idstature_test = trim($_POST['idstature']);
            if(!is_numeric($idstature_test)) {
                $errors[] = "Identified stature must be numeric.";
            } else {
    
		$idstature = trim($_POST['idstature']);
                $idstatureunits = trim($_POST['idstatureunits']);
            }
	}
   
   
   //check for a id source
	if (empty($_POST['idsource'])) {
		$idsource=NULL;
        
	} 
    else {
		
        $idsource = trim($_POST['idsource']);
	}
	
	 //check for a extra race/ethnicity info 
	if (empty($_POST['idancaddtext'])) {
		$idancaddtext=NULL;
        
	} 
    else {
		
        $idancaddtext =  trim($_POST['idancaddtext']);
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
    
    //check for a  casenotes
	if (empty($_POST['casenotes'])) {
		$casenotes=NULL;
	} 
        
    else {
		
        $casenotes = trim($_POST['casenotes']);
	}

    if (empty($_POST['farace_othertext'])) {
		$faothertext=NULL;
        
	} 
    else {
		
        $faothertext = trim($_POST['farace_othertext']);
	}
 
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
        
        // prior known data
    if(isset($_POST['known_none'])) {
      $known_none=$_POST['known_none'];
    }
    else{
        $known_none=0;
    }

    if(isset($_POST['known_none'])) {
      $known_none=$_POST['known_none'];
    }
    else{
        $known_none=0;
    }
    
    if(isset($_POST['known_sex'])) {
      $known_sex=$_POST['known_sex'];
    }
    else{
        $known_sex=0;
    }
    
    if(isset($_POST['known_age'])) {
      $known_age=$_POST['known_age'];
    }
    else{
        $known_age=0;
    }
    
    if(isset($_POST['known_ancestry'])) {
      $known_ancestry=$_POST['known_ancestry'];
    }
    else{
        $known_ancestry=0;
    }
    
    if(isset($_POST['known_stature'])) {
      $known_stature=$_POST['known_stature'];
    }
    else{
        $known_stature=0;
    }
              
    if(isset($_POST['known_unable_to_determine'])) {
      $known_unable_to_determine=$_POST['known_unable_to_determine'];
    }
    else{
        $known_unable_to_determine=0;
    }
    
    if (empty($_POST['idrace_othertext'])) {
		$idothertext=NULL;
        
	} 
    else {
		$idOt=1;
                $idothertext = trim($_POST['idrace_othertext']);
	}
    
    if(($idOt==0 && $idothertext)||($idOt==1 && !$idothertext)) {
        $errors[] = 'You must Check the Other box and enter text.';
    }
    
    if(empty($_POST['fdb_consent'])) {
        $errors[] = "You must select an FDB Data Sharing Option.";
    } else {
        $fdb_consent = $_POST['fdb_consent'];
    }
        
        
    
    if (empty($errors)) 
        { // If there were no errors
		//Determine whether the case has already been registered	
		$memberid=$_SESSION['id'];

                $exists = sofa_case::new_case_exists($db, $memberid, $casename, $casenum);
	
            if (!$exists)
            {//The case has not been registered already 
        
               
                $data = array(
                    
                   "casename"=>$casename,
                   "casenum"=>$casenum,
                   "caseyear"=>$caseyear,
                   "memberid"=>$memberid,
                   "caseag"=>$caseag,
                    
                   "fasex"=>$fasex,
                   "faage"=>$faage,
                   "faage2"=>$faage2,
                   "faageunits"=>$faageunits,
                   "faageunits2"=>$faageunits2,
                    
                   "fastature"=>$fastature,
                    "fastature2"=>$fastature2,
                    "fastatureunits"=>$fastatureunits,
                    "idsex"=>$idsex,
                    "idage"=>$idage,
                    
                    "idageunits"=>$idageunits,
                    "idstature"=>$idstature,
                    "idstatureunits"=>$idstatureunits,
                    "idsource"=>$idsource,
                    "casenotes"=>$casenotes,
                    
                    "faancestryas"=>$faAs,
                    "faancestryeuro"=>$faWh,
                    "faancestryaf"=>$faBl,
                    "faancestryna"=>$faNa,
                    "faancestryhi"=>$faHi,
                    "faancestryot"=>$faOt,
                    "faancestryottext"=>$faothertext,
                    
                    "idraceas"=>$idAs,
                    "idraceaf"=>$idBl,
                    "idracewh"=>$idWh,
                    "idracehi"=>$idHi,
                    "idracena"=>$idNa,
                    
                    "idraceot"=>$idOt,
                    "idraceottext"=>$idothertext,
                    "idancaddtext"=>$idancaddtext,
                    
                    "known_none"=>$known_none,
                    "known_age"=>$known_age,
                    "known_sex"=>$known_sex,
                    "known_ancestry"=>$known_ancestry,
                    "known_stature"=>$known_stature,
                    "known_unable_to_determine"=>$known_unable_to_determine,
                    
                    "fdb_consent"=>$fdb_consent
                
                        
                        
                        );	

                $result = sofa_case::add_case($db, $data);
                
                if($result['RESULT'] == FALSE) {
                    echo($result['MESSAGE']);
                    exit();
                }
                $case_id = $result['id'];

                $case =  new sofa_case($db, $case_id);

               header ("location: ../editcase/index.php?id=$case_id&successAddCase=$case_id#tabs-2"); exit();
                 
			// Include the footer and stop the script
		  
			exit();
		}
	else
    	{//The cae  is already registered
		echo	'<span style="padding-left:100px; 
                display:block;"><p class="error">The case name and number are not acceptable because it is already registered</p></span>';
		}//end already registered if
	} 
    else
     { // Report the errors.
		echo '<span style="padding-left:100px; 
                display:block;"><h2>Error!</h2>
		<p class="error">The following error(s) occurred:<br/>';
		foreach ($errors as $msg) 
        { // Print each error.
			echo " - $msg<br/>\n";
		}
		echo '</p><h3>Please try again.</h3><p><br/></p></span>';
	   }// End of else (empty($errors))
} // End of the main Submit conditional.
?>
  


  <div id="caseform">
    <form action="index.php" method="post" id="casedata">
    
    
  
    <div id="tabs">
  <ul>
    <li><a href="#tabs-1">General Case Information</a></li>

  </ul>
<div id="tabs-1">
  <fieldset class="enclosefieldset">
    
    
  <fieldset class="caseinfobox"><legend class="boldlegend">General Case Information</legend>
        <label class="label" for="caseyear">Case Year*</label><input id="caseyear" type="text" name="caseyear" size="5" maxlength="4" value="<?php if (isset($_POST['caseyear'])) echo $_POST['caseyear']; ?>"/><strong class="outsidetext">* indicates required field</strong>
  <br/>
  <label class="label" for="casenumber">Case Number*</label><input id="casenumber" type="text" name="casenumber" size="30" maxlength="30" value="<?php if (isset($_POST['casenumber'])) echo $_POST['casenumber']; ?>"/>
  <br />
    
  <label class="label" for="caseagency">Case Agency</label><input id="caseagency" type="text" name="caseagency" size="30"  value="<?php if (isset($_POST['caseagency'])) echo $_POST['caseagency']; ?>"/>
  <br />
    
 
    <span name="savebutton" class="bigsavebutton">
    <input name="savecase" type="image" id="savecase" src="../../images/bigsave.png" alt="Save Case" width="90"/></span>
    
  </fieldset>
    
  <fieldset class="caseinfobox"><legend class="boldlegend"> Biological Profile: Forensic Anthropology Case Estimation</legend>
    
    
  <label class="label" for="fasex">Sex</label>
  <select name="fasex">
    <option value="">- Select -</option>
    <option value="Female"<?php if (isset($_POST['fasex']) AND ($_POST['fasex'] == 'Female')) echo ' selected="selected"'; ?>>Female</option>
    <option value="Probable Female"<?php if (isset($_POST['fasex']) AND ($_POST['fasex'] == 'Probable Female')) echo ' selected="selected"'; ?>>Probable Female</option>
    <option value="Indeterminate"<?php if (isset($_POST['fasex']) AND ($_POST['fasex'] == 'Indeterminate')) echo ' selected="selected"'; ?>>Indeterminate</option>
    <option value="Probable Male"<?php if (isset($_POST['fasex']) AND ($_POST['fasex'] == 'Probable Male')) echo ' selected="selected"'; ?>>Probable Male</option>
    <option value="Male"<?php if (isset($_POST['fasex']) AND ($_POST['fasex'] == 'Male')) echo ' selected="selected"'; ?>>Male</option>
    </select>
    
    
    
    <br/><label class="label" for="faage">Age</label><input id="faage" type="text" name="faage" size="5" maxlength="5" value="<?php if (isset($_POST['faage'])) echo $_POST['faage']; ?>"/>
    
    <select name="faageunits">
      <option value="years">years</option>
      <option value="months"<?php if (isset($_POST['faageunits']) AND ($_POST['faageunits'] == 'months')) echo ' selected="selected"'; ?>>months</option>
      <option value="fetalmonths"<?php if (isset($_POST['faageunits']) AND ($_POST['faageunits'] == 'fetalmonths')) echo ' selected="selected"'; ?>>fetal months</option>
      </select>&nbsp; to &nbsp;
    
    <input id="faage2" type="text" name="faage2" size="5" maxlength="5" value="<?php if (isset($_POST['faage2'])) echo $_POST['faage2']; ?>"/>
    
    <select name="faageunits2">
      <option value="years">years</option>
      <option value="months"<?php if (isset($_POST['faageunits2']) AND ($_POST['faageunits2'] == 'months')) echo ' selected="selected"'; ?>>months</option>
      <option value="fetalmonths"<?php if (isset($_POST['faageunits2']) AND ($_POST['faageunits2'] == 'fetalmonths')) echo ' selected="selected"'; ?>>fetal months</option>
      </select>
    
    
    
    <br/><label class="label" for="faancestry">Ancestry/Group Affiliation</label><input id="farace_othertext" type="text" name="farace_othertext" size="30" maxlength="100" value="<?php if (isset($_POST['farace_othertext'])) echo $_POST['farace_othertext']; ?>"/>
    
    
    
    <br/><label class="label" for="fastature">Stature</label><input id="fastature" type="text" name="fastature" size="6" maxlength="8" value="<?php if (isset($_POST['fastature'])) echo $_POST['fastature']; ?>"/>  &nbsp; to &nbsp;
    
    <input id="fastature2" type="text" name="fastature2" size="6" maxlength="8" value="<?php if (isset($_POST['fastature2'])) echo $_POST['fastature2']; ?>"/>  <select name="fastatureunits">
      <option value="in">inches</option>
      <option value="cm">cm</option>
      </select>
    
    
    </fieldset>
    
      <!-- Identified information -->
    <fieldset class="caseinfobox"><legend class="boldlegend">Biological Profile: Actual Identified Information</legend>
      
      <label class="label" for="idsex">Sex</label>

        <input type="radio" name="idsex" value="Female" <?php if (isset($_POST['idsex']) AND ($_POST['idsex'] == 'Female')) echo ' checked'; ?>> Male
        <input type="radio" name="idsex" value="Male" <?php if (isset($_POST['idsex']) AND ($_POST['idsex'] == 'Male')) echo ' checked'; ?>> Female
        <input type="radio" name="idsex" value="Other" <?php if (isset($_POST['idsex']) AND ($_POST['idsex'] != 'Male') AND ($_POST['idsex'] != 'Female')) { echo " checked ";}?>> Other: 
        <input id="idsexother" name="idsexother" type="text" 
          <?php if (isset($_POST['idsex']) AND ($_POST['idsex'] != 'Male') AND ($_POST['idsex'] != 'Female')) { echo " value='".$_POST['idsex']."' ";}?>/>
               <BR>
      <br/><label class="label" for="idage">Age</label><input id="idage" type="text" name="idage" size="5" maxlength="5" value="<?php if (isset($_POST['idage'])) echo $_POST['idage']; ?>"/>
      <select name="idageunits">
        <option value="years">years</option>
        <option value="months"<?php if (isset($_POST['idageunits']) AND ($_POST['idageunits'] == 'months')) echo ' selected="selected"'; ?>>months</option>
        <option value="fmonths"<?php if (isset($_POST['idageunits']) AND ($_POST['idageunits'] == 'fmonths')) echo ' selected="selected"'; ?>>fetal months</option>
        </select> 
      
      
      
      
      
      <br/><label class="label" for="idrace">Race/Ethnicity</label>
      <input type="checkbox" name="race_asian" value="1" />Asian/Pacific Islander
      <input type="checkbox" name="race_black" value="1" />Black/African-American
      <input type="checkbox" name="race_hispanic" value="1" />Hispanic<br />
      <label class="label" for="idrace2"></label>
      <input type="checkbox" name="race_native" value="1" />Native American
      <input type="checkbox" name="race_white" value="1" />White
      <input type="checkbox" name="race_other" value="1" />Other: &nbsp; <input id="idrace_othertext" type="text" name="idrace_othertext" size="18" maxlength="30" value="<?php if (isset($_POST['idrace_othertext'])) echo $_POST['idrace_othertext']; ?>"/>
      <br /><label class="label" for="idancaddtext">Race/Ethnicity Notes</label><input id="idancaddtext" type="text" name="idancaddtext" size="30" maxlength="300" value="<?php if (isset($_POST['idancaddtext'])) echo $_POST['idancaddtext']; ?>" /><br>
      
      <br/><label class="label" for="idstature">Stature</label><input id="idstature" type="text" name="idstature" size="6" maxlength="8" value="<?php if (isset($_POST['idstature'])) echo $_POST['idstature']; ?>" />
      
      <select name="idstatureunits">
        <option value="in">inches</option>
        <option value="cm">cm</option>
        </select>
      
      <br />
      
      <br/><label class="label" for="idsource">Information Source</label><input id="idsource" type="text" name="idsource" size="30" maxlength="60" value="<?php if (isset($_POST['idsource'])) echo $_POST['idsource']; ?>" /><br />
      
  
      </fieldset>
      <!-- Prior information -->
            <fieldset class="caseinfobox"><legend class="boldlegend">Background Case Knowledge</legend>
                <BR>
                Please check any component of the biological profile that was known to the practitioner during or before the time of case analysis.
                <BR><BR>

<label class="label" for="known_none"></label><input type="checkbox" name="known_none" value="1" />No biological profile information was known<BR>
<label class="label" for="known_sex"></label><input type="checkbox" name="known_sex" value="1" />Sex was known<BR>
<label class="label" for="known_age"></label><input type="checkbox" name="known_age" value="1" />Age was known<BR>
<label class="label" for="known_ancestry"></label><input type="checkbox" name="known_ancestry" value="1" />Ancestry/Group Affinity was known<BR>
<label class="label" for="known_stature"></label><input type="checkbox" name="known_stature" value="1" />Stature was known <BR>
<label class="label" for="known_unable_to_determine"></label><input type="checkbox" name="known_unable_to_determine" value="1" />Unable to determine<BR>

      </fieldset>
      
       <fieldset class="caseinfobox"><legend class="boldlegend">Case Data Submission Permissions</legend>
           <BR>
           <input type="checkbox" name="certify_permission" value="1"/>
           I certify that I have permission from the appropriate agencies and/or personnel to add this case’s information to the FADAMA database.
           <BR><BR>
           <input type="checkbox" name="certify_no_info" value="1" />
            I certify that no identifiable information (e.g. name, home address, relative’s names, driver’s license number etc) 
            regarding the decedent of this case will be submitted in FADAMA.
            <BR>
            <BR>

       </fieldset>
      
      <fieldset class="caseinfobox"><legend class="boldlegend">FDB Data Sharing Option</legend>
          <BR>
        FADAMA provides the opportunity for users to share relevant case data, such as craniometric and postcranial measurements, with the Forensic Data Bank (FDB). 
        In contrast to FADAMA's anonymous database, FDB sharing requires identifiable information about the case, including the case number and case agency. 
        To review a complete list of data shared with the FDB if you choose to opt-in, please see the FAQs. 
        <BR><BR>
        Please choose one of the following options to apply to this case.
        <BR><BR>
        <label class="label" for="consent"></label><input type='radio' name='fdb_consent' value='consent'>I consent to share this case data with FDB.</input><BR>
        <label class="label" for="already_submitted"></label><input type='radio' name='fdb_consent' value='already_submitted'>I have already submitted this case data with FDB.</input><BR>
        <label class="label" for="decline"></label><input type='radio' name='fdb_consent' value='decline'>I decline to share this case data with FDB.</input><BR>
      </fieldset>
           
    <fieldset class="caseinfobox"><legend class="boldlegend">Case Notes</legend>
      <label class="label" for="casenotes"></label>
      <textarea name="casenotes" cols="55" rows="7"><?php if (isset($_POST['casenotes'])) echo $_POST['casenotes']; ?></textarea>

      
      
      </fieldset>
   </div>

    
   </div></div>
   
     <div id="casedata_errorloc" class="errorlocation">
    </div>
    
    
    
    </fieldset>
 
  </form>
   
    
    <script language="JavaScript" type="text/javascript"
    xml:space="preserve">//<![CDATA[
//You should create the validator only after the definition of the HTML form
  var frmvalidator  = new Validator("casedata");
  
  frmvalidator.EnableOnPageErrorDisplaySingleBox();
   frmvalidator.EnableMsgsTogether();
 
 
  frmvalidator.addValidation("casenumber","req","You must provide a case number");
 
  
 // frmvalidator.addValidation("casename","req","You must provide a nickname for the case");

    frmvalidator.addValidation("caseyear","req","You must provide a year for the case");
	frmvalidator.addValidation("caseyear","gt=1900","Case Year must be post-1900");
 
   
  frmvalidator.addValidation("caseyear","maxlen=4","Year must be entered in YYYY format");
  frmvalidator.addValidation("caseyear","numeric","Year must be entered in YYYY format");
  
   frmvalidator.addValidation("faage","numeric","Ages must be entered as a number");
   
  frmvalidator.addValidation("faage2","numeric","Ages must be entered as a number");
  
  frmvalidator.addValidation("faage", "lt=150", "Age should be less than 150.");
  frmvalidator.addValidation("faage2", "lt=150", "Age should be less than 150.");
  
   frmvalidator.addValidation("fastature","numeric","Statures must be entered as a number");
   
  frmvalidator.addValidation("fastature2","numeric","Statures must be entered as a number");
  
  frmvalidator.addValidation("idage","numeric","Ages must be entered as a number");
   
  frmvalidator.addValidation("idstature","numeric","Statures must be entered as a number");
  
  frmvalidator.addValidation("idrace_othertext","req","Please fill-in the  Other Race/Ethinicity textbox",
        "VWZ_IsChecked(document.forms['casedata'].elements['idrace_other'],'1')");
		
frmvalidator.addValidation("farace_othertext","req","Please fill-in the Other Ancestry textbox",
        "VWZ_IsChecked(document.forms['casedata'].elements['farace_other'],'1')");

  
  //frmvalidator.addValidation("hearabout_other","req","Please fill-in this textbox",    "VWZ_IsChecked(document.forms['myform'].elements['hearabout'],'Other')");
  
    
	//]]></script>
    
<?php
    require_once("../../include/footer.php");
?>

