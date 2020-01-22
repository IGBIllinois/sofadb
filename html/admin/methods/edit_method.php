<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once "../../include/header_admin.php";


$name = null;
$type_id = null;
$measurement_type=null;
$description = null;
$instructions = null;
$features = null;

$method_type_list = array(METHOD_DATA_SEX_ID=>METHOD_DATA_SEX, 
    METHOD_DATA_AGE_ID=>METHOD_DATA_AGE,
    METHOD_DATA_ANCESTRY_ID=>METHOD_DATA_ANCESTRY, 
    METHOD_DATA_STATURE_ID=>METHOD_DATA_STATURE);

if(!isset($_POST['id']) &&  !isset($_GET['id'])) {
    echo("Please enter a valid method.");
} else {
    if(isset($_GET['id'])) {
        // showing form for first time
        $id = $_GET['id'];
        $method = new method($db, $id);
        
        $name = $method->get_name();
        $type_id = $method->get_method_type_num();
        $measurement_type = $method->get_measurement_type();
        $description = $method->get_description();
        $instructions = $method->get_instructions();

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

    $method->update_method($name, $type_name, $type_id, $measurement_type, $description, $instructions);


echo ("Method $name edited successfully.<BR>");
}


echo(''
        . '<form action="edit_method.php" method="post" id="registration">


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
        
echo('<BR><BR>
    <label class="label"><input name="edit_method_submit" id="edit_method_submit" type="submit" value="Edit"/></label><BR><BR>
    </fieldset>
   </form>');



// Method infos

echo('<form action="edit_method.php" method="post" id="registration">');

echo('<fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend>Method Info</legend>');
$method_infos = $method->get_method_infos();

if(count($method_infos) > 0) {
echo("<table id='hortable'>");

echo("<TR><TD>Name</TD><TD>Type</TD><TD>Options</td></TR>");

foreach($method_infos as $method_info) {
    echo("<TR>");
    echo("<TD>".$method_info->get_name()."</TD>");
    $type = new input_type($db, $method_info->get_type());
    echo("<TD>".$type->get_input_type()."</TD>");
    echo("<TD>");
      $options = $method_info->get_method_info_options();
      foreach($options as $option) {
          echo($option->get_value()."<BR>");
      }
    echo("</TD>");
    echo("</TR>");
}
echo("</table>");
} 


echo('</form>');

echo("<BR></fieldset>");





}

require_once "../../include/footer.php";

?>