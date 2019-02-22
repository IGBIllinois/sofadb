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
        if($this->methodtype = "Age") {
            $query = "SELECT * from tier3data_age where tier2id = :id";
            $params = array("id"=>$this->id);
            $result = $this->db->get_query_result($query, $params);

            return $result;
        }
    }
    
    public function format_tier3data() {
        $info = $this->get_tier3data();

        $output = "";
        foreach($info as $tier_info) {
            if(count($tier_info) > 0) {
                $method = new method($this->db, $this->get_methodid());
                //$output .= "[type = ".$method->get_method_type()."]";
                if($method->get_method_type() == "Age") {
                    $q = "SELECT * from age_method_info where id = :methoddataid";
                    $params = array("methoddataid"=>$tier_info['methoddataid']);
                    $result = $this->db->get_query_result($q, $params);
                    foreach($result as $tier3) {
;
                        $output .= "(".$tier3['output_data']. ", ".$tier3['sex'].") ";
                    }
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