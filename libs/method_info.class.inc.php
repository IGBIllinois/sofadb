<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/** Static data for Tier3 information 
 * 
 */
class method_info {
    
    private $id;
    private $methodid;
    private $output_data_1;
    private $output_data_2;
    private $output_data_3;
    private $output_data_4;
    private $output_data_1_description;
    private $output_data_2_description;
    private $output_data_3_description;
    private $output_data_4_description;
    private $reference_list;
    private $age_range;
    private $user_interaction;
    
    
    private $db; // Database object
    
    public function __construct($db, $id = null) {

        $this->db = $db;

        if($id != null) {
            $this->load_method_info($id);
            
        }  
    }
    
    public function get_id() {
        return $this->id;
    }
    
    public function get_methodid() {  
        return $this->methodid;
    }
    
    public function get_output_data_1() {
        return $this->output_data_1;
    }
    
    public function get_output_data_2() {
        return $this->output_data_2;
    }
    
    public function get_output_data_3() {
        return $this->output_data_3;
    }
    
    public function get_output_data_4() {
        return $this->output_data_4;
    }
    
    public function get_output_data_1_description() {
        return $this->output_data_1_description;
    }
    
    public function get_output_data_2_description() {
        return $this->output_data_2_description;
    }
    
    public function get_output_data_3_description() {
        return $this->output_data_1_description;
    }
    
    public function get_output_data_4_description() {
        return $this->output_data_2_description;
    }
    
    public function get_age_range() {
        return $this->age_range;
    }
    
    public function get_user_interaction() {
        return $this->user_interaction;
    }

    /** Formats tier3 data for use in the table
     * 
     * @return string A string formatting the all the tier3 data for this method info
     */
    public function format_tier3data() {
        $info = $this->get_tier3data();
        $method = new method($this->db, $this->get_methodid());
        $output = "";
        foreach($info as $tier_info) {
                

                $q = "SELECT * from method_info where id = :methoddataid";
                $params = array("methoddataid"=>$tier_info->get_methodinfoid());
                $result = $this->db->get_query_result($q, $params);
                foreach($result as $tier3) {

                    $output .= "(".$tier3['output_data_1']. ", ".$tier3['output_data_2'].") ";
                }

        }
        return $output;
    }
    
    /** Gets all output_data_2 for an output_data_1
     * Used for select_each method_info types
     * 
     * @param od1 The output_data_1 field
     */
    public function get_od2_for_od1($od1, $category=null, $subcategory=null) {
        $query = "SELECT output_data_2 from method_info where methodid=:methodid and output_data_1=:od1";
        $params = array("methodid"=>$this->methodid,
                        "od1"=>$od1);
        if($category != null) { 
            $query .= " AND output_data_3 = :category ";
            $params['category'] = $category;
        }
        if($subcategory != null) { 
            $query .= " AND output_data_4 = :subcategory ";
            $params['subcategory'] = $subcategory;
        }
        $result = $this->db->get_query_result($query, $params);
        if(count($result > 0)) {
            return $result;
        }
    }
    
    /** Gets all the user_interaction types used in this method_info
     * 
     * @return type array of user_interaction types for this method_info
     */
    public function get_user_interactions() {
        $query = "SELECT distinct user_interaction from method_info where methodid = :methodid order by field(user_interaction, '".USER_INTERACTION_INPUT_BOX."') DESC";
        $params = array("methodid"=>$this->methodid);
        $result = $this->db->get_query_result($query, $params);
        return $result;
    }
    
    public function get_references() {
        $ref_array = explode(",",$this->reference_list);
        $in  = str_repeat('?,', count($ref_array) - 1) . '?';
        $query = "SELECT * from reference where id in ($in)";
        $result = $this->db->get_query_result($query, $ref_array);

        return $result;
    }
    
    
    // Static functions
    
