-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2017 at 09:41 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `webshopm`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE IF NOT EXISTS `carts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `product_id`, `quantity`) VALUES
(7, 4, 2, 1),
(8, 4, 1, 1),
(9, 4, 3, 1),
(10, 1, 1, 3),
(12, 1, 2, 2),
(13, 1, 19, 1),
(14, 1, 20, 1),
(15, 1, 21, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`) VALUES
(1, 'Racunari'),
(2, 'TV'),
(3, 'Desktop racunari'),
(4, 'Laptop racunar'),
(5, 'Telefoni'),
(6, 'Oprema za racunare');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `comment` text,
  `date_posted` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `product_id`, `comment`, `date_posted`) VALUES
(1, 1, 1, 'Ovo je komentar.', '2017-02-04 12:14:24'),
(2, 2, 1, 'Ovo je komentar od drugog korisnika.', '2017-02-04 12:14:24'),
(3, 1, 1, 'Novi komentar', '2017-02-05 10:20:10'),
(4, 1, 1, '3', '2017-02-05 10:20:37'),
(5, 1, 1, '4', '2017-02-05 10:22:55'),
(6, 1, 1, '5', '2017-02-05 10:23:00'),
(7, 1, 1, '7', '2017-02-05 10:23:08'),
(8, 1, 1, 'Novi komentar', '2017-02-05 10:23:12'),
(9, 1, 1, 'Najnoviji. Jos jedan', '2017-02-05 10:23:19'),
(10, 1, 1, 'Jos jedan komentar.', '2017-02-05 10:46:53'),
(11, 1, 1, 'Jos jedan komentar.', '2017-02-05 10:47:06'),
(12, 1, 1, 'Jos jedan komentar.', '2017-02-05 10:47:10'),
(13, 2, 3, 'Moj komentar', '2017-02-05 13:04:28'),
(14, 2, 1, 'Novi komentar.', '2017-02-05 13:04:44'),
(15, 1, 2, 'Test', '2017-02-11 13:31:16'),
(16, 1, 3, 'Test', '2017-02-19 10:19:53'),
(17, 4, 3, 'Teeeest', '2017-02-19 10:20:24'),
(18, 4, 2, 'Odlican proizvod!', '2017-02-19 11:16:46'),
(19, 1, 19, 'Test!', '2017-02-26 10:06:12'),
(20, 1, 20, 'Odlican proizvod!', '2017-02-26 10:41:34');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_id` int(11) DEFAULT NULL,
  `to_id` int(11) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text,
  `date_sent` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_read` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `from_id`, `to_id`, `subject`, `message`, `date_sent`, `date_read`) VALUES
(1, 1, 2, 'Naslov', 'Poruka', '2017-02-04 12:13:22', '2017-02-04 12:13:00'),
(2, 2, 1, 'Odgovor', 'Tekst poruke', '2017-02-04 12:13:22', '2017-02-18 10:14:47'),
(5, 1, 1, 'Nova poruka', 'Najnovija poruka', '2017-02-11 13:13:09', '2017-02-11 13:26:21'),
(6, 1, 2, 'Test', 'Teeeest', '2017-02-18 10:14:43', '2017-02-18 10:19:19'),
(9, 1, 4, 'Test', 'Test', '2017-02-19 10:12:04', '2017-02-19 10:20:14'),
(10, 4, 4, 'Test', 'Test', '2017-02-19 12:38:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `category_id` int(11) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `description`, `category_id`, `price`, `img`) VALUES
(20, 'Desktop racunar', 'Opis desktop racunar', 3, '30000', './img/product_images/14881020762496-51ede99afa8d38a1e04ae1121e32f7bc.jpg'),
(21, 'Monitor', 'Test monitor', 6, '20000', './img/product_images/148810313301-51ede99afa8d38a1e04ae1121e32f7bc.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `account_type` enum('admin','user') DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `account_type`) VALUES
(1, 'admin', 'admin@test.com', '202cb962ac59075b964b07152d234b70', 'admin'),
(2, 'maja', 'maja@itc.com', '202cb962ac59075b964b07152d234b70', 'user'),
(4, 'milos', 'milos@itc.com', '202cb962ac59075b964b07152d234b70', 'user'),
(5, 'milic22', 'milos@google.com', 'c4ca4238a0b923820dcc509a6f75849b', 'user');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
