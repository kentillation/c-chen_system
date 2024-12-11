-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 11, 2024 at 12:02 AM
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
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_bookings`
--

INSERT INTO `tbl_bookings` (`booking_id`, `reference_number`, `fullname`, `email`, `phone_number`, `date_check_in`, `date_check_out`, `message`, `reason_for_cancellation`, `mode_of_payment_id`, `evidence`, `booking_status_id`, `created_at`) VALUES
(17, '8009199682', 'test', 'test@sample.com', '1234567890', '2024-12-11', '2024-12-12', 'qwertyuio', NULL, 1, 'IMG-6758c6d315eba2.89491128.png', 2, '2024-12-10 22:55:15'),
(18, '5153985928', 'sample', 'sample@test.com', '0987654321', '2024-12-14', '2024-12-15', '', NULL, 1, 'IMG-6758ce3f2e7054.19451754.png', 2, '2024-12-10 23:26:55');

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
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_booking_cottage`
--

INSERT INTO `tbl_booking_cottage` (`booking_cottage_id`, `booking_id`, `cottage_id`, `reference_number`, `created_at`) VALUES
(15, 17, 1, '8009199682', '2024-12-11 06:55:15'),
(16, 18, 8, '5153985928', '2024-12-11 07:26:55');

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
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_booking_room`
--

INSERT INTO `tbl_booking_room` (`booking_room_id`, `booking_id`, `pax`, `room_number`, `room_category_id`, `reference_number`, `created_at`) VALUES
(45, 17, 1, '002', 2, '8009199682', '2024-12-11 06:55:15'),
(46, 18, 1, '001', 1, '5153985928', '2024-12-11 07:26:55'),
(44, 17, 1, '001', 1, '8009199682', '2024-12-11 06:55:15'),
(47, 18, 1, '002', 2, '5153985928', '2024-12-11 07:26:55'),
(48, 18, 1, '006', 3, '5153985928', '2024-12-11 07:26:55');

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
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_booking_service`
--

INSERT INTO `tbl_booking_service` (`booking_service_id`, `booking_id`, `service_id`, `reference_number`, `created_at`) VALUES
(15, 17, 1, '8009199682', '2024-12-11 06:55:15'),
(16, 18, 2, '5153985928', '2024-12-11 07:26:55');

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_room_category`
--

INSERT INTO `tbl_room_category` (`room_category_id`, `room_category_name`, `room_category_price`, `room_capacity`, `room_details`, `img_url`) VALUES
(1, 'Single Room', '1250', 2, 'This is a Single Room', 'single.jpg'),
(2, 'Single Room (Double Bed)', '1250', 2, 'This is a Single type with double bed', 'single(double bed).jpg'),
(3, 'Family Room', '2000', 10, 'This is a Family Room', 'family.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_room_number`
--

DROP TABLE IF EXISTS `tbl_room_number`;
CREATE TABLE IF NOT EXISTS `tbl_room_number` (
  `room_number_id` int NOT NULL AUTO_INCREMENT,
  `room_number` varchar(20) NOT NULL,
  `room_category_id` int NOT NULL,
  `room_capacity` int NOT NULL,
  `room_availability_id` int NOT NULL,
  PRIMARY KEY (`room_number_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_room_number`
--

INSERT INTO `tbl_room_number` (`room_number_id`, `room_number`, `room_category_id`, `room_capacity`, `room_availability_id`) VALUES
(1, '001', 1, 2, 1),
(2, '008', 1, 2, 1),
(3, '010', 1, 2, 1),
(4, '012', 1, 2, 1),
(5, '013', 1, 2, 1),
(6, '014', 1, 2, 1),
(7, '002', 2, 2, 1),
(8, '003', 2, 2, 1),
(9, '004', 2, 2, 1),
(10, '009', 2, 2, 1),
(11, '006', 3, 7, 1);

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
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_schedule`
--

INSERT INTO `tbl_schedule` (`id`, `booking_id`, `fullname`, `description`, `start_datetime`, `end_datetime`, `created_at`) VALUES
(12, 16, 'test', '', '2024-12-13', '2024-12-14', '2024-12-09 02:52:42'),
(13, 17, 'test', '', '2024-12-12', '2024-12-13', '2024-12-10 22:55:15'),
(14, 18, 'sample', '', '2024-12-14', '2024-12-15', '2024-12-10 23:26:55');

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
(1, 'Kiddie Pool', '50', '8am to 4pm', 'Kiddie Pool.jpg', '2024-11-30 02:55:02'),
(2, 'Big Pool', '100', '8am to 4pm', 'Big Pool.jpg', '2024-11-30 02:55:02'),
(6, 'Function Hall', '3500', '8am to 4pm', 'Function Hall.jpg', '2024-11-30 02:55:02');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
