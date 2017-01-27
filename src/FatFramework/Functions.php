<?php

namespace FatFramework;

class Functions
{
    /**
     * String Trasformer
     * Formats a 16-digit creditcard number into 4-digit-blocks
     * 
     * @param string $cc 16-digit creditcardnum
     * 
     * @return string 4-digit-block formatted creditcardnum
     */
    public static function formatCreditCardNum($cc) {
        $sDivider = ' ';
        $cc_length = strlen($cc);
        $newCreditCard = substr($cc, -4);

        for ($i = $cc_length - 5; $i >= 0; $i--) {
            if ((($i + 1) - $cc_length)%4 == 0) {
                $newCreditCard = $sDivider . $newCreditCard;
            }
            $newCreditCard = $cc[$i] . $newCreditCard;
        }

        return $newCreditCard;
    }
    
    /**
     * String Trasformer
     * Date string converter for dates loaded from database 
     * and shown in templates, mails etc.
     * 
     * @param string $sDate Date formated like 2000-12-24
     * 
     * @return string $sGermanDate Date formated like 24.12.2000
     */
    public static function formatMysqlDate($sDate)
    {
        $aD = explode("-", $sDate);
        $sGermanDate = sprintf("%02d.%02d.%04d", $aD[2], $aD[1], $aD[0]);
        return $sGermanDate;
    }
    
    /**
     * Get cleaned GET or POST parameters.
     * Avoid SQL-Injection etc.
     * 
     * @param string $sParam Parameter-name
     * 
     * @return string $sParamValue Parameter-value OR false
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
     * 
     * @return void
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
     * String Trasformer
     * Removes whitespace and empty lines from a html-source.
     * 
     * @param string $sHtml HTML sourcecode
     * 
     * @return string $sCleanedHtml Reduced HTML sourcecode
     */
    public static function reduceHtml($sHtml) {
        $sCleanedHtml = "";
        $aHtmlLines = explode("\n", $sHtml);
        foreach ($aHtmlLines as $sLine) {
            if (trim($sLine) != "") {
                $sCleanedHtml .= trim($sLine) . "\n";
            }
        }
        return $sCleanedHtml;
    }
}
