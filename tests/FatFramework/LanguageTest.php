<?php

namespace FatFramework;


class LanguageTest extends \PHPUnit\Framework\TestCase
{
    public function testGetTranslation()
    {
        /*
         * Test translation not found
         */
        $sOrig = "nightmare";
        $sTarget = "nightmare not found";
        $sTranslation = Language::getTranslation($sOrig);
        $this->assertEquals($sTarget, $sTranslation);
    }
}
