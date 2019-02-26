<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class feature {
    
    private $db;
    
    private $id;
    private $name;
    private $description;
    
    public function __construct($db, $id = null) {

        $this->db = $db;

        if($id != null) {
            $this->load_feature($id);
            
        }  
    }    
    
    public function get_id() { return $this->id; }
    public function get_name() { return $this->name; }
    public function get_description() { return $this->description; }
    
    public static function get_features($db) {
        
        $query = "SELECT * from feature";
        $result = $db->get_query_result($query);
        $features = array();
        foreach($result as $feature_data) {
            $id = $feature_data['id'];
            $feature = new feature($db, $id);
            $features[] = $feature;
        }
        
        return $features;
        
    }
            // Private functions
    
    private function load_feature($id) {
       $query = "SELECT * from feature where id=:id";
       $params = array("id"=>$id);
       $result = $this->db->get_query_result($query, $params);

       if(count($result) > 0) {
           $data = $result[0];
       
       $this->id = $id;
        $this->name = $data['name'];
        $this->description = $data['description'];

       }
    }
       
    
    
}