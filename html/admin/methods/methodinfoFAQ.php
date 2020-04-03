<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once "../../include/header_admin.php";

?>
<div id='memberregion'> <h1 style='text-align:center'>Method FAQ</h1>
    
This is a guide for adding new methods, along with method infos and options.
<BR><BR>
Method Info Types:<BR>

<ul>
    <li><a href='#multiselect'>multiselect</a></li>
    <li><a href='#singleselect'>singleselect</a></li>
    <li><a href='#select_each'>select_each</a></li>
    <li><a href='#numeric_entry'>numeric_entry</a></li>
    <li><a href='#text_entry'>text_entry</a></li>
    <li><a href='#user_input_with_dropdown'>user_input_with_dropdown</a></li>
    <li><a href='#text_area'>text_area</a></li>
    <li><a href='#category'>category</a></li>
    <li><a href='#estimated_outcome'>estimated_outcome</a></li>
    <li><a href='#two_column'>two_column</a></li>
    <li><a href='#checkbox_select'>checkbox_select</a></li>
    <li><a href='#left_right'>checkbox_select</a></li>
</ul>

<BR><BR>
<a name='multiselect'></a>
<h1>multiselect</h1>
<img src='../../images/faq/multiselect.png'><BR>
<img src='../../images/faq/multiselect-annotated.png'><BR>
<B>Multiselect</B> is used to select from a number of choices, where multiple entries can be selected at the same time. Users can hold "Ctl" to select multiple options on Windows, or "Command" on a Mac. <BR>
<BR>
To create the above example,<BR><BR>
<B>Method info name:</B> "Phase/Stage"<BR>
<B>Method info type:</B>  multiselect<BR>
<B>Header:</B>  "Phase/Stage" - This corresponds to the bold and underlined text above the options.<BR>
<B>Option header:</B>  (not used)<BR>
<BR>
Once the method info has been created, you can add method info options to it to create the select options.
To create the above example you would add the following method info options:
<BR>
V<BR>
VII<BR>
VIII<BR>
<hr>

<a name='singleselect'></a>
<h1>singleselect</h1>
<img src='../../images/faq/singleselect.png'><BR>
<img src='../../images/faq/singleselect-annotated.png'><BR>
<B>Singleselect</B> is used to select from a number of choices, but only one selected option is allowed. It is drawn as a drop-down selection box. <BR>
<BR>
To create the above example,<BR><BR>
<B>Method info name:</B> "Fibula Max length formula"<BR>
<B>Method info type:</B>  singleselect<BR>
<B>Header:</B>  "Bone measurement selection for formula" - This corresponds to the bold and underlined text above the options.<BR>
<B>Option header:</B>  (not used)<BR>
<BR>
Once the method info has been created, you can add method info options to it to create the select options.
To create the above example you would add the following method info options:
<BR>
Caucasian (3.78 Fibula Max L) + 30.15 +/- 4.06<BR>
All Ancestry (3.59 Fibula Max L) + 36.31 +/- 4.10<BR>

<HR>

<a name='select_each'></a>
<h1>select_each</h1>
<img src='../../images/faq/select_each.png'><BR>
<img src='../../images/faq/select_each-annotated.png'><BR>
Select_each is a multiselect box that also has a description displayed before it. Both the description and options box have header titles.<BR>
To create the above example:
<B>Method info name:</B>Nuchal crest<BR>
<B>Method info type</B>select_each<BR>
<B>Header:</B>Feature<BR>
<B>Option header:</B>Score<BR>
<BR>
Once the method info has been created, you can add method info options to it to create the select options.
To create the above example you would add the following method info options:
<BR>
-2<BR>
-1<BR>
0<BR>
1<BR>
2<BR>

<HR>

<a name='numeric_entry'></a>
<h1>numeric_entry</h1>
<img src='../../images/faq/numeric_entry.png'><BR> 
<img src='../../images/faq/numeric_entry-annotated.png'><BR> 
Numeric_entry is a text box that only accepts numeric values. Attempts to enter non-numeric entries will result in an error. The input allows up to 2 decimal places.<BR>
To create the above example:
<B>Method info name:</B>biauricular breadth (mm)<BR>
<B>Method info type</B>numeric_entry<BR>
<B>Header:</B>(not used)<BR>
<B>Option header:</B>(not used)<BR>
<BR>
A default method info option is automatically added. It is the only one that is needed.

<HR>

<a name='text_entry'></a>
<h1>text_entry</h1>
<img src='../../images/faq/text_entry.png'><BR> 
<img src='../../images/faq/text_entry-annotated.png'><BR> 
Text_entry is a text box that allows brief user input. It is a single line text entry box, though the text entered can be much longer.<BR>
To create the above example:<BR>
<B>Method info name:</B>Cultural Profile<BR>
<B>Method info type</B>numeric_entry<BR>
<B>Header:</B>(not used)<BR>
<B>Option header:</B>(not used)<BR>
<BR>
A default method info option is automatically added. It is the only one that is needed.<BR>

<HR>

