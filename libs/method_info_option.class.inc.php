<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class method_info_option {
    
    private $db; // Database object
    
    private $id;
    private $method_infos_id;
    private $value;

    
    
    public function get_id() {
        return $this->id;
    }
    
    public function get_method_infos_id() {
        return $this->method_infos_id;
    }
    
    public function get_value() {
        return $this->value;
    }
    

    
            
    public function __construct($db, $id = null) {

        $this->db = $db;

        if($id != null) {
            $this->load_method_info_option($id);
            
        }  
    }
    
    public function get_type() {
        $method_infos = new method_infos($this->db, $this->method_infos_id);
        $type = $method_infos->get_type();
        return $type;
    }

    // Private
    private function load_method_info_option($id) {

        $query = "SELECT * from method_info_options where id=:id";
        $params = array("id"=>$id);
        $result = $this->db->get_query_result($query, $params);

        if(count($result) > 0) {
            $data = $result[0];

        $this->id = $id;
         $this->method_infos_id = $data['method_infos_id'];
         $this->value = $data['value'];

        }

    }
    
}