    /** Adds a new method_data to to a case
     * 
     * @param db $db The database object
     * @param int $caseid ID of the method_case to add the method_data to
     * @param int $methodid ID of the method used
     * @param int $method_data_id ID of the method_data for the case
     * @return array An array of the form ("RESULT"=>[TRUE | FALSE],
     *          "MESSAGE"=>$message)
     * where "RESULT" is true if successful, else false, and 
     * "MESSAGE" is an output message
     */
        public static function add_method_data($db,
                                $caseid,
                                $methodid,
                                $method_data_id) {
        
        $case = new sofa_case($db, $caseid);
        $method = new method($db, $methodid);
        
            
            $query = "INSERT INTO method_data (caseid, methodid, methoddataid) VALUES "
                    . "(:caseid, :methodid, :methoddataid)";
            $params = array("caseid"=>$caseid,
                            "methodid"=>$methodid,
                            "methoddataid"=>$methoddataid);
            
            $result = $db->get_insert_result($query, $params);
            if($result > 0) {
                return array("RESULT"=>TRUE,
                            "MESSAGE"=>"Method data added successfully.");
                
            } else {
                return array("RESULT"=>FALSE,
                            "MESSAGE"=>"Method data not added.");
            }
            
        
    }
    
    /** Gets all the method_info data for a method
     * 
     * @param db $db The database object
     * @param int $methodid ID of the method
     * @param string $category additional optional category used for some methods
     * 
     * @return \method_info An array of method_info objects for this method
     */
    public static function get_data_for_method($db, $methodid, $category=null) {

            $query = "SELECT id from method_info where methodid = :methodid";
            $params = array("methodid"=>$methodid);
            if($category != null) {
                $query .= " AND output_data_3 = :category ";
                $params['category'] = $category;
            }
            $result = $db->get_query_result($query, $params);

            //return $result;
            $tier3s = array();
            foreach($result as $tier3) {
                $new_tier3 = new method_info($db, $tier3['id']);
                $tier3s[] = $new_tier3;
            }
            return $tier3s;
        
    }
    
    /**
     * Gets method_info data for a method based on user_interaction type
     * @param db $db The database object
     * @param int $methodid Method ID
     * @param string $user_interaction user_interaction type
     * @return \method_info An array of method_info objects for this method of the given
     * user_interaction type
     */
    public static function get_data_for_method_by_type($db, $methodid, $user_interaction) {

            $query = "SELECT id from method_info where methodid = :methodid and user_interaction = :user_interaction";
            $params = array("methodid"=>$methodid, "user_interaction"=>$user_interaction);
            $result = $db->get_query_result($query, $params);

            //return $result;
            $tier3s = array();
            foreach($result as $tier3) {
                $new_tier3 = new method_info($db, $tier3['id']);
                $tier3s[] = $new_tier3;
            }
            return $tier3s;
        
    }
    
    /** Gets a single method_info for a method
     * 
     * @param db $db The database object
     * @param int $methodid ID of the method
     * @param string $od1 Name of the ouput_data_1 for the method_info
     * @param string $od2 Name of the output_data_2 for the method_info (optional)
     * @return \method_info|null An method_info object fitting the criteria, or null if there are none
     */
    public static function get_one_method_info($db, $methodid, $od1, $od2=null) {

            if($od2 != null) {
                $query = "SELECT id from method_info where methodid=:methodid and output_data_1=:od1 and output_data_2=:od2";
                $params = array("methodid"=>$methodid, 
                                "od1"=>$od1,
                                "od2"=>$od2);
            } else {
                $query = "SELECT id from method_info where methodid=:methodid and output_data_1=:od1";
                $params = array("methodid"=>$methodid, 
                                "od1"=>$od1);
            }

            $result = $db->get_query_result($query, $params);

            if(count($result) > 0) {
                $id = $result[0]['id'];
                $method_info = new method_info($db, $id);
                return $method_info;
            } else {
                return null;
            }
    }
    
    
    
