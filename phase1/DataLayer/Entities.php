<?php

namespace DataAccessLayer;


/**
* Class representing a user. 
* User is represented by user id which is unique in the system and public internal to the system.
* User name would be the email address for the user. This is exposes to the user.
* User Token is the login OAuth token associated with the user. This could be password temporarily.
*/

class User {
    public string $m_userName;
    public int $m_userId;
    public string $m_password;
    public ActivationToken $m_activationToken;
    public string $m_userToken;
};

class ActivationToken {
    public int $m_id;
    public string $m_token;
    public string $m_expiryTime;
};

class Address {
    public int $m_id;
    public string $m_addressLine1;
    public string $m_addressLine2;
    public string $m_city;
    public string $m_state;
    public string $m_zipCode;
};

class ContactInfo  {
    public int $m_id;
    public string $m_homePhoneNumber;
    public string $m_mobilePhoneNumber;
    public string $m_primaryEmailAddress;
    public string $m_secondaryEmailAddress;
};

class Provider {
    public string $m_providerName;
    public int $m_providerId;
    public int $m_userId;
    public string $m_description;
    public string $m_zipCode;
    public Address $m_address;
    public ContactInfo $m_contactInfo;
    public ProvideType $m_type;

    public function __construct() {}

    public static function CreateProviderWithAllInfo(
        $providerName,
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
        $providerName,
        $providerId,
        $userId,
        $description,
        $zipCode) {
        $provider = new Provider();
        $provider->m_providerName = $providerName;
        $provider->m_providerId = $providerId;
        $provider->m_userId = $userId;
        $provider->m_description = $description;
        $provider->m_zipCode = $zipCode;
        return $provider;
    }
};
