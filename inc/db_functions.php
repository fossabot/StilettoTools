<?php
/**
 * inc/db_functions.php
 * Sets up database connection
 * Code and Markup Copyright (c) Montana Banana
 */

$con = mysql_connect(DBHOST, DBUSER, DBPASS);
if(!$con){
	die('Could not connect: ' . mysql_error());
} else {
	mysql_select_db(DBNAME);
}

/*
$MYSQL_ERRNO = '';
$MYSQL_ERROR = '';

function mysql_db_connect(){
	//global DBHOST, DBUSER, DBPASS, DBNAME;
	global $MYSQL_ERRNO, $MYSQL_ERROR;

	$link_id = mysql_connect(DBHOST, DBUSER, DBPASS);
	if (!$link_id){
		$MYSQL_ERRNO = mysql_errno();
		$MYSQL_ERROR = "Could not connect to database";
		return 0;
	} else if (!mysql_select_db(DBNAME)){
		$MYSQL_ERRNO = mysql_errno();
		$MYSQL_ERROR = mysql_error();
		return 0;
	} else {
		return $link_id;
	}
}

function mysql_sql_error(){
	global $MYSQL_ERRNO, $MYSQL_ERROR;

	if (empty($MYSQL_ERROR)){
		$MYSQL_ERRNO = mysql_errno();
		$MYSQL_ERROR = mysql_error();
	}
	return "$MYSQL_ERRNO: $MYSQL_ERROR";
}

$link_id = mysql_db_connect(DBNAME);

$link_id = mysql_db_connect();
if (!$link_id) die(mysql_sql_error());
*/

?>