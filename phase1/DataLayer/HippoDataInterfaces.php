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

abstract class ProviderType {
	const Restaurant = 1;
	const Photographer = 2;
	const Venue = 3;
	const ActivityProvider = 4;
};

interface IDataFactory {
    public function GetUserDataFactory(IDataConnectionFactory $connectionFactory);
    public function GetProviderDataFactory(IDataConnectionFactory $connectionFactory);
};

interface IUserDataFactory {
    public function GetUserByName($userName);
    public function AddUser(User $user);
    public function DeleteUserById($userId);
};

interface IProviderDataFactory {
    public function GetAllProviders($zipCode);
    public function GetAllProvidersByName($providerName);
    public function GetProvidersByType($zipcode, ProvideType $type);
    public function AddProvider(Provider $provider);
    public function DeleteProviderById($providerId);
};

