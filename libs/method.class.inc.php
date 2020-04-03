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
    private $prompt_id;
    private $fdb;
    private $top;
    private $active;
    
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
    
    public function get_prompt_id() {
        return $this->prompt_id;
    }
    
    public function get_fdb() {
        return $this->fdb;
    }
    
    public function get_top() {
        return $this->top;
    }
    
    public function get_active() {
        return $this->active;
    }
    

    /**
     * Updates a method with new data
     * 
     * @param string $name
     * @param int $type_num
     * @param string $measurement_type
     * @param string $description
     * @param string $instructions
     * @param int $prompt_id
     * @return type
     */
    public function update_method(
            $name, 
            $type_num, 
            $measurement_type, 
            $description,
            $instructions,
            $method_info_type,
            $prompt_id,
            $fdb,
            $top,
            $active) {
                $query = "UPDATE methods SET ".
                    "methodname = :methodname,".
                    " methodtypenum = :methodtypenum, ".
                    " measurementtype = :measurementtype, ".
                    " description = :description, ".
                    " instructions = :instructions, ".
                    " methodinfotype = :methodinfotype, ".
                    " prompt = :prompt, " .
                    " fdb = :fdb,".
                    " top = :top,".
                    " active = :active ".
                    " where id = :id ";
                $params = array("methodname"=>$name,
                                "methodtypenum"=>$type_num,
                                "measurementtype"=>$measurement_type,
                                "description"=>$description,
                                "instructions"=>$instructions,
                                "prompt"=>$prompt_id,
                                "methodinfotype"=>$method_info_type,
                                "active"=>$active,
                                "fdb"=>$fdb,
                                "top"=>$top,
                                "id"=>$this->id);

                $result = $this->db->get_update_result($query, $params);
                if ($result) { // If it ran OK.
                    return $result;
                }
    }
    
    // Static functions
    
    /**
     * 
     * @param db $db The database object
     * @param string $name Method name
     * @param int $type_num ID of the method type (for "Sex", "Age", etc)
     * @param string $measurement_type Measurement type used
     * @param string $description Description of the method
     * @param string $instructions Additional instructions
     * @param int $prompt_id ID of the prompt to use (from the 'prompts' table. Defaults to null
     * @param bool $fdb Whether or not this method is included in FDB reports. Defaults to false
     * @param bool $top Whether or not this method should be displayed at the top (Defaults to false)
     * $param bool $active Whether or not the method is active. Defaults to 0 when adding a new method.
     * @return array
     */
    public static function create_method(
            $db,
            $name, 
            $type_num, 
            $measurement_type, 
            $description,
            $instructions, 
            $method_info_type,
            $prompt_id = null,
            $fdb,
            $top,
            $active = 0) {
        
        $check_query = "SELECT id from methods where methodname=:name and methodtypenum=:typenum";
        $check_params = array("name"=>$name, "typenum"=>$type_num);
        
        $check_result = $db->get_query_result($check_query, $check_params);
        
        if(count($check_result)>0) {
            // A method with this name already exists
            return array("RESULT"=>FALSE,
                        "MESSAGE"=>"A method with the name $name already exists. Please choose a different name and try again.");
            
        }

        $query = "INSERT INTO methods (".
                "methodname, ".
                " methodtypenum, ".
                " measurementtype, ".
                " description, ".
                " instructions,".
                " methodinfotype,".    
                " prompt,".
                " fdb, ".
                " top, ".
                " active)".
            " VALUES (".
               ":methodname, ".
               ":methodtypenum, ".
               ":measurementtype, ".
               ":description, ".
               ":instructions,".
               ":methodinfotype,".
               ":prompt, ".
               ":fdb, ".
               ":top, ".
               ":active) ";
        $params = array("methodname"=>$name,
                        "methodtypenum"=>$type_num,
                        "measurementtype"=>$measurement_type,
                        "description"=>$description,
                        "instructions"=>$instructions,
                        "methodinfotype"=>$method_info_type,
                        "active"=>$active,
                        "fdb"=>$fdb,
                        "top"=>$top,
                        "prompt"=>$prompt_id);
        
        $result = $db->get_insert_result($query, $params);

	if ($result > 0) { // If it ran OK.
            return array("RESULT"=>TRUE,
                        "MESSAGE"=>"The method $name has been added successfully.",
                        "id"=>$result);
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
      * 
      * @return int The ID of the newly created method_info
      */
    public function add_method_info($name, $header, $option_header, $input_type, $parent_id=null) {
        $methodid=$this->id;
        if($input_type == input_type::get_input_id_by_name($this->db, USER_INTERACTION_INPUT_BOX_WITH_DROPDOWN)) {
            $header2=$header;
            $header = null;
            
        }
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
        if($result > 0) {
            if($input_type == input_type::get_input_id_by_name($this->db, USER_INTERACTION_NUMERIC_ENTRY) ||
                    $input_type == input_type::get_input_id_by_name($this->db, USER_INTERACTION_TEXT_ENTRY) ||
                    $input_type == input_type::get_input_id_by_name($this->db, USER_INTERACTION_TEXT_AREA)) {
                // Just add one default option
                $new_info = new method_infos($this->db, $result);
                $new_info->add_option($name);

            } else if($input_type == input_type::get_input_id_by_name($this->db, USER_INTERACTION_LEFT_RIGHT)) {
                // Add default options to Left-Right type
                $new_info = new method_infos($this->db, $result);
                $new_info->add_option("Left");
                $new_info->add_option("Right");
            } else if($input_type == input_type::get_input_id_by_name($this->db, USER_INTERACTION_INPUT_BOX_WITH_DROPDOWN)) {
                // Add numeric entry
                $this->add_method_info($name, $header2, $option_header, input_type::get_input_id_by_name($this->db, USER_INTERACTION_MULTISELECT), $result);
                // Add dropdown
                $this->add_method_info($name, $name, $option_header, input_type::get_input_id_by_name($this->db, USER_INTERACTION_NUMERIC_ENTRY), $result);
            }
        }
        
        return $result;
    } 
    
    /** Delete a method_info from this method
     * 
     * @param id $method_info_id The ID of the method_info to delete
     * @return int The number of deleted entries
     */
    public function delete_method_info($method_info_id) {
        $method_info = new method_infos($this->db, $method_info_id);
        $options = $method_info->get_method_info_options();
        
        // Delete options from database
        foreach($options as $option) {
            $method_info->delete_option($option->get_id());
        }
        
        $query = "DELETE FROM method_infos where id = :method_info_id";
        $params = array("method_info_id"=>$method_info_id);
        $result = $this->db->get_update_result($query, $params);
        
        return $result;
    }
    
    // Prompts
    
    /**
     * Gets the full prompt text for this method
     * 
     * @return string The full prompt text for this method
     */
    public function get_method_prompt() {
            if($this->prompt_id == null) {
                $promptid = 1; // Default prompt
            } else {
                $promptid = $this->prompt_id;
            }
            $query = "SELECT prompt from prompts where id = :id";
            $params = array("id"=>$promptid);
            $result = $this->db->get_query_result($query, $params);
            if(count($result) > 0) {
                return $result[0]['prompt'];
            } else {
                return '';
            }
        }

    
    // Static functions
    
    /** 
     * Gets an array of methods from the database
     * 
     * @param db $db The database object
     * @param int $start Starting index in the full list (optional)
     * @param int $limit Number of records to return (optional)
     * @param string $order Database column name to order the methods by. Defaults to 'methodname'
     * @return \method An array of method objects. If $start and $limit are given,
     *  $limit is the number of records to return, starting at index $start.
     *  Otherwise, all methods in the database will be returned.
     */
    public static function get_methods($db, $start = -1, $limit = -1, $order='methodname', $active=1) {
        // $active = 1: Only show active methods
        // $active = 0: Only show inactive methods
        // $active = -1: Show all methods
        
        $active_test = ($active >= 0) ? " where active=:active " : "";
        $query = "SELECT id from methods $active_test  ORDER BY $order ";
        $params = array("active"=>$active);
        if(is_numeric($start) && $start >= 0) {
            $query .= " LIMIT $start ";
            if(is_numeric($limit) && $limit > 0) {
                $query .= ", $limit";
            }
        }

        $result = $db->get_query_result($query, $params);
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
    public static function get_methods_by_type($db, $type_id, $active=1) {
            $query = "SELECT methodname,id FROM methods WHERE active=:active AND methodtypenum=:methodtypenum ";
            $query .= " ORDER BY top desc, methodname";
            $params = array("methodtypenum"=>$type_id, "active"=>$active);
            $result = $db->get_query_result($query, $params);
            $methods = array();
            foreach($result as $method) {
                $curr_method = new method($db, $method['id']);
                $methods[] = $curr_method;
            }
            return $methods;
        }
        
        
    /**
     * Gets a list of all method prompts available as an array in $id=>$value format
     * 
     * @param db $db The database object
     * 
     * @return an array of prompt ids and texts in $id=>$value format
     */    
    public static function get_all_prompts($db) {
        
        $query = "SELECT * from prompts ";
        $result = $db->get_query_result($query);
        
        $return_array = array();
        foreach($result as $prompt) {
            $return_array[$prompt['id']] = $prompt['prompt'];
        }
        
        return $return_array;
        
    }

    /** Adds a new prompt to the database
     * 
     * @param db $db The database object
     * @param string  $prompt_name Name of the prompt
     * @param string $prompt_text Display text of the prompt
     */
    public static function add_new_prompt($db, $prompt_name, $prompt_text) {
        
        $query = "INSERT INTO prompts (prompt_name, prompt) VALUES (:prompt_name, :prompt_text)";
        $params = array("prompt_name"=>$prompt_name, "prompt_text"=>$prompt_text);
        
        $result = $db->get_insert_result($query, $params);
        
        if($result > 0) {
            return array("RESULT"=>TRUE,
                         "MESSAGE"=>"Prompt added successfully.",
                         "id"=>$result);
            
        } else {
            return array("RESULT"=>FALSE,
                        "MESSAGE"=>"There was an error, the prompt was not added. Please check your input and try again."
                );
        }
        
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
         $this->prompt_id = $data['prompt'];
         $this->fdb = $data['fdb'];
         $this->top = $data['top'];
         $this->active = $data['active'];
         }
         
     }
}