    /** Shows the method info selection boxes based on a method id and (optionally)
    * a tier2 id if the data already exists (for editing)
    * 
    * @global type $db
    * @param type $method_id
    * @param type $tier2id
    */
   public static function show_method_info($db, $method_id, $tier2id=null, $category=null) {

      if($tier2id != null) {
          $tier2 = new tier2data($db, $tier2id);
          $tier3s = $tier2->get_tier3data();
      }

       echo("<BR>");

       $method = new method($db, $method_id);


       $output_data_1_result = $method->get_data_1();
       $output_data_2_result = $method->get_data_2();   

       $header1 = $method->get_header_1();
       $header2 = $method->get_header_2();
       
       if($method->get_method_info_type() == METHOD_INFO_TYPE_SPRADLEY_JANTZ) {
           
           //method_info::show_method_info_spradley_jantz($db, $method, $tier2id, $category);
           //echo("method_id = $method_id<BR>");
            $category_query = "SELECT DISTINCT output_data_3, output_data_3_description from method_info where methodid = :methodid";
            $params = array("methodid"=>$method->get_id());
            echo("<input type=hidden id='method_id' name='method_id' value='$method_id'>");
            $result = $db->get_query_result($category_query, $params);
            echo("<B><U>".$result[0]['output_data_3_description']."</U></B><BR>");
            echo("<select id='category' name='category[]' onchange='show_category();'>");
            echo("<option name='none'></option>");
            foreach($result as $category) {
                $name = $category['output_data_3'];
                echo("<option name='$name'>$name</option>");
            }
            echo("</select>");
       
       
       } else {
           
       
       $methodinfos = array();
       if($tier2id != null) {
           $tier2 = new tier2data($db, $tier2id);
           $data = $tier2->get_tier3data();
           
           foreach($data as $tier_info) {
               $method_info = new method_info($db, $tier_info->get_methodinfoid());
               $methodinfos[] = $method_info; 
           }
       }
       
       $method_info = method_info::get_data_for_method($db, $method_id);
       
       if(count($method_info) > 0) {
           //$user_interaction = $method_info[0]->get_user_interaction();
           $interactions = $method_info[0]->get_user_interactions();
           echo("<table class='table_full'><tr>");
           foreach($interactions as $user_interaction) {
               echo("<td class='align_top'>");
               
               $user_interaction = $user_interaction[0];
               //echo("user interaction = $user_interaction<BR>");
           if($user_interaction == USER_INTERACTION_MULTISELECT ||
                   $user_interaction == USER_INTERACTION_SINGLE_SELECT) {
               
               method_info::show_method_info_multiselect($method, $user_interaction);

           } else if($user_interaction == USER_INTERACTION_SELECT_RANGE) {
               
               method_info::show_method_info_select_range($method, $tier2id);
               
           } else if($user_interaction == USER_INTERACTION_SELECT_EACH) {
               
               method_info::show_method_info_select_each($db, $method, $tier2id);

           } else if($user_interaction == USER_INTERACTION_INPUT_BOX ||
                   $user_interaction == USER_INTERACTION_NUMERIC_ENTRY) {

               method_info::show_method_info_input($db, $method, $tier2id, $user_interaction);
               
            } else if($user_interaction == USER_INTERACTION_3_COL_W_REF) {
                
                method_info::show_method_info_3_col_with_ref($db, $method, $tier2id);

            } else if($user_interaction == USER_INTERACTION_INPUT_BOX_WITH_DROPDOWN) {
                
                method_info::show_method_info_user_input_with_dropdown($db, $method, $tier2id);
            }
           }
       echo("</td>");
       }
       echo("</tr></table>");
       }
   
   }
   
