<?php

/**
 * IHippoDataProvider short summary.
 *
 * IHippoDataProvider description.
 *
 * @version 1.0
 * @author Seenu
 */

namespace DataAccessLayer;

enum ProvideType {
	Restaurant,
	Photographer,
	Venue,
	ActivityProvider
};

/**
* Interface representing a user. 
* User is represented by user id which is unique in the system and internal to the system.
* User name would be the email address for the user. This is exposes to the user.
* User Token is the login OAuth token associated with the user. This could be password temporarily.
*/
interface IUser {
	public function GetUserName();
	public function GetUserId();
	public function GetUserToken();
	public function GetPassword();
	public function GetActivationToken();
};

interface IActivationToken {
	public function GetToken();
	public function GetExpiryTime();
};

interface IAddress {
	public function GetAddressLine1();
	public function GetAddressLine2();
	public function GetCity();
	public function GetState();
	public function GetZipcode();
};

interface IContactInfo {
	public function GetHomePhoneNumber();
	public function GetMobilePhoneNumber();
	public function GetPrimaryEmailAddress();
	public function GetSecondaryEmailAddress();
}

interface IVendor {
	public function GetVendorName();
	public function GetAddress();
	public function GetProviderType();
	public function GetContactInfo();
};

interface IDataFactory {
    public function GetUserDataFactory(IDataConnectionFactory $connectionFactory);
    public function GetVendorDataFactory(IDataConnectionFactory $connectionFactory);
};

interface IUserDataFactory {
    public function GetUserByName(string $userName);
    public function AddUser(IUser $user);
};

interface IVendorDataFactory {
    public function GetAllProviders(string $zipCode);
    public function GetProvidersByType(string $zipcode, ProvideType $type);
    public function AddVendor(IVendor $vendor);
};

