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

require_once(__DIR__ . 'HippoDataInterfaces.php');

/**
* Class representing a user. 
* User is represented by user id which is unique in the system and internal to the system.
* User name would be the email address for the user. This is exposes to the user.
* User Token is the login OAuth token associated with the user. This could be password temporarily.
*/

class User {

    private string $_userName;
    private int $_userId;
    private string $_password;
    private ActivationToken $_activationToken;
    private string $_userToken;

	public function GetUserName() {return $_userName;}
	public function GetUserId() {return $_userId;}
	public function GetUserToken() {return $_userToken;}
	public function GetPassword() {return $_password;}
	public function GetActivationToken() {return $_activationToken.GetToken();}
};

class ActivationToken {
    private int $_id;
    private string $_token;
    private string $_expiryTime;

	public function GetToken() {return $_token;}
	public function GetExpiryTime() {return $_expiryTime;}
};

class Address extends IAddress {
    private int $_id;
    private string $_addressLine1;
    private string $_addressLine2;
    private string $_city;
    private string $_state;
    private string $_zipCode;

    public function GetAddressLine1() {return $_addressLine1;}
    public function GetAddressLine2() {return $_addressLine2;}
    public function GetCity() {return $_city;}
    public function GetState() {return $_state;}
    public function GetZipcode() {return $_zipCode;}
};

class ContactInfo extends IContactInfo {
    private int $_id;
    private string $_homePhoneNumber;
    private string $_mobilePhoneNumber;
    private string $_primaryEmailAddress;
    private string $_secondaryEmailAddress;

    public function GetHomePhoneNumber() {return $_homePhoneNumber;}
    public function GetMobilePhoneNumber() {return $_mobilePhoneNumber;}
    public function GetPrimaryEmailAddress() {return $_primaryEmailAddress;}
    public function GetSecondaryEmailAddress() {return $_secondaryEmailAddress;}
}

class Vendor implements IVendor {
    private string $_vendorName;
    private int $_id;
    private IAddress $_address;
    private IContactInfo $_contactInfo;
    private ProvideType $_type;

	public function GetVendorName() {return $_vendorName;}
	public function GetAddress() {return $_address;}
	public function GetProviderType() {return $_type;}
	public function GetContactInfo() {return $_contactInfo;}
};

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
    
    public function AddVendor(IVendor $vendor) {

    }
};

