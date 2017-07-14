-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 11, 2017 at 11:12 AM
-- Server version: 5.7.18-0ubuntu0.17.04.1
-- PHP Version: 7.0.18-0ubuntu0.17.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `markers`
--

CREATE TABLE `markers` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `address` varchar(80) NOT NULL,
  `lat` float(10,6) NOT NULL,
  `lng` float(10,6) NOT NULL,
  `type` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `markers`
--

INSERT INTO `markers` (`id`, `name`, `address`, `lat`, `lng`, `type`) VALUES
(1, 'Love.Fish', '580 Darling Street, Rozelle, NSW', -33.861034, 151.171936, 'restaurant'),
(2, 'Young Henrys', '76 Wilford Street, Newtown, NSW', -33.898113, 151.174469, 'bar'),
(4, 'The Potting Shed', '7A, 2 Huntley Street, Alexandria, NSW', -33.910751, 151.194168, 'bar'),
(5, 'Nomad', '16 Foster Street, Surry Hills, NSW', -33.879917, 151.210449, 'bar'),
(6, 'Three Blue Ducks', '43 Macpherson Street, Bronte, NSW', -33.906357, 151.263763, 'restaurant'),
(7, 'Single Origin Roasters', '60-64 Reservoir Street, Surry Hills, NSW', -33.881123, 151.209656, 'restaurant');

-- --------------------------------------------------------

--
-- Table structure for table `Sites`
--

CREATE TABLE `Sites` (
  `SiteID` int(11) NOT NULL,
  `Lat` float NOT NULL,
  `Lng` float NOT NULL,
  `Pictures` text,
  `Description` text,
  `Stream` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Sites`
--

INSERT INTO `Sites` (`SiteID`, `Lat`, `Lng`, `Pictures`, `Description`, `Stream`) VALUES
(11111, 43.3844, -80.1517, NULL, '', 'Spencer Creek'),
(22222, 43.2416, -80.0012, NULL, '', 'Sulphur Creek'),
(33333, 43.185, -79.8098, NULL, '', 'Pottruff Spring'),
(44444, 43.2122, -79.7853, NULL, '', 'Felker Creek'),
(55555, 43.2397, -79.9598, NULL, '', 'Tiffany Creek'),
(66666, 43.2389, -79.9733, NULL, '', 'Ancaster Creek');

-- --------------------------------------------------------

--
-- Table structure for table `Testing`
--

CREATE TABLE `Testing` (
  `Name` varchar(256) DEFAULT NULL,
  `Email` text NOT NULL,
  `SiteID` int(11) NOT NULL,
  `Notes` text,
  `Affiliation` text NOT NULL,
  `TimeExtracted` int(11) NOT NULL,
  `DateCollected` date DEFAULT NULL,
  `DateDeployed` date DEFAULT NULL,
  `Habitat` varchar(256) NOT NULL,
  `RodLength` int(11) NOT NULL,
  `EntryNumber` int(64) NOT NULL,
  `BlueValue` int(11) DEFAULT NULL,
  `Chlorophyll` int(11) DEFAULT NULL,
  `Lat` float DEFAULT NULL,
  `Lng` float DEFAULT NULL,
  `SiteDescription` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Testing`
--

INSERT INTO `Testing` (`Name`, `Email`, `SiteID`, `Notes`, `Affiliation`, `TimeExtracted`, `DateCollected`, `DateDeployed`, `Habitat`, `RodLength`, `EntryNumber`, `BlueValue`, `Chlorophyll`, `Lat`, `Lng`, `SiteDescription`) VALUES
('Cameron', 'Parker@mcmaster.ca', 11111, '', 'Mac', 72, '2016-02-01', '2016-01-01', 'riffle', 5, 1, 50, 9, 43.3844, -80.1517, 'Cold, Eroded, Fast Flow'),
('Cameron', 'Parker@mcmaster.ca', 22222, '', 'McMaster', 72, '2016-02-01', '2016-01-01', 'pool', 5, 2, 50, 9, 43.2416, -80.0012, 'Cold, Eroded, Fast Flow'),
('Cameron', 'Parker@mcmaster.ca', 33333, '', 'McMaster', 72, '2016-02-01', '2016-01-01', 'pool', 5, 3, 50, 9, 43.185, -79.8098, 'Cold, Eroded, Fast Flow'),
('Cameron', 'Parker@mcmaster.ca', 44444, '', 'McMaster', 72, '2016-02-01', '2016-01-01', 'thalweg', 5, 4, 50, 9, 43.2122, -79.7853, 'Cold, Eroded, Fast Flow'),
('Cameron', 'Parker@mcmaster.ca', 55555, '', 'McMaster', 72, '2016-02-01', '2016-01-01', 'pool', 5, 5, 50, 9, 43.2397, -79.9598, 'Cold, Eroded, Fast Flow'),
('Cameron', 'Parker@mcmaster.ca', 66666, '', 'McMaster', 72, '2016-02-01', '2016-01-01', 'riffle', 5, 6, 50, 9, 43.2389, -79.9733, 'Cold, Eroded, Fast Flow'),
('Cameron', 'Parker@mcmaster.ca', 66666, '', 'McMaster', 72, '2016-02-01', '2016-01-01', 'riffle', 5, 7, 50, 9, 43.2389, -79.9733, 'Cold, Eroded, Fast Flow');

--
-- Triggers `Testing`
--
DELIMITER $$
CREATE TRIGGER `updateRow` BEFORE INSERT ON `Testing` FOR EACH ROW BEGIN
SET New.Lat = (Select Lat From Sites WHERE NEW.SiteID = siteID) , New.Lng = (Select Lng From Sites WHERE NEW.SiteID = siteID);
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `markers`
--
ALTER TABLE `markers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Sites`
--
ALTER TABLE `Sites`
  ADD PRIMARY KEY (`SiteID`),
  ADD UNIQUE KEY `Site ID` (`SiteID`);

--
-- Indexes for table `Testing`
--
ALTER TABLE `Testing`
  ADD PRIMARY KEY (`EntryNumber`),
  ADD UNIQUE KEY `Entry Number` (`EntryNumber`),
  ADD KEY `SiteID` (`SiteID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `markers`
--
ALTER TABLE `markers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `Testing`
--
ALTER TABLE `Testing`
  MODIFY `EntryNumber` int(64) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
