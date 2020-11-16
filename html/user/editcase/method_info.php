<?php

/** This file is used when adding methods, to display the new list of methods based
 * on the type selected, or to display the method once it has been selected from another dropdown menu
 * 
 * It is used in the $('#methodtype').change() function in sofa_javascript.js to display the method list,
 * and also in javascript written in the the drop_1() function in functions.class.inc.php
 * 
 */

// If drop_1 is set, show the dropdown menu of methods for the given type
if(isset($_POST['func']) && $_POST['func'] == "drop_1"  ) { 
   // If drop_1 (method type) was chosen, show dropdown for the newly selected method type
   require_once('../../include/main.inc.php') ;
   if(isset($_POST['drop_var'])) {
        functions::drop_1($_POST['drop_var']); 
   } else {
       echo("Please select a valid method type.");
   }
   exit();
   
// If show_method_info is set, draw the selected method   
} else if(isset($_POST['func']) && $_POST['func'] == "show_method_info"  ) { 
    // If a method was chosen, show the method_infos for that method
    require_once('../../include/main.inc.php') ;
    if(isset($_POST['method_id'])) {
        $method_id = $_POST['method_id'];
        method_infos::show_method_info($db, $method_id); 
    } else {
        echo("Please select a valid method.");
    }
    exit();
    
}

?>