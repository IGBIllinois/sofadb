<?php
$title = "Forensic Anthropology Case Database (FADAMA) - Reports";
require_once "../include/header_admin.php";


 if (isset($_POST['exportfdb']) && $_POST['exportfdb'] != null){

     $datesubmitted = null;
     if(isset($_POST['datesubmitted']) && $_POST['datesubmitted'] != null) {
         $datesubmitted = $_POST['datesubmitted'];
         $params = array("datesubmitted"=>$datesubmitted);
         
     } else {
         $params = array();
     }
     $params['fdb_consent'] = true;
     $caselist = sofa_case::search_cases($db, null, $params, null);
     
     sofa_case::write_report($db, $caselist, null, null, 1,0);
     die();

 } else if (isset($_POST['downloaddata'])) {
     $date = null;
     if(isset($_POST['date'])); {
        $date = $_POST['date'];
     }
     functions::download_data_report($db, $date);
     die();
 }

echo <<<_END
<fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend class="boldlegend">FDB Report</legend>
<br>
    <form action="admin_reports.php" method="post" id="export">
    Only get cases submitted after: (if left blank, all cases will be retrieved.)
<input type="date" id="datesubmitted" name="datesubmitted">
 
<br/><p>Click here to export FDB report results to a CSV file
<input name="fdb" type="hidden" value="1">
   <input name="exportfdb" id="exportfdb" type="submit" value="Export FDB Case Data"/></p>

       
   </form>'
 </fieldset>
 
 <fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend class="boldlegend">Download Report</legend>
<br>
    <form action="admin_reports.php" method="post" id="export">
    Only get cases submitted after: (if left blank, all cases will be retrieved.)
<input type="date" id="date" name="date">
 
<br/><p>Click here to export downloaded data report results to a CSV file
<input name="fdb" type="hidden" value="1">
   <input name="downloaddata" id="downloaddata" type="submit" value="Export Download Data"/></p>

       
   </form>'
 </fieldset>

_END;
 
require_once "../include/footer.php";