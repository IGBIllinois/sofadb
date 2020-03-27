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
        $method_info_type = $method->get_method_info_type();
        $prompt_id = $method->get_prompt_id();
        $active = $method->get_active();
        $top = $method->get_top();
        $fdb = $method->get_fdb();

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
    
    if(isset($_POST['prompt'])) {
        $prompt_id = $_POST['prompt'];
    }
    
    if(isset($_POST['active'])) {
        $active = $_POST['active'];
    } else {
        $active = 0;
    }
    
    if(isset($_POST['fdb'])) {
        $fdb = $_POST['fdb'];
    } else {
        $fdb = 0;
    }

    if(isset($_POST['top'])) {
        $top = $_POST['top'];
    } else {
        $top = 0;
    }

    $method->update_method($name, 
            $type_id, 
            $measurement_type, 
            $description, 
            $instructions, 
            $method_info_type, 
            $prompt_id, 
            $fdb,
            $top,
            $active);
    


echo ("Method $name edited successfully.<BR>");
}

if(isset($_POST['add_method_info_submit'])) {

    $methodid = $method->get_id();
    $method_info_name = $_POST['method_info_name'];
    $header = $_POST['method_info_header'];
    $option_header = $_POST['method_info_option_header'];
    $input_type = $_POST['input_type'];
    $parent = $_POST['parent'];
    if($parent < 0) {
        $parent = null;
    }
    $result = $method->add_method_info($method_info_name, $header, $option_header, $input_type, $parent);
    if($result > 0) {
            echo("Added method info $method_info_name.<BR>");
    }
}

if(isset($_POST['add_method_info_option_submit'])) {

    $method_info_id = $_POST['method_info_id'];
    $value = $_POST['method_info_option_value'];
    $method_info = new method_infos($db, $method_info_id);
    $result = $method_info->add_option($value);
    if($result > 0) {
            echo("Added method info option to ".$method_info->get_name() . " with value: $value.<BR>");
    }
}

if(isset($_POST['delete_option'])) {

    $info_id = $_POST['info_id'];
    $option_id = $_POST['option_id'];

    $method_info = new method_infos($db, $info_id);
    $option = new method_info_option($db, $option_id);
    $op_name = $option->get_value();
    $result = $method_info->delete_option($option_id);
    if($result > 0) {
            echo("Deleted option $name.<BR>");
    }
}

if(isset($_POST['delete_method_info'])) {

    $method_info_id = $_POST['info_id'];

    $result = $method->delete_method_info($method_info_id);
    
    if($result > 0) {
            echo("Deleted option $name.<BR>");
    }
}

