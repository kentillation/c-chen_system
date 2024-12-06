-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 06, 2024 at 01:55 AM
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
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  PRIMARY KEY (`booking_room_id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `cottage_image` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`cottage_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_cottages`
--

INSERT INTO `tbl_cottages` (`cottage_id`, `cottage_name`, `cottage_price`, `cottage_capacity`, `cottage_image`, `created_at`) VALUES
(1, 'Small', '700', '10 to 15 pax', 'Small.jpg', '2024-11-30 02:07:39'),
(8, 'Family', '1000', '15 to 20 pax', 'Family.jpg', '2024-12-06 01:00:08');

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
  `img_url` varchar(50) NOT NULL,
  PRIMARY KEY (`room_category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_room_category`
--

INSERT INTO `tbl_room_category` (`room_category_id`, `room_category_name`, `room_category_price`, `room_capacity`, `room_details`, `img_url`) VALUES
(1, 'Single Room', '1250', 2, 'This is a Single Room', 'single.jpg'),
(2, 'Family Room', '2500', 10, 'This is a Family Room', 'family.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_room_number`
--

DROP TABLE IF EXISTS `tbl_room_number`;
CREATE TABLE IF NOT EXISTS `tbl_room_number` (
  `room_number_id` int NOT NULL AUTO_INCREMENT,
  `room_number` varchar(20) NOT NULL,
  `room_category_id` int NOT NULL,
  PRIMARY KEY (`room_number_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_room_number`
--

INSERT INTO `tbl_room_number` (`room_number_id`, `room_number`, `room_category_id`) VALUES
(1, '001', 1),
(2, '008', 1),
(3, '010', 1),
(4, '012', 1),
(5, '013', 1),
(6, '014', 1),
(7, '002', 1),
(8, '003', 1),
(9, '004', 1),
(10, '009', 1),
(11, '006', 2);

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
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`service_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_services`
--

INSERT INTO `tbl_services` (`service_id`, `service_name`, `service_price`, `service_duration`, `service_image`, `created_at`) VALUES
(1, 'Swimming Pool (Kids)', '50', '8am to 4pm', 'Swimming Pool.jpg', '2024-11-30 02:55:02'),
(2, 'Swimming Pool (Adult)', '100', '8am to 4pm', 'Swimming Pool.jpg', '2024-11-30 02:55:02'),
(6, 'Function Hall', '3500', '8am to 4pm', 'Function Hall.jpg', '2024-11-30 02:55:02');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
