-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2021 at 04:17 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hp_reserved`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `custEmail` varchar(255) NOT NULL,
  `custName` varchar(40) NOT NULL,
  `custSurname` varchar(40) NOT NULL,
  `custAddress` varchar(100) NOT NULL,
  `custDateofBirth` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`custEmail`, `custName`, `custSurname`, `custAddress`, `custDateofBirth`) VALUES
('Shardin111@gmail.com', 'Matvei', 'Shardin', 'Monetpassage 23 - 11', '2003-04-25'),
('test@test.com', 'Eric', 'Koston', '2535A E 12th St, Los Angeles, CA 90021, USA', '1975-04-29');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `eventId` int(11) NOT NULL,
  `eventDate` date NOT NULL,
  `eventName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`eventId`, `eventDate`, `eventName`) VALUES
(1, '2021-04-20', 'St.Patricks Day');

-- --------------------------------------------------------

--
-- Table structure for table `guest`
--

CREATE TABLE `guest` (
  `guestId` int(11) NOT NULL,
  `guestName` varchar(50) NOT NULL,
  `guestSurname` varchar(50) NOT NULL,
  `guestDateofBirth` date NOT NULL,
  `guestGender` varchar(6) NOT NULL,
  `resId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guest`
--

INSERT INTO `guest` (`guestId`, `guestName`, `guestSurname`, `guestDateofBirth`, `guestGender`, `resId`) VALUES
(1, 'Sean', 'Malto', '1980-07-18', 'male', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `resId` int(11) NOT NULL,
  `custEmail` varchar(255) NOT NULL,
  `resNumberGuests` tinyint(20) NOT NULL,
  `resCheckIn` date NOT NULL,
  `resDuration` tinyint(8) NOT NULL,
  `resAddServices` varchar(255) NOT NULL,
  `eventId` int(11) NOT NULL,
  `resCottageType` varchar(7) NOT NULL,
  `resLocation` varchar(50) NOT NULL,
  `resPayment` varchar(50) NOT NULL,
  `resPrice` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`resId`, `custEmail`, `resNumberGuests`, `resCheckIn`, `resDuration`, `resAddServices`, `eventId`, `resCottageType`, `resLocation`, `resPayment`, `resPrice`) VALUES
(1, 'test@test.com', 2, '2022-02-14', 3, 'BBQ', 1, 'Brick', 'Netherlands, Emmen', 'PayPal', 1500);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`custEmail`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`eventId`);

--
-- Indexes for table `guest`
--
ALTER TABLE `guest`
  ADD PRIMARY KEY (`guestId`),
  ADD KEY `resId` (`resId`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`resId`),
  ADD KEY `custEmail` (`custEmail`),
  ADD KEY `eventId` (`eventId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `eventId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `guest`
--
ALTER TABLE `guest`
  MODIFY `guestId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `resId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `guest`
--
ALTER TABLE `guest`
  ADD CONSTRAINT `guest_ibfk_1` FOREIGN KEY (`resId`) REFERENCES `reservation` (`resId`);

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`custEmail`) REFERENCES `customer` (`custEmail`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`eventId`) REFERENCES `event` (`eventId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
