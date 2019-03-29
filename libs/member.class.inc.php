<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class member {
    
    private $db;
    
    private $id;
    private $uname;
    private $pwd;
    private $firstname;
    private $lastname;
    private $title;
    private $degree;
    private $degreeyear;
    private $fieldofstudy;
    private $aafsstatus;
    private $institution;
    private $yearsexperience;
    private $caseperyear;
    private $region;
    private $mailaddress;
    private $mailaddress2;
    private $city;
    private $state;
    private $zip;
    private $phone;
    private $lastlogin;
    private $permissionstatus;
    private $casessubmitted;
    private $caseswithdrawn;
    private $dateregistered;
    private $totalcases;
    
    public function __construct($db, $id = null) {
        $this->db = $db;
        if($id !=  null) {
            $this->load_member($id);
        }
    }

public function get_id() { return $this->id; }
public function get_uname() { return $this->uname; }
public function get_firstname() { return $this->firstname; }
public function get_lastname() { return $this->lastname; }
public function get_title() { return $this->title; }
public function get_degree() { return $this->degree; }
public function get_degreeyear() { return $this->degreeyear; }
public function get_fieldofstudy() { return $this->fieldofstudy; }
public function get_aafsstatus() { return $this->aafsstatus; }
public function get_institution() { return $this->institution; }
public function get_caseperyear() { return $this->caseperyear; }
public function get_region() { return $this->region; }
public function get_mailaddress() { return $this->mailaddress; }
public function get_mailaddress2() { return $this->mailaddress2; }
public function get_city() { return $this->city; }
public function get_state() { return $this->state; }
public function get_zip() { return $this->zip; }
public function get_casessubmitted() { return $this->casessubmitted; }
public function get_totalcases() { return $this->totalcases; }
public function get_dateregistered() { return $this->dateregistered; }
public function get_lastlogin() { return $this->lastlogin; }
public function get_permissionstatus() { return $this->permissionstatus; }

/** Sets this user's permission status
 * 
 * @param int $status The users new status 
 * ('0' for not yet approved,
 *  '1' for regular user,
 *  '2' for admin
 * @return array An array of the form:
 *  ("RESULT"=>TRUE|FALSE,
 *   "MESSAGE"=>$message)
 * where "RESULT" is true if the change was successful, else false,
 * and "MESSAGE" is an output message.
 * 
 */
public function set_permission($status) {
    $q="UPDATE members SET permissionstatus=:status WHERE id=:idactivate";
    $params = array("status"=>$status,
                    "idactivate="=>$this->id);
    $result = $this->db->get_update_result($q, $params);
    
    if($result > 0) {
        return array("RESULT"=>TRUE,
                    "MESSAGE"=>"Member ".$this->get_uname(). " updated successfully.");
    } else {
            return array("RESULT"=>FALSE,
                "MESSAGE"=>"Error: Member ".$this->get_uname(). " not updated.");
    }
    
}

/** Gets tne number of active (not deleted) cases for this user
 * 
 * @return int the number of active (not deleted) cases for this user
 * 
 */
public function get_num_active_cases() {
    $q = "SELECT COUNT(id) as count FROM cases WHERE memberid=:memberid AND submissionstatus>=0";
    $params = array("memberid"=>$this->id);
    $result = $this->db->get_query_result($q, $params);
    if(count($result)> 0) {
        return $result[0]['count'];
    }
    
}


public function load_info_by_name($name, $hash_pass) {
    $query = "SELECT id from members where uname=:name and pwd=:pwd";
    $params = array("name"=>$name,
                    "pwd"=>$hash_pass);
    
    $result = $this->db->get_query_result($query, $params);
    if(count($result) > 0) {
        $id = $result[0]['id'];
        $this->load_member($id);
        return array("RESULT"=>TRUE,
                        "MESSAGE"=>"Member loaded successfully.");
    } else {
        return array("RESULT"=>FALSE,
                        "MESSAGE"=>"Member not loaded successfully.");
    }
    
}

public function update_login_time() {
    $q = "UPDATE members SET lastlogin=NOW() WHERE id=:id";
    $params = array("id"=>$this->id);
    $result = $this->db->get_update_result($q, $params);
    if($result > 0) {
        return array("RESULT"=>TRUE,
                        "MESSAGE"=>"Member updated successfully.");
    } else {
        return array("RESULT"=>FALSE,
                        "MESSAGE"=>"Member not updated successfully.");
    }
}

// Static functions
/** Gets a list of database members
 * 
 * @param db $db The database object
 * @param int $start
 * @param int $pagerows
 * @return \member
 */
public static function get_members($db, $start=-1, $pagerows=-1) {
	
$q = "SELECT id, lastname, firstname, uname, institution, 
DATE_FORMAT(dateregistered, '%M %d, %Y') AS regdat, 
DATE_FORMAT(lastlogin, '%M %d, %Y') AS logdat, 
permissionstatus, id, totalcases FROM members
 ORDER BY dateregistered DESC ";

if($start > -1) {
	$q .= " LIMIT $start, $pagerows";	
}

$result = $db->get_query_result($q);

$members = array();
foreach($result as $member) {
	$newmember = new member($db, $member['id']);
	$members[] = $newmember;
}
return $members;
}

public static function search_members($db, $query, $params) {
    $result = $db->get_query_result($query, $params);
    $found_members = array();
    foreach($result as $member) {
        $this_member = new member($db, $member['id']);
        $found_members[] = $this_member;
    }
    return $found_members;
}



public static function get_members_permission($db, $permission_status) {
    $q = "SELECT id, lastname, firstname, uname, institution, DATE_FORMAT(dateregistered, '%M %d, %Y') AS regdat, id  FROM members WHERE permissionstatus=:permissionstatus";
    $params = array("permissionstatus"=>$permission_status);
    
    $result = $db->get_query_result($q, $params);
    
    $members = array();
    foreach($result as $member) {
        $id = $member['id'];
        $new_member = new member($db, $id);
        $members[] = $new_member;
    }
    
    return $members;
}

public static function add_member($db, $params) {
    $q = "INSERT INTO members ("
            . "uname, "
            . "pwd,"
            . "firstname,"
            . "lastname,"
            . "title,"
            . "degree,"
            . "degreeyear,"
            . "fieldofstudy,"
            . "aafsstatus,"
            . "institution,"
            . "yearsexperience,"
            . "caseperyear,"
            . "region,"
            . "mailaddress,"
            . "mailaddress2,"
            . "city,"
            . "state,"
            . "zip,"
            . "phone,"
            . "permissionstatus,"
            . "dateregistered,"
            . "casessubmitted,"
            . "caseswithdrawn,"
            . "totalcases) VALUES ("
                . ":uname, "
                . ":pwd, "
                . ":firstname, "
                . ":lastname, "
                . ":title, "
                . ":degree, "
                . ":degreeyear,"
                . ":fieldofstudy,"
                . ":aafsstatus,"
                . ":institution,"
                . ":yearsexperience,"
                . ":caseperyear,"
                . ":region,"
                . ":mailaddress1,"
                . ":mailaddress2,"
                . ":city,"
                . ":state,"
                . ":zip,"
                . ":phone,"
                . "'0', "
                . "NOW(), "
                . "'0', "
                . "'0', "
                . "'0')";		
    $result = $db->get_insert_result($q, $params);
    if($result > 0) {
        return array("RESULT"=>TRUE,
                    "MESSAGE"=>"User added successfully.",
                    "id"=>$result);
    } else {
        return array("RESULT"=>FALSE,
                    "MESSAGE"=>"An error occurred. User not added.");
    }

}

    public static function member_exists($db, $uname) {
        $query = "SELECT id from members where uname=:uname";
        $params = array("uname"=>$uname);
        $result = $db->get_query_result($query, $params);
        

        if(count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

     
    // Private functions;
    private function load_member($id) {
        $query = "SELECT * from members where id = :id";
        $params = array("id"=>$id);
        $result = $this->db->get_query_result($query, $params);
        
        if(count($result) > 0) {
            $member_data = $result[0];
            
            $this->id = $id;
            $this->uname = $member_data['uname'];
            $this->pwd = $member_data['pwd'];
            $this->firstname = $member_data['firstname'];
            $this->lastname = $member_data['lastname'];
            $this->title = $member_data['title'];
            $this->degree = $member_data['degree'];
            $this->degreeyear = $member_data['degreeyear'];
            $this->fieldofstudy = $member_data['fieldofstudy'];
            $this->aafsstatus = $member_data['aafsstatus'];
            $this->institution = $member_data['institution'];
            $this->yearsexperience = $member_data['yearsexperience'];
            $this->caseperyear = $member_data['caseperyear'];
            $this->region = $member_data['region'];
            $this->mailaddress = $member_data['mailaddress'];
            $this->mailaddress2 = $member_data['mailaddress2'];
            $this->city = $member_data['city'];
            $this->state = $member_data['state'];
            $this->zip = $member_data['zip'];
            $this->phone = $member_data['phone'];
            $this->lastlogin = $member_data['lastlogin'];
            $this->permissionstatus = $member_data['permissionstatus'];
            $this->casessubmitted = $member_data['casessubmitted'];
            $this->caseswithdrawn = $member_data['caseswithdrawn'];
            $this->dateregistered = $member_data['dateregistered'];
            $this->totalcases = $member_data['totalcases'];
            
        }
    }
            
            
    
}