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
            //include_once('db.php');
            //include_once($_SERVER['DOCUMENT_ROOT'].'/mysqli_connect.php');
            //$result = mysqli_query($dbcon,"SELECT methodname,id FROM methods WHERE methodtypenum='$drop_var' Order by methodname ASC") 
            //or die(mysql_error());
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
    
    
}