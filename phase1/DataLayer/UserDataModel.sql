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
-- Database: hippo
--
CREATE database IF NOT EXISTS Hippo;

-- --------------------------------------------------------

--
-- Use Hippo DB
--
USE Hippo;

-- ---------------------------------------------------------

/* drop events table before users table due to foreign key constraint */
DROP TABLE IF EXISTS events;

DROP TABLE IF EXISTS permissions;

CREATE TABLE IF NOT EXISTS permissions (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

INSERT INTO permissions (id, name) VALUES
  (1, 'New Member'),
  (2, 'Administrator');


DROP TABLE IF EXISTS users;

CREATE TABLE IF NOT EXISTS users (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  user_name varchar(50) NOT NULL,
  display_name varchar(50) DEFAULT NULL,
  password varchar(225) NOT NULL,
  email varchar(150) NOT NULL,
  activation_token varchar(225) DEFAULT NULL,
  last_activation_request int(11) DEFAULT NULL,
  lost_password_request tinyint(1) DEFAULT NULL,
  active tinyint(1) DEFAULT NULL,
  title varchar(150) DEFAULT NULL,
  sign_up_stamp int(11) DEFAULT NULL,
  last_sign_in_stamp int(11) DEFAULT NULL,
  `Token` varbinary(256) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO users (
  id,
  user_name,
  display_name,
  password,
  email,
  activation_token,
  last_activation_request,
  lost_password_request,
  active,
  title,
  sign_up_stamp,
  last_sign_in_stamp
) VALUES (
  1,
  'username',
  'username',
  '90b31f6a62fcac60ed233805df09143b25be9608706e15430081a7794c6afddbc',
  'soorya@hippo.com',
  'e2196f5281ed3b399e5619ff35786117',
  1438752964,
  0,
  1,
  'NewMember',
  1438752964,
  1438752975
);


DROP TABLE IF EXISTS user_permission_matches;

CREATE TABLE IF NOT EXISTS user_permission_matches (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) NOT NULL,
  permission_id int(11) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;


INSERT INTO user_permission_matches (id, user_id, permission_id) VALUES
  (1, 1, 2);


DROP TABLE IF EXISTS configuration;

CREATE TABLE IF NOT EXISTS configuration (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(150) NOT NULL,
  value varchar(150) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;


INSERT INTO configuration (id, name, value) VALUES
  (1, 'website_name', 'UserCake'),
  (2, 'website_url', 'localhost/'),
  (3, 'email', 'noreply@ILoveUserCake.com'),
  (4, 'activation', 'false'),
  (5, 'resend_activation_threshold', '0'),
  (6, 'language', 'models/languages/en.php'),
  (7, 'template', 'models/site-templates/default.css');


DROP TABLE IF EXISTS pages;

CREATE TABLE IF NOT EXISTS pages (
  id int(11) NOT NULL AUTO_INCREMENT,
  page varchar(150) NOT NULL,
  private tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;


INSERT INTO pages (id, page, private) VALUES
  (1, 'account', 1),
  (2, 'activate-account', 0),
  (3, 'admin_configuration', 1),
  (4, 'admin_page', 1),
  (5, 'admin_pages', 1),
  (6, 'admin_permission', 1),
  (7, 'admin_permissions', 1),
  (8, 'admin_user', 1),
  (9, 'admin_users', 1),
  (10, 'forgot-password', 0),
  (11, 'index.php', 0),
  (12, 'left-nav', 0),
  (13, 'login', 0),
  (14, 'logout', 1),
  (15, 'register', 0),
  (16, 'resend-activation', 0),
  (17, 'user_settings', 1);


DROP TABLE IF EXISTS permission_page_matches;

CREATE TABLE IF NOT EXISTS permission_page_matches (
  id int(11) NOT NULL AUTO_INCREMENT,
  permission_id int(11) NOT NULL,
  page_id int(11) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;


INSERT INTO permission_page_matches (id, permission_id, page_id) VALUES
  (1, 1, 1),
  (2, 1, 14),
  (3, 1, 17),
  (4, 2, 1),
  (5, 2, 3),
  (6, 2, 4),
  (7, 2, 5),
  (8, 2, 6),
  (9, 2, 7),
  (10, 2, 8),
  (11, 2, 9),
  (12, 2, 14),
  (13, 2, 17);



CREATE TABLE IF NOT EXISTS events (
  EventId varchar(50) NOT NULL,
  ETag varchar(50) NOT NULL,
  Summary varchar(300) NOT NULL,
  Description varchar(500) NOT NULL,
  AddressId bigint(20) NOT NULL,
  StartTime date NOT NULL,
  EndTime date NULL,
  TimeZone varchar(50) NOT NULL,
  MaxAttendees int(11) NULL,
  OrganizerUserId int(11) NOT NULL,
  ColorId int(4) NULL,
  SendReminder tinyint(1) NOT NULL,
  ReminderMethod int(4) NOT NULL,
  ReminderTime int(4) NOT NULL,
  PRIMARY KEY (EventId),
  FOREIGN KEY(OrganizerUserId)
      REFERENCES users(Id),
  FOREIGN KEY(AddressId)
      REFERENCES provideraddress(AddressId)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


/*ALTER TABLE `events`
  ADD CONSTRAINT `FeatureId_FK` FOREIGN KEY (`AddressId`) REFERENCES `provideraddress` (`AddressId`) ON DELETE NO ACTION ON UPDATE NO ACTION;
/*
ALTER TABLE `events`
  ADD CONSTRAINT `FeatureId_FK` FOREIGN KEY (`OrganizerUserId`) REFERENCES `user` (`UserId`) ON DELETE NO ACTION ON UPDATE NO ACTION;
*/

INSERT INTO events (
  EventId,
  ETag,
  Summary,
  Description,
  AddressId,
  StartTime,
  EndTime,
  TimeZone,
  MaxAttendees,
  OrganizerUserId,
  ColorId,
  SendReminder,
  ReminderMethod,
  ReminderTime
) VALUES (
  'testeventid',
  'testetag',
  'testsummary',
  'testdesc',
  1,
  NOW(),
  NOW(),
  'testtimezone',
  10,
  1,
  1,
  1,
  0,
  30
);

