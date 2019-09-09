<?php 
require_once('../../include/header_user.php');
require_once('../../include/session_addcase.php') ;
require_once('func.php');

?>

<title>Edit Case Methods</title>

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

  <h1 class="cntr">Edit Case Methods</h1>




  <?php

$casedata = null;
if(isset($_GET['id'])) 
{
    $caseeditid=$_GET['id'];
    $_SESSION['caseid']=$caseeditid;
    unset($_GET['id']);

    $casedata = new sofa_case($db, $caseeditid);
    
    
    if(isset($_GET['tier2id'])) {
        //$method_info = new method_info($db, $_GET['methodid']);
        $tier2id = $_GET['tier2id'];
        $tier2 = new tier2data($db, $_GET['tier2id']);
        $method = new method($db, $tier2->get_methodid());
        
    }
}

elseif(!isset($_SESSION['caseid']))
{ 
    header ("location: ../index.php"); exit();
}

elseif(isset($_SESSION['caseid']))
{
	$caseeditid=$_SESSION['caseid'];
        $casedata = new sofa_case($db, $caseeditid);

}
	
 $methods = $casedata->get_case_methods();
 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //echo("POST=");
//print_r($_POST);
    if(isset($_POST['tier2id'])) {
        
        //$method_info = new method_info($db, $_GET['methodid']);
        $tier2id = $_POST['tier2id'];
        $tier2 = new tier2data($db, $_POST['tier2id']);
        $method = new method($db, $tier2->get_methodid());
        
        $est1 = null;
        $est2 = null;
        $units = null;
        
        if(isset($_POST['estimated_outcome_1'])) {
            $est1 = $_POST['estimated_outcome_1'];
        }
        
        if(isset($_POST['estimated_outcome_2'])) {
            $est2 = $_POST['estimated_outcome_2'];
        }
        
        if(isset($_POST['estimated_outcome_units'])) {
            $units = $_POST['estimated_outcome_units'];
        }
        
        if($est1 != null) {
            $tier2->update_estimated_outcomes($est1, $est2, $units);
        }

    }
    $result = null;
    $errors = 0;
    // make changes
    $this_case = new sofa_case($db, $caseeditid);
    $tier3s = $tier2->get_tier3data();
    $existing_ids = array();
    foreach($tier3s as $t3) {
        $existing_ids[] = $t3->get_methodinfoid();
    }
    $method = new method($db, $tier2->get_methodid());
    $method_info = $method->get_method_info();
    $user_interaction = "";
    if(count($method_info) > 0) {
        $user_interactions = $method_info[0]->get_user_interactions();
        //print_r($user_interactions);
        $user_interaction = $method_info[0]->get_user_interaction();
        
    }
    if(isset($_POST['output_data_1'])) {
        $output_data_1 = $_POST['output_data_1'];
    } else {
        $output_data_1 = array();
    }
    $output_data_2 = null;
    if(isset($_POST['output_data_2'])) {
        $output_data_2 = $_POST['output_data_2'];
    }

    $new_ids = array();
    
    
    
    if($user_interaction == USER_INTERACTION_RIOS_CARDOSO) {
        $current_t3s = $tier2->get_tier3data();
        $current_t3_values = array();
        $selected_options = $_POST['select_option'];
        
        
        foreach($current_t3s as $t3) {
            $method_info_i = new method_info($db, $t3->get_methodinfoId());
            $method_info_name = $method_info_i->get_output_data_1();
            if($selected_options[$method_info_name][$t3->get_value()] == "on") {
                // Already exists; Do nothing
            } else {
                // Previously added, but no longer selected; Remove.
                tier3data::delete_tier3($db, $tier2id, $method_info_i->get_id());
            }
        }
        
        foreach($selected_options as $od1=>$sel_opt) {
            foreach($sel_opt as $selected_option_id=>$selected_option) {
                $found = false;
                if($selected_option != "Select an option") {
                    $selected_method_info = method_info::get_one_method_info($db, $tier2->get_methodid(), $od1);
                    foreach($current_t3s as $t3) {
                        if($t3->get_methodinfoid() == $selected_method_info->get_id() &&
                                $t3->get_value() == $selected_option_id) {
                            // Found; Do nothing
                            $found  = true;
                            
                        }
                    }
                    if($found == FALSE) {
                        // Not already found; add
                        $addresult = $this_case->add_tier3($method->get_id(),
                                    $od1,
                                    null,
                                    $tier2id,
                                    $selected_option_id,
                                    USER_INTERACTION_RIOS_CARDOSO);

                    }
                }
            }
        }
        
    }
    else if($user_interaction == USER_INTERACTION_MULTISELECT) {
    if($output_data_2 != null) {
    foreach($output_data_1 as $od1) {
        foreach($output_data_2 as $od2) {
            $method_info = method_info::get_one_method_info($db, $method->get_id(), $od1, $od2);
            $id = $method_info->get_id();
            $new_ids[] = $id;
        }
    }
    } else {
        foreach($output_data_1 as $od1) {
            $method_info = method_info::get_one_method_info($db, $method->get_id(), $od1);
            $id = $method_info->get_id();
            $new_ids[] = $id;
        }
    }
    
    // if it's in the existing ids, but not in the new ids, delete it.
    foreach($existing_ids as $existing_id) {
        if(!in_array($existing_id, $new_ids)) {
            tier3data::delete_tier3($db, $tier2id, $existing_id);
        }
    }
    
    // if it's in the new ids, but not in the existing ids, add it
    foreach($new_ids as $new_id) {
        if(!in_array($new_id, $existing_ids)) {
            $curr_result = $this_case->add_tier3_by_id($tier2id, $new_id);
            if($curr_result['RESULT'] == FALSE) {
                $errors++;
                $result[] = $curr_result;        
            }
        }
    }
    } else if($user_interaction == USER_INTERACTION_SELECT_RANGE) {
            // RANGE needs an output_data_1 and a value
            foreach($tier3s as $tier3) {
                // check existing tier3 data, to see if each submitted
                // value already exists there.
                $found = false;
                $method_info_id = $tier3->get_methodinfoid();
                $method_info = new method_info($db, $method_info_id);
                $od1 = $method_info->get_output_data_1();
                
                // first delete data that doesn't appear in new data
                foreach($output_data_1 as $name=>$values) {
                    $dbname = urldecode($name);
                    //echo("name, value = $dbname, $value<BR>");
                    
                    foreach($values as $value) {
                        if($od1 == $dbname &&
                           $tier3->get_value() == $value) {
                            // data is still here
                            $found = true;
                        }
                    }
                }
                if($found == false) {
                    // not in new data; delete this tier3
                    $curr_result = tier3data::delete_tier3_by_id($db, $tier3->get_id());
                    if($curr_result['RESULT'] == FALSE) {
                        $errors++;
                        $result[] = $curr_result;
                    }
            
                }
            
            }
            
            foreach($output_data_1 as $name=>$values) {
                // add new ones    
                $dbname = urldecode($name);
                $method_info_by_name = method_info::get_one_method_info($db, $method->get_id(), $dbname);
                echo("name = $dbname<BR>");
                $curr_method_info_id = $method_info_by_name->get_id();
                foreach($values as $value) {
                    $found = false;
                    foreach($tier3s as $tier3) {
                        
                        
                        $method_info_id = $tier3->get_methodinfoid();
                        $method_info = new method_info($db, $method_info_id);
                        $curr_od1 = $method_info->get_output_data_1();
                        $curr_value = $tier3->get_value();
                        
                        if($tier3->get_methodinfoid() == $curr_method_info_id &&
                           $tier3->get_value() == $value) {
                                $found = true;
                        }
                    }
                    
                    if($found == false) {
                        // add it
                        $curr_result = $this_case->add_tier3($tier2->get_methodid(), $dbname, null, $tier2id, $value);
                        if($curr_result['RESULT'] == FALSE) {
                            $errors++;
                            $result[] = $curr_result;        
                        }
                    }
                    }
                }
            
        } else if($user_interaction == USER_INTERACTION_INPUT_BOX ||
                $user_interaction == USER_INTERACTION_NUMERIC_ENTRY ||
                $user_interaction == USER_INTERACTION_SELECT_EACH ||
                $user_interaction == USER_INTERACTION_INPUT_BOX_WITH_DROPDOWN ||
                $user_interaction == USER_INTERACTION_TEXT_AREA) {

            $new_ids = array();

        //echo("user_interaction = $user_interaction<BR>");
        //print_r($output_data_1);
            foreach($output_data_1 as $name=>$od1_value) {
                $name = urldecode($name);
                if(is_array($od1_value)) {
                    foreach($od1_value as $od2) {
                        if($user_interaction == USER_INTERACTION_INPUT_BOX_WITH_DROPDOWN) {
                            $od2 = urldecode($od2);
                        }
                        $method_info = method_info::get_one_method_info($db, $method->get_id(), $name, $od2);

                        $id = $method_info->get_id();
                        $new_ids[] = $id;
                    }
                } else {
                    if($user_interaction == USER_INTERACTION_NUMERIC_ENTRY ||
                            $user_interaction == USER_INTERACTION_INPUT_BOX ||
                            $user_interaction == USER_INTERACTION_TEXT_AREA) {
                        // just use output_data_name for numeric entry
                        $method_info = method_info::get_one_method_info($db, $method->get_id(), $name);
                    } elseif($user_interaction == USER_INTERACTION_INPUT_BOX_WITH_DROPDOWN) {
                        $od2 = $output_data_2[urlencode($name)];
                            $method_info = method_info::get_one_method_info($db, $method->get_id(), $name, $od2);
                    }else {
                        $method_info = method_info::get_one_method_info($db, $method->get_id(), $name, $od1_value);
                    }
                    $id = $method_info->get_id();
                    $new_ids[] = $id;
                }
            }
        
        // if it's in the existing ids, but not in the new ids, delete it.

        foreach($existing_ids as $existing_id) {
            if(!in_array($existing_id, $new_ids)) {
                $curr_result = tier3data::delete_tier3($db, $tier2id, $existing_id);
                if($curr_result['RESULT'] == FALSE) {
                    $errors++;
                    $result[] = $curr_result;        
                }
            }
        }
    
        foreach($output_data_1 as $name=>$od1_value) {
            $name = urldecode($name);
            if(is_array($od1_value)) {
                foreach($od1_value as $od2) {
                    $method_info = method_info::get_one_method_info($db, $method->get_id(), $name, $od2);
                    $methoddataid = $method_info->get_id();
                    $this_case->update_tier3($tier2id, $methoddataid, $od2);
                }
            } else {
                if($user_interaction == USER_INTERACTION_NUMERIC_ENTRY ||
                   $user_interaction == USER_INTERACTION_INPUT_BOX ||
                   $user_interaction == USER_INTERACTION_TEXT_AREA) {
                    // just use output_data_name for numeric entry
                    $method_info = method_info::get_one_method_info($db, $method->get_id(), $name);
                } else if($user_interaction == USER_INTERACTION_INPUT_BOX_WITH_DROPDOWN) {
                    $od2 = $output_data_2[urlencode($name)];
                    $method_info = method_info::get_one_method_info($db, $method->get_id(), $name, $od2);
                }else {
                    $method_info = method_info::get_one_method_info($db, $method->get_id(), $name, $od1_value);
                }
                $methoddataid = $method_info->get_id();
                $curr_result = $this_case->update_tier3($tier2id, $methoddataid, $od1_value);
                if($curr_result['RESULT'] == FALSE) {
                    $errors++;
                    $result[] = $curr_result;        
                }
            }
        }
    } else if($user_interaction == USER_INTERACTION_3_COL_W_REF) {

        $caseid = $_POST['caseid'];
        $case = new sofa_case($db, $caseid);
        $tier2id = $_POST['tier2id'];
        $tier2 = new tier2data($db, $tier2id);
        $output_data_1 = $_POST['output_data_1'];
        
        
        $new_ids = array();
        
        foreach($output_data_1 as $od1=>$od2_data) {
            foreach($od2_data as $od2=>$od3) {
                $od2 = urldecode($od2);
                $od3 = $od3[0];
                if($od3 != null && $od3 != "") {
                    $method_info = $method->get_method_info_by_od1($od1, $od2, $od3);
                    if(count($method_info) == 1) {
                        $method_info = $method_info[0];
                    }
                    $new_id = $method_info->get_id();
                    $new_ids[] = $new_id;

                    $tier3data = $tier2->get_tier3data($method_info->get_id());
                    $tier3 = new tier3data($db, $tier3data['id']);

                    $newreflist = "";
                    $newrefs = $_POST['references'][$od1][urlencode($od2)];
                    foreach($newrefs as $id=>$status) {
                        if($status == "on") {
                            if($newreflist == "") {
                                $newreflist .= $id;
                            } else {
                                $newreflist .= ", ".$id;
                            }
                        }
                    }

                    if(!in_array($new_id, $existing_ids)) {
                        // add

                        $case->add_tier3($method->get_id(), $od1, $od2, $tier2id, $od3, $user_interaction, $newreflist);
                    } else {
                        // update

                        $case->update_tier3($tier2id, $method_info->get_id(), null, $newreflist);
                    }
                    foreach($existing_ids as $ex_id) {
                        if(!in_array($ex_id, $new_ids)) {

                            tier3data::delete_tier3($db, $tier2id, $ex_id);
                        }
                    }
                    
                    
                    
                }
            }
        }
        
    }
    echo("<div id='caseform'>");
    if($errors == 0) {
        echo("Method info updated successfully.");
    } else {
        foreach($result as $error_result) {
            echo($error_result['MESSAGE']. "<BR>");
        }
    }
    echo("</div>");
            
        
    
}
?>
  


  <div id="caseform">
  
   
  

	<div id="tabs">
  <ul>
    <li><a href="#tabs-1">Manage Case Methods</a></li>
 
  </ul>

	     <div id="tabs-1">
                 
                     <!-- Add Method box -->    
                     <?php 
                     echo('<form action="editmethods.php?id='.$caseeditid.'&tier2id='.$tier2->get_id().'" method="post" id="casedata">');
                     ?>
        <input type='hidden' id='caseid' name='caseid' value='<?php echo $caseeditid; ?>'>
        <input type='hidden' id='tier2id' name='tier2id' value='<?php echo $tier2id; ?>'>
    <fieldset class="methodinfobox"><legend class="boldlegend">Edit Methods</legend>

        <?php
        echo($method->get_name()."<BR>");
        if($method->get_method_info_type() == METHOD_INFO_TYPE_SPRADLEY_JANTZ) {
            //echo("Spradley/Jantz<BR>");
            //echo("tier2 id = ".$tier2->get_id());

            $result = $method->get_categories();
            
            echo("<input type=hidden id='method_id' name='method_id' value='$method_id'>");
            
            echo("<B><U>".$result[0]['output_data_3_description']."</U></B><BR>");
            echo("<select id='category' name='category[]' onchange='showBoneRegion(this.value)'>");
            echo("<option name='none'></option>");
            foreach($result as $category) {
                $name = $category['output_data_3'];
                echo("<option name='$name'>$name</option>");
            }
            echo("</select>");
            
            $tier3s = $tier2->get_tier3data();
            $tier3 = $tier3s[0];
            $method_info_id = $tier3->get_methodinfoid();
            $method_info = new method_info($db, $method_info_id);
            $category = $method_info->get_output_data_3();
            method_info::show_method_info_spradley_jantz($db, $method, $tier2->get_id(), $category);
        } else {
            method_info::show_method_info($db, $tier2->get_methodid(), $tier2->get_id());
        }
        ?>
             <div name="methodholder" id="methodholder">
             <p>
                            


     
     <input type="submit" class="showybutton" id="editmethoddatabutton" value="Save Edits" ><BR><BR>
                 
             <U><a href="index.php?id=<?php echo $caseeditid; ?>">Back to Case</a></U>
     

             </div>

          <input name="fchoseninput" type="hidden" id="fchoseninput" value="0" />
    <input name="pchoseninput" type="hidden" id="pchoseninput" value="0" />   
   
    
    </fieldset>
        </form>
    <!-- End Add Method box -->
    
                 <!-- Method data -->
   <div class="scroll" name="methodtableholder" id="methodtableholder">
             
            
             
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
                                   Method Data
                            </th>
                            </p>
                    </tr>
                    
                    <?php
                    $tier2s = $casedata->get_case_methods();
                    
                    
                    foreach($tier2s as $tier2) {
                        $method = new method($db, $tier2->get_methodid());
                        echo("<tr>
                            
                        <td><U><a href=editmethods.php?id=".$caseeditid."&tier2id=".$tier2->get_id().">Edit</A></U></td>");
                        
                        
                        echo '<td>
                            <form action="index.php" method="post" id="removedata" onsubmit="return confirm(\'Do you really want to remove this method from this case?\')">
                            <input name="delid" type="hidden" value="'.$tier2->get_id().'"/>
                            <input name="delsubmit" type="submit" value="Remove" /> </form>
                            </td>';
                        
                        echo("<td>". $method->get_method_type()."</td>
				<td>".$method->get_name()."</td>".
                                "<td>".$tier2->format_tier3data()."</td>".
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
    
<!--<br />	<br /> <label class="label" for="savecase">Click here to save case</label>
    <input name="savecase" id="savecase" type="submit" value="Save Case"/>-->
    
    
    </fieldset>
 
  </form>
    
    
    
<?php
    require_once("../../include/footer.php");
?>

