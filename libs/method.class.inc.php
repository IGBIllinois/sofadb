<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class method {
    
    private $id;
    private $method_name;
    private $method_type;
    private $method_type_num;
    private $measurement_type;
    private $description;
    private $instructions;
    private $methodinfotype;
    
    private $tier2id;
    
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
        return $this->method_type;
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
                        //echo("Method $name updated successfully.<BR>");
                }
    }
    
    /** Gets a list of data and corresponding data type for this method
     * 
     */
    public function get_method_data() {
        $query = "SELECT * from methoddata where methodid = :methodid";
        $params = array("methodid"=>$this->id);
        //$result = $this->dbcon->query($query);
        $result = $this->db->get_query_result($query, $params);
        $data = array();
        foreach($result as $row) {
            $method_data = new methoddata($this->db, $row['id']);
            $data[] = $method_data;
        }
        return $data;
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
            echo("Method $name added successfully");
            return $result;
        }
    }
    

    /**Gets list of output_data_1 info for this method
     * 
     * @param string $user_interaction User interaction type (optional) If null, get all types
     * @param string $category Category (output_data_3). Used only for certain method types like Spradley_Jantz
     * @param string $subcategory subategory (output_data_4). Used only for certain method types like Spradley_Jantz
     * @param boolean $distinct True if you're getting distinct records, else false. If false, also return ids.
     * 
     * @return array An array of strings that are the output_data_1 for this method_info
     */
    public function get_data_1($user_interaction = null, $category = null, $subcategory=null, $distinct = true) {
        
        $output_data_1_query = "SELECT ". ($distinct ? " DISTINCT " : " id, ")
                . " output_data_1 from method_info where methodid = :method_id".
                
                (($user_interaction == null) ? "" : " and user_interaction = :user_interaction");
        $params = array("method_id"=>$this->id);
        if($user_interaction != null) {
            $params["user_interaction"] = $user_interaction;
        }
        if($category != null) {
            $output_data_1_query .= " AND output_data_3 = :category";
            $params['category'] = $category;
        }
        if($subcategory != null) {
            $output_data_1_query .= " AND output_data_4 = :subcategory";
            $params['subcategory'] = $subcategory;
        }

        $output_data_1_result = $this->db->get_query_result($output_data_1_query, $params);
        if(count($output_data_1_result) > 0) {
            // just return array of texts
            if(($output_data_1_result[0]['output_data_1']) != null) {
                return $output_data_1_result;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }
    
    /** Gets list of output_data_2 info for this method
     * 
     * @return array An array of strings that are the output_data_2 for this method_info
     */
    public function get_data_2($user_interaction = null, $category = null, $subcategory=null) {
        $output_data_2_query = "SELECT DISTINCT output_data_2 from method_info where methodid = :method_id and output_data_2 is not null ".(($user_interaction == null) ? "" : " and user_interaction = :user_interaction");
        $params = array("method_id"=>$this->id);
        if($user_interaction != null) {
            $params["user_interaction"] = $user_interaction;
        }
        if($category != null) {
            $output_data_2_query .= " AND output_data_3 = :category";
            $params['category'] = $category;
        }
        if($subcategory != null) {
            $output_data_2_query .= " AND output_data_4 = :subcategory";
            $params['subcategory'] = $category;
        }
        $output_data_2_result = $this->db->get_query_result($output_data_2_query, $params);
        if(count($output_data_2_result) > 0) {
            // just return array of texts
            if(($output_data_2_result[0]['output_data_2']) != null) {
                
                return $output_data_2_result;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }
    
    public function get_od2_for_od1($od1, $distinct = 0) {
        $query = "SELECT ".($distinct ? " DISTINCT " : "" ). " output_data_2 from method_info where methodid=:methodid and output_data_1=:od1";
        $params = array("methodid"=>$this->id,
                        "od1"=>$od1);
        $result = $this->db->get_query_result($query, $params);
        if(count($result > 0)) {
            return $result;
        }
    }

    
    /** Gets output_data_1 ids and names
     * 
     * @return array Array with id and name info for output_data_1 of this method
     */
    public function get_output_data_1() {
        $query = "SELECT id, output_data_1 from method_info where methodid=:methodid and output_data_1 is not null";
        $params = array("methodid"=>$this->id);


        $result = $this->db->get_query_result($query, $params);
        if(count($result > 0)) {
            return $result;
        }
    }
    
    /** Gets output_data_2 ids and names
     * 
     * @param $od1 output_data_1 id to get output_data_2 for. If null, get ALL output_data_2 data
     * 
     * @return array Array with id and name info for output_data_2 of this method
     */
    public function get_output_data_2($od1 = null) {
        $query = "SELECT id, output_data_2 from method_info where output_data_1=:od1 and methodid=:methodid";
        $params = array("od1"=>$od1,
                        "methodid"=>$this->id);
        if($od1 == null) {
            // get all od3 data
            $query = "SELECT id, output_data_2 from method_info where methodid=:methodid and output_data_2 is not null";
            $params = array("methodid"=>$this->id);
        }

        $result = $this->db->get_query_result($query, $params);
        if(count($result > 0)) {
            return $result;
        }
    }
    
    /** Gets output_data_3 ids and names
     * 
     * @param $od1 output_data_1 id to get output_data_3 for. If null, get ALL output_data_3 data
     * @param $od2 output_data_2 id to get output_data_3 for. If null, get ALL output_data_3 data
     *      
     * @return array Array with id and name info for output_data_3 of this method
     */ 
   public function get_output_data_3($od1 = null, $od2 = null) {
        $query = "SELECT id, output_data_3 from method_info where output_data_1=:od1 and output_data_2=:od2 and methodid=:methodid";
        $params = array("od1"=>$od1,
                        "od2"=>$od2,
                        "methodid"=>$this->id);
        if($od1 == null && $od2 == null) {
            // get all od3 data
            $query = "SELECT id, output_data_3 from method_info where methodid=:methodid and output_data_3 is not null";
            $params = array("methodid"=>$this->id);
        }

        $result = $this->db->get_query_result($query, $params);
        if(count($result > 0)) {
            return $result;
        }
    }
    
    
    /** Gets output_data_4 ids and names
     * 
     * @param $od1 output_data_1 id to get output_data_3 for. If null, get ALL output_data_4 data
     * @param $od2 output_data_2 id to get output_data_3 for. If null, get ALL output_data_4 data
     *      
     * @return array Array with id and name info for output_data_4 of this method
     */    
    public function get_output_data_4($od1 = null, $od2 = null) {
        $query = "SELECT id, output_data_4 from method_info where output_data_1=:od1 and output_data_2=:od2 and methodid=:methodid";
        $params = array("od1"=>$od1,
                        "od2"=>$od2,
                        "methodid"=>$this->id);
        
        if($od1 == null && $od2 == null) {
            // get all od4 data
            $query = "SELECT id, output_data_4 from method_info where methodid=:methodid and output_data_4 is not null";
            $params = array("methodid"=>$this->id);
        }

        $result = $this->db->get_query_result($query, $params);
        if(count($result > 0)) {
            return $result;
        }
    }
    
    public function get_reference_list($od1, $od2) {
        $query = "SELECT reference_listt from method_info where output_data_1=:od1 and output_data_2=:od2 and methodid=:methodid";
        $params = array("od1"=>$od1,
                        "od2"=>$od2,
                        "methodid"=>$this->id);

        $result = $this->db->get_query_result($query, $params);
        if(count($result > 0)) {
            return $result;
        }
    }
    
    
    public function get_header_1($method_info_id=null) {
        $output_data_header_query = "SELECT DISTINCT output_data_1_description from method_info where methodid = :method_id ";
        $params = array("method_id"=>$this->id);
        if($method_info_id != null) {
            $output_data_header_query .= " AND id = :method_info_id";
            $params['method_info_id'] = $method_info_id;
        }
        $output_data_header_result = $this->db->get_query_result($output_data_header_query, $params);
        if(count($output_data_header_result) > 0) {
            if(($output_data_header_result[0]['output_data_1_description']) != null) {
                return $output_data_header_result[0]['output_data_1_description'];
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public function get_header_2($method_info_id=null) {
        $output_data_header_query = "SELECT DISTINCT output_data_2_description from method_info where methodid = :method_id ";
        $params = array("method_id"=>$this->id);
        if($method_info_id != null) {
            $output_data_header_query .= " AND id = :method_info_id";
            $params['method_info_id'] = $method_info_id;
        }
        $output_data_header_result = $this->db->get_query_result($output_data_header_query, $params);
        if(count($output_data_header_result) > 0) {
            if(($output_data_header_result[0]['output_data_2_description']) != null) {
                return $output_data_header_result[0]['output_data_2_description'];
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
    
    public function get_header_3($method_info_id=null) {
        $output_data_header_query = "SELECT DISTINCT output_data_3_description from method_info where methodid = :method_id";
        $params = array("method_id"=>$this->id);
        if($method_info_id != null) {
            $output_data_header_query .= " AND id = :method_info_id";
            $params['method_info_id'] = $method_info_id;
        }
        $output_data_header_result = $this->db->get_query_result($output_data_header_query, $params);
        if(count($output_data_header_result) > 0) {
            if(($output_data_header_result[0]['output_data_3_description']) != null) {
                return $output_data_header_result[0]['output_data_3_description'];
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
    
    public function get_header_4($method_info_id=null) {
        $output_data_header_query = "SELECT DISTINCT output_data_4_description from method_info where methodid = :method_id";
        $params = array("method_id"=>$this->id);
        if($method_info_id != null) {
            $output_data_header_query .= " AND id = :method_info_id";
            $params['method_info_id'] = $method_info_id;
        }
        $output_data_header_result = $this->db->get_query_result($output_data_header_query, $params);
        if(count($output_data_header_result) > 0) {
            if(($output_data_header_result[0]['output_data_4_description']) != null) {
                return $output_data_header_result[0]['output_data_4_description'];
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
    
    public function get_method_info() {
        $query = "SELECT id from method_info where methodid=:methodid order by id";
        $params = array("methodid"=>$this->id);
        $result = $this->db->get_query_result($query, $params);
        if(count($result) > 0) {
            $infos = array();
            foreach($result as $method_info) {
                $new_method_info = new method_info($this->db, $method_info['id']);
                $infos[] = $new_method_info;
            }
            return $infos;
        }
    }
    
    public function get_method_info_by_type($user_interaction) {
        $query = "SELECT id from method_info where methodid=:methodid and user_interaction = :user_interaction";
        $params = array("methodid"=>$this->id, "user_interaction"=>$user_interaction);
        $result = $this->db->get_query_result($query, $params);
        if(count($result) > 0) {
            $infos = array();
            foreach($result as $method_info) {
                $new_method_info = new method_info($this->db, $method_info['id']);
                $infos[] = $new_method_info;
            }
            return $infos;
        }
    }
    
    public function get_method_info_by_od1($od1, $od2 = null, $od3 = null, $od4=null) {
        $query = "SELECT id from method_info where methodid=:methodid and output_data_1 = :od1";
        $params = array("methodid"=>$this->id, "od1"=>$od1);

         if($od2 != null) {
            $query .= " AND output_data_2 = :od2 ";
            $params["od2"] = $od2;
        }
        if($od3 != null) {
            $query .= " AND output_data_3 = :od3 ";
            $params["od3"] = $od3;
        }
        if($od4 != null) {
            $query .= " AND output_data_4 = :od4 ";
            $params["od4"] = $od4;
        }

        $result = $this->db->get_query_result($query, $params);
        if(count($result) > 0) {
            $infos = array();
            foreach($result as $method_info) {
                $new_method_info = new method_info($this->db, $method_info['id']);
                $infos[] = $new_method_info;
            }
            return $infos;
        }
    }
    
    /**
     * 
     * @return type An array of estimated outcome possibilities for this method
     */
    public function get_estimated_outcomes_orig() {
        $query = "SELECT output_data_1 from method_info where methodid=:methodid ".
                " AND user_interaction=:user_interaction";
        $params = array("methodid"=>$this->get_id(),
                        "user_interaction"=>USER_INTERACTION_ESTIMATED_OUTCOME);
        $result = $this->db->get_query_result($query, $params);
        $return_result = array();
        if(count($result) > 0){ 
            foreach($result as $data) {
                $return_result[] = $data[0];
            }
            return $return_result;
        } else {
            return array();
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
    
    /** Gets categories (output_data_3) for a Spradley/Jantz type method
     * 
     */
    public function get_categories() {
        $category_query = "SELECT DISTINCT output_data_3, output_data_3_description from method_info where methodid = :methodid";
            $params = array("methodid"=>$this->get_id());
            $result = $this->db->get_query_result($category_query, $params);
            return $result;
    }
    
    // Static functions
    
    public static function get_methods($db, $start = -1, $limit = -1) {
        $query = "SELECT id from methods ";
        if(is_numeric($start) && $start >= 0) {
            $query .= " LIMIT $start ";
            if(is_numeric($limit) && $limit > 0) {
                $query .= ", $limit";
            }
        }
        //$result = mysqli_query ($dbcon, $query);
        $result = $db->get_query_result($query);
        $methods = array();
        foreach($result as $method) {
            $id = $method['id'];
            $new_method = new method($db, $id);
            $methods[] = $new_method;
        }
        return $methods;
    }
    
    public static function get_methods_by_type($db, $type_id) {
            $query = "SELECT methodname,id FROM methods WHERE methodtypenum=:methodtypenum ";
            if($type_id == 1) {
                // Specific order for Sex methods
                $query .= "order by "
                        . "methodname = 'Fordisc (skeletal, metric)' desc, "
                        . "methodname = 'Generalized Morphology (skeleton, nonmetric)' desc, "
                        . "methodname = 'Soft Tissue Morphology (nonmetric)' desc, "
                        . "methodname = '3D-ID' desc, "
                        . "methodname ASC";
            } else if($type_id == 2) {
                // Specific order for Age methods
                $query .= "Order by "
                        . "methodname = 'Epiphyseal Union (skeletal, nonmetric)' desc, "
                        . "methodname = 'Epiphyseal Union, McKern and Stuart (skeletal, nonmetric)' desc, "
                        . "methodname = 'Transition Analysis (skeletal, nonmetric)' desc, "
                        . "methodname ASC";
            } else if($type_id == 3) {
                // Specific order for Ancestry methods
                $query .= "Order by ".
                        "methodname = '3D-ID' desc, ".
                        "methodname ='Fordisc (skeletal, metric)' desc,".
                        "methodname ASC";
            } else if($type_id == 4) {
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
        
        // New version
        public function get_method_infos() {
            $query = "SELECT id from method_infos where methodid=:methodid";
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
                $type_query = "SELECT DISTINCT input_type from method_infos where methodid = :methodid ORDER BY FIELD(input_type,4,5,7)";
                //echo("query = $type_query");
                $type_params =array("methodid"=>$this->id);
                $type_result = $this->db->get_query_result($type_query, $type_params);
            } else {
                $type_result = array('input_type'=>$type);
            }

            $text_type = input_type::get_input_type_by_name($this->db, USER_INTERACTION_TEXT_ENTRY);
            $numeric_type = input_type::get_input_type_by_name($this->db, USER_INTERACTION_NUMERIC_ENTRY);
            
            $out = array_splice($type_result, $text_type, 1);
            array_splice($type_result, 0, 0, $out);
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
            /*
            //print_r("orig return array = ");
            //print_r($return_array);
            $text_type = input_type::get_input_type_by_name($this->db, USER_INTERACTION_TEXT_ENTRY);
            $numeric_type = input_type::get_input_type_by_name($this->db, USER_INTERACTION_NUMERIC_ENTRY);
            //echo("text_type = $text_type<BR>");
            //echo("num_type = $numeric_type<BR>");
            echo("orig keys = ");
            print_r(array_keys($return_array));
            $i=0;
            foreach($return_array as $id=>$info_array) {
                echo("id = $id");
                if($id == $text_type->get_id() || $id == $numeric_type->get_id()) {
                    echo("found id $id");
                    $out = array_splice($return_array, $i, 1);
                    array_splice($return_array, 0,0,$out);
                }
            }
            echo("new keys = ");
            print_r(array_keys($return_array));
            */
            return $return_array;
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
         $this->method_type = $data['methodtype'];
         $this->method_type_num = $data['methodtypenum'];
         $this->measurement_type = $data['measurementtype'];
         $this->description = $data['description'];
         $this->instructions = $data['instructions'];
         $this->methodinfotype = $data['methodinfotype'];
         }
         
     }
}