<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class tier3data {
    
    private $id;
    private $tier2id;
    private $methodinfoid;
    private $value;

    
    
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
    
    public function get_methodinfoid() {
        return $this->methodinfoid;
    }
    
    public function get_value() {
        return $this->value;
    }
    
    // static functions
    
    
    public static function get_tier3_by_value($db, $methodinfoid, $value) {
        $query = "SELECT id from tier3data where methodinfoid=:methodinfoid and value=:value";
        $params = array("methodinfoid"=>$methodinfoid,
                        "value"=>$value);
        $result = $db->get_query_result($query, $params);
        if(count($result)>0) {
            return new tier3data($db, $result[0][id]);
        } else {
            return null;
        }
    }
        /** Deletes Tier 3 data for a givet Tier 2 id and method_info id
     * 
     * @param int $t2id Tier 2 ID
     * @param int $methoddataid method_info id
     * @return type
     */
    public static function delete_tier3($db, $t2id, $methodinfoid) {

        // TODO: Delete all data. Right now, only deletes one, but there may be several
        $query = "DELETE FROM tier3data where tier2id=:tier2id and methodinfoid=:methodinfoid";
        $params = array("tier2id"=>$t2id,
                        "methodinfoid"=>$methodinfoid);
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
     * @return type
     */
    public static function delete_tier3_by_id($db, $t3id) {

        // TODO: Delete all data. Right now, only deletes one, but there may be several
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
        $this->methodinfoid = $data['methodinfoid'];
        $this->value = $data['value'];
       }
       
    }
    
}