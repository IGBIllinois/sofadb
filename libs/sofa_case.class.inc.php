<?php

/* 
 * The sofa_case class is used to store and manipulate data for the FADAMA user
 * cases. They contain data such as case name, number, and year, and also
 * which methods were used and the method results.
 */

class sofa_case {
    
    /** Database object */
    private $db;
    
    /** ID of the case */
    private $id;
    
    /** Name of the case */
    private $casename;
    
    /** Case number */
    private $casenumber;
    
    /** Year of the case */
    private $caseyear;
    
    /** ID of the member who created the case */
    private $memberid;
    
    /** Case agency */
    private $caseagency;
    
    /** Case region */
    private $caseregion;
   
    /** Region ID */
    private $region_id;

    /** Forensic Anthropology estimated sex */
    private $fasex;
    
    /** Forensic Anthropology estimated start age */
    private $faage;
    
    /** Forensic Anthropology estimated end age */
    private $faage2;
    
    /** Forensic Anthropology estimated start age units */
    private $faageunits;
    
    /** Forensic Anthropology estimated end age units */
    private $faageunits2;
    
    /** Forensic Anthropology estimated age notes */
    private $faage_notes;
    
    /** Forensic Anthropology estimated start stature */
    private $fastature;
    
    /** Forensic Anthropology estimated end stature */
    private $fastature2;
    
    /** Forensic Anthropology estimated stature units */
    private $fastatureunits;
    
    /** Identified sex */
    private $idsex;
    
    /** Identified sex notes */
    private $idsex_notes;
    
    /** Identified age */
    private $idage;
    
    /** Identified age units */
    private $idageunits;
    
    /** Identified age notes */
    private $idage_notes;
    
    /** Identified stature */
    private $idstature;
    
    /** Identified stature units */
    private $idstatureunits;
    
    /** Identified stature notes */
    private $idstature_notes;
    
    /** Source of identification */
    private $idsource;
    
    /** Additional case notes */
    private $casenotes;
    
    /** Date case was started */
    private $datestarted;
    
    /** Date case was last modified */
    private $datemodified;
    
    /** Date case was submitted */
    private $datesubmitted;
    
    /** Current submission status */
    private $submissionstatus;
    
    /** Forensic Anthropology estimated ancestry: Other text */
    private $faancestryottext;
    
    /** Identified ancestry: Asian */
    private $idraceas;
    
    /** Identified ancestry: African */
    private $idraceaf;
    
    /** Identified ancestry: White */
    private $idracewh;
    
    /** Identified ancestry: Hispanic */
    private $idracehi;
    
    /** Identified ancestry: Native American */
    private $idracena;
    
    /** Identified ancestry: Other */
    private $idraceot;
    
    /** Identified ancestry: Other text */
    private $idraceottext;
    
    /** Identified ancestry: Additional text */
    private $idancaddtext;
    
    // prior known data
    /** No data was known prior to case creation */
    private $known_none;
    
    /** Sex was known prior to case creation */
    private $known_sex;
    
    /** Age was known prior to case creation */
    private $known_age;
    
    /** Ancestry was known prior to case creation */
    private $known_ancestry;
    
    /** Stature was known prior to case creation */
    private $known_stature;
    
    /** Some data was known prior to case creation, but it is impossible to determine which */
    private $known_unable_to_determine;
    
    /** Option to give consent to share data with the FDB (Consent, already submitted, Do Not Consent) */
    private $fdb_consent;
    
    /** If this was a cold case, this is the original year of the case */
    private $orig_case_year;
    
    // getters
    public function get_id() { return $this->id; }
    public function get_casename() { return $this->casename; }
    public function get_casenumber() { return $this->casenumber; }
    public function get_caseyear() { return $this->caseyear; }
    public function get_memberid() { return $this->memberid; }
    public function get_caseagency() { return $this->caseagency; }
    public function get_caseregion() { return $this->caseregion; }
    public function get_region_id() { return $this->region_id; }
    public function get_fasex() { return $this->fasex; }
    public function get_faage() { return $this->faage; }
    public function get_faage2() { return $this->faage2; }
    public function get_faage_notes() { return $this->faage_notes; }
    public function get_faageunits() { return $this->faageunits; }
    public function get_faageunits2() { return $this->faageunits2; }
    public function get_fastature() { return $this->fastature; }
    public function get_fastature2() { return $this->fastature2; }
    public function get_fastatureunits() { return $this->fastatureunits; }
    public function get_idsex() { return $this->idsex; }
    public function get_idsex_notes() { return $this->idsex_notes; }
    public function get_idage() { return $this->idage; }
    public function get_idageunits() { return $this->idageunits; }
    public function get_idage_notes() { return $this->idage_notes; }
    public function get_idstature() { return $this->idstature; }
    public function get_idstatureunits() { return $this->idstatureunits; }
    public function get_idstature_notes() { return $this->idstature_notes; }
    public function get_idsource() { return $this->idsource; }
    public function get_casenotes() { return $this->casenotes; }
    public function get_datestarted() { return $this->datestarted; }
    public function get_datemodified() { return $this->datemodified; }
    public function get_datesubmitted() { return $this->datesubmitted; }
    public function get_submissionstatus() { return $this->submissionstatus; }
    public function get_faancestryottext()  { return $this->faancestryottext; }
    public function get_idraceas()  { return $this->idraceas; }
    public function get_idraceaf()  { return $this->idraceaf; }
    public function get_idracewh()  { return $this->idracewh; }
    public function get_idracehi()  { return $this->idracehi; }
    public function get_idracena()  { return $this->idracena; }
    public function get_idraceot()  { return $this->idraceot; }
    public function get_idraceottext()  { return $this->idraceottext; }
    public function get_idancaddtext() { return $this->idancaddtext; }
    public function get_known_none() { return $this->known_none; }
    public function get_known_sex() { return $this->known_sex; }
    public function get_known_age() { return $this->known_age; }
    public function get_known_ancestry() { return $this->known_ancestry; }
    public function get_known_stature() { return $this->known_stature; }
    public function get_known_unable_to_determine() { return $this->known_unable_to_determine; }
    public function get_fdb_consent() { return $this->fdb_consent; }
    public function get_orig_case_year() { return $this->orig_case_year; }
    
    public function __construct($db, $id = 0) {

        $this->db = $db;

        if($id != 0) {
            $this->load_case($id);
        }
        
    }
    
