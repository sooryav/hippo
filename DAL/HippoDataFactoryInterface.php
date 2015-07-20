<?php

/**
 * HippoInterfaces short summary.
 *
 * IHippoDataProvider description.
 *
 * @version 1.0
 * @author Seenu
 */

namespace DataAccessLayer;

interface IDataConnectionFactory
{
    public function GetSharedConnection();
    public function CreateConnection();
};

interface IDataConnection
{
	public function GetDataContext();
};

