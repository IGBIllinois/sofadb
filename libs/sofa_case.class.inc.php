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
    
    
    
    public function get_case_methods() {
        $query = "SELECT * from tier2data where caseid = :id";
        $params = array("id"=>$this->id);
        $result = $this->db->get_query_result($query, $params);
        $tier2s = array();
        foreach($result as $id) {
            $tier2 = new tier2data($this->db, $id['id']);
            $tier2s[] = $tier2;
            //$method = new method($this->db, $id['methodid']);
            //$methods[] = $method;
        }
        return $tier2s;
    }
    
    // Method data, (tier3data)
    public function add_method_data($caseid,
                                    $methodid,
                                    $method_data_id) {
        
        $case = new sofa_case($this->db, $caseid);
        $method = new method($this->db, $methodid);
        
        if($method->get_type() == "Age") {
            
            method_info::add_method_info($db, $caseid, $methodid, $method_data_id);
            
        }
        
    }
    
    public function get_method_info($caseid,    
                                    $methodid) {
        
        $case = new sofa_case($this->db, $caseid);
        $method = new method($this->db, $methodid);
        
        if($method->get_type() == "Age") {
            
            $methoddata = new method_info($db);
            $methoddataobjects = $methoddata->get_method_data($caseid, $methodid);
            return $methoddataobjects;
        }
            
    }
    
    public function add_tier3_age($methodid, $od1, $od2, $tier2id, $value=NULL, $interaction=NULL) {
        if($interaction == null) {
            // try od1 and od2
            if($od2 != null) {
            $info_query = "SELECT * from age_method_info where methodid = :methodid AND ".
                    " output_data_1 = :od1 and output_data_2 = :od2";
            $info_params = array("methodid"=>$methodid,
                    "od1"=>$od1,
                    "od2"=>$od2);
            } else {
                $info_query = "SELECT * from age_method_info where methodid = :methodid AND ".
                        " output_data_1 = :od1";
                $info_params = array("methodid"=>$methodid,
                        "od1"=>$od1);    
            }
        } else if($interaction == USER_INTERACTION_INPUT_BOX) {
            // try without od2 for now
            $info_query = "SELECT * from age_method_info where methodid = :methodid AND ".
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
            
                if($methoddata->get_user_interaction() == USER_INTERACTION_MULTISELECT) {

                $q = "INSERT INTO tier3data_age(tier2id, methoddataid) VALUES ".
                        "(:t2id, :methoddataid)";
                $params = array("t2id"=>$tier2id,
                                "methoddataid"=>$methoddataid);
                $info_result = $this->db->get_insert_result($q, $params);
                if($info_result > 0) {
                    return array("RESULT"=>TRUE,
                                "MESSAGE"=>"Method data added successfully.",
                                "id"=>$info_result);
                }
            } else if($methoddata->get_user_interaction() == USER_INTERACTION_INPUT_BOX) {

                $q = "INSERT INTO tier3data_age(tier2id, methoddataid, value) VALUES ".
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
    
    public function get_tier3data_age($t2id) {
        $query1 = "SELECT * from tier3data_age where tier2id = :t2id";
        $params = array("t2id"=>$t2id);
        
        $result = $this->db->get_query_result($query1, $params);
        
        return $result;

    }
    
    
    
    public function remove_method_age($t2id) {
        $query1 = "DELETE FROM tier2data where id = :t2id";
        $params = array("t2id"=>$t2id);
        
        $result = $this->db->get_update_result($query1, $params);
        
        $query2 = "DELETE from tier3data_age where tier2id = :t2id";
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