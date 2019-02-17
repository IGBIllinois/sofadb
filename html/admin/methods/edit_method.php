<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once "../../include/header_admin.php";
$name = null;
$type_id = null;
$type_name = null;
$measurement_type=null;
$description = null;
$instructions = null;
$features = null;

$method_type_list = array("1"=>"Sex", "2"=>"Age", "3"=>"Ancestry", "4"=>"Stature");

if(!isset($_POST['id']) &&  !isset($_GET['id'])) {
    echo("Please enter a valid method.");
} else {
    if(isset($_GET['id'])) {
        // showing form for first time
        $id = $_GET['id'];
        $method = new method($db, $id);
        
        $name = $method->get_name();
        $type_id = $method->get_method_type_num();
        $type_name = $method->get_method_type();
        $measurement_type = $method->get_measurement_type();
        $description = $method->get_description();
        $instructions = $method->get_instructions();
    
        $features = $method->get_features();
        
    } else {
        $id = ($_POST['id']);
        $method = new method($db, $id);
    }
    
    
if(isset($_POST['edit_method_submit'])) {
    
    if(isset($_POST['method_name'])) {
        $name = $_POST['method_name'];
    }

    if(isset($_POST['method_type'])) {
        $type_id = $_POST['method_type'];
        $type_name = $method_type_list[$type_id];
    }

    if(isset($_POST['measurement_type'])) {
        $measurement_type = $_POST['measurement_type'];
    }

    if(isset($_POST['description'])) {
        $description = $_POST['description'];
    }

    if(isset($_POST['instructions'])) {
    $instructions = $_POST['instructions'];
    }

    if(isset($_POST['features'])) {
        $features = $_POST['features'];
    }
    $method->update_method($name, $type_name, $type_id, $measurement_type, $description, $instructions);

    $method->edit_features($features);

echo ("Method $name edited successfully.<BR>");
}

if(isset($_POST['add_method_type_submit'])) {
    $method_data_name = $_POST['method_data_name'];
    $method_data_type = $_POST['method_data_type'];
    $method_id = $_POST['id'];
    
    $result = methoddata::add_method_data($db, $method_id, $method_data_name, $method_data_type);
    if($result) {
        echo("Method Data $method_data_name edited successfully.<BR>");
    }
    
}


echo(''
        . '<form action="edit_method.php" method="post" id="registration">

<div id="registerform">
<fieldset style="border: solid 2px #cc0000;overflow: hidden;" class="roundedborder">

<fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend>Edit Method</legend>
<label class="label" for="mID">Method name</label>
<input type="hidden" name="id" value="'.$id.'">
<input id="method_name" type="text" name="method_name" size="100" maxlength="100" value="'.$name.'">

<BR>
<label class="label" for="method_name">Method type</label>');


echo('<select name="method_type" id="method_type">
    
    <option value="" selected="selected" disabled="disabled">Method Type</option>');

foreach($method_type_list as $id=>$name) {
    echo("<option value='".$id."' ".(($type_id == $id)?" selected ": "").">".$name."</option>");
}
echo("</select>");


echo('
    <BR>
<label class="label" for="mID">Measurement Type</label>
<input id="measurement_type" type="text" name="measurement_type" size="100" maxlength="100" value="'.$measurement_type.'">
<BR>
<label class="label" for="description">Description</label>
<input id="description" type="text" name="description" size="100" maxlength="100" value="'.$description.'">
<BR>
<label class="label" for="mID">Instruction</label>
<input id="instructions" type="text" name="instructions" size="100" maxlength="100" value="'.$instructions.'">
        ');
        
echo('<BR></fieldset><BR>');

// Features

echo('<fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend>Features (hold CTL to select multiple)</legend>');

echo('<select name="features[]" size="5" multiple="multiple">');

$query = "SELECT * from feature";
$result = mysqli_query($dbcon, $query);

foreach($result as $feature) {
    echo("<option value='".$feature['id'] . "' ".
            (in_array($feature['id'], $features) ? " SELECTED ": "" ) .
            ">".$feature['name'].
            "</option>");
}
echo("</select>");
echo("<BR></fieldset>");

echo('<BR>'
        . '<input name="edit_method_submit" id="edit_method_submit" type="submit" value="Edit"/><BR>
   </div></form>');

// Method data

echo('<form action="edit_method.php" method="post" id="registration">

<div id="registerform">
<fieldset style="border: solid 2px #cc0000;overflow: hidden;" class="roundedborder">');

echo('<fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend>Method Data</legend>');
$method_data = $method->get_method_data();
if(count($method_data) > 0) {
echo("<table id='hortable'>");

echo("<TR><TD>Name</TD><TD>Type</TD></TR>");

foreach($method_data as $method_datum) {
    echo("<TR>");
    echo("<TD>".$method_datum->get_name()."</TD>");
    echo("<TD>".$method_datum->get_type()."</TD>");
    echo("</TR>");
}
echo("</table>");
} 

echo("");
echo('
    <input name="id" id="id" type="hidden" value="'.$method->get_id().'">
        <BR><label class="label"><U>Edit method data:</U></label><BR>
<label class="label" for="mID">Method Data Name</label>
<input id="method_data_name" type="text" name="method_data_name" size="100" maxlength="100" ><BR>
        <label class="label" for="mID">Method Data Type</label>
<input id="method_data_type" type="text" name="method_data_type" size="100" maxlength="100"><BR>
        ');
echo('<BR>'
        . '<input name="add_method_type_submit" id="edit_method_submit" type="submit" value="Add Method Type"/><BR>
   </div></form>');
echo("<BR></fieldset>");


echo('</fieldset>');
}

require_once "../../include/footer.php";

?>