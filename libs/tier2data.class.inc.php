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
    private $featureid;
    private $phaseid;
    
    
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
    
    public function get_featureid() {
        return $this->featureid;
    }
    
    public function get_phaseid() {
        return $this->phaseid;
    }
    
    public function get_tier3data() {

        $query = "SELECT * from tier3data where tier2id = :id";
        $params = array("id"=>$this->id);
        $result = $this->db->get_query_result($query, $params);

        return $result;

    }
    
    public function format_tier3data() {
        $info = $this->get_tier3data();

        $output = "";
        foreach($info as $tier_info) {
            if(count($tier_info) > 0) {
                $method = new method($this->db, $this->get_methodid());


                    $method_info = new method_info($this->db, $tier_info['methoddataid']);
                    
                    $interaction = $method_info->get_user_interaction();
                    
                    if($interaction == USER_INTERACTION_MULTISELECT) {
                        
                        if($method_info->get_output_data_2() != null) {
                            $output .= "(".$method_info->get_output_data_1(). ", ".$method_info->get_output_data_2().") ";
                        } else {
                            $output .= "(".$method_info->get_output_data_1().") ";
                        }

                    } else if($interaction == USER_INTERACTION_INPUT_BOX ||
                            $interaction == USER_INTERACTION_SELECT_RANGE) {
                        $output .= "(".$method_info->get_output_data_1(). ", ".$tier_info['value'].") ";
                    }

            }
        }
        return $output;
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
        $this->featureid = $data['featureid'];
        $this->phaseid = $data['phaseid'];
       }
       
    }
}