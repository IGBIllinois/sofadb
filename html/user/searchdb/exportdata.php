<?php

 require_once('../../include/session.inc.php') ;
  if (isset($_POST['exportMy'])) {
            $case_data = array("memberId"=>$_POST['mId']);

            $name=$_POST['name'];
            $email = $_POST['email'];
             
            $case_results = sofa_case::search_cases($db, null, $case_data, null);
              
            sofa_case::write_report($db, $case_results, $name, $email);
            die();
            
    } else
	  if (isset($_POST['exportsubmit']) || 
              isset($_POST['exportall'])
             )
	  {

          $race_array = array();
          foreach($_GET['race'] as $race=>$value) {
              $race_array[$value] = $race;
          }
          $case_data = array(
              "memberId"=>$_GET['mID'],
              "caseYear"=>$_GET['cyear'],
              "yearRange"=>$_GET['yearrange'],
              "caseNumber"=>$_GET['cnum'],
              "caseAgency"=>$_GET['cagency'],
              "region"=>$_GET['region'],
              "idsex"=>$_GET['sexid'],
              "idage1"=>$_GET['ageid1'],
              "idage2"=>$_GET['ageid2'],
              "statureid1"=>$_GET['statureid1'],
              "statureid2"=>$_GET['statureid2'],
              "race"=>$race_array,
              "est_sex"=>$_GET['est_sex'],
              "est_age"=>$_GET['est_age'],
              "est_stat"=>$_GET['est_stat'],
              "est_anc"=>$_GET['est_anc'],
              "conjunction"=>$_GET['andor'],
              "method_conj"=>$_GET['method_conj'],
              "race_join"=>$_GET['race_join'],
              "prac_join"=>$_GET['prac_join']
                  );
              $methods = ($_GET['method_select']);
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
              $case_results = sofa_case::search_cases($db, null, $case_data, $method_list);

              sofa_case::write_report($db, $case_results, $name, $email);

	} 

?>