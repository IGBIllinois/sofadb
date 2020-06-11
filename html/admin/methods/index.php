<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once "../../include/header_admin.php";

if(isset($_POST['delete_method'])) {
    $method_id = $_POST['del_method_id'];
    
    $result = method::delete_method($db, $method_id);
    
    echo($result['MESSAGE']);
    
    
}

$pagerows = PAGEROWS;

// Has the total number of pagess already been calculated?
if (isset($_GET['p']) && is_numeric
($_GET['p'])) {//already been calculated
$pages=$_GET['p'];
}else{//use the next block of code to calculate the number of pages
//First, check for the total number of records
    
    $all_methods = method::get_methods($db);
    $num_methods = count($all_methods);

//Now calculate the number of pages
if ($num_methods > $pagerows){ //if the number of records will fill more than one page
//Calculatethe number of pages and round the result up to the nearest integer
$pages = ceil ($num_methods/$pagerows);
}else{
$pages = 1;
}
}

////page check finished
//Decalre which record to start with
if (isset($_GET['s']) && is_numeric($_GET['s'])) {//already been calculated
$start = $_GET['s'];
}else{
$start = 0;
}


echo("<div id='memberregion'> <h2 style='text-align:center'>List of methods</h2> ");

echo("<a href='add_method.php'>Add new method</A><BR>");
echo("<BR><BR>");

if ($pages > 1) {

//What number is the current page?
$current_page = ($start/$pagerows) + 1;
//If the page is not the first page then create a Previous link
if ($current_page != 1) {
echo '<a href="index.php?s=' . ($start - $pagerows) . '&p=' . $pages . '">Previous</a> | ';
}
//Create a Next link
if ($current_page != $pages+1) {
echo '<a href="index.php?s=' . ($start + $pagerows) . '&p=' . $pages . '">Next</a> ';
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
    echo("<tr>".
            "<td><a href='edit_method.php?id=". $method->get_id()."'>Edit</td>");
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
echo '<p>';
//What number is the current page?
$current_page = ($start/$pagerows) + 1;
//If the page is not the first page then create a Previous link
if ($current_page != 1) {
echo '<a href="index.php?s=' . ($start - $pagerows) . '&p=' . $pages . '">Previous</a> | ';
}
//Create a Next link
if ($current_page != $pages+1) {
echo '<a href="index.php?s=' . ($start + $pagerows) . '&p=' . $pages . '">Next</a> ';
echo '&nbsp; &nbsp; &nbsp; &nbsp;';
}
echo '</p>';
}

echo("</div>");
        

require_once "../../include/footer.php";

?>