<?php

/** Allows an Admin to add, or edit prompts available for methods
 *  Prompts are additional text for methods that help describe methods and their inputs
 */

$title = "Forensic Anthropology Case Database (FADAMA) - Prompts";
require_once "../../include/header_admin.php";


if(isset($_POST['add_prompt'])) {
    // Add a new prompt
    $errors = array();
    
    if(!isset($_POST['prompt_name']) || $_POST['prompt_name'] == "") {
        $errors[] = "Please enter a prompt name.";
    } else {
        $prompt_name = $_POST['prompt_name'];
    }
    if(!isset($_POST['prompt_text']) || $_POST['prompt_text'] == "") {
        $errors[] = "Please enter text for the prompt.";
    } else {
        $prompt_text = $_POST['prompt_text'];
    }

    if(count($errors) > 0) {
        echo("Error:<BR>");
        foreach($errors as $error)  {
            echo($error . "<BR>");
        }
    } else {
        $result = method::add_new_prompt($db, $prompt_name, $prompt_text);

        echo($result['MESSAGE']);
    }
    
}


if(isset($_POST['delete_prompt'])) {
    
    if(!isset($_POST['del_prompt_id'])) {
        echo("Please select a prompt to delete.");
    } else {
        // Delete prompt
    
    $prompt_id = $_POST['del_prompt_id'];
    
    $result = method::delete_prompt($db, $prompt_id);
    
    echo($result['MESSAGE']);
    
    }
}

$prompt_list = method::get_all_prompts($db);

echo('<fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend>Add Prompt</legend>');
echo("<B><U>Current prompts</U></B>");
echo("<table style='border:1px solid black'>");
foreach($prompt_list as $id=>$prompt) {
    if($prompt == null || $prompt == "") {
        $prompt = "<I>(No prompt)</I>";
    }
    echo(" <tr><td class='bordered td_spaced' > ".$prompt."</td>");
    echo('
	<td class="bordered td_spaced"><form action="prompts.php" method="post" id="delete_prompt" onsubmit="return confirm(\'Do you really want to delete this prompt?\nAll methods using this prompt will have their prompt set to the default.\')">
	<input name="del_prompt_id" type="hidden" value="'.$id.'"/>
	<input id="delete_prompt" name="delete_prompt" type="submit" value="Delete" /> </form>');
}
echo("</table>");
echo("<BR><BR>");

echo("<B><U>Add a new prompt</U></B><BR>");
echo("Please enter a name for the new prompt, and its text. This prompt will be available to use for other methods as well.<BR>");
echo("<form method=POST action='prompts.php' name='promptform'>");
 
echo('<label class="label" for="caseyear">Prompt Name</label>');
    

echo('<input id="prompt_name" type="text" name="prompt_name" size="100">');

echo("<BR>");

echo('<label class="label" for="caseyear">Prompt Text</label>');
echo('<input id="prompt_text" type="text" name="prompt_text" size="100">');

echo("<BR>");
echo('<input name="add_prompt" id="add_prompt" type="submit" value="Add Prompt"/><BR><BR>');
echo("</fieldset>");
echo("</form>");
echo('
<script language="JavaScript" type="text/javascript"
    xml:space="preserve">
        var frmvalidator  = new Validator("promptform");
        frmvalidator.addValidation("prompt_name","req","Please enter a prompt name.");
        frmvalidator.addValidation("prompt_text","req","Please enter text for the prompt.");
</script>');

require_once "../../include/footer.php";

?>