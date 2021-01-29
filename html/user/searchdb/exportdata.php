<?php

 require_once('../../include/session.inc.php') ;
 set_time_limit ( 0 );
 
  if (isset($_POST['exportMy'])) {
      $unsubmitted = false;
      if(isset($_POST['unsubmitted'])) {
          $unsubmitted = $_POST['unsubmitted'];
      }
        $case_data = array("memberId"=>$_POST['mId']);

        $name=$_POST['name'];
        $email = $_POST['email'];

        $case_results = sofa_case::search_cases($db, null, $case_data, null, $unsubmitted);

        sofa_case::write_report($db, $case_results, $name, $email);
        die();
            
    } else
	  if (isset($_POST['exportsubmit']) || 
              isset($_POST['exportall'])) {
              
          $race_array = array();
          foreach($_POST['race'] as $race=>$value) {
              $race_array[$value] = $race;
          }
          $case_data = array(
              "memberId"=>$_POST['mID'],
              "caseYear"=>$_POST['cyear'],
              "yearRange"=>$_POST['yearrange'],
              "caseNumber"=>$_POST['cnum'],
              "caseAgency"=>$_POST['cagency'],
              "region"=>$_POST['region'],
              "idsex"=>$_POST['sexid'],
              "idage1"=>$_POST['ageid1'],
              "idage2"=>$_POST['ageid2'],
              "idageunits"=>$_POST['ageidunits'],
              "idstature1"=>$_POST['statureid1'],
              "idstature2"=>$_POST['statureid2'],
              "idstatureunits"=>$_POST['statureunits'],
              "race"=>$race_array,
              "est_sex"=>$_POST['est_sex'],
              "est_age"=>$_POST['est_age'],
              "est_stat"=>$_POST['est_stat'],
              "est_anc"=>$_POST['est_anc'],
              "conjunction"=>$_POST['andor'],
              "method_conj"=>$_POST['method_conj'],
              "race_join"=>$_POST['race_join'],
              "prac_join"=>$_POST['prac_join']
                  );
              $methods = ($_POST['method_select']);
             $method_list = array();
             foreach($methods as $index=>$result) {
                 foreach($result as $id=>$option) {
                     if($id != 0) {
                         $method_list[] = $id;
                     }
                 }
             }
             $name=$_POST['name'];
             $email = $_POST['email'];
             $unsubmitted = $_POST['unsubmitted'];
              $case_results = sofa_case::search_cases($db, null, $case_data, $method_list, $unsubmitted);

              sofa_case::write_report($db, $case_results, $name, $email);

	} else {
            // No export
        }

?>