--TEST--
SUCCESS: mysql_ping()
--FILE--
<?php
/*
mysql_ping

(PHP 4 >= 4.3.0, PHP 5)
mysql_ping -- Ping a server connection or reconnect if there is no connection
Description
bool mysql_ping ( [resource link_identifier] )

Checks whether or not the connection to the server is working. If it has gone down, an automatic reconnection is attempted. This function can be used by scripts that remain idle for a long while, to check whether or not the server has closed the connection and reconnect if necessary.
Parameters

link_identifier

    The MySQL connection. If the link identifier is not specified, the last link opened by mysql_connect() is assumed. If no such link is found, it will try to create one as if mysql_connect() was called with no arguments. If by chance no connection is found or established, an E_WARNING level warning is generated.

Return Values

Returns TRUE if the connection to the server MySQL server is working, otherwise FALSE. 

NOTE: DOCUMENTATION IS WRONG - returns NULL instead of FALSE
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

    
$ping_default   = mysqli_ping($GLOBALS["___mysqli_ston"]);
$ping_con       = mysqli_ping($con);
if ($ping_default != $ping_con)
    printf("FAILURE: different values returned for ping with specified and default connection\n");

if (!is_bool($ping_con))
    printf("FAILURE: boolean value expected, got %s value\n", gettype($ping_con));

$ping_con = mysqli_ping($illegal_link_identifier);
if (!is_null($ping_con))
    printf("FAILURE: NULL value expected because of illegal identifier, got %s value\n", gettype($ping_con));

if ($ping_con)
    printf("FAILURE: false expected\n");
    
    
((is_null($___mysqli_res = mysqli_close($con))) ? false : $___mysqli_res);
?>
--EXPECT-EXT/MYSQL-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQL-PHP-ERRORS--
--EXPECT-EXT/MYSQLI-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQLI-PHP-ERRORS--
45, E_NOTICE, Undefined variable: illegal_link_identifier
45, E_WARNING, mysqli_ping() expects parameter 1 to be mysqli, null given
--EXPECT-CONVERTER-ERRORS--
26, 28, 28, 33,
--ENDOFTEST--