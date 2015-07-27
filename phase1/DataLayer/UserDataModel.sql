-
-- Use Hippo DB
--
USE Hippo;

-----------------------------------------------------------

--
-- Table structure for table `contact`
--
CREATE TABLE `User` (
  `UserId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `UserName` varchar(45) DEFAULT NULL,
  `Password` varchar(45) DEFAULT NULL,
  `Token` varbinary(256) DEFAULT NULL,
  `ActivationTokenId` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Dumping data for table `User`
--
INSERT INTO `Hippo`.`User`
(`UserName`, `Password`, `Token`, `ActivationTokenId`) VALUES
('HippoTestUser', '1234AbCd', '123456abcdef', '1'),
('HippoTestVendor', '1234AbCd', '123456abcdef', '2');
