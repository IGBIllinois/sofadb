<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class sofa_case {
    
    private $dbcon;
    
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
    
    public function __construct($dbcon, $id = 0) {
        $this->dbcon = $dbcon;
        if($id != 0) {
            $this->load_case($id);
        }
    }
    /**
     * 
     * @param type $dbcon Connection to database
     * @param type $data array of values. Using an array here since thera are so many
     */
    public static function add_case($dbcon, $data) {
        $casename = mysqli_real_escape_string($dbcon, $data['casename']);
        $casenum = mysqli_real_escape_string($dbcon, $data['casenum']);
        $caseyear = mysqli_real_escape_string($dbcon, $data['caseyear']);
        $memberid = mysqli_real_escape_string($dbcon, $data['memberid']);
        $caseag = mysqli_real_escape_string($dbcon, $data['caseag']);
        $fasex = mysqli_real_escape_string($dbcon, $data['fasex']);
        $faage = mysqli_real_escape_string($dbcon, $data['faage']);
        $faage2 = mysqli_real_escape_string($dbcon, $data['faage2']);
        $faageunits = mysqli_real_escape_string($dbcon, $data['faageunits']);
        $faageunits2 = mysqli_real_escape_string($dbcon, $data['faageunits2']);
        $fastature = mysqli_real_escape_string($dbcon, $data['fastature']);
        $fastature2 = mysqli_real_escape_string($dbcon, $data['fastature2']);
        $fastatureunits = mysqli_real_escape_string($dbcon, $data['fastatureunits']);
        $idsex = mysqli_real_escape_string($dbcon, $data['idsex']);
        $idage = mysqli_real_escape_string($dbcon, $data['idage']);
        $idageunits = mysqli_real_escape_string($dbcon, $data['idageunits']);
        $idstature = mysqli_real_escape_string($dbcon, $data['idstature']);
        $idstatureunits = mysqli_real_escape_string($dbcon, $data['idstatureunits']);
        $casenotes = mysqli_real_escape_string($dbcon, $data['casenotes']);
        //$datestarted = mysqli_real_escape_string($dbcon, $data['datestarted']);
        //$datemodified = mysqli_real_escape_string($dbcon, $data['datemodified']);
        //$submissionstatus = mysqli_real_escape_string($dbcon, $data['submissionstatus']);
        $faancestryas = mysqli_real_escape_string($dbcon, $data['faancestryas']);
        $faancestryeuro = mysqli_real_escape_string($dbcon, $data['faancestryeuro']);
        $faancestryaf = mysqli_real_escape_string($dbcon, $data['faancestryaf']);
        $faancestryna = mysqli_real_escape_string($dbcon, $data['faancestryna']);
        $faancestryhi = mysqli_real_escape_string($dbcon, $data['faancestryhi']);
        $faancestryot = mysqli_real_escape_string($dbcon, $data['faancestryot']);
        $faancestryottext = mysqli_real_escape_string($dbcon, $data['faancestryottext']);
        $idraceas = mysqli_real_escape_string($dbcon, $data['idraceas']);
        $idraceaf = mysqli_real_escape_string($dbcon, $data['idraceaf']);
        $idracewh = mysqli_real_escape_string($dbcon, $data['idracewh']);
        $idracehi = mysqli_real_escape_string($dbcon, $data['idracehi']);
        $idracena = mysqli_real_escape_string($dbcon, $data['idracena']);
        $idraceot = mysqli_real_escape_string($dbcon, $data['idraceot']);
        $idraceottext = mysqli_real_escape_string($dbcon, $data['idothertext']);
        $idancaddtext = mysqli_real_escape_string($dbcon, $data['idancaddtext']);
        $nummethods = mysqli_real_escape_string($dbcon, $data['numcasemethods']);
        
        $q = "INSERT INTO cases ("
                . "casename, 	"
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
                    . "'$casename',"
                    . "'$casenum',"
                    . " '$caseyear',"
                    . "'$memberid',"
                    . "'$caseag',"
                    . "'$fasex',"
                    . "'$faage',"
                    . "'$faage2',"
                    . "'$faageunits',"
                    . "'$faageunits2',"
                    . "'$fastature',"
                    . "'$fastature2',"
                    . "'$fastatureunits',"
                    . "'$idsex',"
                    . "'$idage',"
                    . "'$idageunits',"
                    . "'$idstature',"
                    . "'$idstatureunits',"
                    . "'$idancaddtext',"
                    . "'$casenotes',"
                    . "NOW(),"
                    . "NOW(),"
                    . "'0',"
                    . "'$faancestryas',"
                    . "'$faancestryeuro',"
                    . "'$faancestryaf',"
                    . "'$faancestryna',"
                    . "'$faancestryhi',"
                    . "'$faancestryot',"
                    . "'$faancestryottext',"
                    . "'$idraceas',"
                    . "'$idraceaf',"
                    . "'$idracewh',"
                    . "'$idracehi',"
                    . "'$idracena',"
                    . "'$idraceot',"
                    . "'$idraceottext',"
                    . "'$idancaddtext',"
                    . "'$nummethods')";	
        

		$result = @mysqli_query ($dbcon, $q); // Run the query.
                $caseid=mysqli_insert_id($dbcon);
                if($caseid == 0) {
                    return array("RESULT"=>FALSE,
                            "MESSAGE"=>"<h2>System Error</h2>
				<p class='error'>Saving failed because of a system error. We apologize for any inconvenience.</p>
				<p> ". mysqli_error($dbcon) . "<br/><br/>Query: " . $q . "</p>"
                        );
                }
                
                
                $q="INSERT INTO membercasetable (memberid,caseid) VALUES ('$memberid','$caseid')";
                $result2 = @mysqli_query ($dbcon, $q); // Run the query.
                if(!$result2) {
                    return array("RESULT"=>FALSE,
                                 "MESSAGE"=>"<h2>System Error</h2>
				<p class='error'>Case number not linked with member number. We apologize for any inconvenience.</p>
				<p>" . mysqli_error($dbcon) . "<br/><br/>Query: ". $q . "</p>"
                        );
                }
                
                

                return array("RESULT"=>TRUE,
                             "MESSAGE"=>"<h2>System Error</h2>
				<p class='error'>Case number not linked with member number. We apologize for any inconvenience.</p>
				<p>" . mysqli_error($dbcon) . "<br/><br/>Query: ". $q . "</p>",
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
                . "'$this->memberid',"
                . "'$this->id',"
                . "'".mysqli_real_escape_string($this->dbcon,$methodtype)."',"
                . "'".mysqli_real_escape_string($this->dbcon,$methodid)."',"
                . "'".mysqli_real_escape_string($this->dbcon,$featureid)."',"
                . "'".mysqli_real_escape_string($this->dbcon,$phaseid)."')";
        
        
                echo("add_case_method query = ".$q."<BR>");
                 $result = mysqli_query($this->dbcon,$q);
                 $casemethodid=mysqli_insert_id($this->dbcon);
                 
                 return $casemethodid;
      
    }
    
    public function get_case_methods() {
        $query = "SELECT methodid from tier2data where caseid = ".$this->id;
        $result = @mysqli_query ($this->dbcon, $query); // Run the query.
        $methods = array();
        foreach($result as $id) {
            $method = new method($this->dbcon, $id);
            $methods[] = $method;
        }
        return $methods;
    }
    
    private function load_case($id) {
        
        $query = "SELECT * from cases where id = '". mysqli_real_escape_string($this->dbcon, $id). "'";

        $mresult=mysqli_query($this->dbcon,$query);
        if(!$mresult) {
            echo 'Could not load user data from database';
            return;
        }

        $casedata=mysqli_fetch_array($mresult);
        
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