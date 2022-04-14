<?php

/* 
 * Member class for users and admins for the database
 */

class member {
    
    private $db;
    
    /** Member ID */
    private $id;
    
    /** email (username) */
    private $uname;
    
    /** Encrypted password */
    private $pwd;
    
    /** First name */
    private $firstname;
    
    /** Last name */
    private $lastname;
    
    /** Title */
    private $title;
    
    /** Academic degree */
    private $degree;
    
    /** Year degree was earned */
    private $degreeyear;
    
    /** Field of study */
    private $fieldofstudy;
    
    /** Status with AAFS */
    private $aafsstatus;
    
    /** Institution where the user works */
    private $institution;
    
    /** Region user works in */
    private $region;
    
    /** Mailing address 1 */
    private $mailaddress;
    
    /** Mailing address 2 */
    private $mailaddress2;
    
    /** City */
    private $city;
    
    /** State */
    private $state;
    
    /** Zip code */
    private $zip;
    
    /** Phone number */
    private $phone;
    
    /** Last login date */
    private $lastlogin;
    
    /** User permission status */
    private $permissionstatus;
    
    
    private $dateregistered;
    
    private $affiliation;
    private $sponsor;
    private $sponsor_email;
    private $sponsor_affiliation;
    
    /** User has agreed to terms */
    private $agree_to_terms;
    
    /** User's signature, signifying they've agreed to terms */
    private $signature;
    
    /** Date of signature */
    private $signature_date;
    