echo(''
        . '<form action="edit_method.php?id='.$id.'" method="post" id="registration">


<fieldset style="border: solid 2px #cc0000;overflow: hidden;" class="roundedborder">

<fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend>Edit Method</legend>
<label class="label" for="mID">Method name</label>
<input type="hidden" name="id" value="'.$id.'">
<input id="method_name" type="text" name="method_name" size="100" maxlength="100" value="'.$name.'">

<BR>
<label class="label" for="method_name">Method type</label>');


echo('<select name="method_type" id="method_type">
    
    <option value="" selected="selected" disabled="disabled">Method Type</option>');

foreach($method_type_list as $t_id=>$name) {
    echo("<option value='".$t_id."' ".(($type_id == $t_id)?" selected ": "").">".$name."</option>");
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
echo('
<BR>
<label class="label" for="prompt">Method prompt (optional additional text)</label>');

echo('<select name="prompt" id="prompt">
    
    <option value="" selected="selected" disabled="disabled">Prompt</option>');
$prompts = method::get_all_prompts($db);
foreach($prompts as $pid=>$prompt) {

    echo("<option value='".$pid."'".(($pid == $prompt_id)  ? " selected " : "")." >".$prompt."</option>");
}
echo("</select>");
echo(" (<a href='prompts.php' target='blank'>Add a new prompt</a>)<BR>");
echo("<BR>");

echo("<label class='label' for='fdb'>FDB sharing method?</label><input style='vertical-align: middle'  type='checkbox' name='fdb' value='1'". ($fdb ? " checked " : "") ." />");
echo("<BR><BR>");
echo("<label class='label' for='top'>Should this method be shown at the top when listing methods?</label><input type='checkbox' name='top' value='1'". ($top ? " checked " : "") ." />");
echo("<BR><BR>");


echo('<label class="label" for="active">Is this method active?</label>');
echo("<input name='active' id='active' type='checkbox' value=1". ($active ? " checked " : "") .">");

echo('<BR><BR>
    <label class="label"><input name="edit_method_submit" id="edit_method_submit" type="submit" value="Edit"/></label><BR><BR>
    </fieldset>
   </form>');

// Add new method infos
echo('<fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend>Add new Method Info</legend>');
echo("<a href='methodinfoFAQ.php'>New method FAQ</A><BR>");
echo('<form action="edit_method.php?id='.$id.'" method="post" id="add_method_info">');
echo('<input type="hidden" name="id" value="'.$id.'">');
echo('<label class="label" for="method_info_name">Method info name</label>');
echo("<input type=text id='method_info_name' name='method_info_name'>");
echo("<BR>");
echo('<label class="label" for="input_type">Input type</label>');
echo("<select name='input_type' id='input_type'>");
$input_types = input_type::get_input_types($db);
foreach($input_types as $type) {
    echo("<option value = '".$type->get_id()."' id='".$type->get_id()."'>".$type->get_input_type()."</option>");
}
echo("</select>");
echo("<BR>");
echo('<label class="label" for="method_info_header">Header</label>');
echo("<input type=text id='method_info_header' name='method_info_header'>");
echo("<BR>");
echo('<label class="label" for="method_info_option_header">Option header</label>');
echo("<input type=text id='method_info_option_header' name='method_info_option_header'>");
echo("<BR>");
echo('<label class="label" for="parent">Parent (needed for certain method info types)</label>');
echo("<select name='parent' id='parent'>");
$tmp_method_infos = $method->get_method_infos();
echo("<option value = '-1' id='-1'>Parent (optional)</option>");
foreach($tmp_method_infos as $method_info) {
    $type = (new input_type($db, $method_info->get_type()))->get_input_type();
    echo("<option value = '".$method_info->get_id()."' id='".$method_info->get_id()."'>".$method_info->get_name()." (".$type.")".  "</option>");
}
echo("</select>");
echo("<BR><BR>");

echo('<label class="label"><input name="add_method_info_submit" id="add_method_info_submit" type="submit" value="Add Method Info"/></label><BR><BR>');
echo("</fieldset></form>");

// Method infos

echo('<fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend>Method Info</legend>');
$method_infos = $method->get_method_infos();

if(count($method_infos) > 0) {
echo("<table id='hortable'>");

echo("<TR><TD>Name</TD><TD>Type</TD><TD>Options</td><TD>Add option</td></TR>");

foreach($method_infos as $method_info) {
    echo("<TR>");
    echo("<TD>".$method_info->get_name());
    echo('<form action="./edit_method.php?id='.$id.'" method="post" id="delete_method_info" onsubmit="return confirm(\'Do you really want to delete this method info?\')">
          <input name="info_id" type="hidden" value="'.$method_info->get_id().'"/>
          <input name="id" type="hidden" value="'.$method->get_id().'"/>
	<input name="delete_method_info" type="submit" value="Delete Method Info" /> </form>');
    echo("</TD>");
    $type = new input_type($db, $method_info->get_type());
    echo("<TD>".$type->get_input_type()."</TD>");
    echo("<TD>");
      $options = $method_info->get_method_info_options();
      foreach($options as $option) {
          echo("<table ><tr class=''><td class=''>");
          echo($option->get_value());
          echo("</td><td class=''>");
          echo('<form action="./edit_method.php?id='.$id.'" method="post" id="delete_option" onsubmit="return confirm(\'Do you really want to delete this option?\')">
          <input name="option_id" type="hidden" value="'.$option->get_id().'"/>
          <input name="info_id" type="hidden" value="'.$method_info->get_id().'"/>
          <input name="id" type="hidden" value="'.$method->get_id().'"/>
	<input name="delete_option" type="submit" value="Delete Option" /> </form>');
          echo("</td></table>");
          echo("<BR>");
      }
      echo("<td>");
      echo('<form action="edit_method.php?id='.$id.'" method="post" id="add_option">');
      echo("<input type='hidden' name=method_info_id value='".$method_info->get_id()."'>");
      echo("<BR>");
      echo('Option value:');
      echo("<input type=text id='method_info_option_value' name='method_info_option_value'>");
      echo('<input name="add_method_info_option_submit" id="add_method_info_option_submit" type="submit" value="Add Option"/><BR><BR>');
      echo("</form>");
      echo("</td>");
    echo("</TD>");
    echo("</TR>");
}
echo("</table>");
} 

echo("<BR></fieldset>");

// Preview 

echo('<fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend>Preview</legend>');

echo(method_infos::show_method_info($db, $method->get_id()));
echo("<BR>");
echo("</fieldset>");
echo("<BR>");
}

require_once "../../include/footer.php";

?>