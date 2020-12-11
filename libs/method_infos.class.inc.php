<?php

/* 
 * This class details the method_infos object. Every method has one or more "method_infos", which are inputs detailing
 * what measurements are used in the method. Each method_infos object has a type, 
 * (such as 'multiselect', 'singleselect', etc. described in app.inc.php) that determines how it will be displayed
 * and how the input will be accepted.
 * 
 * When submitting data entered into a method_infos object, the user input 
 */

class method_infos {
    
    private $db; // Database object
    
    /** Unique id for the method_infos object */
    private $id;
    
    /** ID of the method this method_infos is for */
    private $methodid;
    
    /** Name of this method_infos object */
    private $name;
    
    /** Header used for this method_infos */
    private $header;
    
    /** Header used for the options used in certain method_infos */
    private $option_header;
    
    /** Type id of this method_info */
    private $type;
    
    /** ID of the parent method_infos object. Used in certain types like category or Left/Right */
    private $parent_id;

    
    
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
    
    public function get_parent_id() {
        return $this->parent_id;
    }
    

    
            
    public function __construct($db, $id = null) {

        $this->db = $db;

        if($id != null) {
            $this->load_method_infos($id);  
        } else {
            // Don't load data
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
        } else {
            // Not found
        }
        
        return $return_result;
        
    }
    
    /** Gets references associated with this method_infos object, if any
     * 
     * @return \reference An array of reference objects associated with this method_infos
     */
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
   
   /** Gets the children of this method_infos object
     * 
     * @return \method_infos An array of method_infos that have
     * this method_infos listed as their parent
     */
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
   
   /** Adds a method_info_option to this method_info
    * 
    * @param string $value The value to add
    * 
    * @return int The id of the newly created method_info_option
    */
   public function add_option($value) {
       $query = "INSERT INTO method_info_options (method_infos_id, value) VALUES"
               . "(:method_infos_id, :value)";
       $params = array("method_infos_id"=>$this->get_id(),
                        "value"=>$value);
       $result = $this->db->get_insert_result($query, $params);
       
       return $result; 
   }
   
   /** Adds a method_info_option to this method_info
    * 
    * @param int $option_id The id of the option to remove
    * 
    * $return int The number of options removed
    */
   public function delete_option($option_id) {
       $query = "DELETE FROM method_info_options where id=:id";
       $params = array("id"=>$option_id);
       
       $result = $this->db->get_update_result($query, $params);
       
       return $result; 
   }
   
   /** Edits a method_info_option for this method_info
    * 
    * @param int $option_id ID of the option to edit
    * @param string $new_value New value for the option
    */
   public function edit_option($option_id, $new_value) {
       $query = "UPDATE method_info_options set value=:value where id=:option_id";
       $params = array("value"=>$new_value,
                       "option_id"=>$option_id);
       $result = $this->db->get_update_result($query, $params);
       return $result;
       
   }
   
   // Static
    
