<?php
/**
 * inc/common.php
 * Determines what to include where, as far as db functions, page functions and configuration files
 * Code and Markup Copyright (c) Montana Banana
 */

if( preg_match("/inc/",$_SERVER['PHP_SELF']) || preg_match("/actions/",$_SERVER['PHP_SELF']) || preg_match("/xml/",$_SERVER['PHP_SELF']) ){
	$relative_path_to_files = '../';
} else {
	$relative_path_to_files = '';
}

require($relative_path_to_files.'inc/configuration.php');
require($relative_path_to_files.'inc/db_functions.php');
require($relative_path_to_files.'inc/global_functions.php');
require($relative_path_to_files.'inc/site_functions.php');

// eof
?>