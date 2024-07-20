-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2024 at 01:39 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `boatrental`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `accountType` varchar(11) NOT NULL,
  `licenseNumber` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `firstName`, `lastName`, `email`, `password`, `accountType`, `licenseNumber`) VALUES
(2, 'Lester', 'Mendoza', 'lstrmndz10@gmail.com', '$2y$10$31rSG4Hc4H5iBpTM//anqea48ltOKT6AQs8yi6kMmFQpKB22C8ILS', 'tourist', ''),
(3, 'Vincent', 'Baltazar', 'vb@gmail.com', '$2y$10$uMr6OsDfPg30sll2N2yHAeIzSl4/oreJyZluKiL5KfRkFEUWFMsGO', 'admin', '123456789'),
(4, 'lester', 'Mendoza', '12242412', '$2y$10$A6fCaOU3G1imWt4quQsQKuIzFP2SjNvaeEGDTg/jWtRpBlcuSJDDm', 'captain', '12242412'),
(5, 'jsahdasj', 'asdkasjj', 'asdfgh@gmail.com', '$2y$10$UntsejJgHupigDeJVkxrBucKHTIVynRIV198RIrF.gCvdKCBQzkmy', 'tourist', ''),
(6, 'vincent', 'baltazar', '09090909', '$2y$10$WpLDzSkHi4cdb6avh0WHZem4SbhpsDmMbXBnWywxpHxVNAWMWZAqm', 'captain', '09090909');

-- --------------------------------------------------------

--
-- Table structure for table `captains`
--

CREATE TABLE `captains` (
  `captainFirstName` varchar(255) NOT NULL,
  `captainLastName` varchar(255) NOT NULL,
  `profilePic` varchar(255) DEFAULT NULL,
  `licenseID` varchar(255) NOT NULL,
  `boatName` varchar(255) DEFAULT NULL,
  `boat` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`boat`)),
  `boatDescription` text DEFAULT NULL,
  `boatPrice` decimal(10,2) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `crewMembers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`crewMembers`)),
  `requirements` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`requirements`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `captains`
--

INSERT INTO `captains` (`captainFirstName`, `captainLastName`, `profilePic`, `licenseID`, `boatName`, `boat`, `boatDescription`, `boatPrice`, `capacity`, `crewMembers`, `requirements`) VALUES
('vincent', 'baltazar', 'PROFILE-6698f571960910.76442743.jpg', '09090909', 'pulgoso1', '[\"BOAT-6698f571965358.76427147.png\", \"BOAT-6698ca2771e803.76496130.jpg\"]', 'okay naman din', '10000.00', 30, '[\"me\",\"me\"]', '[\"REQ-6698f571969992.11682628.png\"]'),
('lester', 'Mendoza', 'PROFILE-6698ca2768baf2.72843449.png', '12242412', 'pulgoso', '[\"BOAT-6698ca2771e803.76496130.jpg\"]', 'okay naman', '21212.00', 25, '[\"choy\",\"luwe\"]', '[\"REQ-6698ca277285b5.84080349.png\"]');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `captains`
--
ALTER TABLE `captains`
  ADD PRIMARY KEY (`licenseID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
