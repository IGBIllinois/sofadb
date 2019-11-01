<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class method_infos {
    
    private $db; // Database object
    
    private $id;
    private $methodid;
    private $name;
    private $header;
    private $option_header;
    private $type;
    private $category;
    private $subcategory;
    
    
    public function get_id() {
        return $this->id;
    }
    
    public function get_methodid() {
        return $this->methodid;
    }
    
    public function get_name() {
        return $this->name;
    }
    
    public function get_header() {
        return $this->header;
    }
    
    public function get_option_header() {
        return $this->option_header;
    }
    
    public function get_type() {
        return $this->type;
    }
    
    public function get_category() {
        return $this->category;
    }
    
    public function get_subcategory() {
        return $this->subcategory;
    }
    
            
    public function __construct($db, $id = null) {

        $this->db = $db;

        if($id != null) {
            $this->load_method_infos($id);
            
        }  
    }
    
   // Newer versions
   public static function show_method_info($db, $methodid, $tier2id=null) {
       $method = new method($db, $methodid);

       if($method == null) {
           echo "Method not found.";
           return;
       }
       $output = "";
       $output .= "<BR>VERSION 2<BR>";
       $prompt = "<BR>Select any/all outcomes for features used.</BR>";
       $method_name = $method->get_name();
       if(in_array($method_name, method_infos::$noPrompts)){
           $prompt = "";
       } else if(in_array($method_name, method_infos::$formulaPrompts)) {
           $prompt = "<BR>Enter any/all measurements and select any/all formulas used.</BR>";
       } else if(in_array($method_name, method_infos::$formulaOutcomePrompts)) {
           $prompt = "<BR>Enter any/all measurements and select any/all formula outcomes from formulas used.</BR>";
       } else if(in_array($method_name, method_infos::$measurementPrompts)) {
           $prompt = "<BR>Enter all measurements used below<BR>";
       }
       
       // Draw estimated outcomes
       if($method->get_method_type() == "Sex") {

           $selected = false;
           if($tier2id != null) {
               $tier2 = new tier2data($db, $tier2id);
               $estimated_outcome = $tier2->get_estimated_outcome_1();
           }
           
           $output .= ("<BR>Estimated Sex from this method:<BR>");
           $output .= ("<select name='estimated_outcome_1'>");
           $output .= ("<option value=''>- Select -</option>");
           $output .= ("<option value='Female' ". (($estimated_outcome == 'Female') ? " selected='selected' " : "") .">Female</option>");
           $output .= ("<option value='Probable Female' ".(($estimated_outcome == 'Probable Female') ? " selected='selected' " : "") .">Probable Female</option>");
           $output .= ("<option value='Indeterminate' ". (($estimated_outcome  == 'Indeterminate')? " selected='selected' " : "") .">Indeterminate</option>");
           $output .= ("<option value='Probable Male' ". (($estimated_outcome == 'Probable Male') ? " selected='selected' " : "") .">Probable Male</option>");
           $output .= ("<option value='Male' ". (($estimated_outcome == 'Male') ? " selected='selected' " : "") .">Male</option>");
           $output .= ("</select><BR>");

           /*
           if($method->get_method_info_type() == METHOD_INFO_TYPE_SPRADLEY_JANTZ ||
                   $method->get_method_info_type() == METHOD_INFO_TYPE_TRANSITION_ANALYSIS) {
               $output .= ("<BR>Select any/all sectioning point outcomes.<BR>");
           } else if($method->get_name() == ("Holland 1991 (proximal tibia, metric)")){ // Holland (TODO: Make this more robust)
               $output .= ("<BR>Select any/all formula outcomes from formulas used.<BR>");
           } else {
               $output .= ("<BR>Select any/all outcomes for features used.<BR>");
           }
            * 
            */
           $output .= $prompt;
       } else if($method->get_method_type() == "Stature") {
           $estimated_outcome_1 = "";
           $estimated_outcome_2 = "";
           $estimated_outcome_units = "";
           if($tier2id != null) {
               $tier2 = new tier2data($db, $tier2id);
               $estimated_outcome_1 = $tier2->get_estimated_outcome_1();
               $estimated_outcome_2 = $tier2->get_estimated_outcome_2();
               $estimated_outcome_units = $tier2->get_estimated_outcome_units();
           }

           $output .= ("<BR>Estimated Stature from this method:");
           $output .= ("<input size=6 id='estimated_outcome_1' name='estimated_outcome_1' value='$estimated_outcome_1'>");
           $output .= (" to ");
           $output .= ("<input size=6 id='estimated_outcome_2' name='estimated_outcome_2' value='$estimated_outcome_2'>");
           
           $output .= ("&nbsp;&nbsp;Units:");
           $output .= ("<select name='estimated_outcome_units'>");
           $output .= ("<option value=''>- Select -</option>");
           $output .= ("<option value='in' ". (($estimated_outcome_units == 'in') ? " selected='selected' " : "") .">in</option>");
           $output .= ("<option value='cm' ".(($estimated_outcome_units == 'cm') ? " selected='selected' " : "") .">cm</option>");
           $output .= ("</select><BR>");
           /*
           if($method->get_method_info_type() == METHOD_INFO_TYPE_STATURE_1) {
            $output .= ("<BR>Select any/all formulae used to estimate stature.<BR>");
           } else {
            $output .= ("<BR>Select any/all data used to estimate stature.<BR>");   
           }
            * 
            */
           $output .= $prompt;
       } else if($method->get_method_type() == "Age") {

           if($tier2id != null) {
               $tier2 = new tier2data($db, $tier2id);
               $estimated_outcome_1 = $tier2->get_estimated_outcome_1();
               $estimated_outcome_2 = $tier2->get_estimated_outcome_2();
               $estimated_outcome_units = $tier2->get_estimated_outcome_units();
           }

           $estimated_outcomes = $method->get_estimated_outcomes();

           /*
           if(count($method->get_method_info_by_type(USER_INTERACTION_NUMERIC_ENTRY)) > 0) {
               // No title for user input methods like Lamedin, Prince&Ubelaker, etc.s
               $title = "";
           }
           if(($method->get_header_2() != null) && 
                   ($method->get_header_2() == "Reference Sample") ||
                   ($method->get_header_2() == "Reference Samples")) {
               $title = "Select method outcome and reference sample used.";
           } else {
               $title = "Select method outcome used.";
           }
           if($title != "") {
            $output .= ("<BR>$title<BR>");
           }
            * 
            */

           $output .= ("<BR>Estimated Age range from this method:");
           $output .= ("<input size=6 id='estimated_outcome_1' name='estimated_outcome_1' value='$estimated_outcome_1'> to ");
           $output .= ("<input size=6 id='estimated_outcome_2' name='estimated_outcome_2' value='$estimated_outcome_2'> years");
           $output .= ("<BR>");
           $output .= $prompt;
           
       } else if($method->get_method_type() == "Ancestry") {
           if($tier2id != null) {
               $tier2 = new tier2data($db, $tier2id);
               $estimated_outcome_1 = $tier2->get_estimated_outcome_1();
               $estimated_outcome_2 = $tier2->get_estimated_outcome_2();
               $estimated_outcome_units = $tier2->get_estimated_outcome_units();
           }
           $estimated_outcomes = $method->get_estimated_outcomes();
           $output .= ("<BR>Estimated Group Affiliation from this method:<BR>");
           $output .= ("<select name='estimated_outcome_1'>");
           $output .= ("<option value=''>- Select -</option>");
           
           foreach($estimated_outcomes as $outcome) {
               $id = $outcome->get_id();
               $value = $outcome->get_value();
               $output .= ("<option value='$id' ". (($estimated_outcome_1 == $id) ? " selected='selected' " : "") .">$value</option>");
           }
           $output .= ("</select><BR>");
           $output .= $prompt;
           
       }
       

       $maxcols = MAXCOLS;
       if($method->get_method_type() == "Stature" ||
               $method->get_name() == 'Holland 1991 (proximal tibia, metric)' ||
               $method->get_name() == 'Birkby et al. 2008 (skeletal, nonmetric)' ||
               $method->get_name() == 'Rhine 1990 (skull, nonmetric)') {
           // Draw vertically
           $maxcols = 1;
       }

       //$method_infos = $method->get_method_infos();
       $method_infos_by_type = $method->get_method_infos_by_type();
       
       if(count($method_infos_by_type) > 0) {

        if($method->get_method_info_type() != null) {
           $input_type = new input_type($db, $method->get_method_info_type());

           // TODO: Ints in input_type table
           if($method->get_method_info_type() == METHOD_INFO_TYPE_SPRADLEY_JANTZ) {

               $output .= method_infos::show_method_info_spradley_jantz($db, $methodid, $tier2id);
               echo $output;
               return;
            } else if($method->get_method_info_type() == USER_INTERACTION_3_COL_W_REF) {

                $output .= method_infos::show_method_info_3_col_with_ref($db, $methodid, $tier2id);
                echo $output;
                return;
            } else if($method->get_method_info_type() == METHOD_INFO_TYPE_TRANSITION_ANALYSIS) {
                $output .= method_infos::show_method_info_transition_analysis($db, $methodid, $tier2id);
                echo $output;
                return;
            } else if($method->get_method_info_type() == METHOD_INFO_TYPE_RIOS_CARDOSO) {

                $output .= method_infos::show_method_infos_rios_cardoso($db, $methodid, $tier2id) ;
                
                echo $output;
                return;
                        
            }  
       } 
       

       $j = 0;
       $output .= "<table class='table_full'><tr>";
       
        foreach($method_infos_by_type as $type_id=>$method_infos) {    
            $output .= "<td class='td_spaced align_top'>";

            $j++;
            if($j > $maxcols) {
                $output .= "</tr><tr>";
                $j = 0;
            }


        $i=0;

        $output .= "<table><tr>";
        $count = 0 ;
       foreach($method_infos as $method_info) {
           $method_info_id = $method_info->get_id();
           $input_type_id = $method_info->get_type();
           $input_type = new input_type($db, $input_type_id);

           $input_type_name = $input_type->get_input_type();

           if($input_type_name == USER_INTERACTION_MULTISELECT ||
                   $input_type_name == USER_INTERACTION_TWO_COLUMN ||
                   $input_type_name == USER_INTERACTION_SINGLESELECT ) {
               $multiple = true;
               $default = null;
               if($input_type_name == USER_INTERACTION_SINGLESELECT) {
                   $multiple = false;
                   $default = ' - Select One - ';
               }
               if($i >= $maxcols) {
                   $output .= "</tr><tr>";
                   $i = 0;
               }
               $output .= "<td class='td_spaced align_top'>";
               $output .= self::show_method_infos_select($db, $method_info_id, $tier2id, true, $multiple, $default);
               $output .= "</td>";
           } else if($input_type_name == USER_INTERACTION_NUMERIC_ENTRY) {
               
               $output .= self::show_method_infos_user_input($db, $method_info_id, $tier2id);
           }  else if($input_type_name == USER_INTERACTION_TEXT_ENTRY) {
               
               $output .= self::show_method_infos_user_input($db, $method_info_id, $tier2id, true);
               
           } else if($input_type_name == USER_INTERACTION_TEXT_AREA) {

               $output .= self::show_method_info_text_area($db, $method_info_id, $tier2id);
           }
           
           else if($input_type_name == USER_INTERACTION_SELECT_EACH ||
                   $input_type_name == USER_INTERACTION_CHECKBOX_SELECT) {
               $inner_table = true;
               if($input_type_name == USER_INTERACTION_CHECKBOX_SELECT) {
                   $maxcols = 1;
               }
               if($maxcols == 1 ) {
                   // draw vertically
                   $inner_table = false;
               }
               
               if($i >= $maxcols) {
                   $output .= "</tr><tr>";
                   $i = 0;
               }
               if(!$inner_table && $count == 0) {
                   // draw headers for all
                   $method_infos = new method_infos($db, $method_info_id);
                   $header = $method_infos->get_header();
                   $option_header = $method_infos->get_option_header();
                   $output .= "<tr><th class='td_spaced align_top align_right'><B><U>$header</U></B></th><th><B><U>$option_header</U></B></th></tr>";
                   
               }

               $output .= "<td class='td_spaced align_top ".(!$inner_table ? " align_right ": "")."'>";
               $output .= self::show_method_infos_select_each($db, $method_info_id, $tier2id, $inner_table, ($input_type_name == USER_INTERACTION_CHECKBOX_SELECT));
               $output .= "</td>";
           }
           
           $i++;
           $count++;
       }
       $output .= "</tr></table>";
       //$output .= "</td>";
}
        $output .= "</tr></table>";
        echo($output);
       }
           else {
               method_info::show_method_info($db, $methodid, $tier2id);
           }
           
       
   }    
    

    /** Get all options for this method_infos
     * 
     * @return \method_info_option An array of method_info_option objects for this method_infos
     */
    public function get_method_info_options() {
        $query = "SELECT id from method_info_options where method_infos_id = :method_infos_id";
        $params = array("method_infos_id"=>$this->get_id());

        $result = $this->db->get_query_result($query, $params);
        
        $return_result = array();
        if(count($result) > 0) {
            foreach($result as $mi_opt) {
                $id = $mi_opt['id'];
                $option = new method_info_option($this->db, $id);
                $return_result[] = $option;
                
            }
        }
        
        return $return_result;
        
    }
    
       public function get_references() {
       $query = "SELECT reference_id from method_info_reference_list where method_infos_id=:mi_id";
       $params = array("mi_id"=>$this->get_id());
       $results = $this->db->get_query_result($query, $params);

       $return_result = array();
       foreach($results as $ref) {
           $ref = new reference($this->db, $ref['reference_id']);
           $return_result[] = $ref;
       }
       return $return_result;
   }
   

    // static
    public static function show_method_infos_select($db, $method_infos_id, $tier2id = null, $header = true, $multiple=true, $default_option = null) {

        $method_infos = new method_infos($db, $method_infos_id);
        $options = $method_infos->get_method_info_options();

        $values = array();
        $selected = array();
        
        if($tier2id != null) {
            $t2 = new tier2data($db, $tier2id);
            $tier3s = $t2->get_tier3data();
            foreach($tier3s as $tier3) {
                $option_id = $tier3->get_method_info_option_id();
                $selected[] = $option_id;
            }
        }

        foreach($options as $option) {
            $id = $option->get_id();
            $value = $option->get_value();
            $values[$option->get_id()] = $option->get_value();
        }

        $output .= "<table class='td_spaced table_full table_horz_spacing>";
        if($header) {
            $output .= "<th class='td_spaced'><B><U>".$method_infos->get_header()."</U></B></th></tr>";
        }
        $output .= "<tr>";
        if($header && $multiple == false) {
            $output .= "<td class='align_right align_top td_spaced width_75' width=50%>".$method_infos->get_name()."</td>";
        }
        $output .= "<td class='td_spaced align_top align_left'>";

        $output .= (functions::draw_select($values, $selected, $multiple, $default_option));
        
        $output .= "</td></tr></table>";

        return $output;
    }
    
    public static function show_method_infos_user_input($db, $method_infos_id, $tier2id = null, $text = null) {
        $method_infos = new method_infos($db, $method_infos_id);
        $options = $method_infos->get_method_info_options();

        $curr_option = $options[0];
        $value = "";
        
        if($tier2id != null) {
            $t2 = new tier2data($db, $tier2id);
            $tier3s = $t2->get_tier3data();
            // Should be one
            foreach($tier3s as $tier3) {
                if($tier3->get_method_info_option_id() == $curr_option->get_id()) {
                    $value = $tier3->get_value();
                }
            }
        }
        
        $size = 6;
        if($text != null && $text == true) {
            $size = 30;
        }
        $output .= "<table class=' td_spaced'>";
        foreach($options as $op) {
            $output .= "<tr><td style='width:250px'>".$op->get_value().": </td><td class='align_left'><input size=$size type='text' name=output_data[][".$op->get_id()."] ".(($value != "") ? ("value ='$value'") : "" )."></input></td></tr>";
        }
        $output .= "</table>";

        return $output;
    }
    
    public static function show_method_infos_select_each($db, $method_infos_id, $tier2id = null, $inner_table = true, $checkboxes = false) {

        $method_infos = new method_infos($db, $method_infos_id);
        $options = $method_infos->get_method_info_options();
        $output = "";
        // header
        if($inner_table) {
        $output .= "<table><tr><th class='align_right align_top td_spaced'>";
        $output .= "<B><U>".$method_infos->get_header() . "</U></B></th><th class='td_spaced align_left' ><B><U>". $method_infos->get_option_header() . "</U></B></th></tr><tr>";
        $output .= "<tr><td class='align_right align_top td_spaced'>";
        }
        $output .= $method_infos->get_name();
        if($method_infos->get_name() != null && $method_infos->get_name() != "") {
            $output .= ":";
        }

        $output .="</td><td class='align_left align_top td_spaced'>";
        
        $values = array();
        $selected = array();
        
        if($tier2id != null) {
            $t2 = new tier2data($db, $tier2id);
            $tier3s = $t2->get_tier3data();
            foreach($tier3s as $tier3) {
                $option_id = $tier3->get_method_info_option_id();
                $selected[] = $option_id;
            }
        }
        
        foreach($options as $op) {
            $values[$op->get_id()] = $op->get_value();
        }
        if(!$checkboxes) {
        $output .= (functions::draw_select($values, $selected, true));
        } else {

            $check_values = array();
                foreach($options as $option) {
                $id = $option->get_id();
                $value = $option->get_value();
                $check_values[] = array($option->get_id(),  $option->get_value());
            }
            $output .= functions::checkbox_dropdown($method_infos->get_id(), $method_infos->get_name(), $check_values, $selected, 'check_select');
        }
        if($inner_table) {
        $output .= "</td></tr></table>";
        }
        return $output;
    }
    
    public static function show_method_info_spradley_jantz($db, $method_id, $tier2id=null) {

        $method = new method($db, $method_id);
        // Get main categories
        $cat_type  = input_type::get_input_type_by_name($db, 'category');
        $cat_type_id = $cat_type->get_id();
        $cat_query = "SELECT * from method_infos where methodid = :methodid and input_type = :input_type and parent_id is null";

        $cat_params = array("methodid"=>$method_id, 'input_type'=>$cat_type_id);

        $categories = $db->get_query_result($cat_query, $cat_params);
        $output = "";
        $output_header = $categories[0]['header'];

        $output .= ("<B><U>$output_header</U></B><BR>");
            $output .= ("<select id='category' name='category[]' onchange='showBoneRegion(this.value)'>");
            $output .= ("<option name='none'></option>");
        // Show initial dropdown box
        foreach($categories as $category) {

            $category_info = new method_infos($db, $category['id']);
            $name = $category_info->get_name();
            $output .= ("<option name='$name'>$name</option>");

        }
        $output .= ("</select>");

        foreach($categories as $category) {
            // Get subcategories
            $category_info = new method_infos($db, $category['id']);
            $category_name = $category_info->get_name();
            $subcat_query = "SELECT * from method_infos where methodid = :methodid and input_type = :input_type and parent_id = :parentid";
            $subcat_params = array("methodid"=>$method_id, 'input_type'=>$cat_type_id, 'parentid'=>$category_info->get_id());

            $sub_categories = $db->get_query_result($subcat_query, $subcat_params);
            
            if(count($sub_categories) == 0) {
                $sub_categories = array($category);
            }
            
            $output .= ("<div name='$category_name' id='$category_name' style='display: none'>");
            $default_option = "Sectioning point used?";
            foreach($sub_categories as $subcategory) {
                // Get method_infos
                $subcategory_info = new method_infos($db, $subcategory['id']);
                $subname = $subcategory_info->get_name();

                $info_query = "SELECT * from method_infos where methodid = :methodid and parent_id = :parentid";
                
                $info_params = array("methodid"=>$method_id, 'parentid'=>$subcategory_info->get_id());

                $infos = $db->get_query_result($info_query, $info_params);

                
                $output .= ("<fieldset class='methodinfobox'>");
                $output .= ("<legend class='boldlegend'>".$subname."</legend> ");
                $output .= ("<table class='table_padded'><tr>");
                //FInally, display infos
                
                $sorted_method_infos = array();
                foreach($infos as $method_infos) {
                    
                    $mi_id = $method_infos['id'];
                    $mi = new method_infos($db, $mi_id);
                    $input_type_id = $mi->get_type();
                    $input_type = new input_type($db, $input_type_id);
                    if(!key_exists($input_type->get_input_type(), $sorted_method_infos)) {

                        $sorted_method_infos[$input_type->get_input_type()] = array();
                    }
                    $sorted_method_infos[$input_type->get_input_type()][] = $method_infos;

                            
                }


                foreach($sorted_method_infos as $input_type_name=>$infos) {
                    $output .= "<td>";
                    if($input_type_name == USER_INTERACTION_INPUT_BOX_WITH_DROPDOWN) {
                        $output .= "<table class='align_top'>";
                        foreach($infos as $method_infos) {
                            $output .= "<tr><td>";
                        
                            $method_info = new method_infos($db, $method_infos['id']);
                            $id = $method_info->get_id();

                            $output .= method_infos::show_method_infos_input_box_with_dropdown($db, $id, $tier2id, $default_option);
                            $output .= "</td></tr>";
                        }
                        $output  .= "</table>";
                }
                else if($input_type_name == USER_INTERACTION_SELECT_EACH) {
                    $output .= "<table>";
                    foreach($infos as $method_infos) {
                        $method_info = new method_infos($db, $method_infos['id']);
                        $id = $method_info->get_id();
                        
                        $output .= "<tr><td class='td_spaced align_top'>";
                        $output .= self::show_method_infos_select_each($db, $id, $tier2id);
                        $output .= "</td></tr>";
                    }
                    $output .= "</table>";
                }
                $output .= "</td>";
            }
            $output .= "</tr></table></fieldset>";
            
                    
        }
        $output .= "</div>";
    }
        return $output;
    }
    
    public static function show_method_info_transition_analysis($db, $method_id, $tier2id=null) {

        $method = new method($db, $method_id);
        // Get main categories
        $cat_type  = input_type::get_input_type_by_name($db, 'category');
        $cat_type_id = $cat_type->get_id();
        $cat_query = "SELECT * from method_infos where methodid = :methodid and input_type = :input_type and parent_id is null";

        $cat_params = array("methodid"=>$method_id, 'input_type'=>$cat_type_id);

        $categories = $db->get_query_result($cat_query, $cat_params);
        $output = "";

        $output .= ("<B><U>All Data</U></B><BR>");
            $output .= ("<select id='category' name='category[]' onchange='showBoneRegion(this.value)'>");
            $output .= ("<option name='none'></option>");
        // Show initial dropdown box
        foreach($categories as $category) {

            $category_info = new method_infos($db, $category['id']);
            $name = $category_info->get_name();
            $output .= ("<option name='$name'>$name</option>");

        }
        $output .= ("</select>");

        foreach($categories as $category) {
                // Get method_infos
                $category_info = new method_infos($db, $category['id']);
                $name = $category_info->get_name();

                //echo('subcat id = '.$subcategory['id']);
                $info_query = "SELECT * from method_infos where methodid = :methodid and parent_id = :parentid";
                
                $info_params = array("methodid"=>$method_id, 'parentid'=>$category_info->get_id());

                $infos = $db->get_query_result($info_query, $info_params);

                
                $output .= ("<div name='$name' id='$name' style='display: none'>");
                $output .= ("<fieldset class='methodinfobox'>");
                $output .= ("<legend class='boldlegend'>".$name."</legend> ");
                
                //FInally, display infos
                
                $sorted_method_infos = array();
                foreach($infos as $method_infos) {
                    $output .= ("<table class='table_padded'><tr>");
                    $mi_id = $method_infos['id'];
                    
                    $mi = new method_infos($db, $mi_id);
                    $input_type_id = $mi->get_type();
                    $input_type = new input_type($db, $input_type_id);
                    if(!key_exists($input_type->get_input_type(), $sorted_method_infos)) {

                        $sorted_method_infos[$input_type->get_input_type()] = array();
                    }
                    $sorted_method_infos[$input_type->get_input_type()][] = $method_infos;

                            
                }


                foreach($sorted_method_infos as $input_type_name=>$infos) {
                    $output .= "<td>";

                    if($input_type_name == USER_INTERACTION_NUMERIC_ENTRY) {
                        foreach($infos as $method_infos) {
                            //$method_info = new method_infos($db, $method_infos['id']);

                            $method_info_id = $method_infos['id'];
                            $output .= self::show_method_infos_user_input($db, $method_info_id, $tier2id);
                        }
                    }
                    $output .= "</td>";

                }
                $output .= "</tr></table></fieldset>";
                $output .= "</div>";
            }

        return $output;
    }
    
    public static function show_method_infos_input_box_with_dropdown($db, $method_infos_id, $tier2id=null, $default_option = null) {
        // Method info bos with dropdown should have 2 method_infos whose parent_ids point back to it
        // one numeric_entry, and one multiselect
        
        $output = '';

        $m_infos = new method_infos($db, $method_infos_id);
        $result = $m_infos->get_children();
        
        $inputbox_mi = null;
        $dropdown_mi = null;

        $input_box_type = input_type::get_input_type_by_name($db, USER_INTERACTION_NUMERIC_ENTRY);
        $dropdown_type = input_type::get_input_type_by_name($db, USER_INTERACTION_MULTISELECT);
        foreach($result as $mi_info) {

            $mi = new method_infos($db, $mi_info->get_id());

            if($mi->get_type() == $input_box_type->get_id()) {
                $inputbox_mi = $mi;

            } else if($mi->get_type() == $dropdown_type->get_id()) {
                $dropdown_mi = $mi;

        }
            
        }
        if($inputbox_mi != null) {
        $output .= "<table class='td_spaced'><tr><td>";

        $output .= method_infos::show_method_infos_user_input($db, $inputbox_mi->get_id(), $tier2id);
        $output .= "</td><td class='td_spaced align_right'>";
        $output .= method_infos::show_method_infos_select($db, $dropdown_mi->get_id(), $tier2id, false, false, $default_option);
        $output .= "</td></tr></table>";
        }
        return $output;
        
        
    }
        
   /** Shows HTML method_info input for a "text_area" method_info
    * 
    * @param method $method The method object
    * @param int $tier2id Existing info, if editing
    * @param string $user_interaction The user_interaction type
    */
   public static function show_method_info_text_area($db, $method_infos_id, $tier2id) {
        $method_infos = new method_infos($db, $method_infos_id);
        $value = "";        
        
        $options = $method_infos->get_method_info_options();

        $curr_option = $options[0];
        $value = "";
        
        if($tier2id != null) {
            $t2 = new tier2data($db, $tier2id);
            $tier3s = $t2->get_tier3data();
            // Should be one
            foreach($tier3s as $tier3) {
                if($tier3->get_method_info_option_id() == $curr_option->get_id()) {
                    $value = $tier3->get_value();
                }
            }
        }

        $output .= "<table class=' td_spaced'>";
        foreach($options as $op) {

            $output .= "<tr><td style='width:250px'>".$op->get_value().": </td></tr><tr><td class='align_left'><textarea  rows=10 cols=50 name=output_data[][".$op->get_id()."]>$value</textarea></td></tr>";
        }
        $output .= "</table>";
        
        return $output;
           
   
   }
   

   
    public static function show_method_info_3_col_with_ref($db, $method_id, $tier2id=null) {

        $output = "";
          $method = new method($db, $method_id);
          $cat_input_type = input_type::get_input_type_by_name($db, USER_INTERACTION_CATEGORY);
        
          $cat_query = "SELECT * from method_infos where methodid = :methodid and input_type = :input_type and parent_id is null";

        $cat_params = array("methodid"=>$method_id, 'input_type'=>$cat_input_type->get_id());

        $categories = $db->get_query_result($cat_query, $cat_params);
        $tmp_cat = $categories[0];

        $category_info = new method_infos($db, $tmp_cat['id']);
        $header1 = $category_info->get_header();

        $children = $category_info->get_children();
        $header2 = $children[0]->get_header();
        $header3 = $children[0]->get_option_header();
        $header4 = "References";
        

            $selected = array();
       $methodinfos = array();

            if($tier2id != null) {

                   $tier2 = new tier2data($db, $tier2id);

                   $data = $tier2->get_tier3data();

                   foreach($data as $tier_info) {
                       
                       $sel_id = $tier_info->get_method_info_option_id();
                       $selected[] = $sel_id;
                   }
                   
                   
               }

               $output .= "";
               $headers = "";
               $has_refs = false;
               $headers .= ("<table  style='table_full table_padded'><tr><th><U><B>".$header1."</B></U></th>");
               $headers .= ("<th><U><B>".$header2."</B></U></th>");
               $headers .= ("<th><U><B>".$header3."</B></U></th>");

               $value = null;
               

               foreach($categories as $category) {
                   $cat = new method_infos($db, $category['id']);
                   $method_infos = $cat->get_children();
                   
                   $output .= ("<tr><td class='align_top td_spaced' rowspan='".(count($method_infos)+1)."'>");
                   $output .= $cat->get_name();
                   $output .= "</td>";
                   foreach($method_infos as $mi) {
                       $values = array();
                       $options = $mi->get_method_info_options();
                       $output .= "<tr><td>".$mi->get_name()."</td>";
                       
                       foreach($options as $op) {
                            $values[$op->get_id()] = $op->get_value();
                        }
                        
                        $output .= "<td>".(functions::draw_select($values, $selected, false, " ")). "</td>";
                       
                        $refs = $mi->get_references();
                        if(count($refs) > 0) {

                            $has_refs = true;
                        
                        $ref_list= array();
                        foreach($refs as $ref) {
                            $ref_list[] = array($ref->get_id(), $ref->get_reference_name());
                        }
                        $selected_refs = array();
                        if($tier2 != null) {
                                $sel_ref_list = $tier2->get_selected_references($mi->get_id());

                                foreach($sel_ref_list as $sel_ref) {

                                    $selected_refs[] = $sel_ref->get_id();
                                }

                        }

                        $references = functions::checkbox_dropdown($mi->get_id(), $mi->get_name(), $ref_list, $selected_refs, 'references');
                        }
                       $output .= "<td>$references</td></tr>";
                        
                   }
                   $output .= "</tr>";
               }
               $output .= "</table>";

               if($has_refs == true) {
                   $headers .= ("<th><U><B>".$header4."</B></U></th>");
               }
               else {
                   $headers .= "<th></th>";
               }
               return $headers . $output;
   }
   
    public static function show_method_infos_rios_cardoso($db, $method_id, $tier2id=null) {
        
        $method = new method($db, $method_id);
        
        $selected = array();
        if($tier2id != null) {
            $t2 = new tier2data($db, $tier2id);
            $tier3s = $t2->get_tier3data();
            foreach($tier3s as $tier3) {
                $option_id = $tier3->get_method_info_option_id();
                $selected[] = $option_id;
            }
        }
        
        // Get main categories
        $cat_type  = input_type::get_input_type_by_name($db, 'category');
        $cat_type_id = $cat_type->get_id();
        $cat_query = "SELECT * from method_infos where methodid = :methodid and input_type = :input_type and parent_id is null";

        $cat_params = array("methodid"=>$method_id, 'input_type'=>$cat_type_id);

        $categories = $db->get_query_result($cat_query, $cat_params);
        $output = "";
        $output_header = $categories[0]['header'];
        
        $headers = array();
        $table = '';
        
        // table headers
        
        foreach($categories as $cat_info) {
            $row = "";
            $category = new method_infos($db, $cat_info['id']);
            $subcategories = $category->get_children();
            $sorted_subcats = array();
            foreach($subcategories as $subcat) {
                if(!in_array($subcat->get_name(), $headers)) {
                    $headers[] = $subcat->get_name();
                }
                $sorted_subcats[array_search($subcat->get_name(), $headers)] = $subcat;
            }
            $row .= "<tr>";
            $row .= "<td>".$category->get_name()."</td>";
            
            foreach($sorted_subcats as $subcat_info) {
                

                $method_info_options = $subcat_info->get_method_info_options();
                $list = array();
                foreach($method_info_options as $opt) {
                    $list[] = array($opt->get_id(), $opt->get_value());
                }
                $row .= "<td>";
                
                $row .= functions::checkbox_dropdown($subcat_info->get_id(), $subcat_info->get_name(), $list, $selected, 'check_select');
                $row .= "</td>";
            }
            $row .= "</tr>";
            $table .= $row;
        }
        $header_info = "<tr class='td_spaced'>";
        $header_info .= "<td><B><U>$output_header</U></B></td>";
        foreach($headers as $header) {
            $header_info .= "<td><B><U>".$header."</U></B></td>";
        }
        $header_info .= "</tr>";
        $table = "<table class='table_padded'>".$header_info. $table;
        $table .= "</table>";
        
        return $table;
        
    }
   
   public function get_children() {
       $query = "SELECT id from method_infos where parent_id = :parent_id";
       $params = array("parent_id"=>$this->get_id());

       $result = $this->db->get_query_result($query, $params);
       $return_result = array();
       foreach($result as $mi) {

           $method_infos = new method_infos($this->db, $mi['id']);
           $return_result[] = $method_infos;
       }
       return $return_result;
   }
   

    
    // Private
    private function load_method_infos($id) {

        $query = "SELECT * from method_infos where id=:id";
        $params = array("id"=>$id);

        $result = $this->db->get_query_result($query, $params);

        if(count($result) > 0) {
            $data = $result[0];

        $this->id = $id;
         $this->methodid = $data['methodid'];
         $this->name = $data['name'];
         $this->header = $data['header'];
         $this->option_header = $data['option_header'];
         $this->type = $data['input_type'];
         $this->category = $data['category'];
         $this->subcategory = $data['subcategory'];
    }
    }

  
    
    private static $noPrompts = array(
        "Fordisc (skeletal, metric)",
        "Generalized Morphology (skeleton, nonmetric)",
        "Soft Tissue Morphology (nonmetric)",
        "3D-ID (cranial, metric)",
        "Buikstra and Ubelaker 1994 (skull, nonmetric)",
        "Rogers et al. 2000 (clavicle, nonmetric)",
        "Walker 2005 (os coxa, nonmetric)",
        "Walker 2008 (cranial, nonmetric)",
        "Edgar 2013 (detention, nonmetric)",
        "Raxter et al. (skeletal, metric)");
    
    private static $formulaPrompts = array(
        "Fully 1956 (skeletal, metric)",
        "Genoves 1967 (long bones, metric)",
        "Ousley 1995 (long bones, metric)",
        "Sjovold 1990 (long bones, metric)",
        "Spradley et al. 2008 (long bones, metric)",
        "Steele 1970 (long bones, metric)",
        "Trotter 1970 (long bones, metric)",
        "Trotter and Glesser 1952 (long bones, metric)"
        );

    private static $formulaOutcomePrompts = array(
        "Holland 1991 (proximal tibia, metric)",
        "Tise et al. 2013 (postcranial, metric)",
        "Spradley and Jantz 2011 (metric)"
        
    );
    
    private static $measurementPrompts = array(
        "Lamendin et al. 1992 (dentition, metric)",
        "Prince and Ubelaker 2002 (dentition, metric)"
    );
}