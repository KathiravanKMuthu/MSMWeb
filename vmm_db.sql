-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 18, 2018 at 06:06 AM
-- Server version: 5.6.38
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `msm_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `msm_logininfo`
--

DROP TABLE IF EXISTS `msm_logininfo`;
CREATE TABLE `msm_logininfo` (
  `user_id` bigint(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `encrypted_password` varchar(500) NOT NULL,
  `logged_in_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `login_status` enum('YES','NO') NOT NULL DEFAULT 'NO'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `msm_messages`
--

DROP TABLE IF EXISTS `msm_messages`;
CREATE TABLE `msm_messages` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `picture` varchar(1023) DEFAULT NULL,
  `message_payload` varchar(2047) DEFAULT NULL,
  `message_type` enum('IMAGE','VIDEO','EVENT','') NOT NULL DEFAULT 'IMAGE',
  `message_status` enum('CREATED','DELIVERED','REMOVED') NOT NULL DEFAULT 'DELIVERED',
  `time_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_delivered` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


--
-- Indexes for dumped tables
--

--
-- Indexes for table `msm_logininfo`
--
ALTER TABLE `msm_logininfo`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `msm_messages`
--
ALTER TABLE `msm_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_type` (`message_type`),
  ADD KEY `message_status` (`message_status`),
  ADD KEY `message_status_2` (`message_status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `msm_logininfo`
--
ALTER TABLE `msm_logininfo`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1001;

--
-- AUTO_INCREMENT for table `msm_messages`
--
ALTER TABLE `msm_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1001;

