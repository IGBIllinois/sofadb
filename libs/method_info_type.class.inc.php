<?php

/* 
 * Method_info_type class for the various types of method_infos (select_each, numeric_entry, etc.)
 * 
 */

class method_info_type {
    
    /** Database object */
    private $db;
    
    /** ID of the method_info_type */
    private $id;
    
    /** Method type id of the method used by this method_info_type */
    private $method_type;
    
    public function __construct($db, $id = null) {

        $this->db = $db;

        if($id != null) {
            $this->load_method_info_type($id);
            
        }  
    }    
    
    public function get_id() { return $this->id; }
    public function get_method_info_type() { return $this->method_type; }
    
    /**
     * Gets a list of the method_info_types
     * 
     * @param db $db
     * @return \method_info_type Array of method_info_type objects
     */
    public static function get_method_info_types($db) {
        
        $query = "SELECT * from method_info_types";
        $result = $db->get_query_result($query);
        $types = array();
        foreach($result as $info) {

            $id = $info['id'];
            $type = new method_info_type($db, $id);
            $types[] = $type;
        }
        
        return $types;
        
    }
    
    /** Gets a list of method_info_types by name
     * 
     * @param db $db the database object
     * @param string $name Name of the type
     * @return \method_info_type An array of method_info_type object with the given type name
     */
    public static function get_method_info_type_by_name($db, $name) {
        
        $query = "SELECT id from method_info_types where method_type=:name";
        $params = array("name"=>$name);
        $result = $db->get_query_result($query, $params);
        if(count($result) > 0) {
        
            $input = $result[0];

            $id = $input['id'];
            $type = new method_info_type($db, $id);
            return $type;
        } else {
            // Type not found
        }
        return null;
        
    }
    
     // Private functions
    
    private function load_method_info_type($id) {
       $query = "SELECT * from method_info_types where id=:id";

       $params = array("id"=>$id);
       $result = $this->db->get_query_result($query, $params);

       if(count($result) > 0) {
            $data = $result[0];
       
            $this->id = $id;
            $this->method_type = $data['method_type'];

       } else {
           // Type not found
       }
    }
       
    
    
}