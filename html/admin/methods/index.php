<?php

/* 
 * Show all available methods to an Admin, and allow them to add, edit or delete them
 */

require_once "../../include/header_admin.php";

if(isset($_POST['delete_method'])) {
    $method_id = $_POST['del_method_id'];
    
    $result = method::delete_method($db, $method_id);
    
    echo($result['MESSAGE']);
    
    
}

$pagerows = PAGEROWS;

//First, check for the total number of records
$all_methods = method::get_methods($db);
$num_methods = count($all_methods);

// Has the total number of pages already been calculated?
if (isset($_POST['p']) && is_numeric ($_POST['p'])) { //already been calculated
    $pages=$_POST['p'];
} else { //use the next block of code to calculate the number of pages

    //Now calculate the number of pages
    if ($num_methods > $pagerows){ //if the number of records will fill more than one page
    //Calculate the number of pages and round the result up to the nearest integer
        $pages = ceil ($num_methods/$pagerows);
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


$current_page = ($start/$pagerows) + 1;
echo("<div id='memberregion'> <h2 style='text-align:center'>List of methods</h2> ");

echo("<a href='add_method.php'>Add new method</A><BR>");
echo("<BR><BR>");
if ($pages > 1) {

//What number is the current page?


if ($current_page != 1) {
   // Create a Previous Link
    echo("<form class='inline' method=post action=index.php name='regsubmit'>"
            . "<input type=submit value='Previous Page'>"
            . "<input type=hidden name='p' value=$pages>"
            . "<input type=hidden name='s' value=".($start-$pagerows).">"
            . "<input type=hidden name=querystring value='".$session->get_var('querystring')."'>"
            . "</form>");
} else {
    
}

if ($current_page != $pages) {
//Create a Next link
    echo("<form class='inline' method=post action=index.php name='regsubmit'>"
            . "<input type=submit value='Next Page'>"
            . "<input type=hidden name='p' value=$pages>"
            . "<input type=hidden name='s' value=".($start+$pagerows).">"
            . "<input type=hidden name=querystring value='".$session->get_var('querystring')."'>"
            . "</form>");
} else {
}


}

echo '<div class="scroll"><table id="hortable" summary="List of methods">
    <thead>
    	<tr>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
            <th scope="col">Method</th>
            <th scope="col">Type</th>
            <th scope="col">Measurement Type</th>
            <th scope="col">Description</th>
            <th scope="col">Instructions</th>	
            <th scope="col">Active</th>
        </tr>
    </thead>
    <tbody>';

// Show all methods; Active and inactive
$methods = method::get_methods($db, $start, $pagerows, 'methodname, id', -1);
foreach($methods as $method) {
    $method_id = $method->get_id();
    $times_method_used = count(tier2data::get_used_methods($db, $method_id));
    $delete_alert_message = 'Are you sure you want to delete this method?\nAll method data and method infos associated with it will be deleted.';
    if($times_method_used > 0) {
        $delete_alert_message .= '\nThis method is currently used in '.$times_method_used.' cases.';
    }
    echo("<td>".
            "<form action='edit_method.php' name=editmethod method=POST>"
            . "<input type=hidden name='id' value='".$method->get_id()."'>"
            . "<input type=submit value=Edit>"
            . "</form></td>");
    echo('
	<td><form action="index.php?s='.$start.'&p='.$pages.'" method="post" id="delete_method" onsubmit="return confirm(\''.$delete_alert_message.'\')">
	<input name="del_method_id" type="hidden" value="'.$method_id.'"/>
	<input id="delete_method" name="delete_method" type="submit" value="Delete" /> </form>');
    echo("</td>".
             "<td>".$method->get_name(). "</td>".
            "<td>".$method->get_method_type()."</td>".
            "<td>".$method->get_measurement_type()."</td>".
            "<td>".$method->get_description()."</td>".
            "<td>".$method->get_instructions()."</td>".
            "<td>".($method->get_active() ? "Active" : "Inactive")."</td>".
        "</tr>");
}

echo("</tbody></table></div>");

if ($pages > 1) {

//What number is the current page?
$current_page = ($start/$pagerows) + 1;

if ($current_page != 1) {
   // Create a Previous Link
    echo("<form class='inline' method=post action=index.php name='regsubmit'>"
            . "<input type=submit value='Previous Page'>"
            . "<input type=hidden name='p' value=$pages>"
            . "<input type=hidden name='s' value=".($start-$pagerows).">"
            . "<input type=hidden name=querystring value='".$session->get_var('querystring')."'>"
            . "</form>");
} else {
    
}

if ($current_page != $pages) {
//Create a Next link
    echo("<form class='inline' method=post action=index.php name='regsubmit'>"
            . "<input type=submit value='Next Page'>"
            . "<input type=hidden name='p' value=$pages>"
            . "<input type=hidden name='s' value=".($start+$pagerows).">"
            . "<input type=hidden name=querystring value='".$session->get_var('querystring')."'>"
            . "</form>");
} else {
}
}

echo("</div>");
        

require_once "../../include/footer.php";

?>