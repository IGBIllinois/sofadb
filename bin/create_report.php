#!/usr/bin/env php
<?php

chdir(dirname(__FILE__));

$include_paths = array('../libs');
set_include_path(get_include_path() . ":" . implode(':',$include_paths));

require_once '../conf/settings.inc.php';
require_once '../html/include/main.inc.php';


//Command parameters
$output_command = "create_report.php - Generates report for all cases.\n";
$output_command .= "Usage: php create_report.php \n";
$output_command .= "	-o, --output		Output folder\n";
$output_command .= "	-h, --help 		Display help menu\n";

//Parameters
$shortopts = "h";
$shortopts .= "o";


$longopts = array(
	"help",
	"output"
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

	echo date('Y-m-d H:i:s') . ": Creating Full Report\n";
	$case_data = array();
        $method_list = array();
        $unsubmitted = null;
	$case_results = sofa_case::search_cases($db, $case_data, $method_list, $unsubmitted);
	$output_dir = "/var/www/sofadb/reports";
	try {
		$zip_file = sofa_case::write_full_report($db, $case_results, null, null,0,0,$output_dir);
		echo date('Y-m-d H:i:s') . ": Report created at " . $zip_file . "\n";
		exit();
	}
	catch (Exception $e) {
		echo date('Y-m-d H:i:s') . ":" . $e->getMessage() . "\n";
		exit(1);
	}

?>
