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
  `sno` int(11) NOT NULL,
  `id` varchar(500) NOT NULL,
  `registrationNo` varchar(500) NOT NULL,
  `academicDetails` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `advanced_details`
--

CREATE TABLE `advanced_details` (
  `sno` int(11) NOT NULL,
  `id` varchar(500) NOT NULL,
  `registrationNo` varchar(500) NOT NULL,
  `fatherName` varchar(500) NOT NULL,
  `motherName` varchar(500) NOT NULL,
  `parentsOccupation` varchar(1000) NOT NULL,
  `guardianName` varchar(500) NOT NULL,
  `relationOfApplicant` varchar(500) NOT NULL,
  `houseNo` varchar(500) NOT NULL,
  `street` varchar(1000) NOT NULL,
  `pincode` varchar(100) NOT NULL,
  `postOffice` varchar(1000) NOT NULL,
  `state` varchar(500) NOT NULL,
  `city` varchar(500) NOT NULL,
  `cHouseNo` varchar(500) NOT NULL,
  `cStreet` varchar(1000) NOT NULL,
  `cPincode` varchar(100) NOT NULL,
  `cPostOffice` varchar(1000) NOT NULL,
  `cState` varchar(500) NOT NULL,
  `cCity` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `basic_details`
--

CREATE TABLE `basic_details` (
  `sno` int(11) NOT NULL,
  `id` varchar(100) NOT NULL,
  `registrationNo` varchar(500) NOT NULL,
  `faculty` varchar(500) NOT NULL,
  `courseType` varchar(500) NOT NULL,
  `course` varchar(500) NOT NULL,
  `vaccinated` varchar(100) NOT NULL,
  `nameTitle` varchar(100) NOT NULL,
  `name` varchar(500) NOT NULL,
  `dob` varchar(500) NOT NULL,
  `gender` varchar(500) NOT NULL,
  `religion` varchar(500) NOT NULL,
  `caste` varchar(500) NOT NULL,
  `category` varchar(500) NOT NULL,
  `subCategory` varchar(500) NOT NULL,
  `categoryCertificate` varchar(500) NOT NULL,
  `subCategoryCertificate` varchar(500) NOT NULL,
  `personalMobile` varchar(500) NOT NULL,
  `parentMobile` varchar(500) NOT NULL,
  `aadharNo` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL,
  `mediumOfInstitution` varchar(500) NOT NULL,
  `photo` varchar(1000) NOT NULL,
  `wrn` varchar(500) NOT NULL,
  `form` varchar(1000) NOT NULL,
  `signature` varchar(1000) NOT NULL,
  `submitted` varchar(100) NOT NULL,
  `payment` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `sno` int(11) NOT NULL,
  `id` varchar(500) NOT NULL,
  `registrationNo` varchar(500) NOT NULL,
  `documents` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `merit_details`
--

CREATE TABLE `merit_details` (
  `sno` int(11) NOT NULL,
  `id` varchar(500) NOT NULL,
  `registrationNo` varchar(500) NOT NULL,
  `nationalCompetition` varchar(2000) NOT NULL,
  `nationalCertificate` varchar(1000) NOT NULL,
  `otherCompetition` varchar(2000) NOT NULL,
  `otherCertificate` varchar(1000) NOT NULL,
  `ncc` varchar(2000) NOT NULL,
  `nccCertificate` varchar(1000) NOT NULL,
  `freedomFighter` varchar(1000) NOT NULL,
  `nationalSevaScheme` varchar(1000) NOT NULL,
  `nssDocument` varchar(1000) NOT NULL,
  `roverRanger` varchar(2000) NOT NULL,
  `otherRoverRanger` varchar(1000) NOT NULL,
  `rrDocument` varchar(1000) NOT NULL,
  `bcom` varchar(1000) NOT NULL,
  `other` varchar(2000) NOT NULL,
  `totalMeritCount` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `sno` int(11) NOT NULL,
  `id` varchar(500) NOT NULL,
  `registrationNo` varchar(500) NOT NULL,
  `payment_date` varchar(500) NOT NULL,
  `mode` varchar(500) NOT NULL,
  `amount` varchar(500) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `sno` int(11) NOT NULL,
  `student_id` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `age` varchar(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `creationTime` varchar(500) NOT NULL,
  `createdBy` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`sno`, `student_id`, `name`, `email`, `mobile`, `age`, `gender`, `creationTime`, `createdBy`) VALUES
(1, '60d9cbd007fb3', 'Krishna Wahi', 'krishnawahi69@gmail.com', '7351860421', '', '', '1624886224032', '60d9cbd007fb3');

-- --------------------------------------------------------

--
-- Table structure for table `users_info`
--

CREATE TABLE `users_info` (
  `sno` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `active` varchar(10) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_info`
--

INSERT INTO `users_info` (`sno`, `user_id`, `user_name`, `password`, `role`, `active`) VALUES
(1, '1111', 'admin', 'admin', 'ADMIN', '1'),
(2, '60d9cbd007fb3', 'krishna', 'krishna', 'STUDENT', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_details`
--
ALTER TABLE `academic_details`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `advanced_details`
--
ALTER TABLE `advanced_details`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `basic_details`
--
ALTER TABLE `basic_details`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `merit_details`
--
ALTER TABLE `merit_details`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `users_info`
--
ALTER TABLE `users_info`
  ADD PRIMARY KEY (`sno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_details`
--
ALTER TABLE `academic_details`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `advanced_details`
--
ALTER TABLE `advanced_details`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `basic_details`
--
ALTER TABLE `basic_details`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `merit_details`
--
ALTER TABLE `merit_details`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users_info`
--
ALTER TABLE `users_info`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