<a name='text_area'></a>
<h1>text_entry</h1>
<img src='../../images/faq/text_area.png'><BR> 
Text_entry is a text box that allows brief user input. It is a larger text box, intended for longer text entries.<BR>
To create the above example:<BR>
<B>Method info name:</B>Notes<BR>
<B>Method info type</B>text_area<BR>
<B>Header:</B>(not used)<BR>
<B>Option header:</B>(not used)<BR>
<BR>
A default method info option is automatically added. It is the only one that is needed.<BR>

<HR>

<a name='user_input_with_dropdown'></a>
<h1>user_input_with_dropdown</h1>
<img src='../../images/faq/user_input_with_dropdown.png'><BR>   
User_input_with_dropdown is a more complicated input type. It is actually a parent type to two separate inputs that are related: a numeric_entry, and a multiselect.
The user_input_with_dropdown type is used in methods such as Spradley & Jantz (2011).
<BR>
To create the above example, you would create 3 separate method infos:
<BR>
1.)<BR>
<B>Method info name:</B>Clavicle Maximum Length (mm)<BR>
<B>Method info type</B>user_input_with_dropdown<BR>
<B>Header:</B>(not used)<BR>
<B>Option header:</B>(not used)<BR>
<HR>

<a name='category'></a>
<h1>category</h1>
<img src='../../images/faq/category_1.png'><BR>
The category method info type typically acts as a header to group other method infos. For example , in Spradley_Jantz type methods, 
Categories are used to define the drop-down box listings as well as the box headers. 
To create the above example, it would need to be in a Spradley_Jantz type method, and you could add the following method infos:<BR><BR>
<B>Method info name:</B>Upper Appendicular<BR>
<B>Method info type</B>category<BR>
<B>Header:</B>Skeletal Region<BR>
<B>Option header:</B>(not used)<BR>
<BR>
<B>Method info name:</B>Pelvis<BR>
<B>Method info type</B>category<BR>
<B>Header:</B>Skeletal Region<BR>
<B>Option header:</B>(not used)<BR>
<BR>
<B>Method info name:</B>Lower Limb<BR>
<B>Method info type</B>category<BR>
<B>Header:</B>Skeletal Region<BR>
<B>Option header:</B>(not used)<BR>
<BR>
<B>Method info name:</B>Skull<BR>
<B>Method info type</B>category<BR>
<B>Header:</B>Skeletal Region<BR>
<B>Option header:</B>(not used)<BR>
<BR>
The Spradley_Jantz also contains boxes with headers to group method infos. These are categories whose parent is the option from the dropdown menu. For example, in this illustration:
<img src='../../images/faq/category_2.png'><BR>
The "Clavicle" box would be created by adding a method info with the following parameters:<BR>
<B>Method info name:</B>Clavicle<BR>
<B>Method info type</B>category<BR>
<B>Header:</B>Clavicle <i>(optional)</i><BR>
<B>Option header:</B>(not used)<BR>
<B>Parent:</B>: Upper Appendicular<BR>
<BR>
When creating each method info within the "Clavicle" box, they would need to have the "Clavicle" method info listed as their parent.
<BR>



<HR>

<a name='estimated_outcome'></a>
<h1>estimated_outcome</h1>
<img src='../../images/faq/estimated_outcome.png'><BR>     
"Estimated Outcome" is a method info specific to Ancestry methods. The other types either use a minumum and maximun numeric quantity, or a fixed set of options ("Male", "Female", etc.),
but the estimated outcome for an Ancestry method may vary depending on the method. It looks and acts just like a multiselect type.<BR>
To create the above example:<BR>
<B>Method info name:</B>Estimated Outcome <i>(optional. It is listed in the database, but not shown on screen.)</i><BR>
<B>Method info type</B>estimated_outcome<BR>
<B>Header:</B>(not used)<BR>
<B>Option header:</B>(not used)<BR>
<BR>
Then, create the following method info options:

African American<BR>
European American<BR>



<HR>

<a name='two-column'></a>
<h1>two-column</h1>
<img src='../../images/faq/two-column.png'><BR>            
A two_column method info is shorthand for two separate multiselect boxes. It is typically used for two items which are closely related,
and so the two boxes are diplayed together.
<HR>
To create the above example:<BR>
<B>Method info name:</B>Phase/Stage<BR>
<B>Method info type</B>two-column<BR>
<B>Header:</B>Phase/StageBR>
<B>Option header:</B>(not used)<BR>
<BR>
Then, to the method info that is created, add the following method info options:
<BR>
0<BR>
1<BR>
2<BR>
3<BR>
<BR>Then create the second column.
<B>Method info name:</B>Reference Sample<BR>
<B>Method info type</B>two-column<BR>
<B>Header:</B>Reference Sample<BR>
<B>Option header:</B>(not used)<BR>
<BR>
Then, to the method info that is created, add the following method info options:
<BR>
Male<BR>
Female<BR>


<a name='checkbox_select'></a>
<h1>checkbox_select</h1>
<img src='../../images/faq/checkbox_select.png'><BR> 
"Checkbox select" is similar in functionality to a multiple select, but with the compact display of a singleselect.
Clicking on the entry opens a dropdown menu of checkboxes to select from. This method info has been used in <a href="methodFAQ.php#Rios_Cardoso"
<a name='left_right'></a>
<h1>left_right</h1>

</div>

<?php
require_once "../../include/footer.php";
?>