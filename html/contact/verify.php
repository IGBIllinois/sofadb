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
        if($user->get_permissionstatus() == member::PERMISSION_UNVERIFIED) {
            // And currently unverified
            echo('<div id="wrapper" style="width:500px">');
                echo("Email verification success. Thank you for requesting membership approval to FADAMA. Your request is under review and may take up to 1 week to be approved.");
            echo("</div>");
                $user->set_permission(member::PERMISSION_REQUESTED);

            // Send admin email
            $admin_email = settings::get_admin_email();              
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

            $from= settings::get_from_email();
            $subject = "FADAMA DB ADMIN ALERT: Activate new user";
            $html_message = functions::renderTwigTemplate('email/register_admin.html.twig', $params);
            $txt_message = functions::renderTwigTemplate('email/register_admin.txt.twig', $params);
	    $emailer = new \IGBIllinois\email(settings::get_smtp_host(), 
		    settings::get_smtp_port(),
		    settings::get_smtp_username(),
	    		settings::get_smtp_password()
		);
		$emailer->set_replyto_emails(settings::get_admin_email());
            $emailer->set_to_emails($to);
            $retval = $emailer->send_email(settings::get_from_email(), $subject, $txt_message, $html_message);

            // Send user email
            $user_to = $user->get_uname();
            $user_subject = "FADAMA Membership Request";

            $user_params = array("user_name"=>($user->get_firstname() . " ".$user->get_lastname()),
                                "from_email"=>settings::get_from_email());
            
            $user_html_message = functions::renderTwigTemplate("email/register_user.html.twig", $user_params);
            $user_txt_message = functions::renderTwigTemplate("email/register_user.txt.twig", $user_params);
            $user_header = "From:".$from."\r\n";
            
            $emailer->set_to_emails($user_to);
            $user_retval = $emailer->send_email(FROM_EMAIL, $user_subject, $user_txt_message, $user_html_message);
    
        } else {
            echo('<div id="wrapper" style="width:500px">');
                echo("This email address has already been verified. Thank you for requesting membership approval to FADAMA. Your request is under review and may take up to 1 week to be approved.");
                echo("<BR><a href=../contact/index.php/>Contact</a> the administrator if you registered more than 48 hours ago.");
            echo("</div>");
        }
    } else {
        // Information incorrect
        echo('<div id="wrapper" style="width:500px">');
            echo("The information provided in the link is incorrect. Please check the link is valid, or contact the administration.");


        echo("</div>");
    }
        

    
} else {
    echo('<div id="wrapper" style="width:500px">');
    echo("There was an error in verifying this email. Please contact the administration if you are experiencing problems.");
    echo("</div>");
    
}

require_once "../include/footer.php";
   
