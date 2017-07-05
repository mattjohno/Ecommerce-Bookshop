-- phpMyAdmin SQL Dump
-- version 4.0.10.18
-- https://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Feb 19, 2017 at 12:58 PM
-- Server version: 5.6.35
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `a2029624_tech_reader`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `adminID` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(150) NOT NULL,
  `password` varchar(8) NOT NULL,
  PRIMARY KEY (`adminID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminID`, `email`, `password`) VALUES
(1, 'admin@admin.com', 'Admin17');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `cartID` int(11) NOT NULL AUTO_INCREMENT,
  `customerID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cartID`),
  KEY `customerID` (`customerID`),
  KEY `productID` (`productID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `customerID` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(30) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `address` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `postcode` varchar(6) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `vipNum` varchar(10) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(32) NOT NULL,
  PRIMARY KEY (`customerID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customerID`, `firstName`, `lastName`, `address`, `city`, `postcode`, `phone`, `vipNum`, `email`, `password`) VALUES
(1, 'Test', 'Account', '42 Wallaby Way', 'Sydney', '2000', '0401913771', '000123', 'test@test.com', '5ce5759c06ab4cc458364b193a4fae21');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `orderID` int(11) NOT NULL AUTO_INCREMENT,
  `customerID` int(11) NOT NULL,
  `productCode` varchar(10) NOT NULL,
  `title` varchar(11) NOT NULL,
  `author` varchar(50) NOT NULL,
  `year` varchar(4) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`orderID`),
  KEY `customerID` (`customerID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderID`, `customerID`, `productCode`, `title`, `author`, `year`, `quantity`, `price`, `datetime`) VALUES
(1, 1, 'PDX004', 'JavaScript ', 'Jon Duckett', '2015', 1, 15, '2017-02-19 12:58:04'),
(2, 1, 'PDX001', 'Moby Dick', 'Herman Melvill', '1851', 3, 20, '2017-02-19 12:58:04');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `productID` int(11) NOT NULL AUTO_INCREMENT,
  `productCode` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `year` varchar(4) NOT NULL,
  `publisher` varchar(255) NOT NULL,
  `productDesc` varchar(255) NOT NULL,
  `price` varchar(20) NOT NULL,
  `imagePath` varchar(1024) NOT NULL,
  PRIMARY KEY (`productID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productID`, `productCode`, `author`, `title`, `year`, `publisher`, `productDesc`, `price`, `imagePath`) VALUES
(1, 'PDX001', 'Herman Melvill', 'Moby Dick', '1851', 'Harper & Brothers', 'The Whale of a novel...', '20', '1487131025_moby_dick.jpg'),
(2, 'PDX002', 'J. D. Salinger', 'The Catcher in the Rye', '2001', 'Jimmy Bartle', 'The Bourne Identity is a 1980 spy fiction thriller by Robert Ludlum that tells the story of Jason Bourne, a man with rem', '19.95', '1487208486_catcher_in_the_rye.jpg'),
(3, 'PDX003', 'Robert lundund', 'The Bourne Identity', '1980', 'Jimmy Bartlet', 'The Bourne Identity is a 1980 spy fiction thriller by Robert Ludlum that tells the story of Jason Bourne, a man with rem', '15', '1487036378_bourne_identity.jpg'),
(4, 'PDX004', 'Jon Duckett', 'JavaScript and JQuery', '2015', 'John Wiley & Sons', 'This full-color book adopts a visual approach to teaching JavaScript & jQuery, showing you how to make web pages more interactive and interfaces more intuitive through the use of inspiring code examples, infographics, and photography.', '15', '1487307146_Javascript_Jon_Duckett.jpg'),
(5, 'PDX005', 'Josh Lockhart', 'Modern PHP', '2001', 'O''Reilly', 'PHP is experiencing a renaissance, though it may be difficult to tell with all of the outdated PHP tutorials online. With this practical guide, you’ll learn how PHP has become a full-featured, mature language with object-orientation, namespaces, and a gro', '36.50', '1487036371_PHP_modern.gif');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cust_cart_fk` FOREIGN KEY (`customerID`) REFERENCES `customers` (`customerID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cust_prod_fk` FOREIGN KEY (`productID`) REFERENCES `products` (`productID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `ord_cust_fk` FOREIGN KEY (`customerID`) REFERENCES `customers` (`customerID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
