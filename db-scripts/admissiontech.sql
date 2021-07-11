-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2021 at 08:23 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `admissiontech`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_details`
--

CREATE TABLE `academic_details` (
  `id` int(100) NOT NULL,
  `registrationNo` varchar(500) NOT NULL,
  `academicDetails` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `advanced_details`
--

CREATE TABLE `advanced_details` (
  `id` int(100) NOT NULL,
  `registrationNo` varchar(500) NOT NULL,
  `fatherName` varchar(500) NULL,
  `motherName` varchar(500) NULL,
  `parentsOccupation` varchar(1000) NULL,
  `guardianName` varchar(500) NULL,
  `relationOfApplicant` varchar(500) NULL,
  `houseNo` varchar(500) NULL,
  `street` varchar(1000) NULL,
  `pincode` varchar(100) NULL,
  `postOffice` varchar(1000) NULL,
  `state` varchar(500) NULL,
  `city` varchar(500) NULL,
  `cHouseNo` varchar(500) NULL,
  `cStreet` varchar(1000) NULL,
  `cPincode` varchar(100) NULL,
  `cPostOffice` varchar(1000) NULL,
  `cState` varchar(500) NULL,
  `cCity` varchar(500) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `basic_details`
--

CREATE TABLE `basic_details` (
  `id` int(100) NOT NULL,
  `registrationNo` varchar(500) NOT NULL,
  `faculty` varchar(500) NULL,
  `courseType` varchar(500) NULL,
  `course` varchar(500) NULL,
  `vaccinated` varchar(100) NULL,
  `nameTitle` varchar(100) NULL,
  `name` varchar(500) NULL,
  `dob` varchar(500) NULL,
  `gender` varchar(500) NULL,
  `religion` varchar(500) NULL,
  `caste` varchar(500) NULL,
  `category` varchar(500) NULL,
  `subCategory` varchar(500) NULL,
  `categoryCertificate` varchar(500) NULL,
  `subCategoryCertificate` varchar(500) NULL,
  `personalMobile` varchar(500) NULL,
  `parentMobile` varchar(500) NULL,
  `aadharNo` varchar(500) NULL,
  `email` varchar(500) NULL,
  `mediumOfInstitution` varchar(500) NULL,
  `photo` varchar(1000) NULL,
  `wrn` varchar(500) NULL,
  `form` varchar(1000) NULL,
  `signature` varchar(1000) NULL,
  `submitted` varchar(100) NULL,
  `payment` varchar(100) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(100) NOT NULL,
  `registrationNo` varchar(500) NOT NULL,
  `documents` varchar(10000) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `merit_details`
--

CREATE TABLE `merit_details` (
  `id` int(100) NOT NULL,
  `registrationNo` varchar(500) NOT NULL,
  `nationalCompetition` varchar(2000) NULL,
  `nationalCertificate` varchar(1000) NULL,
  `otherCompetition` varchar(2000) NULL,
  `otherCertificate` varchar(1000) NULL,
  `ncc` varchar(2000) NULL,
  `nccCertificate` varchar(1000) NULL,
  `freedomFighter` varchar(1000) NULL,
  `nationalSevaScheme` varchar(1000) NULL,
  `nssDocument` varchar(1000) NULL,
  `roverRanger` varchar(2000) NULL,
  `otherRoverRanger` varchar(1000) NULL,
  `rrDocument` varchar(1000) NULL,
  `bcom` varchar(1000) NULL,
  `other` varchar(2000) NULL,
  `totalMeritCount` varchar(500) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(100) NOT NULL,
  `registrationNo` varchar(100) NOT NULL,
  `payment_date` varchar(100) NOT NULL,
  `mode` varchar(100) NOT NULL,
  `amount` varchar(20) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users_info`
--

CREATE TABLE `users_info` (
  `id` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `active` varchar(10) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_info`
--

-- Indexes for table `academic_details`
--
ALTER TABLE `academic_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `advanced_details`
--
ALTER TABLE `advanced_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `basic_details`
--
ALTER TABLE `basic_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `merit_details`
--
ALTER TABLE `merit_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_info`
--
ALTER TABLE `users_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_details`
--
ALTER TABLE `academic_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `advanced_details`
--
ALTER TABLE `advanced_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `basic_details`
--
ALTER TABLE `basic_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `merit_details`
--
ALTER TABLE `merit_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
