<?php
require_once('../include/header_user.php');
//require_once('../include/session_user.php') ;

?>


  <h1 class="cntr">View Case Information</h1>



  <?php


if(isset($_GET['id']))
{$caseeditid=$_GET['id'];
$_SESSION['caseid']=$caseeditid;
$userid=$_SESSION['id'];
unset($_GET['id']);
$q="SELECT * FROM cases WHERE id=$caseeditid AND memberid=$userid";

$mresult=mysqli_query($dbcon,$q);

$case = new sofa_case($dbcon, $caseeditid);
if(!$mresult)
{echo 'Could not load user data from database';exit();}

$casedata=mysqli_fetch_array($mresult);}
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
    $case = new sofa_case($dbcon, $caseeditid);


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
    <label class="label" for="caseyear">Case Year</label><input id="caseyear" type="text" name="caseyear" size="5" maxlength="4" value="<?php if (null !== ($case->get_caseyear())) echo $case->get_caseyear(); ?>" readonly/> 
      <br />
  <label class="label" for="casenumber">Case Number</label><input id="casenumber" type="text" name="casenumber" size="30" maxlength="30" value="<?php if (null !== ($case->get_casenumber())) echo $case->get_casenumber(); ?>" readonly/>
  <br />
    
  <label class="label" for="caseagency">Case Agency</label><input id="caseagency" type="text" name="caseagency" size="30" maxlength="30" value="<?php if (null !== ($case->get_caseagency())) echo $case->get_caseagency(); ?>" readonly/>
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

