<?php
/** Class for admins to add notes regarding document changes, etc.
 * 
 */
class admin_note {
    
    private $db;
    
    /** ID of the note */
    private $id;
    
    /** ID of the user who made the change */
    private $user_id;
    
    /** Text of the message */
    private $message;
    
    /* Date the message was added */
    private $date_added;
    
    public function __construct($db, $id = null) {

        $this->db = $db;

        if($id != null) {
            $this->load_admin_notes($id);
            
        }  
    }   
 
    
    public function get_id() {
        return $this->id;
    }
    
    public function get_member_id() {
        return $this->user_id;
    }
    
    public function get_message() {
        return $this->message;
    }
    
    public function get_date_added() {
        return $this->date_added;
    }
    
    /** Format the message, with user name and date
     * 
     * @return string The formatted message
     */
    public function format_message() {
        $member = new member($this->db, $this->user_id);
        $member_name = $member->get_firstname(). " ".$member->get_lastname();
        $text = "$member_name [" . date('Y-d-m', $this->date_added) . "] " . $this->message;
        
        return $text;
        
    }
    
    // Static functions
    
    /** Adds a new admin note
     * 
     * @param db $db The database object
     * @param int $user_id ID of the user adding the message
     * @param string $message Text of the message
     */
    public static function add_admin_note($db, $user_id, $message) {
        $query = "INSERT INTO admin_notes (user_id, message, date_added) VALUES (:user_id, :message, NOW())";
        $params = array("user_id"=>$user_id,
                        "message"=>$message);
        
        $result = $db->get_insert_result($query, $params);
        
        if($result > 0) {
            $return_result = array("RESULT"=>TRUE,
                                    "MESSAGE"=>"The note has been added.",
                                    "id"=>$result);
        } else {
            $return_result = array("RESULT"=>FALSE,
                                    "MESSAGE"=>"There was an error. The note has not been added.");
        }
    }
    
    /** Deletes an admin note
     * 
     * @param db $db The database object
     * @param int $id ID of the message to delete
     */
    public static function delete_admin_note($db, $id) {
        $query = "DELETE FROM admin_notes where id=:id";
        $params = array("id"=>$id);
        
        $db->get_update_result($query, $params);
        
    }
    
    /** Edits an admin note
     * 
     * @param db $db The database object
     * @param int $id ID of the note to edit
     * @param string $new_message Text of the new message
     */
    public static function edit_admin_note($db, $id, $new_message) {
        $query = "UPDATE admin_notes set message = :message where id=:id";
        $params = array("message"=>$message,
                        "id"=>$id);
        
        $db->get_update_result($query, $params);
    }
    
    /** Gets an array of all the admin notes
     * 
     * @param db $db The database object
     * @return \admin_note Array of all the admin notes in the database, newest first
     */
    public static function get_all_admin_notes($db) {
        $query = "SELECT id from admin_notes ORDER BY id DESC";
        $result = $db->get_query_result($query);
        
        $return_result = array();
        foreach($result as $admin_note) {
            $id = $admin_note['id'];
            $note = new admin_note($db, $id);
            $return_result[] = $note;
        }
        return $return_result;
    }
    
    // Private functions
    private function load_admin_notes($id) {
        $query = "SELECT * from admin_notes where id=:id";

       $params = array("id"=>$id);
       $result = $this->db->get_query_result($query, $params);

       if(count($result) > 0) {
           $data = $result[0];
       
       $this->id = $id;
        $this->user_id = $data['user_id'];
        $this->message = $data['message'];
        $this->date_added = $data['date_added'];

       }
    }
}