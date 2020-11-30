<?php
/**
 *  Allows an Admin to add Administrator notes, 
 */
$title = " Forensic Anthropology Case Database (FADAMA) - Admin Notes";
require_once "../include/header_admin.php";

if(isset($_POST['addMessageSubmit'])) {
    // Add a new message
    $errors = array();
    if(!isset($_POST['message']) || $_POST['message'] == "") {
        $errors[] = "Please input a message.";
    } else {
        $message = $_POST['message'];
    }
    
    if(count($errors) == 0) {
        
        $result = admin_note::add_admin_note($db, $session->get_var('id'), $message);
        echo($result['MESSAGE']);
    } else {
        echo("Error:<BR>");
        foreach($errors as $error) {
            echo($error."<BR>");
        }
    }
} else {
    // No submit
}

echo('<div id="memberregion"> 
  </br>');
echo("
This is a place where admins can post and keep track of modifications and tasks they have completed for FADAMA. 
For a comprehensive list of the roles and responsibilities of the FADAMA Administrators, please see the Administrator Handbook <a target='blank' href='https://docs.google.com/document/d/1OW1R_Xms-2qMvjbuBTdESk9vTED8SwVVxCpttGSK5uE/edit?usp=sharing'>here</a>.
");
$notes = admin_note::get_all_admin_notes($db);

echo("<table id='hortable'>");
echo("<tr><th width=20%>Date</th><th width=20%>Name</th><th>Message</th></tr>");
foreach($notes as $note) {
    $member = new member($db, $note->get_member_id());
    $name = $member->get_firstname() . " ".$member->get_lastname();
    echo("<tr><td>".date("Y-m-d ", strtotime($note->get_date_added()))."</td><td>".$name."</td><td>".$note->get_message()."</td></tr>");
}
echo("</table>");

echo("<form action=admin_notes.php method='POST' name=new_note id=new_note>");
echo("Add a new note:<BR>");
echo("<textarea rows=10 cols=50 name=message id=message></textarea>");
echo("<BR><input type='submit' value='Add message' name='addMessageSubmit' id='addMessageSubmit'>");
echo("</form>");


echo("</div>");

require_once("../include/footer.php");
?>