<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class reference {
    
    private $db;
    
    private $id;
    private $reference_name;
    
    public function __construct($db, $id = null) {

        $this->db = $db;

        if($id != null) {
            $this->load_reference($id);
            
        }  
    }    
    
    public function get_id() { return $this->id; }
    public function get_reference_name() { return $this->reference_name; }
    
    public static function get_references($db) {
        
        $query = "SELECT * from reference";
        $result = $db->get_query_result($query);
        $refs = array();
        foreach($result as $input) {

            $id = $input['id'];
            $ref = new reference($db, $id);
            $refs[] = $ref;
        }
        
        return $refs;
        
    }
    
    /**
     * Adds reference data to a tier2 object
     * @param int $tier2id ID of the tier2 to add data to
     * @param int $method_info_id ID of the method_infos to add reference data to
     * @return array Array of type ["RESULT"=>$result, "MESSAGE"=>$message],
     *  where RESULT is true if successful, and $message is an output message.
     */
    public function add_reference_to_tier2($tier2id, $method_info_id) {
        $query = "INSERT INTO reference_data (tier2id, method_info_id, reference_id) VALUES (:tier2id, :methodinfoid, :ref_id)";
        $params = array("tier2id"=>$tier2id, "methodinfoid"=>$method_info_id, "ref_id"=>$this->get_id());
        
        $result = $this->db->get_insert_result($query, $params);
        if($result > 0) {
            return array("RESULT"=>TRUE,
                    "MESSAGE"=>"Reference added successfully.",
                    $id=>$result);
        
        } else {
            return array("RESULT"=>FALSE, 
                        "MESSAGE"=>"Reference not added.");
        }
        
    }
    
    /**
     * Removes reference data from a tier2 object
     * @param int $reference_data_id ID of the reference_data record to delete
     * @return type Array of type ["RESULT"=>$result, "MESSAGE"=>$message],
     *  where RESULT is true if successful, and $message is an output message.
     */
    public function remove_reference_from_tier2($reference_data_id) {
        $query = "delete from reference_data where id = :reference_data_id";
        $params = array(":reference_data_id"=>$reference_data_id);
        
        $result = $this->db->get_update_result($query, $params);
        if($result > 0) {
            return array("RESULT"=>TRUE,
                    "MESSAGE"=>"Reference removed successfully.");
        
        } else {
            return array("RESULT"=>FALSE, 
                        "MESSAGE"=>"Reference not removed.");
        }
        
    }
    
            // Private functions
    
    private function load_reference($id) {
       $query = "SELECT * from reference where id=:id";

       $params = array("id"=>$id);
       $result = $this->db->get_query_result($query, $params);

       if(count($result) > 0) {
           $data = $result[0];
       
       $this->id = $id;
        $this->reference_name = $data['reference_name'];

       }
    }
       
    
    
}