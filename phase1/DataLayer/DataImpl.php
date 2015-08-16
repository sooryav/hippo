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

    private IDataConnectionFactory $m_dataConnectionFactory = null;

    public function __construct(IDataConnectionFactory $connectionFactory) {
       $this->m_dataConnectionFactory = $connectionFactory;      
        
    }

    public function GetUserDataFactory() {
    	return new UserDataFactory($this->m_dataConnectionFactory);
    }

    public function GetProviderDataFactory() {
    	return new ProviderDataFactory($this->m_dataConnectionFactory);
    }
};

class UserDataFactory implements IUserDataFactory {

	private $_dbContext;

    public function __construct(IDataConnectionFactory $connectionFactory) {
       $this->_dbContext = $connectionFactory->GetSharedConnection()->GetDataContext();      
        
    }

    public function GetUserByName($userName) {
    	$query = "SELECT * FROM `Hippo`.`users` where `user_name` = '$userName'";
        $result = $this->_dbContext->query($query);

        if (!$result) {
            echo "Error executing query: $query. Result: $result" . $this->_dbContext->error;
            return null;
        }

        if ($result->num_rows == 0) {
            echo "No user found with user name: $userName\n";
            return null;
        }

        $myArray = array();
        
        while($row = $result->fetch_array(MYSQL_ASSOC)) {
            $myArray[] = $row;
        }

        $result->close();

        $userCount = count($myArray);

        if ($userCount == 0) {
            echo "No user found with user name: $userName\n";
            return null;
        }

        echo "Users found with user name: $userName. Count: $userCount\n";

        $userArray = $myArray[0];

        $user = new User($userArray["user_name"], $userArray["password"], $userArray["email"]);
        $user->m_userId = $userArray["id"];
        $user->m_userToken = $userArray["Token"];
        $user->m_activationToken = $userArray["activation_token"];        
        return $user;
    }

    public function AddUser(User $user) {
        echo "Enter: AddUser Method\n";

        if (!isset($user)) {
            echo "AddUser Method Error: User object not set\n";
            return false;
        }

        $existingUser = $this->GetUserByName($user->m_userName);

        if ($existingUser) {
            echo "User with username: $userName exists already"; 
            return false;
        }

    	$query = sprintf("INSERT INTO `Hippo`.`users`
						(`user_name`, `password`, `email`, `Token`, `activation_token`) VALUES
						('%s', '%s', '%s', '%s', '%s')", 
						$user->m_userName, 
						$user->m_password,
                        $user->m_emailId, 
						$user->m_userToken, 
						$user->m_activationToken
						);

        echo "Query: $query\n";

        $result = $this->_dbContext->query($query);

        if (!$result) {
            echo "Error executing query: $query. Result: $result" . $this->_dbContext->error;
            return null;
        }

        $resultString = $result ? 'true' : 'false';
        echo "Query Result: $resultString\n";

        return $result;
    }

    public function DeleteUserById($userId) {
        echo "Enter: DeleteUserById Method\n";

        if (!isset($userId)) {
            return false;
        }

        $query = sprintf("DELETE FROM `Hippo`.`users` WHERE `id`='%s'", $userId);

        echo "Query: $query\n";

        $result = $this->_dbContext->query($query);

        if (!$result) {
            echo "Error executing query: $query. Result: $result" . $this->_dbContext->error;
            return null;
        }
        
        $resultString = $result ? 'true' : 'false';
        echo "Query Result: $resultString\n";

        return $result;
    }
};

class ProviderDataFactory implements IProviderDataFactory {

	private $_dbContext;

    public function __construct(IDataConnectionFactory $connectionFactory) {
       $this->_dbContext = $connectionFactory->GetSharedConnection()->GetDataContext();      
        
    }

    private function GetAllProvidersInternal($query) {
        $result = $this->_dbContext->query($query);

        if (!$result) {
            echo "Error executing query: $query. Result: $result" . $this->_dbContext->error;
            return null;
        }

        if ($result->num_rows == 0) {
            return null;
        }

        $providerList = array();
        
        while($row = $result->fetch_array(MYSQL_ASSOC)) {
            $providerList[] = Provider::CreateProvider($row["Name"], 
                (int)$row["Id"], 
                (int)$row["UserId"], 
                $row["Description"], 
                $row["ZipCode"]
                );
        }

        $result->close();

        return $providerList; 
    }

    public function GetAllProvidersByName($providerName) {
        $query = sprintf("SELECT * FROM provider WHERE Name='%s'", $providerName);
        return $this->GetAllProvidersInternal($query);        
    }


    public function GetAllProviders($zipCode) {
    	$query = sprintf("SELECT * FROM provider WHERE ZipCode='%s'", $zipCode);
        return $this->GetAllProvidersInternal($query);        
    }

    public function GetProvidersByType($zipcode, ProvideType $type)  {
        if(!isset($zipCode) and !isset($zipCode))
        {
            throw new \Exception("Cannot get Providers. Please specify atleast one search option. Zip code or Provider Type");
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
        return GetAllProvidersInternal($query);        
    }
    
    public function AddProvider(Provider $provider) {
        if (!isset($provider)) {
            return false;
        }

        $addressId = NULL;

        if ($provider->m_address != null) {
            $addressId = $provider->$Address->$m_id;
        }

        $addressId = 'NULL';

        if ($provider->m_userId == null) {
            throw new \Exception("Cannot add Provider. Please specify user id");
        }

        if ($provider->m_providerName == null) {
            throw new \Exception("Cannot add Provider. Please specify provider name");
        }

        if ($provider->m_description == null) {
            throw new \Exception("Cannot add Provider. Please specify provider description.");
        }      

        if ($provider->m_zipCode == null) {
            throw new \Exception("Cannot add Provider. Please specify provider zip code.");
        }    

        $query = "INSERT INTO `Hippo`.`provider` (`UserId`, `AddressId`, `Name`, `Description`, `ZipCode`)
                VALUES ($provider->m_userId, $addressId, '$provider->m_providerName', '$provider->m_description', '$provider->m_zipCode');";

        echo "\nQuery: $query\n";

        $result = $this->_dbContext->query($query);

        if (!$result) {
            echo "Error executing query: $query. Result: $result" . $this->_dbContext->error;
            return $result;
        }

        echo "Added provider $provider->m_providerName\n";

        return $result;
    }

    public function DeleteProviderById($providerId) {
        if (!isset($providerId)) {
            return false;
        }

        $query = sprintf("DELETE FROM `Hippo`.`provider` WHERE `Id`='%s'", $providerId);

        echo "\nDelete Query: $query\n";

        $result = $this->_dbContext->query($query);

        $resultString = $result ? 'true' : 'false';
        echo "\nDeleted Query Result: $resultString\n";

        return $result;
    }
};

