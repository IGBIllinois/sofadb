<?php

 require_once('../../include/session.inc.php') ;
 
	  if (isset($_POST['exportsubmit'])|| isset($_POST['exportall']))
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
              "ageid1"=>$_GET['ageid1'],
              "ageid2"=>$_GET['ageid2'],
              "statureid1"=>$_GET['statureid1'],
              "statureid2"=>$_GET['statureid2'],
              "race"=>$race_array,
              "est_sex"=>$_GET['est_sex'],
              "est_age"=>$_GET['est_age'],
              "est_stat"=>$_GET['est_stat'],
              "est_anc"=>$_GET['est_anc'],
              "conjuction"=>$_GET['andor']
                  );
              
              $case_results = sofa_case::search_cases($db, null, $case_data);
              
              sofa_case::write_report($db, $case_results);
              die();
	
		  }




?>