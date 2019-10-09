<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class tier2data {
    
    private $id;
    private $memberid;
    private $caseid;
    private $methodtype;
    private $methodid;
    private $estimated_outcome_1;
    private $estimated_outcome_2;
    private $estimated_outcome_units;
    
    private $db; // Database object
    
    public function __construct($db, $id = null) {

        $this->db = $db;

        if($id != null) {
            $this->load_tier2data($id);
            
        }  
    }
    
    public function get_id() {
        return $this->id;
    }
    
    public function get_memberid() {  
        return $this->memberid;
    }
    
    public function get_caseid() {
        return $this->caseid;
    }
    
    public function get_methodtype() {
        return $this->methodtype;
    }
    
    public function get_methodid() {
        return $this->methodid;
    }
    
    public function get_estimated_outcome_1() {
        return $this->estimated_outcome_1;
    }
    
    public function get_estimated_outcome_2() {
        return $this->estimated_outcome_2;
    }
    
    public function get_estimated_outcome_units() {
        return $this->estimated_outcome_units;
    }
    
    /** Gets all or one tier3 data for this tier2 object
     * 
     * @param type $methodinfoid method_info id to get tier3 data for; null to get all data
     * @return \tier3data array of tier3 objects
     */
    public function get_tier3data($methodinfoid = null) {

        $query = "SELECT * from tier3data where tier2id = :id";
        $params = array("id"=>$this->id);
        if($methodinfoid != null) {
            $query .= " AND methodinfoid = :methodinfoid ";
            $params['methodinfoid'] = $methodinfoid;
            
        }

        $result = $this->db->get_query_result($query, $params);
        $tier3s = array();
        foreach($result as $tier3) {
            $id = $tier3['id'];
            $tier3data = new tier3data($this->db, $id);
            $tier3s[] = $tier3data;
            
        }
        return $tier3s;

    }
    
    /** Formats Tier3 data for display in the table, in the form:
     *  ($output_data_1, $value), for each $output_data_1 for this Tier2 data.
     *  $value may either be an $output_data_2, a value within a range, or a 
     *  user-specified value, depending on the user_interaction type.
     * 
     * @param int tier3id ID of a tier3 object to format. If null, get all tier3 data for this tier2 object
     * @param boolean for_web True if outputting to web (include <BR> tags). Defaults to true
     * 
     * @return string A string representing the Tier3 data for this Tier2 object
     */
    public function format_tier3data($tier3id = null, $for_web=true) {
        if($tier3id == null)  {
            $info = $this->get_tier3data();
        } else{
            $info = array(new tier3data($this->db, $tier3id)); 
        }

        $output = "";
        foreach($info as $tier_info) {
            if(count($tier_info) > 0) {
                $method = new method($this->db, $this->get_methodid());


                    $method_info = new method_info($this->db, $tier_info->get_methodinfoid());
                    
                    $interaction = $method_info->get_user_interaction();

                    if($interaction == USER_INTERACTION_MULTISELECT||
                            $interaction == USER_INTERACTION_SELECT_EACH) {
                        
                        if($for_web) {
                            if($method_info->get_output_data_2() != null) {
                                $output .= "(".$method_info->get_output_data_1(). ", ".$method_info->get_output_data_2().")";
                            } else {
                                $output .= "(".$method_info->get_output_data_1().")";
                            }
                        } else {
                            $output .= "Y";
                        }

                    } else if($interaction == USER_INTERACTION_INPUT_BOX ||
                            $interaction == USER_INTERACTION_NUMERIC_ENTRY ||
                            $interaction == USER_INTERACTION_SELECT_RANGE) {
                        if($for_web) {     
                            $output .= "(".$method_info->get_output_data_1(). ", ".$tier_info->get_value().")";
                        } else {
                            $output .= $tier_info->get_value();
                        }
                    } else if($interaction == USER_INTERACTION_3_COL_W_REF) {
                        if($for_web) {
                            $output .= "(".$method_info->get_output_data_1().", ".$method_info->get_output_data_2(). ", ".$method_info->get_output_data_3().") ";
                        } else {
                            $output .= "Y";
                        }
                    } else if($interaction == USER_INTERACTION_INPUT_BOX_WITH_DROPDOWN) {
                        if($for_web) {
                            $output .= "( ".$method_info->get_output_data_1().", ".$method_info->get_output_data_2(). ", " . $tier_info->get_value(). ") ";
                        } else {
                            $output .= $tier_info->get_value();
                        }
                    } else if($interaction == USER_INTERACTION_TEXT_AREA) {
                        $output = "Data entered";
                    } else if($interaction == USER_INTERACTION_RIOS_CARDOSO) {
                        // output_data_1 is the 
                        if($for_web) {
                            $newid = $tier_info->get_value();

                            $method_info_value = new $method_info($this->db, $newid);
                            $desc = "";
                            if($method_info_value->get_output_data_2() != null) {

                                $desc = "(" . $method_info_value->get_output_data_2_description() .":".$method_info_value->get_output_data_2().")";
                            } else if($method_info_value->get_output_data_3() != null) {
                                $desc = "(".$method_info_value->get_output_data_3_description() .":".$method_info_value->get_output_data_3().")";
                            } else if($method_info_value->get_output_data_4() != null) {
                                $desc = "(".$method_info_value->get_output_data_4_description() .":".$method_info_value->get_output_data_4().")";
                            }
                            $output .= $method_info->get_output_data_1_description() . " " . $method_info->get_output_data_1() . ": ". $desc."";

                        } else {
                            $output .= $tier_info->get_value();
                        }
                    }
                    
                    if($for_web) {
                        $output .= "<BR>";
                    }

            }
            
        }
        
        return $output;
    }
    
    public function update_estimated_outcomes($estimated_outcome_1, $estimated_outcome_2 = null, $units=null) {
        
        $tier2id = $this->id;
        $query = "update tier2data set estimated_outcome_1=:est1 where id=:tier2id";
        $params = array("tier2id"=>$tier2id, "est1"=>$estimated_outcome_1);
        
        if($estimated_outcome_2 != null) {
            $query = "update tier2data set estimated_outcome_1=:est1 , estimated_outcome_2=:est2 where id=:tier2id";
            $params = array("tier2id"=>$tier2id, "est1"=>$estimated_outcome_1, "est2"=>$estimated_outcome_2);
            
            if($units != null) {
            $query = "update tier2data set estimated_outcome_1=:est1 , estimated_outcome_2=:est2, estimated_outcome_units=:units where id=:tier2id";
            $params = array("tier2id"=>$tier2id, "est1"=>$estimated_outcome_1, "est2"=>$estimated_outcome_2, "units"=>$units);
        }
        }
        
        
        
        $result = $this->db->get_update_result($query, $params);
        return $result;
    }
    
    // static functions
    public static function delete_tier2($db, $tier2id) {
        $query = "DELETE from tier2data where id=:tier2id ";
        $params = array("tier2id"=>$tier2id);
        $result = $db->get_update_result($query, $params);
        if($result > 0) {
            return array("RESULT"=>TRUE,
                "MESSAGE"=>"Tier 2 data deleted successfully");
        } else {
            return array("RESULT"=>TRUE,
                "MESSAGE"=>"ERROR: Tier 2 data not deleted");
        }
    }
    
 
    
    private function load_tier2data($id) {
       $query = "SELECT * from tier2data where id=:id";
       $params = array("id"=>$id);
       $result = $this->db->get_query_result($query, $params);

       if(count($result) > 0) {
           $data = $result[0];
       
       $this->id = $id;
        $this->memberid = $data['memberid'];
        $this->caseid = $data['caseid'];
        $this->methodtype = $data['methodtype'];
        $this->methodid = $data['methodid'];
        $this->estimated_outcome_1 = $data['estimated_outcome_1'];
        $this->estimated_outcome_2 = $data['estimated_outcome_2'];
        $this->estimated_outcome_units = $data['estimated_outcome_units'];
       }
       
    }
}