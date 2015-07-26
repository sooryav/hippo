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

require_once(__DIR__ . '/Entities.php');

abstract class ProvideType {
	const Restaurant = 0;
	const Photographer = 1;
	const Venue = 2;
	const ActivityProvider = 3;
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
    public function GetUserByName($userName);
    public function AddUser(User $user);
    public function DeleteUserById($userId);
};

interface IVendorDataFactory {
    public function GetAllProviders($zipCode);
    public function GetProvidersByType($zipcode, ProvideType $type);
    public function AddVendor(Vendor $vendor);
};

