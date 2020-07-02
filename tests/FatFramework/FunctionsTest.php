<?php

namespace FatFramework;


class FunctionsTest extends \PHPUnit\Framework\TestCase
{

    public function testFormatCreditCardNum()
    {
        $s16DigitNum = "1234567890123456";
        $sFormattedNum = Functions::formatCreditCardNum($s16DigitNum);
        $this->assertEquals('1234 5678 9012 3456', $sFormattedNum);
    }

    public function testFormatMysqlDate()
    {
        $sDateEn = "2001-12-24";
        $sDateDe = Functions::formatMysqlDate($sDateEn);
        $this->assertEquals('24.12.2001', $sDateDe);
    }

    public function testGetRequestParameter()
    {
    	// Test string parameter
        $_REQUEST['foo'] = 'bar';
        $foo = Functions::getRequestParameter('foo');
        $this->assertEquals('bar', $foo);

	    // Test array parameter
	    $_REQUEST['aData'] = ['foo','bar'];
	    $foo = Functions::getRequestParameter('aData');
	    $this->assertEquals('foo', $foo[0]);

	    // Test SQL injection string parameter
	    $_REQUEST['foo'] = 'ba"r';
	    $foo = Functions::getRequestParameter('foo');
	    $this->assertEquals('ba&quot;r', $foo);

	    // Test SQL injection array parameter
	    $_REQUEST['foo'] = ['ba"r', "fo'o"];
	    $foo = Functions::getRequestParameter('foo');
	    $this->assertEquals('ba&quot;r', $foo[0]);
	    $this->assertEquals('fo&#039;o', $foo[1]);
    }

    public function testIncludeDir()
    {
	    $sDir = dirname(__FILE__) . "/testIncludeDir/";
        mkdir($sDir);
        file_put_contents($sDir . "myTest.php", "<?php \n class myTest { \n public \$foo = 'bar'; \n } \n");
        Functions::includeDir($sDir);
        $oMyTest = new \myTest();
        $this->assertEquals('bar', $oMyTest->foo);
        unlink($sDir . "myTest.php");
        rmdir($sDir);
    }

    public function testReduceHtml()
    {
        $sHtml = " <html>   </html>  \n";
        $sReducedHtml = Functions::reduceHtml($sHtml);
        $this->assertEquals("<html>   </html>\n", $sReducedHtml);
    }
}
