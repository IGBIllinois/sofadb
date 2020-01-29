<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class method_info_type {
    
    private $db;
    
    private $id;
    private $method_type;
    
    public function __construct($db, $id = null) {

        $this->db = $db;

        if($id != null) {
            $this->load_method_info_type($id);
            
        }  
    }    
    
    public function get_id() { return $this->id; }
    public function get_method_info_type() { return $this->method_type; }
    
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
    
        public static function get_method_info_type_by_name($db, $name) {
        
        $query = "SELECT id from method_info_types where method_type=:name";
        $params = array("name"=>$name);
        $result = $db->get_query_result($query, $params);
        if(count($result) > 0) {
        
            $input = $result[0];

            $id = $input['id'];
            $type = new method_info_type($db, $id);
            return $type;
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

       }
    }
       
    
    
}