-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2022 at 09:46 AM
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
('dan@mail.ru', 'Danil', 'Borstch', 'Chernyshevskogo 15', '2003-03-17'),
('example@gmail.com', 'Brad', 'Pitt', 'USA, Los Angeles', '1980-03-21'),
('johnsmith@gmail.com', 'John', 'Smith', 'Monetpassage 23 - 11', '1996-09-29'),
('mathew.shardin@student.nhlstenden.com', 'Mathew ', 'Shardin', 'Monetpassage 23 - 11', '2003-01-01'),
('Shardin111@gmail.com', 'Matvei', 'Shardin', 'Monetpassage 23 - 11', '2003-04-25'),
('shardin@mail.ru', 'Mathew', 'Shardin', 'Monetpassage 23 - 11', '2000-05-25'),
('test2@gmail.com', 'Mike', 'Mo', '137 Strathearn Pl, Simi Valley, CA 93065, United States', '1990-03-27'),
('test4@gmail.com', 'Elizabeth', 'McDonald', 'Example address - 18, 6709PP', '1998-07-14'),
('test5@rambler.com', 'Steve', 'Berra', 'Amsterdam, example st. 14 ', '1990-06-13'),
('test7@gmail.com', 'Luan', 'Oliviera', 'Sample address 45, USA, 78121', '1988-07-20'),
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
(1, '2021-04-20', 'St.Patricks Day'),
(2, '2022-02-09', 'Test event'),
(14, '2022-02-20', 'MJ Day');

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
(1, 'Sean', 'Malto', '1980-07-18', 'male', 1),
(2, 'Spencer', 'Barton', '1995-04-21', 'Male', 3),
(3, 'Ana', 'Smith', '1998-06-24', 'female', 10),
(4, 'Mathew', 'shardin', '2003-04-25', 'male', 11),
(5, 'John', 'Smith', '2021-12-09', 'male', 14),
(7, 'Test', 'Guest1', '2021-12-30', 'male', 19),
(8, 'Test', 'Guest2', '2015-03-17', 'female', 19);

-- --------------------------------------------------------

--
-- Table structure for table `hpstaff`
--

CREATE TABLE `hpstaff` (
  `userName` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `userType` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hpstaff`
--

INSERT INTO `hpstaff` (`userName`, `password`, `userType`) VALUES
('admin', '$2y$10$An8ZwTcwmP0I21kMGAEs4uxDUsTFF1/i9NIkJCnUskeKBq/ltW19q', 'admin'),
('test', '$2y$10$qBevkWzp4k2/14wdAw1OLujPXEiXfIegIwqfCEWMfDsvYMNVFDsAC', 'user');

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
  `eventId` int(11) DEFAULT NULL,
  `resCottageType` varchar(7) NOT NULL,
  `resLocation` varchar(50) NOT NULL,
  `resPayment` varchar(50) NOT NULL,
  `resPrice` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`resId`, `custEmail`, `resNumberGuests`, `resCheckIn`, `resDuration`, `resAddServices`, `eventId`, `resCottageType`, `resLocation`, `resPayment`, `resPrice`) VALUES
(1, 'test@test.com', 2, '2022-02-14', 3, 'BBQ', 1, 'Brick', 'Location 2', 'PayPal', 1500),
(3, 'example@gmail.com', 2, '2022-02-27', 4, 'NULL', NULL, 'Brick', 'Location 2', 'Paypal', 420),
(8, 'test2@gmail.com', 1, '2021-03-12', 5, '', NULL, 'Straw', 'Location 1', 'cash', 500),
(9, 'shardin@mail.ru', 1, '2021-12-16', 1, '', NULL, 'Bamboo', 'Location 2', 'ideal', 242),
(10, 'johnsmith@gmail.com', 2, '2022-05-13', 3, 'Extra Pillow', NULL, 'Bamboo', 'Location 2', 'card', 726),
(11, 'dan@mail.ru', 2, '2022-02-10', 3, 'Set of spices Champagne Bottle', NULL, 'Brick', 'Location 2', 'cash', 1107),
(13, 'Shardin111@gmail.com', 1, '2023-06-12', 1, '', NULL, 'Straw', 'Location 1', 'cash', 145),
(14, 'mathew.shardin@student.nhlstenden.com', 2, '2022-02-03', 6, ' Champagne Bottle', 2, 'Brick', 'Location 2', 'cash', 2196),
(15, 'Shardin111@gmail.com', 1, '2022-02-08', 2, '', 2, 'Straw', 'Location 1', 'cash', 242),
(17, 'test4@gmail.com', 1, '2022-03-04', 3, 'Birthday cake', NULL, 'Brick', 'Location 2', 'paypal', 1089),
(19, 'test7@gmail.com', 3, '2022-01-25', 3, '', NULL, 'Bamboo', 'Location 2', 'paypal', 363);

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
  ADD KEY `guest_ibfk_1` (`resId`);

--
-- Indexes for table `hpstaff`
--
ALTER TABLE `hpstaff`
  ADD PRIMARY KEY (`userName`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`resId`),
  ADD KEY `reservation_ibfk_1` (`custEmail`),
  ADD KEY `reservation_ibfk_2` (`eventId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `eventId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `guest`
--
ALTER TABLE `guest`
  MODIFY `guestId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `resId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `guest`
--
ALTER TABLE `guest`
  ADD CONSTRAINT `guest_ibfk_1` FOREIGN KEY (`resId`) REFERENCES `reservation` (`resId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`custEmail`) REFERENCES `customer` (`custEmail`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`eventId`) REFERENCES `event` (`eventId`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