    /**
     * Adds a new case to the database
     * 
     * @param type $db Connection to database
     * @param type $data array of values. Using an array here since thera are so many
     */
    public static function add_case($db, $data) {

                        
        $q = "INSERT INTO cases ("
                . "casename, "
                . "casenumber,"
                . "caseyear,"
                . "origcaseyear,"
                . "memberid,"
                . "caseagency,"
                . "region_id," 
                . "fasex,"
                . "faage,"
                . "faage2,"
                . "faageunits,"
                . "faageunits2,"
                . "faage_notes,"
                . "fastature,"
                . "fastature2,"
                . "fastatureunits,"
                . "idsex,"
                . "idsex_notes,"
                . "idage,"               
                . "idageunits,"
                . "idage_notes,"
                . "idstature,"
                . "idstatureunits,"
                . "idstature_notes,"
                . "idsource,"
                . "casenotes,"
                . "datestarted,"
                . "datemodified,"
                . "submissionstatus,"
                . "faancestryottext,"
                . "idraceas,"
                . "idraceaf,"
                . "idracewh,"
                . "idracehi,"
                . "idracena,"
                . "idraceot,"
                . "idraceottext,"
                . "idancaddtext,"
                . "known_none,"
                . "known_sex,"
                . "known_age,"
                . "known_ancestry,"
                . "known_stature,"
                . "known_unable_to_determine,"
                . "fdb_consent"
                .") "
                . "VALUES ("
                    . ":casename,"
                    . ":casenum,"
                    . ":caseyear,"
                    . ":origcaseyear,"
                    . ":memberid,"
                    . ":caseag,"
                    . ":region_id,"
                    . ":fasex,"
                    . ":faage,"
                    . ":faage2,"
                    . ":faageunits,"
                    . ":faageunits2,"
                    . ":faage_notes,"
                    . ":fastature,"
                    . ":fastature2,"
                    . ":fastatureunits,"
                    . ":idsex,"
                    . ":idsex_notes,"
                    . ":idage,"
                    . ":idageunits,"
                    . ":idage_notes,"
                    . ":idstature,"
                    . ":idstatureunits,"
                    . ":idstature_notes,"
                    . ":idsource,"
                    . ":casenotes,"
                    . "NOW(),"
                    . "NOW(),"
                    . "'0',"
                    . ":faancestryottext,"
                    . ":idraceas,"
                    . ":idraceaf,"
                    . ":idracewh,"
                    . ":idracehi,"
                    . ":idracena,"
                    . ":idraceot,"
                    . ":idraceottext,"
                    . ":idancaddtext,"
                    . ":known_none,"
                    . ":known_sex,"
                    . ":known_age,"
                    . ":known_ancestry,"
                    . ":known_stature,"
                    . ":known_unable_to_determine,"
                    . ":fdb_consent"
                
                . ")";	
        
        
                try {
                $caseid = $db->insert_query($q, $data);
                } catch(Exception $e) {
                    echo $e->getTraceAsString();
                }

                if($caseid == 0) {
                    print_r($data);
                    return array("RESULT"=>FALSE,
                            "MESSAGE"=>"<h2>System Error</h2>
				<p class='error'>Saving failed because of a system error. We apologize for any inconvenience.</p>
				<p> " . $db->errorInfo()[2] ."<br/><br/>Query: " . $q . "</p>"
                        );
                }
                

                return array("RESULT"=>TRUE,
                             "MESSAGE"=>"<h2>System Error</h2>
				<p class='error'>Case added successfully.</p>",
                             "id"=>$caseid
                              
                        );
    }
    
    
    /** Adds a method to a case
     * 
     * @param int $methodid ID of the method to add
     * @param string $methodtype Type of the method to add ("Age", "Sex", "Stature", "Ancestry")
     * @param string $estimated_outcome_1 The first estimated outcome for this method (optional)
     * @param string $estimated_outcome_2 The second estimated outcome for this method (optional)
     * @param string $estimated_outcome_units The units used for the estimated outcomes (optional)
     * @return type ID of the newly created case-method
     */
    public function add_case_method($methodid, $methodtype, $estimated_outcome_1 = null, $estimated_outcome_2=null, $estimated_outcome_units = null) {
        $q="INSERT INTO tier2data "
                . "("
                . "memberid,"
                . "caseid,"
                . "methodtype,"
                . "methodid,"
                . "estimated_outcome_1,"
                . "estimated_outcome_2,"
                . "estimated_outcome_units)"
                . "VALUES ("
                . ":memberid,"
                . ":caseid,"
                . ":methodtype,"
                . ":methodid,"
                . ":estimated_outcome_1,"
                . ":estimated_outcome_2,"
                . ":estimated_outcome_units)";
        
        
                $data = array("memberid"=>$this->memberid,
                        "caseid"=>$this->id,
                        "methodid"=>$methodid,
                        "methodtype"=>$methodtype,
                        "estimated_outcome_1"=>$estimated_outcome_1,
                        "estimated_outcome_2"=>$estimated_outcome_2,
                        "estimated_outcome_units"=>$estimated_outcome_units);

                $casemethodid = $this->db->insert_query($q, $data);
                
                 
                 if($casemethodid > 0) {
                            
                    return array("RESULT"=>TRUE,
                            "MESSAGE"=>"Method case added successfully.",
                            "id"=>$casemethodid);
                        
                 } else {
                     return array("RESULT"=>FALSE,
                                    "MESSAGE"=>"Could not add method. We apologize for any inconvenience.");
                 }
                 
      
    }
/** Marks a case for submission, or other status
 * 
 * @param int $submitstatus Submission status. "1" for submitted, "0" for unsubmitted
 * @return array Array of the form ("RESULT"=>$result, "MESSAGE"=>$message)
 *  where $result is true or false, and $message is an output message
 */
public function submit_case($submitstatus) {

    if($submitstatus == 1) {
        $datesubmitted = "NOW()";
    } else {
        $datesubmitted = "NULL";
    }
	$q="UPDATE cases SET submissionstatus=:status,datesubmitted=$datesubmitted WHERE id=:caseid";

	$params = array("status"=>$submitstatus, "caseid"=>$this->get_id());

	$result = $this->db->non_select_query($q, $params);

	if(!$result) {
	return array("RESULT"=>FALSE,
	"MESSAGE"=>'System Error: Could not update submit data.');
	}
        
        
        return array("RESULT"=>TRUE,
            "MESSAGE"=>"Case status changed successfully.");
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
                . "origcaseyear=:origcaseyear,"
                . "casenumber=:casenum,"
                . "caseagency=:caseag,"
                . "region_id=:region_id," 
                . "fasex=:fasex,"
                . "faage=:faage,"
                . "faage2=:faage2,"
                . "faageunits=:faageunits, "
                . "faageunits2=:faageunits2,"
                . "faage_notes=:faage_notes,"
                . "fastature=:fastature,"
                . "fastature2=:fastature2,"
                . "fastatureunits=:fastatureunits,"
                . "idsex=:idsex,"
                . "idsex_notes=:idsex_notes,"
                . "idage=:idage,"
                . "idageunits=:idageunits,"
                . "idage_notes=:idage_notes,"
                . "idsource=:idsource,"
                . "idstature=:idstature,"
                . "idstatureunits=:idstatureunits,"
                . "idstature_notes=:idstature_notes,"
                . "casenotes=:casenotes,"
                . "datemodified=NOW(),"
                . "faancestryottext=:faancestryottext,"
                . "idraceas=:idraceas,"
                . "idraceaf=:idraceaf,"
                . "idracewh=:idracewh,"
                . "idracehi=:idracehi,"
                . "idracena=:idracena,"
                . "idraceot=:idraceot,"
                . "idraceottext=:idraceottext,"
                . "idancaddtext=:idancaddtext,"
                . "known_none=:known_none,"
                . "known_sex=:known_sex,"
                . "known_age=:known_age,"
                . "known_ancestry=:known_ancestry,"
                . "known_stature=:known_stature,"
                . "known_unable_to_determine=:known_unable_to_determine,"
                . "fdb_consent=:fdb_consent"
                . " WHERE id=:caseeditid";

        $this->db->non_select_query($q, $data);
        return array("RESULT"=>TRUE,
                    "MESSAGE"=>"Case ".$this->get_casename() . " edited successfully.");
				
    }
    
    
    /** Gets all the methods for this case
     * 
     * @return \tier2data An array of tier2data objects that represent
     * the methods used in this case
     */
    public function get_case_methods() {
        $query = "SELECT * from tier2data where caseid = :id order by id DESC";
        $params = array("id"=>$this->id);
        $result = $this->db->query($query, $params);
        $tier2s = array();
        foreach($result as $id) {
            $tier2 = new tier2data($this->db, $id['id']);
            $tier2s[] = $tier2;
        }
        return $tier2s;
    }
 

