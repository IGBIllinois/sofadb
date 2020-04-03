<?php
$title = "Export FDB";
require_once "../include/header_admin.php";


 if (isset($_POST['exportfdb']) && $_POST['exportfdb'] != null){

     $datesubmitted = null;
     if(isset($_POST['datesubmitted']) && $_POST['datesubmitted'] != null) {
         $datesubmitted = $_POST['datesubmitted'];
         $params = array("datesubmitted"=>$datesubmitted);
         
     } else {
         $params = array();
     }
     $caselist = sofa_case::search_cases($db, null, $params, null);

     sofa_case::write_report($db, $caselist, 1,0);
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

_END;
 
require_once "../include/footer_admin.php";