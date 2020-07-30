<?php

/* 
 * References class. Used by Epiphyseal Union type methods
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
    
    /** Gets all references in the database
     * 
     * @param db $db The database object
     * @return \reference Array of reference objects
     */
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
    
    // Static functions
    
    /** Adds a new reference
     * 
     * @param db $db The database object
     * @param string $ref_name Name for the new reference
     */
    public static function add_reference($db, $ref_name) {
        $check_query = "SELECT * from reference where reference_name=:name";
        $params = array("name"=>$ref_name);
        $result = $db->get_query_result($check_query, $params);
        if(count($result) > 0) {
            return array("RESULT"=>FALSE,
                         "MESSAGE"=>"A reference with the name $ref_name already exists. Please choose a different name before adding.");
        }
        
        $add_query = "INSERT INTO reference (reference_name) VALUES (:name)";
        $result = $db->get_insert_result($add_query, $params);
        if($result > 0) {
            return array("RESULT"=>TRUE,
                        "MESSAGE"=>"Reference $ref_name added successfully.");
        } else {
            return array("RESULT"=>FALSE,
                        "MESSAGE"=>"There was an error. Reference $ref_name not added.");
        }
        
    }
    /**
     * Deletes a reference from the database, including deleting it from all 
     * method infos.
     * 
     * @param db $db The database object
     * @param int $id ID of the reference to delete
     */
    public static function delete_reference($db, $id) {
        
        $reference = new reference($db, $id);
        $ref_name = $reference->get_reference_name();
        
        $del_ref_query = "DELETE from references where id=:id";
        $del_params = array("id"=>$id);
        
        $del_info_query = "DELETE from method_info_reference_list where reference_id=:id";
        
        $del_ref_data = "DELETE from reference_data where reference_id=:id";
        
        // delete from reference data
       $data_result = $db->get_update_result($del_ref_data, $del_params);
       
       if($data_result == 0) {
           return array("RESULT"=>FALSE,
               "MESSAGE"=>"Could not delete from reference_data table.");
       }
        
        // delete from method info reference list
        $info_result = $db->get_update_result($del_info_query, $del_params);
        
        if($info_result == 0) {
           return array("RESULT"=>FALSE,
               "MESSAGE"=>"Could not delete from method_info_reference_list table.");
       }
        
        // delete from references
        $ref_result = $db->get_update_result($del_ref_query, $del_params);
        if($ref_result == 0) {
           return array("RESULT"=>FALSE,
               "MESSAGE"=>"Could not delete from reference table.");
       } else {
           return array("RESULT"=>TRUE,
               "MESSAGE"=>"Reference ".$ref_name." deleted successfully.");
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