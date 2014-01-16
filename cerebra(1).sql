-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 15, 2014 at 10:34 PM
-- Server version: 5.5.34
-- PHP Version: 5.3.10-1ubuntu3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `main_cerebra`
--

-- --------------------------------------------------------

--
-- Table structure for table `cerebra_users`
--

CREATE TABLE IF NOT EXISTS `cerebra_users` (
  `kid` varchar(15) NOT NULL,
  `points` int(5) NOT NULL,
  `answered` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cerebra_users`
--

INSERT INTO `cerebra_users` (`kid`, `points`, `answered`) VALUES
('k1444', -1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `k13_cerebra`
--

CREATE TABLE IF NOT EXISTS `k13_cerebra` (
  `kid` varchar(20) NOT NULL,
  `qid` int(2) NOT NULL,
  `attempt` int(3) NOT NULL,
  `flag` int(1) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`kid`,`qid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `k13_cerebra`
--

INSERT INTO `k13_cerebra` (`kid`, `qid`, `attempt`, `flag`, `timestamp`) VALUES
('k1444', 3, 0, 0, '2014-01-15 08:15:17'),
('k1444', 2, 1, 0, '2014-01-15 16:08:03'),
('k1444', 1, 3, 1, '2014-01-15 15:52:16');

-- --------------------------------------------------------

--
-- Table structure for table `start_cerebra`
--

CREATE TABLE IF NOT EXISTS `start_cerebra` (
  `st_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `start_cerebra`
--

INSERT INTO `start_cerebra` (`st_time`) VALUES
('2014-01-15 04:32:59');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
