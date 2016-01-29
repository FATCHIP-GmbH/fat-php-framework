<?php

namespace FatFramework;

class Language
{

    static function getTranslation($identifier)
    {
        $sTranslatedString = $identifier . ' not found';
        $oLanguage = new FatFramework\Language();
        
        if (isset($oLanguage->$identifier)) {
            $sTranslatedString = $oLanguage->$identifier;
        } 
        
        return $sTranslatedString;
    }

}
