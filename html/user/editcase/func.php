<?php

if(file_exists('../../../include/main.inc.php')) {
require_once('../../../include/main.inc.php');
} else if('../../include/main.inc.php') {
    require_once('../../include/main.inc.php');
}


if(!isset($_SESSION)){
session_start();
if(!isset($_SESSION['loggedin']))
{header('Location: ' . '../../index.php');
exit();
}
 if(!isset($_SESSION['num_methods']))
 { $_SESSION['num_methods']=0;}}
 ob_start();


//***********
//Filling in dropboxes when editing a method. Doesn't work yet!
//
if (isset($_GET['editrow']) && $_GET['editrow']!=0 && $_GET['delmethods']>=1) 
{
	
	$data=$_GET['delmethods']-1;
	if ($_GET['editrow']==1){
	
	$mout=$_SESSION['methodtype'][$data];}
	elseif ($_GET['editrow']==2)
	{
	$mout=$_SESSION['methodname'][$data];
	
	}
	
	//$mfeat=$_SESSION['methodfeature'][$data];
	
	
	unset($_GET['editrow']);
	unset($_GET['delmethods']);	 
		
		echo $mout;

}//end edit row


//*****************
// Removing Method Data when deleting row
//*****************
if (isset($_GET['delrow']) && $_GET['delrow']==1) 
{
			
	$data   =   $_GET['delmethods'];
    $data   =    json_decode("$data",true);
	
	$num_deleted=intval($data[0]);

        $_SESSION["1"] = 1;
	for ($i=1;$i<=$num_deleted;$i++)
	{
            
            $meth_index=intval($data[$i])-1;
            $_SESSION['HELP'.$meth_index] = "HELP".$meth_index;
            echo("methindex = $meth_index<BR>");
            $t2id = $_SESSION['t2id'][$meth_index];
            $_SESSION['HELP-t2id'.$t2id] = "HELP-t2id".$t2id;
            echo("t2id = $t2id<BR>");
            $caseid = $_SESSION['caseid'];
            if($t2id > 0) {
                if(isset($_SESSION['methodtabletype'][$meth_index]) && $_SESSION['methodtabletype'][$meth_index] == "Age") {
                    $_SESSION['IAMHERE0'.$t2id] = "IAMHERE:".$t2id;
                    $tmpcase = new sofa_case($db, $caseid);
                    $_SESSION['IAMHERE1'.$t2id] = "IAMHERE:".$caseid;
                    $tmpcase->remove_method_age($t2id);
                    $_SESSION['IAMHERE'.$t2id] = "IAMHERE:".$t2id;
                }
            }
		 
                 
		 unset($_SESSION['t2id'][$meth_index]);
                 unset($_SESSION['methoddata'][$meth_index]);
		 unset($_SESSION['methodtype'][$meth_index]);
		 unset($_SESSION['methodname'][$meth_index]);
		 unset($_SESSION['methodfeature'][$meth_index]);
		 unset($_SESSION['methodphase'][$meth_index]);
		 unset($_SESSION['featurechosen'][$meth_index]);
		 unset($_SESSION['phasechosen'][$meth_index]);
		 
	}
        
	

	
	$_SESSION['num_methods']=$_SESSION['num_methods']-$num_deleted;
        $_SESSION['t2id']=array_values($_SESSION['t2id']);
	$_SESSION['methodtype']=array_values($_SESSION['methodtype']);
	$_SESSION['methodname']=array_values($_SESSION['methodname']);
    $_SESSION['methodfeature']=array_values($_SESSION['methodfeature']);
	$_SESSION['methodphase']=array_values($_SESSION['methodphase']);
	$_SESSION['featurechosen']=array_values($_SESSION['featurechosen']);
	$_SESSION['phasechosen']=array_values($_SESSION['phasechosen']);
	
	
	
unset($_GET['delmethods']);	
unset($_GET['delrow']);

}









//*****************
// Saving Method Data when adding row
//*****************
if(isset($_GET['savecase']) && $_GET['savecase']==1  ) 
{
	
	$method_id = $_GET['drop_2'];
        $output_data_1 = $_GET['od1'];
        $output_data_2 = $_GET['od2'];
        $caseid = $_GET['caseid'];
        
        $this_case = new sofa_case($db, $caseid);
        $method = new method($db, $method_id);
        $result = $this_case->add_case_method($method_id, $method->get_method_type_num(), 0, 127);
        
        if($result['RESULT'] == TRUE) {
            $method_case_id = $result['id'];
            // This echo command is what the javascript uses for its output response
            echo($method_case_id);
            foreach($output_data_1 as $od1) {
                foreach($output_data_2 as $od2) {
                    $result = $this_case->add_tier3_age($method_id, $od1, $od2, $method_case_id);

                }
            }
        }
        
        //header ("location: ../index.php"); exit();
        
/*
        $index = $_SESSION['num_methods'];
	$_SESSION['num_methods']=$_SESSION['num_methods']+1;
        
	$_SESSION['methoddata'][$index][$drop_2]['od1'] = $_GET['od1'];
        $_SESSION['methoddata'][$index][$drop_2]['od2'] = $_GET['od2'];
        $my_methoddata['methoddata'][$drop_2] = array($_GET['od1'], $_GET['sex']);
        

    unset($_GET['savecase']);	
 * 
 */
	//echo $_SESSION['num_methods'];
}




