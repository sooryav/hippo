<?php

/**
 * MySqlDataFactory short summary.
 *
 * MySql Based implementation of Data Factory.
 *
 * @version 1.0
 * @author Seenu
 */

namespace DataAccessLayer;

class MySqlDataConnectionFactory implement IDataConnectionFactory
{
    public function GetSharedConnection()
    {
    	return new MySqlDataConnection();      
    }
    public function CreateConnection()
    {
    	return new MySqlDataConnection();    
    }
};

class MySqlDataConnection implements IDataConnection
{
	public function GetDataContext()
	{
		return DatabaseConnection::GetDataStoreContext("localhost","root","","hippo");  
	}
};

