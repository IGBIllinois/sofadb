<?php
$title = "Export FDB";
require_once "../include/header_admin.php";

 if (isset($_POST['exportfdb']) && $_POST['exportfdb'] != null){
     $after_date = null;
     if(isset($_POST['after_date']) && $_POST['after_date'] != null) {
         $after_date = $_POST['after_date'];
     }
     echo("After date = ".$after_date);
 }

echo '<form action="admin_reports.php" method="post" id="export">
<br/><p>Click here to export FDB report results to a CSV file
<input name="fdb" type="hidden" value="1">
   <input name="exportfdb" id="exportfdb" type="submit" value="Export FDB Case Data"/></p>
   Only get cases added after: (if left blank, all cases will be retrieved.)
<input type="date" id="after_date" name="after_date">
       
   </form>';


require_once "../include/footer_admin.php";