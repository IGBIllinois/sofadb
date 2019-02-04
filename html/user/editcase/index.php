<?php 
require_once('../../include/header_user.php');
require_once('../../include/session_addcase.php') ;
require_once('func.php');

?>

<title>Edit Case Information</title>


  <h1 class="cntr">Edit Case Information</h1>




  <?php


if(isset($_GET['id'])) 
{
    $caseeditid=$_GET['id'];
    $_SESSION['caseid']=$caseeditid;
    unset($_GET['id']);
    $q="SELECT * FROM cases WHERE id=$caseeditid";

    $mresult=mysqli_query($dbcon,$q);
    if(!$mresult)
    {echo 'Could not load user data from database';exit();}

    $casedata=mysqli_fetch_array($mresult);

}

elseif(!isset($_SESSION['caseid']))
{ 
    header ("location: ../index.php"); exit();
}

elseif(isset($_SESSION['caseid']))
{
	$caseeditid=$_SESSION['caseid'];
	$q="SELECT * FROM cases WHERE id=$caseeditid";

$mresult=mysqli_query($dbcon,$q);
if(!$mresult)
{echo 'Could not load case data from database';exit();}

$casedata=mysqli_fetch_array($mresult);
	
	}
	
if(!isset($_SESSION['loadedmethods']))
	{//Extract methods data
	$_SESSION['loadedmethods']=1;
 $_SESSION['num_methods']=$casedata['nummethods'];
 $q="SELECT methods.id as mid, methods.methodname as mname, methods.methodtype as mtype, methods.methodtypenum as mtypenum, feature.id as fid, feature.name as fname, phase.id as pid, phase.phasename as pname FROM tier2data t2 INNER JOIN methods ON t2.methodid=methods.id INNER JOIN feature ON t2.featureid=feature.id  INNER JOIN phase ON t2.phaseid=phase.id WHERE t2.caseid=$caseeditid";
 
 
 
 $methresult=mysqli_query($dbcon,$q);
 if(!$methresult)
 {echo 'Could not load method data from database';exit();}	

for ($i=1;$i<=$_SESSION['num_methods'];$i++)
{
	$methodX=mysqli_fetch_assoc($methresult);
	$_SESSION['methodtype'][$i-1]=$methodX['mtypenum'];
	
	$_SESSION['methodname'][$i-1]=$methodX['mid'];
	$_SESSION['methodfeature'][$i-1]=$methodX['fid'];
	$_SESSION['methodphase'][$i-1]=$methodX['pid'];
	$_SESSION['methodtabletype'][$i-1]=$methodX['mtype'];
	$_SESSION['methodtablename'][$i-1]=$methodX['mname'];
	$_SESSION['methodtablefeature'][$i-1]=$methodX['fname'];
	$_SESSION['methodtablephase'][$i-1]=$methodX['pname'];
	
	if ($methodX['fid']>1){
	$_SESSION['featurechosen'][$i-1]=1;}
	else {$_SESSION['featurechosen'][$i-1]=0;}
	
	if ($methodX['pid']!=127){
	$_SESSION['phasechosen'][$i-1]=1;}
	else {$_SESSION['phasechosen'][$i-1]=0;}
	
}
	}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$errors = array(); // Start an array to hold the errors
	
	// Check for a casename:
	if (empty($_POST['caseyear'])) {
		$errors[] = 'You must enter a case year to save.';
	} 
    else {
			$caseyear = mysqli_real_escape_string($dbcon, trim($_POST['caseyear']));
	}

	// Check for a casenumber:
	if (empty($_POST['casenumber'])) {
		$errors[] = 'You must enter a case number to save.';
	} 
    else {
		$casenum = mysqli_real_escape_string($dbcon, trim($_POST['casenumber']));
	}
	// Check for a casename:
	if (!empty($_POST['casename'])) {
			$casenam = mysqli_real_escape_string($dbcon, trim($_POST['casename']));
	} 
    else {
	$casenam=NULL;	
	}
    
    
	// Check for a case agency:
	if (empty($_POST['caseagency'])) {
		$caseag=NULL;
        
	} 
    else {
		$caseag = mysqli_real_escape_string($dbcon, trim($_POST['caseagency']));
	}
	
    // Check for a FA sex
    if (empty($_POST['fasex'])) {
		$fasex=NULL;
	} 
    else {
		$fasex = mysqli_real_escape_string($dbcon, trim($_POST['fasex']));
	}
	
	
    
       	//check for a FA age 2 first!
	if (empty($_POST['faage2'])) {
		$faage2=NULL;
        $faageunits2=NULL;
	} 
    else {
		$faage2 = trim($_POST['faage2']);
        $faageunits2 = mysqli_real_escape_string($dbcon, trim($_POST['faageunits2']));
	}
    
    
    //check for a FA age 1
	if (empty($_POST['faage'])) {
		$faage=NULL;
        $faageunits=NULL;
        $faage2=NULL;
        $faageunits2=NULL;
	} 
    else {
		$faage = trim($_POST['faage']);
        $faageunits = mysqli_real_escape_string($dbcon, trim($_POST['faageunits']));
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
		$fastature = trim($_POST['fastature']);
       // $fastatureunits = mysqli_real_escape_string($dbcon, trim($_POST['fastatureunits']));
	}


  // Check for a id sex
    if (empty($_POST['idsex'])) {
		$idsex=NULL;
	} 
    else {
		$idsex = mysqli_real_escape_string($dbcon, trim($_POST['idsex']));
	}


  //check for a id age 
	if (empty($_POST['idage'])) {
		$idage=NULL;
        $idageunits=NULL;
        
	} 
    else {
		$idage = trim($_POST['idage']);
        $idageunits = mysqli_real_escape_string($dbcon, trim($_POST['idageunits']));
	}



	//check for a id stature
	if (empty($_POST['idstature'])) {
		$idstature=NULL;
        $idstatureunits=NULL;
	} 
    else {
		$idstature = trim($_POST['idstature']);
      //  $idstatureunits = mysqli_real_escape_string($dbcon, trim($_POST['idstatureunits']));
	}
   
   
   //check for a id source
	if (empty($_POST['idsource'])) {
		$idsource=NULL;
        
	} 
    else {
		
        $idsource = mysqli_real_escape_string($dbcon, trim($_POST['idsource']));
	}
	
	
		 //check for a extra race/ethnicity info 
	if (empty($_POST['idancaddtext'])) {
		$idancaddtext=NULL;
        
	} 
    else {
		
        $idancaddtext = mysqli_real_escape_string($dbcon, trim($_POST['idancaddtext']));
	}
    
    //check for a  casenotes
	if (empty($_POST['casenotes'])) {
		$casenotes=NULL;
        
	} 
    else {
		
        $casenotes = mysqli_real_escape_string($dbcon, trim($_POST['casenotes']));
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
		
        $faothertext = mysqli_real_escape_string($dbcon, trim($_POST['farace_othertext']));
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
        $idothertext = mysqli_real_escape_string($dbcon, trim($_POST['idrace_othertext']));
	
	}
    
    if(($idOt==0 && $idothertext)||($idOt==1 && !$idothertext))
	{$errors[] = 'You must Check the Other box and enter text.';}
    
     if (isset($_SESSION['num_methods']))
    {
    $numcasemethods=$_SESSION['num_methods'];
    
    
    }
    else{ $numcasemethods=0;}
	
	
    
    
		if (empty($errors)) 
        { // If there were no errors
		//Determine whether the case has already been registered	
		$memberid=$_SESSION['id'];

      $caseeditid=$_SESSION['caseid'];
		$q = "SELECT id FROM cases WHERE memberid='$memberid' AND caseyear='$caseyear' AND casenumber='$casenum' AND id!='$caseeditid'";
		$result=mysqli_query ($dbcon, $q) ; 	
			
            if (mysqli_num_rows($result) == 0)
            {//The case has not been registered already 
		// Make the query:
		
        	$q = "UPDATE cases SET casename='$casenam',caseyear='$caseyear',casenumber='$casenum',caseagency='$caseag',fasex='$fasex',faage='$faage',faage2='$faage2',faageunits='$faageunits', faageunits2='$faageunits2',fastature='$fastature',fastature2='$fastature2',fastatureunits='$fastatureunits',idsex='$idsex',idage='$idage',idageunits='$idageunits',idsource='$idsource',idstature='$idstature',idstatureunits='$idstatureunits',casenotes='$casenotes',datemodified=NOW(),faancestryas='$faAs',faancestryeuro='$faWh',faancestryaf='$faBl',faancestryna='$faNa',faancestryhi='$faHi',faancestryot='$faOt',faancestryottext='$faothertext',idraceas='$idAs',idraceaf='$idBl',idracewh='$idWh',idracehi='$idHi',idracena='$idNa',idraceot='$idOt',idraceottext='$idothertext',idancaddtext='$idancaddtext',nummethods='$numcasemethods' WHERE id='$caseeditid'";
				
			$result = @mysqli_query ($dbcon, $q); // Run the query.
		$inid=mysqli_insert_id($dbcon);
     
        		if (!$result) 
                { // If it ran OK.
                // If it did not run OK
				// Error message:
				echo '<h2>System Error</h2>
				<p class="error">Registration failed because of a system error. We apologize for any inconvenience.</p>'; 
				// Debugging message:
				echo '<p>' . mysqli_error($dbcon) . '<br/><br/>Query: ' . $q . '</p>';
                exit();
                }
                
         
		 $q="DELETE FROM tier2data WHERE caseid=$caseeditid";
		 $result3=mysqli_query($dbcon,$q);
		  if (!$result3) 
                { // If it ran OK.
                // If it did not run OK
				// Error message:
				echo '<h2>System Error</h2>
				<p class="error">Did not properly remove/attach methods to case. We apologize for any inconvenience.</p>'; 
				// Debugging message:
				echo '<p>' . mysqli_error($dbcon) . '<br/><br/>Query: ' . $q . '</p>';
                exit();
                }
		 
		 
		 for ($i=1;$i<=$numcasemethods;$i++){
                
                $methodidsave=$_SESSION['methodname'][$i-1];
              
                $methodtypesave=$_SESSION['methodtype'][$i-1];
				
                
				if($_SESSION['featurechosen'][$i-1]==1){
				$methodfeatsave=$_SESSION['methodfeature'][$i-1];}
				else $methodfeatsave=1;
				
	if($_SESSION['phasechosen'][$i-1]==1){
				$methodphasesave=$_SESSION['methodphase'][$i-1];}
				else $methodphasesave=127;
				
                
                 $q="INSERT INTO tier2data (id,memberid,caseid,methodtype,methodid,featureid,phaseid) VALUES (' ','$memberid','$caseeditid','$methodtypesave','$methodidsave','$methodfeatsave','$methodphasesave')";
                 $result4 = mysqli_query($dbcon,$q);
                  if (!$result4) 
                { // If it ran OK.
                // If it did not run OK
				// Error message:
				echo '<h2>System Error</h2>
				<p class="error">Did not attach methods to case. We apologize for any inconvenience.</p>'; 
				// Debugging message:
				echo '<p>' . mysqli_error($dbcon) . '<br/><br/>Query: ' . $q . '</p>';
                exit();
                }
                 
                 
                 
                 
                 }
                 
                 
                
                 
                 
                 
                unset($_SESSION['loadedmethods']);
       			unset($_SESSION['num_methods']);
                unset($_SESSION['methodtype']);
                unset($_SESSION['methodname']);
                unset($_SESSION['methodfeature']);
				unset($_SESSION['methodphase']);
       		    unset($_SESSION['phasechosen']);
				unset($_SESSION['featurechosen']);
        		 
       
       			unset($_SESSION['caseid']); 
                header ("location: ../index.php"); exit();
				
                 
       	   mysqli_close($dbcon); // Close the database connection
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
?>
  



  <div id="caseform">
  
   
  
    <form action="index.php" method="post" id="casedata">
	
	<div id="tabs">
  <ul>
    <li><a href="#tabs-1">General Case Information</a></li>
    <li><a href="#tabs-2">Manage Case Methods</a></li>
 
  </ul>
<div id="tabs-1">
    
    
  <fieldset class="enclosefieldset">
    
    
  <fieldset class="caseinfobox"><legend class="boldlegend">General Case Information</legend>
    
     <label class="label" for="caseyear">Case Year</label><input id="caseyear" type="text" name="caseyear" size="5" maxlength="4" value="<?php if (isset($casedata['caseyear'])) echo $casedata['caseyear']; ?>"/>
  <br />
    
  <label class="label" for="casenumber">Case Number</label><input id="casenumber" type="text" name="casenumber" size="30" maxlength="30" value="<?php if (isset($casedata['casenumber'])) echo $casedata['casenumber']; ?>"/>
  <br />
    
  <label class="label" for="caseagency">Case Agency</label><input id="caseagency" type="text" name="caseagency" size="30" maxlength="30" value="<?php if (isset($casedata['caseagency'])) echo $casedata['caseagency']; ?>"/>
      
  <br/>
    <span name="savebutton" class="bigsavebutton">
    <input name="savecase" type="image" id="savecase" src="../../images/bigsave.png" alt="Save Case" width="90"/></span>
  </fieldset>
    
  <fieldset class="caseinfobox"><legend class="boldlegend"> Biological Profile: Forensic Anthropology Case Estimation</legend>
    
    
  <label class="label" for="fasex">Sex</label>
  <select name="fasex">
    <option value="">- Select -</option>
    <option value="Female"<?php if (isset($casedata['fasex']) AND ($casedata['fasex'] == 'Female')) echo ' selected="selected"'; ?>>Female</option>
    <option value="Probable Female"<?php if (isset($casedata['fasex']) AND ($casedata['fasex'] == 'Probable Female')) echo ' selected="selected"'; ?>>Probable Female</option>
    <option value="Indeterminate"<?php if (isset($casedata['fasex']) AND ($casedata['fasex'] == 'Indeterminate')) echo ' selected="selected"'; ?>>Indeterminate</option>
    <option value="Probable Male"<?php if (isset($casedata['fasex']) AND ($casedata['fasex'] == 'Probable Male')) echo ' selected="selected"'; ?>>Probable Male</option>
    <option value="Male"<?php if (isset($casedata['fasex']) AND ($casedata['fasex'] == 'Male')) echo ' selected="selected"'; ?>>Male</option>
    </select>
    
    
    
    <br/><label class="label" for="faage">Age</label><input id="faage" type="text" name="faage" size="5" maxlength="5" value="<?php if (isset($casedata['faage'])) echo $casedata['faage']; ?>"/>
    
    <select name="faageunits">
      <option value="years">years</option>
      <option value="months"<?php if (isset($casedata['faageunits']) AND ($casedata['faageunits'] == 'months')) echo ' selected="selected"'; ?>>months</option>
      <option value="fetalmonths"<?php if (isset($casedata['faageunits']) AND ($casedata['faageunits'] == 'fetalmonths')) echo ' selected="selected"'; ?>>fetal months</option>
      </select>&nbsp; to &nbsp;
    
    <input id="faage2" type="text" name="faage2" size="5" maxlength="5" value="<?php if (isset($casedata['faage2'])) echo $casedata['faage2']; ?>"/>
    
    <select name="faageunits2">
      <option value="years">years</option>
      <option value="months"<?php if (isset($casedata['faageunits2']) AND ($casedata['faageunits2'] == 'months')) echo ' selected="selected"'; ?>>months</option>
      <option value="fetalmonths"<?php if (isset($casedata['faageunits2']) AND ($casedata['faageunits2'] == 'fetalmonths')) echo ' selected="selected"'; ?>>fetal months</option>
      </select>
    
    
    
    <br/><label class="label" for="faancestry">Ancestry</label><input id="farace_othertext" type="text" name="farace_othertext" size="30" maxlength="100" value="<?php if (isset($casedata['faancestryottext'])) echo $casedata['faancestryottext']; ?>"/>
    
    
    
    <br/><label class="label" for="fastature">Stature</label><input id="fastature" type="text" name="fastature" size="6" maxlength="8" value="<?php if (isset($casedata['fastature'])) echo $casedata['fastature']; ?>"/>  &nbsp; to &nbsp;
    
    <input id="fastature2" type="text" name="fastature2" size="6" maxlength="8" value="<?php if (isset($casedata['fastature2'])) echo $casedata['fastature2']; ?>"/>  <select name="fastatureunits" disabled>
      <option value="in">inches</option>
      </select>
    
    
    </fieldset>
    
    <fieldset class="caseinfobox"><legend class="boldlegend">Biological Profile: Actual Identified Information</legend>
      
      <label class="label" for="idsex">Sex</label>
      <select name="idsex">
        <option value="">- Select -</option>
        <option value="Female"<?php if (isset($casedata['idsex']) AND ($casedata['idsex'] == 'Female')) echo ' selected="selected"'; ?>>Female</option>
        <option value="Male"<?php if (isset($casedata['idsex']) AND ($casedata['idsex'] == 'Male')) echo ' selected="selected"'; ?>>Male</option>
        </select>
      
      
      <br/><label class="label" for="idage">Age</label><input id="idage" type="text" name="idage" size="5" maxlength="5" value="<?php if (isset($casedata['idage'])) echo $casedata['idage']; ?>"/>
      <select name="idageunits">
        <option value="years">years</option>
        <option value="months"<?php if (isset($casedata['idageunits']) AND ($casedata['idageunits'] == 'months')) echo ' selected="selected"'; ?>>months</option>
        <option value="fmonths"<?php if (isset($casedata['idageunits']) AND ($casedata['idageunits'] == 'fmonths')) echo ' selected="selected"'; ?>>fetal months</option>
        </select> 
      
      
      
      
      
      <br/><label class="label" for="idrace">Race/Ethnicity</label>
      <input type="checkbox" name="race_asian" value="1" <?php if (isset($casedata['idraceas']) AND $casedata['idraceas'] == 1) echo ' checked'; ?>/>Asian/Pacific Islander
      <input type="checkbox" name="race_black" value="1" <?php if (isset($casedata['idraceaf'])  AND $casedata['idraceaf'] == 1) echo ' checked'; ?>/>Black/African-American
      <input type="checkbox" name="race_hispanic" value="1" <?php if (isset($casedata['idracehi']) AND $casedata['idracehi'] == 1) echo ' checked'; ?>/>Hispanic<br />
      <label class="label" for="idrace2"></label>
      <input type="checkbox" name="race_native" value="1" <?php if (isset($casedata['idracena']) AND $casedata['idracena'] == 1) echo ' checked'; ?>/>Native American
      <input type="checkbox" name="race_white" value="1" <?php if (isset($casedata['idracewh']) AND $casedata['idracewh'] == 1) echo ' checked'; ?>/>White
      <input type="checkbox" name="race_other" value="1" <?php if (isset($casedata['idraceot']) AND $casedata['idraceot'] == 1) echo ' checked'; ?> />Other: &nbsp; <input id="idrace_othertext" type="text" name="idrace_othertext" size="18" maxlength="30" value="<?php if (isset($casedata['idraceottext'])) echo $casedata['idraceottext']; ?>"/>
       <br /><label class="label" for="idancaddtext">Race/Ethnicity Notes</label><input id="idancaddtext" type="text" name="idancaddtext" size="30" maxlength="300" value="<?php if (isset($casedata['idancaddtext'])) echo $casedata['idancaddtext']; ?>" /><br>
      
      
      <br/><label class="label" for="idstature">Stature</label><input id="idstature" type="text" name="idstature" size="6" maxlength="8" value="<?php if (isset($casedata['idstature'])) echo $casedata['idstature']; ?>" />
      
      <select name="idstatureunits" disabled>
        <option value="in">inches</option>
        </select>
      
      <br />
      
      <br/><label class="label" for="idsource">Information Source</label><input id="idsource" type="text" name="idsource" size="30" maxlength="60" value="<?php if (isset($casedata['idsource'])) echo $casedata['idsource']; ?>" /><br />
      
  </fieldset>
    <fieldset class="caseinfobox"><legend class="boldlegend">Case Notes</legend>
      <label class="label" for="casenotes"></label>
      <textarea name="casenotes" cols="55" rows="7"><?php if (isset($casedata['casenotes'])) echo $casedata['casenotes']; ?></textarea>
      
      
     
      
      
      
      
      </fieldset>
	  </div>
	     <div id="tabs-2">
   <div class="scroll" name="methodtableholder" id="methodtableholder">
             
            
             
               <table id="hortable" border="1">
                  <tbody>
                    <tr>
                      <p>
						
						<th>Selected </th>
						 <th>
						
   Method Type
					     </th>
						 <th>
							Method Name
						 </th>
						 </p>
                    </tr>
                    
                    <?php
					for($i=1;$i<=$_SESSION['num_methods'];$i++)
					{
					echo "<tr><td><input type='checkbox' name='chk[]'  /></td>
					<td>". $_SESSION['methodtabletype'][$i-1]."</td>
				<td>".$_SESSION['methodtablename'][$i-1]."</td>
				</tr>
				";
					
					
					}
					
					
					
	
					
					?>
                    
                   
                    </tbody>
                </table>
				<div class="clear"></div>
    
    </div>
    <fieldset class="methodinfobox"><legend class="boldlegend">Remove Methods</legend>
    <input type="button" value="Remove Method" id="removemethodbutton2"  /> 
               <!--     	<input type="button" value="Edit Method" id="editmethodbutton"  />-->
                         
					(Select a method in the table above to remove.)
    
    </fieldset>
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
    
     <span id="result_2" style="display: none;"></span>
                              <span id="wait_3" style="display: none;">
    <img alt="Please Wait" src="ajax-loader.gif"/>
    </span>
    <span id="result_3" style="display: none;"></span></p>
           <p>  <input type="button" class="showybutton" id="addmethodbutton2" value="Add Method to List" ></p>
             </div>
              <span name="savebutton" class="bigsavebutton">
    <input name="savecase" type="image" id="savecase" src="../../images/bigsave.png" alt="Save Case" width="90"/></span>
          <input name="fchoseninput" type="hidden" id="fchoseninput" value="0" />
    <input name="pchoseninput" type="hidden" id="pchoseninput" value="0" />   
   
    
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
    
</div>
  






 </div>






<div id="footer">Copyright 2014 by <a href="http://www.sofainc.org/" target="_blank">SOFA</a>.</div>
</div>




</body>
</html>

