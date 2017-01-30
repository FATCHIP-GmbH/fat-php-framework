<?php

namespace FatFramework;

class Language
{

    static function getTranslation($identifier, $sLang = false)
    {
        if (!$sLang) {
            $sLang = "En";
        }
        $sTranslatedString = $identifier . ' not found';

        $sLangLanguage = "Language" . $sLang;
        if (class_exists($sLangLanguage)){
            $oLanguage = new $sLangLanguage();
        }
        if (isset($oLanguage) && isset($oLanguage->$identifier)) {
            $sTranslatedString = $oLanguage->$identifier;
        } 
        
        return $sTranslatedString;
    }

}