<?php

/* 
 * The method_info adds input data for a method object
 */

class method_info_option {
    
    /** Database object */
    private $db; 
    
    /** ID of the method_info_option */
    private $id;
    
    /** ID of the method_infos object this option belongs to */
    private $method_infos_id;
    
    /** Text value of the option */
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
    
    /** Get the type of this method_info_option
     * 
     * @return int the ID of the method info type for the method info of this option
     */
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