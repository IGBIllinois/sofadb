<?php

/* 
 * The tier3data class is used to hold the actual information entered for each tier2data object.
 * This includes which options were selected for each tier2data, and what values were entered for text inputs.
 */

class tier3data {
    
    /** tier3data object id */
    private $id;
    
    /** id of the tier2data object (method_info data) associated with this tier3data */
    private $tier2id;
    
    /** Value input. Only used for user input method_infos (text entry, numeric entry, text areas, etc.) */
    private $value;
    
    /** Id of the method_info_option selected */
    private $method_info_option_id;

    
    
    private $db; // Database object
    
    public function __construct($db, $id = null) {

        $this->db = $db;

        if($id != null) {
            $this->load_tier3data($id);
            
        } else {
            // Don't load data
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
    
    
    /** Gets the method_info associated with this tier3 data
     * 
     */
    public function get_method_infos() {
        $method_info_option  = new method_info_option($this->db, $this->method_info_option_id);
        $method_infos_id = $method_info_option->get_method_infos_id();
        $method_infos = new method_infos($this->db, $method_infos_id);
        return $method_infos;
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

        $result = $db->query($query, $params);
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
        $result = $db->non_select_query($query, $params);

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
        $result = $db->non_select_query($query, $params);

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
       $result = $this->db->query($query, $params);

       if(count($result) > 0) {
            $data = $result[0];
       
            $this->id = $id;
            $this->tier2id = $data['tier2id'];
            $this->value = $data['value'];
            $this->method_info_option_id = $data['method_info_option_id'];
        } else {
            // Not found
        }

    }
    
}