<?php

namespace DataAccessLayer;

require_once(__DIR__ . '/IHippoDataProvider.php');
require_once(__DIR__ . '/HippoDatabaseConnection.php');

/**
 * HippoDataProvider short summary.
 *
 * HippoDataProvider description.
 *
 * @version 1.0
 * @author akhilj
 */
class HippoDataProvider implements IHippoDataProvider
{
    private $_dbContext;

    public function __construct()
    {
       $this->_dbContext = DatabaseConnection::GetDataStoreContext("localhost","root","","hippo");      
        
    }

    public static function SetDatabaseContext($dbContext)
    {
        if(!isset($dbContext))
        {
            throw new \Exception("DB Context needs to be defined.");
        }

        $obj = new HippoDataProvider();        
        $obj->_dbContext = $dbContext;
        return $obj;
    }
    
    public function GetVenuesbyZip($zipCode)
    {
        $query = sprintf("SELECT * FROM vendor WHERE zip='%s'", $zipCode);
        $result = $this->_dbContext->query($query);

        $myArray = array();
        
        while($row = $result->fetch_array(MYSQL_ASSOC)) {
            $myArray[] = $row;
        }

        $result->close();

        $jsonResponse =  json_encode($myArray);
        return $jsonResponse;
    }

    public function GetVenues($zipCode, $type)
    {
        if(!isset($zipCode) and !isset($zipCode))
        {
            throw new \Exception("Cannot get all venues. Please specify atleast one search option. Zip or Type");
        }
        
        unset($queryBuilderVariables);

        $queryBase = "SELECT * FROM `provider`  P
                                join provideraddress PA on P.AddressId = PA.AddressId
                                Join ProviderTypeMapping PTM on PTM.ProviderId = P.Id
                                join ProvideType PT on PT.ProviderTypeId = PTM.TypeId";

        if($zipCode)
        {
            $queryBuilderVariables[] = " PA.ZipCode = '$zipCode'";
        }

        if($type)
        {
            $queryBuilderVariables[] = " PTM.TypeId = '$type'";
        }

        if (!empty($queryBuilderVariables)) {
            $queryBase .= ' WHERE ' . implode(' AND ', $queryBuilderVariables);
        }

        
        $result = $this->_dbContext->query($queryBase);

        $myArray = array();
        
        while($row = $result->fetch_array(MYSQL_ASSOC)) {
            $myArray[] = $row;
        }

        $result->close();

        $jsonResponse =  json_encode($myArray);
        return $jsonResponse;
    }
   
    
}
