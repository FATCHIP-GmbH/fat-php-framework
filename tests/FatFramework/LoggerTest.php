<?php

namespace FatFramework;


class LoggerTest extends \PHPUnit_Framework_TestCase
{
    public function testLogToFile()
    {
        $sTestMessage = "This is my testing text.";
        Logger::logToFile($sTestMessage,"FatFramewokTest.log", Logger::NOTICE);
        $sPhpLogFile = ini_get('error_log');
        $sLogFilePath = dirname($sPhpLogFile);
        $sLogEntry = "[" . date("Y-m-d H:i:s") . " Europe/Berlin] notice: This is my testing text.\n";
        $sLog = file_get_contents($sLogFilePath . "FatFramewokTest.log");
        $this->assertEquals($sLogEntry, $sLog);
        unlink($sLogFilePath . "FatFramewokTest.log");
    }
}
