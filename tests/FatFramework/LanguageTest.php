<?php

namespace FatFramework;


class LanguageTest extends \PHPUnit\Framework\TestCase
{
    public function testGetTranslation()
    {
        // Test translation not found
        $sOrig = "nightmare";
        $sTarget = "nightmare not found";
        $sTranslation = Language::getTranslation($sOrig);
        $this->assertEquals($sTarget, $sTranslation);

        // Test successful translation
	    include_once (dirname(__FILE__, 2) . '/testdata/LanguageDe.php');
	    $sOrig = "DASHBOARD_TITLE";
	    $sTarget = "Fat Framework";
	    $sTranslation = Language::getTranslation($sOrig, 'De');
	    $this->assertEquals($sTarget, $sTranslation);
    }
}
