<?php 
require_once('../../include/header_user.php');
require_once('../../include/session_user.php') ;
require_once('func.php');

?>

<title>Edit Case Information</title>


  <h1 class="cntr">Edit Case Information</h1>

  <?php

$casedata = null;
if(isset($_GET['id'])) 
{
    $caseeditid=$_GET['id'];
    $_SESSION['caseid']=$caseeditid;
    //unset($_GET['id']);

    $casedata = new sofa_case($db, $caseeditid);
}

elseif(!isset($_SESSION['caseid']))
{ 
    header ("location: ../index.php"); exit();
}



elseif(isset($_SESSION['caseid']))
{
	$caseeditid=$_SESSION['caseid'];
        $casedata = new sofa_case($db, $caseeditid);

        $casedata = new sofa_case($db, $caseeditid);
}
	
 $methods = $casedata->get_case_methods();
 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if(isset($_POST['methodtype'])) {
        $selmethodtype = $_POST['methodtype'][0];
    }
    
    //remove method from case here, decrement total cases and numsubmitted from members.
    if (isset($_POST['delsubmit']))
    {

            $deleteid=$_POST['delid'];
            $tier2 = new tier2data($db, $deleteid);
            $caseid = $tier2->get_caseid();
            $this_case = new sofa_case($db, $caseid);
            $this_case->remove_method($deleteid);
            

    } else if(isset($_POST['add_method'])) {

        
        $estimated_outcome_1 = null;
        $estimated_outcome_2 = null;
        $estimated_outcome_units = null;
        
        if(isset($_POST['estimated_outcome_1'])) {
            $estimated_outcome_1 = $_POST['estimated_outcome_1'];
        }
        if(isset($_POST['estimated_outcome_2'])) {
            $estimated_outcome_2 = $_POST['estimated_outcome_2']; 
       }
        if(isset($_POST['estimated_outcome_units'])) {
            $estimated_outcome_units = $_POST['estimated_outcome_units'];
        }
        
        $method_id = $_POST['drop_2'];
        $method = new method($db, $method_id);
        
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
        foreach($output_data as $od) {

            if(is_array($od)) {
                foreach($od as $id=>$value) {
                    if($id != null && $id != '') {
                    //echo("adding to tier3 ($id, $value)<BR>");
                    $this_case->add_tier3($t2id, $id, $value);
                    }
                }
            } else {
                if($od != null && $od != '') {
                $this_case->add_tier3($t2id, $od);
                }
            }
        }
        
        if($_POST['check_select'] != null) {
            // used for checkbox arrays, like Rios & Cardoso
            print_r($_POST['check_select']);
            $check_select = $_POST['check_select'];
            foreach($check_select as $method_info_id=>$option_list) {
                foreach($option_list as $option_id=>$option_name) {
                    if($option_id > 0) {                
                        $this_case->add_tier3($t2id, $option_id);
                    }
                }

            }
            
        }
        
        if($_POST['references'] != null) {
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
            
        }

        header ("location:index.php#tabs-2");

    }

    
 else {

	$errors = array(); // Start an array to hold the errors
	
	// Check for a casename:
	if (empty($_POST['caseyear'])) {
		$errors[] = 'You must enter a case year to save.';
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
                $faage2 = trim($_POST['faage2']);
                $faageunits2 = trim($_POST['faageunits2']);
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
                $faage = trim($_POST['faage']);
                $faageunits = trim($_POST['faageunits']);
            }
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
        $fastature_test = trim($_POST['fastature']);
        $fastature2_test = trim($_POST['fastature2']);
            if(!is_numeric($fastature_test) || !is_numeric($fastature2_test)) {
                $errors[] = "Forensic Anthropology estimated stature must be numeric.";
            } else {
                $fastature = trim($_POST['fastature']);
                $fastature2 = trim($_POST['fastature2']);

                if(isset($_POST['fastatureunits'])) {
                    $fastatureunits = trim($_POST['fastatureunits']);
                } else {
                    $fastatureunits = "inches";
                }
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
		$idage = trim($_POST['idage']);
                $idageunits = trim($_POST['idageunits']);
            }
	}



	//check for a id stature
	if (empty($_POST['idstature'])) {
		$idstature=NULL;
        $idstatureunits=NULL;
	} 
    else {
        $idstature_test = trim($_POST['idstature']);
            if(!is_numeric($idstature)) {
                $errors[] = "Identified stature must be numeric.";
            } else {
            
		$idstature = trim($_POST['idstature']);
            if(isset($_POST['idstatureunits'])) {
                $idstatureunits = trim($_POST['idstatureunits']);
                } else {
                    $idstatureunits = "inches";
                }
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
		
        $idancaddtext = trim($_POST['idancaddtext']);
	}
    
    //check for a  casenotes
	if (empty($_POST['casenotes'])) {
		$casenotes=NULL;
        
	} 
    else {
		
        $casenotes = trim($_POST['casenotes']);
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
    
    if(($idOt==0 && $idothertext)||($idOt==1 && !$idothertext))
	{$errors[] = 'You must Check the Other box and enter text.';}
    


    
    if (empty($errors)) 
        { // If there were no errors
		//Determine whether the case has already been registered	
		$memberid=$_SESSION['id'];

      $caseeditid=$_SESSION['caseid'];
      
      $case_exists = sofa_case::case_exists($db, $memberid, $caseyear, $casenum, $caseeditid);

            if ($case_exists == false)
            {//The case has not been registered already 
		// Make the query:
		
                $case = new sofa_case($db, $caseeditid);
                $data = array(
                    
                   "casename"=>$casenam,
                   "casenum"=>$casenum,
                   "caseyear"=>$caseyear,
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
                                    
                    "caseeditid"=>$caseeditid);

                                
                $result = $case->edit_case($data);
        	if ($result["RESULT"] == FALSE) 
                { // If it ran OK.
                // If it did not run OK
				// Error message:
				echo '<h2>System Error</h2>
				<p class="error">Registration failed because of a system error. We apologize for any inconvenience.</p>'; 
				// Debugging message:
				echo '<p>' . $db->errorInfo()[2] . '<br/><br/>Query: ' . $q . '</p>';
                exit();
                } else {
                    echo($result["MESSAGE"]);
                }

       		unset($_SESSION['caseid']); 
                header ("location: ../index.php");

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
}
?>

  <script type='text/javascript'>
  $(function() {
    $('#casedata').areYouSure(
      {
        message: 'It looks like you have been editing something. '
               + 'If you leave before saving, your changes will be lost.'
      }
    );
  });
  
    $(function() {
    $('#method_info_data').areYouSure(
      {
        message: 'It looks like you have been editing something. '
               + 'If you leave before saving, your changes will be lost.'
      }
    );
  });
</script>


  <div id="caseform">
  
   
  

	<div id="tabs">
  <ul>
    <li><a href="#tabs-1">General Case Information</a></li>
    <li><a href="#tabs-2">Manage Case Methods</a></li>
 
  </ul>
<div id="tabs-1">
    
    
  <fieldset class="enclosefieldset">
    
    <form action="index.php" method="post" id="casedata" name="casedata">
        <input type='hidden' id='caseid' name='caseid' value='<?php echo $caseeditid; ?>'>
  <fieldset class="caseinfobox"><legend class="boldlegend">General Case Information</legend>
      
          
    
     <label class="label" for="caseyear">Case Year</label><input id="caseyear" type="text" name="caseyear" size="5" maxlength="4" value="<?php  echo $casedata->get_caseyear();; ?>"/>
  <br />
    
  <label class="label" for="casenumber">Case Number</label><input id="casenumber" type="text" name="casenumber" size="30" maxlength="30" value="<?php echo $casedata->get_casenumber(); ?>"/>
  <br />
    
  <label class="label" for="caseagency">Case Agency</label><input id="caseagency" type="text" name="caseagency" size="30" maxlength="30" value="<?php echo $casedata->get_caseagency(); ?>"/>
      
  <br/>
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
    
    
    
    <br/><label class="label" for="faage">Age</label><input id="faage" type="text" name="faage" size="5" maxlength="5" value="<?php  echo $casedata->get_faage(); ?>"/>
    
    <select name="faageunits">
      <option value="years">years</option>
      <option value="months"<?php if($casedata->get_faageunits() == 'months') echo ' selected="selected"'; ?>>months</option>
      <option value="fetalmonths"<?php if ($casedata->get_faageunits() == 'fetalmonths') echo ' selected="selected"'; ?>>fetal months</option>
      </select>&nbsp; to &nbsp;
    
    <input id="faage2" type="text" name="faage2" size="5" maxlength="5" value="<?php echo $casedata->get_faage2(); ?>"/>
    
    <select name="faageunits2">
      <option value="years">years</option>
      <option value="months"<?php if ($casedata->get_faageunits2() == 'months') echo ' selected="selected"'; ?>>months</option>
      <option value="fetalmonths"<?php if ($casedata->get_faageunits2() == 'fetalmonths') echo ' selected="selected"'; ?>>fetal months</option>
      </select>
    
    
    
    <br/><label class="label" for="faancestry">Ancestry/Group Affiliation</label><input id="farace_othertext" type="text" name="farace_othertext" size="30" maxlength="100" value="<?php  echo $casedata->get_faancestryottext(); ?>"/>
    
    
    
    <br/><label class="label" for="fastature">Stature</label><input id="fastature" type="text" name="fastature" size="6" maxlength="8" value="<?php echo $casedata->get_fastature() ?>"/>  &nbsp; to &nbsp;
    
    <input id="fastature2" type="text" name="fastature2" size="6" maxlength="8" value="<?php echo $casedata->get_fastature2(); ?>"/>  <select name="fastatureunits">
        <option value="in" <?php if ($casedata->get_fastatureunits() == 'in') echo ' selected="selected"'; ?>>inches</option>
      <option value="cm" <?php if ($casedata->get_fastatureunits() == 'cm') echo ' selected="selected"'; ?>>cm</option>
      </select>
    
    
    </fieldset>
    
    <fieldset class="caseinfobox"><legend class="boldlegend">Biological Profile: Actual Identified Information</legend>
      
      <label class="label" for="idsex">Sex</label>
      <!--
      <select name="idsex">
        <option value="">- Select -</option>
        <option value="Female"<?php if($casedata->get_idsex() == 'Female') echo ' selected="selected"'; ?>>Female</option>
        <option value="Male"<?php if($casedata->get_idsex()  == 'Male') echo ' selected="selected"'; ?>>Male</option>
        </select>
      -->
              <input type="radio" name="idsex" value="Female" <?php if ($casedata->get_idsex() == 'Female') echo ' checked'; ?>> Female
        <input type="radio" name="idsex" value="Male" <?php if ($casedata->get_idsex() == 'Male') echo ' checked'; ?>> Male
        <input type="radio" name="idsex" value="Other" <?php if (($casedata->get_idsex() != null) AND ($casedata->get_idsex() != 'Male') AND ($casedata->get_idsex() != 'Female')) echo ' checked'; ?>> Other: 
        <input id="idsexother" name="idsexother" type="text" 
          <?php if (($casedata->get_idsex() != null) AND ($casedata->get_idsex() != 'Male') AND ($casedata->get_idsex() != 'Female')) { echo " value='".$casedata->get_idsex()."' ";}?>/>
               <BR>
      
      
      <br/><label class="label" for="idage">Age</label><input id="idage" type="text" name="idage" size="5" maxlength="5" value="<?php echo $casedata->get_idage(); ?>"/>
      <select name="idageunits">
        <option value="years">years</option>
        <option value="months"<?php if ($casedata->get_idageunits() == 'months') echo ' selected="selected"'; ?>>months</option>
        <option value="fmonths"<?php if ($casedata->get_idageunits() == 'fmonths') echo ' selected="selected"'; ?>>fetal months</option>
        </select> 
      
      
      
      
      
      <br/><label class="label" for="idrace">Race/Ethnicity</label>
      <input type="checkbox" name="race_asian" value="1" <?php if ($casedata->get_idraceas() == 1) echo ' checked'; ?>/>Asian/Pacific Islander
      <input type="checkbox" name="race_black" value="1" <?php if ($casedata->get_idraceaf() == 1) echo ' checked'; ?>/>Black/African-American
      <input type="checkbox" name="race_hispanic" value="1" <?php if ($casedata->get_idracehi()  == 1) echo ' checked'; ?>/>Hispanic<br />
      <label class="label" for="idrace2"></label>
      <input type="checkbox" name="race_native" value="1" <?php if ($casedata->get_idracena() == 1) echo ' checked'; ?>/>Native American
      <input type="checkbox" name="race_white" value="1" <?php if ($casedata->get_idracewh() == 1) echo ' checked'; ?>/>White
      <input type="checkbox" name="race_other" value="1" <?php if ($casedata->get_idraceot() == 1) echo ' checked'; ?> />Other: &nbsp; <input id="idrace_othertext" type="text" name="idrace_othertext" size="18" maxlength="30" value="<?php echo $casedata->get_idraceottext(); ?>"/>
      <br /><label class="label" for="idancaddtext">Race/Ethnicity Notes</label><input id="idancaddtext" type="text" name="idancaddtext" size="30" maxlength="300" value="<?php echo $casedata->get_idancaddtext(); ?>" /><br>
      
      
      <br/><label class="label" for="idstature">Stature</label><input id="idstature" type="text" name="idstature" size="6" maxlength="8" value="<?php echo $casedata->get_idstature(); ?>" />
      
      <select name="idstatureunits" >
          <option value="in" <?php if ($casedata->get_idstatureunits() == 'in') echo ' selected="selected"'; ?>>inches</option>
        <option value="cm" <?php if ($casedata->get_idstatureunits() == 'cm') echo ' selected="selected"'; ?>>cm</option>
        </select>
      
      <br />
      
      <br/><label class="label" for="idsource">Information Source</label><input id="idsource" type="text" name="idsource" size="30" maxlength="60" value="<?php echo $casedata->get_idsource(); ?>" /><br />
      
  </fieldset>
        
          </fieldset>
      
      <!-- Prior information -->
            <fieldset class="caseinfobox"><legend class="boldlegend">Prior Case Knowledge</legend>
                <BR>
                Please check any component of the biological profile that was known to the practitioner during or before the time of case analysis.
                <BR><BR>

<label class="label" for="known_none"></label><input type="checkbox" name="known_none" value="1" <?php if ($casedata->get_known_none() == 1) echo ' checked'; ?>/>No biological profile information was known<BR>
<label class="label" for="known_sex"></label><input type="checkbox" name="known_sex" value="1" <?php if ($casedata->get_known_sex() == 1) echo ' checked'; ?>/>Sex was known<BR>
<label class="label" for="known_age"></label><input type="checkbox" name="known_age" value="1" <?php if ($casedata->get_known_age() == 1) echo ' checked'; ?>/>Age was known<BR>
<label class="label" for="known_ancestry"></label><input type="checkbox" name="known_ancestry" value="1" <?php if ($casedata->get_known_ancestry() == 1) echo ' checked'; ?>/>Ancestry/Group Affinity was known<BR>
<label class="label" for="known_stature"></label><input type="checkbox" name="known_stature" value="1" <?php if ($casedata->get_known_stature() == 1) echo ' checked'; ?>/>Stature was known <BR>
<label class="label" for="known_unable_to_determine"></label><input type="checkbox" name="known_unable_to_determine" value="1" <?php if ($casedata->get_known_unable_to_determine() == 1) echo ' checked'; ?>/>Unable to determine<BR>

      </fieldset>
      
    <fieldset class="caseinfobox"><legend class="boldlegend">Case Notes</legend>
      <label class="label" for="casenotes"></label>
      <textarea name="casenotes" cols="55" rows="7"><?php echo $casedata->get_casenotes(); ?></textarea>

      </fieldset>
    </form>
	  </div>
	     <div id="tabs-2">
                    <?php
   if(isset($_GET['successAddCase'])) {
       echo("Case added successfully. You may now add method data to this case.<BR>");
   }
   ?>
                 
                     <!-- Add Method box -->    

        <form action="index.php#tabs-2" method="post" id="method_info_data">
        <input type='hidden' id='caseid' name='caseid' value='<?php echo $caseeditid; ?>'>
    <fieldset class="methodinfobox"><legend class="boldlegend">Add Methods</legend>

    <div name="methodholder" id="methodholder">
             <p><select name="methodtype[]" id="methodtype">
                     
                           <option value="" selected="selected" disabled="disabled">Add Method For</option>
                           <option value="1" >Sex</option>
                           <option value="2" >Age</option>
                           <option value="3" >Ancestry</option>
                           <option value="4" >Stature</option>

                            </select>

                             <span id="wait_1" style="display: none;">

    <img alt="Please Wait" src="ajax-loader.gif"/>
    </span>
     <span id="result_1" style="display: none;"></span>
    <span id="wait_2" style="display: none;">
    <img alt="Please Wait" src="ajax-loader.gif"/>
    </span>
     <!--
     <input type="submit" class="showybutton"  name='add_method' value="Save Method" /><BR>
     -->
     <span id="result_2" style="display: none;"></span>
    <span id="wait_3" style="display: none;">
        <img alt="Please Wait" src="ajax-loader.gif"/>
    </span>
     <span id="result_3" style="display: none;">
         
     </span></p>
             
           <!--<p>  <input type="button" class="showybutton" id="addmethodbutton" value="Add Method to List" ></p>-->
    </div>

          <input name="fchoseninput" type="hidden" id="fchoseninput" value="0" />
    <input name="pchoseninput" type="hidden" id="pchoseninput" value="0" />   
   
    
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
                         <th>
						
                            Method Type
                        </th>
                            <th>
                                   Method Name
                            </th>
                            <th>
                                   Method Outcomes
                            </th>
                            </p>
                    </tr>
                    
                    <?php
                    $tier2s = $casedata->get_case_methods();
                    
                    
                    foreach($tier2s as $tier2) {
                        $method = new method($db, $tier2->get_methodid());
                        echo("<tr>
                            
                        <td><U><a href=editmethods.php?id=".$caseeditid."&tier2id=".$tier2->get_id().">Edit</a></U></td>");
                        
                        
                        echo '<td><form action="index.php#tabs-2" method="post" id="removedata" onsubmit="return confirm(\'Do you really want to remove this method from this case?\')">
                            <form action="index.php#tabs-2" method="post" id="removedata" onsubmit="return confirm(\'Do you really want to remove this method from this case?\')">
                            <input name="delid" type="hidden" value="'.$tier2->get_id().'"/>
                            <input name="delsubmit" type="submit" value="Remove" /> </form>
                            </td>';
                        
                        echo("<td>". $method->get_method_type()."</td>
				<td>".$method->get_name()."</td>".
                                //"<td>".$tier2->format_tier3data_new()."</td>".
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
    
<!--<br />	<br /> <label class="label" for="savecase">Click here to save case</label>
    <input name="savecase" id="savecase" type="submit" value="Save Case"/>-->
    
    
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
//  frmvalidator.addValidation("casename","req","You must provide a nickname for the case");

  
   frmvalidator.addValidation("faage","numeric","Ages must be entered as a number");
   
  frmvalidator.addValidation("faage2","numeric","Ages must be entered as a number");
  
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