    public function __construct($db, $id = null) {
        $this->db = $db;
        if($id !=  null) {
            $this->load_member($id);
        } else {
            // Don't load data
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
public function get_region() { return $this->region; }
public function get_mailaddress() { return $this->mailaddress; }
public function get_mailaddress2() { return $this->mailaddress2; }
public function get_city() { return $this->city; }
public function get_state() { return $this->state; }
public function get_zip() { return $this->zip; }
public function get_phone() { return $this->phone; }
public function get_dateregistered($long_format = false) { 
	if ($long_format) {
		return $this->dateregistered;
	}
	else {
		return date("Y-m-d",strtotime($this->dateregistered));
	}
}
public function get_lastlogin($long_format = false) { 
	if ($long_format) {
		return $this->lastlogin; 
	}
	elseif ($this->lastlogin) {
		return date("Y-m-d",strtotime($this->lastlogin));
	}
	return "";

}
public function get_permissionstatus() { return $this->permissionstatus; }
public function get_affiliation() { return $this->affiliation; }
public function get_sponsor() { return $this->sponsor; }
public function get_sponsor_email() { return $this->sponsor_email; }
public function get_sponsor_affiliation() { return $this->sponsor_affiliation; }
public function get_agree_to_terms() { return $this->agree_to_terms; }
public function get_signature() { return $this->signature; }
public function get_signature_date() { return $this->signature_date; }

public function get_totalcases() {
    return $this->get_num_active_cases();
}

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
                    "idactivate"=>$this->id);
    $result = $this->db->get_update_result($q, $params);
    
    if($result > 0) {
        return array("RESULT"=>TRUE,
                    "MESSAGE"=>"Member ".$this->get_uname(). " updated successfully.");
    } else {
        return array("RESULT"=>FALSE,
            "MESSAGE"=>"Error: Member ".$this->get_uname(). " not updated.");
    }
    
}

/** Gets the number of active (not deleted) cases for this user
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
    } else {
        // None found
    }
    
}


/** Gets the number of unsubmitted cases for this user
 * 
 * @return int the number of active cases for this user
 * 
 */
public function get_num_unsubmitted_cases() {
    $q = "SELECT COUNT(id) as count FROM cases WHERE memberid=:memberid AND submissionstatus=0";
    $params = array("memberid"=>$this->id);
    $result = $this->db->get_query_result($q, $params);
    if(count($result)> 0) {
        return $result[0]['count'];
    } else {
        // None found
    }
    
}

/** Loads info from the database into this member object. Used when updating user password to new version
 * 
 * @param string email of the user
 * @param string $hash_pass Hashed password of the user
 * @return Array in the format ("RESULT"=>$result, "MESSAGE"=>$message) where
 * $result is true if successful, and $message is an output message.
 */
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

/** Updates then this user last logged in.
 * 
 * @return Array in the format ("RESULT"=>$result, "MESSAGE"=>$message) where
 * $result is true if successful, and $message is an output message.
 */
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

/**
 * Resets this user's password
 * 
 * @param type $new_pass hashed new password
 * @return An array of the form ("RESULT"=>$result, "MESSAGE"=>$message)
 * where $result is true or false, and $message is an output message.
 */
public function reset_password($new_pass) {

    $new_pass_hash = password_hash($new_pass, PASSWORD_DEFAULT);
    $query = "UPDATE members set pwd=:new_pass where id=:id";
    $params = array("new_pass"=>$new_pass_hash,
                    "id"=>$this->id);
    $result = $this->db->get_update_result($query, $params);
    if($result > 0) {
        return array("RESULT"=>TRUE,
                    "MESSAGE"=>"Password updated successfully.");
    } else {
        return array("RESULT"=>FALSE,
                    "MESSAGE"=>"There was an error resetting your password.");
    }
}

/**
 * Deletes a member from the database, and removes their data as well
 * 
 * @param id $delete_member_id ID of the user to delete
 * @return An array of the form ("RESULT"=>$result, "MESSAGE"=>$message)
 * where $result is true or false, and $message is an output message.
 */
public function delete_member($delete_member_id) {
    if($this->get_permissionstatus() != PERMISSION_ADMIN) {
        return array("RESULT"=>FALSE,
                    "MESSAGE"=>"You do not have permission to delete this user.");        
    } else {
        
    }
    
    if($this->get_id() == $delete_member_id) {
        return array("RESULT"=>FALSE,
                    "MESSAGE"=>"You cannot delete yourself.");            
    }
    $del_member = new member($this->db, $delete_member_id);
    if($del_member == null) {
         return array("RESULT"=>FALSE,
                    "MESSAGE"=>"Member not found.");             
    }
    $del_member_name = $del_member->get_firstname() . " ".$del_member->get_lastname();
    $del_member_email = $del_member->get_uname();
    $del_member_id = $del_member->get_id();
   $total_cases = sofa_case::get_member_cases($this->db, $del_member_id);
   foreach($total_cases as $case) {
       // delete tier2data for each case
       $tier2s = $case->get_case_methods();
       foreach($tier2s as $tier2) {
           // delete tier3 data
           $t2id = $tier2->get_id();
           $tier3s = $tier2->get_tier3data();
           foreach($tier3s as $tier3) {
               $t3id = $tier3->get_id();
               tier3data::delete_tier3_by_id($this->db, $t3id);
           }
           tier2data::delete_tier2($this->db, $t2id);
       }
   }
   
    $delete_cases_query = "DELETE FROM cases where memberid = :memberid ";
    $delete_cases_params = array("memberid"=>$delete_member_id);
    $delete_cases_result = $this->db->get_update_result($delete_cases_query, $delete_cases_params);
    
    $delete_user_query = "DELETE FROM members where id = :memberid";
    $delete_user_params = array("memberid"=>$delete_member_id);
    $delete_user_result = $this->db->get_update_result($delete_user_query, $delete_user_params);
    
    if($delete_user_result > 0) {
        return array("RESULT"=>TRUE,
        "MESSAGE"=>"Member $del_member_name ($del_member_email) successfully deleted.");       
    } else {
        return array("RESULT"=>FALSE,
        "MESSAGE"=>"There was an error deleting $del_member_name ($del_member_email). Please check the information and try again.");       
    }
}

/** Updates if a user has agreed to the terms of service
 * 
 * @param string $signature Signature the user provided, saying they agree to the terms
 * @param string $signature_date Date the user provided
 * @param bool $agree True if data is provided and they agree.
 */
public function update_terms_agreement($signature, $signature_date, $agree) {
    $query = "UPDATE members set signature=:signature, signature_date=:signature_date, agree_to_terms = :agree where id=:id";
    $params = array("signature"=>$signature,
                    "signature_date"=>$signature_date,
                    "agree"=>$agree,
                    "id"=>$this->id);
    $result = $this->db->get_update_result($query, $params);
    if($result > 0) {
        $this->agree_to_terms = $agree;
    }
}

// Static functions

/** Check a user's entered password matches the new encrypted version in database
 * 
 * @param db $db The database object
 * @param string User's email
 * @param string Password to check
 * @return boolean True if the passwords match, else false
 */
public static function authenticate($db, $name, $chkpwd) {
    $query = "SELECT pwd from members where uname=:name";
    $params = array("name"=>$name);
    
    $pwd_result = $db->get_query_result($query, $params);
    
    $pwd = $pwd_result[0]['pwd'];

    $result = password_verify($chkpwd, $pwd);

    // Returns true if successful, else false;
    return $result;
    
}

/** Gets a list of database members
 * 
 * @param db $db The database object
 * @param int $start Starting index (optional)
 * @param int $pagerows Number of records to display (optional)
 * @return \member An array of member objects
 */
public static function get_members($db, $start=-1, $pagerows=-1) {
	
    $q = "SELECT id, lastname, firstname, uname, institution, 
    DATE_FORMAT(dateregistered, '%M %d, %Y') AS regdat, 
    DATE_FORMAT(lastlogin, '%M %d, %Y') AS logdat, 
    permissionstatus, id FROM members
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


/**
 * Search members given certain parameters
 * 
 * @param db $db
 * @param int $id
 * @param string $first_name Member's first name, or part of it to search for
 * @param string $last_name Member's last name, or part of it to search for
 * @param string $email Member's email (username), or part of it to search for
 * @param string $institution Member's institution, or part of it to search for
 * @param string $region Member's region (from dropdown list)
 * @param string $andor Joining type ("AND" or "OR" depending on how to join parts)
 * 
 * @return \member A list of member objects that fit the given criteria
 */
public static function search_members(
        $db,
        $id,
        $first_name,
        $last_name,
        $email,
        $institution,
        $region,
        $andor
        
        ) {
      
        $searchstring = "";
        $params = array();
        
        if($id != null) {
            // search by id. 
        
            $searchstring=" id=:mid ";
            $params['mid'] = $id;
            
        } else {
            
        
        if($first_name != null) {
            // search by params
            if($first_name != null) {
               $searchstring=" (firstname LIKE :fname) ";
               $params['fname'] = "%".$first_name."%";                   
            }
        }
            if($last_name != null) {
                if($searchstring != null) {
                    $searchstring .= " $andor ";
                }
            
               $searchstring .= " (lastname LIKE :lname) ";
               $params['lname'] = "%".$last_name."%";      

            }
            
            if($email != null) {
                if($searchstring != null) {
                    $searchstring .= " $andor ";
                }
            
               $searchstring .= " (uname LIKE :email) ";
               $params['email'] = "%".$email."%";                      
            }
            
            if($institution != null) {
                if($searchstring != null) {
                    $searchstring .= " $andor ";
                }
            
               $searchstring .= " (institution LIKE :institution) ";
               $params['institution'] = "%".$institution."%";                      
            }
            
            if($region != null) {
                if($searchstring != null) {
                    $searchstring .= " $andor ";
                }
            
               $searchstring .= " (region LIKE :region) ";
               $params['region'] = "%".$region."%";                      
            }

        }
        
        $query = "SELECT id from members WHERE $searchstring ";
        
        $result = $db->get_query_result($query, $params);
        $found_members = array();
        foreach($result as $member) {
            $this_member = new member($db, $member['id']);
            $found_members[] = $this_member;
        }
        return $found_members;
       
}


/** 
 * Gets a list of members with a given permission status
 * 
 * @param db $db The database object
 * @param int $permission_status (0 = not registered, 1 = regular user, 2 = admin)
 * @return \member An array of members with the given permission status
 */
public static function get_members_permission($db, $permission_status) {
    $q = "SELECT id FROM members WHERE permissionstatus=:permissionstatus";
    
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

/** Add s new member to the database
 * 
 * @param db $db
 * @param array $params An array of parameters in $name=>$value form
 * @return array An array of the form 
 * ("RESULT"=>TRUE|FALSE,
 *   "MESSAGE"=>$message,
 *   "id"=>$id)
 * where "RESULT" is true if completed successfully, else false, 
 * "MESSAGE" is an output message,
 * and $id is the id of the newly created user, if successful.
 */
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
            . "region,"
            . "mailaddress,"
            . "mailaddress2,"
            . "city,"
            . "state,"
            . "zip,"
            . "phone,"
            . "permissionstatus,"
            . "affiliation,"
            . "sponsor,"
            . "sponsor_email,"
            . "sponsor_affiliation,"
            . "agree_to_terms,"
            . "signature,"
            . "signature_date"
            . ") VALUES ("
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
                . ":region,"
                . ":mailaddress1,"
                . ":mailaddress2,"
                . ":city,"
                . ":state,"
                . ":zip,"
                . ":phone,"
                . PERMISSION_UNVERIFIED. ", "
                . ":affiliation,"
                . ":sponsor,"
                . ":sponsor_email,"
                . ":sponsor_affiliation,"
                . ":agree_to_terms,"
                . ":signature,"
                . ":signature_date"
            . ")";		

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

/** Updates member info in the database
 * 
 * @param db $db
 * @param array $params An array of parameters in $name=>$value form
 * @param string $pwd New password (optional)
 * @return array An array of the form 
 * ("RESULT"=>TRUE|FALSE,
 *   "MESSAGE"=>$message,
 *   "id"=>$id)
 * where "RESULT" is true if completed successfully, else false, 
 * "MESSAGE" is an output message,
 * and $id is the id of the newly created user, if successful.
 */
public static function update_member($db, $params, $pwd=null) {
    $q = "UPDATE members SET "
            . "uname = :uname, "
            . ($pwd != null ? "pwd = :pwd," : "")
            . "firstname = :firstname,"
            . "lastname = :lastname,"
            . "title = :title,"
            . "degree = :degree,"
            . "degreeyear = :degreeyear,"
            . "fieldofstudy = :fieldofstudy,"
            . "aafsstatus = :aafsstatus,"
            . "institution = :institution,"
            . "region = :region,"
            . "mailaddress = :mailaddress1,"
            . "mailaddress2 = :mailaddress2,"
            . "city = :city,"
            . "state = :state,"
            . "zip = :zip,"
            . "phone = :phone,"
            . "affiliation = :affiliation,"
            . "sponsor = :sponsor,"
            . "sponsor_email = :sponsor_email,"
            . "sponsor_affiliation = :sponsor_affiliation"

            . " WHERE id = :id";	
    if($pwd != null) {
        $hash_pwd = password_hash($pwd, PASSWORD_DEFAULT);
        $params['pwd'] = $hash_pwd;
    }

    $result = $db->get_update_result($q, $params);
    if($result > 0) {
        return array("RESULT"=>TRUE,
                    "MESSAGE"=>"User updated successfully.",
                    "id"=>$result);
    } else {
        return array("RESULT"=>FALSE,
                    "MESSAGE"=>"An error occurred. User not updated.");
    }

}

/** Determines if a given member name exists
 * 
 * @param db $db The database object
 * @param type $uname User name (email) to check
 * @return boolean TRUE if the user exists in the database, else false.
 */
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
    
    public static function load_member_by_name($db, $name) {
        $query1 = "SELECT id from members where uname = :uname";
        $params = array("uname"=>$name);
        $result = $db->get_query_result($query1, $params);
        if(count($result) >0) {
            $id = $result[0]['id'];
            return new member($db, $id);
        }
    }

     
    // Private functions;
    /** Loads member data from the database into this member object
     * 
     * @param int $id ID of the member to get data for
     */
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
            $this->region = $member_data['region'];
            $this->mailaddress = $member_data['mailaddress'];
            $this->mailaddress2 = $member_data['mailaddress2'];
            $this->city = $member_data['city'];
            $this->state = $member_data['state'];
            $this->zip = $member_data['zip'];
            $this->phone = $member_data['phone'];
            $this->lastlogin = $member_data['lastlogin'];
            $this->permissionstatus = $member_data['permissionstatus'];

            $this->dateregistered = $member_data['dateregistered'];
            
            $this->affiliation = $member_data['affiliation'];
            $this->sponsor = $member_data['sponsor'];
            $this->sponsor_email = $member_data['sponsor_email'];
            $this->sponsor_affiliation = $member_data['sponsor_affiliation'];
            
            $this->agree_to_terms = $member_data['agree_to_terms'];
            $this->signature = $member_data['signature'];
            $this->signature_date = $member_data['signature_date'];
            
        }
    }
    
    
            
            
    
}
