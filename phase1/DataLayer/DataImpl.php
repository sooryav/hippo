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
       $this->_dbContext = $connectionFactory->GetSharedConnection()->GetDataContext();      
        
    }

    public function GetUserByName($userName) {
    	$query = sprintf("SELECT * FROM Hippo.User where UserName = '%s'", $userName);
        $result = $this->_dbContext->query($query);

        $myArray = array();
        
        while($row = $result->fetch_array(MYSQL_ASSOC)) {
            $myArray[] = $row;
        }

        $result->close();
        var_dump($myArray);

        $userArray = $myArray[0];

        $user = new User();
        $user->m_userName = $userArray["UserName"];
        $user->m_userId = $userArray["UserId"];
        $user->m_password = $userArray["Password"];
        $user->m_userToken = $userArray["Token"];
        $user->m_activationToken = $userArray["ActivationTokenId"];        
        return $user;
    }

    public function AddUser(User $user) {
    	$query = sprintf("INSERT INTO `Hippo`.`User`
						(`UserName`, `Password`, `Token`, `ActivationTokenId`) VALUES
						('%s', '%s', '%s', %s)", 
						$user->m_userName, 
						$user->m_password, 
						$user->m_userToken, 
						$user->m_activationToken
						);

        echo "Query: ";
        var_dump($query);

        $result = $this->_dbContext->query($query);

        echo "\nResult: ";
        var_dump($result);

        return $result;
    }
};

class VendorDataFactory implements IVendorDataFactory {

	private $_dbContext;

    public function __construct(IDataConnectionFactory $connectionFactory) {
       $this->_dbContext = $connectionFactory->GetDataContext();      
        
    }

    public function GetAllProviders($zipCode) {
    	$query = sprintf("SELECT * FROM vendor WHERE zip='%s'", $zipCode);
        $result = $this->_dbContext->query($query);

        $myArray = array();
        
        while($row = $result->fetch_array(MYSQL_ASSOC)) {
            $myArray[] = $row;
        }

        $result->close();
    }

    public function GetProvidersByType($zipcode, ProvideType $type)  {
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

