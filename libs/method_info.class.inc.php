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

        $output = "";
        foreach($info as $tier_info) {
            if(count($tier_info) > 0) {
                $method = new method($this->db, $this->get_methodid());


                    $q = "SELECT * from method_info where id = :methoddataid";
                    $params = array("methoddataid"=>$tier_info['methoddataid']);
                    $result = $this->db->get_query_result($q, $params);
                    foreach($result as $tier3) {

                        $output .= "(".$tier3['output_data_1']. ", ".$tier3['output_data_2'].") ";
                    }
                
            }
        }
        return $output;
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