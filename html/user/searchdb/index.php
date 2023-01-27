<?php
$title = "Forensic Anthropology Case Database (FADAMA) - Search";
require_once('../../include/header_user.php');
require_once('../../include/session.inc.php') ;
require_once(__DIR__ . "/exportdata.php"); 

?>

<br/>
<h1 class="cntr">Search Cases</h1>
<center>(<a target='blank' href='https://github.com/andicyim/FADAMA/wiki/FADAMA-User-Tutorial#Downloaded_data_sheet'>Search tutorial</a>)</center><BR>

<div id="searchregion"> 
<div name="searchresults">
<?php 
  
// Get the member id from the session
$memberid=$session->get_var('id');

$error=0;
  
if (isset($_POST['search'])){
	$session->unset_session_var('searched');
}
  
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['exportsubmit'])){//not export
	$first=0;
	$race_array = array();
	if (isset($_POST['race'])) {
		foreach($_POST['race'] as $race=>$value) {
			$race_array[$value] = $race;
		}
	}
	$case_data = array(
              //"memberId"=>$_POST['mID'],
              "caseYear"=>$_POST['cyear'],
              "yearRange"=>$_POST['yearrange'],
              //"caseNumber"=>$_POST['cnum'],
              //"caseAgency"=>$_POST['cagency'],
              //"region"=>$_POST['region'],
              "idsex"=>$_POST['sexid'],
              "idage1"=>$_POST['ageid1'],
              "idage2"=>$_POST['ageid2'],
              "idageunits"=>$_POST['ageidunits'],
              "idstature1"=>$_POST['statureid1'],
              "idstature2"=>$_POST['statureid2'],
              "idstatureunits"=>$_POST['statureunits'],
              "race"=>$race_array,
              "est_sex"=>isset($_POST['est_sex']) ? 1:0,
              "est_age"=>isset($_POST['est_age']) ? 1:0,
              "est_stat"=>isset($_POST['est_stat']) ? 1:0,
              "est_anc"=>isset($_POST['est_anc']) ? 1:0,
	      "conjunction"=>$_POST['andor'],
	      "method_conj"=>$_POST['method_conj'],
              "race_join"=>$_POST['race_join'],
              "prac_join"=>$_POST['prac_join'],
              "unsubmitted"=>isset($_POST['unsubmitted']) ? 1:0
                  );
		$method_list = array();
		if (isset($_POST['method_select'])) {
			$methods = ($_POST['method_select']);
             		foreach($methods as $index=>$result) {
				foreach($result as $id=>$option) {
					if($id != 0) {
						$method_list[] = $id;
					}
				}
			}
		}

	$case_results = sofa_case::search_cases($db, $case_data, $method_list);
	echo("<BR>");

        if(!$error){


            $pagerows = PAGEROWS;

            // Has the total number of pages already been calculated?
            if (isset($_POST['p']) && is_numeric ($_POST['p'])) { //already been calculated
                $pages=$_POST['p'];
            } else { //use the next block of code to calculate the number of pages
            //First, check for the total number of records

                $records = count($case_results);

                //Now calculate the number of pages
                if ($records > $pagerows){ //if the number of records will fill more than one page
                //Calculate the number of pages and round the result up to the nearest integer
                    $pages = ceil ($records/$pagerows);
                }else{
                    $pages = 1;
                }

            }//page check finished

            //Declare which record to start with
            if (isset($_POST['s']) && is_numeric($_POST['s'])) {//already been calculated
                $start = $_POST['s'];
            }else{
                $start = 0;
            }

            if(count($case_results) > 0) {
                // Cases were found

                $cases = count($case_results);
                $current_page = ($start/$pagerows) + 1;

                if ($pages==1) {
                    $startingrecord=1;
                    $endingrecord=$cases;

                } elseif ($current_page!= $pages) {
                    $startingrecord=($current_page-1)*$pagerows+1;
                    $endingrecord=($current_page)*$pagerows;

                } else {
                $startingrecord=($current_page-1)*$pagerows+1;
                $endingrecord=$cases;

                }

                echo("If you plan to analyze this data, please be sure to review the FADAMA tutorials on how the .csv organizes and presents case data. There is important information provided in <B><U><a href='https://github.com/andicyim/FADAMA/wiki/FADAMA-User-Tutorial#Downloaded_data_sheet' target=_blank>these tutorials</a></U></B> that can help ensure that misinterpretation of the data is not occurring.");
                echo("<BR>");

                echo ('<form action="confirm.php?'.$_SERVER['QUERY_STRING'].'" method="post" id="export">');
                if(isset($_POST)) {
			foreach($_POST as $name=>$value) {
				echo("<input type=hidden name='$name' value='$value'>");
                    }
                }
                echo'<br/><p>Click here to export results to CSV File
                <input name="fdb" type="hidden" value="0">
                   <input name="exportsubmit" id="exportsubmit" type="submit" value="Export Case Data"/></p>
                   </form>';

                echo '<br/> <a href="index.php?search=1">Search Again</a><BR><BR>';

                echo "<p class='dbresults'>Total number of search results: $cases. Showing records  $startingrecord - $endingrecord </p>";
                echo("<BR>");
                echo '<div class="scroll"><table id="hortable" summary="List of cases">
                    <thead>
                        <tr>
                            <th scope="col">Case Year</th>
                            <th scope="col">Date Submitted</th>
                             </tr>
                    </thead>
                    <tbody>';



                // Fetch and print all the records:
                $regcount=1;

                for($i = $startingrecord; $i <= $endingrecord; $i++) {

                    $case = $case_results[($i-1)];
                        echo '<tr>
                        <td>' . $case->get_caseyear(). '</td>
                        <td>' . $case->get_datesubmitted() . '</td>
                        </tr>';    
                }

                echo '</tbody></table></div>'; 

            } else { 
                // No cases found
                    echo '<p class="error">No records found.  </p>';	
                    echo '<br/> <a href="index.php?search=1">Search Again</a>';
                    exit();
            } // End of if ($result). 

            if ($current_page != 1) {
               // Create a Previous Link
                echo("<form class='inline' method=post action=index.php name='regsubmit'>"
                        . "<input type=submit value='Previous Page'>"
                        . "<input type=hidden name='p' value=$pages>"
                        . "<input type=hidden name='s' value=".($start-$pagerows).">"
                        . "<input type=hidden name=querystring value='".$session->get_var('querystring')."'>"
                        . "</form>");
            }


            if ($current_page != $pages) {
            //Create a Next link
                echo("<form class='inline' method=post action=index.php name='regsubmit'>"
                        . "<input type=submit value='Next Page'>"
                        . "<input type=hidden name='p' value=$pages>"
                        . "<input type=hidden name='s' value=".($start+$pagerows).">"
                        . "<input type=hidden name=querystring value='".$session->get_var('querystring')."'>"
                        . "</form>");
            }
		$session->set_session_var('searched',1);


        }//end on error
  
} else {
    // just show input form

?>





 </div>

<div id="searchform">

<?php 


if(!isset($fyear)) $fyear="";
if(!isset($fageid1)) $fageid1="";
if(!isset($fageid2)) $fageid2="";

?>

<fieldset class="enclosefieldset">
	<br>
        <fieldset class="caseinfobox"><legend class="boldlegend">Export Database</legend>
		<br>
 If you plan to analyze this data, please be sure to review the FADAMA tutorials on how the .csv organizes and presents case data. There is important information provided in <B><U><a href='https://github.com/andicyim/FADAMA/wiki/FADAMA-User-Tutorial#Downloaded_data_sheet' target=_blank>these tutorials</a></U></B> that can help ensure that misinterpretation of the data is not occurring. The size of the database prohibits a real-time download of all data in FADAMA. Instead, the data downloads every night at 11:59PM CST and prepared in the .zip file accessible through the Export All button below. There are four spreadsheets, with data related to methods for each of the four biological profile components.
		<br><br>
		<form action="confirm.php" method="post" id="export">
		<span><label class="label" for="exportall">Click here to export all cases</label><input name="exportall" type="submit" id="exportall" title="Export All" value="Export All">&nbsp; <?php echo basename(sofa_case::get_latest_full_report()); ?></span>
		</form>
		<br>
	</fieldset>
</fieldset>
<br>
<form action="index.php" method="post" id="search">
<fieldset class='enclosefieldset'>

   <fieldset class="caseinfobox"><legend class="boldlegend">Search By Identification Information</legend>
    
    <br><label class="label" for="sexid">Identified Sex</label>

   <select name="sexid" id="sexid">
	<option value="">- Select -</option>
	<option value="Male">Male</option>
	<option value="Female">Female</option>
    </select>

    <br><label class="label" for="ageid1">Range of Identified Ages</label><input id="ageid1" type="text" name="ageid1" size="5" maxlength="5" value="<?php echo $fageid1; ?>"/>&nbsp; to &nbsp;
<input id="ageid2" type="text" name="ageid2" size="5" maxlength="5" value="<?php echo $fageid2; ?>"/>
    <select name="ageidunits">
      <option value="years">years</option>
      <option value="months">months</option>
      <option value="fmonths">fetal months</option>
      </select>
    
    <br><label class="label" for="statureid1">Range of Identified Statures</label><input id="statureid1" type="text" name="statureid1" size="5" maxlength="8" value=""/>&nbsp; to &nbsp;
    <input id="statureid2" type="text" name="statureid2" size="5" maxlength="8" value=""/> 
    
    <select name="statureunits">
      <option value="in">inches</option>
      <option value="cm">cm</option>
    </select>
      
        <br><label class="label" for="idrace">Identified Races/Ethnicities</label>
      <input type="checkbox" name="race[]" value="as" id="raceAs"/>Asian/Pacific Islander
      <input type="checkbox" name="race[]" value="af" id="raceAf"/>Black/African-American<br>
      <label class="label" for="idrace2"></label>
      <input type="checkbox" name="race[]" value="hi" id="raceHi"/>Hispanic
      <input type="checkbox" name="race[]" value="na" id="raceNa"/>Native American<br>
      <label class="label" for="idrace3"></label>
      <input type="checkbox" name="race[]" value="wh" id="raceWh"/>White
      <input type="checkbox" name="race[]" value="ot" id="raceOt"/>Other<br/><br>
      <label class="label" for="searchtype">List Cases That Meet:</label>
        
      <select name="race_join">
	<option value="1">All Selected Races/Ethnicities</option>
	<option value="2">At Least One of Selected Races/Ethnicities</option>
      </select> 
        
      <span class="tooltip"><img class="img-bottom" src="../../images/tooltip.png">
        <span class="tooltiptext">If you've selected multiple boxes for "Identified Races/Ethnicities," then use the dropdown menu here to clarify your search. For example, if you selected Asian and Black, clicking "All Selected Races/Ethnicities" will only return cases where the individual identified as black AND Asian. </span>
      </span>
        
        <BR><BR>

	   </fieldset>  
	<br>
     <fieldset class="caseinfobox"><legend class="boldlegend">Search By Forensic Anthropology Report Information</legend>
     <br><label class="label" for="cyear">Case Year</label><input id="cyear" type="text" name="cyear" size="5" maxlength="4" value="<?php echo $fyear; ?>"> <select name="yearrange" id="yearrange">
	<option value="1">On or After</option>
	<option value="2">On or Before</option>
	<option value="3">Only</option>
	</select>
      <br><label class="label" for="methodest">Practitioner Estimated</label>
      <input type="checkbox" name="est_sex" value="1" />Sex
      <input type="checkbox" name="est_age" value="1" />Age
      <input type="checkbox" name="est_anc" value="1" />Ancestry
       <input type="checkbox" name="est_stat" value="1" />Stature<br />
        
        <br><label class="label" for="searchtype">Search for cases that contain:</label>
        <select name="prac_join">
		<option value="1">All Selected Estimations</option>
		<option value="2">At Least One of Selected Estimations</option>
      </select> 
        <span class="tooltip"><img class="img-bottom" src="../../images/tooltip.png">
            <span class="tooltiptext">If you've selected multiple boxes for "Practitioner Estimated", then use the dropdown menu here to clarify your search. For example, if you selected Sex and Stature, clicking "All Selected Estimations" will only return cases where both sex AND stature were estimated. </span>
        </span>
        <BR><BR>
     </fieldset>  

        
    <fieldset class="caseinfobox"><legend class="boldlegend">Search By Method</legend>

<?php 	
    // Draw dropdown lists of all the methods, organized by type
    // Sex methods
    $sx_methods = method::get_methods_by_type($db, METHOD_DATA_SEX_ID);
    $list = array();
    foreach($sx_methods as $sx_method) {
        $item = array($sx_method->get_id(), $sx_method->get_name());
        $list[] = $item;
    }
    echo("<table><tr><th>Sex Methods</th><td>Age Methods</td><td>Ancestry Methods</td><td>Stature Methods</td></tr>");
    echo("<td>");
    echo(functions::checkbox_dropdown(METHOD_DATA_SEX_ID, 'sex_methods', $list, array(), 'method_select'));
    echo("</td>");
    
    // Age methods
    
    $age_methods = method::get_methods_by_type($db, METHOD_DATA_AGE_ID);
    $list = array();
    foreach($age_methods as $age_method) {
        $item = array($age_method->get_id(), $age_method->get_name());
        $list[] = $item;
    }
    
    echo("<td>");
    echo(functions::checkbox_dropdown(METHOD_DATA_AGE_ID, 'age_methods', $list, array(), 'method_select'));
    echo("</td>");
    
    // Ancestry methods
    
    $anc_methods = method::get_methods_by_type($db, METHOD_DATA_ANCESTRY_ID);
    $list = array();
    foreach($anc_methods as $anc_method) {
        $item = array($anc_method->get_id(), $anc_method->get_name());
        $list[] = $item;
    }
    
    echo("<td>");
    echo(functions::checkbox_dropdown(METHOD_DATA_ANCESTRY_ID, 'anc_methods', $list, array(), 'method_select'));
    echo("</td>");
    
    // Stature methods
    
    $stat_methods = method::get_methods_by_type($db, METHOD_DATA_STATURE_ID);
    $list = array();
    
    foreach($stat_methods as $stat_method) {
        $item = array($stat_method->get_id(), $stat_method->get_name());
        $list[] = $item;
    }
    
    echo("<td>");
    echo(functions::checkbox_dropdown(METHOD_DATA_STATURE_ID, 'stat_methods', $list, array(), 'method_select'));
    echo("</td>");
    
    echo("</tr></table><BR>");
    
    
?>
    
     <br><label class="label" for="searchtype">Search for cases that contain:</label>
  
    <select name="method_conj">
	<option value="all">All Selected Methods</option>
	<option value="any">At Least One of Selected Methods</option>
    </select> 
    
    <span class="tooltip"><img class="img-bottom" src="../../images/tooltip.png">
        <span class="tooltiptext">If you've selected multiple methods, then use the dropdown menu here to clarify your search. For example, if you selected Fordisc and Brooks & Suchey 1990, clicking "All Selected Methods" will only return cases where both methods were used.</span>
    </span>   
    
    <br ><br>

     
    
<br> 
   <div id="search_errorloc" class="errorlocation">
            </div>
   
    </fieldset>
	<br >
	<fieldset class="caseinfobox"><legend class="boldlegend">Search Options</legend>
        <br>
        <label class="label" for="searchtype">List Cases That Meet:</label>
        <select name="andor">
            <option value="1">All Selected Criteria</option>
            <option value="2">At Least One of Selected Criteria</option>
        </select> 

        <span class="tooltip"><img class="img-bottom" src="../../images/tooltip.png">
            <span class="tooltiptext"> If you've selected or entered multiple criteria for your above search query (e.g. female, white, black, case year 2009+, Fordisc, Brooks and Suchey 1990), you will need to specify the conditions of that search here.  Correctly indicating your specifications will improve the accuracy of your search. </span>
        </span> 
    
        <br ><br>
	<label class="label" for="regsubmit">Click here to search</label>
        <input name="regsubmit" id="regsubmit" type="submit" class="showybutton" value="Search"/><br />
   
    
    <br>
    </fieldset>

    <br>
</fieldset>
    <br>

</form>


    
<form action="confirm.php" method="post" id="export">

<input type=hidden name='mId' value='<?php echo $memberid; ?>'>

    

    <fieldset class="enclosefieldset">
            <fieldset class="caseinfobox"><legend class="boldlegend">Export My Cases</legend>
    <br>
    If you plan to analyze this data, please be sure to review the FADAMA tutorials on how the .csv organizes and presents case data. There is important information provided in <B><U><a href='https://github.com/andicyim/FADAMA/wiki/FADAMA-User-Tutorial' target=_blank>these tutorials</a></U></B> that can help ensure that misinterpretation of the data is not occurring.
    <BR><BR>
    <span><label class="label" for="exportMy">Click here to export all of the current user's cases</label><input name="exportMy" type="submit" id="exportMy" title="Export My Cases" value="Export My Cases"></span><br>
    <BR>
        <span><label class="label" for="unsubmitted">Include unsubmitted cases?</label><input type=checkbox name="unsubmitted" value=1> </span>

    <br>
    </fieldset>
            <br>
            </fieldset>
    </form>
    
<script language="JavaScript" type="text/javascript"
    xml:space="preserve">//<![CDATA[
  //You should create the validator only after the definition of the HTML form
  var frmvalidator  = new Validator("search");
  
  frmvalidator.EnableOnPageErrorDisplaySingleBox();
  frmvalidator.EnableMsgsTogether();

  frmvalidator.addValidation("cyear","gt=1900","Case Year must be post-1900");
  frmvalidator.addValidation("ageid1","gt=0","First age must be larger than zero");
  frmvalidator.addValidation("ageid2","gt=0","Second age must be larger than zero");
  frmvalidator.addValidation("statureid1","gt=0","First stature must be larger than zero");
  frmvalidator.addValidation("statureid2","gt=0","Second stature must be larger than zero");
 
  frmvalidator.addValidation("statureid2","geelmnt=statureid1","The second stature should be larger or equal to the first.");
  frmvalidator.addValidation("ageid2","geelmnt=ageid1","The second age should be larger or equal to the first.");
  frmvalidator.addValidation("cyear","maxlen=4","Year must be entered in YYYY format");
  frmvalidator.addValidation("cyear","numeric", "Year must be an integer number");
  frmvalidator.addValidation("ageid1","numeric", "First age must be a number");
  frmvalidator.addValidation("ageid2","numeric", "Second age must be a number");
  frmvalidator.addValidation("statureid1","numeric", "First stature must be a number");
  frmvalidator.addValidation("statureid2","numeric", "Second stature must be a number");
  frmvalidator.addValidation("mID","numeric","Member ID must be an integer number");

    
//]]>
</script>


</div>

<?php
// end else
}
    require_once("../../include/footer.php");
?>
