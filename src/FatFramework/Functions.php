<?php

namespace FatFramework;

class Functions
{

    /**
     * get GET or POST parameters
     * @param string $sParam
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
     * autoloads all php files in $directoryPath (not recursive)
     * auto include all files in given directory
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

}
