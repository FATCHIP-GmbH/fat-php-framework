<?php

namespace FatFramework;

class MySqlConnection
{

    /**
     * establish connection to database
     */
    static function connect($projectConfiguration)
    {
        // connect to database
        $conn = @mysql_connect($projectConfiguration->databaseHost, $projectConfiguration->databaseUser, $projectConfiguration->databasePass);
        // select databes
        @mysql_select_db($projectConfiguration->databaseName, $conn);
        // throw error if error
        if ($conn != TRUE) {
            echo "Verbindungsfehler: " . mysql_error() . " !! Versuchen Sie es zu einem sp&auml;teren Zeitpunkt nochmals. Danke.";
            die;
        }
    }

}
