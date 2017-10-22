-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2017 at 04:20 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `telegrambots`
--

-- --------------------------------------------------------

--
-- Table structure for table `bots`
--

CREATE TABLE `bots` (
  `Bot_ID` int(11) NOT NULL,
  `Token` varchar(100) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Description` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bots`
--

INSERT INTO `bots` (`Bot_ID`, `Token`, `Name`, `Description`) VALUES
(18, 'hjkhjkhj', 'hjkhjk', 'khjkj');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `Menu_ID` int(11) NOT NULL,
  `Bot_ID` int(11) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Description` longtext,
  `Is_Starter` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`Menu_ID`, `Bot_ID`, `Name`, `Description`, `Is_Starter`) VALUES
(31, 18, 'kjhkhjk', 'hjkhjkhjkhjk', 0),
(32, 18, 'kjhkhjkhjk', 'jhkhjkh', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sub_menus`
--

CREATE TABLE `sub_menus` (
  `Sub_Menu_ID` int(11) NOT NULL,
  `Menu_ID` int(11) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Replay` int(11) NOT NULL,
  `Content` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_menus`
--

INSERT INTO `sub_menus` (`Sub_Menu_ID`, `Menu_ID`, `Name`, `Replay`, `Content`) VALUES
(11, 31, 'll;lk;kl;', 31, 'lk;kl;kl;');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bots`
--
ALTER TABLE `bots`
  ADD PRIMARY KEY (`Bot_ID`),
  ADD UNIQUE KEY `Name` (`Name`),
  ADD UNIQUE KEY `Token` (`Token`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`Menu_ID`),
  ADD UNIQUE KEY `Name` (`Name`),
  ADD KEY `menus_ibfk_1` (`Bot_ID`);

--
-- Indexes for table `sub_menus`
--
ALTER TABLE `sub_menus`
  ADD PRIMARY KEY (`Sub_Menu_ID`),
  ADD UNIQUE KEY `Name` (`Name`),
  ADD KEY `sub_menus_ibfk_1` (`Menu_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bots`
--
ALTER TABLE `bots`
  MODIFY `Bot_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `Menu_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `sub_menus`
--
ALTER TABLE `sub_menus`
  MODIFY `Sub_Menu_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_ibfk_1` FOREIGN KEY (`Bot_ID`) REFERENCES `bots` (`Bot_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sub_menus`
--
ALTER TABLE `sub_menus`
  ADD CONSTRAINT `sub_menus_ibfk_1` FOREIGN KEY (`Menu_ID`) REFERENCES `menus` (`Menu_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
