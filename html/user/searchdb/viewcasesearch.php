<?php 
require('../../include/session_user.php') ;

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>View Case</title>
 <link href="../../css/styleTemplateMod.css" rel="stylesheet" type="text/css" />
 <link rel="stylesheet" type="text/css" href="../../css/jquery.multiselect.css" />
 <link rel="stylesheet" type="text/css" href="../../css/jquery-ui.css" />
 
 


   
  
 
 
 
 



<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>



 
<!--<script type="text/javascript">
  $(function() {
    $( "#tabs" ).tabs();
  });
  </script>-->








<!-- // Load Javascipt -->
</head>

<body>
<div id="top">
<div id="header"><a href="http://www.sofainc.org" target="_blank"><img src="../../images/customLogo.gif" width="351" height="147" /></a></div>

<div id="title">
<h1>Forensic Anthropology Case Database (FADAMA)</h1>
</div>

<div id="hline">
<hr size="3" />
</div>

<div id="navbar">
  <ul>
    <li><a href="../../">Home</a></li>
    <li><a href="../index.php">My Cases</a></li>
    <li><a href="../../logout.php">Logout</a></li>
    <li><a href="../../contact/">Contact Us</a></li>
  </ul>
</div>

<div id="hline">
<hr size="3" />
</div>

<div id="templatecontainer">
 
  <br/>
  <h1 class="cntr">View Case Information <a href="<?php echo $_SERVER['HTTP_REFERER'] ?>">[Back to Search Results]</a></h1>

   <div class="navigation">

        <ul class="menu">
        
        <li><a class="active" href="../"><svg class="home" width="30px" height="30px" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><path d="M419.492,275.815v166.213H300.725v-90.33h-89.451v90.33H92.507V275.815H50L256,69.972l206,205.844H419.492 z M394.072,88.472h-47.917v38.311l47.917,48.023V88.472z"/></svg><span title="Home">My Cases</span></a></li>
        
        <li><a href="../addcase/"><svg class="contact" width="30px" height="30px" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 30 30" enable-background="new 0 0 30 30" xml:space="preserve"><path d="M11.8,8.3h-1.8V6.5c0-0.7,0.6-1.2,1.2-1.2h7.4c0.7,0,1.2,0.6,1.2,1.2v1.8h-1.8v-1c0-0.2-0.2-0.4-0.4-0.4h-5.5c-0.2,0-0.4,0.2-0.4,0.4C11.8,7.3,11.8,8.3,11.8,8.3z"/>

<rect x="2.9" y="9.4" width="24.1" height="15.3"/>

<text transform="matrix(1 0 0 1 11.5 20.375)" fill="#FFFFFF" font-family="'MyriadPro-Regular'" font-size="12">+</text></svg><span title="About">Add Case</span></a></li>

<li>
<a href="../deletecase/">
<svg class="work" width="30px" height="30px" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 30 30" enable-background="new 0 0 30 30" xml:space="preserve"><path d="M11.8,8.3h-1.8V6.5c0-0.7,0.6-1.2,1.2-1.2h7.4c0.7,0,1.2,0.6,1.2,1.2v1.8h-1.8v-1c0-0.2-0.2-0.4-0.4-0.4h-5.5c-0.2,0-0.4,0.2-0.4,0.4C11.8,7.3,11.8,8.3,11.8,8.3z"/>
<rect x="2.9" y="9.4" width="24.1" height="15.3"/>
<text transform="matrix(1 0 0 1 12.5 22.375)" fill="#FFFFFF" font-family="'MyriadPro-Regular'" font-size="18">-</text></svg><span title="Work">Delete</span></a></li>

<li><a href="./?search=1">
<svg class="search" width="30px" height="30px" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 30 30" enable-background="new 0 0 30 30" xml:space="preserve"><path d="M11.8,8.3h-1.8V6.5c0-0.7,0.6-1.2,1.2-1.2h7.4c0.7,0,1.2,0.6,1.2,1.2v1.8h-1.8v-1c0-0.2-0.2-0.4-0.4-0.4h-5.5c-0.2,0-0.4,0.2-0.4,0.4C11.8,7.3,11.8,8.3,11.8,8.3z"/>

