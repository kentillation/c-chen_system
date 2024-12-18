-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 18, 2024 at 11:50 PM
-- Server version: 8.0.31
-- PHP Version: 8.2.0

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
(1, 'test@test.com', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Juan', 'Dela', 'Cruz', 'profile.png', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

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
-- Table structure for table `tbl_availability`
--

DROP TABLE IF EXISTS `tbl_availability`;
CREATE TABLE IF NOT EXISTS `tbl_availability` (
  `availability_id` int NOT NULL AUTO_INCREMENT,
  `availability` varchar(20) NOT NULL,
  PRIMARY KEY (`availability_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_availability`
--

INSERT INTO `tbl_availability` (`availability_id`, `availability`) VALUES
(1, 'Available'),
(2, 'Unavailable');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bookings`
--

DROP TABLE IF EXISTS `tbl_bookings`;
CREATE TABLE IF NOT EXISTS `tbl_bookings` (
  `booking_id` int NOT NULL AUTO_INCREMENT,
  `reference_number` varchar(50) NOT NULL,
  `fullname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  `date_check_in` date NOT NULL,
  `date_check_out` date NOT NULL,
  `message` text NOT NULL,
  `reason_for_cancellation` text,
  `mode_of_payment_id` int NOT NULL,
  `evidence` varchar(255) NOT NULL,
  `booking_status_id` int NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`booking_id`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_bookings`
--

INSERT INTO `tbl_bookings` (`booking_id`, `reference_number`, `fullname`, `email`, `phone_number`, `date_check_in`, `date_check_out`, `message`, `reason_for_cancellation`, `mode_of_payment_id`, `evidence`, `booking_status_id`, `created_at`) VALUES
(61, '9046015520', 'test', 'teat212@gmail.com', '123456789', '2024-12-18', '2024-12-19', '', NULL, 1, 'IMG-67635e961b2c47.22186363.png', 2, '2024-12-18 23:45:26'),
(60, '3292333530', 'test', 'teat212@gmail.com', '123456789', '2024-12-18', '2024-12-19', '', NULL, 1, 'IMG-67635db2e32656.75054834.png', 2, '2024-12-18 23:41:38'),
(59, '1791420301', 'test', 'teat212@gmail.com', '123456789', '2024-12-18', '2024-12-19', '', NULL, 1, 'IMG-67635d740799e8.20504267.png', 2, '2024-12-18 23:40:36'),
(58, '7879598929', 'test', 'teat212@gmail.com', '123456789', '2024-12-18', '2024-12-19', '', NULL, 1, 'IMG-67635d36068ca9.99751475.png', 2, '2024-12-18 23:39:34');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_booking_cottage`
--

DROP TABLE IF EXISTS `tbl_booking_cottage`;
CREATE TABLE IF NOT EXISTS `tbl_booking_cottage` (
  `booking_cottage_id` int NOT NULL AUTO_INCREMENT,
  `booking_id` int NOT NULL,
  `cottage_id` int NOT NULL,
  `reference_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`booking_cottage_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_booking_room`
--

DROP TABLE IF EXISTS `tbl_booking_room`;
CREATE TABLE IF NOT EXISTS `tbl_booking_room` (
  `booking_room_id` int NOT NULL AUTO_INCREMENT,
  `booking_id` int NOT NULL,
  `pax` int NOT NULL,
  `room_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `room_category_id` int NOT NULL,
  `reference_number` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`booking_room_id`),
  KEY `room_category_id` (`room_category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_booking_room`
--

INSERT INTO `tbl_booking_room` (`booking_room_id`, `booking_id`, `pax`, `room_number`, `room_category_id`, `reference_number`, `created_at`) VALUES
(29, 59, 1, '201', 11, '1791420301', '2024-12-19 07:40:36'),
(30, 60, 1, '101', 10, '3292333530', '2024-12-19 07:41:38'),
(31, 61, 1, '301', 12, '9046015520', '2024-12-19 07:45:26'),
(28, 58, 1, '301', 12, '7879598929', '2024-12-19 07:39:34');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_booking_service`
--

DROP TABLE IF EXISTS `tbl_booking_service`;
CREATE TABLE IF NOT EXISTS `tbl_booking_service` (
  `booking_service_id` int NOT NULL AUTO_INCREMENT,
  `booking_id` int NOT NULL,
  `service_id` int NOT NULL,
  `reference_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`booking_service_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cottages`
--

DROP TABLE IF EXISTS `tbl_cottages`;
CREATE TABLE IF NOT EXISTS `tbl_cottages` (
  `cottage_id` int NOT NULL AUTO_INCREMENT,
  `cottage_name` varchar(50) NOT NULL,
  `cottage_price` varchar(50) NOT NULL,
  `cottage_capacity` varchar(20) NOT NULL,
  `cottage_image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `cottage_availability_id` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`cottage_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_cottages`
--

INSERT INTO `tbl_cottages` (`cottage_id`, `cottage_name`, `cottage_price`, `cottage_capacity`, `cottage_image`, `cottage_availability_id`, `created_at`, `updated_at`) VALUES
(1, 'Small', '700', '10-15', 'Small.jpg', 1, '2024-12-13 03:33:50', '2024-12-18 21:20:17'),
(2, 'Family', '1000', '15-20', 'Family.jpg', 1, '2024-12-13 03:35:20', '2024-12-18 21:18:39');

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
-- Table structure for table `tbl_room_category`
--

DROP TABLE IF EXISTS `tbl_room_category`;
CREATE TABLE IF NOT EXISTS `tbl_room_category` (
  `room_category_id` int NOT NULL AUTO_INCREMENT,
  `room_category_name` varchar(50) NOT NULL,
  `room_category_price` varchar(50) NOT NULL,
  `room_capacity` int NOT NULL,
  `room_details` text,
  `img_url` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `availability_id` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`room_category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_room_category`
--

INSERT INTO `tbl_room_category` (`room_category_id`, `room_category_name`, `room_category_price`, `room_capacity`, `room_details`, `img_url`, `availability_id`, `created_at`, `updated_at`) VALUES
(12, 'Family Room', '2500', 7, NULL, 'IMG-67631ce755bd14.34726786.jpg', 1, '2024-12-19 03:05:11', '2024-12-19 03:05:11'),
(11, 'Single Room (Double bed)', '200', 3, '', 'IMG-67631af70e0fe2.02749865.jpg', 1, '2024-12-19 02:56:55', '2024-12-19 03:04:34'),
(10, 'Single Room', '100', 2, '', 'IMG-67631ad2acc222.28778707.jpg', 1, '2024-12-19 02:56:18', '2024-12-19 03:04:20');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_room_number`
--

DROP TABLE IF EXISTS `tbl_room_number`;
CREATE TABLE IF NOT EXISTS `tbl_room_number` (
  `room_number_id` int NOT NULL AUTO_INCREMENT,
  `room_number` varchar(20) NOT NULL,
  `room_category_id` int NOT NULL,
  `room_availability_id` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`room_number_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_room_number`
--

INSERT INTO `tbl_room_number` (`room_number_id`, `room_number`, `room_category_id`, `room_availability_id`, `created_at`, `updated_at`) VALUES
(1, '101', 10, 1, '0000-00-00 00:00:00', '2024-12-19 02:57:06'),
(2, '201', 11, 1, '2024-12-19 03:05:45', '2024-12-19 03:05:45'),
(3, '102', 10, 1, '0000-00-00 00:00:00', '2024-12-19 03:05:23'),
(4, '202', 11, 1, '0000-00-00 00:00:00', '2024-12-19 03:05:54'),
(5, '301', 12, 1, '0000-00-00 00:00:00', '2024-12-19 03:06:26'),
(6, '302', 12, 1, '0000-00-00 00:00:00', '2024-12-19 03:09:39');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_schedule`
--

DROP TABLE IF EXISTS `tbl_schedule`;
CREATE TABLE IF NOT EXISTS `tbl_schedule` (
  `id` int NOT NULL AUTO_INCREMENT,
  `booking_id` int NOT NULL,
  `fullname` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` text NOT NULL,
  `start_datetime` date NOT NULL,
  `end_datetime` date DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_schedule`
--

INSERT INTO `tbl_schedule` (`id`, `booking_id`, `fullname`, `description`, `start_datetime`, `end_datetime`, `created_at`) VALUES
(17, 49, 'test2', '', '2024-12-25', '2024-12-26', '2024-12-18 22:59:52'),
(16, 48, 'test1', '', '2024-12-20', '2024-12-21', '2024-12-18 22:57:42'),
(15, 47, 'test4', '', '2024-12-27', '2024-12-28', '2024-12-18 22:55:41'),
(14, 46, 'test3', '', '2024-12-24', '2024-12-25', '2024-12-18 22:54:41'),
(13, 45, 'test1', '', '2024-12-23', '2024-12-24', '2024-12-18 22:51:44'),
(12, 44, 'test1', '', '2024-12-20', '2024-12-21', '2024-12-18 22:50:07'),
(18, 50, 'test111', '', '2024-12-20', '2024-12-21', '2024-12-18 23:00:47'),
(19, 51, 'test1', '', '2024-12-21', '2024-12-22', '2024-12-18 23:02:31'),
(20, 52, 'test2', '', '2024-12-20', '2024-12-21', '2024-12-18 23:04:26'),
(21, 53, 'test3', '', '2024-12-24', '2024-12-25', '2024-12-18 23:06:08'),
(22, 54, 'test1', '', '2024-12-20', '2024-12-21', '2024-12-18 23:20:25'),
(23, 55, 'test100', '', '2024-12-20', '2024-12-21', '2024-12-18 23:24:46'),
(24, 56, 'test101', '', '2024-12-27', '2024-12-28', '2024-12-18 23:25:30'),
(25, 57, 'test102', '', '2024-12-24', '2024-12-25', '2024-12-18 23:26:08'),
(26, 58, 'test', '', '2024-12-18', '2024-12-19', '2024-12-18 23:39:34'),
(27, 59, 'test', '', '2024-12-18', '2024-12-19', '2024-12-18 23:40:36'),
(28, 60, 'test', '', '2024-12-18', '2024-12-19', '2024-12-18 23:41:38'),
(29, 61, 'test', '', '2024-12-18', '2024-12-19', '2024-12-18 23:45:26');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_services`
--

DROP TABLE IF EXISTS `tbl_services`;
CREATE TABLE IF NOT EXISTS `tbl_services` (
  `service_id` int NOT NULL AUTO_INCREMENT,
  `service_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `service_price` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `service_duration` varchar(50) NOT NULL,
  `service_image` varchar(50) NOT NULL,
  `service_availability_id` int NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`service_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_services`
--

INSERT INTO `tbl_services` (`service_id`, `service_name`, `service_price`, `service_duration`, `service_image`, `service_availability_id`, `created_at`) VALUES
(1, 'Kiddie Pool', '50', '8am to 4pm', 'Kiddie Pool.jpg', 1, '2024-11-30 02:55:02'),
(2, 'Big Pool', '100', '8am to 4pm', 'Big Pool.jpg', 2, '2024-11-30 02:55:02'),
(3, 'Function Hall', '3500', '8am to 4pm', 'Function Hall.jpg', 1, '2024-11-30 02:55:02');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
