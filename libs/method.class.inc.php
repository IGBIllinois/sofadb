<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class method {
    
    private $id;
    private $method_name;
    private $method_type_num;
    private $measurement_type;
    private $description;
    private $instructions;
    private $methodinfotype;
    
    private $db; // Database object
    
    public function __construct($db, $id = null) {

        $this->db = $db;

        if($id != null) {
            $this->load_method($id);
            
        }  
    }
    
    public function get_id() {
        return $this->id;
    }
    
    public function get_name() {  
        return $this->method_name;
    }
    
    public function get_method_type() {

        switch($this->method_type_num) {
            case METHOD_DATA_SEX_ID:
                return METHOD_DATA_SEX;
                break;
            case METHOD_DATA_AGE_ID:
                return METHOD_DATA_AGE;
                break;
            case METHOD_DATA_ANCESTRY_ID;
                return METHOD_DATA_ANCESTRY;
                break;
            case METHOD_DATA_STATURE_ID:
                return METHOD_DATA_STATURE;
                break;
            default:
                return "Unknown method type";
                break;
                
        }
    }
    
    public function get_method_type_num() {
        return $this->method_type_num;
    }
    
    public function get_measurement_type() {
        return $this->measurement_type;
    }
    
    public function get_description() {
        return $this->description;
    }
    
    public function get_instructions() {
        return $this->instructions;
    }
    
    public function get_method_info_type() {
        return $this->methodinfotype;
    }
    

    public function update_method(
            $name, 
            $type, 
            $type_num, 
            $measurement_type, 
            $description,
            $instructions) {
                $query = "UPDATE methods SET ".
                    "methodname = :methodname,".
                    " methodtype = :methodtype, ".
                    " methodtypenum = :methodtypenum, ".
                    " measurementtype = :measurementtype, ".
                    " description = :description, ".
                    " instructions = :instructions where id = :id ";
                $params = array("methodname"=>$name,
                                "methodtype"=>$type,
                                "methodtypenum"=>$type_num,
                                "measurementtype"=>$measurement_type,
                                "description"=>$description,
                                "instructions"=>$instructions,
                                "id"=>$this->id);

                $result = $this->db->get_update_result($query, $params);
                if ($result) { // If it ran OK.
                    return $result;
                }
    }
    
    // Static functions
    
    public static function create_method(
            $db,
            $name, 
            $type, 
            $type_num, 
            $measurement_type, 
            $description,
            $instructions) {
        
        $query = "INSERT INTO methods (".
                "methodname, ".
            " methodtype, ".
            " methodtypenum, ".
            " measurementtype, ".
            " description, ".
            " instructions)".
            " VALUES (".
               ":methodname, ".
               ":methodtype, ".
               ":methodtypenum, ".
               ":measurementtype, ".
               ":description, ".
               ":instructions) ";
        $params = array("methodname"=>$name,
                                "methodtype"=>$type,
                                "methodtypenum"=>$type_num,
                                "measurementtype"=>$measurement_type,
                                "description"=>$description,
                                "instructions"=>$instructions);
        
        $result = $db->get_insert_result($query, $params);

	if ($result > 0) { // If it ran OK.
            return $result;
        }
    }


    

    
    /**
     * 
     * @return type An array of estimated outcome possibilities for this method
     */
    public function get_estimated_outcomes() {
        $est_input_type = input_type::get_input_type_by_name($this->db, USER_INTERACTION_ESTIMATED_OUTCOME);
        $est_query = "SELECT id from method_info_options where method_infos_id = (select id from method_infos where methodid=:methodid and input_type=:input_type)";
        $est_params = array("methodid"=>$this->get_id(), "input_type"=>$est_input_type->get_id());
        $result = $this->db->get_query_result($est_query, $est_params);
        $return_result = array();
        if(count($result) > 0){ 
            foreach($result as $data) {
                $return_result[] = new method_info_option($this->db, $data['id']);
            }
            return $return_result;
        } else {
            return array();
        }
        
    }
    
            /**
         * Returns an array of method_infos objects for this method
         * @return \method_infos An array of method_infos objects for this method
         */
        public function get_method_infos() {
            $query = "SELECT id from method_infos where methodid=:methodid ORDER BY id";
            $params = array("methodid"=>$this->id);
            $result = $this->db->get_query_result($query, $params);
            
            $return_result = array();
            if(count($result) > 0) {
                foreach($result as $method_infos) {
                    $mi = new method_infos($this->db, $method_infos['id']);
                    $return_result[] = $mi;
                }
            }
            return $return_result;
        }
    
        /** Gets method_infos for a method sorted by type
         * 
         * @return \method_infos An array whose contents are arrays of method_infos, sorted by type
         */
        public function get_method_infos_by_type($type = null) {
            if($type == null) {
                $text_type = input_type::get_input_type_by_name($this->db, USER_INTERACTION_TEXT_ENTRY)->get_id();
                $number_type = input_type::get_input_type_by_name($this->db, USER_INTERACTION_NUMERIC_ENTRY)->get_id();
                $type_query = "SELECT DISTINCT input_type from method_infos where methodid = :methodid ORDER BY FIELD(input_type,$text_type, $number_type) DESC";

                $type_params =array("methodid"=>$this->id);
                $type_result = $this->db->get_query_result($type_query, $type_params);
            } else {
                $type_result = array('input_type'=>$type);
            }

            $text_type = input_type::get_input_type_by_name($this->db, USER_INTERACTION_TEXT_ENTRY);
            $numeric_type = input_type::get_input_type_by_name($this->db, USER_INTERACTION_NUMERIC_ENTRY);
            
            $return_array = array();
            foreach($type_result as $type) {
                $info_array = array();
                $input_type = $type['input_type'];
                $infos_query = "SELECT id from method_infos where methodid= :methodid and input_type=:type";
                $infos_params = array("methodid"=>$this->id, "type"=>$input_type);
                $info_result = $this->db->get_query_result($infos_query, $infos_params);
                
                foreach($info_result as $info) {
                    $method_infos = new method_infos($this->db, $info['id']);
                    $info_array[] = $method_infos;
                }
                $return_array[$input_type] = $info_array;
            }

            return $return_array;
        }
        
    
     /** Adds a method info to this method
      * 
      * @param string $name Name of the method_info
      * @param string $header Header used for the method_info
      * @param string $option_header Header for the option list (used in some input types)
      * @param int $input_type Input type id
      * @param int $parent_id Parent id (optional, used in some input types)
      */
    public function add_method_info($name, $header, $option_header, $input_type, $parent_id=null) {
        $methodid=$this->id;
        echo("parent id = ".$parent_id);
        $query = "INSERT INTO method_infos (methodid, name, header, option_header, input_type " .
                (($parent_id != null) ? ", parent_id" : "") 
                . ") VALUES "
                . "(:methodid, :name, :header, :option_header, :input_type ".
                (($parent_id != null) ? ", :parent_id)" : ")");
        $params = array("methodid"=>$methodid,
                        "name"=>$name,
                        "header"=>$header,
                        "option_header"=>$option_header,
                        "input_type"=>$input_type);

        if($parent_id !=  null) {
            $params["parent_id"] = $parent_id;
        }
        $result = $this->db->get_insert_result($query, $params);
    } 
    
    public function remove_method_info($method_info_id) {
        $query = "DELETE FROM method_infos where id = :method_info_id";
        $params = array("method_info_id"=>$method_info_id);
        
        $result = $this->db->get_update_result($query, $params);
        
        return $result;
    }

    
    // Static functions
    
    /** 
     * Gets an array of methods from the database
     * 
     * @param db $db The database object
     * @param int $start Starting index in the full list (optional)
     * @param int $limit Number of records to return (optional)
     * @return \method An array of method objects. If $start and $limit are given,
     *  $limit is the number of records to return, starting at index $start.
     *  Otherwise, all methods in the database will be returned.
     */
    public static function get_methods($db, $start = -1, $limit = -1) {
        $query = "SELECT id from methods ";
        if(is_numeric($start) && $start >= 0) {
            $query .= " LIMIT $start ";
            if(is_numeric($limit) && $limit > 0) {
                $query .= ", $limit";
            }
        }

        $result = $db->get_query_result($query);
        $methods = array();
        foreach($result as $method) {
            $id = $method['id'];
            $new_method = new method($db, $id);
            $methods[] = $new_method;
        }
        return $methods;
    }
    
    /**
     * Get an array of methods based on their type.
     * @param db $db The database object
     * @param int $type_id Type ID for the type of method to return (1 for Sex, 2 for Age, etc.)
     * @return \method An array of method objects of the given type. Some have a specific order,
     *      with preferred methods being listed first for display purposes.
     */
    public static function get_methods_by_type($db, $type_id) {
            $query = "SELECT methodname,id FROM methods WHERE methodtypenum=:methodtypenum ";
            if($type_id == METHOD_DATA_SEX_ID) {
                // Specific order for Sex methods
                $query .= "order by "
                        . "methodname = 'Fordisc (skeletal, metric)' desc, "
                        . "methodname = 'Generalized Morphology (skeleton, nonmetric)' desc, "
                        . "methodname = 'Soft Tissue Morphology (nonmetric)' desc, "
                        . "methodname = '3D-ID (cranial, metric)' desc, "
                        . "methodname ASC";
            } else if($type_id == METHOD_DATA_AGE_ID) {
                // Specific order for Age methods
                $query .= "Order by "
                        . "methodname = 'Epiphyseal Union (skeletal, nonmetric)' desc, "
                        . "methodname = 'Epiphyseal Union, McKern and Stuart (skeletal, nonmetric)' desc, "
                        . "methodname = 'Transition Analysis (skeletal, nonmetric)' desc, "
                        . "methodname ASC";
            } else if($type_id == METHOD_DATA_ANCESTRY_ID) {
                // Specific order for Ancestry methods
                $query .= "Order by ".
                        "methodname = '3D-ID (cranial, metric)' desc, ".
                        "methodname ='Fordisc (skeletal, metric)' desc,".
                        "methodname ASC";
            } else if($type_id == METHOD_DATA_STATURE_ID) {
                // Specific order for Stature methods
                $query .= "Order by methodname ASC";
            }
            $params = array("methodtypenum"=>$type_id);
            $result = $db->get_query_result($query, $params);
            $methods = array();
            foreach($result as $method) {
                $curr_method = new method($db, $method['id']);
                $methods[] = $curr_method;
            }
            return $methods;
        }
        

    
     // Private functions

     /** Loads database data into this method
      * 
      * @param int $id The id of the method to load
      */
     private function load_method($id) {
         $query = "SELECT * from methods where id = :id";
         $params = array("id"=>$id);
         $result = $this->db->get_query_result($query, $params);

         if(count($result) > 0) {
             $data = $result[0];
         
         $this->id = $id;
         $this->method_name = $data['methodname'];
         $this->method_type_num = $data['methodtypenum'];
         $this->measurement_type = $data['measurementtype'];
         $this->description = $data['description'];
         $this->instructions = $data['instructions'];
         $this->methodinfotype = $data['methodinfotype'];
         }
         
     }
}