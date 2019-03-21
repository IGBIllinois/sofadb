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
     * @param array $output_data_2, optional
     * @param array $od1Names Array of output_data_1 names, used for INPUT_BOX type
     */
    public function add_all_tier3_data($method_id, $method_case_id, $output_data_1, $output_data_2=null, $od1Names=null) {
                    
            $method = new method($this->db, $method_id);
            
            
                $method_data = method_info::get_data_for_method($this->db, $method_id);
                
                if(count($method_data) > 0) {

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
                            $user_interaction == USER_INTERACTION_INPUT_BOX) {

                        $i=0;
                        foreach($output_data_1 as $value) {
                            $name = $od1Names[$i];
                                $result = $this->add_tier3($method_id, $name, null, $method_case_id, $value, $user_interaction);
                                $i++;
                            }
                    }   

                }
    }
    
    /** Adds just one record to the tier3data table
     * 
     * @param type $methodid
     * @param type $od1
     * @param type $od2
     * @param type $tier2id
     * @param type $value
     * @param type $interaction
     * @return type
     */
    public function add_tier3($methodid, $od1, $od2, $tier2id, $value=NULL, $interaction=NULL) {
        if($interaction == null) {
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
                $interaction == USER_INTERACTION_INPUT_BOX) {
            // try without od2 for now
            $info_query = "SELECT * from method_info where methodid = :methodid AND ".
                " output_data_1 = :od1";
            $info_params = array("methodid"=>$methodid,
                    "od1"=>$od1);
        }

        $result = $this->db->get_query_result($info_query, $info_params);
        if(count($result) == 0) {

            return array("RESULT"=>FALSE,  
                        "MESSAGE"=>"Could not find specified method data.");
            
        } else {

            $methoddataid = $result[0]['id'];
            $methoddata = new method_info($this->db, $methoddataid);
            $interaction = $methoddata->get_user_interaction();
            
                if($interaction == USER_INTERACTION_MULTISELECT) {

                $q = "INSERT INTO tier3data(tier2id, methoddataid) VALUES ".
                        "(:t2id, :methoddataid)";
                $params = array("t2id"=>$tier2id,
                                "methoddataid"=>$methoddataid);
                $info_result = $this->db->get_insert_result($q, $params);
                if($info_result > 0) {
                    return array("RESULT"=>TRUE,
                                "MESSAGE"=>"Method data added successfully.",
                                "id"=>$info_result);
                }
            } else if($interaction == USER_INTERACTION_INPUT_BOX ||
                        $interaction == USER_INTERACTION_SELECT_RANGE) {

                $q = "INSERT INTO tier3data(tier2id, methoddataid, value) VALUES ".
                        "(:t2id, :methoddataid, :value)";
                $params = array("t2id"=>$tier2id,
                                "methoddataid"=>$methoddataid,
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
    
    /** Adds a record to the tier3data table given a methoddataid id instead
     * of output_data values
     * 
     * @param type $tier2id
     * @param type $methoddataid
     * @param type $value
     * @return type
     */
    public function add_tier3_by_id($tier2id, $methoddataid, $value=null) {
        if($value == null) {
            $q = "INSERT INTO tier3data(tier2id, methoddataid) VALUES ".
                        "(:t2id, :methoddataid)";
                $params = array("t2id"=>$tier2id,
                                "methoddataid"=>$methoddataid);
                $info_result = $this->db->get_insert_result($q, $params);
                if($info_result > 0) {
                    return array("RESULT"=>TRUE,
                                "MESSAGE"=>"Method data added successfully.",
                                "id"=>$info_result);
                }
        } else {
            $q = "INSERT INTO tier3data(tier2id, methoddataid, value) VALUES ".
                        "(:t2id, :methoddataid, :value)";
                $params = array("t2id"=>$tier2id,
                                "methoddataid"=>$methoddataid,
                                "value"=>$value);

                $info_result = $this->db->get_insert_result($q, $params);
                if($info_result > 0) {
                    return array("RESULT"=>TRUE,
                                "MESSAGE"=>"Method data added successfully.",
                                "id"=>$info_result);
                }
        }
    }
    
    
    public function delete_tier3($t2id, $methoddataid) {
        $query = "DELETE FROM tier3data where tier2id=:tier2id and methoddataid=:methoddataid";
        $params = array("tier2id"=>$t2id,
                        "methoddataid"=>$methoddataid);
        $result = $this->db->get_update_result($query, $params);
        if(count($result) > 0) {
            return array("RESULT"=>TRUE,
                                "MESSAGE"=>"Method data deleted successfully.");
        } else {
            return array("RESULT"=>FALSE,
                                "MESSAGE"=>"Method data not deleted successfully.");
        }
        
    }
    
    public function get_tier3data($t2id) {
        $query1 = "SELECT * from tier3data where tier2id = :t2id";
        $params = array("t2id"=>$t2id);
        
        $result = $this->db->get_query_result($query1, $params);
        
        return $result;

    }
    
    /** Updates a tier3 data with a new value, or inserts it if it doesn't exist
     * 
     * @param type $t2id
     * @param type $methoddataid
     * @param type $new_value
     * @return type
     */
    public function update_tier3($t2id, $methoddataid, $new_value){
        $check_query = "SELECT * from tier3data where tier2id = :t2id and methoddataid = :methoddataid ";
        $params = array("t2id"=>$t2id,
                        "methoddataid"=>$methoddataid);
        $check_result = $this->db->get_query_result($check_query, $params);
        
        if(count($check_result)>0) {
            // it already exists, update
            $update_query = "UPDATE tier3data set value=:new_value where tier2id=:t2id and methoddataid=:methoddataid";
            $params = array("t2id"=>$t2id,
                        "methoddataid"=>$methoddataid,
                        "new_value"=>$new_value);
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
            $this->add_tier3_by_id($t2id, $methoddataid, $new_value);
        }
    }
    
    
   
    public function remove_method($t2id) {
        $query1 = "DELETE FROM tier2data where id = :t2id";
        $params = array("t2id"=>$t2id);
        
        $result = $this->db->get_update_result($query1, $params);
        
        $query2 = "DELETE from tier3data where tier2id = :t2id";
        $result2 = $this->db->get_update_result($query2, $params);
    }


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