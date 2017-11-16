-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: godaddy
-- Generation Time: Nov 13, 2017 at 03:35 PM
-- Server version: 5.1.53
-- PHP Version: 5.3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `msm_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `msm_logininfo`
--
-- Creation: Nov 12, 2017 at 01:07 PM
-- Last update: Nov 12, 2017 at 01:07 PM
--

DROP TABLE IF EXISTS `msm_logininfo`;
CREATE TABLE IF NOT EXISTS `msm_logininfo` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `encrypted_password` varchar(500) NOT NULL,
  `logged_in_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `login_status` enum('YES','NO') NOT NULL DEFAULT 'NO',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1001 ;

-- --------------------------------------------------------

--
-- Table structure for table `msm_messages`
--
-- Creation: Nov 12, 2017 at 01:03 PM
-- Last update: Nov 13, 2017 at 01:04 PM
--

DROP TABLE IF EXISTS `msm_messages`;
CREATE TABLE IF NOT EXISTS `msm_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `picture` varchar(1023) NOT NULL,
  `message_status` enum('CREATED','DELIVERED','REMOVED') NOT NULL DEFAULT 'DELIVERED',
  `time_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_delivered` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1001 ;
