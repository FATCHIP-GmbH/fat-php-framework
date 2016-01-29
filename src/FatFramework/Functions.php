<?php

namespace FatFramework;

class Functions
{

    public static function getRequestParameter($sParam)
    {
        $sParamValue = false;

//        // handle $_GET parameter
//        $sParamGetValue = filter_input(INPUT_GET, $sParam);
//        if ($sParamGetValue) {
//            $sParamValue = $sParamGetValue;
//        }
//
//        // handle $_POST parameter
//        if ($sParamValue === false) {
//            $sParamPostValue = filter_input(INPUT_POST, $sParam);
//            if ($sParamPostValue) {
//                $sParamValue = $sParamPostValue;
//            }
//        }
        
        if (isset($_REQUEST[$sParam])) {
            $sParamValue = $_REQUEST[$sParam];
        }
        
        return $sParamValue;
    }

    /**
     * auto include all files in given directory
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