   /** Show the two columns for selecting tier3 data for a 
    *  one or two-columned multiselect method
    * 
    * @param type $method The method object to draw inputs for
    */
   public static function show_method_info_multiselect($method, $user_interaction = null) {
            // Notes to user
            //$user_interaction = USER_INTERACTION_MULTISELECT;
       $header1 = $method->get_header_1();
       $header2 = $method->get_header_2();
       
       $multiple = 1;

       if($user_interaction == USER_INTERACTION_SINGLE_SELECT) {

           $multiple = 0;

       }
       if($user_interaction == USER_INTERACTION_MULTISELECT) {
            echo("<legend><I>(hold CTL to select multiple)</I></legend>");
       }
            $output_data_1_result_sel = $method->get_data_1($user_interaction);
            $output_data_2_result_sel = $method->get_data_2($user_interaction);
            $method_info = $method->get_method_info_by_type($user_interaction);

               
           echo("<table>");
           echo("<tr><th class='td_spaced'><B><U>".$header1."</U></B></th>");
           
           if(count($output_data_2_result_sel) > 0) {
               echo("<th class='td_spaced'><B><U>".$header2."</U></B></th>");
           }
           echo("</tr>");
           
           echo("<tr><td class='td_spaced align_top'>");

           
           $size = count($output_data_1_result_sel);
           echo("<select id='output_data_1' ". (($multiple == 1) ? " multiple size=$size " : "" ) ." name=output_data_1[] >");

                foreach($output_data_1_result_sel as $od1_result) {
                    $selected = false;
                    foreach($methodinfos as $method_info) {
                        if($method_info->get_output_data_1() == $od1_result['output_data_1']) {
                            $selected = true;
                            break;
                        }
                    }
                    echo("<option value='".$od1_result['output_data_1']."' ".($selected ? " selected=$selected " : "") .">".$od1_result['output_data_1']."</option>");

                }
                echo("</select>");
            
           echo("</td>");

           if(count($output_data_2_result_sel) > 0) {
               echo("<td class='td_spaced align_top'>");
               $selected = false;
               $size2 = count($output_data_2_result_sel);
                   // output a select box
                echo("<select id='output_data_2' ". (($multiple == 1) ? " multiple size=$size2 " : "" ) ." name=output_data_2[] >");
                foreach($output_data_2_result_sel as $od2_option) {
                    foreach($methodinfos as $method_info) {
                        if($method_info->get_output_data_2() == $od2_option['output_data_2']) {
                            $selected = true;
                        } else {
                            $selected = false;
                        }
                    }
                    echo("<option value='".$od2_option['output_data_2']."' ".($selected ? " selected=$selected " : "") .">".$od2_option['output_data_2']."</option>");

                }
                echo("</select>");
               
           }
           echo("</td></tr></table>");
       
   }
   
   /** Shows HTML method_info input for a "select_range" method_info
    * 
    * @param method $method The method object
    * @param int $tier2id Existing info, if editing
    */
   public static function show_method_info_select_range($method, $tier2id=null) {
       
       $header1 = $method->get_header_1();
       $header2 = $method->get_header_2();
       $user_interaction = USER_INTERACTION_SELECT_RANGE;
    echo("<legend><I>(hold CTL to select multiple)</I></legend>");
    echo("<table><tr>");
    

    $value = null;
    $i = 0;
        //$method = new method($db, $method_id);
        $this_method_info = $method->get_method_info();
        foreach($this_method_info as $method_info) {
            
            if($i >= MAXCOLS) {
                $html .="</tr><tr>";
                $i=0;
            }
            echo("<td class='align_top width_20'>");
            echo("<table class='table_padded'><tr><th width=50% class='align_right align_top'><U><B>".$header1."</B></U></th>");
            echo("<th><U><B>".$header2."</B></U></th>");

            echo("</tr>");
            $value = null;
            if($tier2id != null) {
                // Find existing value
                $tier2 = new tier2data($db, $tier2id);
                $data = $tier2->get_tier3data();
                foreach($data as $tier3) {
                    if($tier3->get_methodinfoid() == $method_info->get_id()) {
                        $value = $tier3->get_value();
                    }
                }
            }

            $range = $method_info->get_output_data_2();

            $positive_start = strpos($range, "-");


            if($positive_start !== false && $positive_start == 0) {
                // first positition is a dash, negative start
                $range = substr($range, 1);
                $ranges = explode("-", $range);
                $ranges[0] = "-" . $ranges[0];

            } else {
                $ranges = explode("-", $range);
            }

            $name = $method_info->get_output_data_1();
            //In case name has spaces, encode it
            $outputname = urlencode($name);
            $size = $ranges[1] - $ranges[0] +1;
            $selectbox = "<select size=$size name=output_data_1[$outputname][] multiple>";

            for($curr_range = $ranges[0]; $curr_range <= $ranges[1]; $curr_range++) {
                $selected = false;
                if($tier2id != null) {
                    foreach($tier3s as $tier3) {
                        $method_info_id = $tier3->get_methodinfoid();
                        $value = $tier3->get_value();
                        if($method_info_id == $method_info->get_id() &&
                                $value == $curr_range) {
                            $selected = true;
                            break;
                        }
                    }
                }

                $selectbox .= "<option  value='".$curr_range."'";
                if($selected == true) {
                    $selectbox .= " selected=1 ";
                }
                $selectbox .= ">$curr_range</option>";                           

            }
            $selectbox .="</select>";

            echo("<tr><td class='align_right align_top'>".$name.":</td><td class='align_top'> $selectbox </td></tr>");
            echo("</table>");
            echo("</td>");
            $i++;

            }
            echo("</table>");

   }
   
