<?php

namespace FatFramework;


class ModelTest extends \PHPUnit\Framework\TestCase
{
    public function testAssign()
    {
        /*
         * Test array assignment
         */
        $aData = array('id' => '1000', 'name' => 'FATCHIP GmbH', 'email' => "kontakt@fatchip.de");
        $oModel = new Model();
        $oModel->assign($aData);
        $this->assertEquals('FATCHIP GmbH', $oModel->name);
    }

    public function testGetTableName()
    {
        $oModel = new Model();
        $sTableName = $oModel->getTableName();
        $this->assertEquals('default', $sTableName);
    }
}