<rect x="2.9" y="9.4" width="24.1" height="15.3"/>

<text transform="matrix(1 0 0 1 12.5 22.375)" fill="#FFFFFF" font-family="'MyriadPro-Regular'" font-size="14">?</text></svg><span title="Work">Search</span></a></li>



<li><a href="../editprofile/"><svg class="about" width="30px" height="30px" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><path d="M407.448,360.474c-59.036-13.617-113.989-25.541-87.375-75.717 c81.01-152.729,21.473-234.406-64.072-234.406c-87.231,0-145.303,84.812-64.072,234.406c27.412,50.482-29.608,62.393-87.375,75.717 c-59.012,13.609-54.473,44.723-54.473,101.176h411.838C461.919,405.196,466.458,374.083,407.448,360.474z"/></svg><span title="About">Profile</span></a></li>



<li><a href="../../logout.php"><svg class="lab" width="30px" height="30px" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="202 16 539 524" enable-background="new 202 16 539 524" xml:space="preserve"><g>

	<path d="M586.9,508.9H311.5c-43.2,0-81-37.8-81-81V128.2c0-45.9,37.8-81,81-81h275.4c45.9,0,81,35.1,81,81v299.7C667.9,471.1,632.8,508.9,586.9,508.9z"/>

	<path fill="#000000" d="M667.8,376.2c-32.3,44.3-85.5,73.3-145.7,73.3c-98.4,0-178.2-77.4-178.2-172.8s79.8-172.8,178.2-172.8c60.1,0,113.2,28.8,145.5,73"/>

	<polygon  points="406,230.8 406,344.2 546.4,344.2 546.4,419.8 727.3,287.5 568,155.2 568,225.4 	"/>

</g></svg><span title="Lab">Logout</span></a></li>
</ul>


    </div>


  <?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/mysqli_connect.php'); // Connect to the database.


if(isset($_GET['id']))
{$caseeditid=$_GET['id'];
$_SESSION['caseid']=$caseeditid;
$userid=$_SESSION['id'];
unset($_GET['id']);
$q="SELECT * FROM cases WHERE id=$caseeditid AND submissionstatus=1";

$mresult=mysqli_query($dbcon,$q);
if(!$mresult)
{echo 'Could not load user data from database';exit();}

$casedata=mysqli_fetch_array($mresult);}
elseif(!isset($_SESSION['caseid']))
{ header ("location: ../index.php"); exit();}
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
	
}
	}

                 
               
?>
  



  <div id="caseform">
  
   
  
    <form action="index.php" method="post" id="casedata">
	
	<div id="tabs">
 <!-- <ul>
    <li><a href="#tabs-1">General Case Information</a></li>
    <li><a href="#tabs-2">Methods Used</a></li>
 
  </ul>-->
