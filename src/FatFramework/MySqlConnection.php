<?php

namespace FatFramework;

class MySqlConnection
{

    /**
     * establish connection to MySql database
     * @param type $sHost
     * @param type $sName
     * @param type $sUser
     * @param type $sPassword
     */
    static function connect($sHost, $sName, $sUser, $sPassword)
    {
        // connect to database
        $conn = @mysql_connect($sHost, $sUser, $sPassword);
        // select databes
        @mysql_select_db($sName, $conn);
        // throw error if error
        if ($conn != TRUE) {
            echo "MySQL connect error: " . mysql_error() . " !!" . PHP_EOL;
            die;
        }
    }

}
