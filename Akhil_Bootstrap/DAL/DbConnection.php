<?php

class DatabaseConnection
{
    function ConnecttoDatabase($host, $user,$password,$database)
    {
        $mysqli = new mysqli($host, $user, $password, $database);
        return $mysqli;
    }
}

?>