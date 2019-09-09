<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

DEFINE ('DB_USER', '');
DEFINE ('DB_PASSWORD', '');
DEFINE ('DB_HOST', '');
DEFINE ('DB_NAME', '');

DEFINE ('ADMIN_EMAIL', '');
DEFINE ('FROM_EMAIL', '');

DEFINE ("ROOT_URL", '');

DEFINE ("SALT", '');

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

// For each output_data_1, there is a multi-select box of choices
DEFINE ("USER_INTERACTION_SELECT_EACH", "select_each");

// For each output_data_1, there is a single select from within a numerical range (e.g. "1-16")
DEFINE ("USER_INTERACTION_SELECT_RANGE", "select_range");

// A single input box where a user enters the data
DEFINE ("USER_INTERACTION_INPUT_BOX", "user_input_box");

// A single input box where a user enters the data
DEFINE ("USER_INTERACTION_NUMERIC_ENTRY", "numeric_entry");

// 3 columns, divided into categories, with a reference dropdown box
DEFINE ("USER_INTERACTION_3_COL_W_REF", "3_col_w_ref");

// User input with an associated dropdown box (Spradley & Jantz)
DEFINE ("USER_INTERACTION_INPUT_BOX_WITH_DROPDOWN", "user_input_with_dropdown");

DEFINE("USER_INTERACTION_SINGLE_SELECT", "single_select");

// User input with a large text area
DEFINE("USER_INTERACTION_TEXT_AREA", "text_area");

// User input for possible estimated outcome values
DEFINE("USER_INTERACTION_ESTIMATED_OUTCOME", "estimated_outcome");

// Method info type for "Spradley & Jantz 2011" method, and similar
DEFINE("METHOD_INFO_TYPE_SPRADLEY_JANTZ", "Spradley_Jantz");

// Method info type for most Stature types, with text input boxes and select_each inputs
DEFINE("METHOD_INFO_TYPE_STATURE_1", "Stature_1");

// Method info type for Rios & Cardoza, and similiarly structured methods)
DEFINE("METHOD_INFO_TYPE_RIOS_CARDOSO", "Rios_Cardoso");

// User Interaction type for Rios & Cardoza, and similiarly structured methods)
DEFINE("USER_INTERACTION_RIOS_CARDOSO", "Rios_Cardoso");