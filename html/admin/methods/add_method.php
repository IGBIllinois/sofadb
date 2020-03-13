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
$prompt = null;

$method_type_list = array(METHOD_DATA_SEX_ID=>METHOD_DATA_SEX, 
    METHOD_DATA_AGE_ID=>METHOD_DATA_AGE,
    METHOD_DATA_ANCESTRY_ID=>METHOD_DATA_ANCESTRY, 
    METHOD_DATA_STATURE_ID=>METHOD_DATA_STATURE);

$errors = array();

if(isset($_POST['method_name']) && $_POST['method_name'] != '') {
    $name = $_POST['method_name'];
} else {
    $errors[] = "Please input a Method Name.";
}

if(isset($_POST['method_type'])) {
    $type_id = $_POST['method_type'];
    
} else {
    $errors[] = "Please select a Method Type. (Sex, Age, etc.)";
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

if(isset($_POST['method_info_type'])) {
$method_info_type = $_POST['method_info_type'];
echo("METHODINFOTYPE = $method_info_type<BR>");
}

if(isset($_POST['prompt'])) {
$prompt = $_POST['prompt'];
}

if(isset($_POST['add_method_submit'])) {
    if(count($errors) == 0) {
        $result = method::create_method($db, $name, $type_id, $measurement_type, $description, $instructions, $method_info_type, $prompt);

        if($result['RESULT'] == TRUE) {
            $id = $result['id'];
        
            if($id > 0) {
                $method = new method($db, $id);
                echo($result['MESSAGE']);
                $new_id = $result['id'];
                echo("Its status is currently Inactve. You may edit and activate it on the <a href='edit_method.php?id=$id'>edit method</a> page.");

            }
        } else {
            echo($result['MESSAGE']);
        }
    } else {
        foreach($errors as $error) {
            echo($error ."<BR>");
        }
    }
}



echo(''
        . '<form action="add_method.php" method="post" id="registration">


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
<label class="label" for="mID">Method info type (used to display certain types of methods)</label>');

echo('<select name="method_info_type" id="method_info_type">
    
    <option value="" selected="selected" disabled="disabled">Method Info Type</option>');
$method_info_types = method_info_type::get_method_info_types($db);
foreach($method_info_types as $type) {
    $id = $type->get_id();
    $name = $type->get_method_info_type();
    echo("<option value='".$name."' ".(($method_info_type_id == $id)?" selected ": "").">".$name."</option>");
}
echo("</select>");
echo(" <a href='methodFAQ.php' target='blank'>(More info on Method Info Types)</A>");
echo('
    <BR>
<label class="label" for="mID">Measurement Type</label>
<input id="measurement_type" type="text" name="measurement_type" size="100" maxlength="100" value="'.$measurement_type.'">
<BR>
<label class="label" for="mID">Description</label>
<input id="description" type="text" name="description" size="100" maxlength="100" value="'.$description.'">
<BR>
<label class="label" for="instructions">Instruction</label>
<input id="instructions" type="text" name="instructions" size="100" maxlength="100" value="'.$instructions.'">
        ');
        

echo('
<BR>
<label class="label" for="prompt">Method prompt (optional additional text)</label>');

echo('<select name="prompt" id="prompt">
    
    <option value="" selected="selected" disabled="disabled">Prompt</option>');
$prompts = method::get_all_prompts($db);
foreach($prompts as $id=>$prompt) {

    echo("<option value='".$id."' >".$prompt."</option>");
}
echo("</select>");

echo('<BR><BR></fieldset><BR>');


echo('<input name="add_method_submit" id="add_method_submit" type="submit" value="Add"/><BR><BR>');
echo('<div id="registration_errorloc" class="errorlocation">
            </div></form>
            </fieldset>');
echo("</fieldset>");

require_once "../../include/footer.php";

?>