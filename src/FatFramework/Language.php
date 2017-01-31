<?php

namespace FatFramework;

class Language
{
    /**
     * Translate a given identifier in the given language.
     * Requires an existing language class.
     *
     * @param string $sIdentifier
     * @param string $sLang
     *
     * @return string $sTranslatedString
     */
    public static function getTranslation($sIdentifier, $sLang = 'En')
    {
        $sTranslatedString = $sIdentifier . ' not found';

        $sLangLanguage = "Language" . $sLang;
        if (class_exists($sLangLanguage)){
            $oLanguage = new $sLangLanguage();
            if (isset($oLanguage->$sIdentifier)) {
                $sTranslatedString = $oLanguage->$sIdentifier;
            }
        }

        return $sTranslatedString;
    }

}