   /** Displays input for a method information
    * 
    * @param db $db The database object
    * @param int $methodid ID of the method to add
    * @param int $tier2id ID of tier2 object, if editing existing data
    * @return string HTML output for inputting data
    */
   public static function show_method_info($db, $methodid, $tier2id=null) {
       $method = new method($db, $methodid);

       if($method == null) {
           echo "Method not found.";
           return;
       } else {
       
        $output = "";

        $prompt = "<BR><span class='prompt'>".$method->get_method_prompt()."</span><BR><BR>";
        // Draw estimated outcomes
        if($method->get_method_type_num() == METHOD_DATA_SEX_ID) {
            // Sex method
            
            $selected = false;
            if($tier2id != null) {
                $tier2 = new tier2data($db, $tier2id);
                $estimated_outcome = $tier2->get_estimated_outcome_1();
            }

            // Estimated sex for this method
            $output .= ("<BR>Estimated Sex from this method:<BR>");
            $output .= ("<select name='estimated_outcome_1'>");
            $output .= ("<option value=''>- Select -</option>");
            $output .= ("<option value='Female' ". (($estimated_outcome == 'Female') ? " selected='selected' " : "") .">Female</option>");
            $output .= ("<option value='Probable Female' ".(($estimated_outcome == 'Probable Female') ? " selected='selected' " : "") .">Probable Female</option>");
            $output .= ("<option value='Indeterminate' ". (($estimated_outcome  == 'Indeterminate')? " selected='selected' " : "") .">Indeterminate</option>");
            $output .= ("<option value='Probable Male' ". (($estimated_outcome == 'Probable Male') ? " selected='selected' " : "") .">Probable Male</option>");
            $output .= ("<option value='Male' ". (($estimated_outcome == 'Male') ? " selected='selected' " : "") .">Male</option>");
            $output .= ("</select><BR>");

            $output .= $prompt;
        } else if($method->get_method_type_num() == METHOD_DATA_STATURE_ID) {
            // Stature method
            
            $estimated_outcome_1 = "";
            $estimated_outcome_2 = "";
            $estimated_outcome_units = "";
            if($tier2id != null) {
                $tier2 = new tier2data($db, $tier2id);
                $estimated_outcome_1 = $tier2->get_estimated_outcome_1();
                $estimated_outcome_2 = $tier2->get_estimated_outcome_2();
                $estimated_outcome_units = $tier2->get_estimated_outcome_units();
            } else {
                // No tier2 data given
            }

            $output .= ("<BR>Estimated Stature from this method:");
            $output .= ("<input type='number' step='0.01' size=6 id='estimated_outcome_1' name='estimated_outcome_1' value='$estimated_outcome_1'>");
            $output .= (" to ");
            $output .= ("<input type='number' step='0.01' size=6 id='estimated_outcome_2' name='estimated_outcome_2' value='$estimated_outcome_2'>");

            $output .= ("&nbsp;&nbsp;Units:");
            $output .= ("<select name='estimated_outcome_units'>");
            $output .= ("<option value=''>- Select -</option>");
            $output .= ("<option value='in' ". (($estimated_outcome_units == 'in') ? " selected='selected' " : "") .">in</option>");
            $output .= ("<option value='cm' ".(($estimated_outcome_units == 'cm') ? " selected='selected' " : "") .">cm</option>");
            $output .= ("</select><BR>");

            $output .= $prompt;
        } else if($method->get_method_type_num() == METHOD_DATA_AGE_ID) {
            // Age method
            
            if($tier2id != null) {
                $tier2 = new tier2data($db, $tier2id);
                $estimated_outcome_1 = $tier2->get_estimated_outcome_1();
                $estimated_outcome_2 = $tier2->get_estimated_outcome_2();
                $estimated_outcome_units = $tier2->get_estimated_outcome_units();
            } else {
                // No tier2 given
            }

            $estimated_outcomes = $method->get_estimated_outcomes();

            $output .= ("<BR>Estimated Age range from this method:");
            $output .= ("<input type='number' step='0.01' size=6 id='estimated_outcome_1' name='estimated_outcome_1' value='$estimated_outcome_1'> to ");
            $output .= ("<input type='number' step='0.01' size=6 id='estimated_outcome_2' name='estimated_outcome_2' value='$estimated_outcome_2'> years");
            $output .= ("<BR>");
            $output .= $prompt;

        } else if($method->get_method_type_num() == METHOD_DATA_ANCESTRY_ID) {
            // Ancestry method
            if($tier2id != null) {
                $tier2 = new tier2data($db, $tier2id);
                $estimated_outcome_1 = $tier2->get_estimated_outcome_1();
                $estimated_outcome_2 = $tier2->get_estimated_outcome_2();
                $estimated_outcome_units = $tier2->get_estimated_outcome_units();
            } else {
                // No tier2 given
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

        } else {
            // Unknown type
        }


        $maxcols = MAXCOLS;
        if($method->get_method_type_num() == METHOD_DATA_STATURE_ID||
                $method->get_name() == 'Holland 1991 (proximal tibia, metric)' ||
                $method->get_name() == 'Birkby et al. 2008 (skeletal, nonmetric)' ||
                $method->get_name() == 'Rhine 1990 (skull, nonmetric)') {
            // Draw vertically
            $maxcols = 1;
        } else {
            // Not special method
        }


        $method_infos_by_type = $method->get_method_infos_by_type();

        // Draw method_infos
        if(count($method_infos_by_type) > 0) {

         if($method->get_method_info_type() != null) {

             // These are special method types requiring unique displays

            if($method->get_method_info_type() == METHOD_INFO_TYPE_SPRADLEY_JANTZ) {

                $output .= method_infos::show_method_info_spradley_jantz($db, $methodid, $tier2id);
                echo $output;
                return;
             } else if($method->get_method_info_type() == METHOD_INFO_TYPE_3_COL_W_REF) {

                 $output .= method_infos::show_method_info_3_col_with_ref($db, $methodid, $tier2id);
                 echo $output;
                 return;
             } else if($method->get_method_info_type() == METHOD_INFO_TYPE_RIOS_CARDOSO) {

                 $output .= method_infos::show_method_infos_rios_cardoso($db, $methodid, $tier2id) ;

                 echo $output;
                 return;

             } else if($method->get_method_info_type() == METHOD_INFO_TYPE_RHINE) {
                 $output .= method_infos::show_method_info_rhine($db, $methodid, $tier2id);
                 echo $output;
                 return;
             } else {
                 // Unknown method info type
             }
        } else {
            // No method info type
        }


        $j = 0;

        // Draw each method_info
         foreach($method_infos_by_type as $type_id=>$method_infos) {
             $output .= "<table ><tr>";
             if($type_id == input_type::get_input_id_by_name($db, USER_INTERACTION_ESTIMATED_OUTCOME)) {
                 // Estimated outcome has already been displayed
                 continue;
             } else {
                 // Keep going
             }
             
             if(count($method_infos) > 0) {
                 $j++;
                if($j > $maxcols) {
                    $output .= "</tr><tr>";
                    $j = 0;
                }

                 $i=0;

                // Add header title for specific methods
                $input_type = new input_type($db, $type_id);
                $input_type_name = $input_type->get_input_type();
                if(($input_type_name == USER_INTERACTION_NUMERIC_ENTRY ||
                           $input_type_name == USER_INTERACTION_TEXT_ENTRY)) {

                    $output .= "<td class='td_spaced align_top'>";
                   if($method_infos[0]->get_option_header() != null) {
                       // Show header
                       $output .= ("<B><U>".$method_infos[0]->get_option_header()."</U></B>");
                   } else {
                       // No header to show
                   }

                } else {
                    // No need to show header
                }

                $count = 0 ;
                // Draw each method_infos
                foreach($method_infos as $method_info) {

                    $method_info_id = $method_info->get_id();
                    $input_type_id = $method_info->get_type();
                    $input_type = new input_type($db, $input_type_id);

                    $input_type_name = $input_type->get_input_type();
                    // MULTISELECT / TWO_COLUMN / SINGLESELECT
                    if($input_type_name == USER_INTERACTION_MULTISELECT ||
                            $input_type_name == USER_INTERACTION_TWO_COLUMN ||
                            $input_type_name == USER_INTERACTION_SINGLESELECT ) {
                        $output .= "<td class=align_top>";
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
                        $output .="<table><tr>";
                        $output .= "<td class='td_spaced align_top'>";
                        $output .= self::show_method_infos_select($db, $method_info_id, $tier2id, true, $multiple, $default);
                        $output .= "</td>";
                        $output .="</tr></table>";
                        $output .= "</td>";
                        // NUMERIC ENTRY
                    } else if($input_type_name == USER_INTERACTION_NUMERIC_ENTRY) {

                        if($method_info->get_parent_id() == null) {
                            // numeric inputs with parent id will be displayed later
                            $output .= self::show_method_infos_user_input($db, $method_info_id, $tier2id);
                        } 

                        // TEXT_ENTRY
                    }  else if($input_type_name == USER_INTERACTION_TEXT_ENTRY) {
                        $output .= self::show_method_infos_user_input($db, $method_info_id, $tier2id, true);


                        // TEXT_AREA
                    } else if($input_type_name == USER_INTERACTION_TEXT_AREA) {
                        $output .= "<td class=align_top>";
                        $output .= self::show_method_info_text_area($db, $method_info_id, $tier2id);
                        $output .= "</td>";
                    }
                     // SELECT_EACH
                    else if($input_type_name == USER_INTERACTION_SELECT_EACH) {

                        $output .= "<td class=align_top>";
                        $inner_table = true;

                        if($maxcols == 1 ) {
                            // draw vertically
                            $inner_table = false;
                        }

                        if($i >= $maxcols) {
                            $output .= "</td></tr><tr><td class=align_top>";
                            $i = 0;
                        }

                        if(!$inner_table && $count == 0) {
                            // draw headers for all
                            $method_infos2 = new method_infos($db, $method_info_id);
                            $header = $method_infos2->get_header();
                            $option_header = $method_infos2->get_option_header();
                            $output .= "<tr><th class='td_spaced align_top align_right'><B><U>$header</U></B></th><th><B><U>$option_header</U></B></th></tr>";
                            $output .= "<tr>";
                            $output .= "<td class='td_spaced align_top ".(!$inner_table ? " align_right ": "")."'></tr>";
                        } else {
                            // Don't show in an inner table
                        }

                        // Actually draw the method_info
                        $output .= self::show_method_infos_select_each($db, $method_info_id, $tier2id, $inner_table, 0);
                        
                        if(!$inner_table) {
                             $output .= "</td>";
                             $output .= "</tr>";
                        } else {
                            // Don't show in an inner table
                        }
                        $output .= "</td>";

                        // CHECKBOX_SELECT
                    } else if($input_type_name == USER_INTERACTION_CHECKBOX_SELECT) {
                        $output .= "<td class=align_top>";
                        $maxcols = 1;
                        if($count == 0) {
                            $method_infos2 = new method_infos($db, $method_info_id);
                             $header = $method_infos2->get_header();
                             $opt_header = $method_infos2->get_option_header();
                            $output .= "<tr><th class='td_spaced align_top'><B><U>$header</U></B></th><th class='td_spaced align_top'><B><U>$opt_header</U></B></th></tr>";
                        } else {
                            // None found
                        }
                        if($i >= $maxcols) {
                            // New row
                            $output .= "</tr><tr>";
                            $i = 0;
                        } else {
                            // No new row
                        }
                        $inner_table = false;


                        $output .= "<tr>";
                        $output .= self::show_method_infos_select_each($db, $method_info_id, $tier2id, false, 1);
                        $output .= "</tr>";
                        $output .= "</td>";
                    } else {
                        // Unknown type
                    }

                    $i++;
                    $count++;


                }
                
                if(($method_infos[0]->get_option_header() != null) &&
                         ($input_type_name == USER_INTERACTION_NUMERIC_ENTRY ||
                            $input_type_name == USER_INTERACTION_TEXT_ENTRY)) {
                    
                     $output .= "</td>";

                } else {
                    // No need to close <td>
                }

                if($input_type_name == USER_INTERACTION_TEXT_ENTRY) {
                        $output .= "</td></tr><tr>";
                }

                $output .= "</td>";

                } else {
                    // No method infos found in this method
                }

                $output .= "</tr></table>"; 
                
            } // End foreach($method_infos_by_type)

        } else {
            // No method_infos_by_type found
        }
        $output .= "</tr></table>";

         // If there are additional methods with categories, like Fordisc (Ancestry), also show entries in Rhine format
         $output .= self::show_method_info_rhine($db, $method->get_id(), $tier2id);

         echo($output);

       }
   }    

   
    /** Displays input for a Selection method_infos object (Single-select, multi-select or checkbox)
    * 
    * @param db $db The database object
    * @param int $method_infos_id  ID of the method_infos object to display
    * @param int $tier2id ID of tier2 object, if editing existing data
    * @param boolean $header True if a header should be displayed, else false
    * @param boolean $multiple True if you can select multiple entries, else false
    * @param string $default_option The string for a default option (optional)
    * @return type HTML output for inputting data
    */
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
        } else {
            // No tier2 given
        }

