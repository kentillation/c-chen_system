-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 02, 2024 at 11:31 PM
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
  `user_name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `img_url` text NOT NULL,
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
  `booking_id` int NOT NULL AUTO_INCREMENT,
  `reference_number` varchar(50) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  `date_check_in` date NOT NULL,
  `date_check_out` date NOT NULL,
  `message` text NOT NULL,
  `reason_for_cancellation` text NOT NULL,
  `mode_of_payment_id` int NOT NULL,
  `evidence` varchar(255) NOT NULL,
  `booking_status_id` int NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`booking_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_bookings`
--

INSERT INTO `tbl_bookings` (`booking_id`, `reference_number`, `fullname`, `email`, `phone_number`, `date_check_in`, `date_check_out`, `message`, `mode_of_payment_id`, `evidence`, `booking_status_id`, `created_at`) VALUES
(5, '4892951855', 'QWERTYUIOP', 'qwerty@gmail.com', '1234567890', '2024-12-03', '2024-12-04', '', 1, 'IMG-674dd948e5e5c2.39760707.png', 2, '2024-12-02 03:59:04');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_booking_cottage`
--

DROP TABLE IF EXISTS `tbl_booking_cottage`;
CREATE TABLE IF NOT EXISTS `tbl_booking_cottage` (
  `booking_cottage_id` int NOT NULL AUTO_INCREMENT,
  `booking_id` int NOT NULL,
  `cottage_id` int NOT NULL,
  `reference_number` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`booking_cottage_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_booking_cottage`
--

INSERT INTO `tbl_booking_cottage` (`booking_cottage_id`, `booking_id`, `cottage_id`, `reference_number`, `created_at`) VALUES
(4, 5, 1, '4892951855', '2024-12-02 11:59:04');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_booking_room`
--

DROP TABLE IF EXISTS `tbl_booking_room`;
CREATE TABLE IF NOT EXISTS `tbl_booking_room` (
  `booking_room_id` int NOT NULL AUTO_INCREMENT,
  `booking_id` int NOT NULL,
  `pax` int NOT NULL,
  `room_number` varchar(20) DEFAULT NULL,
  `room_category_id` int NOT NULL,
  `reference_number` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`booking_room_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_booking_room`
--

INSERT INTO `tbl_booking_room` (`booking_room_id`, `booking_id`, `pax`, `room_number`, `room_category_id`, `reference_number`, `created_at`) VALUES
(16, 5, 1, '201', 2, '4892951855', '2024-12-02 11:59:04'),
(17, 5, 1, '202', 2, '4892951855', '2024-12-02 11:59:04'),
(14, 5, 1, '101', 1, '4892951855', '2024-12-02 11:59:04'),
(15, 5, 1, '102', 1, '4892951855', '2024-12-02 11:59:04');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_booking_service`
--

DROP TABLE IF EXISTS `tbl_booking_service`;
CREATE TABLE IF NOT EXISTS `tbl_booking_service` (
  `booking_service_id` int NOT NULL AUTO_INCREMENT,
  `booking_id` int NOT NULL,
  `service_id` int NOT NULL,
  `reference_number` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`booking_service_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_booking_service`
--

INSERT INTO `tbl_booking_service` (`booking_service_id`, `booking_id`, `service_id`, `reference_number`, `created_at`) VALUES
(4, 5, 1, '4892951855', '2024-12-02 11:59:04');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cottages`
--

DROP TABLE IF EXISTS `tbl_cottages`;
CREATE TABLE IF NOT EXISTS `tbl_cottages` (
  `cottage_id` int NOT NULL AUTO_INCREMENT,
  `cottage_name` varchar(50) NOT NULL,
  `cottage_price` varchar(50) NOT NULL,
  `cottage_image` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`cottage_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_cottages`
--

INSERT INTO `tbl_cottages` (`cottage_id`, `cottage_name`, `cottage_price`, `cottage_image`, `created_at`) VALUES
(1, 'Cottage A', '500', 'Price-500a.jpg', '2024-11-30 02:07:39'),
(2, 'Cottage B', '500', 'Price-500b.jpg', '2024-11-30 02:07:39'),
(3, 'Cottage C', '800', 'Price-800.jpg', '2024-11-30 02:07:39');

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
(1, 'Single Room', '990', 2, 'This is a Standard Room', 'single.jpg'),
(2, 'Family Room', '1090', 10, 'This is a Twin Room', 'family.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_room_number`
--

DROP TABLE IF EXISTS `tbl_room_number`;
CREATE TABLE IF NOT EXISTS `tbl_room_number` (
  `room_number_id` int NOT NULL AUTO_INCREMENT,
  `room_number` varchar(10) NOT NULL,
  `room_category_id` int NOT NULL,
  PRIMARY KEY (`room_number_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_room_number`
--

INSERT INTO `tbl_room_number` (`room_number_id`, `room_number`, `room_category_id`) VALUES
(1, '101', 1),
(2, '102', 1),
(3, '201', 2),
(4, '202', 2),
(5, '203', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_schedule`
--

DROP TABLE IF EXISTS `tbl_schedule`;
CREATE TABLE IF NOT EXISTS `tbl_schedule` (
  `id` int NOT NULL AUTO_INCREMENT,
  `booking_id` int NOT NULL,
  `fullname` text NOT NULL,
  `description` text NOT NULL,
  `start_datetime` date NOT NULL,
  `end_datetime` date DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_schedule`
--

INSERT INTO `tbl_schedule` (`id`, `booking_id`, `fullname`, `description`, `start_datetime`, `end_datetime`, `created_at`) VALUES
(5, 5, 'QWERTYUIOP', '', '2024-12-03', '2024-12-04', '2024-12-02 03:59:04');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_services`
--

DROP TABLE IF EXISTS `tbl_services`;
CREATE TABLE IF NOT EXISTS `tbl_services` (
  `service_id` int NOT NULL AUTO_INCREMENT,
  `service_name` varchar(50) NOT NULL,
  `service_price` varchar(50) NOT NULL,
  `service_image` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`service_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_services`
--

INSERT INTO `tbl_services` (`service_id`, `service_name`, `service_price`, `service_image`, `created_at`) VALUES
(1, 'Swimming Pool (Kids)', '50', 'Swimming Pool.jpg', '2024-11-30 02:55:02'),
(2, 'Swimming Pool (Adult)', '100', 'Swimming Pool.jpg', '2024-11-30 02:55:02'),
(6, 'Event Hosting', '10000', 'Event Hosting.jpg', '2024-11-30 02:55:02');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
