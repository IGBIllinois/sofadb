<?php
$title = "Prompts";
require_once "../../include/header_admin.php";


if(isset($_POST['add_prompt'])) {
    $prompt_name = $_POST['prompt_name'];
    $prompt_text = $_POST['prompt_text'];
    
    $result = method::add_new_prompt($db, $prompt_name, $prompt_text);
    
    echo($result['MESSAGE']);
    
    
}

$prompt_list = method::get_all_prompts($db);

echo('<fieldset style="border: solid 1px #000000;overflow: hidden;" class="roundedborder"><legend>Add Prompt</legend>');
echo("<B><U>Current prompts</U></B>");
echo("<table style='border:1px solid black'>");
foreach($prompt_list as $id=>$prompt) {
    if($prompt == null || $prompt == "") {
        $prompt = "<I>(No prompt)</I>";
    }
    echo(" <tr><td class='bordered td_spaced' > ".$prompt."</td></tr>");
}
echo("</table>");
echo("<BR><BR>");

echo("<B><U>Add a new prompt</U></B><BR>");
echo("Please enter a name for the new prompt, and its text. This prompt will be available to use for other methods as well.<BR>");
echo("<form method=POST action='prompts.php' >");
 
echo('<label class="label" for="caseyear">Prompt Name</label>');
    

echo('<input id="prompt_name" type="text" name="prompt_name" size="100" maxlength="100">');

echo("<BR>");

echo('<label class="label" for="caseyear">Prompt Text</label>');
echo('<input id="prompt_text" type="text" name="prompt_text" size="100" maxlength="100">');

echo("<BR>");
echo('<input name="add_prompt" id="add_prompt" type="submit" value="Add Prompt"/><BR><BR>');
echo("</fieldset>");

require_once "../../include/footer.php";

?>