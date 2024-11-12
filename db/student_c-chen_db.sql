-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 12, 2024 at 09:00 AM
-- Server version: 8.0.31
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_c-chen_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

DROP TABLE IF EXISTS `tbl_admin`;
CREATE TABLE IF NOT EXISTS `tbl_admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `user_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `img_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `email`, `user_name`, `password`, `firstname`, `middlename`, `lastname`, `img_url`, `created_at`, `updated_at`) VALUES
(1, 'support@kentillation.com', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Juan', 'Dela', 'Cruz', 'profile.png', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_announcements`
--

DROP TABLE IF EXISTS `tbl_announcements`;
CREATE TABLE IF NOT EXISTS `tbl_announcements` (
  `id` int NOT NULL AUTO_INCREMENT,
  `admin_id` int NOT NULL,
  `announcement` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bookings`
--

DROP TABLE IF EXISTS `tbl_bookings`;
CREATE TABLE IF NOT EXISTS `tbl_bookings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reference_number` varchar(50) NOT NULL,
  `fullname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  `date_check_in` datetime NOT NULL,
  `date_check_out` datetime NOT NULL,
  `service_id` int NOT NULL,
  `message` text NOT NULL,
  `mode_of_payment_id` int NOT NULL,
  `evidence` varchar(255) NOT NULL,
  `booking_status_id` int NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mode_of_payment`
--

DROP TABLE IF EXISTS `tbl_mode_of_payment`;
CREATE TABLE IF NOT EXISTS `tbl_mode_of_payment` (
  `mode_of_payment_id` int NOT NULL AUTO_INCREMENT,
  `mode_of_payment` varchar(50) NOT NULL,
  PRIMARY KEY (`mode_of_payment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_mode_of_payment`
--

INSERT INTO `tbl_mode_of_payment` (`mode_of_payment_id`, `mode_of_payment`) VALUES
(1, 'GCash'),
(2, 'PayMaya'),
(3, 'Shoppe Pay');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_price`
--

DROP TABLE IF EXISTS `tbl_price`;
CREATE TABLE IF NOT EXISTS `tbl_price` (
  `price_id` int NOT NULL AUTO_INCREMENT,
  `price` varchar(20) NOT NULL,
  `price_range_id` int NOT NULL,
  PRIMARY KEY (`price_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_price_range`
--

DROP TABLE IF EXISTS `tbl_price_range`;
CREATE TABLE IF NOT EXISTS `tbl_price_range` (
  `price_range_id` int NOT NULL AUTO_INCREMENT,
  `price_range` varchar(20) NOT NULL,
  PRIMARY KEY (`price_range_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_price_range`
--

INSERT INTO `tbl_price_range` (`price_range_id`, `price_range`) VALUES
(1, '300-1000'),
(2, '50-100'),
(3, '5000-10000'),
(4, '500-2000');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_room_number`
--

DROP TABLE IF EXISTS `tbl_room_number`;
CREATE TABLE IF NOT EXISTS `tbl_room_number` (
  `room_number_id` int NOT NULL AUTO_INCREMENT,
  `room_number` int NOT NULL,
  PRIMARY KEY (`room_number_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_room_number`
--

INSERT INTO `tbl_room_number` (`room_number_id`, `room_number`) VALUES
(1, 101),
(2, 102),
(3, 103),
(4, 104),
(5, 105);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_schedule`
--

DROP TABLE IF EXISTS `tbl_schedule`;
CREATE TABLE IF NOT EXISTS `tbl_schedule` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fullname` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` text NOT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_services`
--

DROP TABLE IF EXISTS `tbl_services`;
CREATE TABLE IF NOT EXISTS `tbl_services` (
  `service_id` int NOT NULL AUTO_INCREMENT,
  `service_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` text NOT NULL,
  `price_id` int NOT NULL,
  PRIMARY KEY (`service_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_services`
--

INSERT INTO `tbl_services` (`service_id`, `service_name`, `description`, `price_id`) VALUES
(1, 'Cottage', '', 1),
(2, 'Swimming Pool', '', 2),
(3, 'Event Hosting', '', 3),
(4, 'Bar and Lounge', '', 4),
(5, 'Rooms', '', 5);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
