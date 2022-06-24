<?php 
$title = "Forensic Anthropology Case Database (FADAMA) - Edit Case Methods";
require_once('../../include/header_user.php');
require_once('../../include/session.inc.php') ;
?>

<h1 class="cntr">Edit Case Methods</h1>

<center>(<a href="https://fadamahelp.miraheze.org/wiki/FADAMA_User_Tutorial#Add_methods" target="_blank">Edit methods tutorial</a>)</center>


  <?php

$casedata = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Posted form
    
    if(isset($_POST['caseid'])) {
        // Edit methods for the case
        
        $case = new sofa_case($db, $_POST['caseid']);
        if($case->get_memberid() != $session->get_var('id')) {
            // Member does not have permission to view/edit this case
            echo('<span style="padding-left:100px; 
                        display:block;">');
            echo "You do not have permission to view this case.";
            echo("</span>");
            require_once("../../include/footer.php");
            exit;
        } else {
            // Create the case object
            $caseeditid=$_POST['caseid'];
            $casedata = new sofa_case($db, $caseeditid);

            if(isset($_POST['tier2id'])) {
                $tier2id = $_POST['tier2id'];
                $tier2 = new tier2data($db, $_POST['tier2id']);
                $method = new method($db, $tier2->get_methodid());

            } else {
                // No tier2 data given
            }
        }
    } else {
        echo("Please input a valid case id.<BR>");
    }
    
    if(!isset($_POST['tier2id'])) {
        echo("Please select a valid tier2id.<BR>");
    } else {
        if(isset($_POST['submit'])) {
            // Edit methods
            $numerrors = 0;
            $errors = array();

            $tier2id = $_POST['tier2id'];
            $tier2 = new tier2data($db, $_POST['tier2id']);
            $method = new method($db, $tier2->get_methodid());

            $est1 = null;
            $est2 = null;
            $units = null;

            if(isset($_POST['estimated_outcome_1'])) {
                $est1 = $_POST['estimated_outcome_1'];
            } else {
                // No estimated outcome 1 given
            }

            if(isset($_POST['estimated_outcome_2'])) {
                $est2 = $_POST['estimated_outcome_2'];
            } else {
                // No estimated outcome 2 given
            }

            if(isset($_POST['estimated_outcome_units'])) {
                $units = $_POST['estimated_outcome_units'];
            } else {
                // No estimated outcome units given
            }



            if($method->get_method_type_num() == METHOD_DATA_STATURE_ID ||
                    $method->get_method_type_num() == METHOD_DATA_AGE_ID) {
                if(($est1 != null && $est1 !=  "" && !is_numeric($est1)) ||
                        ($est2 != null && $est2 !=  "" && !(is_numeric($est2)))) {
                    $numerrors++;
                    $errors[] = "Estimated outcome must be numeric.";

                } else {
                    // estimated outcome data is correctly formatted
                }
            } else {
                // No estimated outcome data needed
            }

            // Check for errors
            // $_POST[output_data] is the results of all the data given
            // for the method info data.
            //
            // It is in $id=>$value pairs, where $id is the ID of the method_info_option,
            // and $value is the value associated with it, if any
            $output_data = $_POST['output_data'];
            
            foreach($output_data as $od) {
                
                // Check for validity
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
                                $numerrors++;
                            } else {
                                // Numeric input okay
                            }

                        } else {
                            // ID not given
                        }
                    }
                } else {
                    // $output_data is not array
                }
            }

            if($numerrors == 0) {
                
                // No errors, add new data
                $tier2->update_estimated_outcomes($est1, $est2, $units);

                $result = null;
                $numerrors = 0;
                // make changes
                
                // First find out which method_info_options have already been added
                // to this case
                $this_case = new sofa_case($db, $caseeditid);
                $tier3s = $tier2->get_tier3data();
                $existing_ids = array();
                foreach($tier3s as $t3) {
                    $existing_ids[] = $t3->get_method_info_option_id();
                }

                $method = new method($db, $tier2->get_methodid());

                $user_interaction = "";
                $user_interactions = array();


                $output_data = $_POST['output_data'];
                $new_ids = array();

                
                // $new_ids is an array of the ids of the method_info_options
                // existing in this update.
                foreach($output_data as $od) {
                    if(is_array($od)) {

                        foreach($od as $id=>$value) {
                            // For each $output_data entry, add the new entry and
                            // delete the old one (if it exists)
                            // Add the id of the method_info to new_ids[]
                            if($id != null && $id != '') {
                                $new_ids[] = $id;

                                tier3data::delete_tier3($db, $tier2id, $id);
                                $casedata->add_tier3($tier2id, $id, $value);
                                $existing_ids[] = $id;

                            }
                        }
                    }
                    else {
                        // If it's not an array, $od is just the ID itselfm and has
                        // no value associated with it.
                        if($od != null && $od != '') {
                            $new_ids[] = $od;
                        }
                    }

                }

                if (isset($_POST['LR']) && ($_POST['LR'] != null)) {
                    // "LR" is a method type for "left/right" radio button, used to determine
                    // if a left or right bone was used.
                    //
                    // The $_POST['LR'] input contains data from all the LR inputs in the method
                    // This is separate from the output_data, because the 'name' value must be the same for the entire set of radio buttons

                    $lr = $_POST['LR'];
                    // process left/right options
                        foreach($lr as $value=>$id) {

                            if($id != null && $id != '') {
                                // Add the data, and also add it to new_ids[], and then existing_ids[]
                                $new_ids[] = $id;

                                tier3data::delete_tier3($db, $tier2id, $id);
                                $casedata->add_tier3($tier2id, $id);

                                $existing_ids[] = $id;

                            }
                    }
                }



                foreach($new_ids as $new_id) {
                    // If the id is in new_ids, but not in existing_ids, it hasn't been added yet
                    // so add it now.
                    if(!in_array($new_id, $existing_ids)) {
                        $casedata->add_tier3($tier2id, $new_id);
                    }
                }

                foreach($existing_ids as $ex_id) {
                    // If it was in existing_ids, but not in new-ids, it has been 
                    // deleted, so delete it from database.
                    if(!in_array($ex_id, $new_ids)) {
                        tier3data::delete_tier3($db, $tier2id, $ex_id);
                    }
                }

                // References
                // Delete existing and add new

                $selected_refs = $tier2->get_all_selected_references();
                foreach($selected_refs as $sel_ref) {
                    $sel_ref->remove_reference_from_tier2($sel_ref->get_id());
                }

                if (isset($_POST['references']) && ($_POST['references'] != null)) {
                    // add references
                    $t2id = $tier2->get_id();
                        $sel_refs = $_POST['references'];
                        foreach($sel_refs as $id=>$ref_list) {

                            foreach($ref_list as $ref=>$ref_name) {

                                if($ref > 0) {                
                                    $reference = new reference($db, $ref);
                                    $reference->add_reference_to_tier2($tier2id, $id);
                                }
                            }

                        }

                    } else {
                        // No references
                    }

                    if(isset($_POST['check_select']) && $_POST['check_select'] != null) {
                        // used for checkbox arrays, like Rios & Cardoso
                        $check_select = $_POST['check_select'];
                        foreach($check_select as $method_info_id=>$option_list) {
                            foreach($option_list as $option_id=>$option_name) {
                                if($option_id > 0) {    
                                    $this_case->add_tier3($tier2id, $option_id);
                                }
                            }
                        }
                    } else {
                        // No checkbox selectors
                    }

                echo("<div id='caseform'>");
                if($numerrors == 0) {
                    // Edit went smoothly
                    echo("Method edited successfully.");
                } else {
                    // There were errors, output them
                    foreach($result as $error_result) {
                        echo($error_result['MESSAGE']. "<BR>");
                    }
                }
                echo("</div>");

            } else {
                // Report the errors.
                echo '<span style="padding-left:100px; 
                    display:block;"><h2>Error!</h2>
                    <p class="error">The following error(s) occurred:<br/>';
                foreach ($errors as $msg) { // Print each error.
                    echo " - $msg<br/>\n";
                }
                echo '</p><h3>Please try again.</h3><p><br/></p></span>';

            }   
        } else {
            // Not posted
        }
    }
    
} else {
    // Nothing posted
}
?>
  


  <div id="caseform">
	<form method="post" action="index.php#tabs-2">
            <input type="hidden" name="caseid" value="<?php echo $caseeditid; ?>">
            <input type="submit" name="submit" value="Back to Case">
         </form>
	<br>
  <div id="tabs">
  <ul>
	<li><a href="#tabs-1">Manage Case Methods</a></li>
  </ul>

    <div id="tabs-1">
                 
        <!-- Add Method box -->    
        <?php 
        echo('<form action="editmethods.php" method="post" id="casedata">');
        ?>
        
        <input type='hidden' id='submit' name='submit' value='1'>
        <input type='hidden' id='caseid' name='caseid' value='<?php echo $caseeditid; ?>'>
        <input type='hidden' id='tier2id' name='tier2id' value='<?php echo $tier2id; ?>'>
        <fieldset class="methodinfobox"><legend class="boldlegend">Edit Methods</legend>

        <?php
        echo($method->get_name());
        echo('<br><input type="submit" class="showybutton" id="editmethoddatabutton" value="Save Edits" ><BR><BR>');
        // Draw method_infos for this method, with tier2data 
        method_infos::show_method_info($db, $tier2->get_methodid(), $tier2->get_id());
        
        ?>


        <br><input type="submit" class="showybutton" id="editmethoddatabutton" value="Save Edits" ><BR><BR>

        </form>
   
    
    </fieldset>
        
    
