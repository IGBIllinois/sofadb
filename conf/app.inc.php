<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

DEFINE ("PAGEROWS", 20);

// Number of columns for method_info fields
DEFINE ("MAXCOLS", 5);

DEFINE ("METHOD_DATA_AGE", "Age");
DEFINE ("METHOD_DATA_SEX", "Sex");
DEFINE ("METHOD_DATA_ANCESTRY", "Ancestry");
DEFINE ("METHOD_DATA_STATURE", "Stature");

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

// 3 columns, divided into categories, with a reference dropdown box
DEFINE ("USER_INTERACTION_3_COL_W_REF", "3_col_w_ref");

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

DEFINE("USER_INTERACTION_CHECKBOX_SELECT", "checkbox_select");

// Method info type for "Spradley & Jantz 2011" method, and similar
DEFINE("METHOD_INFO_TYPE_SPRADLEY_JANTZ", "Spradley_Jantz");

// Method info type for most Stature types, with text input boxes and select_each inputs
DEFINE("METHOD_INFO_TYPE_STATURE_1", "Stature_1");

// Method info type for Rios & Cardoza, and similiarly structured methods)
DEFINE("METHOD_INFO_TYPE_RIOS_CARDOSO", "Rios_Cardoso");

// User Interaction type for Rios & Cardoza, and similiarly structured methods)
DEFINE("USER_INTERACTION_RIOS_CARDOSO", "Rios_Cardoso");

// Method info type for "Spradley & Jantz 2011" method, and similar
DEFINE("METHOD_INFO_TYPE_TRANSITION_ANALYSIS", "Transition_Analysis");


    
DEFINE ("NO_PROMPTS", array(
        "Fordisc (skeletal, metric)",
        "Generalized Morphology (skeleton, nonmetric)",
        "Soft Tissue Morphology (nonmetric)",
        "3D-ID (cranial, metric)",
        "Buikstra and Ubelaker 1994 (skull, nonmetric)",
        "Rogers et al. 2000 (clavicle, nonmetric)",
        "Walker 2005 (os coxa, nonmetric)",
        "Walker 2008 (cranial, nonmetric)",
        "Edgar 2013 (detention, nonmetric)",
        "Raxter et al. (skeletal, metric)",
        "Demirjian et al. 1973 (dentition, nonmetric)"));
    
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
    
DEFINE("MEASUREMENT_PROMPTS", array(
        "Lamendin et al. 1992 (dentition, metric)",
        "Prince and Ubelaker 2002 (dentition, metric)"
    ));
?>