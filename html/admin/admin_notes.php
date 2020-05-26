<?php
$title = "Admin Notes";
require_once "../include/header_admin.php";

if(isset($_POST['addMessageSubmit'])) {
    $message = $_POST['message'];
    $result = admin_note::add_admin_note($db, $_SESSION['id'], $message);
    echo($result['MESSAGE']);
}

echo('<div id="memberregion"> 
  </br>');


$notes = admin_note::get_all_admin_notes($db);

echo("<table id='hortable'>");
echo("<tr><th width=20%>Date</th><th width=20%>Name</th><th>Message</th></tr>");
foreach($notes as $note) {
    $member = new member($db, $note->get_member_id());
    $name = $member->get_firstname() . " ".$member->get_lastname();
    echo("<tr><td>".date("Y-m-d", strtotime($note->get_date_added()))."</td><td>".$name."</td><td>".$note->get_message()."</td></tr>");
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