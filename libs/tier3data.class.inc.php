<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class tier3data {
    
    private $id;
    private $tier2id;
    private $value;
    private $method_info_option_id;

    
    
    private $db; // Database object
    
    public function __construct($db, $id = null) {

        $this->db = $db;

        if($id != null) {
            $this->load_tier3data($id);
            
        }  
    }
    
    public function get_id() {
        return $this->id;
    }
    
    public function get_tier2_id() {
        return $this->tier2id;
    }
    
    
    public function get_value() {
        return $this->value;
    }

    
    public function get_method_info_option_id() {
        return $this->method_info_option_id;
    }
    
    // static functions

    /** Gets a Tier 3 data by its tier2id and method_info_option id
     * 
     * @param type $db The database object
     * @param type $methodinfoid The method_info id
     * @param type $value The value for the Tier 3 data
     * @return \tier3data|null The Tier 3 data if it exists, else null
     */
    public static function get_tier3_by_option($db, $t2id, $option_id) {
        $query = "SELECT id from tier3data where tier2id=:t2id and method_info_option_id=:option_id";
        $params = array("t2id"=>$t2id,
                        "option_id"=>$option_id);

        $result = $db->get_query_result($query, $params);
        if(count($result)>0) {
            return new tier3data($db, $result[0]['id']);
        } else {
            return null;
        }
    }

    /** Deletes Tier 3 data for a givet Tier 2 id and method_info id
     * 
     * @param int $t2id Tier 2 ID
     * @param int $method_info_option_id method_info option id
     * @return array An array of the format ("RESULT"=>TRUE|FALSE, "MESSAGE"=>$message)
     *  where RESULT is true if the Tier3 was deleted successfully, and "MESSAGE"
     * is an output message.
     */
    public static function delete_tier3($db, $t2id, $method_info_option_id) {

        // TODO: Delete all data. Right now, only deletes one, but there may be several
        $query = "DELETE FROM tier3data where tier2id=:tier2id and method_info_option_id=:method_info_option_id";
        $params = array("tier2id"=>$t2id,
                        "method_info_option_id"=>$method_info_option_id);
        $result = $db->get_update_result($query, $params);

        if($result > 0) {
            return array("RESULT"=>TRUE,
                                "MESSAGE"=>"Method data deleted successfully.");
        } else {
            return array("RESULT"=>FALSE,
                                "MESSAGE"=>"Method data not deleted successfully.");
        }
        
    }
    
    /** Deletes Tier 3 data for a given its id
     * 
     * @param int $t2id Tier 2 ID
     * @param int $methoddataid method_info id
     * @return array An array of the format ("RESULT"=>TRUE|FALSE, "MESSAGE"=>$message)
     *  where RESULT is true if the Tier3 was deleted successfully, and "MESSAGE"
     * is an output message.
     */
    public static function delete_tier3_by_id($db, $t3id) {

        $query = "DELETE FROM tier3data where id=:t3id";
        $params = array("t3id"=>$t3id);
        $result = $db->get_update_result($query, $params);

        if($result > 0) {
            return array("RESULT"=>TRUE,
                                "MESSAGE"=>"Method data deleted successfully.");
        } else {
            return array("RESULT"=>FALSE,
                                "MESSAGE"=>"Method data not deleted successfully.");
        }
        
    }
    
    // private function
    private function load_tier3data($id) {
       $query = "SELECT * from tier3data where id=:id";
       $params = array("id"=>$id);
       $result = $this->db->get_query_result($query, $params);

       if(count($result) > 0) {
           $data = $result[0];
       
        $this->id = $id;
        $this->tier2id = $data['tier2id'];
        $this->value = $data['value'];
        $this->method_info_option_id = $data['method_info_option_id'];
       }
       
    }
    
}