<?php
	  if (isset($_POST['exportsubmit'])|| isset($_POST['exportall']))
	  {
		if(isset($_POST['exportsubmit']))
		{$searchstr=$_SESSION['searchstring'];}
		if(isset($_POST['exportall']))
		{$searchstr="caseyear >= 1901";}
		 require_once($_SERVER['DOCUMENT_ROOT'].'/mysqli_connect.php');
		  // output headers so that the file is downloaded rather than displayed
//header('Content-Type: text/csv; charset=utf-8');

 ob_end_clean();
 $today = date("m_d_Y_H_i_s");
 $filename='SOFADBExport_'.$today.".csv";
header("Content-type: application/octet-stream");
header('Content-Disposition: attachment; filename='.$filename);

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');


// make header row for data
$headerrow=array('Case ID', 'Date Submitted to SOFA DB', 'Practioner Degree', 'Year Earned', 'Practioner Cases Per Year', 'Case Year','FA Report: Sex', 'FA Report: Minimum age', 'FA Report: Minimum age units (years or fetal months)', 'FA Report: Maximum age', 'FA Report: Maximum age units (years or fetal months)','FA Report: Ancestry','FA Report: Minimum Stature (inches)','FA Report: Maximum Stature (inches)','Identified Sex','Identified Age','Identified Age Units (years or fetal months)','Identified Race/Ethnicity','Race/Ethnicity Notes','Identified Stature (inches)','Information Source','Case Notes');





// make sure we allow for any methods
$q0 = "SELECT id, measurementtype FROM methods ORDER BY id ASC";

 $result0 = @mysqli_query ($dbcon, $q0); // Run the query.
// fetch the data
if(!$result0){
	echo 'System Error: Could not export Data';
	exit();
	
	}
	
	$nummethodret=mysqli_num_rows($result0);

while ($row0=mysqli_fetch_array($result0, MYSQLI_ASSOC)){
	$headerrow[]=$row0['measurementtype'];
	}

//this was the hardcoded header before

//$headerrow=array('Case ID', 'Case Year', 'FA Report: Sex', 'FA Report: Minimum age', 'FA Report: Minimum age units (years or fetal months)', 'FA Report: Maximum age', 'FA Report: Maximum age units (years or fetal months)','FA Report: Ancestry','FA Report: Minimum Stature (inches)','FA Report: Maximum Stature (inches)','Identified Sex','Identified Age','Identified Age Units (years or fetal months)','Identified Race','Identified Stature (inches)','Information Source','Case Notes','ASCADI & NEMERESKI 1970 (sex, skull, nonmetric)','FORDISC (sex, skull, metric)','KLALES ET AL 2012 (sex, os pubis, nonmetric)','PHENICE 1969 (sex, os pubis, nonmetric)','TISE ET AL. 2013 (sex, postcranial, metric)','WALKER 2008 (sex, skull, metric)','BROOKS & SUCHEY 1990 (age, os pubis, nonmetric)','HARTNETT 2012 (age, os pubis, nonmetric)','HARTNETT 2012 (age, ribs, nonmetric)','ISCAN 1984/1985 (age, ribs, nonmetric)','ISCAN 1985 white females (age, ribs, nonmetric)','MEINDL & LOVEJOY 1985 (age, nonmetric, cranium)','MINCER ET AL 1993 (age, third molar, nonmetric)','MOORREES ET AL 1963 (age, dentition, nonmetric)','OSBOURNE ET AL 2004 (age, os coxa, nonmetric)','FORDISC (ancestry, cranium, metric)','HEFNER 2010 (ancestry, skull, nonmetric)','RHINE 1990 (ancestry, skull, nonmetric)','FORDISC (stature, long bones, metric)','SJOVOLD 1990 (stature, long bones, metric)')

// output the column headings
fputcsv($output,$headerrow);


// now let's get all the case data matching our search string
$q = "SELECT * FROM cases WHERE ($searchstr) AND submissionstatus=1 ORDER BY caseyear ASC";

 $result = @mysqli_query ($dbcon, $q); // Run the query.
// fetch the data
if(!$result){
	echo 'System Error: Could not export Data';
	exit();
	
	}


// loop over the rows, outputting them
while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	
	//construct ancestry id string
	$idancestry="";
	if ($row['idraceas']!=0){$idancestry=$idancestry.'[Asian/Pacific Islander]';}
	if ($row['idraceaf']!=0){$idancestry=$idancestry.'[African-American/Black]';}
	if ($row['idracehi']!=0){$idancestry=$idancestry.'[Hispanic]';}
	if ($row['idracena']!=0){$idancestry=$idancestry.'[Native Ameriacan]';}
	if ($row['idracewh']!=0){$idancestry=$idancestry.'[White]';}
	if ($row['idraceot']!=0){$idancestry=$idancestry.'['.$row['idraceottext'].']';}
	
	//find out member data
	$idmember=$row['memberid'];
	$qmem="SELECT * FROM members where id=$idmember";
	$resultmem=@mysqli_query($dbcon,$qmem);
	if(!$resultmem)
	{echo 'System Error: Could not export Data';
	exit();
		}
	$rowmem=mysqli_fetch_array($resultmem, MYSQLI_ASSOC);
	
	//find out which methods are bieng used
	$idq=$row['id'];
	$q2= "SELECT methodid FROM tier2data WHERE caseid=$idq";
	$result2 = @mysqli_query ($dbcon, $q2); 
	if(!$result2){
	echo 'System Error: Could not export Data';
	exit();
    }
	
	//These lines were added in November 2017 to deal with the issue that people submitting
	//cases may not be the same people that worked on the case
	$rowmem['degree']='NA';
	$rowmem['degreeyear']='NA';
	$rowmem['caseperyear']='NA';
	
	$caserow=array($row['id'],$row['datesubmitted'],$rowmem['degree'],$rowmem['degreeyear'],$rowmem['caseperyear'], $row['caseyear'], $row['fasex'], $row['faage'], $row['faageunits'], $row['faage2'], $row['faageunits2'],$row['faancestryottext'],$row['fastature'],$row['fastature2'],$row['idsex'],$row['idage'],$row['idageunits'],$idancestry,$row['idancaddtext'],$row['idstature'],$row['idsource'],$row['casenotes']);
	
	
	//set all the methods as unused first
	for($i=1;$i<=$nummethodret;$i++){
	$caserow[]='N';
			}
		
		while ($rowmeth=mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
	 //the 21 comes from the number of columns-1 before the methods start. 
			$axnumber=21+$rowmeth['methodid'];
			$caserow[$axnumber]='Y';}	
			
	
	fputcsv($output, $caserow);}
		  fclose($output);
		  unset($_POST['export']);
		die();
		
		  }




?>