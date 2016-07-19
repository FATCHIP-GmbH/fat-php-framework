<?php

namespace FatFramework;

class Functions
{
    /**
     * Get GET or POST parameters.
     * 
     * @param string $sParam
     * 
     * @return string $sParamValue OR false
     */
    public static function getRequestParameter($sParam)
    {
        $sParamValue = false;

        if (isset($_REQUEST[$sParam])) {
            $sParamValue = $_REQUEST[$sParam];
        }

        if (is_string($sParamValue)) {
            $sParamValue = str_replace(
                    array('&', '<', '>', '"', "'", chr(0), '\\', "\n", "\r"), 
                    array('&amp;', '&lt;', '&gt;', '&quot;', '&#039;', '', '&#092;', '&#10;', '&#13;'), 
                    $sParamValue
                    );
        }

        return $sParamValue;
    }

    /**
     * Autoloads all php files in $directoryPath (not recursive)
     * auto include all files in given directory
     * 
     * @param string $directoryPath
     */
    public static function includeDir($directoryPath)
    {
        $aIncludeFiles = scandir($directoryPath);
        $i = 1;
        foreach ($aIncludeFiles AS $file) {
            if ($i >= 3 && !is_dir($directoryPath . $file) && substr($directoryPath . $file, -3, 3) == 'php') {
                include_once($directoryPath . $file);
            }
            $i++;
        }
    }
    
    /**
     * Date string converter for dates loaded from database and shown in templates, mails etc.
     * 
     * @param string $sDate Date formated like 2000-12-24
     * 
     * @return string $sGermanDate Date formated like 24.12.2000
     */
    public static function convertMysqlDate($sDate)
    {
        $aD = explode("-", $sDate);
        $sGermanDate = sprintf("%02d.%02d.%04d", $aD[2], $aD[1], $aD[0]);
        return $sGermanDate;
    }
}
