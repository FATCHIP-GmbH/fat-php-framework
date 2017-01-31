<?php

namespace FatFramework;


class RegistryTest extends \PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $myTestClass = new \stdClass();
        $myTestClass->myProperty = "FATCHIP";
        Registry::set('myTestClass', $myTestClass);

        $myTestResult = Registry::get('myTestClass');
        $this->assertEquals($myTestResult->myProperty, "FATCHIP");
    }

    public function testSet()
    {
        $myTestClass = new \stdClass();
        $myTestClass->myProperty = "FATCHIP";
        Registry::set('myTestClass', $myTestClass);

        $myTestResult = Registry::get('myTestClass');
        $this->assertEquals($myTestResult->myProperty, "FATCHIP");
    }
}
