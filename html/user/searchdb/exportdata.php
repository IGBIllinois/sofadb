<?php

require_once(__DIR__ . '/../../include/main.inc.php');
require_once(__DIR__ . '/../../include/session.inc.php') ;
set_time_limit ( 0 );

$zip_file = "";
if (isset($_POST['exportMy'])) {
	$unsubmitted = false;
	if(isset($_POST['unsubmitted'])) {
		$unsubmitted = $_POST['unsubmitted'];
	}
	$case_data = array("memberId"=>$_POST['mId']);

        $name=$_POST['name'];
        $email = $_POST['email'];

        $case_results = sofa_case::search_cases($db, $case_data, null, $unsubmitted);

	$zip_file = sofa_case::write_report($db, $case_results, $name, $email, false, true);
}
elseif (isset($_POST['exportsubmit'])) {
              
	$race_array = array();
	if (isset($_POST['race'])) {
		foreach($_POST['race'] as $race=>$value) {
			$race_array[$value] = $race;
		}
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

	$method_list = array();
	if (isset($_POST['method_select'])) {
		foreach($_POST['method_select'] as $index=>$result) {
			foreach($result as $id=>$option) {
				if($id != 0) {
					$method_list[] = $id;
				}
			}
		}
	}
	$name=$_POST['name'];
	$email = $_POST['email'];
	$unsubmitted = $_POST['unsubmitted'];
	$case_results = sofa_case::search_cases($db, $case_data, $method_list, $unsubmitted);
	$zip_file = sofa_case::write_report($db, $case_results, $name, $email);
} 

elseif (isset($_POST['exportall'])) {
	$report_dir = settings::get_report_dir();
	$zip_file = sofa_case::get_latest_full_report();
}

if (file_exists($zip_file)) {
	header("Content-type: application/zip");
	header("Content-Disposition: attachment; filename=" . basename($zip_file));
	header("Content-Type: application/zip");
	header("Content-Length: " . filesize($zip_file));
	header("Pragma: no-cache");
	header("Expires: 0");
	readfile($zip_file);
	unlink($zip_file);

}
?>
