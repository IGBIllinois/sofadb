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
                     $data = array("id"=>$this->memberid);
                     $result = $this->db->get_update_result($q, $data);
                        if(!$result){
                                echo '<h2>System Error</h2>
                        <p class="error">Did not increment number of cases. We apologize for any inconvenience.</p>'; 
                        // Debugging message:
                        echo '<p>'. '<br/><br/>Query: ' . $q . '</p>';
                        }
                 }
                 
                 return $casemethodid;
      
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
                    "MESSAGE"=>"Case ".$this->get_casename . " edited successfully.");
				
    }
    
    
    
    public function get_case_methods() {
        $query = "SELECT methodid from tier2data where caseid = :id";
        $params = array("id"=>$this->id);
        $result = $this->db->get_query_result($query, $params);
        $methods = array();
        foreach($result as $id) {
            $method = new method($this->db, $id['methodid']);
            $methods[] = $method;
        }
        return $methods;
    }
    
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