<div id="tabs-1">
    
    
  <fieldset class="enclosefieldset">
    
    
  <fieldset class="caseinfobox"><legend class="boldlegend">General Case Information</legend>
    <label class="label" for="caseyear">Case Year</label><input id="caseyear" type="text" name="caseyear" size="5" maxlength="4" value="<?php if (isset($casedata['caseyear'])) echo $casedata['caseyear']; ?>" readonly/> 
      <br />   
 
  </fieldset>
    
  <fieldset class="caseinfobox"><legend class="boldlegend"> Biological Profile: Forensic Anthropology Case Estimation</legend>
    
    
  <label class="label" for="fasex">Sex</label>
  <select name="fasex" disabled>
    <option value="">- Select -</option>
    <option value="Female"<?php if (isset($casedata['fasex']) AND ($casedata['fasex'] == 'Female')) echo ' selected="selected"'; ?>>Female</option>
    <option value="Probable Female"<?php if (isset($casedata['fasex']) AND ($casedata['fasex'] == 'Probable Female')) echo ' selected="selected"'; ?>>Probable Female</option>
    <option value="Indeterminate"<?php if (isset($casedata['fasex']) AND ($casedata['fasex'] == 'Indeterminate')) echo ' selected="selected"'; ?>>Indeterminate</option>
    <option value="Probable Male"<?php if (isset($casedata['fasex']) AND ($casedata['fasex'] == 'Probable Male')) echo ' selected="selected"'; ?>>Probable Male</option>
    <option value="Male"<?php if (isset($casedata['fasex']) AND ($casedata['fasex'] == 'Male')) echo ' selected="selected"'; ?>>Male</option>
    </select>
    
    
    
    <br/><label class="label" for="faage">Age</label><input id="faage" type="text" name="faage" size="5" maxlength="5" value="<?php if (isset($casedata['faage'])) echo $casedata['faage']; ?>"readonly/>
    
    <select name="faageunits" disabled>
      <option value="years">years</option>
      <option value="months"<?php if (isset($casedata['faageunits']) AND ($casedata['faageunits'] == 'months')) echo ' selected="selected"'; ?>>months</option>
      <option value="fetalmonths"<?php if (isset($casedata['faageunits']) AND ($casedata['faageunits'] == 'fetalmonths')) echo ' selected="selected"'; ?>>fetal months</option>
      </select>&nbsp; to &nbsp;
    
    <input id="faage2" type="text" name="faage2" size="5" maxlength="5" value="<?php if (isset($casedata['faage2'])) echo $casedata['faage2']; ?>"readonly/>
    
    <select name="faageunits2" disabled>
      <option value="years">years</option>
      <option value="months"<?php if (isset($casedata['faageunits2']) AND ($casedata['faageunits2'] == 'months')) echo ' selected="selected"'; ?>>months</option>
      <option value="fetalmonths"<?php if (isset($casedata['faageunits2']) AND ($casedata['faageunits2'] == 'fetalmonths')) echo ' selected="selected"'; ?>>fetal months</option>
      </select>
    
    
    
    <br/><label class="label" for="faancestry">Ancestry</label><input id="farace_othertext" type="text" name="farace_othertext" size="60" maxlength="100" value="<?php if (isset($casedata['faancestryottext'])) echo $casedata['faancestryottext']; ?>"readonly/>
    
    
    
    <br/><label class="label" for="fastature">Stature</label><input id="fastature" type="text" name="fastature" size="6" maxlength="8" value="<?php if (isset($casedata['fastature'])) echo $casedata['fastature']; ?>"readonly/>  &nbsp; to &nbsp;
    
    <input id="fastature2" type="text" name="fastature2" size="6" maxlength="8" value="<?php if (isset($casedata['fastature2'])) echo $casedata['fastature2']; ?>"readonly/>  <select name="fastatureunits" disabled>
      <option value="in">inches</option>
      </select>
    
    
    </fieldset>
    
    <fieldset class="caseinfobox"><legend class="boldlegend">Biological Profile: Actual Identified Information</legend>
      
      <label class="label" for="idsex">Sex</label>
      <select name="idsex" disabled>
        <option value="">- Select -</option>
        <option value="Female"<?php if (isset($casedata['idsex']) AND ($casedata['idsex'] == 'Female')) echo ' selected="selected"'; ?>>Female</option>
        <option value="Male"<?php if (isset($casedata['idsex']) AND ($casedata['idsex'] == 'Male')) echo ' selected="selected"'; ?>>Male</option>
        </select>
      
      
      <br/><label class="label" for="idage">Age</label><input id="idage" type="text" name="idage" size="5" maxlength="5" value="<?php if (isset($casedata['idage'])) echo $casedata['idage']; ?>"readonly/>
      <select name="idageunits" disabled>
        <option value="years">years</option>
        <option value="months"<?php if (isset($casedata['idageunits']) AND ($casedata['idageunits'] == 'months')) echo ' selected="selected"'; ?>>months</option>
        <option value="fmonths"<?php if (isset($casedata['idageunits']) AND ($casedata['idageunits'] == 'fmonths')) echo ' selected="selected"'; ?>>fetal months</option>
        </select> 
      
      
      
      
      
      <br/><label class="label" for="idrace">Race/Ethnicity</label>
      <input type="checkbox" name="race_asian" value="1" <?php if (isset($casedata['idraceas']) AND $casedata['idraceas'] == 1) echo ' checked'; ?> disabled/>Asian/Pacific Islander
      <input type="checkbox" name="race_black" value="1" <?php if (isset($casedata['idraceaf'])  AND $casedata['idraceaf'] == 1) echo ' checked'; ?> disabled/>Black/African-American
      <input type="checkbox" name="race_hispanic" value="1" <?php if (isset($casedata['idracehi']) AND $casedata['idracehi'] == 1) echo ' checked'; ?> disabled/>Hispanic<br />
      <label class="label" for="idrace2"></label>
      <input type="checkbox" name="race_native" value="1" <?php if (isset($casedata['idracena']) AND $casedata['idracena'] == 1) echo ' checked'; ?> disabled/>Native American
      <input type="checkbox" name="race_white" value="1" <?php if (isset($casedata['idracewh']) AND $casedata['idracewh'] == 1) echo ' checked'; ?> disabled/>White
      <input type="checkbox" name="race_other" value="1" <?php if (isset($casedata['idraceot']) AND $casedata['idraceot'] == 1) echo ' checked'; ?> disabled />Other: &nbsp; <input id="idrace_othertext" type="text" name="idrace_othertext" size="18" maxlength="30" value="<?php if (isset($casedata['idraceottext'])) echo $casedata['idraceottext']; ?>"readonly/>
         <br /><label class="label" for="idancaddtext">Race/Ethnicity Extra</label><input id="idancaddtext" type="text" name="idancaddtext" size="30" maxlength="300" value="<?php if (isset($casedata['idancaddtext'])) echo $casedata['idancaddtext']; ?>" readonly/><br>
      
      <br/><label class="label" for="idstature">Stature</label><input id="idstature" type="text" name="idstature" size="6" maxlength="8" value="<?php if (isset($casedata['idstature'])) echo $casedata['idstature']; ?>" readonly/>
      
      <select name="idstatureunits" disabled>
        <option value="in">inches</option>
        </select>
      
      <br />
      
      <br/><label class="label" for="idsource">Information Source</label><input id="idsource" type="text" name="idsource" size="30" maxlength="60" value="<?php if (isset($casedata['idsource'])) echo $casedata['idsource']; ?>" readonly/><br />
      
  </fieldset>
    <fieldset class="caseinfobox"><legend class="boldlegend">Case Notes</legend>
      <label class="label" for="casenotes"></label>
      <textarea name="casenotes" cols="55" rows="7" readonly><?php if (isset($casedata['casenotes'])) echo $casedata['casenotes']; ?></textarea>
      
      
     
      
      
      
      
      </fieldset>
      
      <fieldset class="caseinfobox"><legend class="boldlegend"> Methods Used</legend>
       <div id="tabs-2">
   <!-- <fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend>Methods</legend>-->
    
   
  
    
    
              <div class="scroll" name="methodtableholder" id="methodtableholder">
             
            
             
               <table id="hortable" border="1">
                  <tbody>
                    <tr>
                      <p>
						
						
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
					echo "<tr>
					<td>". $_SESSION['methodtabletype'][$i-1]."</td>
				<td>".$_SESSION['methodtablename'][$i-1]."</td>
				</tr>
				";
					
					
					}
					
					
					
	
					
					?>
                    
                   
                    </tbody>
                </table>
                
                <!-- </fieldset>-->
				<div class="clear"></div>
    
    </div>
    
    </div>
      </fieldset>
	  </div>
	    
    
    
   </div></div>
	  
	  
   
    
  
    
    
    </fieldset>
 
  </form>
    
    
    
</div>
  






 </div>






<div id="footer">Copyright 2014 by <a href="http://www.sofainc.org/" target="_blank">SOFA</a>.</div>
</div>




</body>
</html>

