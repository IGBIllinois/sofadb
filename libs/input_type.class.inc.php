<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class input_type {
    
    private $db;
    
    private $id;
    private $input_type;
    
    public function __construct($db, $id = null) {

        $this->db = $db;

        if($id != null) {
            $this->load_input_type($id);
            
        }  
    }    
    
    public function get_id() { return $this->id; }
    public function get_input_type() { return $this->input_type; }
    
    public static function get_input_types($db) {
        
        $query = "SELECT * from input_types";
        $result = $db->get_query_result($query);
        $types = array();
        foreach($result as $input) {

            $id = $input['id'];
            $type = new input_type($db, $id);
            $types[] = $type;
        }
        
        return $types;
        
    }
    
        public static function get_input_type_by_name($db, $name) {
        
        $query = "SELECT id from input_types where input_type=:name";
        $params = array("name"=>$name);
        $result = $db->get_query_result($query, $params);
        if(count($result) > 0) {
        
            $input = $result[0];

            $id = $input['id'];
            $type = new input_type($db, $id);
            return $type;
        }
        return null;
        
    }
    
            // Private functions
    
    private function load_input_type($id) {
       $query = "SELECT * from input_types where id=:id";

       $params = array("id"=>$id);
       $result = $this->db->get_query_result($query, $params);

       if(count($result) > 0) {
           $data = $result[0];
       
       $this->id = $id;
        $this->input_type = $data['input_type'];

       }
    }
       
    
    
}