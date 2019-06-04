<?php
// Call MySQLConverterTool_CreateDBTest::main() if this source file is executed directly.
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "MySQLConverterTool_CreateDBTest::main");
}

require_once "MySQLConverterTool/Converter.php";
require_once "MySQLConverterTool/UnitTests/Converter/ConverterTest.php";

/**
* UnitTests: real life tests, PHPUnit test of Function/CreateDB
*
* @category   Real-life UnitTests
* @package    MySQLConverterTool
* @author     Andrey Hristov <andrey@php.net>, Ulf Wendel <ulf.wendel@phpdoc.de>
* @copyright  1997-2006 The PHP Group
* @license    http://www.php.net/license/3_0.txt  PHP License 3.0
* @version    CVS: $Id:$, Release: @package_version@
* @link       http://www.mysql.com
* @since      Class available since Release 1.0
*/
class MySQLConverterTool_UnitTests_Converter_CreateDBTest extends MySQLConverterTool_UnitTests_Converter_ConverterTest {      
    
    public function testConvertFile() {
        
        
        $files = array( 'create_db001.php',
                        );
                        
        foreach ($files as $k => $file) {
            $file = dirname(__FILE__) . '/TestCode/' . $file;
            $test_spec = $this->parseTestFile($file);
            if ($err = $this->validateTestSpec($test_spec)) {
                $this->fail(sprintf("[%s]\n%s\n", $file, $err));
                return;
            }
            if ($err = $this->runTestSpec($test_spec)) {
                $this->fail(sprintf("[%s]\n%s\n", $file, $err));
                return;
            };
        }
        
    } 
    
    
}

// Call MySQLConverterTool_CreateDBTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == "MySQLConverterTool_CreateDBTest::main") {
    MySQLConverterTool_CreateDBTest::main();
}
?>