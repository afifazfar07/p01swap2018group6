-- phpMyAdmin SQL Dump
-- version 4.7.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 11, 2018 at 03:26 PM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `SWAP`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_table`
--

CREATE TABLE `audit_table` (
  `auditid` int(11) NOT NULL,
  `dtime` datetime NOT NULL,
  `info` varchar(100) NOT NULL,
  `comments` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `itemtable`
--

CREATE TABLE `itemtable` (
  `itemid` varchar(11) NOT NULL,
  `itemp` double NOT NULL,
  `itemn` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `otp_expiry`
--

CREATE TABLE `otp_expiry` (
  `otpid` int(11) NOT NULL,
  `email` tinytext NOT NULL,
  `otp` varchar(300) NOT NULL,
  `is_expired` int(11) NOT NULL,
  `create_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `storetable`
--

CREATE TABLE `storetable` (
  `storeid` varchar(20) NOT NULL,
  `store_address` varchar(100) NOT NULL,
  `employee_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `usertable`
--

CREATE TABLE `usertable` (
  `userid` varchar(20) NOT NULL,
  `passwd` varchar(300) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usertable`
--

INSERT INTO `usertable` (`userid`, `passwd`, `name`, `email`) VALUES
('admin', '$2y$10$Mk/XMn7l.0ebg01lCx/hR.GmMYCw0ZyOusynDVOKSDM30gvqfnMdm', 'admin', ''),
('auditor', '$2y$10$aZiN5pLOn1Ys6DTm88jIee4rtsoWi8kLssXnQhczlkT6LqXXqpBNG', 'auditor', ''),
('store3', '$2y$10$1qfEk3WyB4wbW5ctoPH3HeT1e4q/sRrwGGWsAFrl/KdF4sGRXJqwG', 'hadmin', ''),
('user', '$2y$10$L17GBjO.uOP1Uec.7VUcre3JxFfHzmyFYlmyPuGAIo5qCMeaj9o0C', 'user', 'swaptestswap@sharklasers.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_table`
--
ALTER TABLE `audit_table`
  ADD PRIMARY KEY (`auditid`);

--
-- Indexes for table `itemtable`
--
ALTER TABLE `itemtable`
  ADD PRIMARY KEY (`itemid`);

--
-- Indexes for table `otp_expiry`
--
ALTER TABLE `otp_expiry`
  ADD PRIMARY KEY (`otpid`);

--
-- Indexes for table `storetable`
--
ALTER TABLE `storetable`
  ADD PRIMARY KEY (`storeid`);

--
-- Indexes for table `usertable`
--
ALTER TABLE `usertable`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_table`
--
ALTER TABLE `audit_table`
  MODIFY `auditid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=224;

--
-- AUTO_INCREMENT for table `otp_expiry`
--
ALTER TABLE `otp_expiry`
  MODIFY `otpid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
