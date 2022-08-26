<?php

/**
 * Allows an Admin to get reports about FDB cases, and reports of who has requested reports
 */

$title = "Forensic Anthropology Case Database (FADAMA) - Reports";
require_once "../include/header_admin.php";


 if (isset($_POST['exportfdb']) && $_POST['exportfdb'] != null){
     
     // Get FDB data report
     
     $errors = array();
     $datesubmitted = null;
     if(isset($_POST['datesubmitted']) && $_POST['datesubmitted'] != null) {

         $datesubmitted = $_POST['datesubmitted'];
         $test_arr  = explode('-', $datesubmitted);
         // check for valid date (yyyy-mm-dd format)
         $checkdate = checkdate($test_arr[1],$test_arr[2],$test_arr[0]);
         echo("checkdate = $checkdate<BR>");
         if(!$checkdate) {
             $errors[] = "'$datesubmitted' is not a valid date. Please enter a valid date.";
         } else {
            $params = array("datesubmitted"=>$datesubmitted);
         }
     } else {
         $params = array();
     }

     if(count($errors) > 0) {
         echo("Error:<BR>");
         foreach($errors as $error) {
             echo($error);
         }
     } else {
         // No errors; Write report
        $params['fdb_consent'] = true;
        $caselist = sofa_case::search_cases($db, null, $params, null);
        sofa_case::write_report($db, $caselist, null, null, 1,0);
        die();
     }

 } else if (isset($_POST['downloaddata'])) {
     // Get a download report
     $date = null;
     $errors = array();
     if(isset($_POST['date']) && $_POST['date'] != null) {
        $date = $_POST['date'];
         $test_arr  = explode('-', $date);
         // check for valid date (yyyy-mm-dd format)
         $checkdate = checkdate($test_arr[1],$test_arr[2],$test_arr[0]);
         if(!$checkdate) {
             $errors[] = "'$date' is not a valid date. Please enter a valid date.";
         } else {

         }
     } else {
         // No date entered; Get all data
     }
     
     if(count($errors) > 0) {
         echo("Error:<BR>");
         foreach($errors as $error) {
             echo($error);
         }
     } else {
        functions::download_data_report($db, $date);
        die();
     }
 }

echo <<<_END
<fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend class="boldlegend">FDB Report</legend>
<br>
    <form action="admin_reports.php" method="post" id="export" name='fdb_report'>
    Only get cases submitted after: (if left blank, all cases will be retrieved.)
<input type="date" id="datesubmitted" name="datesubmitted">
 
<br/><p>Click here to export FDB report results to a CSV file
<input name="fdb" type="hidden" value="1">
   <input name="exportfdb" id="exportfdb" type="submit" value="Export FDB Case Data"/></p>

       
   </form>'
 </fieldset>
 
 <fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend class="boldlegend">Download Report</legend>
<br>
    <form action="admin_reports.php" method="post" id="export" name='admin_report'>
    Only get cases submitted after: (if left blank, all cases will be retrieved.)
<input type="date" id="date" name="date">
 
<br/><p>Click here to export downloaded data report results to a CSV file
<input name="fdb" type="hidden" value="1">
   <input name="downloaddata" id="downloaddata" type="submit" value="Export Download Data"/></p>

       
   </form>'
 </fieldset>

_END;
 
require_once "../include/footer.php";
