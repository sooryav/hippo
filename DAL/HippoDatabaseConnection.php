<?php

namespace DataAccessLayer;

class DatabaseConnection
{
    private $_host, $_user, $_password, $_database;
    
    private function __construct() 
    {    
    }

    public static function GetDataStoreContext($host, $user,$password,$database)
    {
        $obj = new DatabaseConnection();
        $obj->_host = $host;
        $obj->_user = $user;
        $obj->_password = $password;
        $obj->_database = $database;

        $mysqli = new \mysqli($host, $user, $password, $database);

        if($mysqli->connect_errno)
        {
            throw new \Exception("Error while connecting to MySql. Reason :: [$mysqli->connect_errno] + ",1000);
        }
        return $mysqli;        
    }

    public static function GetDataStoreContextUsingConfigFile($configFilePath)
    {
     //TODO: This will be done later      
    }
        
}

?>