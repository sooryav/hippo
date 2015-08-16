<?hh

namespace DataAccessLayer;


/**
* Class representing a user. 
* User is represented by user id which is unique in the system and public internal to the system.
* User name would be the email address for the user. This is exposes to the user.
* User Token is the login OAuth token associated with the user. This could be password temporarily.
*/

class User {
    public string $m_userName;
    public string $m_emailId;
    public ?int $m_userId;
    public string $m_password;
    public ?string $m_activationToken;
    public ?string $m_userToken;

    public function __construct(string $userName, string $password, string $emailId) {
        $this->m_userName = $userName;
        $this->m_password = $password;
        $this->m_emailId = $emailId;
    }
};

class ActivationToken {
    public ?int $m_id;
    public string $m_token;
    public string $m_expiryTime;

    public function __construct(string $token, string $expiryTime) {
        $this->m_token = $token;
        $this->m_expiryTime = $expiryTime;
    }
};

class Address {
    public ?int $m_id;
    public string $m_addressLine1;
    public string $m_addressLine2;
    public string $m_city;
    public string $m_state;
    public string $m_zipCode;

    public function __construct(string $addressLine1, string $addressLine2, string $city, string $state, string $zipCode) {
        $this->m_addressLine1 = $addressLine1;
        $this->m_addressLine2 = $addressLine2;
        $this->m_city = $city;
        $this->m_state = $state;
        $this->m_zipCode = $zipCode;
    }    
};

class ContactInfo  {
    public ?int $m_id;
    public string $m_homePhoneNumber;
    public string $m_mobilePhoneNumber;
    public string $m_primaryEmailAddress;
    public string $m_secondaryEmailAddress;

    public function __construct(string $homePhoneNumber, string $mobilePhoneNumber, string $primaryEmailAddress, string $secondaryEmailAddress) {
        $this->m_homePhoneNumber = $homePhoneNumber;
        $this->m_mobilePhoneNumber = $mobilePhoneNumber;
        $this->m_primaryEmailAddress = $primaryEmailAddress;
        $this->m_secondaryEmailAddress = $secondaryEmailAddress;
    }      
};

class Provider {
    public ?string $m_providerName;
    public ?int $m_providerId;
    public ?int $m_userId;
    public ?string $m_description;
    public ?string $m_zipCode;
    public ?Address $m_address;
    public ?ContactInfo $m_contactInfo;
    public ?ProvideType $m_type;

    public function __construct() {}

    public static function CreateProviderWithAllInfo(
        string $providerName,
        $providerId,
        $userId,
        $description,
        $zipCode,
        Address $address,
        ContactInfo $contactInfo,
        ProvideType $type) {
        $provider = new Provider();
        $provider->m_providerName = $providerName;
        $provider->m_providerId = $providerId;
        $provider->m_userId = $userId;
        $provider->m_description = $description;
        $provider->m_zipCode = $zipCode;
        $provider->m_address = $address;
        $provider->m_contactInfo = $contactInfo;
        $provider->m_type = $type; 
        return $provider;     
    }

    public static function CreateProvider(
        string $providerName,
        int $providerId,
        int $userId,
        string $description,
        string $zipCode) {

        $provider = new Provider();
        $provider->m_providerName = $providerName;
        $provider->m_providerId = $providerId;
        $provider->m_userId = $userId;
        $provider->m_description = $description;
        $provider->m_zipCode = $zipCode;
        return $provider;
    }
};
