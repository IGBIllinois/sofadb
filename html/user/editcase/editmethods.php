<?php 
require_once('../../include/header_user.php');
require_once('../../include/session_addcase.php') ;
require_once('func.php');

?>

<title>Edit Case Methods</title>


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

    if(isset($_POST['tier2id'])) {
        //$method_info = new method_info($db, $_GET['methodid']);
        $tier2id = $_POST['tier2id'];
        $tier2 = new tier2data($db, $_POST['tier2id']);
        $method = new method($db, $tier2->get_methodid());
        
    }
    
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
    if($user_interaction == USER_INTERACTION_MULTISELECT) {
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
            $this_case->add_tier3_by_id($tier2id, $new_id);
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
                    
                    foreach($values as $value) {
                        if($od1 == $name &&
                           $tier3->get_value() == $value) {
                            // data is still here
                            $found = true;
                        }
                    }
                }
                if($found == false) {
                    // not in new data; delete this tier3
                    tier3data::delete_tier3_by_id($db, $tier3->get_id());
                }
            
            }
            
            foreach($output_data_1 as $name=>$values) {
                // add new ones    
                $method_info_by_name = method_info::get_one_method_info($db, $method->get_id(), $name);
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
                        $this_case->add_tier3($tier2->get_methodid(), $name, null, $tier2id, $value);
                    }
                    }
                }
            
        } else if($user_interaction == USER_INTERACTION_INPUT_BOX ||
            $user_interaction == USER_INTERACTION_SELECT_EACH) {

            $new_ids = array();

        
            foreach($output_data_1 as $name=>$od1_value) {
                $name = urldecode($name);
                if(is_array($od1_value)) {
                    foreach($od1_value as $od2) {
                        $method_info = method_info::get_one_method_info($db, $method->get_id(), $name, $od2);

                        $id = $method_info->get_id();
                        $new_ids[] = $id;
                    }
                } else {
                    $method_info = method_info::get_one_method_info($db, $method->get_id(), $name, $od1_value);
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
    
        foreach($output_data_1 as $name=>$od1_value) {
            $name = urldecode($name);
            if(is_array($od1_value)) {
                foreach($od1_value as $od2) {
                    $method_info = method_info::get_one_method_info($db, $method->get_id(), $name, $od2);
                    $methoddataid = $method_info->get_id();
                    $this_case->update_tier3($tier2id, $methoddataid, $name, $od2);
                }
            } else {
                $method_info = method_info::get_one_method_info($db, $method->get_id(), $name, $od1_value);
                $methoddataid = $method_info->get_id();
                $this_case->update_tier3($tier2id, $methoddataid, $od1_value);
            }
        }
            }
            
        
    
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
            method_info::show_method_info($db, $tier2->get_methodid(), $tier2->get_id());
            
        ?>
             <div name="methodholder" id="methodholder">
             <p>
                            


     
     <input type="submit" class="showybutton" id="editmethoddatabutton" value="Edit Method Data" ><BR><BR>
                 
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
    
</div>
  






 </div>






<div id="footer">Copyright 2014 by <a href="http://www.sofainc.org/" target="_blank">SOFA</a>.</div>
</div>




</body>
</html>

