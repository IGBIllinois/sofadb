<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class functions {
    

    /** Creates a list of methods based on the method type selected (Age, Sex, etc.)
     * 
     * @global db $db The database object
     * @param int $drop_var The id of the selected type (Age, Sex, etc)
     * 
     * Outputs Javascript and HTML select box to show methods of the selected method type
     */
    public static function drop_1($drop_var)
    {  
        global $db;

            $methods = method::get_methods_by_type($db,$drop_var);
            echo '<script type=\"text/javascript\">
             $(function(){

            $("#drop_X").multiselect({
                multiple: false,
                header: "Select an option",
                noneSelectedText: "Select an Option",
                selectedList: 1
             });

            });</script>';

            echo '<select name="drop_2" id="drop_2">
                  <option value="" disabled="disabled" selected="selected">Choose method</option>';

                foreach($methods as $method) {
                    echo '<option value="'.$method->get_id().'">'.$method->get_name().'</option>';
                }

            echo '</select>';
            echo('&nbsp;<input type="submit" class="showybutton"  name="add_method" value="Save Method" />'.
                    ' (Don\'t see your method? <U><A target="blank" href="../../contact/index.php">Contact us.</A></U>)<BR>');
            
            // This javascript draws the method info on the page when selected from the dropdown menu
            echo "<script type=\"text/javascript\">
                    $('#wait_2').hide();
                    $('#drop_2').change(function(){
                    $('#wait_2').show();
                    $('#result_2').hide();
                    $.post(\"method_info.php\", {
                        func: \"show_method_info\",
                        method_id: $('#drop_2').val()
                        }, function(response){
                    $('#result_2').fadeOut();
                    setTimeout(\"finishAjax_tier_three('result_2', '\"+escape(response)+\"')\", 400);
                  });
                return false;
            });
    </script>";
    }
    
    /**
     * Resets a user's password from a password change page assigned to them
     * 
     * @param db $db The database object
     * @param string $selector Generated ID in password_reset table
     * @param string $validator URL Validator
     * @param type $new_pass New password string
     * @return array An array of the form (RESULT=>$result, MESSAGE=>$message) where
     *  $result is true or false, and $message is an output message
     */
    public static function reset_password($db, $selector, $validator, $new_pass) {
        // Get tokens
        $results = $db->get_query_result("SELECT * FROM password_reset WHERE selector = :selector AND expires >= :time", ['selector'=>$selector,'time'=>time()]);

        if ( empty( $results ) ) {
            return array('RESULT'=>FALSE,
                'MESSAGE'=>'There was an error processing your request. Error Code: 002');
        }

        $auth_token = $results[0];
        $token = $auth_token['token'];
        $email = $auth_token['email'];

        // Validate tokens
        if ( password_verify($validator, $token) )  {

            if(member::member_exists($db, $email)) {
                $user = member::load_member_by_name($db, $email);
                if ( null === $user ) {
                    return array('RESULT'=>0,
                        'MESSAGE'=>'There was an error processing your request.');
                } else {
                    
                }

                // Update password
                $result = $user->reset_password($new_pass);
                $update = $result['RESULT'];


            if ( $update == true ) {
                // New password. New session.

                return array('RESULT'=>TRUE,
                    'MESSAGE'=>'Password updated successfully. <BR><a href="../index.php">Login here</a>');
            } else {
                return $result;
            }
            }
        } else {
            return array('RESULT'=>0,
                        'MESSAGE'=>'There was an error processing your request.');
        }

    }
    
    /**
     * Creates HTML text for a select box
     * 
     * @param type $options Array of $id->value elements ($id is the id of the method_info_option object, $value is the text displayed)
     * @param type $selected Array of selected ids
     * @param type $multiple True if multiselect, else false.
     * @return HTML text for the select input box
     */
    public static function draw_select($options, $selected, $multiple, $default_option = null) {

        $result .= "<select ".( $multiple ? " multiple size='".count($options)."'" : " style='width:200px' " ) ." name='output_data[]' id='$select_id' >";
        if($default_option != null) {
            $result .= "<option value='' id='' name='' >$default_option</option>";
        }
        foreach($options as $id=>$value) {
            $result .= "<option value=$id id=$id name=$id ". (in_array($id, $selected) ? " selected " : "") .">$value</option>";
        }
        $result .="</select>";
        return $result;
            
    }
    
    /** Creates a dropdown list of checkboxes
     * 
     * @param int $elementId Label for checkbox list
     * @param string $elementName Name of the checkbox element (no longer used)
     * @param array $list Labels for each of the checkbox options
     * @param array $checked_list Array of true/false options telling which options are selected
     * @param string $select_name HTML attribute name for the select option. Defaults to 'select_option'.
     * $param string $alt_text Additional text to display after the select box. Usually used to denote if a checkbox already has selected items. Defaults to null. 
     * @return HTML for the checkbox dropdown option
     */
       public static function checkbox_dropdown($elementId, $elementName, $list, $checked_list = array(), $select_name='select_option', $alt_text = null) {
       

        $elementName = "checkboxes_".urlencode($elementId);
        $divName = "checkbox_container_".urlencode($elementId);

        $ref_text = '<div class="multiselect table_full" >';
        $ref_text .= '<div class="selectBox" onclick="showCheckboxes('.$divName.')">';
        $ref_text .= "<select name=".$select_name."[$elementId][]>";
        $ref_text .= '<option selected diasbled>Select an option</option>';
        $ref_text .= '</select>';
        if(count($checked_list) > 0 && $alt_text != null) {
            $ref_text .= " ". $alt_text;
        }
        $ref_text .= '<div id="checkbox_label" class="overSelect"></div>';
        $ref_text .= '</div>';
        $ref_text.= '<div class="checkboxes" id="'.$divName.'">';

        foreach($list as $list_item) {

            $id = $elementName ."[".$list_item[0]."]";
            $name = $list_item[1];
            
            $ref_text .= ("<label id='checkbox_label' for='$id'>");
            $curr_name = $select_name."[$elementId]"."[".$list_item[0]."]";
            $ref_text .= ("<input type='checkbox' id='$id' name='$curr_name'".(in_array($list_item[0], $checked_list)? " checked=1 " : "")." />$name</label>");
        }
        
        $ref_text .= "</div>";
        
        $ref_text .= "</div>";
        
        return $ref_text;
        


   }
   
   /** Updates the password_reset database with unique data so a user can safely change their password
    * 
    * @param db $db The database object
    * @param string $email The user's email/username
    * @param string $selector Generated ID for password_reset table
    * @param string $validator URL Validator. Will be hashed for security
    * @return type
    */
   public static function update_password_request($db, $email, $selector, $validator) {
       
       // Token expiration
        $expires = new DateTime('NOW');
        $expires->add(new DateInterval('PT24H')); // 24 hours

       $db->get_update_result("DELETE from password_reset where email=:email", 
        array("email"=>$email));

        // Insert reset token into database
        $insert = $db->get_insert_result("insert into password_reset (email, selector, token, expires) VALUES (:email, :selector, :token, :expires)",
            array(
                'email'     =>  $email,
                'selector'  =>  $selector, 
                'token'     =>  password_hash($validator, PASSWORD_DEFAULT),
                'expires'   =>  $expires->format('U'),
            ));
        
        return $insert;
   }
   
   /**
    * Renders text based on a Twig template, and returns the final text string
    * @param string $template
    * @param array  $context
    */
   public static function renderTwigTemplate($template, $context) {
       global $twig;
       try {
           $template = $twig->load($template);
           return $template->render($context);
       } catch (LoaderError $e) {
           echo $e->getMessage();
       } catch (RuntimeError $e) {
           echo $e->getMessage();
       } catch (SyntaxError $e) {
           echo $e->getMessage();
       }
   }
   
   /** Creates a report (.csv file) of names, emails, and dates of people
    *  who downloaded reports.
    * 
    * @param type $db The database object
    * @param type $date If given, only get records from on or after this date. If null, get all records
    */
   public static function download_data_report($db, $date = null) {
        header('Content-Type: text/csv; charset=utf-8');
        ob_end_clean();
        $today = date("m_d_Y_H_i_s");
        $filename='DownloadReport_'.$today.".csv";

        header("Content-type: application/octet-stream");
        header('Content-Disposition: attachment; filename='.$filename);

        $header1 = array("Name", "Email", "Download Date");

        $query = "SELECT * from downloads";
        $params = array();

        if($date != null) {
            $query .= " WHERE date >= :date";
            $params['date'] = $date;
        }

        $download_results = $db->get_query_result($query, $params);

         // create a file pointer connected to the output stream
         $output = fopen('php://output', 'w');
         fputcsv($output, $header1);

        foreach($download_results as $result) {
            $data = array($result['name'], $result['email'], $result['date']);
            fputcsv($output, $data);
        }

        fclose($output);

   }

   /** Gets an array of emails for users
    * 
    * @param type $db The database object
    * @param type $admin If true, get only admin emails, else get all emails
    * @return type
    */
   public function get_emails($db, $admin=0) {
       $query = "SELECT uname from members where permissionstatus ";
       if($admin === 0) {
           $query .= " != 0";
       } else {
           $query .= " = 2";
       }
       $result = $db->get_query_result($query);
       
       $return_result = array();
       foreach($result as $data) {
           $return_result[] = $data['uname'];
       }
       
       return $return_result;
   }
}