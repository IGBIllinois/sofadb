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
                    'MESSAGE'=>'Password updated successfully. <a href="index.php">Login here</a>');
            } else {
                return $result;
            }
            }
        }

    }
}