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