 /** Adds tier3 data to the database
  * 
  * @param type $tier2id ID of the Tier2 object
  * @param type $method_info_option_id ID of the method_info_option object
  * @param type $value Value of the method_info_option (optional)
     * @return array an array in the form
     *  ("RESULT"=>$result,
     *      "MESSAGE"=>$message,
     *       "id"=>$id)
     * where "RESULT" is true if successful, else false, and "MESSAGE" is an
     * output message, and "id" is the id of the newly inserted tier3, if successful
  */
    public function add_tier3($tier2id, $method_info_option_id, $value=null) {
        $mi_option = new method_info_option($this->db, $method_info_option_id);
	$method_infos = new method_infos($this->db, $mi_option->get_method_infos_id());
        if($method_infos->get_type() == input_type::get_input_type_by_name($this->db, USER_INTERACTION_CATEGORY)->get_id()) {
            //Don't input a category
            return;
        } else {
            $fields = "(tier2id, method_info_option_id ";
            $values = "(:tier2id, :method_info_option_id ";
            $params = array("tier2id"=>$tier2id, "method_info_option_id"=>$method_info_option_id);

            if($value != null) {
                $fields .= ", value ";
                $values .= ", :value ";
                $params['value'] = $value;
            } else {
                // No value given
            }
            $fields .= ")";
            $values .= ")";

            $query = "INSERT INTO tier3data $fields VALUES $values";

            $result = $this->db->insert_query($query, $params);
            if($result > 0) {
                return array("RESULT"=>TRUE,
                            "MESSAGE"=>"Tier 3 data added successfully.",
                            "id"=>$result);
            } else {
                return array("RESULT"=>FALSE,
                            "MESSAGE"=>"Tier 3 data not added successfully.");
            }
        }
    }

    
    /** Deletes Tier 3 data for a given Tier 2 id and method_info id
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
        $result = $this->db->non_select_query($query, $params);

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
        $result = $this->db->non_select_query($query, $params);

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
        
        $result = $this->db->query($query1, $params);
        
        return $result;

    }
     
   /** Remove a method from a case
    *  (Note: This will completely delete the tier2 and tier3 data from
    *  the database. There will be no getting it back.
    * @param int $t2id ID of the tier2 method to delete from this case
    */
    public function remove_method($t2id) {
        $query1 = "DELETE FROM tier2data where id = :t2id";
        $params = array("t2id"=>$t2id);
        
        $result = $this->db->non_select_query($query1, $params);
        
        $query2 = "DELETE from tier3data where tier2id = :t2id";
	$result2 = $this->db->non_select_query($query2, $params);
	if ($result && $result2) {
		return true;
	}
	return false;
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

        $delete_case_query = "DELETE FROM cases where memberid=:memberid AND id=:deleteid";
        $delete_case_params = array("memberid"=>$memberid,
                        "deleteid"=>$deleteid);
        
        // delete tier2 data
        $tier2_data = $this->get_case_methods();
        foreach($tier2_data as $t2) {
            $this->remove_method($t2->get_id());
        }

        $result = $this->db->non_select_query($delete_case_query, $delete_case_params);
        if($result) {
            return array("RESULT"=>TRUE,
                        "MESSAGE"=>"Case deleted successfully.");
        } else {
            return array("RESULT"=>FALSE,
                        "MESSAGE"=>"There was an error deleting the case. Please check your information and try again.");
        }
    }
    
    /////////////// Static functions ///////////////
    
