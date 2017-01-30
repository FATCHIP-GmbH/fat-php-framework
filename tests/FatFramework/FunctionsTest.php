<?php

namespace FatFramework;


class FunctionsTest extends \PHPUnit_Framework_TestCase
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
        $_REQUEST['foo'] = 'bar';
        $foo = Functions::getRequestParameter('foo');
        $this->assertEquals('bar', $foo);
    }

    public function testIncludeDir()
    {
        mkdir(dirname(__FILE__) . '/test');
        $sDir = dirname(__FILE__) . "/test/";
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
