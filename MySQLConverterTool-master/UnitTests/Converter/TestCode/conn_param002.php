--TEST--
SUCCESS: mysqli_affected_rows(), default connection
--FILE--
<?php
/*
mysql_affected_rows -- Get number of affected rows in previous MySQL operation
Description
int mysql_affected_rows ( [resource link_identifier] )

Get the number of affected rows by the last INSERT, UPDATE or DELETE query associated with link_identifier.
Parameters

link_identifier

    The MySQL connection. If the link identifier is not specified, the last link opened by mysql_connect() is assumed. If no such link is found, it will try to create one as if mysql_connect() was called with no arguments. If by chance no connection is found or established, an E_WARNING level warning is generated.

Return Values

Returns the number of affected rows on success, and -1 if the last query failed.

If the last query was a DELETE query with no WHERE clause, all of the records will have been deleted from the table but this function will return zero with MySQL versions prior to 4.1.2.

When using UPDATE, MySQL will not update columns where the new value is the same as the old value. This creates the possibility that mysql_affected_rows() may not actually equal the number of rows matched, only the number of rows that were literally affected by the query.

The REPLACE statement first deletes the record with the same primary key and then inserts the new record. This function returns the number of deleted records plus the number of inserted records. 
require('MySQLConverterTool/UnitTests/Converter/TestCode/config.php');
*/
require('MySQLConverterTool/UnitTests/Converter/TestCode/config.php');

$con    = ($GLOBALS["___mysqli_ston"] = mysqli_connect($host,  $user,  $pass));
if (!$con) {
    printf("FAILURE: [%d] %s\n", ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
} else {
    print "SUCCESS: connect\n";
}

if (!((bool)mysqli_query( $con, "USE " . $db)))
   printf("FAILURE: [%d] %s\n", ((is_object($con)) ? mysqli_errno($con) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
   
if (!mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO nobody(id) VALUES (1)"))
    printf("FAILURE: [%d] %s\n", ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
$affected = mysqli_affected_rows($GLOBALS["___mysqli_ston"]);
if ($affected == 1) {
    print "SUCCESS: one row affected\n";
} else if ($affected > 0) {
    printf("FAILURE: one row should have been affected, %d reported\n", $affected);
} else if ($affected == -1) {
    printf("FAILURE: command failed, -1 returned\n");
}

((is_null($___mysqli_res = mysqli_close($con))) ? false : $___mysqli_res);
?>
--EXPECT-EXT/MYSQL-OUTPUT--
SUCCESS: connect
SUCCESS: one row affected

--EXPECT-EXT/MYSQL-PHP-ERRORS--
--EXPECT-EXT/MYSQLI-OUTPUT--
SUCCESS: connect
SUCCESS: one row affected

--EXPECT-EXT/MYSQLI-PHP-ERRORS--
--EXPECT-CONVERTER-ERRORS--
28, 30, 30, 35, 39, 39,
--ENDOFTEST--