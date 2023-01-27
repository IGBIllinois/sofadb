#!/usr/bin/env php
<?php

chdir(dirname(__FILE__));

$include_paths = array('../libs');
set_include_path(get_include_path() . ":" . implode(':',$include_paths));

require_once __DIR__ . '/../conf/settings.inc.php';
require_once '../html/include/main.inc.php';

$output_dir = "";
$verbose = false;

//Command parameters
$output_command = "create_report.php - Generates report for all cases.\n";
$output_command .= "Usage: php create_report.php \n";
$output_command .= "	--output		Output folder\n";
$output_command .= "	--verbose               Verbose Output\n";
$output_command .= "	-h, --help 		Display help menu\n";
//Parameters
$shortopts = "h";


$longopts = array(
	"help",
	"output:",
	"verbose"
);

//If not run from command line
if (php_sapi_name() != 'cli') {
	exit("Error: This script can only be run from the command line.\n");
}
	$options = getopt($shortopts,$longopts);

	//verify options are specified correctly
	if (isset($options['h']) || isset($options['help'])) {
		echo $output_command;
		exit;
	}

	if (isset($options['verbose'])) {
		$verbose = true;
	}
	if (isset($options['output'])) {
		$output_dir = $options['output'];
		if (!file_exists($output_dir)) {
			$log->send_log("Directory " . $output_dir . " does not exist",\IGBIllinois\log::ERROR);
			exit(1);
		}
	}
	else {
		$log->send_log("Please specify an output folder with --output",\IGBIllinois\log::ERROR);
		exit(1);
	}
	$log->send_log("Creating Full Report",\IGBIllinois\log::NOTICE,$verbose);
	$case_data = array();
        $method_list = array();
        $unsubmitted = null;
	$case_results = sofa_case::search_cases($db, $case_data, $method_list, $unsubmitted);
	try {
		$zip_file = sofa_case::write_full_report($db, $case_results, null, null,0,0,$output_dir);
		$log->send_log("Report created at " . $zip_file,\IGBIllinois\log::NOTICE,$verbose);
		exit();
	}
	catch (Exception $e) {
		$log->send_log($e->getMessage(),\IGBIllinois\log::ERROR);
		exit(1);
	}

?>
