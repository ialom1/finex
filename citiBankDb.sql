-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 07, 2019 at 07:30 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `citiBankDb`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `acc_name` varchar(20) DEFAULT NULL,
  `acc_num` int(11) DEFAULT NULL,
  `acc_pin` varchar(65) DEFAULT NULL,
  `acc_bal` double(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`acc_name`, `acc_num`, `acc_pin`, `acc_bal`) VALUES
('mysales', 112200, '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 100190.00),
('citisupply', 113300, '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 100170.00),
('ialom@gmail.com', 112233, '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 49640.00),
('shatil@gmail.com', 112244, '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 50000.00);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `txn_id` int(11) DEFAULT NULL,
  `acc_from` int(11) DEFAULT NULL,
  `acc_to` int(11) DEFAULT NULL,
  `amt` double(10,2) DEFAULT NULL,
  `txn_ref` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`txn_id`, `acc_from`, `acc_to`, `amt`, `txn_ref`) VALUES
(32276772, 112233, 112200, 160.00, '32276772'),
(89141085, 112200, 113300, 70.00, '89141085'),
(26607339, 112233, 112200, 200.00, '26607339'),
(22787721, 112200, 113300, 100.00, '22787721');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
