<?php

namespace FatFramework;


class LoggerTest extends \PHPUnit_Framework_TestCase
{
    public function testLogToFile()
    {
        $sTestMessage = "This is my testing text.";
        Logger::logToFile($sTestMessage,"default.log", Logger::NOTICE);
        $sPhpLogFile = ini_get('error_log');
        $sLogFilePath = dirname($sPhpLogFile);
        $sLogEntry = "[" . date("Y-m-d H:i:s") . " Europe/Berlin] notice: This is my testing text.\n";
        $sLog = file_get_contents($sLogFilePath . "default.log");
        $this->assertEquals($sLogEntry, $sLog);
    }
}