    /** Gets the cases for a member
     * 
     * @param db $db The database object
     * @param id $memberid ID of the member to get cases for
     * @param int $start Starting index to get cases from (optional)
     * @param int $pagerows Number of cases to retrieve (optional)
     * @return \sofa_case An array of sofa_case objects for the given member
     */
    public static function get_member_cases($db, $memberid, $start=-1, $pagerows=-1) {

        $sql = "SELECT id, casename, casenumber, caseyear, caseagency,submissionstatus, ";
	$sql .= "DATE_FORMAT(datemodified, '%M %d, %Y') AS moddat, ";
	$sql .= "DATE_FORMAT(datesubmitted, '%M %d, %Y') AS subdat ";
	$sql .= "FROM cases WHERE memberid=:memberid ";
	$sql .= "AND submissionstatus>=0 ";
	$sql .= "ORDER BY datemodified DESC, id ASC ";

        $params = array("memberid"=>$memberid);
        if($start >= 0) {
                $sql .= "LIMIT $start, $pagerows";

	}
        $result = $db->query($sql, $params);
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

        $result = $db->query($q, $params);
        if(count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    /** Determines if a case exists, without a case id. Used when adding new cases
     * 
     * 
     * @param db $db The database object
     * @param int $memberid ID of the member whose case this is
     * @param string $casename Case name to search for
     * @param string $casenumber Case number
     * @return boolean
     */
    public static function new_case_exists($db, $memberid, $casename, $casenumber) {
        $q = "SELECT id FROM cases WHERE memberid=:memberid AND casename=:casename AND casenumber=:casenum";
        $params = array("memberid"=>$memberid,
                        "casename"=>$casename,
                        "casenum"=>$casenumber);

        $result = $db->query($q, $params);
        if(count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Search for cases based on given criteria
     * @param type $db The database object
     * @param type $case_data array of name=>value pairs of database info to search for
     * $param boolean $unsubmitted Allow unsubmitted cases? Defaults to false
     * 
     * @return a list of case objects that fit the criteria
     */
    public static function search_cases($db, $case_data, $methods=null, $unsubmitted = 0) {
        $submission_status = " where submissionstatus = 1 ";
        if($unsubmitted == 1) {
            // get submitted and unsubmitted
            $submission_status = " where submissionstatus >= 0 ";
        }
        $query = "SELECT id from cases ".$submission_status."  ";
        $param_string = "";
        $conjunction = " AND ";
       	$params = array(); 
        // determine the conjuction to use ("AND" if matching every criteria, "OR" if any criteria can match)
        if(isset($case_data['conjunction']) && $case_data['conjunction'] == 2) {
            $conjunction = " OR ";
        }
        
        // Member ID
        if (isset($case_data['memberId']) && $case_data['memberId'] != null && $case_data['memberId'] != "") { 		
		$query .= " AND memberid =:memberId  ";
                $params["memberId"] = $case_data['memberId'];
		
	}
       
        // Case Year
        if (isset($case_data['caseYear']) && $case_data['caseYear'] != null && $case_data['caseYear'] != "") {
            $yearRange = $case_data['yearRange'];
            $yearJoiner = " = ";
                if($yearRange==1){
                    $yearJoiner = ">=";
                    
                } elseif($yearRange==2){
                    $yearJoiner = "<=";
                }
                if($param_string != "") {
                    $param_string .= $conjunction;
                }
                $param_string .= " caseyear " . $yearJoiner . " :caseyear ";
                $params["caseyear"] = $case_data['caseYear'];

	}
        
        // Case number
        if (isset($case_data['caseNumber']) && ($case_data['caseNumber'] != null && $case_data['caseNumber'] != "")) {
		if($param_string != "") {
                    $param_string .= $conjunction;
                }
                $param_string .= " casenumber LIKE CONCAT ('%', :casenumber, '%') ";
                $params["casenumber"] = $case_data['caseNumber'];
                
        }
        
        // Case agency
        if (isset($case_data['caseAgency']) && ($case_data['caseAgency'] != null && $case_data['caseAgency'] != "")) {
            if($param_string != "") {
                $param_string .= $conjunction;
            }
            $param_string .= " caseagency LIKE CONCAT ('%', :caseagency, '%') ";
            $params["caseagency"] = $case_data['caseAgency'];
        }
        
        // Region
        if (isset($case_data['region_id']) && ($case_data['region_id'] != null && $case_data['region_id'] != "")) {
            if($param_string != "") {
                $param_string .= $conjunction;
            }
            $param_string .= " cases.region_id = :region_id ";
            $params["region_id"] = $case_data['region_id'];
        }
        
        // Sex id
        if (isset($case_data['idsex']) && $case_data['idsex'] != null && $case_data['idsex'] != "") {
            if($param_string != "") {
                $param_string .= $conjunction;
            }
            $param_string .= " idsex = :idsex ";
            $params["idsex"] = $case_data['idsex'];
        }
                
        // Age range 
        if ((isset($case_data['idage1']) && $case_data['idage1'] != null && $case_data['idage1'] != "") &&
                (isset($case_data['idage2']) && $case_data['idage2'] != null && $case_data['idage2'] != "")) {
            
            if($case_data['idageunits'] == 'years') {
                $alt_ageunits = "months";
                $alt_idage1 = $case_data['idage1'] * 12;
                $alt_idage2 = $case_data['idage2'] * 12;
            } else {
                $alt_ageunits = "years";
                $alt_idage1 = $case_data['idage1'] / 12;
                $alt_idage2 = $case_data['idage2'] / 12;
            }
            if($param_string != "") {
                $param_string .= $conjunction;
            }

            if($case_data['idageunits'] == 'fmonths') {
                $params["idage1"] = $case_data['idage1'];
                $params["idage2"] = $case_data['idage2'];
                $params['idageunits'] = $case_data['idageunits'];
                $param_string .= ("( (idageunits = :idageunits AND (idage between :idage1 AND :idage2) ))");
            } else {    
                $param_string .= " ( (idageunits = :idageunits AND (idage between :idage1 AND :idage2) )".
                    " OR (idageunits = :alt_idageunits AND (idage between :alt_idage1 AND :alt_idage2)))";

            $params["idage1"] = $case_data['idage1'];
            $params["idage2"] = $case_data['idage2'];
            $params["idageunits"] = $case_data['idageunits'];
            $params["alt_idage1"] = $alt_idage1;
            $params["alt_idage2"] = $alt_idage2;
            $params['alt_idageunits'] = $alt_ageunits;
            }
        }
        
        // Stature
        if ((isset($case_data['idstature1']) && $case_data['idstature1'] != null && $case_data['idstature1'] != "") &&
                (isset($case_data['idstature2']) && $case_data['idstature2'] != null && $case_data['idstature2'] != "")) {

            if($case_data['idstatureunits'] == 'in') {
                $alt_idstatureunits = "cm";
                $alt_idstature1 = $case_data['idstature1'] * 2.54;
                $alt_idstature2 = $case_data['idstature2'] * 2.54;
            } else {
                $alt_idstatureunits = "in";
                $alt_idstature1 = $case_data['idstature1'] / 2.54;
                $alt_idstature2 = $case_data['idstature2'] / 2.54;
            }
                        
            if($param_string != "") {
                $param_string .= $conjunction;
            }
            $param_string .= " ( (idstatureunits = :idstatureunits AND (idstature between :idstature1 AND :idstature2) )".
                    " OR (idstatureunits = :alt_idstatureunits AND (idstature between :alt_idstature1 AND :alt_idstature2)))";
            $params["idstature1"] = $case_data['idstature1'];
            $params["idstature2"] = $case_data['idstature2'];
            $params["idstatureunits"] = $case_data['idstatureunits'];
            $params["alt_idstature1"] = $alt_idstature1;
            $params["alt_idstature2"] = $alt_idstature2;
            $params["alt_idstatureunits"] = $alt_idstatureunits;
        }
        
        // Submit date
        if(isset($case_data['datasubmitted']) && ($case_data['datesubmitted'] != null)) {
            if($param_string != "") {
                $param_string .= $conjunction;
            } else {
                    // No conjuction needed in query string yet
            }
            $param_string .= " (datesubmitted >= :datesubmitted) ";
            $params['datesubmitted'] = $case_data['datesubmitted'];
        }
                
        // FDB consent
        if(isset($case_data['fdb_consent']) && ($case_data['fdb_consent'] != null && $case_data['fdb_consent'] == true)) {
            if($param_string != "") {
                $param_string .= $conjunction;
            }
            
            $param_string .= " fdb_consent = 'consent'";
            
        }
        
        // Race
	// $case_data['race'] is an array of "idrace$value" as keys
        if (isset($case_data['race']) && $case_data['race'] != null) {
            $race_string = "";
            if($param_string != "") {
                $param_string .= $conjunction;
            }
            foreach ($case_data['race'] as $name=>$value) {
                $race_join = " AND ";
                if($case_data['race_join'] == 2) {
                    $race_join = " OR ";
                }
                if($race_string != "") {
                    $race_string .= $race_join;
                }
                $race_string .= "( idrace".$name."=1 )";
            }

            $param_string .= "(".$race_string.")";
        }
        
        $est_string = "";
        $est_join = " AND ";
        if(isset($case_data['prac_join']) && $case_data['prac_join'] == 2) {
            $est_join = " OR ";
	}

        // Estimated sex               
        if (isset($case_data['est_sex']) && $case_data['est_sex'] != null && $case_data['est_sex'] == 1 ) {
            if($est_string != "") {
                $est_string .= $est_join;
            }
            $est_string .= " fasex <> '' ";

        }
        
        // Estimated age
        if(isset($case_data['est_age']) && $case_data['est_age'] != null && $case_data['est_age'] == 1) {
            if($est_string != "") {
                $est_string .= $est_join;
            }
            
            $est_string .= " (faage <> '' OR faage2 <> '') ";
            
        }
        
        // Estimated stature
        if(isset($case_data['est_stat']) && $case_data['est_stat'] != null && $case_data['est_stat'] == 1) {
            if($est_string != "") {
                $est_string .= $est_join;
            }
            
            $est_string .= " (fastature <> '' OR fastature2 <> '') ";
            
        }
        
        // Estimated ancestry
        if(isset($case_data['est_anc']) && $case_data['est_anc'] != null && $case_data['est_anc'] == 1) {
            if($est_string != "") {
                $est_string .= $est_join;
            }
            
            $est_string .= " faancestryottext <> '' ";
            
        }
        
        if($est_string != '') {
            if($param_string != "") {
                $param_string .= $conjunction;
            }
            $param_string .= " (".$est_string.") "; 
        }
        
        if($methods !=  null && count($methods) > 0) {
            $method_conj = $case_data['method_conj'];
            if($method_conj == 'any') {
                $method_ids = implode(",", $methods);
                if($param_string != "") {
                    $param_string .= $conjunction;
                } else {
                    // No conjuction needed in query string yet
                }
                $param_string .= " id in (select tier2data.caseid from tier2data where tier2data.methodid in ($method_ids))";
            } else {
                // all
                $num_methods = count($methods);
                $tmp_str = "";
                foreach($methods as $method) {
                    if($tmp_str != "") {
                        $tmp_str .= " OR ";
                    }
                    $tmp_str .= "(methodid = $method)";
                }
                if($param_string != "") {
                    $param_string .= $conjunction;
                } else {
                    // No conjuction needed in query string yet
                }
                $param_string .= "( id in (SELECT caseid FROM `tier2data` where ($tmp_str) ".
                        " group by caseid having count( caseid)=$num_methods and caseid not in (select id from cases where id in (SELECT caseid FROM `tier2data` group by caseid having (count(methodid) > count(distinct methodid))))))";
            }
        }
        
        if($param_string != "") {
            $param_string  = " AND (".$param_string . ")";
            
        }
     
        $query .= $param_string;

        $query .= " ORDER BY id ";
        $result = $db->query($query, $params);
        $results = array();
        
        foreach($result as $casedata) {
            $case = new sofa_case($db, $casedata['id']);
	    $results[] = $case;
	    
        }
        return $results;

    }

	public static function get_latest_full_report() {
		$latest_ctime = 0;
		$latest_filename = '';
		$files = glob(settings::get_report_dir() . "/SOFADBExport_*.zip");
		foreach ($files as $file) {
			if (is_file($file) && filectime($file) > $latest_ctime) {
				$latest_ctime = filectime($file);
				$latest_filename = $file;
			
			}


		}
		return $latest_filename;
	}

    public static function write_full_report($db,$case_list,$username=null,$email=null,$fdb=0,$mine=0,$output_dir = null) {
		$today = date("m_d_Y_H_i_s");

		// Zip filename
		$zip_filename= "SOFADBExport_" . $today . ".zip";
		$sex_filename= "SOFADBExport_sex_" . $today . ".csv";
		$age_filename= "SOFADBExport_age_" . $today . ".csv";
		$anc_filename= "SOFADBExport_anc_" . $today . ".csv";
		$stat_filename= "SOFADBExport_stat_" . $today . ".csv";
		if($fdb) {
			// Zip filename
			$zip_filename = "SOFADB_FDB_Export_" . $today . ".zip";
			$sex_filename= "SOFADB_FDB_Export_sex_" . $today . ".csv";
			$age_filename= "SOFADB_FDB_Export_age_" . $today . ".csv";
			$anc_filename= "SOFADB_FDB_Export_anc_" . $today . ".csv";
			$stat_filename= "SOFADB_FDB_Export_stat_" . $today . ".csv";
		}
		$zip_filepath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $zip_filename;
		$zip = new ZipArchive();
		if ($zip->open($zip_filepath, ZIPARCHIVE::CREATE )!==TRUE) {
			exit("cannot open <$zip_filename>\n");
		} 


		$sex_method_data = self::write_report($db,$case_list,$username,$email,$fdb,$mine,METHOD_DATA_SEX_ID);
		$age_method_data = self::write_report($db,$case_list,$username,$email,$fdb,$mine,METHOD_DATA_AGE_ID);
		$anc_method_data = self::write_report($db,$case_list,$username,$email,$fdb,$mine,METHOD_DATA_ANCESTRY_ID);
		$stat_method_data = self::write_report($db,$case_list,$username,$email,$fdb,$mine,METHOD_DATA_STATURE_ID);

		try {
			$zip->addFile(__DIR__ . "/../html/docs/Report_Info.docx", "Report_Info.docx");
			$zip->AddFromString($sex_filename,$sex_method_data);
			$zip->AddFromString($age_filename,$age_method_data);
			$zip->AddFromString($anc_filename,$anc_method_data);
			$zip->AddFromString($stat_filename,$stat_method_data);
			$zip->close();

		}
		catch(Exception $e) {
                        echo("Error:".$e->getTraceAsString());
		}
		$output_filepath = $zip_filepath;
		if ($output_dir != null) {
			$output_filepath = $output_dir . "/" . $zip_filename;
			rename($zip_filepath,$output_filepath);
		}
		if(!$fdb) {
	    
			// Add record of download request to database
			$download_query = "INSERT INTO downloads (name, email, date) VALUES (:name, :email, NOW())";
			$download_params = array("name"=>$username,
                                    "email"=>$email);
			$db->insert_query($download_query, $download_params);
		} 

		return $output_filepath;
	
    }

    /** Creates a zip file containing an excel sheet with data from the given cases
     * and an additional information text document.
     * 
     * @param db $db The database object
     * @param \sofa_case $case_list List of case objects
     * @param string $name Name of the user making the request
     * @param string $email Email of the user making the request
     * @param bool $fdb True if this is an FDB report (only show methods from the FDB database)
     * @param bool $mine True if this is a report for the given user's cases (show case number and agency)
     * @param string A method type to create report
     */
    public static function write_report($db, $case_list, $username=null, $email=null, $fdb=0, $mine=0, $method_type = null) {
        
        $today = date("m_d_Y_H_i_s");
        
        // Excel filename
        $filename='SOFADBExport_'.$today.".csv";
        
        if($fdb) {
            // Excel filename
            $filename = 'SOFADB_FDB_Export_'.$today.".csv";
            
        }
        
       // make header rows for data
       if($fdb) {
            // Create an FDB report

            // Header row contains column name, and Method name
            $headerrow = array();
            array_push($headerrow, 'Case ID');
            if($mine) {
                array_push($headerrow, "Case Number");
            }
            array_push($headerrow,
                 'Date Submitted to FADAMA DB', 
                 'Case Year',
                 'Cold Case?',
                 'Cold Case Year',
                 'Case Number',
                 'Case Agency',
                 'FA Report: Sex', 
                 'FA Report: Minimum age', 
                 'FA Report: Maximum age', 
                 'FA Report: FA Age Notes',
                 'FA Report: Ancestry',
                 'FA Report: Minimum Stature',
                 'FA Report: Maximum Stature',
                 'Identified Sex',
                 'Identified Sex Notes',
                 'Identified Age',
                 'Identified Age Units (years or fetal months)',
                 'Identified Age Notes',
                 'Identified Race/Ethnicity',
                 'Race/Ethnicity Notes',
                 'Identified Stature',
                 'Identified Stature Notes',
                 'Information Source',
                 'Case Notes',
                 'Background Case Knowledge');
            
             // Second header row contains Method Info name, under the corresponding Method name
            $headerrow2 = array("");
            if($mine) {
                array_push($headerrow, "");
            }
            array_push($headerrow2,
                 '',
                 '',
                 '',
                 '',
                 '',
                 '',
                 '',
                 '',
                 '',
                 '',
                 '',
                 '',
                 '',
                 '',
                 '',
                 '',
                 '',
                 '',
                 '',
                 '',
                 '',
                 '',
                 '',
                 '',
                 ''
                 );  
             $pre_headerrow = $headerrow2;
        
       } else {
            $headerrow = array();
            array_push($headerrow, 'Case ID');
            if($mine) {
                array_push($headerrow, "Case Number");
            }
            array_push($headerrow,
                'Date Submitted to FADAMA DB', 
                'Case Year',
                'Cold Case?',
                'Cold Case Year',
                'FA Report: Sex', 
                'FA Report: Minimum age', 
                'FA Report: Maximum age', 
                'FA Report: FA Age Notes',
                'FA Report: Ancestry',
                'FA Report: Minimum Stature',
                'FA Report: Maximum Stature',
                'Identified Sex',
                'Identified Sex Notes',
                'Identified Age',
                'Identified Age Units (years or fetal months)',
                'Identified Age Notes',
                'Identified Race/Ethnicity',
                'Race/Ethnicity Notes',
                'Identified Stature',
                'Identified Stature Notes',
                'Information Source',
                'Case Notes',
                'Background Case Knowledge');

            $headerrow2 = array("");
            if($mine) {
                array_push($headerrow2, "");
            }
            array_push($headerrow2,
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                ''
                );
            $pre_headerrow = $headerrow2;
       }

        // Add methods to header row
        $method_info_ids = $headerrow2; // for proper order of method_infos


       	$all_methods = method::get_methods_by_type($db,$method_type); 
        // Order methods by type
        
        foreach($all_methods as $method) {
            // Create header rows for methods
            if($fdb) {
                // FDB report
                if(!$method->get_fdb()) {
                    // If method isn't FDB, skip over this method
                    continue;
                } else {
                    // Keep going in foreach
                }
            } else {
               // Regular report 
            }
            $methodname = $method->get_name();
            
            $method_type_name = $method->get_method_type() . " Method";
            
            $pre_headerrow[] = $method_type_name;
            $pre_headerrow[] = $method_type_name;
            
            $headerrow[] = $methodname;
            $headerrow[] = $methodname;
            $headerrow2[] = 'Method used?';
            $headerrow2[] = 'Estimated outcome';
            $method_info_ids[] = '';
            $method_info_ids[] = '';
            $method_infos = $method->get_method_infos();

            // Some methods ('misfit methods') don't follow standard display. They have a separate
            // "method_info_type", and are displayed according to that type
            foreach($method_infos as $method_info) {
                
                if($method->get_method_info_type() == METHOD_INFO_TYPE_SPRADLEY_JANTZ) {
                    if($method_info->get_type() != input_type::get_input_id_by_name($db, USER_INTERACTION_CATEGORY)&&
                            $method_info->get_type() != input_type::get_input_id_by_name($db, USER_INTERACTION_INPUT_BOX_WITH_DROPDOWN) &&
                            $method_info->get_type() != input_type::get_input_id_by_name($db, USER_INTERACTION_ESTIMATED_OUTCOME) &&
                            $method_info->get_type() != input_type::get_input_id_by_name($db, USER_INTERACTION_LEFT_RIGHT)) {
                        
                        $name = $method_info->get_name();
                        if($method_info->get_header() != null && $method_info->get_name() != $method_info->get_header()) {
                            $name .= ": ". $method_info->get_header();
                        }

                        // For formulas, just use the header text
                        if($method_info->get_type() == input_type::get_input_type_by_name($db, USER_INTERACTION_SELECT_EACH)->get_id()) {
                            $name = $method_info->get_header();
                        }

                        $pre_headerrow[] = $method_type_name;
                        $headerrow[] = $methodname;
                        $headerrow2[] = $name;
                        $method_info_ids[] = $method_info->get_id();
                    } else {
                        // Don't display this type in the record
                    }
                } else {
                if($method_info->get_type() != input_type::get_input_id_by_name($db, USER_INTERACTION_CATEGORY) &&
                        $method_info->get_type() != input_type::get_input_id_by_name($db, USER_INTERACTION_INPUT_BOX_WITH_DROPDOWN) &&
                        $method_info->get_type() != input_type::get_input_id_by_name($db, USER_INTERACTION_ESTIMATED_OUTCOME) &&
                        $method_info->get_type() != input_type::get_input_id_by_name($db, USER_INTERACTION_LEFT_RIGHT)) {

                    $name = $method_info->get_name();
                    if($method_info->get_parent_id() != null) {
                        $parent = new method_infos($db, $method_info->get_parent_id());
                        if($parent->get_name() != $name) {
                            // Format name with parent title
                            $name = $parent->get_name() . ": ". $name;
                        } else {
                            // Don't format name
                        }

                    }
                    $pre_headerrow[] = $method_type_name;
                    $headerrow[] = $methodname;
                    $headerrow2[] = $name;
                    $method_info_ids[] = $method_info->get_id();
                                        
                    if(count($method_info->get_references()) > 0) {
                        // Add column for references
                        $pre_headerrow[] = $method_type_name;
                        $headerrow[] = $methodname;
                        $headerrow2[] = $name . " References";
                        $method_info_ids[] = '';
                    } else {
                        // Don't show in report
                    }
                    
                }
                }
                
                   
            } // end foreach($method_infos)
        } // end creating header rows
         
        
        // create a file pointer connected to the output stream
        $output = fopen('php://temp', 'w');
        
        // output the column headings
        fputcsv($output, $pre_headerrow);
        fputcsv($output,$headerrow);
        fputcsv($output,$headerrow2);

        foreach($case_list as $curr_case) {
            $curr_row = array();

            $member = new member($db, $curr_case->get_memberid());

            $curr_row[] = $curr_case->get_id();

            
            if($mine) {
                $curr_row[] = $curr_case->get_casenumber();
            } else {
            }
            
            $curr_row[] = $curr_case->get_datesubmitted();
            $curr_row[] = $curr_case->get_caseyear();

            if($curr_case->get_orig_case_year() != NULL && $curr_case->get_orig_case_year() != "") {
                $curr_row[] = "Y";
                $curr_row[] = $curr_case->get_orig_case_year();
            } else {
                $curr_row[] = "N";
                $curr_row[] = "";
            }
            
            if($fdb) {
                // Add case number and agency to FDB report
                $curr_row[] = $curr_case->get_casenumber();
                $curr_row[] = $curr_case->get_caseagency();
            } else {
                // Not FDB
            }
            $curr_row[] = $curr_case->get_fasex();
            $curr_row[] = $curr_case->get_faage() . " " . (empty($curr_case->get_faageunits()) ? "years" : $curr_case->get_faageunits());
            $curr_row[] = $curr_case->get_faage2() . " " . (empty($curr_case->get_faageunits2()) ? "years" : $curr_case->get_faageunits2());
            $curr_row[] = $curr_case->get_faage_notes();
            $faancestry = "";
            
            if ($curr_case->get_faancestryottext()!= null &&
                    $curr_case->get_faancestryottext() != '') {
                $faancestry=$faancestry.'['.$curr_case->get_faancestryottext().']';
            } else {
                // Not listed
            }
            $curr_row[] = $faancestry;
            
            // Get the FA estimated stature and stature units
            $fastatureunits = $curr_case->get_fastatureunits();
            $units = '';
            if(!empty($fastatureunits)) {
                $units = " ($fastatureunits)";
            } else {
                $units = " (in)"; // default
            }

            $curr_row[] = (empty($curr_case->get_fastature()) ? "" : ($curr_case->get_fastature() . $units));
            $curr_row[] = (empty($curr_case->get_fastature2()) ? "" : ($curr_case->get_fastature2() . $units));
            
            
            $curr_row[] = $curr_case->get_idsex();
            $curr_row[] = $curr_case->get_idsex_notes();
            $curr_row[] = $curr_case->get_idage();
            $curr_row[] = $curr_case->get_idageunits();
            $curr_row[] = $curr_case->get_idage_notes();
            
            // Get the identified ancestry
            $idancestry = "";
            if ($curr_case->get_idraceas()!=0){
                $idancestry=$idancestry.'[Asian/Pacific Islander]';
            } else {
                // Not listed
            }
            if ($curr_case->get_idraceaf()!=0){
                $idancestry=$idancestry.'[African-American/Black]';
            } else {
                // Not listed
            }
            if ($curr_case->get_idracehi()!=0){
                $idancestry=$idancestry.'[Hispanic]';
            } else {
                // Not listed
            }
            if ($curr_case->get_idracena()!=0){
                $idancestry=$idancestry.'[Native American]';
            } else {
                // Not listed
            }
            if ($curr_case->get_idracewh()!=0){
                $idancestry=$idancestry.'[White]';
            } else {
                // Not listed
            }
            if ($curr_case->get_idraceot()!=0){
                $idancestry=$idancestry.'['.$curr_case->get_idraceottext().']';
            } else {
                // Not listed
            }
            
            $curr_row[] = $idancestry;
            $curr_row[] = $curr_case->get_idancaddtext();
            
            $idstatureunits = $curr_case->get_idstatureunits();
            if(!empty($idstatureunits)) {
                $idunits = " ($idstatureunits)";
            } else {
                $idunits = " (in)"; // default
            }
            
            $curr_row[] = (empty($curr_case->get_idstature()) ? "" : ($curr_case->get_idstature()) . $idunits);
            $curr_row[] = $curr_case->get_idstature_notes();
            $curr_row[] = $curr_case->get_idsource();
            $curr_row[] = $curr_case->get_casenotes();
            
            $background_knowledge = "";
            
            // Determine which, if any, traits were known prior to case investigation
            if($curr_case->get_known_none()== 1) {
                $background_knowledge .= "No biological profile information was known";
            } else {
                // Not checked
            }
            if($curr_case->get_known_sex() == 1) {
                if($background_knowledge != "") {
                    $background_knowledge .= ", ";
                } else { 
                    // No comma
                }
                
                $background_knowledge .= "Sex was known";
            } else {
                // Not checked
            }
            if($curr_case->get_known_age()== 1) {
                if($background_knowledge != "") {
                    $background_knowledge .= ", ";
                } else { // No comma
                    
                }
                $background_knowledge .= "Age was known";
            } else {
                // Not checked
            }
            if($curr_case->get_known_ancestry()== 1) {
                if($background_knowledge != "") {
                    $background_knowledge .= ", ";
                } else { 
                    // No comma
                }
                $background_knowledge .= "Ancestry/Group Affinity was known";
            } else {
                // Not checked
            }
            if($curr_case->get_known_stature()== 1) {
                if($background_knowledge != "") {
                    $background_knowledge .= ", ";
                } else { // No comma
                    
                }
                $background_knowledge .= "Stature was known";
            } else {
                // Not checked
            }
            if($curr_case->get_known_unable_to_determine()== 1) {
                if($background_knowledge != "") {
                    $background_knowledge .= ", ";
                } else { // No comma
                    
                }
                $background_knowledge .= "Unable to determine";
            } else {
                // Not checked
            }
            
            $curr_row[] = $background_knowledge;
            
            $case_methods = $curr_case->get_case_methods();
            $case_method_ids = array();
            $case_method_data = array();
            foreach($case_methods as $tmp_case_method) {
                $case_method_data[$tmp_case_method->get_methodid()] = $tmp_case_method->get_id();
            }
            $case_method_ids = array_keys($case_method_data);

            $i = 0;

            // Go through all methods and print data if that method was used in this case
            
            foreach($all_methods as $tmp_method) {
                if($fdb) {
                    if(!$tmp_method->get_fdb()) {
                        continue;
                    } else {
                        // FDB, keep goint in foreach
                    }
                }
                if(in_array($tmp_method->get_id(), $case_method_ids)) {
                    // This method has been used in this case
                    
                    // "Y" denotes this case was used.
                    $curr_row[] = "Y";

                    $tier2id = $case_method_data[$tmp_method->get_id()];
                    $tier2 = new tier2data($db, $tier2id);
                    
                    // Estimated outcome

                    $est = $tier2->format_estimated_outcome_1();
                    $est2 = $tier2->format_estimated_outcome_2();
                    $est_units = $tier2->get_estimated_outcome_units();
                    if($est2 != null && $est2 != '') {
                        $est .= " to " . $est2;
                    } else {
                        if(is_numeric($est)) {
                            $est = ">= ".$est;
                        } else {
                            // No greater than or equals sign needed
                        }
                    }
                    if(empty($est) && !empty($est2)) {
                        if(is_numeric($est2)) {
                            $est = "<= ".$est2;
                        } else {
                            // No less than or equals sign needed
                        }
                    } else {
                        // No est2 given
                    }
                    if($est_units != null && $est_units != "") {
                        $est .=  " ".$est_units;
                    } else {
                        // No units given
                    }
                    $curr_row[] = $est;
                    
                    $tier3s = $tier2->get_tier3data();

                    $method_infos = $tmp_method->get_method_infos();
                    
                    // Add the method info data for this method
                    foreach($method_infos as $method_info) {
                            if($method_info->get_type() != input_type::get_input_id_by_name($db, USER_INTERACTION_CATEGORY) &&
                                    $method_info->get_type() != input_type::get_input_id_by_name($db, USER_INTERACTION_INPUT_BOX_WITH_DROPDOWN) &&
                                    $method_info->get_type() != input_type::get_input_id_by_name($db, USER_INTERACTION_ESTIMATED_OUTCOME) &&
                                    $method_info->get_type() != input_type::get_input_id_by_name($db, USER_INTERACTION_LEFT_RIGHT)) {
                                // Don't display the above types
                            $id = $method_info->get_id();
                            $index = array_search($id, $method_info_ids);

                            $options = $method_info->get_method_info_options();
                            $opt_ids = array();
                            foreach($options as $opt) {
                                $opt_ids[] = $opt->get_id();
                            }
                            $found = false;
                            $txt = "";
                            $user_input = false;
                            if($method_info->get_type() == input_type::get_input_id_by_name($db, USER_INTERACTION_NUMERIC_ENTRY) ||
                                 $method_info->get_type() == input_type::get_input_id_by_name($db, USER_INTERACTION_TEXT_ENTRY) ||
                                 $method_info->get_type() == input_type::get_input_id_by_name($db, USER_INTERACTION_TEXT_AREA)) {
                                $user_input = true;
                            } else {
                                // No user input
                            }
                            foreach($tier3s as $tier3) {

                                if(in_array($tier3->get_method_info_option_id(), $opt_ids)) {
                                    if($user_input) {
                                        if($tier3->get_value() != null) {
                                            $txt .= $tier3->get_value();
                                        } else {
                                            $txt .= "";
                                        }
                                        $found = true;
                                    } else {
                                        if($txt != "") {
                                            $txt .= ", ";
                                        } else {
                                            // No comma needed
                                        }
                                        $txt .= $tier2->format_tier3data($tier3->get_id(), false);
                                        $found = true;

                                    }
                                }
                            }
                                // Add L/R
                                // "if it's a numeric entry and has a child (L/R), add that info to the text
                                if($method_info->get_type() == input_type::get_input_id_by_name($db, USER_INTERACTION_NUMERIC_ENTRY)) {

                                    if(count($method_info->get_children()) > 0) {

                                        $children = $method_info->get_children();
                                        $child = $children[0];
                                        $options = $child->get_method_info_options();

                                        foreach($options as $opt) {
                                            $t3 = tier3data::get_tier3_by_option($db, $tier2->get_id(), $opt->get_id());
                                            if($t3 != null) {
                                                $txt .= " (".$opt->get_value().")";
                                            } else {
                                                // Null, don't add value
                                            }
                                        }
                                    } else {
                                        // No children for this method
                                    }

                            } else {
                                // Not numeric entry
                            }


                            if(!$found) {
                                $curr_row[$index] = '';
                            } else {
                                $curr_row[$index] = $txt;
                            }
                        } else {
                            // Not a specified type
                        } 

                        // Were references used?        
                        if(count($method_info->get_references()) > 0) {
                            // Add column for references
                            $refs = $tier2->get_selected_references($method_info->get_id());
                            $ref_list = "";
                            foreach($refs as $ref) {
                                if($ref_list != "") {
                                    $ref_list .= "; ";
                                } else {
                                    // No need for separator
                                }
                                $ref_list .= $ref->get_reference_name();
                            }
                            $curr_row[$index + 1] = $ref_list;
                        } else {
                            // No references
                        }    
                    
                    } // end foreach($method_infos)
                    
                } else {
                    // This method was not used
                    
                    $curr_row[]= "N";
                    // Estimated outcome is blank if not used
                    $curr_row[] = '';
                    $method_infos = $tmp_method->get_method_infos();
                    
                    // For each method info, add an empty space to the Excel sheet
                    foreach($method_infos as $method_info) {
                        if($method_info->get_type() != input_type::get_input_id_by_name($db, USER_INTERACTION_CATEGORY) &&
                                $method_info->get_type() != input_type::get_input_id_by_name($db, USER_INTERACTION_INPUT_BOX_WITH_DROPDOWN) &&
                                $method_info->get_type() != input_type::get_input_id_by_name($db, USER_INTERACTION_ESTIMATED_OUTCOME) &&
                                $method_info->get_type() != input_type::get_input_id_by_name($db, USER_INTERACTION_LEFT_RIGHT) ) {
                            
                            $curr_row[] = '';
                            
                            if(count($method_info->get_references()) > 0) {
                                // This method info uses references, so include a column for them
                                $curr_row[] = '';
                            } else {
                                // No reference column needed
                            }
                        } else {
                            // Not a given method type
                        }
                    } // end foreach($method_infos)
                }
                $i++;
            }
            // Add the output data row to the file
            fputcsv($output, $curr_row);

        } // end foreach($caselist)
        
        rewind($output);
        $data = stream_get_contents($output);
	fclose($output);
	return $data;

    }
    
    
    /////////////// Private methods //////////////
    
    private function load_case($id) {
        
	    $query = "SELECT cases.*,region.name as caseregion,region.id as region_id from cases ";
	    $query .= "LEFT JOIN region ON region_id=cases.region_id ";
	    $query .= "WHERE cases.id=  :id";
        $mresult = $this->db->query($query, array("id"=>$id));
        if(!$mresult) {
            echo 'Could not load data from database';
            return;
        }
        $casedata = $mresult[0];
        $this->id = $id; 
        $this->casename = $casedata['casename'];
        $this->casenumber = $casedata['casenumber'];
        $this->caseyear = $casedata['caseyear'];
        $this->orig_case_year = $casedata['origcaseyear'];
        $this->memberid = $casedata['memberid'];
        $this->caseagency = $casedata['caseagency'];
	$this->caseregion = $casedata['caseregion'];
	$this->region_id = $casedata['region_id'];
        $this->fasex = $casedata['fasex'];
        $this->faage = $casedata['faage'];
        $this->faage2 = $casedata['faage2'];
        $this->faageunits = $casedata['faageunits'];
        $this->faageunits2 = $casedata['faageunits2'];
	$this->faage_notes = $casedata['faage_notes'];
        $this->faancestryottext = $casedata['faancestryottext'];
        $this->fastature = $casedata['fastature'];
        $this->fastature2 = $casedata['fastature2'];
        $this->fastatureunits = $casedata['fastatureunits'];
        $this->idsex = $casedata['idsex'];
        $this->idsex_notes = $casedata['idsex_notes'];
        $this->idage = $casedata['idage'];
        $this->idageunits = $casedata['idageunits'];
        $this->idage_notes = $casedata['idage_notes'];
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
        $this->idstature_notes = $casedata['idstature_notes'];
        $this->idsource = $casedata['idsource'];
        $this->casenotes = $casedata['casenotes'];
        $this->datestarted = $casedata['datestarted'];
        $this->datemodified = $casedata['datemodified'];
        $this->submissionstatus = $casedata['submissionstatus'];
        $this->datesubmitted = $casedata['datesubmitted'];        
        $this->known_none = $casedata['known_none'];
        $this->known_sex = $casedata['known_sex'];
        $this->known_age = $casedata['known_age'];
        $this->known_ancestry = $casedata['known_ancestry'];
        $this->known_stature = $casedata['known_stature'];
        $this->known_unable_to_determine = $casedata['known_unable_to_determine']; 
        $this->fdb_consent = $casedata['fdb_consent'];
        }
    
}