    /** Shows HTML method_info input for a "select_each" method_info
    * 
    * @param method $method The method object
    * @param int $tier2id Existing info, if editing
    */
   public static function show_method_info_select_each($db, $method, $tier2id, $category=null, $subcategory=null) {
       $user_interaction = USER_INTERACTION_SELECT_EACH;
       $header1 = $method->get_header_1();
       $header2 = $method->get_header_2();

        echo("<legend><I>(hold CTL to select multiple)</I></legend>");
        echo("<table><tr>");    

        $value = null;
        $i = 0;

            $value = null;
            if($tier2id != null) {

                   $tier2 = new tier2data($db, $tier2id);
                   $data = $tier2->get_tier3data();
                   
                   foreach($data as $tier_info) {
                       $method_info = new method_info($db, $tier_info->get_methodinfoid());
                       $methodinfos[] = $method_info; 
                   }
               }

               $method_info = $method->get_method_info_by_type($user_interaction);
               $header1 = $method_info[0]->get_output_data_1_description();
               $header2 = $method_info[0]->get_output_data_2_description();


               echo("</tr>");
               $value = null;


               $output_data_1_result_sel = $method->get_data_1($user_interaction, $category, $subcategory);
               $output_data_2_result_sel = $method->get_data_2($user_interaction, $category, $subcategory);
               
               $maxCols = MAXCOLS;
               foreach($output_data_1_result_sel as $od1_result) {
                   $length = strlen($od1_result[0]);
                   $width_class ="";
                   if($length > 50) {
                       // for long names, separate into their own columns vertically
                       $maxCols = 1;
                       $width_class = " width_75 ";
                       break;
                   }
               }

               
               foreach($output_data_1_result_sel as $od1_result) {
                    if($i >= $maxCols) {
                        echo "</tr><tr>";
                        $i=0;
                    }
                    $name = $od1_result[0];
                    $od2_data = $method->get_od2_for_od1($name);
                    
                    $curr_method_info = $method->get_method_info_by_od1($name);
                    $header1 = $curr_method_info[0]->get_output_data_1_description();
                    echo("<td  class='align_top td_spaced'>");
                    echo("<table  class='td_spaced table_full'><tr><th width=50% class='align_right align_top td_spaced'><U><B>".$header1."</B></U></th>");
                    echo("<th><U><B>".$header2."</B></U></th>");

                    echo("</tr>");

                   
                   //In case name has spaces, encode it
                   $outputname = urlencode($name);
                   

                   $size = count($od2_data);
                   $selectbox = "<select class='align_left' size=$size name=output_data_1[$outputname][] multiple>";

                   foreach($od2_data as $od2) {
                       $od2 = $od2['output_data_2'];
                       $selected = false;
                       if($tier2id != null) {
                           foreach($methodinfos as $method_info) {
                                   if($method_info->get_output_data_1() == $name &&
                                      $method_info->get_output_data_2() == $od2) {
                                       $selected = true;
                                   }
                               }
                       }
                       $selectbox .= "<option  value='".$od2."'";
                           if($selected) {
                               // it exists in the database
                               $selectbox .= " selected=1 ";
                           }
                           $selectbox .= ">$od2</option>";                           
                   }

                   $selectbox .="</select>";

               echo("<tr><td class='align_right align_top td_spaced $width_class'>".$name.":</td><td class='align_left align_top td_spaced'> $selectbox </td></tr>");
               
                echo("</table>");
                echo("</td>");
                $i++;
               }

        echo("</table>");
   }
   
