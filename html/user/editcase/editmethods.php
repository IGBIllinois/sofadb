<?php 
require_once('../../include/header_user.php');
require_once('../../include/session.inc.php') ;
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
        $existing_ids[] = $t3->get_method_info_option_id();
    }

    $method = new method($db, $tier2->get_methodid());
    $method_info = $method->get_method_info();
    $user_interaction = "";
    $user_interactions = array();
    

    $output_data = $_POST['output_data'];

    $new_ids = array();
    
    foreach($output_data as $od) {
        if(is_array($od)) {

            foreach($od as $id=>$value) {
                $new_ids[] = $id;
                if($id != null && $id != '') {

                    tier3data::delete_tier3($db, $tier2id, $id);
                    $casedata->add_tier3($tier2id, $id, $value);
                }
            }
        }
        else {
            if($od != null && $od != '') {
                $new_ids[] = $od;
            }
        }
        
    }

    
    foreach($new_ids as $new_id) {
        if(!in_array($new_id, $existing_ids)) {
            $casedata->add_tier3($tier2id, $new_id);
        }
    }
    
    foreach($existing_ids as $ex_id) {
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
    
    if($_POST['references'] != null) {
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
            
        }
        
        if($_POST['check_select'] != null) {
            // used for checkbox arrays, like Rios & Cardoso
            echo("t2id = $t2id<BR>");
            $check_select = $_POST['check_select'];
            foreach($check_select as $method_info_id=>$option_list) {
                foreach($option_list as $option_id=>$option_name) {
                    if($option_id > 0) {                
                        $this_case->add_tier3($tier2id, $option_id);
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


            method_infos::show_method_info($db, $tier2->get_methodid(), $tier2->get_id());
        
        ?>
             <div name="methodholder" id="methodholder">
             <p>
                            


     
     <input type="submit" class="showybutton" id="editmethoddatabutton" value="Save Edits" ><BR><BR>
                 
             <U><a href="index.php?id=<?php echo $caseeditid; ?>#tabs-2">Back to Case</a></U>
     

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
                                   Method Outcomes
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
    
    
    
<?php
    require_once("../../include/footer.php");
?>

