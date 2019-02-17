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
if(isset($_POST['add_method_submit'])) {

$id = method::create_method($db, $name, $type_name, $type_id, $measurement_type, $description, $instructions);

if($id > 0) {
$method = new method($db, $id);

if(count($features) > 0) {
    $method->add_features($features);
}
echo ("Method $name created successfully.<BR>");
}
}

echo(''
        . '<form action="add_method.php" method="post" id="registration">

<div id="registerform">
<fieldset style="border: solid 2px #cc0000;overflow: hidden;" class="roundedborder">

<fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend>Add Method</legend>
<label class="label" for="mID">Method name</label>

<input id="mID" type="text" name="method_name" size="100" maxlength="100" value="'.$name.'">

<BR>
<label class="label" for="mID">Method type</label>');


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
<label class="label" for="mID">Description</label>
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
    echo("<option value='".$feature['id']."'>".$feature['name']."</option>");
}
echo("</select>");
echo("<BR></fieldset>");



echo('<BR>'
        . '<input name="add_method_submit" id="add_method_submit" type="submit" value="Add"/><BR>
   <div id="registration_errorloc" class="errorlocation">
            </div></form>
            </fieldset>');


require_once "../../include/footer.php";

?>