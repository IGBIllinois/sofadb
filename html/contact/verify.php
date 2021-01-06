<?php
$title="Email Verification";
require_once "../include/header_general.php";
require_once "../include/main.inc.php";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


// Check for tokens
$selector = filter_input(INPUT_GET, 'selector');
$validator = filter_input(INPUT_GET, 'validator');
$userid = filter_input(INPUT_GET, 'userid');

$queryString = $_SERVER['QUERY_STRING'];
if ( false !== ctype_xdigit( $selector ) && false !== ctype_xdigit( $validator ) ) {
    $result = functions::check_password_reset($db, $selector, $validator);
    $valid = $result['RESULT'];
    if($valid) {
        // They have an entry
        $email = $result['email'];
        //$user = new member($db, $userid);
        $user = member::load_member_by_name($db, $email);
        if($user->get_permissionstatus() == PERMISSION_UNVERIFIED) {
            // And currently unverified
            echo('<div id="wrapper" style="width:500px">');
                echo("Email verification success. Thank you for requesting membership approval to FADAMA. Your request is under review and may take up to 1 week to be approved.");
            echo("</div>");
                $user->set_permission(PERMISSION_REQUESTED);

            // Send admin email
            $admin_email = ADMIN_EMAIL;              
            $to = $admin_email;
            
            $params = array(
            "uname"=>$user->get_uname(),
            "firstname"=>$user->get_firstname(),
            "lastname"=>$user->get_lastname(),
            "title"=>$user->get_title(),
            "degree"=>$user->get_degree(),
            "degreeyear"=>$user->get_degreeyear(),
            "fieldofstudy"=>$user->get_fieldofstudy(),
            "aafsstatus"=>$user->get_aafsstatus(),
            "institution"=>$user->get_institution(),
            "region"=>$user->get_region(),
            "mailaddress1"=>$user->get_mailaddress(),
            "mailaddress2"=>$user->get_mailaddress2(),
            "city"=>$user->get_city(),
            "state"=>$user->get_state(),
            "zip"=>$user->get_zip(),
            "phone"=>$user->get_phone(),
            "affiliation"=>$user->get_affiliation(),
            "sponsor"=>$user->get_sponsor(),
            "sponsor_email"=>$user->get_sponsor_email(),
            "sponsor_affiliation"=>$user->get_sponsor_affiliation(),
            "agree_to_terms"=>$user->get_agree_to_terms(),
            "signature"=>$user->get_signature(),
            "signature_date"=>$user->get_signature_date());

            $from= FROM_EMAIL;
            $subject = "FADAMA DB ADMIN ALERT: Activate new user";
            $message = functions::renderTwigTemplate('email/register_admin.html.twig', $params);

            $header = "From:".$from."\r\n";
            $retval = mail($to,$subject,$message,$header);

            // Send user email
            $user_to = $e;
            $user_subject = "FADAMA Membership Request";

            $user_params = array("user_name"=>($user->get_firstname() . " ".$user->get_lastname()),
                                "from_email"=>FROM_EMAIL);
            
            $user_message = functions::renderTwigTemplate("email/register_verify.html.twig", $user_params);
            $user_header = "From:".$from."\r\n";

            $user_retval = mail($user_to, $user_subject, $user_message, $user_header);
    
        } else {
            echo('<div id="wrapper" style="width:500px">');
                echo("This email address has already been verified. Thank you for requesting membership approval to FADAMA. Your request is under review and may take up to 1 week to be approved.");
                echo("<BR><a href=/contact/index.php/>Contact</a> the administrator if you registered more than 48 hours ago.");
            echo("</div>");
        }
    } else {
        // Information incorrect
        echo('<div id="wrapper" style="width:500px">');
            echo("The information provided in the link is incorrect. Please check the link is valid, or contact the administration.");
            //echo("<form name='verify_email' id='verify_email' method=POST action=resend_verify_request.php>");
            //echo("Email address: <input type=email name=email id=email>");
            //echo("<input type=submit name=verify id=verify value='Submit'>");
            //echo("</form>");

        echo("</div>");
    }
        

    
} else {
    echo('<div id="wrapper" style="width:500px">');
    echo("There was an error in verifying this email. Please contact the administration if you are experiencing problems.");
    echo("</div>");
    
}

require_once "../include/footer.php";
   
