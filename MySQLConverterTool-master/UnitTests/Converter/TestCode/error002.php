--TEST--
SUCCESS: mysql_error()
--FILE--
<?php
/*
mysql_error

(PHP 3, PHP 4, PHP 5)
mysql_error -- Returns the text of the error message from previous MySQL operation
Description
string mysql_error ( [resource link_identifier] )

Returns the error text from the last MySQL function. Errors coming back from the MySQL database backend no longer issue warnings. Instead, use mysql_error() to retrieve the error text. Note that this function only returns the error text from the most recently executed MySQL function (not including mysql_error() and mysql_error()), so if you want to use it, make sure you check the value before calling another MySQL function.
Parameters

link_identifier

    The MySQL connection. If the link identifier is not specified, the last link opened by mysql_connect() is assumed. If no such link is found, it will try to create one as if mysql_connect() was called with no arguments. If by chance no connection is found or established, an E_WARNING level warning is generated.

Return Values

Returns the error text from the last MySQL function, or '' (empty string) if no error occurred. 
*/
require('MySQLConverterTool/UnitTests/Converter/TestCode/config.php');

$con    = ($GLOBALS["___mysqli_ston"] = mysqli_connect($host,  $user,  $pass));
if (!$con) {
    printf("FAILURE: [%d] %s\n", ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_errno($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_errno()) ? $___mysqli_res : false)), ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
} else {
    print "SUCCESS: connect\n";
}

$error = ((is_object($con)) ? mysqli_error($con) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false));
if (!is_string($error))
    printf("FAILURE: expecting string value, using regular connection, got %s\n", gettype($error));    
    
// should throw a warning    
$error = ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false));
if (!is_string($error))
    printf("FAILURE: expecting string value, using default connection, got %s\n", gettype($error));        
    
$error = ((is_object($illegal_link_identifier)) ? mysqli_error($illegal_link_identifier) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false));
if (!is_bool($error))
    printf("FAILURE: expecting boolean value, using illegal link identifier, got %s\n", gettype($error));

if ($error)
    printf("FAILURE: expecting false, using illegal link identifier, got %s\n", $error);     

((is_null($___mysqli_res = mysqli_close($con))) ? false : $___mysqli_res);
?>
--EXPECT-EXT/MYSQL-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQL-PHP-ERRORS--
--EXPECT-EXT/MYSQLI-OUTPUT--
SUCCESS: connect

--EXPECT-EXT/MYSQLI-PHP-ERRORS--
40, E_NOTICE, Undefined variable: illegal_link_identifier
--EXPECT-CONVERTER-ERRORS--
24, 26, 26, 36,
--ENDOFTEST--