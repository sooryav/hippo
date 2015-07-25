<?php

namespace DataAccessLayer;


/**
* Class representing a user. 
* User is represented by user id which is unique in the system and internal to the system.
* User name would be the email address for the user. This is exposes to the user.
* User Token is the login OAuth token associated with the user. This could be password temporarily.
*/

class User {

    public string $m_userName;
    public int $m_userId;
    public string $m_password;
    public ActivationToken $m_activationToken;
    public string $m_userToken;

    public function GetUserName() {return $m_userName;}
    public function GetUserId() {return $m_userId;}
    public function GetUserToken() {return $m_userToken;}
    public function GetPassword() {return $m_password;}
    public function GetActivationToken() {return $m_activationToken.GetToken();}
};

class ActivationToken {
    public int $m_id;
    public string $m_token;
    public string $m_expiryTime;

	public function GetToken() {return $m_token;}
	public function GetExpiryTime() {return $m_expiryTime;}
};

class Address {
    public int $m_id;
    public string $m_addressLine1;
    public string $m_addressLine2;
    public string $m_city;
    public string $m_state;
    public string $m_zipCode;

    public function GetAddressLine1() {return $m_addressLine1;}
    public function GetAddressLine2() {return $m_addressLine2;}
    public function GetCity() {return $m_city;}
    public function GetState() {return $m_state;}
    public function GetZipcode() {return $m_zipCode;}
};

class ContactInfo  {
    public int $m_id;
    public string $m_homePhoneNumber;
    public string $m_mobilePhoneNumber;
    public string $m_primaryEmailAddress;
    public string $m_secondaryEmailAddress;

    public function GetHomePhoneNumber() {return $m_homePhoneNumber;}
    public function GetMobilePhoneNumber() {return $m_mobilePhoneNumber;}
    public function GetPrimaryEmailAddress() {return $m_primaryEmailAddress;}
    public function GetSecondaryEmailAddress() {return $m_secondaryEmailAddress;}
}

class Vendor implements IVendor {
    public string $m_vendorName;
    public int $m_id;
    public IAddress $m_address;
    public IContactInfo $m_contactInfo;
    public ProvideType $m_type;

	public function GetVendorName() {return $m_vendorName;}
	public function GetAddress() {return $m_address;}
	public function GetProviderType() {return $m_type;}
	public function GetContactInfo() {return $m_contactInfo;}
};