<!-- Method data -->
<div class="scroll" name="methodtableholder" id="methodtableholder">
                          
<table id="hortable" border="1">
	<tbody><tr>
		<th>Edit</th>
		<th>Delete</th>
		<th>Method Type</th>
		<th>Method Name</th>
		<th>Method Outcomes </th>
	</tr>

         <?php
         // Draw table of all methods used in this  case
         $caseid = $_POST['caseid'];

         $casedata = new sofa_case($db, $caseid);
         $tier2s = $casedata->get_case_methods();

         foreach($tier2s as $tier2) {
             $method = new method($db, $tier2->get_methodid());
             echo("<tr>");

             // Edit button
             echo("<td><form action=editmethods.php method=POST>"
                     . "<input type=hidden name=caseid value=$caseid>"
                     . "<input type=hidden name=tier2id value=".$tier2->get_id().">"
                     . "<input type=submit name=editmethod value='Edit'>"
                     . "</form>");

             // Delete button
             echo '<td>
                 <form action="index.php" method="post" id="removedata" onsubmit="return confirm(\'Do you really want to remove this method from this case?\')">
                 <input type=hidden name=caseid value='.$caseid.'>
                 <input name="delid" type="hidden" value="'.$tier2->get_id().'"/>
                 <input name="delsubmit" type="submit" value="Remove" /> </form>
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
</div>
</div></div>
	  
<div id="casedata_errorloc" class="errorlocation">
</div>

</fieldset>
 
</form>

<?php require_once("../../include/footer.php"); ?>

