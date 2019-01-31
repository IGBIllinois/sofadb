<?php
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
	
	/*
	     unset($_SESSION['methodtype'][$data]);
		 unset($_SESSION['methodname'][$data]);
		 unset($_SESSION['methodfeature'][$data]);
    
	$_SESSION['num_methods']=$_SESSION['num_methods']-1;
	$_SESSION['methodtype']=array_values($_SESSION['methodtype']);
	$_SESSION['methodname']=array_values($_SESSION['methodname']);
    $_SESSION['methodfeature']=array_values($_SESSION['methodfeature']);
	
	include_once($_SERVER['DOCUMENT_ROOT'].'/mysqli_connect.php');
	$result = mysqli_query($dbcon,"SELECT methodname,id FROM methods WHERE methodtypenum='$mtype' Order by methodname ASC") 
	or die(mysql_error());
	
	$htmlout='<select name="drop_2" id="drop_2">
	      <option value="" disabled="disabled" selected="selected">Choose method</option>';
	
	
	

		   while($drop_2 = mysqli_fetch_assoc( $result )) 
			{
			$htmlout=$htmlout . '<option value="'.$drop_2['id'].'">'.$drop_2['methodname'].'</option>';
			}
	
	$htmlout=$htmlout.'</select>';
	 echo '<script type="text/javascript"> $(\'#result_1\').html($htmlout);$(\'#result_1\').show();</script>';
	*/
	
	
		
	
}//end edit row


//*****************
// Removing Method Data when deleting row
//*****************
if (isset($_GET['delrow']) && $_GET['delrow']==1) 
{
		
	
	$data   =   $_GET['delmethods'];
    $data   =    json_decode("$data",true);
	

	
	$num_deleted=intval($data[0]);
	
	
	
	
	
	
	
	for ($i=1;$i<=$num_deleted;$i++)
	{
		 
		 $meth_index=intval($data[$i])-1;
		 unset($_SESSION['methodtype'][$meth_index]);
		 unset($_SESSION['methodname'][$meth_index]);
		 unset($_SESSION['methodfeature'][$meth_index]);
		 unset($_SESSION['methodphase'][$meth_index]);
		 unset($_SESSION['featurechosen'][$meth_index]);
		 unset($_SESSION['phasechosen'][$meth_index]);
		 
	}
	

	
	$_SESSION['num_methods']=$_SESSION['num_methods']-$num_deleted;
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
	
	
	$_SESSION['num_methods']=$_SESSION['num_methods']+1;
	
		 
	
    unset($_GET['savecase']);	
	echo $_SESSION['num_methods'];
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
   
   
   
   $_SESSION['methodtype'][$_SESSION['num_methods']]=$_GET['drop_var'];
   
   $_SESSION['featurechosen'][$_SESSION['num_methods']]=0;
   $_SESSION['phasechosen'][$_SESSION['num_methods']]=0;
  
   
   drop_1($_GET['drop_var']); 
   
}

function drop_1($drop_var)
{  
    
	//include_once('db.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/mysqli_connect.php');
	$result = mysqli_query($dbcon,"SELECT methodname,id FROM methods WHERE methodtypenum='$drop_var' Order by methodname ASC") 
	or die(mysql_error());
	
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

		   while($drop_2 = mysqli_fetch_assoc( $result )) 
			{
			  echo '<option value="'.$drop_2['id'].'">'.$drop_2['methodname'].'</option>';
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
		func: \"drop_2\",
		drop_var: $('#drop_2').val()
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

function drop_2($drop_var)
{  
   include_once($_SERVER['DOCUMENT_ROOT'].'/mysqli_connect.php');
	
	
	$result = mysqli_query($dbcon,"SELECT name, id FROM feature INNER JOIN methodfeature ON featureid=feature.id WHERE  methodid='$drop_var' Order by name ASC") 
	or die(mysql_error());
	
	echo '<select name="drop_3" id="drop_3">
	      <option value="" disabled="disabled" selected="selected">Choose bone</option>';

		   while($drop_3 = mysqli_fetch_assoc( $result )) 
			{
			  echo '<option value="'.$drop_3['id'].'">'.$drop_3['name'].'</option>';
			}
	
	echo '</select>';
	echo "<script type=\"text/javascript\">
$('#wait_4').hide();
	$('#drop_3').change(function(){
	  $('#wait_3').show();
	  $('#result_3').hide();
	  $('#fchoseninput').val('1');
	$('#pchoseninput').val('0');
      $.get(\"func.php\", {
		func: \"drop_3\",
		drop_var: $('#drop_3').val(),
		}, function(response){
        $('#result_3').fadeOut();
        setTimeout(\"finishAjax_tier_four('result_3', '\"+escape(response)+\"')\", 400);
      });
    	return false;
	});
</script>";
	

}

if (isset($_GET['func']) && $_GET['func'] == "drop_3" ) { 
   
    $_SESSION['methodfeature'][$_SESSION['num_methods']]=$_GET['drop_var'];
	$_SESSION['featurechosen'][$_SESSION['num_methods']]=1;
   $_SESSION['phasechosen'][$_SESSION['num_methods']]=0;
   
   drop_3($_GET['drop_var']); 
}


function drop_3($drop_var)
{  
$methSID=$_SESSION['methodname'][$_SESSION['num_methods']];

   include_once($_SERVER['DOCUMENT_ROOT'].'/mysqli_connect.php');
	$result = mysqli_query($dbcon,"SELECT phasename, id FROM phase INNER JOIN methodphase ON phaseid=phase.id WHERE  methodid='$methSID' AND featureid='$drop_var' Order by phasename ASC") 
	or die(mysql_error());
	
	echo '<select name="drop_4" id="drop_4">
	      <option value="" disabled="disabled" selected="selected">Choose options</option>';

		   while($drop_4 = mysqli_fetch_assoc( $result )) 
			{
			  echo '<option value="'.$drop_4['id'].'">'.$drop_4['phasename'].'</option>';
			}
	
	echo '</select>';
	
	echo "<script type=\"text/javascript\">
$('#wait_4').hide();
	$('#drop_4').change(function(){
	  $('#wait_4').show();
	  $('#result_4').hide();
	  
	$('#pchoseninput').val('1');
      $.get(\"func.php\", {
		func: \"drop_4\",
		drop_var: $('#drop_4').val()
		}, function(response){
        $('#result_4').fadeOut();
        setTimeout(\"finishAjax_tier_four('result_4', '\"+escape(response)+\"')\", 400);
      });
    	return false;
	});
</script>";
	
	
}

if (isset($_GET['func']) && $_GET['func'] == "drop_4" ) { 
   
    $_SESSION['methodphase'][$_SESSION['num_methods']]=$_GET['drop_var'];
	

   $_SESSION['phasechosen'][$_SESSION['num_methods']]=1;
   
}


?>