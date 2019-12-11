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
    public function get_tier3data($method_info_option_id = null) {

        $query = "SELECT * from tier3data where tier2id = :id";
        $params = array("id"=>$this->id);
        if($methodinfoid != null) {
            $query .= " AND method_info_option_id = :method_info_option_id ";
            $params['method_info_option_id'] = $method_info_option_id;
            
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
            
            $method = new method($this->db, $this->get_methodid());
            
            $mi_option_id = $tier_info->get_method_info_option_id();

            $option = new method_info_option($this->db, $mi_option_id);

            $method_infos = $tier_info->get_method_infos();
            
            if($tier_info->get_value() != null && $tier_info->get_value() != "") {
                $output .= $tier_info->get_value();
            } else {
                $output .= $option->get_value();
            }
            
            if($for_web) {
                $output .= "<BR>";
            }


        }
        
        return $output;
    }
    
    /** Update the estimated outcomes for a Tier2data.
     * 
     * @param string $estimated_outcome_1 The new first estimated outcome value
     * @param string $estimated_outcome_2 The new second estimated outcome value (optinal)
     * @param string $units The new estimated outcome units (optional)
     * @return type
     */
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
    
    
    /** Gets the estimated outcome(s) for this method, and units, if applicable
     * 
     * @return string The estimated outcome for this tier2data
     */
    public function show_estimated_outcome() {
        
        $est1 = $this->estimated_outcome_1;
        $est2 = $this->estimated_outcome_2;
        $units = $this->estimated_outcome_units;
        
        $output = "";
        
        $method = new method($this->db, $this->methodid);
        $outcome_type = input_type::get_input_type_by_name($this->db, USER_INTERACTION_ESTIMATED_OUTCOME);
        
        $outcomes = $method->get_method_infos_by_type();
        
        if($outcomes[$outcome_type->get_id()] != null) {
            $method_info_option = new method_info_option($this->db, $est1);
            $output .= $method_info_option->get_value();
        }
        else {
        if($est1 != null) {
            $output .= $est1;
        }
        if($est2 != null && $est2 != "") {
            if($output != "") {
                $output .= " - ";
            }
            $output .= $est2;
        }
        if($units != null && $units != "") {
            $output .= " $units";
        }
        }
        if($output == "") {
            $output = "No estimated outcome given";
        }
        
        return $output;

    }
    
    /** Gets all references for a specific method_infos for this tier2
     * 
     * @param int $method_info_id
     * @return \reference Array of reference objects for this tier2 and method_infos
     */
    public function get_selected_references($method_info_id) {
        $query = "SELECT reference_id from reference_data where tier2id=:tier2id and method_info_id = :method_info_id";
        $params = array("tier2id"=>$this->get_id(),
                        "method_info_id"=>$method_info_id);
        $result = $this->db->get_query_result($query, $params);
        
        $return_result = array();
        foreach($result as $ref) {
            $reference = new reference($this->db, $ref['reference_id']);
            $return_result[] = $reference;
        }
        return $return_result;
    }
    
    /** Gets a list of all references for this tier2
     * 
     * @return \reference An array of references that have been saved for this tier2 object
     */
    public function get_all_selected_references() {
       $query = "SELECT reference_id from reference_data where tier2id=:tier2id ";
        $params = array("tier2id"=>$this->get_id());
        $result = $this->db->get_query_result($query, $params);
        
        $return_result = array();
        foreach($result as $ref) {
            $reference = new reference($this->db, $ref['reference_id']);
            $return_result[] = $reference;
        }
        return $return_result; 
    }
    
    /** Gets a list of all possible method_infos associated with this tier2 data
     * 
     */
    public function get_method_infos() {
        $query = 'select * from method_infos where id in (SELECT method_infos_id from method_info_options where id in(SELECT method_info_option_id FROM tier3data where tier2id=:t2id))';
        $params = array("t2id"=>$this->id);
        
        $result = $this->db->get_query_result($query, $params);
        
        $return_result = array();
        
        foreach($result as $mi) {
            $mi_id = $mi['id'];
            $method_infos = new method_infos($this->db, $mi_id);
            $return_result[] = $method_infos;
        }
        return $method_infos;
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