//**************************************
//     Page load dropdown results     //
//**************************************

$methoddata=array("methodtype"=>"");


function getTierOne()
{
	$result = mysql_query("SELECT DISTINCT tier_one FROM three_drops") 
	or die(mysql_error());

	  while($tier = mysql_fetch_array( $result )) 
  
		{
		   echo '<option value="'.$tier['tier_one'].'">'.$tier['tier_one'].'</option>';
		}

}

//**************************************
//     First selection results     //
//**************************************
if(isset($_GET['func']) && $_GET['func'] == "drop_1"  ) { 
   
   $methoddata['methodtype']=$_GET['drop_var'];
   
   // new one
   $_SESSION['t2id'][$_SESSION['num_methods']] = -1;
   
   $_SESSION['methodtype'][$_SESSION['num_methods']]=$_GET['drop_var'];
   
   $_SESSION['featurechosen'][$_SESSION['num_methods']]=0;
   $_SESSION['phasechosen'][$_SESSION['num_methods']]=0;
  
   
   drop_1($_GET['drop_var']); 
   
} else if(isset($_GET['func']) && $_GET['func'] == "show_age_method_info"  ) { 
    
    $method_id = $_GET['method_id'];
    show_age_method_info($method_id);
    
}
   

function drop_1($drop_var)
{  
    global $db;
	//include_once('db.php');
	//include_once($_SERVER['DOCUMENT_ROOT'].'/mysqli_connect.php');
	//$result = mysqli_query($dbcon,"SELECT methodname,id FROM methods WHERE methodtypenum='$drop_var' Order by methodname ASC") 
	//or die(mysql_error());
        $methods = method::get_methods_by_type($db,$drop_var);
	
	echo '<script type=\"text/javascript\">
	 $(function(){
	//$("#drop_X").multiselect();
	
	$("#drop_X").multiselect({
   multiple: false,
   header: "Select an option",
   noneSelectedText: "Select an Option",
   selectedList: 1
});
	
	
});</script>
  ';
	
	echo '<select name="drop_2" id="drop_2">
	      <option value="" disabled="disabled" selected="selected">Choose method</option>';


                foreach($methods as $method) {
                    echo '<option value="'.$method->get_id().'">'.$method->get_name().'</option>';
                }
	
	echo '</select>';
	
	echo "<script type=\"text/javascript\">
$('#wait_2').hide();
	$('#drop_2').change(function(){
	  $('#wait_2').show();
	  $('#result_2').hide();
	  $('#wait_3').hide();
	$('#result_3').hide();
	$('#drop_3').hide();
	$('#drop_4').hide();
	$('#fchoseninput').val('0');
	$('#pchoseninput').val('0');
      $.get(\"func.php\", {
		func: \"show_age_method_info\",
		method_id: $('#drop_2').val()
      }, function(response){
        $('#result_2').fadeOut();
        setTimeout(\"finishAjax_tier_three('result_2', '\"+escape(response)+\"')\", 400);
      });
    	return false;
	});
</script>";
}


//**************************************
//     Second selection results     //
//**************************************
if (isset($_GET['func']) && $_GET['func'] == "drop_2" ) { 


 $_SESSION['methodname'][$_SESSION['num_methods']]=$_GET['drop_var'];
 $_SESSION['featurechosen'][$_SESSION['num_methods']]=0;
   $_SESSION['phasechosen'][$_SESSION['num_methods']]=0;
 
  
}


function show_age_method_info($method_id) {

     $_SESSION['methodname'][$_SESSION['num_methods']]=$method_id;
 $_SESSION['featurechosen'][$_SESSION['num_methods']]=0;
   $_SESSION['phasechosen'][$_SESSION['num_methods']]=0;
   
    global $db;
    require_once("../../include/main.inc.php");
    echo("<BR>");
    $query = "SELECT * from age_method_info where methodid = :method_id";
    $output_data_1_query = "SELECT DISTINCT output_data_1 from age_method_info where methodid = :method_id";
    $output_data_2_query = "SELECT DISTINCT output_data_2 from age_method_info where methodid = :method_id";
    
    $params = array("method_id"=>$method_id);
    
    $output_data_1_result = $db->get_query_result($output_data_1_query, $params);
    $output_data_2_result = $db->get_query_result($output_data_2_query, $params);
    $all_result = $db->get_query_result($query, $params);
    echo("<table><tr><th>Phase/Stage</th><th>Reference Sample</th></tr><tr><td>");
    echo("<select id='output_data_1' style='width:200px;' multiple name=output_data_1[]>");
    foreach($output_data_1_result as $od1_result) {
        echo("<option value='".$od1_result['output_data_1']."'>".$od1_result['output_data_1']."</option>");
        
    }
    echo("</select>");
    echo("</td><td>");
    echo("<select id='output_data_2' style='width:200px;' multiple name=output_data_2[]>");
    foreach($output_data_2_result as $od2_option) {
        echo("<option value='".$od2_option['output_data_2']."'>".$od2_option['output_data_2']."</option>");
        
    }
    echo("</select>");
    echo("</td></tr></table>");
    

}