<?php

namespace FatFramework;
use \PDO;

class MySqlConnection
{
    /**
     * @param $sDsn
     * @param $sUser
     * @param $sPassword
     *
     * @return PDO
     */
    static function connect($sDsn, $sUser, $sPassword)
    {
        try {
            $dbc = new PDO($sDsn, $sUser, $sPassword);
            $dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e)
        {
            $sMessage = 'MySQL Verbindung fehlgeschlagen: ' . $e->getMessage();
            echo $sMessage;
            Logger::logToFile($sMessage);
        }
        return $dbc;
    }
}