        foreach($options as $option) {
            $id = $option->get_id();
            $value = $option->get_value();
            $values[$option->get_id()] = $option->get_value();
        }

        $output .= "<table class='td_spaced table_full table_horz_spacing>";
        if($header) {
            $output .= "<th class='td_spaced'><B><U>".$method_infos->get_header()."</U></B></th></tr>";
        } else {
            // No header
        }
        
        $output .= "<tr>";
        if($header && $multiple == false) {
            $output .= "<td class='align_right align_top td_spaced width_75' width=50%>".$method_infos->get_name()."</td>";
        } else {
            // No header or multiple
        }
        
        $output .= "<td class='td_spaced align_top align_left'>";

        $output .= (functions::draw_select($values, $selected, $multiple, $default_option));
        
        $output .= "</td></tr></table>";

        return $output;
    }
    
    /** Displays input for a User input method_infos object (numeric_enty, text_entry)
    * 
    * @param db $db The database object
    * @param int $method_infos_id  ID of the method_infos object to display
    * @param int $tier2id ID of tier2 object, if editing existing data
    * @param boolean $text True if this is a text entry (show longer text box)
    * @return string HTML for inputting data for this method_infos object
    */
    public static function show_method_infos_user_input($db, $method_infos_id, $tier2id = null, $text = null) {
        $method_infos = new method_infos($db, $method_infos_id);
        $options = $method_infos->get_method_info_options();
        if($options == null  || count($options) == 0) {
            // It has no options, not even a default, so there must be an error
            return "";
        } else {
            // No options found
        }
        $mi_input_type = $method_infos->get_type();
        $type = new input_type($db, $mi_input_type);
        $tname= $type->get_input_type();

        $typename="text";
        if($tname == USER_INTERACTION_NUMERIC_ENTRY) {
            $typename="number";
        } else {
            // Not numeric
        }
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
        } else {
            // No tier2 given
        }

        $size = 6;
        if($text != null && $text == true) {
            $size = 15;
        } else {
            // Don't reset size for text field
        }
        $output .= "<table class=' td_spaced'>";
        foreach($options as $op) {
            $output .= "<tr><td class='td_spaced width_250px'>".$op->get_value().": </td><td class='align_left'><input style='width:".$size."em' type='$typename' ".(($tname == USER_INTERACTION_NUMERIC_ENTRY) ? " step='0.01'" : "")." name=output_data[][".$op->get_id()."] ".(($value != "") ? ("value ='$value'") : "" )."></input></td>";
        }
        
        // Does this method have a Left/Right modifier?
        $children = $method_infos->get_children();
        if(count($children) > 0) {
            foreach($children as $child) {
                if($child->get_type() == (input_type::get_input_id_by_name($db, USER_INTERACTION_LEFT_RIGHT))) {
                    $output .= "<td>".self::show_method_infos_left_right($db, $child->get_id(), $tier2id)."</td>";
                }
            }
        } else {
            // No children to this method
        }
        
        $output .= "</tr>";
        
        $output .= "</table>";

        return $output;
        
    }
    
    /** Displays input for a select_each method_infos object 
     * 
     * @param db $db The database object
     * @param int $method_infos_id  ID of the method_infos object to display
     * @param int $tier2id ID of tier2 object, if editing existing data
     * @param boolean $inner_table True if each entry should be in its own table. False if all will be aligned in an outer table
     * @param boolean $checkboxes True if this should be displayed as checkboxes, otherwise it will be displayed as a dropdown
     * @return string HTML for inputting data for this method_infos object
     */
    public static function show_method_infos_select_each($db, $method_infos_id, $tier2id = null, $inner_table = true, $checkboxes = false) {

        $method_infos = new method_infos($db, $method_infos_id);
        $options = $method_infos->get_method_info_options();
        $output = "";
        // header
        if($inner_table) {
            $output .= "<table><tr><th class='align_right align_top td_spaced'>";
            $output .= "<B><U>".$method_infos->get_header() . "</U></B></th><th class='td_spaced align_left' ><B><U>". $method_infos->get_option_header() . "</U></B></th></tr><tr>";
        } else {
            // No inner table
        }
        $output .= "<tr><td class='align_right align_top td_spaced_short'>";
        
        $output .= $method_infos->get_name();
        if($method_infos->get_name() != null && $method_infos->get_name() != "") {
            $output .= ":";
        } else {
            // Don't add colon to name
        }
        $output .="</td>";
        

        $output .="<td class='align_left align_top td_spaced'>";
        
        $values = array();
        $selected = array();
        
        if($tier2id != null) {
            $t2 = new tier2data($db, $tier2id);
            $tier3s = $t2->get_tier3data();
            foreach($tier3s as $tier3) {
                $option_id = $tier3->get_method_info_option_id();
                $selected[] = $option_id;
            }
        } else {
            // No tier2 given
        }
        
        foreach($options as $op) {
            $values[$op->get_id()] = $op->get_value();
        }
        if(!$checkboxes) {
            $output .= (functions::draw_select($values, $selected, true));
        } else {

            $check_values = array();
                foreach($options as $option) {
                $check_values[] = array($option->get_id(),  $option->get_value());
            }
            $output .= functions::checkbox_dropdown($method_infos->get_id(), $method_infos->get_name(), $check_values, $selected, 'check_select');
        }
        $output .="</td></tr>";
        if($inner_table) {
            $output .= "</table>";
        } else {
            // No inner table
        }
        return $output;
    }

    /** Displays input for an input_box_with_dropdown method_infos object
    * 
    * @param db $db The database object
    * @param int $method_infos_id  ID of the method_infos object to display
    * @param int $tier2id ID of tier2 object, if editing existing data
    * @param string $default_option Text for an initial, unselectable default option (optional)
    * @return string HTML for inputting data for this method_infos object
    */
    public static function show_method_infos_input_box_with_dropdown($db, $method_infos_id, $tier2id=null, $default_option = null) {
        // Method info box with dropdown should have 2 method_infos whose parent_ids point back to it
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

            } else {
                // Unknown type
            }
            
        }
        if($inputbox_mi != null) {
            $output .= "<table class='td_spaced'><tr><td>";

            $output .= method_infos::show_method_infos_user_input($db, $inputbox_mi->get_id(), $tier2id);
            $output .= "</td><td class='td_spaced align_right'>";
            $output .= method_infos::show_method_infos_select($db, $dropdown_mi->get_id(), $tier2id, false, false, $default_option);
            $output .= "</td></tr></table>";
        } else {
            // Not an input box
        }
        return $output;
        
        
    }
        
   /** Shows HTML method_info input for a "text_area" method_info
    * 
    * @param method $method The method object
    * @param int $tier2id Existing info, if editing
    * @param string $user_interaction The user_interaction type
    * 
    * @return HTML output for the method
    */
   public static function show_method_info_text_area($db, $method_infos_id, $tier2id) {
        $method_infos = new method_infos($db, $method_infos_id);
        $value = "";        
        
        $options = $method_infos->get_method_info_options();

        if(count($options) == 0) {
            // It has no options, not even a default, so there must be an error
            return "";
        } else {
            $curr_option = $options[0];
            $value = "";

            if($tier2id != null) {
                $t2 = new tier2data($db, $tier2id);
                $tier3s = $t2->get_tier3data();
                // Should be one
                foreach($tier3s as $tier3) {
                    if($tier3->get_method_info_option_id() == $curr_option->get_id()) {
                        $value = $tier3->get_value();
                    } else {
                        
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
           
   }
   
       
    /** Displays input for a left/right radio button
    * 
    * @param db $db The database object
    * @param int $methodid ID of the method to add
    * @param int $tier2id ID of tier2 object, if editing existing data (optional)
    * @return string HTML output for inputting data
    */
    public static function show_method_infos_left_right($db, $method_infos_id, $tier2id=null) {
        
        return self::show_method_infos_radio($db, $method_infos_id, $tier2id);
    }
    
    /** Displays input for a radio button
    * 
    * @param db $db The database object
    * @param int $method_infos_id ID of the method to add
    * @param int $tier2id ID of tier2 object, if editing existing data (optional)
    * @param string $name Optional name for the html radio group. Defaults to "LR" for left/right radios
    * @return type HTML output for inputting data
    */
    public static function show_method_infos_radio($db, $method_infos_id, $tier2id=null, $name = "LR") {
        $output = '';

        $value = '';
        $method_info = new method_infos($db, $method_infos_id);
        $options = $method_info->get_method_info_options();
        if($tier2id !=null) {
            $tier2 = new tier2data($db, $tier2id);
            $t3s = $tier2->get_tier3data();
            $t3_opt_ids = array();
            foreach($t3s as $t3) {
                $t3_opt_ids[] = $t3->get_method_info_option_id();
            }
        } else {
            // No tier2 data given
        }
        
        foreach($options as $option) {
            
            $checked = "";
            $optionid = $option->get_id();

            if(in_array($optionid, $t3_opt_ids)) {

                $checked = " checked ";
            } else {
                // Not checked
            }
        
            $output .= "<nobr><input id=$optionid type='radio' ".$checked. " value='".$option->get_id()."' name=$name"."[$method_infos_id]>".$option->get_value()."</input></nobr>";

        }

        return $output;
    }
    
 
    // Methods to display special method types
   

    /** Displays input for a 3 column with reference method_infos object (such as Epiphyseal union)
    * 
    * @param db $db The database object
    * @param int $method_infos_id  ID of the method_infos object to display
    * @param int $tier2id ID of tier2 object, if editing existing data
    * @return string HTML for inputting data for this method_infos object
    */
    public static function show_method_info_3_col_with_ref($db, $method_id, $tier2id=null) {

        $output = "";
        $method = new method($db, $method_id);
        $cat_input_type = input_type::get_input_type_by_name($db, USER_INTERACTION_CATEGORY);
        
        $cat_query = "SELECT * from method_infos where methodid = :methodid and input_type = :input_type and parent_id is null";

        $cat_params = array("methodid"=>$method_id, 'input_type'=>$cat_input_type->get_id());

        $categories = $db->get_query_result($cat_query, $cat_params);
        $tmp_cat = $categories[0];

        $category_info = new method_infos($db, $tmp_cat['id']);
        
        // First column is a category
        $header1 = $category_info->get_header();

        // Second column is sub-categories for that first-column category
        $children = $category_info->get_children();
        $header2 = $children[0]->get_header();
        
        // Third column is  for a drop-down select list of options
        $header3 = $children[0]->get_option_header();
        
        // Fourth column is for the References
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

        } else {
            // No tier2 data given
        }

        $output .= "";
        $headers = "";
        $has_refs = false;
        $headers .= ("<table><tr><th><U><B>".$header1."</B></U></th>");
        $headers .= ("<th><U><B>".$header2."</B></U></th>");
        $headers .= ("<th><U><B>".$header3."</B></U></th>");

        $value = null;


        foreach($categories as $category) {
            $cat = new method_infos($db, $category['id']);
            $method_infos = $cat->get_children();

            // Start new row, with a row-span to span the number of sub-categories
            $output .= ("<tr><td class='align_top td_spaced' rowspan='".(count($method_infos)+1)."'>");
            $output .= $cat->get_name();
            $output .= "</td>";
            
            
            foreach($method_infos as $mi) {
                $values = array();
                $options = $mi->get_method_info_options();
                
                // Draw the method infos as sub-categories
                $output .= "<tr><td>".$mi->get_name()."</td>";

                foreach($options as $op) {
                     $values[$op->get_id()] = $op->get_value();
                }

                // Draw the third column data, a drop-down menu of options
                $output .= "<td>".(functions::draw_select($values, $selected, false, " ")). "</td>";

                // Draw references, if any,, as a checkbox-multiselect
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

                    } else {
                        // No tier2 data given
                    }

                    $alt_text = "(Click to view selected references)";
                    $references = functions::checkbox_dropdown($mi->get_id(), $mi->get_name(), $ref_list, $selected_refs, 'references', $alt_text);
                } else {
                    // No references found
                }
                $output .= "<td>$references</td></tr>";

            }
            $output .= "</tr>";
        }
        
        $output .= "</table>";

        if($has_refs == true) {
            $headers .= ("<th><U><B>".$header4."</B></U></th>");
        } else {
            $headers .= "<th></th>";
        }
        
        // Return the output
        return $headers . $output;
   }
   
    /** Displays input for a Rios_Cardoso type method_infos object 
     * It consists of several rows of checkbox drop-down menus, with both
     * row and column titles
     * 
     * @param db $db The database object
     * @param int $method_infos_id  ID of the method_infos object to display
     * @param int $tier2id ID of tier2 object, if editing existing data
     * @return string HTML for inputting data for this method_infos object
    */
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
        } else {
            // No tier2 given
        }
        
        // Get main categories
        $cat_type  = input_type::get_input_type_by_name($db, 'category');
        $cat_type_id = $cat_type->get_id();
        
        // Get main categories for column headers
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
                // Get column headers
                if(!in_array($subcat->get_name(), $headers)) {
                    $headers[] = $subcat->get_name();
                }
                $sorted_subcats[array_search($subcat->get_name(), $headers)] = $subcat;
            }
            $row .= "<tr>";
            
            // Row header
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
        // Header for the row title column
        $header_info .= "<td><B><U>$output_header</U></B></td>";
        
        // Create header row
        foreach($headers as $header) {
            $header_info .= "<td><B><U>".$header."</U></B></td>";
        }
        
        $header_info .= "</tr>";
        
        // Create table, add header row and rest of data
        $table = "<table class='table_padded'>".
                $header_info. 
                $table;
        $table .= "</table>";
        
        return $table;
        
    }
   
    /** Displays input for a Rhine type method_infos object 
     * Rhine is displayed as a series of drop-down select boxes, organized in
     * separate categories
     * 
     * @param db $db The database object
     * @param int $method_infos_id  ID of the method_infos object to display
     * @param int $tier2id ID of tier2 object, if editing existing data
     * @return string HTML for inputting data for this method_infos object
     */
    public static function show_method_info_rhine($db, $method_id, $tier2id=NULL) {
        $output = '';
        
        $method = new method($db, $method_id);
        // Get main categories
        $cat_type  = input_type::get_input_type_by_name($db, 'category');
        $cat_type_id = $cat_type->get_id();
        
        // Show any uncategorized text entries first
        
        try {
            $typeid = input_type::get_input_id_by_name($db, USER_INTERACTION_TEXT_ENTRY);
            $orphan_method_infos = $method->get_method_infos_by_type($typeid);
            $orphan_method_infos = $orphan_method_infos[$typeid];
            foreach($orphan_method_infos as $orph_info) {
                if($orph_info != null && 
                        $orph_info->get_parent_id() == null &&
                        $method->get_method_info_type() == METHOD_INFO_TYPE_RHINE) {
                    $output .= self::show_method_infos_user_input($db, $orph_info->get_id(), $tier2id);
                } else {
                    // Don't show this method_info
                }
            }

            } catch(Exception $e) {
                $output .= ($e->getTraceAsString());
            }

            $cat_query = "SELECT * from method_infos where methodid = :methodid and input_type = :input_type and parent_id is null";

            $cat_params = array("methodid"=>$method_id, 'input_type'=>$cat_type_id);

            $categories = $db->get_query_result($cat_query, $cat_params);

            foreach($categories as $category) {
                // Get method_infos
                $category_info = new method_infos($db, $category['id']);
                $name = $category_info->get_name();

                $info_query = "SELECT * from method_infos where methodid = :methodid and parent_id = :parentid";
                
                $info_params = array("methodid"=>$method_id, 'parentid'=>$category_info->get_id());

                $infos = $db->get_query_result($info_query, $info_params);

                // Draw each category in its own box
                $output .= ("<fieldset class='methodinfobox'>");
                $output .= ("<legend class='boldlegend'>".$name."</legend> ");
                $output .= ("<table class='table_padded'><tr>");
                
                //Finally, display infos
                
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
                        // Draw drop-down menu
                        $output .= "<table class='align_top'>";
                        foreach($infos as $method_infos) {
                            $output .= "<tr><td>";
                        
                            $method_info = new method_infos($db, $method_infos['id']);
                            $id = $method_info->get_id();

                            $output .= method_infos::show_method_infos_input_box_with_dropdown($db, $id, $tier2id, $default_option);
                            $output .= "</td></tr>";
                        }
                        $output  .= "</table>";
                } else if($input_type_name == USER_INTERACTION_SELECT_EACH) {
                    // Draw select-each
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
                
                else if($input_type_name == USER_INTERACTION_SINGLESELECT) {
                    // Draw single-select
                    $output .= "<table>";
                    foreach($infos as $method_infos) {
                        $method_info = new method_infos($db, $method_infos['id']);
                        $id = $method_info->get_id();
                        
                        $output .= "<tr><td class='td_spaced align_top'>";
                        $output .= self::show_method_infos_select($db, $id, $tier2id,true, false, '- Select One -');
                        $output .= "</td></tr>";
                    }
                    $output .= "</table>";
                } else if($input_type_name == USER_INTERACTION_NUMERIC_ENTRY) {
                    // Draw numeric entries
                    foreach($infos as $method_infos) {
                        $method_info = new method_infos($db, $method_infos['id']);
                        $method_info_id = $method_info->get_id();
                        $output .= self::show_method_infos_user_input($db, $method_info_id, $tier2id);
                    }
                }  else if($input_type_name == USER_INTERACTION_TEXT_ENTRY) {
                    // Draw text-entries
                    foreach($infos as $method_infos) {
                        $method_info = new method_infos($db, $method_infos['id']);
                         $method_info_id = $method_info->get_id();
                        $output .= self::show_method_infos_user_input($db, $method_info_id, $tier2id, true);
                    }
                } else if($input_type_name == USER_INTERACTION_TEXT_AREA) {
                    // Draw text-areas
                    foreach($infos as $method_infos) {
                        $method_info = new method_infos($db, $method_infos['id']);
                        $method_info_id = $method_info->get_id();
                        $output .= self::show_method_info_text_area($db, $method_info_id, $tier2id);
                    }
                } else {
                    // Unknown type
                }
                
                $output .= "</td>";
            } // end drawing method infos within the category
            
            $output .= "</tr></table></fieldset>";
            
            } // end drawing categories
            
            return $output;
            
    }
    
    
    /** Displays input for a Spradley_Jantz type method_infos object 
    * 
    * Spradley-Jantz starts out with a drop-down menu of main categories.
    * When one of those is selected, it displayes a series of boxes with 
    * method infos within them.
    * The method infos consist of input_box_with_dropdowns (with L/R radio buttons for the input box)
    *  and select_each boxes
    * @param db $db The database object
    * @param int $method_infos_id  ID of the method_infos object to display
    * @param int $tier2id ID of tier2 object, if editing existing data
     * @return string HTML for inputting data for this method_infos object
     */
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
            
        // Show initial dropdown box. When something is selected here, it will show
        // more boxes containing method infos for that category
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
            
            // Draw all the sub categories and method infos in a <div> tag.
            // This div will be hidden until its category is selected from the
            // original drop-down menu
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
                        // Draw input boxex, L/R buttons, and drop_down
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
                    // Draw the select_each boxes.
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
            
                    
        } // end foreach($sub_categories)
        $output .= "</div>";
    } // end foreach($categories)
    
        return $output;
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
         $this->parent_id = $data['parent_id'];
        } else {
            // Not found
        }
    }

}
