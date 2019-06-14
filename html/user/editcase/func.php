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


//**************************************
//     Page load dropdown results     //
//**************************************

$methoddata=array("methodtype"=>"");




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
  
   
   functions::drop_1($_GET['drop_var']); 
   
   
} else if(isset($_GET['func']) && $_GET['func'] == "show_method_info"  ) { 

    $method_id = $_GET['method_id'];
    method_info::show_method_info($db, $method_id);
    
}  else if(isset($_GET['func']) && $_GET['func'] == "spradley_jantz"  ) { 

    $category = $_GET['category'];
    $method_id = $_GET['method_id'];

    $method = new method($db, $method_id);
    method_info::show_method_info_spradley_jantz($db, $method, null, $category);
    
} 
   




//**************************************
//     Second selection results     //
//**************************************
if (isset($_GET['func']) && $_GET['func'] == "drop_2" ) { 


 $_SESSION['methodname'][$_SESSION['num_methods']]=$_GET['drop_var'];
 $_SESSION['featurechosen'][$_SESSION['num_methods']]=0;
   $_SESSION['phasechosen'][$_SESSION['num_methods']]=0;
 
  
}

