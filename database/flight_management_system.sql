-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2024 at 11:00 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `flight_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `SurName` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `PhoneNumber` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ID`, `Name`, `SurName`, `Email`, `Password`, `PhoneNumber`) VALUES
(1, 'Will', 'Smith', 'smith12@gmail.com', '25d55ad283aa400af464c76d713c07ad', '+1234567890');

-- --------------------------------------------------------

--
-- Table structure for table `air_planes`
--

CREATE TABLE `air_planes` (
  `ID` int(11) NOT NULL,
  `SerNum` varchar(10) NOT NULL,
  `Manufacture` varchar(30) NOT NULL,
  `Model` varchar(20) NOT NULL,
  `Rating` int(11) NOT NULL,
  `Booked` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `air_planes`
--

INSERT INTO `air_planes` (`ID`, `SerNum`, `Manufacture`, `Model`, `Rating`, `Booked`) VALUES
(6, '100021', 'corolla airlines', 'RX-580', 5, 1),
(7, '100132', 'emirates', 'GTX-1080', 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `passengerid` int(11) NOT NULL,
  `flightnum` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `passengerid`, `flightnum`) VALUES
(19, 4, 1001),
(20, 35, 1001),
(21, 35, 1002);

-- --------------------------------------------------------

--
-- Table structure for table `flight`
--

CREATE TABLE `flight` (
  `flightnum` int(11) NOT NULL,
  `origin` varchar(50) NOT NULL,
  `Intermediate` varchar(100) NOT NULL,
  `dest` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `arr_time` time(6) NOT NULL,
  `dep_time` time(6) NOT NULL,
  `planeid` int(11) NOT NULL,
  `pilotid` int(11) NOT NULL,
  `crewmembers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`crewmembers`)),
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flight`
--

INSERT INTO `flight` (`flightnum`, `origin`, `Intermediate`, `dest`, `date`, `arr_time`, `dep_time`, `planeid`, `pilotid`, `crewmembers`, `status`) VALUES
(1001, 'pakistan', 'dubai', 'london', '2024-05-18', '01:20:00.000000', '17:20:00.000000', 100021, 100112, '[\"10011\",\"100232\"]', 'finished'),
(1002, 'london', 'dubai', 'karachi', '2024-05-17', '01:55:00.000000', '13:55:00.000000', 100021, 100112, '[\"10011\",\"100232\"]', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `passengers`
--

CREATE TABLE `passengers` (
  `ID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `SurName` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `PhoneNumber` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `passengers`
--

INSERT INTO `passengers` (`ID`, `Name`, `SurName`, `Email`, `Password`, `Address`, `PhoneNumber`) VALUES
(4, 'John', 'Alex', 'john12@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'London', '+123456789'),
(35, 'sikander', 'sikander malik', 'smalik01@gmail.com', '25d55ad283aa400af464c76d713c07ad', '212 block k', '03021142646');

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

CREATE TABLE `staffs` (
  `ID` int(11) NOT NULL,
  `EmpNum` varchar(10) NOT NULL,
  `SurName` varchar(50) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `PhoneNumber` varchar(20) NOT NULL,
  `Salary` varchar(20) NOT NULL,
  `Booked` tinyint(1) NOT NULL,
  `Designation` varchar(50) NOT NULL,
  `rating` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staffs`
--

INSERT INTO `staffs` (`ID`, `EmpNum`, `SurName`, `Name`, `Address`, `PhoneNumber`, `Salary`, `Booked`, `Designation`, `rating`) VALUES
(24, '10010', 'carl', 'carl johnson', 'new jersey street 9', '03021142646', '50000', 0, 'Pilot', '5'),
(25, '10011', 'jason', 'jason carl', 'new dehli, india', '03361673480', '30000', 1, 'Crew Member', 'N/A'),
(26, '100112', 'john', 'john carter', 'punjab, india', '21375429813', '80000', 1, 'Pilot', '5'),
(27, '100232', 'micheal', 'micheal jordan', 'america', '12541251253', '30000', 1, 'Crew Member', 'N/A');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `air_planes`
--
ALTER TABLE `air_planes`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `passengers`
--
ALTER TABLE `passengers`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `staffs`
--
ALTER TABLE `staffs`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `air_planes`
--
ALTER TABLE `air_planes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `passengers`
--
ALTER TABLE `passengers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `staffs`
--
ALTER TABLE `staffs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