      /** Shows HTML method_info input for a "user_input" method_info
    * 
    * @param method $method The method object
    * @param int $tier2id Existing info, if editing
    * @param string $user_interaction The user_interaction type
    */
   public static function show_method_info_input($db, $method, $tier2id, $user_interaction, $category=null) {
       
        $output_data_1_result_sel = $method->get_data_1($user_interaction, $category);
        echo("<table >");
        if($tier2id != null) {
            $tier2 = new tier2data($db, $tier2id);
            $data = $tier2->get_tier3data();
            $this_method = new method($db, $tier2->get_methodid());
            $this_method_info = $this_method->get_method_info_by_type($user_interaction);
            $value = "";

            foreach($this_method_info as $method_info) {

                $value = "";
                foreach($data as $tier3) {
                    if($tier3->get_methodinfoid() == $method_info->get_id()) {
                        $value = $tier3->get_value();
                    }
                }
                $name = $method_info->get_output_data_1();
                echo("<tr><td class='no_wrap'>".$name.":</td><td> <input size=6 id='$name' name='output_data_1[$name]' value='$value'></td></tr>");
            }
     } else {
        foreach($output_data_1_result_sel as $od1_result) {
            $name = $od1_result['output_data_1'];
            echo("<tr><td class='no_wrap'>".$name.":</td><td> <input size=6 id='$name' name='output_data_1[$name]'></td></tr>");
        }
    }
    echo("</table>");
   }
   
      /** Shows HTML method_info input for a "3_col_with_ref" method_info
    * 
    * @param db $db The database object
    * @param method $method The method object
    * @param int $tier2id Existing info, if editing
    */
   public static function show_method_info_3_col_with_ref($db, $method, $tier2id=null) {
       
       $header1 = $method->get_header_1();
       $header2 = $method->get_header_2();
       
       $output_data_1_result = $method->get_data_1();
       $output_data_2_result = $method->get_data_2(); 
       
       $methodinfos = array();
            if($tier2id != null) {
                   $tier2 = new tier2data($db, $tier2id);
                   $data = $tier2->get_tier3data();
                   
                   foreach($data as $tier_info) {
                       $method_info = new method_info($db, $tier_info->get_methodinfoid());
                       $methodinfos[] = $method_info; 
                   }
               }
               
                    $header3 = $method->get_header_3();
                    $header4 = $method->get_header_4();

               echo("<table  style='table_full table_padded'><tr><th><U><B>".$header1."</B></U></th>");
               echo("<th><U><B>".$header2."/".$header3."</B></U></th>");

               echo("</tr>");
               $value = null;

               foreach($output_data_1_result as $od1_result) {
                   $reflist = array();
                   $tmp_references = null;
                   
                   $name = $od1_result[0];
                   //In case name has spaces, encode it
                   $outputname = urlencode($name);
                   $od2_data = $method->get_od2_for_od1($name, 1);
                   $selected = false;
                   $od3 = "";
                   $od3 .= "<table >";
                   foreach($od2_data as $od2) {
                       $od2 = $od2['output_data_2'];
                       $tmp_od3 = "";
                       $reflist = array();
                       foreach($methodinfos as $tmp_methodinfo) {
                           if($outputname == $tmp_methodinfo->get_output_data_1() &&
                                   $od2 == $tmp_methodinfo->get_output_data_2()) {
                               $selected = true;

                               $t3 = $tier2->get_tier3data($tmp_methodinfo->get_id());
                               if($t3 != null) {

                               $tmp_references = $t3[0]->get_references();
                               }

                               $reflist = array_map('trim', (explode(",", $tmp_references)));
                               
                               $tmp_od3 = $tmp_methodinfo->get_output_data_3();
                           }
                       }
                   $od3_data = $method->get_output_data_3($name, $od2);
                   $od2_encode = urlencode($od2);
                   $od3 .="<tr><td class='width_250px'>$od2</td>";
                   $od3 .= "<td ><select name=output_data_1[$outputname][$od2_encode][]>";
                   $od3 .= "<option value=''></option>";
                   foreach($od3_data as $output_data_3) {
                       $od3 .= "<option  value='".$output_data_3['output_data_3']."'";
                           if($tmp_od3 == $output_data_3['output_data_3']) {
                               // it exists in the database
                               $od3 .= " selected=1 ";
                           }
                           $od3 .= ">".$output_data_3['output_data_3']."</option>";    
                   }
                   $od3 .="</select>";
                   $od3 .="</td><td>";
                   

                   $method_infos = $method->get_method_info_by_od1($name, $od2);


                   $first_method_info = $method_infos[0];

                   if($first_method_info != null) {
                    $reference_data = $first_method_info->get_references();
                    $elementId = "checkboxes_".$outputname."_".str_replace(" ", "_",$od2);
                    //$elementId = "checkboxes[".$output_name."][".urlencode($od2)."]";
                    $ref_text = '<div class="multiselect table_full" >';
                    $ref_text .= '<div class="selectBox" onclick="showCheckboxes('.$elementId.')">';
                    $ref_text .= "<select name=references[$outputname][$od2_encode][] class='table_full'>";
                    $ref_text .= '<option>Select an option</option>';
                    $ref_text .= '</select>';
                    $ref_text .= '<div class="overSelect"></div>';
                    $ref_text .= '</div>';
                    $ref_text.= '<div class="checkboxes" id="'.$elementId.'">';

                    foreach($reference_data as $ref) {

                        $refid = $elementId ."[".$ref['id']."]";
                        $refname = $ref['reference_name'];
                        $ref_text .= ("<label for='$refid'>");
                        $curr_name = "references[$outputname][$od2_encode]"."[".$ref['id']."]";
                        $ref_text .= ("<input type='checkbox' id='$refid' name='$curr_name'".(in_array($ref['id'], $reflist)? " checked=1 " : "")." />$refname</label>");
                    }
                    
                    $ref_text .= "</div></div>";
                   }
              
                    $od3 .= $ref_text;
                   $od3 .= "</td></tr>";
                   }
                   $od3 .="</table>";
               echo("<tr><td class='align_top td_spaced'>".$name.":</td><td class='td_spaced'> $od3 </td></tr>");
       }
   }
   
