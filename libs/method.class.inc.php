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
    
    private $dbcon;
    
    public function __construct($dbcon, $id = null) {
        $this->dbcon = $dbcon;
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
    
    /** Add a list of features to this Method
     * 
     * @param array $new_features An array of feature IDs to add to this method
     */
    public function add_features($new_features) {
        foreach($new_features as $id=>$feature) {
            $query = "INSERT INTO methodfeature (methodid, featureid, measurementtype) VALUES(".
                   "'". mysqli_real_escape_string($this->dbcon, $this->id). "' ,".
                   "'". mysqli_real_escape_string($this->dbcon, $feature). "',"
                    . "'')";

            $result = $this->dbcon->query($query);
        }
    }
    
    public function edit_features($new_features) {
        $curr_features = $this->get_features();
        echo("features = ");
        print_r($curr_features);
        foreach($new_features as $id) {
            if((count($curr_features) > 0) && !in_array($id, $curr_features)) {
            $query = "INSERT INTO methodfeature (methodid, featureid, measurementtype) VALUES(".
                   "'". mysqli_real_escape_string($this->dbcon, $this->id). "' ,".
                   "'". mysqli_real_escape_string($this->dbcon, $id). "',"
                    . "'')";

            $result = $this->dbcon->query($query);
            }
        }
        // Remove old features
        foreach($curr_features as $feature_id) {
            if($feature_id != "" && !in_array($feature_id, $new_features)) {
            $query = "DELETE FROM methodfeature WHERE methodid = ".
                   "'".mysqli_real_escape_string($this->dbcon, $this->id). "'".
                    " AND featureid = ".
                   "'". mysqli_real_escape_string($this->dbcon, $feature_id). "'";

            $result = $this->dbcon->query($query);
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
                   "'". mysqli_real_escape_string($this->dbcon, $this->id). "' ,".
                   "'". mysqli_real_escape_string($this->dbcon, $feature). "')";
        }
    }
    
    public function get_features() {
        $query = "SELECT featureid from methodfeature where methodid = '".mysqli_real_escape_string($this->dbcon, $this->id) ."'";
        $result = $this->dbcon->query($query);
        $features = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $features[] = $row['featureid'];
        }
        return $features;
    }
    
    public function get_phases() {
        $query = "SELECT * from methodphase where methodid = '".mysqli_real_escape_string($this->dbcon, $this->id) ."'";
        $result = $this->dbcon->query($query);
        return mysqli_fetch_array($result,MYSQLI_ASSOC);
    
    }
    
    public function update_method(
            $name, 
            $type, 
            $type_num, 
            $measurement_type, 
            $description,
            $instructions) {
                $query = "UPDATE method SET (".
                    "methodname = '". mysqli_real_escape_string($this->dbcon, $name) ."',".
                    " methodtype = '". mysqli_real_escape_string($this->dbcon, $type)."', ".
                    " methodtypenum = '". mysqli_real_escape_string($this->dbcon, $type_num)."', ".
                    " measurementtype = '". mysqli_real_escape_string($this->dbcon, $measurement_type)."', ".
                    " description = '". mysqli_real_escape_string($this->dbcon, $description)."', ".
                    " instructions = '". mysqli_real_escape_string($this->dbcon, $instructions)."') ";

                $result = @mysqli_query ($this->dbcon, $query); // Run the query.
                if ($result) { // If it ran OK.
                        echo("Method $name updated successfully.<BR>");
                }
    }
    
    /** Gets a list of data and corresponding data type for this method
     * 
     */
    public function get_method_data() {
        $query = "SELECT * from methoddata where methodid = '".mysqli_real_escape_string($this->dbcon, $this->id) ."'";
        $result = $this->dbcon->query($query);
        $data = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $method_data = new methoddata($this->dbcon, $row['id']);
            $data[] = $method_data;
        }
        return $data;
    }
    
    // Static functions
    
    public static function create_method(
            $dbcon,
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
               "'". mysqli_real_escape_string($dbcon, $name) ."', ".
               "'". mysqli_real_escape_string($dbcon, $type)."', ".
               "'". mysqli_real_escape_string($dbcon, $type_num)."', ".
               "'". mysqli_real_escape_string($dbcon, $measurement_type)."', ".
               "'". mysqli_real_escape_string($dbcon, $description)."', ".
               "'". mysqli_real_escape_string($dbcon, $instructions)."') ";

        $result = @mysqli_query ($dbcon, $query); // Run the query.

	if ($result) { // If it ran OK.
            $id = mysqli_insert_id($dbcon);
            echo("Method $name added successfully");
            return $id;
        }
    }
    
    public static function get_methods($dbcon, $start = 0, $limit = 0) {
        $query = "SELECT id from methods ";
        if(is_numeric($start)) {
            $query .= " LIMIT $start ";
            if(is_numeric($limit)) {
                $query .= ", $limit";
            }
        }
        $result = mysqli_query ($dbcon, $query);
        $methods = array();
        foreach($result as $method) {
            $id = $method['id'];
            $new_method = new method($dbcon, $id);
            $methods[] = $new_method;
        }
        return $methods;
    }
    
     // Private functions

     /** Loads database data into this method
      * 
      * @param int $id The id of the method to load
      */
     private function load_method($id) {
         $query = "SELECT * from methods where id = '" . mysqli_real_escape_string($this->dbcon, $id) . "'";
         $result = mysqli_query($this->dbcon,$query);
         $data = mysqli_fetch_array($result, MYSQLI_ASSOC);
         $this->id = $id;
         $this->method_name = $data['methodname'];
         $this->method_type = $data['methodtype'];
         $this->method_type_num = $data['methodtypenum'];
         $this->measurement_type = $data['measurementtype'];
         $this->description = $data['description'];
         $this->instructions = $data['instructions'];
         
     }
}

class methoddata {
    
    private $id;
    private $method_id;
    private $data_name;
    private $data_type;
    
    private $dbcon;
    
    public function __construct($dbcon, $id = 0) {
        $this->dbcon = $dbcon;
        if($id != 0) {
            $this->load_method_data($id);
        }
    }
    
    public function get_id() { return $this->id; }
    public function get_method_id() { return $this->method_id; }
    public function get_name() { return $this->data_name; }
    public function get_type() { return $this->data_type; }
    
    // Static functions
    
    public static function add_method_data($dbcon, $method_id, $data_name, $data_type) {
        $query = "INSERT INTO methoddata (".
                "methodid, ".
            " dataname, ".
            " datatype)".
            " VALUES (".
               "'". mysqli_real_escape_string($dbcon, $method_id) ."', ".
               "'". mysqli_real_escape_string($dbcon, $data_name)."', ".
               "'". mysqli_real_escape_string($dbcon, $data_type)."') ";
//echo("add method data query = $query<BR>");
        $result = @mysqli_query ($dbcon, $query); // Run the query.

	if ($result) { // If it ran OK.
            $id = mysqli_insert_id($dbcon);
            echo("Method Data $data_name added successfully");
            return $id;
        }
    }
    
    private function load_method_data($id) {
       $query = "SELECT * from methoddata where id='".mysqli_escape_string($this->dbcon, $id). "'";
       $result = mysqli_query($this->dbcon,$query);
       $data = mysqli_fetch_array($result, MYSQLI_ASSOC);
       
       $this->id = $id;
        $this->method_id = $data['methodid'];
        $this->data_name = $data['dataname'];
        $this->data_type = $data['datatype'];
       
    }
}
            
    
