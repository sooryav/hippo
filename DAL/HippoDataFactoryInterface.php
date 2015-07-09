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

interface IHippoDataFactory
{
    public function GetSharedConnection();
    public function CreateConnection();
};

