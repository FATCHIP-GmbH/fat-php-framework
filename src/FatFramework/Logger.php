<?php

namespace FatFramework;

class Logger {

    /**
     * System is unusable.
     */
    const EMERGENCY = 'emergency';

    /**
     * Action must be taken immediately.
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     */
    const ALERT = 'alert';

    /**
     * Critical conditions.
     * Example: Application component unavailable, unexpected exception.
     */
    const CRITICAL = 'critical';

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     */
    const ERROR = 'error';

    /**
     * Exceptional occurrences that are not errors.
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     */
    const WARNING = 'warning';

    /**
     * Normal but significant events.
     */
    const NOTICE = 'notice';

    /**
     * Interesting events.
     * Example: User logs in, SQL logs.
     */
    const INFO = 'info';

    /**
     * Detailed debug information.
     */
    const DEBUG = 'debug';

    /**
     * Log a message to a sLogFilename in PHP's error_log directory.
     *
     * @param string $sLogMessage  The message to log
     * @param string $sLogFilename The filename to log to (optional)
     * @param string $sSeverity    The severity of the message (optional)
     *
     * @return void
     */
    public static function logToFile($sLogMessage, $sLogFilename = "default.log", $sSeverity = self::INFO) {
        $sPhpLogFile = ini_get('error_log');
        $sLogFilePath = dirname($sPhpLogFile);
        $sLogEntry = "[" . date("Y-m-d H:i:s") . " Europe/Berlin] " . $sSeverity . ": " . $sLogMessage . "\n";
        file_put_contents($sLogFilePath . $sLogFilename, $sLogEntry, FILE_APPEND);
    }

}
