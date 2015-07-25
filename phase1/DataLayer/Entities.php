<?php

namespace DataAccessLayer;


/**
* Class representing a user. 
* User is represented by user id which is unique in the system and internal to the system.
* User name would be the email address for the user. This is exposes to the user.
* User Token is the login OAuth token associated with the user. This could be password temporarily.
*/

class User {

    public string $_userName;
    public int $_userId;
    public string $_password;
    public ActivationToken $_activationToken;
    public string $_userToken;

    public function GetUserName() {return $_userName;}
    public function GetUserId() {return $_userId;}
    public function GetUserToken() {return $_userToken;}
    public function GetPassword() {return $_password;}
    public function GetActivationToken() {return $_activationToken.GetToken();}
};

class ActivationToken {
    public int $_id;
    public string $_token;
    public string $_expiryTime;

	public function GetToken() {return $_token;}
	public function GetExpiryTime() {return $_expiryTime;}
};

class Address {
    public int $_id;
    public string $_addressLine1;
    public string $_addressLine2;
    public string $_city;
    public string $_state;
    public string $_zipCode;

    public function GetAddressLine1() {return $_addressLine1;}
    public function GetAddressLine2() {return $_addressLine2;}
    public function GetCity() {return $_city;}
    public function GetState() {return $_state;}
    public function GetZipcode() {return $_zipCode;}
};

class ContactInfo  {
    public int $_id;
    public string $_homePhoneNumber;
    public string $_mobilePhoneNumber;
    public string $_primaryEmailAddress;
    public string $_secondaryEmailAddress;

    public function GetHomePhoneNumber() {return $_homePhoneNumber;}
    public function GetMobilePhoneNumber() {return $_mobilePhoneNumber;}
    public function GetPrimaryEmailAddress() {return $_primaryEmailAddress;}
    public function GetSecondaryEmailAddress() {return $_secondaryEmailAddress;}
}

class Vendor implements IVendor {
    public string $_vendorName;
    public int $_id;
    public IAddress $_address;
    public IContactInfo $_contactInfo;
    public ProvideType $_type;

	public function GetVendorName() {return $_vendorName;}
	public function GetAddress() {return $_address;}
	public function GetProviderType() {return $_type;}
	public function GetContactInfo() {return $_contactInfo;}
};
