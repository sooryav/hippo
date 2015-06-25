-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2015 at 07:38 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hippo`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `Id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Firstname` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `PhoneNumber` varchar(100) NOT NULL,
  `CellNumber` varchar(100) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`Id`, `Firstname`, `LastName`, `PhoneNumber`, `CellNumber`) VALUES
(1, 'Akhil', 'Jindal', '4257897894', '4258974589'),
(2, 'Atul', 'Gupta', '5467782909', '8956989874');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `CountryCode` varchar(5) NOT NULL,
  `CountryName` varchar(100) NOT NULL,
  PRIMARY KEY (`CountryCode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`CountryCode`, `CountryName`) VALUES
('IND', 'India'),
('USA', 'United States of America');

-- --------------------------------------------------------

--
-- Table structure for table `provider`
--

CREATE TABLE IF NOT EXISTS `provider` (
  `Id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `AddressId` bigint(20) unsigned NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Description` text NOT NULL,
  `ContactId` bigint(20) unsigned NOT NULL,
  `ProviderFeatureId` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `ProviderFeatureId` (`ProviderFeatureId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `provider`
--

INSERT INTO `provider` (`Id`, `AddressId`, `Name`, `Description`, `ContactId`, `ProviderFeatureId`) VALUES
(1, 1, 'Hyatt Regency', 'Set 5 blocks from Highway 405, this upscale high-rise hotel is 11.1 miles from downtown Seattle. \r\n\r\nModern, refined rooms feature flat-screen TVs, iPod docks, WiFi (fee), minifridges, and tea and coffeemaking facilities. Upgraded rooms offer floor-to-ceiling windows and/or mountain views, and club rooms provide access to a lounge with free WiFi and continental breakfast. Suites add separate living rooms with pull-out sofas.\r\n\r\nAmong several dining options are a Northwest restaurant, a casual brunch spot, a cocktail bar and a steakhouse with a piano bar. Amenities include a 24/7 fitness center, a heated indoor pool and 70,000 sq ft of event space.', 1, 1),
(2, 2, 'New Delhi Palace', 'Indian Restaurant', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `provideraddress`
--

CREATE TABLE IF NOT EXISTS `provideraddress` (
  `AddressId` bigint(20) NOT NULL AUTO_INCREMENT,
  `Address1` varchar(100) NOT NULL,
  `Address2` varchar(100) NOT NULL,
  `City` varchar(50) NOT NULL,
  `State` varchar(50) NOT NULL,
  `CountryCode` varchar(50) NOT NULL,
  `ZipCode` varchar(50) NOT NULL,
  `PnoneNumber` varchar(50) NOT NULL,
  `Latitude` float(10,6) NOT NULL DEFAULT '0.000000',
  `Longitude` float(10,6) NOT NULL DEFAULT '0.000000',
  PRIMARY KEY (`AddressId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `provideraddress`
--

INSERT INTO `provideraddress` (`AddressId`, `Address1`, `Address2`, `City`, `State`, `CountryCode`, `ZipCode`, `PnoneNumber`, `Latitude`, `Longitude`) VALUES
(1, '900 Bellevue Way NE', '', 'Bellevue', 'WA', 'USA', '98004', '425) 462-1234', 0.000000, 0.000000),
(2, '4125 N E 20th St', '', 'Bellevue', 'WA', 'USA', '98007', '4257836987', 0.000000, 0.000000);

-- --------------------------------------------------------

--
-- Table structure for table `providercontactmapping`
--

CREATE TABLE IF NOT EXISTS `providercontactmapping` (
  `ProviderId` bigint(20) unsigned NOT NULL,
  `ContactId` bigint(20) unsigned NOT NULL,
  `Id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `ProviderId` (`ProviderId`,`ContactId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `providerfeatures`
--

CREATE TABLE IF NOT EXISTS `providerfeatures` (
  `Id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `providerfeatures`
--

INSERT INTO `providerfeatures` (`Id`, `Name`) VALUES
(1, 'OutsideFoodAllowed'),
(2, 'IndoorOnly');

-- --------------------------------------------------------

--
-- Table structure for table `providertypemapping`
--

CREATE TABLE IF NOT EXISTS `providertypemapping` (
  `Id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ProviderId` bigint(20) unsigned NOT NULL,
  `TypeId` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `providertypemapping`
--

INSERT INTO `providertypemapping` (`Id`, `ProviderId`, `TypeId`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `provider_featuremapping`
--

CREATE TABLE IF NOT EXISTS `provider_featuremapping` (
  `Id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ProviderId` bigint(20) unsigned NOT NULL,
  `FeatureId` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `provider_featuremapping`
--

INSERT INTO `provider_featuremapping` (`Id`, `ProviderId`, `FeatureId`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `providetype`
--

CREATE TABLE IF NOT EXISTS `providetype` (
  `ProviderTypeId` int(11) NOT NULL AUTO_INCREMENT,
  `ProviderType` varchar(100) NOT NULL,
  PRIMARY KEY (`ProviderTypeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `providetype`
--

INSERT INTO `providetype` (`ProviderTypeId`, `ProviderType`) VALUES
(1, 'Venue'),
(2, 'Restaurant');

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE IF NOT EXISTS `vendor` (
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `business_name` varchar(100) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `address1` varchar(60) DEFAULT NULL,
  `address2` varchar(60) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `state` varchar(40) DEFAULT NULL,
  `zip` int(10) unsigned NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `category_id` smallint(6) DEFAULT NULL,
  `vendor_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`vendor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`first_name`, `last_name`, `business_name`, `email`, `address1`, `address2`, `city`, `state`, `zip`, `phone`, `category_id`, `vendor_id`) VALUES
('Atul', 'Gupta', 'Pani Poori Inc', 'atulgupta101@yahoo.com', '420 Roop Mahal', '', 'Kirkland', 'WA', 98034, '9709804003', 1, 1),
('Soorya', 'Tanikela', 'Chole Bhature Inc', 'soorya@soorya.com', '123 Some Address', '', 'Redmond', 'WA', 98052, '1234567890', 1, 2);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `provider`
--
ALTER TABLE `provider`
  ADD CONSTRAINT `FeatureId_FK` FOREIGN KEY (`ProviderFeatureId`) REFERENCES `providerfeatures` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `providercontactmapping`
--
ALTER TABLE `providercontactmapping`
  ADD CONSTRAINT `ProviderId_FK` FOREIGN KEY (`ProviderId`) REFERENCES `provider` (`Id`) ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
