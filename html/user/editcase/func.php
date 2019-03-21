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
// Saving Method Data when adding row
//*****************
if(isset($_GET['savecase']) && $_GET['savecase']==1  ) 
{
	/*
	$method_id = $_GET['drop_2'];
        $output_data_1 = $_GET['od1'];
        $output_data_2 = array();
        if(isset($_GET['od2']) && $_GET['od2'] != null &&  $_GET['od2'] != "") {
            echo("od2!!!");
            $output_data_2 = $_GET['od2'];
        }

        $od1Names = isset($_GET['od1Names']) ? $_GET['od1Names'] : null;
        $caseid = $_GET['caseid'];
        
        $this_case = new sofa_case($db, $caseid);
        $method = new method($db, $method_id);
        $result = $this_case->add_case_method($method_id, $method->get_method_type_num(), 0, 127);
        
        if($result['RESULT'] == TRUE) {
            $method_case_id = $result['id'];
            $this_case->add_all_tier3_data($method_id, 
                    $method_case_id, 
                    $output_data_1, 
                    $output_data_2, 
                    $od1Names);
        }
         * 
         */
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
   
} else if(isset($_GET['func']) && $_GET['func'] == "show_method_info"  ) { 
    
    $method_id = $_GET['method_id'];
    method_info::show_method_info($db, $method_id);
    
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
		func: \"show_method_info\",
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

