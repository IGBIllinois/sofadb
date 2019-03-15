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

DEFINE ("METHOD_DATA_AGE", "Age");
DEFINE ("METHOD_DATA_SEX", "Sex");
DEFINE ("METHOD_DATA_ANCESTRY", "Ancestry");
DEFINE ("METHOD_DATA_STATURE", "Stature");

// User interaction types

// one or more multi-select boxes, multiple choices can be made from all
DEFINE ("USER_INTERACTION_MULTISELECT", "multiselect"); 

// For each output_data_1, there is a multi-select box of choices
DEFINE ("USER_INTERACTION_MULTISELECT_EACH", "multiselect_each");

// For each output_data_1, there is a single select from within a numerical range (e.g. "1-16")
DEFINE ("USER_INTERACTION_SELECT_RANGE", "select_range");

// A single input box where a user enters the data
DEFINE ("USER_INTERACTION_INPUT_BOX", "user_input_box");
