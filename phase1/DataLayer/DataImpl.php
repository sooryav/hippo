<?php

/**
 * DataAccessImpl.php short summary.
 *
 * Base implementation of Data access layer
 *
 * @version 1.0
 * @author Seenu
 */

namespace DataAccessLayer;

require_once(__DIR__ . '/HippoDataInterfaces.php');

class DataFactory implements IDataFactory {

    public function GetUserDataFactory(IDataConnectionFactory $connectionFactory) {
    	return new UserDataFactory($connectionFactory);
    }

    public function GetVendorDataFactory(IDataConnectionFactory $connectionFactory) {
    	return new VendorDataFactory($connectionFactory);
    }
};

class UserDataFactory implements IUserDataFactory {

	private $_dbContext;

    public function __construct(IDataConnectionFactory $connectionFactory) {
       $this->_dbContext = $connectionFactory.GetDataContext();      
        
    }

    public function GetUserByName(string $userName) {
    	$query = sprintf("SELECT * FROM Hippo.User where UserName = '%s'", $userName);
        $result = $this->_dbContext->query($query);

        $myArray = array();
        
        while($row = $result->fetch_array(MYSQL_ASSOC)) {
            $myArray[] = $row;
        }

        $result->close();
    }

    public function AddUser(User $user) {
    	$query = sprintf("INSERT INTO `Hippo`.`User`
						(`UserName`, `Password`, `Token`, `ActivationTokenId`) VALUES
						('%s', %s, %s, %s)", 
						$user.GetuserName(), 
						$user.GetPassword(), 
						$user.GetToken(), 
						$user.GetActivationToken().GetToken()
						);

        $result = $this->_dbContext->query($query);

        $result->close();
    }
};

class VendorDataFactory implements IVendorDataFactory {

	private $_dbContext;

    public function __construct(IDataConnectionFactory $connectionFactory) {
       $this->_dbContext = $connectionFactory.GetDataContext();      
        
    }

    public function GetAllProviders(string $zipCode) {
    	$query = sprintf("SELECT * FROM vendor WHERE zip='%s'", $zipCode);
        $result = $this->_dbContext->query($query);

        $myArray = array();
        
        while($row = $result->fetch_array(MYSQL_ASSOC)) {
            $myArray[] = $row;
        }

        $result->close();
    }

    public function GetProvidersByType(string $zipcode, ProvideType $type)  {
    	$query = sprintf("SELECT * FROM vendor WHERE type='%s' and zip=%s'", $type, $zipCode);
        $result = $this->_dbContext->query($query);

        $myArray = array();
        
        while($row = $result->fetch_array(MYSQL_ASSOC)) {
            $myArray[] = $row;
        }

        $result->close();

    }
    
    public function AddVendor(Vendor $vendor) {

    }
};

