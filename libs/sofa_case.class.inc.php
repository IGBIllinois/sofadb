<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class sofa_case {
    
    private $db;
    
    private $id;
    
    private $casename;
    private $casenumber;
    private $caseyear;
    private $memberid;
    private $caseagency;
    private $fasex;
    private $faage;
    private $faage2;
    private $faageunits;
    private $faageunits2;
    private $fastature;
    private $fastature2;
    private $fastatureunits;
    private $idsex;
    private $idage;
    private $idageunits;
    private $idstature;
    private $idstatureunits;
    private $idsource;
    private $casenotes;
    private $datestarted;
    private $datemodified;
    private $datesubmitted;
    private $submissionstatus;
    private $faancestryas;
    private $faancestryeuro;
    private $faancestryaf;
    private $faancestryna;
    private $faancestryhi;
    private $faancestryot;
    private $faancestryottext;
    private $idraceas;
    private $idraceaf;
    private $idracewh;
    private $idracehi;
    private $idracena;
    private $idraceot;
    private $idraceottext;
    private $idancaddtext;
    private $nummethods;
    
    // getters
    public function get_id() { return $this->id; }
    public function get_casename() { return $this->casename; }
    public function get_casenumber() { return $this->casenumber; }
    public function get_caseyear() { return $this->caseyear; }
    public function get_memberid() { return $this->memberid; }
    public function get_caseagency() { return $this->caseagency; }
    public function get_fasex() { return $this->fasex; }
    public function get_faage() { return $this->faage; }
    public function get_faage2() { return $this->faage2; }
    public function get_faageunits() { return $this->faageunits; }
    public function get_faageunits2() { return $this->faageunits2; }
    public function get_fastature() { return $this->fastature; }
    public function get_fastature2() { return $this->fastature2; }
    public function get_fastatureunits() { return $this->fastatureunits; }
    
    public function get_idsex() { return $this->idsex; }
    public function get_idage() { return $this->idage; }
    public function get_idageunits() { return $this->idageunits; }
    public function get_idstature() { return $this->idstature; }
    public function get_idstatureunits() { return $this->idstatureunits; }
    public function get_idsource() { return $this->idsource; }
    public function get_casenotes() { return $this->casenotes; }
    public function get_datestarted() { return $this->datestarted; }
    public function get_datemodified() { return $this->datemodified; }
    public function get_datesubmitted() { return $this->datesubmitted; }
    public function get_submissionstatus() { return $this->submissionstatus; }
    public function get_faancestryas()  { return $this->faancestryas; }
    public function get_faancestryeuro()  { return $this->faancestryeuro; }
    public function get_faancestryaf()  { return $this->faancestryaf; }
    public function get_faancestrywh()  { return $this->faancestrywh; }
    public function get_faancestryhi()  { return $this->faancestryhi; }
    public function get_faancestryna()  { return $this->faancestryna; }
    public function get_faancestryot()  { return $this->faancestryot; }
    public function get_faancestryottext()  { return $this->faancestryottext; }
    public function get_idraceas()  { return $this->idraceas; }
    public function get_idraceaf()  { return $this->idraceaf; }
    public function get_idracewh()  { return $this->idracewh; }
    public function get_idracehi()  { return $this->idracehi; }
    public function get_idracena()  { return $this->idracena; }
    public function get_idraceot()  { return $this->idraceot; }
    public function get_idraceottext()  { return $this->idraceottext; }
    public function get_idancaddtext() { return $this->idancaddtext; }
    public function get_nummethods() { return $this->nummethods; }

    public function __construct($db, $id = 0) {


        $this->db = $db;

        if($id != 0) {
            $this->load_case($id);
        }
        
    }
    
    /**
     * 
     * @param type $db Connection to database
     * @param type $data array of values. Using an array here since thera are so many
     */
    public static function add_case($db, $data) {

                        
        $q = "INSERT INTO cases ("
                . "casename, "
                . "casenumber,"
                . "caseyear,"
                . "memberid,"
                . "caseagency,"
                
                . "fasex,"
                . "faage,"
                . "faage2,"
                . "faageunits,"
                . "faageunits2,"
                
                . "fastature,"
                . "fastature2,"
                . "fastatureunits,"
                . "idsex,"
                . "idage,"
                
                . "idageunits,"
                . "idstature,"
                . "idstatureunits,"
                . "idsource,"
                . "casenotes,"
                
                . "datestarted,"
                . "datemodified,"
                . "submissionstatus,"
                . "faancestryas,"
                . "faancestryeuro,"
                
                . "faancestryaf,"
                . "faancestryna,"
                . "faancestryhi,"
                . "faancestryot,"
                . "faancestryottext,"
                
                . "idraceas,"
                . "idraceaf,"
                . "idracewh,"
                . "idracehi,"
                . "idracena,"
                
                . "idraceot,"
                . "idraceottext,"
                . "idancaddtext,"
                . "nummethods) "
                
                . "VALUES ("
                    . ":casename,"
                    . ":casenum,"
                    . ":caseyear,"
                    . ":memberid,"
                    . ":caseag,"
                
                    . ":fasex,"
                    . ":faage,"
                    . ":faage2,"
                    . ":faageunits,"
                    . ":faageunits2,"
                
                    . ":fastature,"
                    . ":fastature2,"
                    . ":fastatureunits,"
                    . ":idsex,"
                    . ":idage,"
   
                    . ":idageunits,"
                    . ":idstature,"
                    . ":idstatureunits,"
                    . ":idsource,"
                    . ":casenotes,"
                
                    . "NOW(),"
                    . "NOW(),"
                    . "'0',"
                    . ":faancestryas,"
                    . ":faancestryeuro,"
                
                    . ":faancestryaf,"
                    . ":faancestryna,"
                    . ":faancestryhi,"
                    . ":faancestryot,"
                    . ":faancestryottext,"
                
                    . ":idraceas,"
                    . ":idraceaf,"
                    . ":idracewh,"
                    . ":idracehi,"
                    . ":idracena,"
                
                    . ":idraceot,"
                    . ":idraceottext,"
                    . ":idancaddtext,"
                    . ":numcasemethods)";	
        

                $caseid = $db->get_insert_result($q, $data);
                

                if($caseid == 0) {
                    return array("RESULT"=>FALSE,
                            "MESSAGE"=>"<h2>System Error</h2>
				<p class='error'>Saving failed because of a system error. We apologize for any inconvenience.</p>
				<p> " . $db->errorInfo()[2] ."<br/><br/>Query: " . $q . "</p>"
                        );
                }

                $q = "INSERT INTO membercasetable (memberid,caseid) VALUES (:memberid,:caseid)";
                $d = array("memberid"=>$data['memberid'], "caseid"=>$caseid);

                $result2 = $db->get_insert_result($q, $d);
                

                return array("RESULT"=>TRUE,
                             "MESSAGE"=>"<h2>System Error</h2>
				<p class='error'>Case added successfully.</p>",
                             "id"=>$caseid
                              
                        );
    }
    
    
    /** Adds a method to a case
     * 
     * @param type $methodid ID of the method to add
     * @param type $methodtype Type of the method to add
     * @param type $featureid Feature id of the method to add
     * @param type $phaseid Phase id of the method to add
     * @return type ID of the newly created case-method
     */
    public function add_case_method($methodid, $methodtype, $featureid, $phaseid) {
        $q="INSERT INTO tier2data "
                . "("
                . "memberid,"
                . "caseid,"
                . "methodtype,"
                . "methodid,"
                . "featureid,"
                . "phaseid) "
                . "VALUES ("
                . ":memberid,"
                . ":caseid,"
                . ":methodtype,"
                . ":methodid,"
                . ":featureid,"
                . ":phaseid)";
        
        
                $data = array("memberid"=>$this->memberid,
                        "caseid"=>$this->id,
                        "methodid"=>$methodid,
                        "methodtype"=>$methodtype,
                        "featureid"=>$featureid,
                        "phaseid"=>$phaseid);

                $casemethodid = $this->db->get_insert_result($q, $data);
                
                 
                 if($casemethodid > 0) {
                     // everything went okay, update nummethods
                     $q="UPDATE members SET totalcases=totalcases + 1 WHERE id=:memberid";
                     $data = array("memberid"=>$this->memberid);
                     $result = $this->db->get_update_result($q, $data);
                        if( count($result) == 0) {
                                echo '<h2>System Error</h2>
                        <p class="error">Did not increment number of cases. We apologize for any inconvenience.</p>'; 
                        // Debugging message:
                        echo '<p>'. '<br/><br/>Query: ' . $q . '</p>';
                        return array("RESULT"=>FALSE,
                                    "MESSAGE"=>"Did not increment number of cases. We apologize for any inconvenience.");
                        } else {
                            // okay
                            return array("RESULT"=>TRUE,
                                    "MESSAGE"=>"Method case added successfully.",
                                    "id"=>$casemethodid);
                        }
                 } else {
                     return array("RESULT"=>FALSE,
                                    "MESSAGE"=>"Could not add method. We apologize for any inconvenience.");
                 }
                 
      
    }

public function submit_case($submitstatus) {

	$q="UPDATE cases SET submissionstatus=:status,datesubmitted=NOW() WHERE id=:caseid";
	$params = array("status"=>$submitstatus, $caseid=>$this->get_id());
	$result = $this->db->get_update_result($q, $params);

	if(count($result) == 0) {
	return array("RESULT"=>FALSE,
		"MESSAGE"=> 'System Error: Could not submit case, try again later.');
	}
	
	$this_member = new member($this->db, $this->memberid);

	$q="UPDATE members SET casessubmitted=casessubmitted+1 WHERE id='$memberid'";
	$params = array("casessubmitted"=>($this->get_casessubmitted() + 1),
			"memberid"=>$this->memberid);
	$result = $this->db->get_update_result($q, $params);


	if(count($result) == 0) {
	return array("RESULT"=>FALSE,
	"MESSAGE"=>'System Error: Could not update submit data.');
	}
}


    /** Edits case data
     * 
     * @param array $data an array of case data in $key=>$value form
     * @return array an array in the form
     *  ("RESULT"=>$result,
     *      "MESSAGE"=>$message)
     * where "RESULT" is true if successful, else false, and "MESSAGE" is an
     * output message
     * 
     */
    public function edit_case($data) {
        $q = "UPDATE cases SET "
                . "casename=:casename,"
                . "caseyear=:caseyear,"
                . "casenumber=:casenum,"
                . "caseagency=:caseag,"
                . "fasex=:fasex,"
                
                . "faage=:faage,"
                . "faage2=:faage2,"
                . "faageunits=:faageunits, "
                . "faageunits2=:faageunits2,"
                . "fastature=:fastature,"
                
                . "fastature2=:fastature2,"
                . "fastatureunits=:fastatureunits,"
                . "idsex=:idsex,"
                . "idage=:idage,"
                . "idageunits=:idageunits,"
                
                . "idsource=:idsource,"
                . "idstature=:idstature,"
                . "idstatureunits=:idstatureunits,"
                . "casenotes=:casenotes,"
                . "datemodified=NOW(),"
                
                . "faancestryas=:faancestryas,"
                . "faancestryeuro=:faancestryeuro,"
                . "faancestryaf=:faancestryaf,"
                . "faancestryna=:faancestryna,"
                . "faancestryhi=:faancestryhi,"
                . "faancestryot=:faancestryot,"
                
                . "faancestryottext=:faancestryottext,"
                . "idraceas=:idraceas,"
                . "idraceaf=:idraceaf,"
                . "idracewh=:idracewh,"
                . "idracehi=:idracehi,"
                . "idracena=:idracena,"
                . "idraceot=:idraceot,"
                
                . "idraceottext=:idraceottext,"
                . "idancaddtext=:idancaddtext,"
                . "nummethods=:numcasemethods "
                . " WHERE id=:caseeditid";
        
        $this->db->get_update_result($q, $data);
        return array("RESULT"=>TRUE,
                    "MESSAGE"=>"Case ".$this->get_casename() . " edited successfully.");
				
    }
    
    
    /** Gets all the methods for this case
     * 
     * @return \tier2data An array of tier2data objects that represent
     * the methods used in this case
     */
    public function get_case_methods() {
        $query = "SELECT * from tier2data where caseid = :id";
        $params = array("id"=>$this->id);
        $result = $this->db->get_query_result($query, $params);
        $tier2s = array();
        foreach($result as $id) {
            $tier2 = new tier2data($this->db, $id['id']);
            $tier2s[] = $tier2;
        }
        return $tier2s;
    }
 
    public function get_method_info($caseid,    
                                    $methodid) {
        
        $case = new sofa_case($this->db, $caseid);
        $method = new method($this->db, $methodid);
        
        $methoddata = new method_info($db);
        $methoddataobjects = $methoddata->get_method_data($caseid, $methodid);
        return $methoddataobjects;

            
    }
    
    /**
     * Adds multiple tier3 data
     * 
     * @param int $method_case_id ID of case method to update
     * @param array $output_data_1 Array of output_data_1 values
     * @param array $output_data_2 Array of output_data_2 values, optional
     * @param array $od1Names Array of output_data_1 names, used for INPUT_BOX, NUMERIC_ENTRY type
     */
    public function add_all_tier3_data($method_id, $method_case_id, $output_data_1, $output_data_2=null, $od1Names=null, $references = null) {

            $method = new method($this->db, $method_id);
            
                $method_data = method_info::get_data_for_method($this->db, $method_id);
                
                $method_info_type = $method->get_method_info_type();
                if($method_info_type == METHOD_INFO_TYPE_SPRADLEY_JANTZ) {

                    
                    foreach($output_data_1 as $od1=>$value) {
                        if(is_array($value)) {
                            $decode_od1 = urldecode($od1);
                            $od2 = $value[0];
                            $od2 = urldecode($od2);
                            //echo("od1 = $decode_od1, od2 = $od2<BR>");
                            $method_info_arr = $method->get_method_info_by_od1($decode_od1, $od2);
                            if(count($method_info_arr) > 0) {
                                $method_info = $method_info_arr[0];
                            
                                $result = $this->add_tier3($method_id, $decode_od1, $od2, $method_case_id, null, $method_info->get_user_interaction() );
                            }else {
                                echo("method_info not found<BR>");
                            }
                            
                        } else {
                            $encode_od1 = urlencode($od1);
                            $od2 = $output_data_2[$encode_od1];
                            $od2 = urldecode($od2);
                            //echo("od1 = $od1, od2 = $od2<BR>");
                            $method_info_arr = $method->get_method_info_by_od1($od1, $od2);
                            if(count($method_info_arr) > 0) {
                                $method_info = $method_info_arr[0];
                                //echo("<BR>method_info = ".$method_info->get_id());
                                //echo("<BR>type = ".$method_info->get_user_interaction());
                                //echo("<BR>value = $value");
                                $result = $this->add_tier3($method_id, $od1, $od2, $method_case_id, $value, $method_info->get_user_interaction());
                            } else {
                                echo("<BR>method_info not found<BR>");
                            }
                        }
                        

                  

                    }
                } else {
                if(count($method_data) > 0) {
                    
                    $user_interactions = $method_data[0]->get_user_interactions();
                    $user_interaction = $method_data[0]->get_user_interaction();
                    if($user_interaction == USER_INTERACTION_MULTISELECT) {
                        if(count($output_data_2) > 0) {
                            // do both

                            foreach($output_data_1 as $od1) {
                                foreach($output_data_2 as $od2) {
                                    $result = $this->add_tier3($method_id, $od1, $od2, $method_case_id);

                                }
                            }
                        } else {

                            // just one
                            foreach($output_data_1 as $od1) {
                                $result = $this->add_tier3($method_id, $od1, null, $method_case_id);

                            }
                        }
                    } else if($user_interaction == USER_INTERACTION_SELECT_RANGE ||
                            $user_interaction == USER_INTERACTION_INPUT_BOX ||
                            $user_interaction == USER_INTERACTION_NUMERIC_ENTRY ||
                            $user_interaction == USER_INTERACTION_SELECT_EACH) {

                        $i=0;
                        foreach($output_data_1 as $value) {
                            
                            $name = urldecode($od1Names[$i]);
                            if(is_array($value)) {
                                if($user_interaction == USER_INTERACTION_SELECT_RANGE) {
                                    foreach($value as $arr_val) {
                                        $result = $this->add_tier3($method_id, $name, null, $method_case_id, $arr_val, $user_interaction);
                                    }
                                } else if($user_interaction == USER_INTERACTION_SELECT_EACH) {
                                    // array values are output_data_2 values
                                    foreach($value as $arr_val) {
                                        $result = $this->add_tier3($method_id, $name, $arr_val, $method_case_id, null, $user_interaction);
                                    }
                                    
                                   
                                } else {

                                $result = $this->add_tier3($method_id, $name, null, $method_case_id, $value, $user_interaction);
                            }
                            } else {

                                $result = $this->add_tier3($method_id, $name, null, $method_case_id, $value, $user_interaction);
                            }
                                $i++;
                            }
                    } else if($user_interaction == USER_INTERACTION_3_COL_W_REF) {

                        foreach($output_data_1 as $od1=>$data) {
                                
                                foreach($data as $od2=>$result) {
                                    $result = $result[0];
                                    if($result != null && $result != "") {
                                        $curr_references = $references[$od1][$od2];

                                        $od1 = urldecode($od1);
                                        $od2 = urldecode($od2);
                                        //echo("SELECTED: ($od1, $od2) = $result<BR>");
                                        $reflist = "";
                                        foreach($curr_references as $id=>$ref) {
                                            if($id != "0") {
                                            if($reflist == "") {
                                                $reflist .= $id;
                                            } else {
                                                $reflist .= ", $id ";
                                            }
                                            }
                                        }

                                        $insert_result = $this->add_tier3($method_id, $od1, $od2, $method_case_id, $result, $user_interaction, $reflist);
                                    }

                                }
                            }
                    }   

                }
    }
    }
    
    /** Adds just one record to the tier3data table
     * 
     * @param int $methodid Method ID
     * @param string $od1 output_data_1 value
     * @param string $od2 output_data_2 value (can be null)
     * @param id $tier2id ID of the tier2 data to use
     * @param string $value String value for user input,
     * or output_data_3 for 3_col_with_ref type (optional depending on type)
     * @param string $interaction user_interaction type (optional)
     * @return array an array in the form
     *  ("RESULT"=>$result,
     *      "MESSAGE"=>$message)
     * where "RESULT" is true if successful, else false, and "MESSAGE" is an
     * output message
     */
    public function add_tier3($methodid, $od1, $od2, $tier2id, $value=NULL, $interaction=NULL, $references = null) {
        if($interaction == null ||
                $interaction == USER_INTERACTION_MULTISELECT ||
                $interaction == USER_INTERACTION_SELECT_EACH  ||
                $interaction == USER_INTERACTION_INPUT_BOX_WITH_DROPDOWN) {
            // try od1 and od2
            if($od2 != null) {
            $info_query = "SELECT * from method_info where methodid = :methodid AND ".
                    " output_data_1 = :od1 and output_data_2 = :od2";
            
            $info_params = array("methodid"=>$methodid,
                    "od1"=>$od1,
                    "od2"=>$od2);
            
            } else {
                $info_query = "SELECT * from method_info where methodid = :methodid AND ".
                        " output_data_1 = :od1";
                $info_params = array("methodid"=>$methodid,
                        "od1"=>$od1);    
            }
        } else if($interaction == USER_INTERACTION_SELECT_RANGE ||
                $interaction == USER_INTERACTION_INPUT_BOX ||
                $interaction == USER_INTERACTION_NUMERIC_ENTRY) {
            // try without od2 for now
            $info_query = "SELECT * from method_info where methodid = :methodid AND ".
                " output_data_1 = :od1";
            $info_params = array("methodid"=>$methodid,
                    "od1"=>$od1);
        } else if($interaction == USER_INTERACTION_3_COL_W_REF) {
            $info_query = "SELECT * from method_info where methodid = :methodid AND ".
                    "output_data_1 = :od1 and " .
                    "output_data_2 = :od2 and " .
                    "output_data_3 = :od3";
            $info_params = array("methodid"=>$methodid,
                            "od1"=>$od1,
                            "od2"=>$od2,
                            "od3"=>$value);
        }

        $result = $this->db->get_query_result($info_query, $info_params);
        if(count($result) == 0) {

            return array("RESULT"=>FALSE,  
                        "MESSAGE"=>"Could not find specified method data.");
            
        } else {

            $methodinfoid = $result[0]['id'];
            $methoddata = new method_info($this->db, $methodinfoid);
            $interaction = $methoddata->get_user_interaction();
            
                if($interaction == USER_INTERACTION_MULTISELECT ||
                        $interaction == USER_INTERACTION_3_COL_W_REF) {

                $q = "INSERT INTO tier3data(tier2id, methodinfoid) VALUES ".
                        "(:t2id, :methodinfoid)";
                $params = array("t2id"=>$tier2id,
                                "methodinfoid"=>$methodinfoid);
                
                // add references
                if($references != null) {
                    // temp
                    //$references = null;
                    $q = "INSERT INTO tier3data(tier2id, methodinfoid, reference) VALUES ".
                        "(:t2id, :methodinfoid, :reference)";
                    $params = array("t2id"=>$tier2id,
                                "methodinfoid"=>$methodinfoid,
                                "reference"=>$references);
                    
                }
                $info_result = $this->db->get_insert_result($q, $params);
                
                if($info_result > 0) {
                    return array("RESULT"=>TRUE,
                                "MESSAGE"=>"Method data added successfully.",
                                "id"=>$info_result);
                }
            } else if($interaction == USER_INTERACTION_INPUT_BOX ||
                    $interaction == USER_INTERACTION_NUMERIC_ENTRY ||
                        $interaction == USER_INTERACTION_SELECT_RANGE ||
                        $interaction == USER_INTERACTION_SELECT_EACH ||
                        $interaction == USER_INTERACTION_INPUT_BOX_WITH_DROPDOWN) {

                $q = "INSERT INTO tier3data(tier2id, methodinfoid, value) VALUES ".
                        "(:t2id, :methodinfoid, :value)";
                $params = array("t2id"=>$tier2id,
                                "methodinfoid"=>$methodinfoid,
                                "value"=>$value);

                $info_result = $this->db->get_insert_result($q, $params);
                if($info_result > 0) {
                    return array("RESULT"=>TRUE,
                                "MESSAGE"=>"Method data added successfully.",
                                "id"=>$info_result);
                }
            } 
        }
            
    }
    
    /** Adds a record to the tier3data table given a methodinfoid id instead
     * of output_data values
     * 
     * @param int $tier2id Tier2 ID
     * @param int $methodinfoid ID of the method_info
     * @param string $value Value to add (optional, only for certain user_interaction types)
     * @return array an array in the form
     *  ("RESULT"=>$result,
     *      "MESSAGE"=>$message)
     * where "RESULT" is true if successful, else false, and "MESSAGE" is an
     * output message
     */
    public function add_tier3_by_id($tier2id, $methodinfoid, $value=null) {
        if($value == null) {
            $q = "INSERT INTO tier3data(tier2id, methodinfoid) VALUES ".
                        "(:t2id, :methodinfoid)";
                $params = array("t2id"=>$tier2id,
                                "methodinfoid"=>$methodinfoid);
                $info_result = $this->db->get_insert_result($q, $params);
                if($info_result > 0) {
                    return array("RESULT"=>TRUE,
                                "MESSAGE"=>"Method data added successfully.",
                                "id"=>$info_result);
                }
        } else {
            $q = "INSERT INTO tier3data(tier2id, methodinfoid, value) VALUES ".
                        "(:t2id, :methodinfoid, :value)";
                $params = array("t2id"=>$tier2id,
                                "methodinfoid"=>$methodinfoid,
                                "value"=>$value);

                $info_result = $this->db->get_insert_result($q, $params);
                if($info_result > 0) {
                    return array("RESULT"=>TRUE,
                                "MESSAGE"=>"Method data added successfully.",
                                "id"=>$info_result);
                }
        }
    }
    
    
    /** Deletes Tier 3 data for a givet Tier 2 id and method_info id
     * 
     * @param int $t2id Tier 2 ID
     * @param int $methodinfoid method_info id
     * @return array an array in the form
     *  ("RESULT"=>$result,
     *      "MESSAGE"=>$message)
     * where "RESULT" is true if successful, else false, and "MESSAGE" is an
     * output message
     */
    public function delete_tier3($t2id, $methodinfoid) {

        // TODO: Delete all data. Right now, only deletes one, but there may be several
        $query = "DELETE FROM tier3data where tier2id=:tier2id and methodinfoid=:methodinfoid";
        $params = array("tier2id"=>$t2id,
                        "methodinfoid"=>$methodinfoid);
        $result = $this->db->get_update_result($query, $params);

        if($result > 0) {
            return array("RESULT"=>TRUE,
                                "MESSAGE"=>"Method data deleted successfully.");
        } else {
            return array("RESULT"=>FALSE,
                                "MESSAGE"=>"Method data not deleted successfully.");
        }
        
    }
    
        /** Deletes Tier 3 data for a given its id
     * 
     * @param int $t3id the Tier 3 database id
     * @return array an array in the form
     *  ("RESULT"=>$result,
     *      "MESSAGE"=>$message)
     * where "RESULT" is true if successful, else false, and "MESSAGE" is an
     * output message
     */
    public function delete_tier3_by_id($t3id) {

        // TODO: Delete all data. Right now, only deletes one, but there may be several
        $query = "DELETE FROM tier3data where id=:t3id";
        $params = array("t3id"=>$t3id);
        $result = $this->db->get_update_result($query, $params);

        if($result > 0) {
            return array("RESULT"=>TRUE,
                                "MESSAGE"=>"Method data deleted successfully.");
        } else {
            return array("RESULT"=>FALSE,
                                "MESSAGE"=>"Method data not deleted successfully.");
        }
        
    }
    
    /** Gets all the Tier 3 data for a Tier 2 id
     * 
     * @param int  $t2id ID of the Tier 2 data
     * @return array Array of Tier 3 data
     */
    public function get_tier3data($t2id) {
        $query1 = "SELECT * from tier3data where tier2id = :t2id";
        $params = array("t2id"=>$t2id);
        
        $result = $this->db->get_query_result($query1, $params);
        
        return $result;

    }
    
    
    /** Updates a tier3 data with a new value, or inserts it if it doesn't exist
     * 
     * @param type $t2id
     * @param type $methodinfoid
     * @param type $new_value
     * @return array an array in the form
     *  ("RESULT"=>$result,
     *      "MESSAGE"=>$message)
     * where "RESULT" is true if successful, else false, and "MESSAGE" is an
     * output message
     */
    public function update_tier3($t2id, $methodinfoid, $new_value, $reflist = null){
        $check_query = "SELECT * from tier3data where tier2id = :t2id and methodinfoid = :methodinfoid ";
        $params = array("t2id"=>$t2id,
                        "methodinfoid"=>$methodinfoid);
        $check_result = $this->db->get_query_result($check_query, $params);
        
        if(count($check_result)>0) {
            // it already exists, update
            $update_query = "UPDATE tier3data set value=:new_value where tier2id=:t2id and methodinfoid=:methodinfoid";
            $params = array("t2id"=>$t2id,
                        "methodinfoid"=>$methodinfoid,
                        "new_value"=>$new_value);

            if($reflist != null) {
                $update_query = "UPDATE tier3data set value=:new_value, reference = :reflist where tier2id=:t2id and methodinfoid=:methodinfoid";
                $params = array("t2id"=>$t2id,
                        "methodinfoid"=>$methodinfoid,
                        "reflist"=>$reflist,
                        "new_value"=>$new_value);

            }
            $result = $this->db->get_update_result($update_query, $params);
            if(count($result) > 0) {
                return array("RESULT"=>TRUE,
                            "MESSAGE"=>"Tier 3 data updated successfully.");
            } else {
                return array("RESULT"=>FALSE,
                            "MESSAGE"=>"Tier 3 data not updated successfully.");
            }
        } else {
            // insert
            $result = $this->add_tier3_by_id($t2id, $methodinfoid, $new_value);
            return $result;
        }
    }
    
    
   /** Remove a method from a case
    *  (Note: This will completely delete the tier2 and tier3 data from
    *  the database. There will be no getting it back.
    * @param int $t2id ID of the tier2 method to delete from this case
    */
    public function remove_method($t2id) {
        $query1 = "DELETE FROM tier2data where id = :t2id";
        $params = array("t2id"=>$t2id);
        
        $result = $this->db->get_update_result($query1, $params);
        
        $query2 = "DELETE from tier3data where tier2id = :t2id";
        $result2 = $this->db->get_update_result($query2, $params);
    }
    
    /** Permanently deletes a case from the database
     * 
     * @return array an array in the form
     *  ("RESULT"=>$result,
     *      "MESSAGE"=>$message)
     * where "RESULT" is true if successful, else false, and "MESSAGE" is an
     * output message
     */
    public function delete_case() {
        $memberid = $this->memberid;
        $deleteid = $this->id;
        $q="UPDATE cases SET submissionstatus=-1 WHERE memberid=:memberid AND id=:deleteid";
        $params = array("memberid"=>$memberid,
                        "deleteid"=>$deleteid);
        $result = $this->db->get_update_result($q, $params);
        if(count($result) > 0) {
            return array("RESULT"=>TRUE,
                        "MESSAGE"=>"Case deleted successfully.");
        } else {
            return array("RESULT"=>FALSE,
                        "MESSAGE"=>"There was an error deleting the case. Please check your information and try again.");
        }
    }


    // Static functions
    
    /** Gets the cases for a member
     * 
     * @param db $db The database object
     * @param id $memberid ID of the member to get cases for
     * @param int $start Starting index to get cases from (optional)
     * @param int $pagerows Number of cases to retrieve (optional)
     * @return \sofa_case An array of sofa_case objects for the given member
     */
    public static function get_member_cases($db, $memberid, $start=-1, $pagerows=-1) {

        $q = "SELECT id, casename, casenumber, caseyear, caseagency,submissionstatus,  
        DATE_FORMAT(datemodified, '%M %d, %Y') AS moddat, 
        DATE_FORMAT(datesubmitted, '%M %d, %Y') AS subdat 
        FROM cases WHERE memberid=:memberid 
        AND submissionstatus>=0 
        ORDER BY datemodified DESC ";


        $params = array("memberid"=>$memberid);
        if($start >= 0) {
                $q .= "LIMIT $start, $pagerows";

        }

        $result = $db->get_query_result($q, $params);

        $cases = array();
        foreach($result as $case) {
                $newcase = new sofa_case($db, $case['id']);
                $cases[] = $newcase;
        }

        return $cases;
    }

    
    /** Determines if a case exists, given the case name 
     * 
     * 
     * @param db $db The database object
     * @param int $caseid Case ID to check against. Used when re-naming an existing case
     * @param int $memberid ID of the member whose case this is
     * @param string $caseyear Case year to search for
     * @param string $casenum
     * @return boolean
     */
    public static function case_exists($db, $caseid, $memberid, $caseyear, $casenum) {
        $q = "SELECT id FROM cases WHERE memberid=:memberid AND caseyear=:caseyear AND casenumber=:casenum AND id!=:caseeditid";
                    $params = array("memberid"=>$memberid,
                                    "caseyear"=>$caseyear,
                                    "casenum"=>$casenum,
                                    "caseeditid"=>$caseid);

                    $result = $db->get_query_result($q, $params);
                    if(count($result) > 0) {
                        return true;
                    } else {
                        return false;
                    }
    }


    
    // Private methods
    
    private function load_case($id) {
        
        $query = "SELECT * from cases where id = :id";

        $mresult = $this->db->get_query_result($query, array("id"=>$id));
        if(!$mresult) {
            echo 'Could not load data from database';
            return;
        }

        $casedata = $mresult[0];
        
        $this->id = $id;
        
        $this->casename = $casedata['casename'];
        $this->casenumber = $casedata['casenumber'];
        $this->caseyear = $casedata['caseyear'];
        $this->memberid = $casedata['memberid'];
        $this->caseagency = $casedata['caseagency'];
        $this->fasex = $casedata['fasex'];
        $this->faage = $casedata['faage'];
        $this->faage2 = $casedata['faage2'];
        $this->faageunits = $casedata['faageunits'];
        $this->faageunits2 = $casedata['faageunits2'];
        $this->faancestryas = $casedata['faancestryas'];
        $this->faancestryeuro = $casedata['faancestryeuro'];
        $this->faancestryaf = $casedata['faancestryaf'];
        $this->faancestryhi = $casedata['faancestryhi'];
        $this->faancestryna = $casedata['faancestryna'];
        $this->faancestryot = $casedata['faancestryot'];
        $this->faancestryottext = $casedata['faancestryottext'];
        $this->fastature = $casedata['fastature'];
        $this->fastature2 = $casedata['fastature2'];
        $this->fastatureunits = $casedata['fastatureunits'];
        $this->idsex = $casedata['idsex'];
        $this->idage = $casedata['idage'];
        $this->idageunits = $casedata['idageunits'];
        $this->idraceas = $casedata['idraceas'];
        $this->idraceaf = $casedata['idraceaf'];
        $this->idracewh = $casedata['idracewh'];
        $this->idracena = $casedata['idracena'];
        $this->idracehi = $casedata['idracehi'];
        $this->idraceot = $casedata['idraceot'];
        $this->idraceottext = $casedata['idraceottext'];
        $this->idancaddtext = $casedata['idancaddtext'];
        $this->idstature = $casedata['idstature'];
        $this->idstatureunits = $casedata['idstatureunits'];
        $this->idsource = $casedata['idsource'];
        $this->nummethods = $casedata['nummethods'];
        $this->casenotes = $casedata['casenotes'];
        $this->datestarted = $casedata['datestarted'];
        $this->datemodified = $casedata['datemodified'];
        $this->submissionstatus = $casedata['submissionstatus'];
        $this->datesubmitted = $casedata['datesubmitted'];
        }
    
}