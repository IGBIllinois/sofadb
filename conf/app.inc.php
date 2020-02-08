<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

DEFINE ("PAGEROWS", 20);

// Number of columns for method_info fields
DEFINE ("MAXCOLS", 5);

DEFINE ("MAXAGE", 150);

DEFINE ("METHOD_DATA_AGE", "Age");
DEFINE ("METHOD_DATA_SEX", "Sex");
DEFINE ("METHOD_DATA_ANCESTRY", "Ancestry");
DEFINE ("METHOD_DATA_STATURE", "Stature");

DEFINE ("METHOD_DATA_AGE_ID", 2);
DEFINE ("METHOD_DATA_SEX_ID", 1);
DEFINE ("METHOD_DATA_ANCESTRY_ID", 3);
DEFINE ("METHOD_DATA_STATURE_ID",4);

// User interaction types

// one or more multi-select boxes, multiple choices can be made from all
DEFINE ("USER_INTERACTION_MULTISELECT", "multiselect"); 

// one or more multi-select boxes, multiple choices can be made from all
DEFINE ("USER_INTERACTION_SINGLESELECT", "singleselect"); 

// For each output_data_1, there is a multi-select box of choices
DEFINE ("USER_INTERACTION_SELECT_EACH", "select_each");

// For each output_data_1, there is a single select from within a numerical range (e.g. "1-16")
DEFINE ("USER_INTERACTION_SELECT_RANGE", "select_range");

// A single input box where a user enters the data
DEFINE ("USER_INTERACTION_TEXT_ENTRY", "text_entry");

// A single input box where a user enters the data
DEFINE ("USER_INTERACTION_INPUT_BOX", "text_input");

// A single input box where a user enters the data
DEFINE ("USER_INTERACTION_NUMERIC_ENTRY", "numeric_entry");

// User input with an associated dropdown box (Spradley & Jantz)
DEFINE ("USER_INTERACTION_INPUT_BOX_WITH_DROPDOWN", "user_input_with_dropdown");

// User input with a large text area
DEFINE("USER_INTERACTION_TEXT_AREA", "text_area");

// User input for two-column multiselect
DEFINE("USER_INTERACTION_TWO_COLUMN", "two-column");

// User input for possible estimated outcome values
DEFINE("USER_INTERACTION_ESTIMATED_OUTCOME", "estimated_outcome");

// User input for possible estimated outcome values
DEFINE("USER_INTERACTION_CATEGORY", "category");

// User input for a dropdown with multiple-select checkboxes
DEFINE("USER_INTERACTION_CHECKBOX_SELECT", "checkbox_select");

// User input for Left/Right radio buttons
DEFINE("USER_INTERACTION_LEFT_RIGHT", "left_right");


// Method info types. These are special categories for methods, for unique displays.

// Method info type for "Spradley & Jantz 2011" method, and similar
DEFINE("METHOD_INFO_TYPE_SPRADLEY_JANTZ", "Spradley_Jantz");

// Method info type for most Stature types, with text input boxes and select_each inputs
DEFINE("METHOD_INFO_TYPE_STATURE_1", "Stature_1");

// Method info type for Rios & Cardoza, and similiarly structured methods)
DEFINE("METHOD_INFO_TYPE_RIOS_CARDOSO", "Rios_Cardoso");

// Method info type for "Spradley & Jantz 2011" method, and similar
DEFINE("METHOD_INFO_TYPE_RHINE", "Rhine");

// 3 columns, divided into categories, with a reference dropdown box
DEFINE ("METHOD_INFO_TYPE_3_COL_W_REF", "3_col_w_ref");



    
DEFINE ("NO_PROMPTS", array(
        "Fordisc (skeletal, metric)",
        "Generalized Morphology (skeleton, nonmetric)",
        "Soft Tissue Morphology (nonmetric)",
        "3D-ID (cranial, metric)",
        "Buikstra and Ubelaker 1994 (skull, nonmetric)",
        "Rogers et al. 2000 (clavicle, nonmetric)",
        "Edgar 2013 (detention, nonmetric)",
        "Raxter et al. (skeletal, metric)",
        "Demirjian et al. 1973 (dentition, nonmetric)",
        "Transition Analysis (skeletal, nonmetric)",
        "Berg and Kennyhercz 2017 (mandible, metric)",
        ));
    
DEFINE ("FORMULA_PROMPTS", array(
        "Fully 1956 (skeletal, metric)",
        "Genoves 1967 (long bones, metric)",
        "Ousley 1995 (long bones, metric)",
        "Sjovold 1990 (long bones, metric)",
        "Spradley et al. 2008 (long bones, metric)",
        "Steele 1970 (long bones, metric)",
        "Trotter 1970 (long bones, metric)",
        "Trotter and Glesser 1952 (long bones, metric)"
        ));

DEFINE("FORMULA_OUTCOME_PROMPTS", array(
        "Holland 1991 (proximal tibia, metric)",
        "Tise et al. 2013 (postcranial, metric)",
        "Spradley and Jantz 2011 (metric)"
        
    ));

DEFINE("PHASE_REF_PROMPTS", array(
    "Albert and Maples 1995 (vertebrae, nonmetric)",
    "Blankenship et al. 2017 (dentition, nonmetric)",
    "Brooks and Suchey 1990 (os pubis, nonmetric)",
    "Hartnett 2010 (os pubis, nonmetric)",
    "Hartnett 2010 (ribs, nonmetric)",
    "Iscan and Loth 1989 (ribs)",
    "Iscan et al. 1987 (American Black males and females)",
    "Kasper et al. 2009 Hispanic, third molar",
    "Langley-Shirley and Jantz 2010 (clavicle, nonmetric)",
    "Mincer et al. 1993 (third molar, nonmetric)",
    "Shirley and Jantz 2011 (cranium, nonmetric)",
    "Todd 1921 (os pubis, nonmetric)",
    "Webb and Suchey 1985 (os coxa and clavicle, nonmetric)"
));

DEFINE("PHASE_PROMPTS", array(
     "Berg 2008 (os pubis, nometric)",
    "Buckberry and Chamberlain 2002 (ilium, nonmetric)",
    "Garvin 2008 (cartilage, nonmetric)",
    "Gilbert and McKern 1973 (os pubis)",
    "Ginter 2005 (cranium, nonmetric)",
    "Iscan et al. 1984 (White male, ribs, nonmetric)",
    "Iscan et al. 1985 (White females, ribs, nonmetric)",
    "Langley 2016 (clavicle, nonmetric)",
    "Lovejoy et al. 1985 (os coxa, nonmetric)",
    "Mann et al. 1991 (cranium, nonmetric)",
    "Mckern and Stewart 1957 (os pubis, nonmetric)",
    "Osborne et al. 2004 (os coxa, nonmetric)",
    "Passalacqua 2009 (sacrum, nonmetric)",
    "Rejtarova et al. 2009 (costal cartilage, nonmetric)",
    "Todd 1920 (os pubis, nonmetric)"

));
    
DEFINE("MEASUREMENT_PROMPTS", array(
        "Lamendin et al. 1992 (dentition, metric)",
        "Prince and Ubelaker 2002 (dentition, metric)"
    ));
?>