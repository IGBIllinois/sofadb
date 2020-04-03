<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once "../../include/header_admin.php";

?>
<div id='memberregion'> <h1 style='text-align:center'>Method FAQ</h1>
    
This is a guide for adding certain method types. Some types require a specific way of displaying method infos.
<BR><BR>
Method Info Types:<BR>

<ul>
    <li><a href='#spradley_jantz'>Spradley_Jantz</a></li>
    <li><a href='#stature_1'>Stature_1</a></li>
    <li><a href='#rios_cardoso'>Rios_cardoso</a></li>
    <li><a href='#rhine'>Rhine</a></li>
    <li><a href='#3_col_w_ref'>3_col_w-ref</a></li>
    <li><a href='#user_input_with_dropdown'>user_input_with_dropdown</a></li>

</ul>

<BR><BR>
<a name='spradley_jantz'></a>
<h1>Spradley_Jantz</h1>
<img src='../../images/faq/spradley_jantz.png'><BR>

<B>Spradley_Jantz</B> is a type consisting of several parts. The first is a dropdown list of main categories. When a category is selected, it then displays a number of boxes, each with a header label.
In each of those boxes are a number of method infos, of type '<a href='methodinfoFAQ.php#user_input_with_dropdown' target='blank'>user_input_with_dropdown</a>' and '<a href='methodinfoFAQ.php#select_each' target='blank'>select_each</a>'.<BR>
<BR>
1.) For the above example, you'd need to create a Spradley_Jantz type method. In that method, first create a method info of type 'category' named 'Upper Appendicular'.<BR>
2.) Then, create another category named 'Clavicle' whose parent is 'Upper Appendicular'.<BR>
3.) Then you can create method infos of type 'user_input_with_dropdown' for the inputs like 'Clavicle maximum length (mm)', and method infos of type 'select_each' for the inputs like 'Clavicle DFA (American White)'.<BR>
<hr>

<a name='stature_1'></a>
<h1>Stature_1</h1>

<B>Stature_1</B> is used to display most of the Stature methods. It displays the numeric_inputs first, then the singleselect inputs, in a vertical format. <BR>
<BR>
To create the above example,<BR><BR>


<HR>

<a name='rios_cardoso'></a>
<h1>Rios_Cardoso</h1>
<img src='../../images/faq/Rios_Cardoso.png'><BR>
Rios_Cardoso displays a series of singleselect dropdown boxes laid out in rows and columns. The row headers are categories, and each column header is a category whose parent is the row name.<BR>
To create the above example:
1.) Create a category with the name '1' and header 'Rib #'.<BR>
2.) Create a category with the name and header 'Head Ephiphyseal Union' whose parent is the previous method info ('1')<BR>
3.) Create a checkbox_dropdown type whose parent is the 'Head Ephiphyseal Union' you just created, and add method info options 'Stage 1, female', 'stage 2, female', etc.<BR>
4.) For the second column, create a category with the name and header 'Articular Tubercle Union' whose parent is the first method info ('1')<BR>
5.) Create another checkbox_dropdown type whose parent is the 'Articular Tubercle Union' you just created, and add method info options 'Stage 1, female', 'stage 2, female', etc.<BR>

6.) For the second row, create a category like you did in Step 1, with the name '1' and header 'Rib #'.<BR>
7.) Create another category like you did in Step 2, with header 'Head Ephiphyseal Union' whose parent is the previous method info ('2')<BR>
8.) Create a checkbox_dropdown type whose parent is the 'Head Ephiphyseal Union' you just created in Step 7, and add method info options 'Stage 1, female', 'stage 2, female', etc.<BR>

9.) Repeat the process for all rows and columns. You can omit a column category for a row, and it will be left blank. (For example, Row 9 in Rios & Cardoso has no 'Nonarticular Tubercle Union' entry.)
<HR>

<a name='Rhine'></a>
<h1>rhine</h1>

The Rhine method type is similar to the Spradley_Jantz type, but contains no initial drop-down menu for initial selection.

<HR>

<a name='3_col_w_ref'></a>
<h1>3_col_w_ref</h1>
<img src='../../images/faq/3_col_w_ref.png'><BR> 
3_col_w_ref is displayed as 3 columns with references and is used in Epiphyseal Union methods.<BR>
To create the above example:<BR>
1.) Create a method info of type 'category' with the name 'Humerus' and the header 'Bone'.<BR>
2.) Create a method info of type 'singleselect' with the name 'Composite distal epiphysis to shaft', the header 'Site', and the option_header 'Fusion'.
3.) Repeat Step 2 to create method singleselect method infos with names 'Medial epicondyle to shaft' and 'Proximal epiphysis to shaft'. When creating them, the header will still be 'Site' and the option header will still be 'Fusion' for both of them.
<HR>


</div>

<?php
require_once "../../include/footer.php";
?>