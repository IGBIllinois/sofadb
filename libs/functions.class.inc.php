<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class functions {
    
    /** Creates a dropdown menu for methods, which creates a set
     * of additional input based on what is selected from it
     * 
     * @global type $db
     * @param type $drop_var
     */
    public static function drop_1_orig($drop_var)
    {  
        global $db;

            $methods = method::get_methods_by_type($db,$drop_var);

            echo '<script type=\"text/javascript\">
             $(function(){
            //$("#drop_X").multiselect();

            $("#drop_X").multiselect({
       multiple: false,
       header: "Select an option",
       noneSelectedText: "Select an Option",
       selectedList: 1
    });


    });</script>
      ';

            echo '<select name="drop_2" id="drop_2">
                  <option value="" disabled="disabled" selected="selected">Choose method</option>';


                    foreach($methods as $method) {
                        echo '<option value="'.$method->get_id().'">'.$method->get_name().'</option>';
                    }

            echo '</select>';

            echo "<script type=\"text/javascript\">
    $('#wait_2').hide();
            $('#drop_2').change(function(){
              $('#wait_2').show();
              $('#result_2').hide();
              $('#wait_3').hide();
            $('#result_3').hide();
            $('#drop_3').hide();
            $('#drop_4').hide();
            $('#fchoseninput').val('0');
            $('#pchoseninput').val('0');
          $.get(\"func.php\", {
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
    
    public static function drop_1($drop_var)
    {  
        global $db;

            $methods = method::get_methods_by_type($db,$drop_var);

            echo '<script type=\"text/javascript\">
             $(function(){
            //$("#drop_X").multiselect();

            $("#drop_X").multiselect({
       multiple: false,
       header: "Select an option",
       noneSelectedText: "Select an Option",
       selectedList: 1
    });


    });</script>
      ';

            echo '<select name="drop_2" id="drop_2">
                  <option value="" disabled="disabled" selected="selected">Choose method</option>';


                    foreach($methods as $method) {
                        echo '<option value="'.$method->get_id().'">'.$method->get_name().'</option>';
                    }

            echo '</select>';
            echo('&nbsp;<input type="submit" class="showybutton"  name="add_method" value="Save Method" /><BR>');
            
            echo "<script type=\"text/javascript\">
    $('#wait_2').hide();
            $('#drop_2').change(function(){
              $('#wait_2').show();
              $('#result_2').hide();
          $.get(\"index.php\", {
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
        $calc = hash('sha256', hex2bin($validator));

        // Validate tokens
        if ( hash_equals( $calc, $token ) )  {
            //$user = $this->user_exists($auth_token->email, 'email');
            if(member::member_exists($db, $email)) {
                $user = member::load_member_by_name($db, $email);
                if ( null === $user ) {
                    return array('RESULT'=>0,
                        'MESSAGE'=>'There was an error processing your request. Error Code: 003');
                }

                // Update password
                $result = $user->reset_password($new_pass);
                $update = $result['RESULT'];
            /*
            $update = $db->get_update_result('members', 
                array(
                    'password'  =>  password_hash($password, $new_pass),
                ), $user->ID
            );
*/
            // Delete any existing password reset AND remember me tokens for this user
            //$db->delete('password_reset', 'email', $user->email);
            //$db->delete('auth_tokens', 'username', $user->username);

            if ( $update == true ) {
                // New password. New session.
                //session_destroy();

                return array('RESULT'=>TRUE,
                    'MESSAGE'=>'Password updated successfully. <a href="../index.php">Login here</a>');
            } else {
                return $result;
            }
            }
        }

    }
    
    /**
     * 
     * @param type $options Array of $id->value elements ($id is the id of the method_info_option object, $value is the text displayed)
     * @param type $selected Array of selected ids
     * @param type $multiple True if multiselect, else false.
     * @return string
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
     * @param type $elementId Label for checkbox list
     * @param type $elementNumber
     * @param type $elementId2
     * @param type $list
     * @param type $checked_list
     * @return string
     */
       public static function checkbox_dropdown($elementId, $elementName, $list, $checked_list = array(), $select_name='select_option') {
       

        $elementName = "checkboxes_".urlencode($elementId);
        $divName = "checkbox_container_".urlencode($elementId);
        //$elementId = "checkboxes[".$output_name."][".urlencode($od2)."]";
        $ref_text = '<div class="multiselect table_full" >';
        $ref_text .= '<div class="selectBox" onclick="showCheckboxes('.$divName.')">';
        $ref_text .= "<select name=".$select_name."[$elementId][] class='table_full'>";
        $ref_text .= '<option selected diasbled>Select an option</option>';
        $ref_text .= '</select>';
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

        $ref_text .= "</div></div>";
        
        
        return $ref_text;
        


   }
}