      /** Shows HTML method_info input for a "user_input_with_dropdown" method_info
    * 
    * @paramd db $db The database object
    * @param method $method The method object
    * @param int $tier2id Existing info, if editing
       * @param string category Category (like "UpperAppendicular") to get input for
       * @param string subcategory Sub-category (like "Clavicle") to get input for
    */
   public static function show_method_info_user_input_with_dropdown($db, $method, $tier2id, $category=null, $subcategory=null) {

       $user_interaction = USER_INTERACTION_INPUT_BOX_WITH_DROPDOWN;
       $od1s = $method->get_data_1($user_interaction, $category, $subcategory);
       
       foreach($od1s as $id=>$name) {
           $name = $name[0];

       $method_infos = $method->get_method_info_by_od1($name);
       $method_info = $method_infos[0];
       $method_info_id = $method_info->get_id();

       $output_data_1_result_sel = $method->get_data_1($user_interaction, $category, $subcategory);
        echo("<table class='td_spaced'>");
        
        if($tier2id != null) {
            
            $tier2 = new tier2data($db, $tier2id);
            $tier3s = $tier2->get_tier3data(); 
            
            
            $od2s = $method_info->get_od2_for_od1($name, $category, $subcategory);
            $urlName = urlencode($name);
            if(count($od2s) > 0) {
                foreach($od2s as $tmp_od2) {
                    $tmp_method_info = method_info::get_one_method_info($db, $method->get_id(), $name, $tmp_od2[0]);
                    foreach($tier3s as $tier3) {
                        if($tmp_method_info != null && $tmp_method_info->get_id() == $tier3->get_methodinfoid()) {
                            $sel_od2 = $tmp_method_info->get_output_data_2();
                            $value = $tier3->get_value();
                        }
                    }
                }
                
                echo("<tr><td class='width_33'>".$name.":</td><td> <input size=6 id='$name' name='output_data_1[$name]' value='$value'></td>");
                echo("<td><select name=output_data_2[$urlName]>");
            
                foreach($od2s as $od2) {
                    $od2_name = $od2[0];
                    $url_od2 = urlencode($od2_name);
                    echo("<option name='$url_od2'". ($od2_name == $sel_od2 ? " SELECTED " : "") . ">$od2_name</option>");
                }
                echo("</select></td></tr>");
                
            
            }
        
             
            
     } else {

            echo("<tr><td class='width_33'>".$name.":</td><td> <input size=6 id='$name' name='output_data_1[$name]'></td>");
            $od2s = $method_info->get_od2_for_od1($name, $category, $subcategory);
            $urlName = urlencode($name);
            if(count($od2s) > 0) {
                echo("<td><select name=output_data_2[$urlName]>");
            
                foreach($od2s as $od2) {
                    $od2_name = $od2[0];
                    $url_od2 = urlencode($od2_name);
                    echo("<option name='$url_od2'>$od2_name</option>");
                }
                echo("</select></td></tr>");
                
            }

    }
       }
    echo("</table>");
       
       
   }
   
   
   public static function show_method_info_spradley_jantz($db, $method, $tier2id, $category) {
       
       $methodinfos = array();
       if($tier2id != null) {
           $tier2 = new tier2data($db, $tier2id);
           $data = $tier2->get_tier3data();
           
           foreach($data as $tier_info) {
               $method_info = new method_info($db, $tier_info->get_methodinfoid());
               $methodinfos[] = $method_info; 
           }
       }
       $all_method_info = method_info::get_data_for_method($db, $method->get_id(), $category);
       $bones = array();
       $method_infos_by_bone = array();
       foreach($all_method_info as $curr_method_info) {
           $bone = $curr_method_info->get_output_data_4();
           if(!in_array($bone, $bones)) {
               $bones[] = $bone;
               $method_infos_by_bone[$bone][] = $curr_method_info;
               
           }

       }

       
       
       if(count($all_method_info) > 0) {
           foreach($method_infos_by_bone as $bone=>$method_info) {
               $subcategory=$bone;
           $interactions = $method_info[0]->get_user_interactions();
           echo("<fieldset class='methodinfobox'>");
           echo("<legend class='boldlegend'>".$subcategory."</legend> ");
           echo("<table class='table_padded'><tr>");
           foreach($interactions as $user_interaction) {
               echo("<td class='align_top'>");
               
               $user_interaction = $user_interaction[0];
            if($user_interaction == USER_INTERACTION_INPUT_BOX ||
                   $user_interaction == USER_INTERACTION_NUMERIC_ENTRY) {

               method_info::show_method_info_input($method, $tier2id, $user_interaction, null, $category, $subcategory);
               
            } else if($user_interaction == USER_INTERACTION_SELECT_EACH) {
               
               method_info::show_method_info_select_each($db, $method, $tier2id, $category, $subcategory);

           }else if($user_interaction == USER_INTERACTION_INPUT_BOX_WITH_DROPDOWN) {
                
                method_info::show_method_info_user_input_with_dropdown($db, $method, $tier2id, $category, $subcategory);
            }
           
                  echo("</td>");
       }
       echo("</tr></table></fieldset>");
       }
   
       
       }
   }
    
    private function load_method_info($id) {

            $query = "SELECT * from method_info where id=:id";
            $params = array("id"=>$id);
            $result = $this->db->get_query_result($query, $params);

            if(count($result) > 0) {
                $data = $result[0];

            $this->id = $id;
             $this->methodid = $data['methodid'];
             $this->output_data_1 = $data['output_data_1'];
             $this->output_data_2 = $data['output_data_2'];
             $this->output_data_3 = $data['output_data_3'];
             $this->output_data_4 = $data['output_data_4'];
             $this->output_data_1_description = $data['output_data_1_description'];
             $this->output_data_2_description = $data['output_data_2_description'];
             $this->output_data_3_description = $data['output_data_3_description'];
             $this->output_data_4_description = $data['output_data_4_description'];
             $this->reference_list = $data['reference_list'];
             $this->age_range = $data['age_range'];
             $this->user_interaction = $data['user_interaction'];
            }

    }
}