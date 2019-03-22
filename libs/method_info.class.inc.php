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
    private $output_data_1_description;
    private $output_data_2_description;
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
    
    public function get_output_data_1_description() {
        return $this->output_data_1_description;
    }
    
    public function get_output_data_2_description() {
        return $this->output_data_2_description;
    }
    
    public function get_age_range() {
        return $this->age_range;
    }
    
    public function get_user_interaction() {
        return $this->user_interaction;
    }

    
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
     */
    public function get_od2_for_od1($od1) {
        $query = "SELECT output_data_2 from method_info where methodid=:methodid and output_data_1=:od1";
        $params = array("methodid"=>$this->methodid,
                        "od1"=>$od1);
        $result = $this->db->get_query_result($query, $params);
        if(count($result > 0)) {
            return $result;
        }
    }
    
    
    // Static functions
    
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
    
    public static function get_data_for_method($db, $methodid) {

            $query = "SELECT id from method_info where methodid = :methodid";
            $params = array("methodid"=>$methodid);
            $result = $db->get_query_result($query, $params);

            //return $result;
            $tier3s = array();
            foreach($result as $tier3) {
                $new_tier3 = new method_info($db, $tier3['id']);
                $tier3s[] = $new_tier3;
            }
            return $tier3s;
        
    }
    
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
   public static function show_method_info($db, $method_id, $tier2id=null) {

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

       if($tier2id != null) {
           $tier2 = new tier2data($db, $tier2id);
           $data = $tier2->get_tier3data();
           $methodinfos = array();
           foreach($data as $tier_info) {
               $method_info = new method_info($db, $tier_info->get_methodinfoid());
               $methodinfos[] = $method_info; 
           }
       }

       $method_info = method_info::get_data_for_method($db, $method_id);
       if(count($method_info) > 0) {
           $user_interaction = $method_info[0]->get_user_interaction();
           if($user_interaction == USER_INTERACTION_MULTISELECT) {

               // Notes to user
               echo("<legend><I>(hold CTL to select multiple)</I></legend>");

           echo("<table><tr><th>".$header1."</th>");
           if($header2 != null) {
               echo("<th>".$header2."</th>");
           }
           echo("</tr><tr><td>");
           echo("<select id='output_data_1' style='width:200px;' multiple name=output_data_1[] size=6>");
           foreach($output_data_1_result as $od1_result) {
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

           if($header2 != null) {
               echo("<td>");
               $selected = false;

               echo("<select id='output_data_2' style='width:200px;' multiple name=output_data_2[] size=6>");
               foreach($output_data_2_result as $od2_option) {
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

           } else if($user_interaction == USER_INTERACTION_SELECT_RANGE) {
               echo("<table  style='border-spacing:7px'><tr><th><U><B>".$header1."</B></U></th>");
               echo("<th><U><B>".$header2."</B></U></th>");

               echo("</tr>");
               $value = null;

                   $method = new method($db, $method_id);
                   $this_method_info = $method->get_method_info();
                   foreach($this_method_info as $method_info) {
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
                       $selectbox = "<select style='width:100%' name=output_data_1[$outputname][] multiple>";

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

                       echo("<tr><td>".$name.":</td><td> $selectbox </td></tr>");

                       }
                       echo("</table>");

           } else if($user_interaction == USER_INTERACTION_SELECT_EACH) {

               if($tier2id != null) {
                   $tier2 = new tier2data($db, $tier2id);
                   $data = $tier2->get_tier3data();
                   $methodinfos = array();
                   foreach($data as $tier_info) {
                       $method_info = new method_info($db, $tier_info->get_methodinfoid());
                       $methodinfos[] = $method_info; 
                   }
               }

               echo("<table  style='border-spacing:7px'><tr><th><U><B>".$header1."</B></U></th>");
               echo("<th><U><B>".$header2."</B></U></th>");

               echo("</tr>");
               $value = null;

                           // Notes to user
               echo("<legend><I>(hold CTL to select multiple)</I></legend>");


               foreach($output_data_1_result as $od1_result) {

                   $name = $od1_result[0];
                   //In case name has spaces, encode it
                   $outputname = urlencode($name);
                   $od2_data = $method->get_od2_for_od1($name);

                   $selectbox = "<select style='width:100%' name=output_data_1[$outputname][] multiple>";

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

               echo("<tr><td>".$name.":</td><td> $selectbox </td></tr>");
               }

                       echo("</table>");

           } else if($user_interaction == USER_INTERACTION_INPUT_BOX ||
                   $user_interaction == USER_INTERACTION_NUMERIC_ENTRY) {
               echo("<table>");
               if($tier2id != null) {
                   $tier2 = new tier2data($db, $tier2id);
                   $data = $tier2->get_tier3data();
                   $this_method = new method($db, $tier2->get_methodid());
                   $this_method_info = $this_method->get_method_info();
                   $value = "";

                   foreach($this_method_info as $method_info) {

                       $value = "";
                       foreach($data as $tier3) {
                           if($tier3->get_methodinfoid() == $method_info->get_id()) {
                               $value = $tier3->get_value();
                           }
                       }
                       $name = $method_info->get_output_data_1();
                       echo("<tr><td>".$name.":</td><td> <input id='$name' name='output_data_1[$name]' value='$value'></td></tr>");
                   }
            } else {
               foreach($output_data_1_result as $od1_result) {
                   $name = $od1_result['output_data_1'];
                   echo("<tr><td>".$name.":</td><td> <input id='$name' name='output_data_1[$name]'></td></tr>");
               }
           }
           echo("</table>");
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
             $this->output_data_1_description = $data['output_data_1_description'];
             $this->output_data_2_description = $data['output_data_2_description'];
             $this->age_range = $data['age_range'];
             $this->user_interaction = $data['user_interaction'];
            }

    }
}