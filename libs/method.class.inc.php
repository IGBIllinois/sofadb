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
    
    /** Add a list of features to this Method
     * 
     * @param array $new_features An array of feature IDs to add to this method
     */
    public function add_features($new_features) {
        foreach($new_features as $id=>$feature) {
            $query = "INSERT INTO methodfeature (methodid, featureid, measurementtype) VALUES(".
                   ":methodid ,".
                   ":featureid,"
                    . "'')";
            $params = array("methodid"=>$this->id, "featureid"=>$feature);

            $result = $this->db->get_insert_result($query, $params);
        }
    }
    
    public function edit_features($new_features) {
        $curr_features = $this->get_features();
        $curr_feature_ids = array(); 
        foreach($curr_features as $curr_feature) {
            $curr_feature_ids[] = $curr_feature->get_id();
        }
        if($new_features != null) {
        foreach($new_features as $id) {
            if( !in_array($id, $curr_feature_ids)) {
            $query = "INSERT INTO methodfeature (methodid, featureid, measurementtype) VALUES(".
                   ":methodid ,".
                   ":featureid,"
                    . "'')";
            $params = array("methodid"=>$this->id, "featureid"=>$id);
            $result = $this->db->get_insert_result($query, $params);

            }
        }
        }
        // Remove old features
        foreach($curr_features as $feature) {
            $feature_id = $feature->get_id();
            if($feature_id != "" && !in_array($feature_id, $new_features)) {
            $query = "DELETE FROM methodfeature WHERE methodid = ".
                   ":methodid".
                    " AND featureid = ".
                   ":featureid";
            $params = array("methodid"=>$this->id, "featureid"=>$feature_id);

            $result = $this->db->get_update_result($query, $params);
            
            }
        }
        
    }
    
    /** Add a list of phases to this Method
     * 
     * @param int feature ID of the feature to add phases to
     * @param array $new_phases An array of feature IDs to add to this method
     */
    public function add_phases($feature, $new_phases) {
        foreach($new_phases as $phase) {
            $query = "INSERT INTO methodphase (methodid, featureid, $phaseid) VALUES(".
                   ":methodid ,".
                   ":featureid)";
        }
    }
    
    public function get_features() {
        $query = "SELECT featureid from methodfeature where methodid = :id";
        $params = array("id"=>$this->id);
        $result = $this->db->get_query_result($query, $params);
        $features = array();
        foreach($result as $row) {
            //$features[] = $row['featureid'];
            $features[] = new feature($this->db, $row['featureid']);
        }
        return $features;
    }
    
    public function get_phases() {
        $query = "SELECT * from methodphase where methodid = '".mysqli_real_escape_string($this->dbcon, $this->id) ."'";
        $result = $this->db->get_query_result($query);
        return mysqli_fetch_array($result,MYSQLI_ASSOC);
    
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
        $query = "SELECT id from method_info where methodid=:methodid";
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
    public function get_estimated_outcomes() {
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
            $query = "SELECT methodname,id FROM methods WHERE methodtypenum=:methodtypenum Order by methodname ASC";
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
         $this->method_type = $data['methodtype'];
         $this->method_type_num = $data['methodtypenum'];
         $this->measurement_type = $data['measurementtype'];
         $this->description = $data['description'];
         $this->instructions = $data['instructions'];
         $this->methodinfotype = $data['methodinfotype'];
         }
         
     }
}