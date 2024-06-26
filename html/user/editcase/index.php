<?php 
/**
 *  This page allows a user to edit an existing case of theirs
 */
$title = "Forensic Anthropology Case Database (FADAMA) - Edit Case";
require_once('../../include/header_user.php');
?>
<br/>
  <h1 class="cntr">Edit Case Information</h1>
  <center>(<a href="https://github.com/andicyim/FADAMA/wiki/FADAMA-User-Tutorial#Edit_case_information" target="_blank">Edit case tutorial</a>)</center>
  
    <div id="caseform">
   
<?php

$casedata = null;
$errors = array();
$region_id = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if(isset($_POST['caseid'])) {
        // Edit existing case
        $case = new sofa_case($db, $_POST['caseid']);
        if($case->get_memberid() != $session->get_var('id')) {
            // No permission to view this case
            echo('<span style="padding-left:100px; 
                        display:block;">');
            echo "You do not have permission to view this case.";
            echo("</span>");
            require_once("../../include/footer.php");
            exit;
        } else {
            $caseeditid=$_POST['caseid'];
	    $casedata = new sofa_case($db, $caseeditid);
	    $region_id = $casedata->get_region_id();
        }
    } else {
        echo("Please enter a valid case to edit.");
    }

	if (isset($_POST['successAddCase'])) {
		echo "Case added successfully. You may now add method data to the case using the \"Manage Case Methods\" tab";
	}
    $errors = array(); // Start an array to hold the errors
    
    //remove method from case here
    if (isset($_POST['delsubmit'])) {
        // Delete method
        $deleteid=$_POST['delid'];
        $caseid = $_POST['caseid'];
        $tier2 = new tier2data($db, $deleteid);
        $caseid = $tier2->get_caseid();
        $this_case = new sofa_case($db, $caseid);
        $this_case->remove_method($deleteid);

    } else if(isset($_POST['add_method'])) {
        // Add a new method
        if(!isset($_POST['drop_2'])) {
            echo("Please select a method.");
        } else {

        $method_id = $_POST['drop_2'];
        $method = new method($db, $method_id);
        
        // check if this method has already been added
        $tier2s = $casedata->get_case_methods();
        foreach($tier2s as $tier2) {
            if($tier2->get_methodid() == $method_id) {
                $method = new method($db, $method_id);
                $errors[] = "You have already added a method for ".$method->get_name().". Only one instance of each method can be used per case.<BR>".
                        "Please scroll down and use the \"Edit\" function to make any modifications to this method.";
            } else {
                // New method added
            }
        }
        $estimated_outcome_1 = null;
        $estimated_outcome_2 = null;
        $estimated_outcome_units = null;
        
        if(isset($_POST['estimated_outcome_1'])) {
            $estimated_outcome_1 = $_POST['estimated_outcome_1'];
        } else {
            // No estimated outcome 1 given
        }
        if(isset($_POST['estimated_outcome_2'])) {
            $estimated_outcome_2 = $_POST['estimated_outcome_2']; 
        } else {
            // No estimated outcome 2 given
        }
        if(isset($_POST['estimated_outcome_units'])) {
            $estimated_outcome_units = $_POST['estimated_outcome_units'];
        } else {
            // No estimated outcome units given
        }

        if($method->get_method_type_num() == METHOD_DATA_STATURE_ID ||
                $method->get_method_type_num() == METHOD_DATA_AGE_ID) {
            if(($estimated_outcome_1 != null && $estimated_outcome_1 !=  "" && !is_numeric($estimated_outcome_1)) ||
                    ($estimated_outcome_2 != null && $estimated_outcome_2 !=  "" && !(is_numeric($estimated_outcome_2)))) {
                $errors[] = "Estimated outcome must be numeric.";

            } else {
                // Outcome is numeric
            }
        } else {
            // Don't check for numeric type
        }

        // $output_data is an array of the tier3 data (method_info_options) that has been posted
        // in ($id=>$value) pairs
        $output_data = $_POST['output_data'];
        
        foreach($output_data as $od) {
            // Check for numeric validity
            if(is_array($od)) {
                foreach($od as $id=>$value) {
                    if($id != null && $id != '') {
                        $opt = new method_info_option($db, $id);
                        $itype = $opt->get_type();
                        $input_type = new input_type($db, $itype);
                        if($input_type->get_input_type() == USER_INTERACTION_NUMERIC_ENTRY && 
                                $value != null &&
                                $value != "" &&
                                !is_numeric($value)) {
                            $errors[] = ("Value for ".$opt->get_value() . " must be numeric.");
                        } else {
                            // Don't check for numeric value
                        }

                    } else {
                        // ID is null
                    }
                }
            } else {
                // Not array, don't check value
            }
        }
        
        if(count($errors) == 0) {
        $caseid = $_POST['caseid'];
        
        $this_case = new sofa_case($db, $caseid);
        
        $result = $this_case->add_case_method(
                        $method_id, 
                        $method->get_method_type_num(),
                        $estimated_outcome_1, 
                        $estimated_outcome_2,
                        $estimated_outcome_units);
        
        if($result['RESULT'] == TRUE) {
            $t2id = $result['id'];
        } else {
            echo($result['MESSAGE']);
            return;
        }

        
        $output_data = $_POST['output_data'];


        if(count($errors) == 0) {
        // $output_data is an array of the tier3 data (method_info_options) that has been posted
        // in ($id=>$value) pairs    
        foreach($output_data as $od) {

                if(is_array($od)) {
                    foreach($od as $id=>$value) {
                        if($id != null && $id != '') {
                            if($value != null && $value != "") {
                                // Add the tier3 data
                                $this_case->add_tier3($t2id, $id, $value);
                            }
                        }
                    }
                } else {
                    if($od != null && $od != '') {
                        $this_case->add_tier3($t2id, $od);
                    }
                }
            }
        } else {
            // No errors
        }
        
        // Add Left/Right data, if applicable
        if(isset($_POST['LR']) && $_POST['LR'] != null) {
        
            $lr = $_POST['LR'];
            // process left/right options
            // This is separate from the output_data, because the 'name' value must be the same for the entire set of radio buttons
                foreach($lr as $value=>$id) {

                    if($id != null && $id != '') {

                        $casedata->add_tier3($t2id, $id);

                    }
            }
        } else {
            // No Left/Right inputs
        }
        
        
        if(isset($_POST['check_select']) && $_POST['check_select'] != null) {
            // used for checkbox arrays, like Rios & Cardoso

            $check_select = $_POST['check_select'];
            foreach($check_select as $method_info_id=>$option_list) {
                foreach($option_list as $option_id=>$option_name) {
                    if($option_id > 0) {                
                        $this_case->add_tier3($t2id, $option_id);
                    }
                }

            }
            
        }
        
        if(isset($_POST['references']) && ($_POST['references'] != null)) {
            // add references

		$sel_refs = $_POST['references'];
            foreach($sel_refs as $id=>$ref_list) {
                foreach($ref_list as $ref=>$ref_name) {
                    if($ref > 0) {                
                        $reference = new reference($db, $ref);
                        $reference->add_reference_to_tier2($t2id, $id);
                    }
                }

            }
            
        } else {
            // No references
        }
        }
        if(count($errors) == 0) {
            
        } else {
         // Report the errors.
            echo '<span style="padding-left:100px; 
                display:block;"><h2>Error!</h2>
            <p class="error">The following error(s) occurred:<br/>';
                foreach ($errors as $msg) { 
                    // Print each error.
                    echo " - $msg<br/>\n";
                }
                echo("</p><BR></span>");
        }
        }
    } else if(isset($_POST['savecase'])) {
        // Edit case
        // 
	// Check for necessary case data:
	if (empty($_POST['caseyear'])) {
            $errors[] = 'You must enter a case year to save.';
	} else if(!is_numeric($_POST['caseyear'])) {
            $errors[] = 'Case year must be numeric.';
        } else if(strlen("".$_POST['caseyear']) != 4) {
            $errors[] = 'Please enter a 4-digit case year.';
        } else if($_POST['caseyear'] > date('Y')) {
            $errors[] = 'Cannot add a case year for a future date.';
        }
        else {
            $caseyear = trim($_POST['caseyear']);
	}

	// Check for a casenumber:
	if (empty($_POST['casenumber'])) {
            $errors[] = 'You must enter a case number to save.';
	} 
        else {
            $casenum = trim($_POST['casenumber']);
	}
	// Check for a casename:
	if (!empty($_POST['casename'])) {
            $casenam = trim($_POST['casename']);
	} 
        else {
            $casenam="";	
	}
        
        // Check for an original case year
        if (empty($_POST['origcaseyear'])) {
            $origcaseyear = null;
	} else if(!is_numeric($_POST['origcaseyear'])) {
            $errors[] = 'Case year must be numeric.';
        } else if(strlen("".$_POST['origcaseyear']) != 4) {
            $errors[] = 'Please enter a 4-digit original case year.';
        } else if($_POST['origcaseyear'] > date('Y')) {
            $errors[] = 'Cannot add an original case year for a future date.';
        }
        else {
            $origcaseyear = trim($_POST['origcaseyear']);
	}
    
    
	// Check for a case agency:
	if (empty($_POST['caseagency'])) {
            $caseag=NULL;
        
	} 
        else {
            $caseag = trim($_POST['caseagency']);
	}
        
        // Check for a case agency:
	if (empty($_POST['region_id'])) {
            $region_id = 0;
        
	} 
        else {
            $region_id = $_POST['region_id'];
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
            if(is_numeric($faage2_test) && $faage2_test > MAXAGE) {
                $errors[] = "Forensic Anthropology estimated age must be less than ".MAXAGE.".";
            } else {
                $faage2 = trim($_POST['faage2']);
                $faageunits2 = trim($_POST['faageunits2']);
            }

    }
    
    
    //check for a FA age 1
    if (empty($_POST['faage'])) {
        $faage=NULL;
        $faageunits=NULL;
    } 
    else {
        $faage_test = trim($_POST['faage']);
        if(!is_numeric($faage_test)) {
                $errors[] = "Forensic Anthropology estimated age must be numeric.";
        } else {
            if(is_numeric($faage_test) && $faage_test > MAXAGE) {
                $errors[] = "Forensic Anthropology estimated age must be less than ".MAXAGE.".";
            } else {
                $faage = trim($_POST['faage']);
                $faageunits = trim($_POST['faageunits']);
            }
        }
            
    }

    if (strlen($_POST['faage_notes']) > sofa_case::NOTES_MAX_LENGTH) {
                $errors[] = "Age notes must be less than " . sofa_case::NOTES_MAX_LENGTH . ".";
    }
 
    elseif(isset($_POST['faage_notes'])) {
        $faage_notes = $_POST['faage_notes'];
    } else {
        $faage_notes = null;
    }

	
     //check for a FA stature 2 first 
    if (empty($_POST['fastature2'])) {

        $fastature2=NULL;
    } 
    else {
        $fastature2_test = trim($_POST['fastature2']);
        if(!is_numeric($fastature2_test)) {
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
    } else {
        $fastature_test = trim($_POST['fastature']);
        if(!is_numeric($fastature_test)) {
            $errors[] = "Forensic Anthropology estimated stature must be numeric.";
        } else {
            $fastature = trim($_POST['fastature']);
            $fastatureunits = trim($_POST['fastatureunits']);
        }
    }


    if(isset($_POST['fastatureunits'])) {
            $fastatureunits = trim($_POST['fastatureunits']);
    } else {
            $fastatureunits = "inches";
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

    if (strlen($_POST['idsex_notes']) > sofa_case::NOTES_MAX_LENGTH) {
                $errors[] = "Sex notes must be less than " . sofa_case::NOTES_MAX_LENGTH . ".";
    }
 
    elseif(isset($_POST['idsex_notes'])) {
        $idsex_notes = $_POST['idsex_notes'];
    } else {
        $idsex_notes = null;
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

    if (strlen($_POST['idsex_notes']) > sofa_case::NOTES_MAX_LENGTH) {
                $errors[] = "Sex notes must be less than " . sofa_case::NOTES_MAX_LENGTH . ".";
    } 
    elseif(isset($_POST['idage_notes'])) {
        $idage_notes = $_POST['idage_notes'];
    } else {
        $idage_notes = null;
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

    if (strlen($_POST['idstature_notes']) > sofa_case::NOTES_MAX_LENGTH) {
                $errors[] = "Stature notes must be less than " . sofa_case::NOTES_MAX_LENGTH . ".";
    }
 
    elseif(isset($_POST['idstature_notes'])) {
        $idstature_notes = $_POST['idstature_notes'];
    } else {
        $idstature_notes = null;
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
        $idancaddtext = trim($_POST['idancaddtext']);
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
        
    } else {
	$faothertext = trim($_POST['farace_othertext']);
    }
 
    if(isset($_POST['race_asian'])) {
      $idAs=$_POST['race_asian'];
    } else {
        $idAs=0;
        
    }
    if(isset($_POST['race_black'])) {
      $idBl=$_POST['race_black'];
    }
    else{
        $idBl=0;
    }
	
     if(isset($_POST['race_white'])) {
      $idWh=$_POST['race_white'];
    } else{
        $idWh=0;
    }
	
    if(isset($_POST['race_hispanic'])) {
      $idHi=$_POST['race_hispanic'];
    } else{
        $idHi=0;
        
    }
	
   if(isset($_POST['race_native'])){
      $idNa=$_POST['race_native'];
    } else{
        $idNa=0;
    }
  
   if(isset($_POST['race_white'])){
      $idWh=$_POST['race_white'];
    } else{
        $idWh=0;
        
    }
   
    if(isset($_POST['race_other'])){
      $idOt=$_POST['race_other'];
    } else{
        $idOt=0;
    }
  
    
    if (empty($_POST['idrace_othertext'])) {
	$idothertext=NULL;
    } 
    else {
	$idOt=1;
        $idothertext = $_POST['idrace_othertext'];
    }
        
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
    
    if(($idOt==0 && $idothertext)||($idOt==1 && !$idothertext)) {
	{$errors[] = 'You must Check the Other box and enter text.';}
    } else {
        // 'Other' box not checked, or check and text added
    }
    
    if(empty($_POST['fdb_consent'])) {
        $errors[] = "You must select an FDB Data Sharing Option.";
    } else {
        $fdb_consent = $_POST['fdb_consent'];
    }

    if (empty($errors)) { 
       // If there were no errors
       //Determine whether the case has already been registered	
        $memberid=$session->get_var('id');

      $caseeditid=$_POST['caseid'];
      $case_exists = sofa_case::case_exists($db, $memberid, $caseyear, $casenum, $caseeditid);
        $casedata = new sofa_case($db, $caseeditid);
            if ($case_exists == false)
            {//The case has not been registered already 
		// Make the query:
		try {
                $case = new sofa_case($db, $caseeditid);
                $data = array(
                    
                    "casename"=>$casenam,
                    "casenum"=>$casenum,
                    "caseyear"=>$caseyear,
                    "origcaseyear"=>$origcaseyear,
                    "caseag"=>$caseag,
                    "region_id"=>$region_id,

                    "fasex"=>$fasex,
                    "faage"=>$faage,
                    "faage2"=>$faage2,
                    "faageunits"=>$faageunits,
                    "faageunits2"=>$faageunits2,
                    "faage_notes"=>$faage_notes,

                    "fastature"=>$fastature,
                    "fastature2"=>$fastature2,
                    "fastatureunits"=>$fastatureunits,
                    
                    "idsex"=>$idsex,
                    "idsex_notes"=>$idsex_notes,
                    "idage"=>$idage,
                    "idageunits"=>$idageunits,
                    "idage_notes"=>$idage_notes,
                    "idstature"=>$idstature,
                    "idstatureunits"=>$idstatureunits,
                    "idstature_notes"=>$idstature_notes,
                    
                    "idsource"=>$idsource,
                    "casenotes"=>$casenotes,
                    
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
                    
                    "fdb_consent"=>$fdb_consent,
                                    
                    "caseeditid"=>$caseeditid);

                                
                $result = $case->edit_case($data);
                } catch(Exception $e) {
                    echo($e->getTraceAsString());
                }
        	if ($result["RESULT"] == FALSE) { 
                    // If it did not run OK
                    // Error message:
                    echo '<h2>System Error</h2>
                    <p class="error">Registration failed because of a system error. We apologize for any inconvenience.</p>'; 
                    exit();
                } else {
                    echo($result["MESSAGE"]);
		    $casedata = new sofa_case($db, $caseeditid);
		    $region_id = $casedata->get_region_id();
                }

	} else {
            //The email address is already registered
            echo '<p class="error">The case name and number are not acceptable because it is already registered</p>';
        }//end already registered if
    } else { 
        // Report the errors.
        echo '<span style="padding-left:100px; 
            display:block;"><h2>Error!</h2>
        <p class="error">The following error(s) occurred:<br/>';
        foreach ($errors as $msg) { 
            // Print each error.
            echo " - $msg<br/>\n";
	}
        
        echo("</p><BR></span>");

    }// End of else (empty($errors))
    // End of the main Submit conditional.
}  else {
    // Post data not recognized
}

} else {
    // No submit
}

$regions_html = "";
$regions = functions::get_regions($db);
foreach ($regions as $region) {
        if ($region_id == $region['id']) {
                $regions_html .= "<option value='" . $region['id'] . "' selected>" . $region['name'] . "</option>";
        }
        else {
                $regions_html .= "<option value='" . $region['id'] . "'>" . $region['name'] . "</option>";
        }
}

?>



	<div id="tabs">
  <ul>
    <li><a href="#tabs-1">General Case Information</a></li>
    
    <li><a href="#tabs-2">Manage Case Methods</a></li>
 
  </ul>
<div id="tabs-1">
    
    
<fieldset class="enclosefieldset">
    
<form action="index.php" method="post" id="casedata" name="casedata">
    <input type='hidden' id='caseid' name='caseid' value='<?php echo $caseeditid; ?>'>
    <input type='hidden' id='caseid' name='savecase' value=1>
        
<fieldset class="caseinfobox"><legend class="boldlegend">General Case Information</legend>
Please note that only data related to the case year and case region is shared to the database. Case number and case agency is never released and is only kept in your personal case profile. 
      <BR><BR>
      <strong>* indicates a required field</strong>
      <BR><BR>      
          
    
  <label class="label" for="caseyear">Case Year (YYYY)*</label><input id="caseyear" type="text" name="caseyear" size="5" maxlength="4" value="<?php  echo $casedata->get_caseyear(); ?>"/>
  <br />
  <label class="label" for="origcaseyear">Original Case Year</label><input id="origcaseyear" type="text" name="origcaseyear" size="5" maxlength="4" value="<?php echo $casedata->get_orig_case_year(); ?>"/>
  <div class="tooltip"><img class='img-bottom' src="../../images/tooltip.png">
        <span class="tooltiptext">Does the year of this case's forensic anthropology analysis differ from the year the human remains were recovered? If so, please
provide the original case year in the box here, and your year that you
initiated the forensic anthropological analysis in the "Case Year" field
above.</span>
    </div>  
        <br/>
    
  <label class="label" for="casenumber">Case Number*</label><input id="casenumber" type="text" name="casenumber" size="30" maxlength="30" value="<?php echo $casedata->get_casenumber(); ?>"/>
  <br />
    
  <label class="label" for="caseagency">Case Agency</label><input id="caseagency" type="text" name="caseagency" size="30" maxlength="30" value="<?php echo $casedata->get_caseagency(); ?>"/>
 
  <br><label class="label" for="region_id">Case Region</label>
    <select name="region_id">
        <option value="">- Select -</option>
	<?php echo $regions_html; ?>

    </select>
  

    <span name="savebutton" class="bigsavebutton">
    <input name="savecase" type="image" id="savecase" src="../../images/bigsave.png" alt="Save Case" width="90"/></span>
  </fieldset>
    
  <fieldset class="caseinfobox"><legend class="boldlegend"> Biological Profile: Forensic Anthropology Case Estimation</legend>
    
    
  <label class="label" for="fasex">Sex</label>
  <select name="fasex">
    <option value="">- Select -</option>
    <option value="Female"<?php if ($casedata->get_fasex() == 'Female') echo ' selected="selected"'; ?>>Female</option>
    <option value="Probable Female"<?php if ($casedata->get_fasex() == 'Probable Female') echo ' selected="selected"'; ?>>Probable Female</option>
    <option value="Indeterminate"<?php if ($casedata->get_fasex() == 'Indeterminate') echo ' selected="selected"'; ?>>Indeterminate</option>
    <option value="Probable Male"<?php if ($casedata->get_fasex() == 'Probable Male') echo ' selected="selected"'; ?>>Probable Male</option>
    <option value="Male"<?php if ($casedata->get_fasex() == 'Male') echo ' selected="selected"'; ?>>Male</option>
    </select>
    
    
    
    <br/><label class="label" for="faage">Age</label><input id="faage" type="number" step="0.001" name="faage" size="5" maxlength="5" value="<?php  echo $casedata->get_faage(); ?>"/>
    
    <select name="faageunits">
      <option value="years">years</option>
      <option value="months"<?php if($casedata->get_faageunits() == 'months') echo ' selected="selected"'; ?>>months</option>
      <option value="fetalmonths"<?php if ($casedata->get_faageunits() == 'fetalmonths') echo ' selected="selected"'; ?>>fetal months</option>
      </select>&nbsp; to &nbsp;
    
    <input id="faage2" type="number" step="0.001" name="faage2" size="5" maxlength="5" value="<?php echo $casedata->get_faage2(); ?>"/>
    
    <select name="faageunits2">
      <option value="years">years</option>
      <option value="months"<?php if ($casedata->get_faageunits2() == 'months') echo ' selected="selected"'; ?>>months</option>
      <option value="fetalmonths"<?php if ($casedata->get_faageunits2() == 'fetalmonths') echo ' selected="selected"'; ?>>fetal months</option>
      </select>

    <div class="tooltip"><img class='img-bottom' src="../../images/tooltip.png">
        <span class="tooltiptext">If the estimated age is not a range (e.g. 55+ years), input "55" into the lower range text box provided here.</span>
    </div>      
    
    <BR>
    <label class="label" for="faage">Age Notes</label><input id="faage" type="text" name="faage_notes" size="30"  value="<?php echo ((isset($_POST['faage_notes'])) ? $_POST['faage_notes'] : $casedata->get_faage_notes()); ?>"/>
    <BR>
    
    <br/><label class="label" for="faancestry">Ancestry/Group Affiliation</label><input id="farace_othertext" type="text" name="farace_othertext" size="30" maxlength="100" value="<?php  echo $casedata->get_faancestryottext(); ?>"/>
    
    
    
    <br/><label class="label" for="fastature">Stature</label><input id="fastature" type="number" step="0.001" name="fastature" size="6" maxlength="8" value="<?php echo $casedata->get_fastature() ?>"/>  &nbsp; to &nbsp;
    
    <input id="fastature2" type="number" step="0.001" name="fastature2" size="6" maxlength="8" value="<?php echo $casedata->get_fastature2(); ?>"/>  <select name="fastatureunits">
        <option value="in" <?php if ($casedata->get_fastatureunits() == 'in') echo ' selected="selected"'; ?>>inches</option>
      <option value="cm" <?php if ($casedata->get_fastatureunits() == 'cm') echo ' selected="selected"'; ?>>cm</option>
      </select>
    
    
    </fieldset>
    
    <fieldset class="caseinfobox"><legend class="boldlegend">Biological Profile: Actual Identified Information</legend>
      
      <label class="label" for="idsex">Sex</label>

              <input type="radio" name="idsex" value="Female" <?php if ($casedata->get_idsex() == 'Female') echo ' checked'; ?>> Female
        <input type="radio" name="idsex" value="Male" <?php if ($casedata->get_idsex() == 'Male') echo ' checked'; ?>> Male
        <input type="radio" name="idsex" value="Other" <?php if (($casedata->get_idsex() != null) AND ($casedata->get_idsex() != 'Male') AND ($casedata->get_idsex() != 'Female')) echo ' checked'; ?>> Other: 
        <input id="idsexother" name="idsexother" type="text" 
          <?php if (($casedata->get_idsex() != null) AND ($casedata->get_idsex() != 'Male') AND ($casedata->get_idsex() != 'Female')) { echo " value='".$casedata->get_idsex()."' ";}?>/>
        <BR>
        <label class="label" for="idsex_notes">Sex Notes</label><input id="faage" type="text" name="idsex_notes" size="30"  value="<?php echo ((isset($_POST['idsex_notes'])) ? $_POST['idsex_notes'] : $casedata->get_idsex_notes()); ?>"/>
        <BR>
        <BR>
      
      
      <label class="label" for="idage">Age</label><input id="idage" type="number" step="0.001" name="idage" size="5" maxlength="5" value="<?php echo $casedata->get_idage(); ?>"/>
      <select name="idageunits">
        <option value="years">years</option>
        <option value="months"<?php if ($casedata->get_idageunits() == 'months') echo ' selected="selected"'; ?>>months</option>
        <option value="fmonths"<?php if ($casedata->get_idageunits() == 'fmonths') echo ' selected="selected"'; ?>>fetal months</option>
        </select> 
      <BR>  
        <label class="label" for="idage_notes">Age Notes</label><input id="faage" type="text" name="idage_notes" size="30"  value="<?php echo ((isset($_POST['idage_notes'])) ? $_POST['idage_notes'] : $casedata->get_idage_notes()); ?>"/>
        <BR>
        <BR> 

      <label class="label" for="idrace">Race/Ethnicity</label>
      <input type="checkbox" name="race_asian" value="1" <?php if ($casedata->get_idraceas() == 1) echo ' checked'; ?>/>Asian/Pacific Islander
      <input type="checkbox" name="race_black" value="1" <?php if ($casedata->get_idraceaf() == 1) echo ' checked'; ?>/>Black/African-American
      <input type="checkbox" name="race_hispanic" value="1" <?php if ($casedata->get_idracehi()  == 1) echo ' checked'; ?>/>Hispanic<br />
      <label class="label" for="idrace2"></label>
      <input type="checkbox" name="race_native" value="1" <?php if ($casedata->get_idracena() == 1) echo ' checked'; ?>/>Native American
      <input type="checkbox" name="race_white" value="1" <?php if ($casedata->get_idracewh() == 1) echo ' checked'; ?>/>White
      <input type="checkbox" name="race_other" value="1" <?php if ($casedata->get_idraceot() == 1) echo ' checked'; ?> />Other: &nbsp; <input id="idrace_othertext" type="text" name="idrace_othertext" size="18" maxlength="30" value="<?php echo $casedata->get_idraceottext(); ?>"/>
      <br /><label class="label" for="idancaddtext">Race/Ethnicity Notes</label><input id="idancaddtext" type="text" name="idancaddtext" size="30" maxlength="300" value="<?php echo $casedata->get_idancaddtext(); ?>" /><br>
      
      
      <br/><label class="label" for="idstature">Stature</label><input id="idstature" type="number" step="0.001" name="idstature" size="6" maxlength="8" value="<?php echo $casedata->get_idstature(); ?>" />
      
      <select name="idstatureunits" >
          <option value="in" <?php if ($casedata->get_idstatureunits() == 'in') echo ' selected="selected"'; ?>>inches</option>
        <option value="cm" <?php if ($casedata->get_idstatureunits() == 'cm') echo ' selected="selected"'; ?>>cm</option>
        </select>
      <BR>
      <label class="label" for="idstature_notes">Stature Notes</label><input id="faage" type="text" name="idstature_notes" size="30"  value="<?php echo ((isset($_POST['idstature_notes'])) ? $_POST['idstature_notes'] : $casedata->get_idstature_notes()); ?>"/>
      
      <BR>
      <BR>
      
      <br/><label class="label" for="idsource">Information Source</label><input id="idsource" type="text" name="idsource" size="30" maxlength="60" value="<?php echo $casedata->get_idsource(); ?>" /><br />
      
  </fieldset>
        
          
      
      <!-- Prior information -->
            <fieldset class="caseinfobox"><legend class="boldlegend">Background Case Knowledge</legend>
                <BR>
                Please check any component of the biological profile that was known to the practitioner during or before the time of case analysis.
                <BR><BR>

        <label class="label" for="known_none"></label><input type="checkbox" name="known_none" value="1" <?php if ($casedata->get_known_none() == 1) echo ' checked'; ?>/>No biological profile information was known or presumed<BR>
        <label class="label" for="known_sex"></label><input type="checkbox" name="known_sex" value="1" <?php if ($casedata->get_known_sex() == 1) echo ' checked'; ?>/>Sex was known or presumed<BR>
        <label class="label" for="known_age"></label><input type="checkbox" name="known_age" value="1" <?php if ($casedata->get_known_age() == 1) echo ' checked'; ?>/>Age was known or presumed<BR>
        <label class="label" for="known_ancestry"></label><input type="checkbox" name="known_ancestry" value="1" <?php if ($casedata->get_known_ancestry() == 1) echo ' checked'; ?>/>Ancestry/Group Affinity was known or presumed<BR>
        <label class="label" for="known_stature"></label><input type="checkbox" name="known_stature" value="1" <?php if ($casedata->get_known_stature() == 1) echo ' checked'; ?>/>Stature was known or presumed<BR>
	<label class="label" for="known_unable_to_determine"></label><input type="checkbox" name="known_unable_to_determine" value="1" <?php if ($casedata->get_known_unable_to_determine() == 1) { echo 'checked'; } ?> />Unable to determine 
        <div class="tooltip"><img class='img-bottom' src="../../images/tooltip.png">
                <span class="tooltiptext">If this information hasn't been documented, or you are entering data for a case completed by someone else at your agency, you may not know the context for assessing background knowledge and can check this box here.</span>
        </div> 
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
        <label class="label" for="consent"></label><input type='radio' name='fdb_consent' value='consent' <?php if ($casedata->get_fdb_consent() == 'consent') echo ' checked'; ?>>I consent to share this case data with FDB.</input><BR>
        <label class="label" for="already_submitted"></label><input type='radio' name='fdb_consent' value='already_submitted' <?php if ($casedata->get_fdb_consent() == 'already_submitted') echo ' checked'; ?>>I have already submitted this case data with FDB.</input><BR>
        <label class="label" for="decline"></label><input type='radio' name='fdb_consent' value='decline' <?php if ($casedata->get_fdb_consent() == 'decline') echo ' checked'; ?>>I decline to share this case data with FDB.</input><BR>
      </fieldset>
      
    <fieldset class="caseinfobox"><legend class="boldlegend">Case Notes</legend>
      <label class="label" for="casenotes"></label>
<textarea name="casenotes" cols="55" rows="7" placeholder='Please use this box to indicate any aspects of the case that are noteworthy for this case, or may have impacted your approach to assessing the biological profile for this case, including taphonomic alterations, postmortem damage, perimortem trauma, missing skeletal elements, burning, etc.'><?php echo $casedata->get_casenotes();?></textarea>

      </fieldset>
      </fieldset>
    </form>
	  </div>
	     <div id="tabs-2">
                    <?php
   if(isset($_POST['successAddCase'])) {
       echo("Case added successfully. You may now add method data to this case.<BR>");
   }
   ?>
                 
    <!-- Add Method box -->    

    <form action="index.php#tabs-2" method="post" id="method_info_data">
        <input type='hidden' id='caseid' name='caseid' value='<?php echo $caseeditid; ?>'>
        <?php
            if(!empty($_GET['success'])) {
                echo("Method edited successfully.<BR>");
            }
            ?>
    <fieldset class="methodinfobox"><legend class="boldlegend">Add Methods</legend>

    <div name="methodholder" id="methodholder">
             <p><select name="methodtype[]" id="methodtype">
                     
                <option value="" selected="selected" disabled="disabled">Add Method For</option>
                <option value=<?php echo '"'.METHOD_DATA_SEX_ID.'"';?> ><?php echo METHOD_DATA_SEX;?></option>
                <option value=<?php echo '"'.METHOD_DATA_AGE_ID.'"';?> ><?php echo METHOD_DATA_AGE;?></option>
                <option value=<?php echo '"'.METHOD_DATA_ANCESTRY_ID.'"';?> ><?php echo METHOD_DATA_ANCESTRY;?></option>
                <option value=<?php echo '"'.METHOD_DATA_STATURE_ID.'"';?> ><?php echo METHOD_DATA_STATURE;?></option>

                </select>

        <span id="wait_1" style="display: none;">

    <img alt="Please Wait" src="../../images/ajax-loader.gif"/>
    </span>
     <span id="result_1" style="display: none;"></span>
    <span id="wait_2" style="display: none;">
    <img alt="Please Wait" src="../../images/ajax-loader.gif"/>
    </span>

     <span id="result_2" style="display: none;"></span>
    </p>
             
    </div>

    </fieldset>
        </form>
    <!-- End Add Method box -->
    
                 <!-- Method data -->
                 <fieldset class="methodinfobox"><legend class="boldlegend">Currently Added Methods</legend>
   <div name="methodtableholder" id="methodtableholder">

    <table id="hortable" border="1">
       <tbody>
         <tr>
           <p>

             <th>Edit</th>
             <th>Delete</th>
             <th>Method Type</th>
             <th>Method Name</th>
             <th>Method Outcomes

                 <div class="tooltip"><img class='img-bottom' src="../../images/tooltip.png">
                     <span class="tooltiptext">This only displays a summary of the data you entered.</span>
                 </div>   

             </th>
                 </p>
         </tr>

         <?php
         $tier2s = $casedata->get_case_methods();

         // Draw the method table
         foreach($tier2s as $tier2) {
             $method = new method($db, $tier2->get_methodid());
             echo("<tr>");
             // Edit button
             echo("<td><form action=editmethods.php method=POST>"
                     . "<input type=hidden name=caseid value=$caseeditid>"
                     . "<input type=hidden name=tier2id value=".$tier2->get_id().">"
                     . "<input type=submit name=editmethod value='Edit'>"
                     . "</form>");

             // Delete button
             echo '<td><form action="index.php#tabs-2" method="post" id="removedata" onsubmit="return confirm(\'Do you really want to remove this method from this case?\')">
                 <form action="index.php#tabs-2" method="post" id="removedata" onsubmit="return confirm(\'Do you really want to remove this method from this case?\')">
                 <input name="delid" type="hidden" value="'.$tier2->get_id().'"/>
                 <input type=hidden name=caseid value='.$caseeditid.'>
                 <input name="delsubmit" type="submit" value="Delete" /> </form>
                 </td>';

             echo("<td>". $method->get_method_type()."</td>
                     <td>".$method->get_name()."</td>".
                     "<td>".$tier2->show_estimated_outcome()."</td>".
                     "</tr>");
         }

    ?>
                    
                   
        </tbody>
    </table>
    <div class="clear"></div>
    
    </div>
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
 
  frmvalidator.addValidation("caseyear","req","You must provide a year for the case");
  frmvalidator.addValidation("caseyear","gt=1900","Case Year must be post-1900");
 
  frmvalidator.addValidation("caseyear","maxlen=4","Year must be entered in YYYY format");
  frmvalidator.addValidation("caseyear","numeric","Year must be entered in YYYY format");
  
    
  frmvalidator.addValidation("faage", "lt=150", "Age should be less than 150.");
  frmvalidator.addValidation("faage2", "lt=150", "Age should be less than 150.");
  
  frmvalidator.addValidation("fastature","numeric","Statures must be entered as a number");
   
  frmvalidator.addValidation("fastature2","numeric","Statures must be entered as a number");
  
  frmvalidator.addValidation("idage","numeric","Ages must be entered as a number");
   
  frmvalidator.addValidation("idstature","numeric","Statures must be entered as a number");
    
  frmvalidator.addValidation("idrace_othertext","req","Please fill-in the  Other Race/Ethinicity textbox",
    "VWZ_IsChecked(document.forms['casedata'].elements['race_other'],'1')");
		
  frmvalidator.addValidation("farace_othertext","req","Please fill-in the Other Ancestry textbox",
        "VWZ_IsChecked(document.forms['casedata'].elements['farace_other'],'1')");

	//]]></script>
    
<?php
    require_once("../../include/footer.php");
?>

