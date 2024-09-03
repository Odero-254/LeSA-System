-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 21, 2024 at 04:50 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nysei_lesa`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_requests`
--

DROP TABLE IF EXISTS `account_requests`;
CREATE TABLE IF NOT EXISTS `account_requests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `department` varchar(100) NOT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `account_requests`
--

INSERT INTO `account_requests` (`id`, `name`, `phone`, `department`, `status`, `created_at`) VALUES
(1, 'Moses Nyambane', '0734257689', 'Telecommunication', 'Approved', '2024-06-14 21:05:05'),
(2, 'Henry Mburia', '0734257689', 'ICT', 'Approved', '2024-06-14 21:30:56'),
(3, 'Jerevasio', '23416451378612', 'cs', 'Rejected', '2024-06-18 10:51:47'),
(4, 'Francis Mureithi ', '096347263', 'Automotive ', 'Rejected', '2024-06-20 06:28:33'),
(5, 'Benard Odero', '0101443359', 'Mechanical Department', 'Pending', '2024-06-27 13:09:57'),
(19, 'Yvette Sonia', '0734257689', 'Telecommunication', 'Pending', '2024-07-02 16:50:47'),
(20, 'Henry Mburia', '0101443359', 'Automotive ', 'Pending', '2024-07-02 16:53:54'),
(21, 'Yvette Sonia', '0734257689', 'Avionics', 'Pending', '2024-07-04 14:49:00'),
(22, 'Amos Otieno', '0734257689', 'Mechanical Department', 'Pending', '2024-07-18 12:50:11'),
(23, 'Moses Nyambane', '0101443359', 'Automotive ', 'Pending', '2024-07-18 13:05:04'),
(24, 'Amos Otieno', '0734257689', 'Telecommunication', 'Pending', '2024-07-18 13:11:51'),
(25, 'Amos Otieno', '0734257689', 'Telecommunication', 'Pending', '2024-07-18 13:13:43'),
(26, 'Amos Otieno', '0101443359', 'Avionics', 'Pending', '2024-07-18 13:13:53'),
(27, 'Amos Otieno', '0101443359', 'Mechanical Department', 'Pending', '2024-07-18 13:16:07'),
(28, 'Moses Nyambane', '+254 713786943', 'Automotive', 'Pending', '2024-07-18 13:18:29'),
(29, 'Amos Otieno', '+254 713786943', 'Automotive ', 'Pending', '2024-07-18 13:21:19'),
(30, 'Amos Otieno', '0734257689', 'Telecommunication', 'Pending', '2024-07-18 13:25:25'),
(31, 'Yvette Sonia', '+254 713786943', 'ICT', 'Pending', '2024-07-18 13:26:49'),
(32, 'Moses Nyambane', '+254 713786943', 'Mechanical Department', 'Pending', '2024-07-18 13:29:43'),
(33, 'Amos Otieno', '+254 713786943', 'Avionics', 'Pending', '2024-07-18 13:30:39'),
(34, 'Amos Otieno', '0101443359', 'Avionics', 'Pending', '2024-07-18 13:33:15'),
(35, 'Moses Nyambane', '+254 713786943', 'Automotive ', 'Pending', '2024-07-18 13:36:36'),
(36, 'Henry Mburia', '+254 713786943', 'Telecommunication', 'Pending', '2024-07-19 22:04:08'),
(37, 'Amos Otieno', '0101443359', 'ICT', 'Pending', '2024-07-19 22:06:34'),
(38, 'Moses Nyambane', '0101443359', 'Avionics', 'Pending', '2024-07-19 22:07:14'),
(39, 'Benard Odero', '0101443359', 'Avionics', 'Pending', '2024-07-19 22:28:23'),
(40, 'Henry Mburia', '0101443359', 'Automotive ', 'Pending', '2024-07-19 22:32:14'),
(41, 'Benard Odero', '0734257689', 'Automotive ', 'Pending', '2024-07-19 22:36:29'),
(42, 'Benard Odero', '0101443359', 'Automotive ', 'Pending', '2024-07-19 22:55:32'),
(43, 'Henry Mburia', '+254 713786943', 'ICT', 'Pending', '2024-07-19 22:55:41'),
(44, 'Amos Otieno', '+254 713786943', 'Mechanical Department', 'Pending', '2024-07-19 22:55:53'),
(45, 'John Michuki', '0101443359', 'Telecommunication', 'Pending', '2024-07-19 23:10:11'),
(46, 'Sandra Natasha', '0713786943', 'Avionics', 'Pending', '2024-07-19 23:10:33'),
(47, 'Zedekiah Pamba', '0713786943', 'ICT', 'Pending', '2024-07-19 23:10:53'),
(48, 'Jane Karimi', '0101443359', 'Automotive ', 'Pending', '2024-07-30 08:51:27'),
(49, 'John Michuki', '+254 713786943', 'Avionics', 'Pending', '2024-07-30 09:00:42'),
(50, 'Jane Karimi', '0101443359', 'Automotive ', 'Pending', '2024-08-04 18:48:25'),
(51, 'Esther Mbengi', '0711199983', 'Telecommunication', 'Pending', '2024-08-13 11:41:22'),
(52, 'jerevasio murithi', '0769291582', 'cs', 'Pending', '2024-08-20 07:15:49');

-- --------------------------------------------------------

--
-- Table structure for table `allocations`
--

DROP TABLE IF EXISTS `allocations`;
CREATE TABLE IF NOT EXISTS `allocations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lecturer_id` int DEFAULT NULL,
  `subject_id` int DEFAULT NULL,
  `class_id` int DEFAULT NULL,
  `course` varchar(100) NOT NULL,
  `level` varchar(100) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `duration` varchar(8) NOT NULL,
  `day_of_week` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lecturer_id_day_start_time` (`lecturer_id`,`day_of_week`,`start_time`),
  KEY `subject_id` (`subject_id`),
  KEY `class_id` (`class_id`)
) ENGINE=InnoDB AUTO_INCREMENT=652 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `allocations`
--

INSERT INTO `allocations` (`id`, `lecturer_id`, `subject_id`, `class_id`, `course`, `level`, `start_time`, `end_time`, `duration`, `day_of_week`) VALUES
(562, 12, 16, 84, 'ICT', 'Level 3', '08:00:00', '10:00:00', '02:00:00', 'Monday'),
(563, 12, 16, 84, 'ICT', 'Level 3', '08:00:00', '10:00:00', '02:00:00', 'Tuesday'),
(564, 12, 16, 84, 'ICT', 'Level 3', '08:00:00', '10:00:00', '02:00:00', 'Wednesday'),
(565, 12, 16, 84, 'ICT', 'Level 3', '08:00:00', '10:00:00', '02:00:00', 'Thursday'),
(566, 12, 16, 84, 'ICT', 'Level 3', '08:00:00', '10:00:00', '02:00:00', 'Friday'),
(567, 13, 16, 84, 'ICT', 'Level 3', '10:15:00', '12:15:00', '02:00:00', 'Monday'),
(568, 13, 16, 84, 'ICT', 'Level 3', '10:15:00', '12:15:00', '02:00:00', 'Tuesday'),
(569, 13, 16, 84, 'ICT', 'Level 3', '10:15:00', '12:15:00', '02:00:00', 'Wednesday'),
(570, 13, 16, 84, 'ICT', 'Level 3', '10:15:00', '12:15:00', '02:00:00', 'Thursday'),
(571, 13, 16, 84, 'ICT', 'Level 3', '10:15:00', '12:15:00', '02:00:00', 'Friday'),
(572, 15, 17, 84, 'ICT', 'Level 3', '13:15:00', '15:15:00', '02:00:00', 'Monday'),
(573, 15, 17, 84, 'ICT', 'Level 3', '13:15:00', '15:15:00', '02:00:00', 'Tuesday'),
(574, 15, 17, 84, 'ICT', 'Level 3', '13:15:00', '15:15:00', '02:00:00', 'Wednesday'),
(575, 15, 17, 84, 'ICT', 'Level 3', '13:15:00', '15:15:00', '02:00:00', 'Thursday'),
(576, 15, 17, 84, 'ICT', 'Level 3', '13:15:00', '15:15:00', '02:00:00', 'Friday'),
(577, 19, 17, 84, 'ICT', 'Level 3', '15:30:00', '17:30:00', '02:00:00', 'Monday'),
(578, 19, 17, 84, 'ICT', 'Level 3', '15:30:00', '17:30:00', '02:00:00', 'Tuesday'),
(579, 19, 17, 84, 'ICT', 'Level 3', '15:30:00', '17:30:00', '02:00:00', 'Wednesday'),
(580, 19, 17, 84, 'ICT', 'Level 3', '15:30:00', '17:30:00', '02:00:00', 'Thursday'),
(581, 19, 17, 84, 'ICT', 'Level 3', '15:30:00', '17:30:00', '02:00:00', 'Friday'),
(582, 13, 16, 85, 'ICT', 'Level 2', '08:00:00', '10:00:00', '02:00:00', 'Monday'),
(583, 13, 16, 85, 'ICT', 'Level 2', '08:00:00', '10:00:00', '02:00:00', 'Tuesday'),
(584, 13, 16, 85, 'ICT', 'Level 2', '08:00:00', '10:00:00', '02:00:00', 'Wednesday'),
(585, 13, 16, 85, 'ICT', 'Level 2', '08:00:00', '10:00:00', '02:00:00', 'Thursday'),
(586, 13, 16, 85, 'ICT', 'Level 2', '08:00:00', '10:00:00', '02:00:00', 'Friday'),
(587, 15, 17, 85, 'ICT', 'Level 2', '10:15:00', '12:15:00', '02:00:00', 'Monday'),
(588, 15, 17, 85, 'ICT', 'Level 2', '10:15:00', '12:15:00', '02:00:00', 'Tuesday'),
(589, 15, 17, 85, 'ICT', 'Level 2', '10:15:00', '12:15:00', '02:00:00', 'Wednesday'),
(590, 15, 17, 85, 'ICT', 'Level 2', '10:15:00', '12:15:00', '02:00:00', 'Thursday'),
(591, 15, 17, 85, 'ICT', 'Level 2', '10:15:00', '12:15:00', '02:00:00', 'Friday'),
(592, 19, 17, 85, 'ICT', 'Level 2', '13:15:00', '15:15:00', '02:00:00', 'Monday'),
(593, 19, 17, 85, 'ICT', 'Level 2', '13:15:00', '15:15:00', '02:00:00', 'Tuesday'),
(594, 19, 17, 85, 'ICT', 'Level 2', '13:15:00', '15:15:00', '02:00:00', 'Wednesday'),
(595, 19, 17, 85, 'ICT', 'Level 2', '13:15:00', '15:15:00', '02:00:00', 'Thursday'),
(596, 19, 17, 85, 'ICT', 'Level 2', '13:15:00', '15:15:00', '02:00:00', 'Friday'),
(597, 18, 18, 85, 'ICT', 'Level 2', '15:30:00', '17:30:00', '02:00:00', 'Monday'),
(598, 18, 18, 85, 'ICT', 'Level 2', '15:30:00', '17:30:00', '02:00:00', 'Tuesday'),
(599, 18, 18, 85, 'ICT', 'Level 2', '15:30:00', '17:30:00', '02:00:00', 'Wednesday'),
(600, 18, 18, 85, 'ICT', 'Level 2', '15:30:00', '17:30:00', '02:00:00', 'Thursday'),
(601, 18, 18, 85, 'ICT', 'Level 2', '15:30:00', '17:30:00', '02:00:00', 'Friday'),
(602, 15, 17, 86, 'ICT', 'Level 1', '08:00:00', '10:00:00', '02:00:00', 'Monday'),
(603, 15, 17, 86, 'ICT', 'Level 1', '08:00:00', '10:00:00', '02:00:00', 'Tuesday'),
(604, 15, 17, 86, 'ICT', 'Level 1', '08:00:00', '10:00:00', '02:00:00', 'Wednesday'),
(605, 15, 17, 86, 'ICT', 'Level 1', '08:00:00', '10:00:00', '02:00:00', 'Thursday'),
(606, 15, 17, 86, 'ICT', 'Level 1', '08:00:00', '10:00:00', '02:00:00', 'Friday'),
(607, 19, 17, 86, 'ICT', 'Level 1', '10:15:00', '12:15:00', '02:00:00', 'Monday'),
(608, 19, 17, 86, 'ICT', 'Level 1', '10:15:00', '12:15:00', '02:00:00', 'Tuesday'),
(609, 19, 17, 86, 'ICT', 'Level 1', '10:15:00', '12:15:00', '02:00:00', 'Wednesday'),
(610, 19, 17, 86, 'ICT', 'Level 1', '10:15:00', '12:15:00', '02:00:00', 'Thursday'),
(611, 19, 17, 86, 'ICT', 'Level 1', '10:15:00', '12:15:00', '02:00:00', 'Friday'),
(612, 18, 18, 86, 'ICT', 'Level 1', '13:15:00', '15:15:00', '02:00:00', 'Monday'),
(613, 18, 18, 86, 'ICT', 'Level 1', '13:15:00', '15:15:00', '02:00:00', 'Tuesday'),
(614, 18, 18, 86, 'ICT', 'Level 1', '13:15:00', '15:15:00', '02:00:00', 'Wednesday'),
(615, 18, 18, 86, 'ICT', 'Level 1', '13:15:00', '15:15:00', '02:00:00', 'Thursday'),
(616, 18, 18, 86, 'ICT', 'Level 1', '13:15:00', '15:15:00', '02:00:00', 'Friday'),
(617, 14, 20, 86, 'ICT', 'Level 1', '15:30:00', '17:30:00', '02:00:00', 'Monday'),
(618, 14, 20, 86, 'ICT', 'Level 1', '15:30:00', '17:30:00', '02:00:00', 'Tuesday'),
(619, 14, 20, 86, 'ICT', 'Level 1', '15:30:00', '17:30:00', '02:00:00', 'Wednesday'),
(620, 14, 20, 86, 'ICT', 'Level 1', '15:30:00', '17:30:00', '02:00:00', 'Thursday'),
(621, 14, 20, 86, 'ICT', 'Level 1', '15:30:00', '17:30:00', '02:00:00', 'Friday'),
(622, 19, 17, 87, 'CS', 'Level 1', '08:00:00', '10:00:00', '02:00:00', 'Monday'),
(623, 19, 17, 87, 'CS', 'Level 1', '08:00:00', '10:00:00', '02:00:00', 'Tuesday'),
(624, 19, 17, 87, 'CS', 'Level 1', '08:00:00', '10:00:00', '02:00:00', 'Wednesday'),
(625, 19, 17, 87, 'CS', 'Level 1', '08:00:00', '10:00:00', '02:00:00', 'Thursday'),
(626, 19, 17, 87, 'CS', 'Level 1', '08:00:00', '10:00:00', '02:00:00', 'Friday'),
(627, 18, 18, 87, 'CS', 'Level 1', '10:15:00', '12:15:00', '02:00:00', 'Monday'),
(628, 18, 18, 87, 'CS', 'Level 1', '10:15:00', '12:15:00', '02:00:00', 'Tuesday'),
(629, 18, 18, 87, 'CS', 'Level 1', '10:15:00', '12:15:00', '02:00:00', 'Wednesday'),
(630, 18, 18, 87, 'CS', 'Level 1', '10:15:00', '12:15:00', '02:00:00', 'Thursday'),
(631, 18, 18, 87, 'CS', 'Level 1', '10:15:00', '12:15:00', '02:00:00', 'Friday'),
(632, 14, 20, 87, 'CS', 'Level 1', '13:15:00', '15:15:00', '02:00:00', 'Monday'),
(633, 14, 20, 87, 'CS', 'Level 1', '13:15:00', '15:15:00', '02:00:00', 'Tuesday'),
(634, 14, 20, 87, 'CS', 'Level 1', '13:15:00', '15:15:00', '02:00:00', 'Wednesday'),
(635, 14, 20, 87, 'CS', 'Level 1', '13:15:00', '15:15:00', '02:00:00', 'Thursday'),
(636, 14, 20, 87, 'CS', 'Level 1', '13:15:00', '15:15:00', '02:00:00', 'Friday'),
(637, 18, 18, 88, 'CS', 'Level 2', '08:00:00', '10:00:00', '02:00:00', 'Monday'),
(638, 18, 18, 88, 'CS', 'Level 2', '08:00:00', '10:00:00', '02:00:00', 'Tuesday'),
(639, 18, 18, 88, 'CS', 'Level 2', '08:00:00', '10:00:00', '02:00:00', 'Wednesday'),
(640, 18, 18, 88, 'CS', 'Level 2', '08:00:00', '10:00:00', '02:00:00', 'Thursday'),
(641, 18, 18, 88, 'CS', 'Level 2', '08:00:00', '10:00:00', '02:00:00', 'Friday'),
(642, 14, 20, 88, 'CS', 'Level 2', '10:15:00', '12:15:00', '02:00:00', 'Monday'),
(643, 14, 20, 88, 'CS', 'Level 2', '10:15:00', '12:15:00', '02:00:00', 'Tuesday'),
(644, 14, 20, 88, 'CS', 'Level 2', '10:15:00', '12:15:00', '02:00:00', 'Wednesday'),
(645, 14, 20, 88, 'CS', 'Level 2', '10:15:00', '12:15:00', '02:00:00', 'Thursday'),
(646, 14, 20, 88, 'CS', 'Level 2', '10:15:00', '12:15:00', '02:00:00', 'Friday'),
(647, 14, 20, 89, 'CS', 'Level 3', '08:00:00', '10:00:00', '02:00:00', 'Monday'),
(648, 14, 20, 89, 'CS', 'Level 3', '08:00:00', '10:00:00', '02:00:00', 'Tuesday'),
(649, 14, 20, 89, 'CS', 'Level 3', '08:00:00', '10:00:00', '02:00:00', 'Wednesday'),
(650, 14, 20, 89, 'CS', 'Level 3', '08:00:00', '10:00:00', '02:00:00', 'Thursday'),
(651, 14, 20, 89, 'CS', 'Level 3', '08:00:00', '10:00:00', '02:00:00', 'Friday');

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

DROP TABLE IF EXISTS `assignments`;
CREATE TABLE IF NOT EXISTS `assignments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `due_date` datetime NOT NULL,
  `course_id` int NOT NULL,
  `class_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
CREATE TABLE IF NOT EXISTS `attendance` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lesson_id` int NOT NULL,
  `subject_id` int NOT NULL,
  `lecturer_id` int NOT NULL,
  `class_id` int DEFAULT NULL,
  `department_id` int DEFAULT NULL,
  `lesson_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `day_of_week` varchar(10) DEFAULT NULL,
  `status` varchar(10) NOT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_attendance_class` (`class_id`),
  KEY `fk_attendance_department` (`department_id`),
  KEY `fk_attendance_lecturer` (`lecturer_id`),
  KEY `fk_attendance_subject` (`subject_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `lesson_id`, `subject_id`, `lecturer_id`, `class_id`, `department_id`, `lesson_date`, `start_time`, `end_time`, `day_of_week`, `status`, `timestamp`) VALUES
(10, 475, 0, 13, 84, 2, '2024-08-19', NULL, NULL, NULL, 'missed', '2024-08-19 18:06:45'),
(11, 562, 0, 0, 84, 2, '2024-08-21', NULL, NULL, NULL, 'missed', '2024-08-21 16:13:31'),
(12, 563, 0, 0, 84, 2, '2024-08-21', NULL, NULL, NULL, 'missed', '2024-08-21 16:13:31'),
(13, 564, 0, 0, 84, 2, '2024-08-21', NULL, NULL, NULL, 'missed', '2024-08-21 16:13:31'),
(14, 565, 0, 0, 84, 2, '2024-08-21', NULL, NULL, NULL, 'missed', '2024-08-21 16:13:31'),
(15, 566, 0, 0, 84, 2, '2024-08-21', NULL, NULL, NULL, 'missed', '2024-08-21 16:13:31'),
(16, 567, 0, 0, 84, 2, '2024-08-21', NULL, NULL, NULL, 'missed', '2024-08-21 16:13:31'),
(17, 568, 0, 0, 84, 2, '2024-08-21', NULL, NULL, NULL, 'missed', '2024-08-21 16:13:31'),
(18, 569, 0, 0, 84, 2, '2024-08-21', NULL, NULL, NULL, 'missed', '2024-08-21 16:13:31'),
(19, 570, 0, 0, 84, 2, '2024-08-21', NULL, NULL, NULL, 'missed', '2024-08-21 16:13:31'),
(20, 571, 0, 0, 84, 2, '2024-08-21', NULL, NULL, NULL, 'missed', '2024-08-21 16:13:31'),
(21, 572, 0, 0, 84, 2, '2024-08-21', NULL, NULL, NULL, 'missed', '2024-08-21 16:13:31'),
(22, 573, 0, 0, 84, 2, '2024-08-21', NULL, NULL, NULL, 'missed', '2024-08-21 16:13:31'),
(23, 574, 0, 0, 84, 2, '2024-08-21', NULL, NULL, NULL, 'missed', '2024-08-21 16:13:31'),
(24, 575, 0, 0, 84, 2, '2024-08-21', NULL, NULL, NULL, 'missed', '2024-08-21 16:13:31'),
(25, 576, 0, 0, 84, 2, '2024-08-21', NULL, NULL, NULL, 'missed', '2024-08-21 16:13:31');

-- --------------------------------------------------------

--
-- Table structure for table `break_durations`
--

DROP TABLE IF EXISTS `break_durations`;
CREATE TABLE IF NOT EXISTS `break_durations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `day_of_week` varchar(10) NOT NULL,
  `break_start` time NOT NULL,
  `break_end` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
CREATE TABLE IF NOT EXISTS `classes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `class_name` varchar(255) DEFAULT NULL,
  `course_id` int NOT NULL,
  `level_id` int NOT NULL,
  `department_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  KEY `level_id` (`level_id`),
  KEY `fk_classes_department` (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `class_name`, `course_id`, `level_id`, `department_id`) VALUES
(84, 'ICT 3', 1, 3, 2),
(85, 'ICT 2', 1, 2, 2),
(86, 'ICT 1', 1, 1, 2),
(87, 'Computer Studies 1', 2, 1, 2),
(88, 'Computer Studies 2', 2, 2, 2),
(89, 'Computer Studies 3', 2, 3, 2),
(90, 'EP 1', 3, 1, 3),
(91, 'EP 2', 3, 2, 3),
(92, 'EP 3', 3, 3, 3),
(93, 'B.Tech 1', 10, 1, 6),
(94, 'B.Tech 2', 10, 2, 6),
(95, 'B.Tech 3', 10, 3, 6),
(96, 'Instrumentation 1', 4, 1, 3),
(97, 'Instrumentation 2', 4, 2, 3),
(98, 'Instrumentation 3', 4, 3, 3),
(99, 'Telecom 1', 5, 1, 2),
(100, 'Telecom 2', 5, 2, 2),
(101, 'Telecom 3', 5, 3, 2),
(102, 'Civil Engineering 1', 11, 1, 6),
(103, 'Civil Engineering 2', 11, 2, 6),
(104, 'Civil Engineering 3', 11, 3, 6),
(105, 'Auto 1', 6, 1, 4),
(106, 'Auto 2', 6, 2, 4),
(107, 'Auto 3', 6, 3, 4),
(108, 'CP 1', 7, 1, 5),
(109, 'CP 2', 7, 2, 5),
(110, 'CP 3', 7, 3, 5),
(111, 'IP 1', 8, 1, 5),
(112, 'IP 2', 8, 2, 5),
(113, 'IP 3', 8, 3, 5),
(114, 'FTM 1', 9, 1, 5),
(115, 'FTM 2', 9, 2, 5),
(116, 'FTM 3', 9, 3, 5),
(117, 'Avionics 1', 12, 1, 7),
(118, 'MP 1', 13, 1, 5),
(119, 'MP 2', 13, 2, 5),
(120, 'MP 3', 13, 3, 5);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
CREATE TABLE IF NOT EXISTS `courses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `course_name` varchar(100) DEFAULT NULL,
  `department_id` int NOT NULL,
  `RegDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `department_id` (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_name`, `department_id`, `RegDate`) VALUES
(1, 'ICT', 2, '2024-07-17 19:17:39'),
(2, 'CS', 2, '2024-07-17 19:17:39'),
(3, 'Power Option', 3, '2024-07-17 19:17:39'),
(4, 'Instrumentation Option', 3, '2024-07-17 19:17:39'),
(5, 'Telecommunication Option', 2, '2024-07-17 19:17:39'),
(6, 'Automotive', 4, '2024-07-17 19:17:39'),
(7, 'Construction Plant', 5, '2024-07-17 19:17:39'),
(8, 'Industrial Plant', 5, '2024-07-17 19:17:39'),
(9, 'Welding and Fabrication', 5, '2024-07-17 19:17:39'),
(10, 'B.Tech', 6, '2024-07-17 19:17:39'),
(11, 'Civil Engineering', 6, '2024-07-17 19:17:39'),
(12, 'Avionics', 7, '2024-07-17 19:17:39'),
(13, 'Mechanical production', 5, '2024-07-17 19:28:13');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
CREATE TABLE IF NOT EXISTS `department` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `name`) VALUES
(1, 'Administration'),
(4, 'Automotive'),
(7, 'Aviation'),
(6, 'Building Technology'),
(3, 'Electrical and Electronic'),
(2, 'ICT'),
(5, 'Mechanical');

-- --------------------------------------------------------

--
-- Table structure for table `exam_schedule`
--

DROP TABLE IF EXISTS `exam_schedule`;
CREATE TABLE IF NOT EXISTS `exam_schedule` (
  `id` int NOT NULL AUTO_INCREMENT,
  `exam_date` date NOT NULL,
  `exam_start` time NOT NULL,
  `exam_end` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hod`
--

DROP TABLE IF EXISTS `hod`;
CREATE TABLE IF NOT EXISTS `hod` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `qualifications` text,
  `qualified_subjects` text,
  `allocated_subjects` text,
  `user_id` int NOT NULL,
  `department_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `department_id` (`department_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `hod`
--

INSERT INTO `hod` (`id`, `username`, `qualifications`, `qualified_subjects`, `allocated_subjects`, `user_id`, `department_id`) VALUES
(1, 'John Gichemi', 'Certified Analytics Professional (CAP) and Certified Six Sigma Green Belt', 'Quantitative Techniques', NULL, 34, 4),
(2, 'Weldon Kamau', 'Diploma in ICT', 'Computational Mathematics', NULL, 38, 7),
(6, 'Caroline Ngigi', 'Internet Programming,  Certified Information Systems Security Professional (CISSP)', 'Internet Based Programming (IBP), Management Information System (MIS)', NULL, 46, 2);

-- --------------------------------------------------------

--
-- Table structure for table `hod_subjects`
--

DROP TABLE IF EXISTS `hod_subjects`;
CREATE TABLE IF NOT EXISTS `hod_subjects` (
  `hod_id` int NOT NULL,
  `subject_id` int NOT NULL,
  PRIMARY KEY (`hod_id`,`subject_id`),
  KEY `subject_id` (`subject_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `hod_subjects`
--

INSERT INTO `hod_subjects` (`hod_id`, `subject_id`) VALUES
(34, 20),
(38, 11),
(41, 16),
(41, 17),
(42, 17),
(42, 18),
(43, 17),
(43, 18),
(46, 16),
(46, 17);

-- --------------------------------------------------------

--
-- Table structure for table `lecturers`
--

DROP TABLE IF EXISTS `lecturers`;
CREATE TABLE IF NOT EXISTS `lecturers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `user_id` int DEFAULT NULL,
  `department_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_lecturers_department` (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `lecturers`
--

INSERT INTO `lecturers` (`id`, `username`, `user_id`, `department_id`) VALUES
(12, 'Teresia Muthoni', 33, 2),
(13, 'Joseph Moseti', 36, 2),
(14, 'Frank Obura', 37, 2),
(15, 'Benard Esadia', 39, 2),
(16, 'Moses Nyambane', 40, 7),
(18, 'Madam Justine', 49, 2),
(19, 'Madam Susan', 50, 2),
(20, 'jerevasio', 51, 4);

-- --------------------------------------------------------

--
-- Table structure for table `lecturer_qualifications`
--

DROP TABLE IF EXISTS `lecturer_qualifications`;
CREATE TABLE IF NOT EXISTS `lecturer_qualifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lecturer_id` int NOT NULL,
  `qualification` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lecturer_id` (`lecturer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `lecturer_qualifications`
--

INSERT INTO `lecturer_qualifications` (`id`, `lecturer_id`, `qualification`) VALUES
(1, 12, 'Internet Programming'),
(2, 12, 'Certified Information Systems Security Professional (CISSP)'),
(3, 12, 'Bachelors Degree in Computer Networks and Telecommunications'),
(4, 13, 'Internet Programming'),
(5, 14, 'Certified Analytics Professional (CAP)'),
(6, 14, 'Certified Six Sigma Green Belt'),
(7, 15, 'Certified Information Systems Security Professional (CISSP)'),
(8, 16, 'Diploma in ICT'),
(10, 18, 'Bachelors Degree in Computer Networks and Telecommunications'),
(11, 18, 'Bachelors Degree in Computer Networks and Telecommunications'),
(12, 19, ' Certified Information Systems Security Professional (CISSP)'),
(13, 20, 'A Bachelors degree in Building Technology and Technical Drawing');

-- --------------------------------------------------------

--
-- Table structure for table `lecturer_requests`
--

DROP TABLE IF EXISTS `lecturer_requests`;
CREATE TABLE IF NOT EXISTS `lecturer_requests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lecturer_id` int NOT NULL,
  `from_department_id` int NOT NULL,
  `to_department_id` int NOT NULL,
  `request_date` datetime NOT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  PRIMARY KEY (`id`),
  KEY `lecturer_id` (`lecturer_id`),
  KEY `from_department_id` (`from_department_id`),
  KEY `to_department_id` (`to_department_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lecturer_subjects`
--

DROP TABLE IF EXISTS `lecturer_subjects`;
CREATE TABLE IF NOT EXISTS `lecturer_subjects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lecturer_id` int NOT NULL,
  `subject_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lecturer_id` (`lecturer_id`),
  KEY `subject_id` (`subject_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `lecturer_subjects`
--

INSERT INTO `lecturer_subjects` (`id`, `lecturer_id`, `subject_id`) VALUES
(1, 16, 11),
(2, 12, 16),
(3, 13, 16),
(4, 12, 17),
(5, 15, 17),
(6, 12, 18),
(7, 14, 20),
(8, 18, 18),
(9, 18, 19),
(10, 19, 17),
(11, 20, 23);

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

DROP TABLE IF EXISTS `lessons`;
CREATE TABLE IF NOT EXISTS `lessons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `subject_id` int NOT NULL,
  `lesson_name` varchar(255) NOT NULL,
  `lecturer_id` int NOT NULL,
  `class_id` int NOT NULL,
  `repeat_until` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `day_of_week` varchar(10) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_lesson_subject` (`lesson_name`),
  KEY `subject_id` (`subject_id`),
  KEY `lecturer_id` (`lecturer_id`),
  KEY `class_id` (`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lesson_hours`
--

DROP TABLE IF EXISTS `lesson_hours`;
CREATE TABLE IF NOT EXISTS `lesson_hours` (
  `id` int NOT NULL AUTO_INCREMENT,
  `day_of_week` varchar(10) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

DROP TABLE IF EXISTS `levels`;
CREATE TABLE IF NOT EXISTS `levels` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `level` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`id`, `name`, `level`) VALUES
(1, 'Level 1', 1),
(2, 'Level 2', 2),
(3, 'Level 3', 3);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_id` int NOT NULL,
  `recipient_id` int NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('unread','read') NOT NULL DEFAULT 'unread',
  `file` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sender_id` (`sender_id`),
  KEY `recipient_id` (`recipient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `recipient_id`, `message`, `timestamp`, `status`, `file`) VALUES
(11, 1, 3, 'Report to your Respective Head of Department for updates ASAP,', '2024-07-05 20:02:52', 'read', NULL),
(16, 1, 3, '', '2024-07-08 17:52:35', 'read', '1720461155_PoM group.jpg'),
(17, 22, 1, 'Hello sir, kindly find attached the circular from the Director Training - NYS Headquarters', '2024-07-13 20:47:43', 'unread', '1720903663_demo-compressed-high.pdf'),
(19, 29, 3, 'Kindly report to my office for examination updates at 2 pm', '2024-07-23 22:07:08', 'unread', ''),
(20, 46, 29, 'help', '2024-08-14 07:55:33', 'unread', '');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `user_role` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `status` enum('unread','read') NOT NULL DEFAULT 'unread',
  `notification_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lesson_id` int NOT NULL,
  `user_id` int NOT NULL,
  `sender_id` int NOT NULL,
  `is_sent` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_lesson_id` (`lesson_id`),
  KEY `fk_user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1014 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `title`, `user_role`, `message`, `link`, `status`, `notification_time`, `lesson_id`, `user_id`, `sender_id`, `is_sent`) VALUES
(61, 'Account request', 'Principal', 'New account request from Jane Karimi in Automotive  department.<br>\n                             <button onclick=\"location.href=\'add_user.php?request_id=48&status=approved\'\">Approve</button> \n                             <button onclick=\"location.href=\'reject_request.php?request_id=48&status=rejected\'\">Reject</button>', NULL, 'read', '2024-07-30 11:51:27', 0, 0, 0, 0),
(62, 'Account request', 'Deputy Principal', 'New account request from Jane Karimi in Automotive  department.<br>\r\n                             <button onclick=\"location.href=\'add_user.php?request_id=48&status=approved\'\">Approve</button> \r\n                             <button onclick=\"location.href=\'reject_request.php?request_id=48&status=rejected\'\">Reject</button>', NULL, 'read', '2024-07-30 11:51:27', 0, 0, 0, 0),
(63, 'Account request', 'Principal', 'New account request from John Michuki in Avionics department.', 'add_user.php?request_id=49&status=approved', 'read', '2024-07-30 12:00:42', 0, 0, 0, 0),
(64, 'Account request', 'Deputy Principal', 'New account request from John Michuki in Avionics department.', 'reject_request.php?request_id=49&status=rejected', 'read', '2024-07-30 12:00:42', 0, 0, 0, 0),
(65, 'Allocations', 'lecturer', 'You have been allocated a new lesson.<br>Class: 84<br>Subject: 17<br>Start Time: 13:04<br>End Time: 15:15<br>Duration: 131 minutes<br>Day: Wednesday<br>', 'send_message.php', 'read', '2024-07-30 12:05:52', 0, 12, 46, 0),
(66, 'Automatic Lesson Track', 'lecturer', 'The lesson has been automatically marked as missed.', '', 'read', '2024-08-04 21:14:16', 7, 3, 1, 0),
(67, 'Automatic Lesson Track', 'lecturer', 'The lesson has been automatically marked as missed.', '', 'read', '2024-08-04 21:14:16', 8, 3, 1, 0),
(68, 'Account request', 'Principal', 'New account request from Jane Karimi in Automotive  department.', 'add_user.php?request_id=50&status=approved', 'unread', '2024-08-04 21:48:25', 0, 0, 0, 0),
(69, 'Account request', 'Deputy Principal', 'New account request from Jane Karimi in Automotive  department.', 'reject_request.php?request_id=50&status=rejected', 'read', '2024-08-04 21:48:25', 0, 0, 0, 0),
(70, '', '', 'Premature end of term: Set new term dates', NULL, 'unread', '2024-08-08 20:40:46', 0, 1, 0, 0),
(71, '', '', 'Premature end of term: Set new term dates', NULL, 'unread', '2024-08-08 20:40:46', 0, 3, 0, 0),
(72, '', '', 'Premature end of term: Set new term dates', NULL, 'unread', '2024-08-08 20:40:46', 0, 33, 0, 0),
(73, '', '', 'Premature end of term: Set new term dates', NULL, 'unread', '2024-08-08 20:40:46', 0, 34, 0, 0),
(74, '', '', 'Premature end of term: Set new term dates', NULL, 'unread', '2024-08-08 20:40:46', 0, 36, 0, 0),
(75, '', '', 'Premature end of term: Set new term dates', NULL, 'unread', '2024-08-08 20:40:46', 0, 37, 0, 0),
(76, '', '', 'Premature end of term: Set new term dates', NULL, 'unread', '2024-08-08 20:40:46', 0, 38, 0, 0),
(77, '', '', 'Premature end of term: Set new term dates', NULL, 'unread', '2024-08-08 20:40:46', 0, 39, 0, 0),
(78, '', '', 'Premature end of term: Set new term dates', NULL, 'unread', '2024-08-08 20:40:46', 0, 40, 0, 0),
(79, '', '', 'Premature end of term: Set new term dates', NULL, 'unread', '2024-08-08 20:40:46', 0, 44, 0, 0),
(80, '', '', 'Premature end of term: Set new term dates', NULL, 'unread', '2024-08-08 20:40:46', 0, 45, 0, 0),
(81, '', '', 'Premature end of term: Set new term dates', NULL, 'unread', '2024-08-08 20:40:46', 0, 46, 0, 0),
(82, '', '', 'Premature end of term: Set new term dates', NULL, 'unread', '2024-08-08 20:40:46', 0, 47, 0, 0),
(83, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 16 in class ICT 3 on Monday from 08:00:00 to 10:00:00.', NULL, 'read', '2024-08-08 22:04:45', 10, 46, 12, 0),
(84, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 20 in class ICT 3 on Monday from 10:15:00 to 12:15:00.', NULL, 'read', '2024-08-08 22:04:45', 11, 46, 14, 0),
(85, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 17 in class ICT 3 on Monday from 13:15:00 to 15:15:00.', NULL, 'read', '2024-08-08 22:04:45', 12, 46, 12, 0),
(86, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 18 in class ICT 3 on Monday from 15:30:00 to 17:30:00.', NULL, 'read', '2024-08-08 22:04:45', 13, 46, 12, 0),
(87, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Monday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:04:52', 0, 46, 46, 0),
(88, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:04:58', 0, 46, 46, 0),
(89, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:05:04', 0, 46, 46, 0),
(90, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:05:09', 0, 46, 46, 0),
(91, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:05:15', 0, 46, 46, 0),
(92, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:05:22', 0, 46, 46, 0),
(93, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Wednesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:05:29', 0, 46, 46, 0),
(94, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Wednesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:05:35', 0, 46, 46, 0),
(95, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Wednesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:05:41', 0, 46, 46, 0),
(96, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Wednesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:05:41', 0, 46, 46, 0),
(97, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Wednesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:05:41', 0, 46, 46, 0),
(98, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Thursday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:05:42', 0, 46, 46, 0),
(99, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Thursday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:05:42', 0, 46, 46, 0),
(100, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Thursday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:05:43', 0, 46, 46, 0),
(101, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Thursday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:05:43', 0, 46, 46, 0),
(102, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Thursday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:05:43', 0, 46, 46, 0),
(103, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Friday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:05:44', 0, 46, 46, 0),
(104, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Friday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:05:44', 0, 46, 46, 0),
(105, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Friday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:05:44', 0, 46, 46, 0),
(106, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Friday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:05:45', 0, 46, 46, 0),
(107, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Friday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:05:45', 0, 46, 46, 0),
(108, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 16 in class ICT 2 on Monday from 08:00:00 to 10:00:00.', NULL, 'read', '2024-08-08 22:05:45', 14, 46, 13, 0),
(109, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 17 in class ICT 2 on Monday from 10:15:00 to 12:15:00.', NULL, 'read', '2024-08-08 22:05:45', 15, 46, 15, 0),
(110, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 20 in class ICT 2 on Monday from 13:15:00 to 15:15:00.', NULL, 'read', '2024-08-08 22:05:45', 16, 46, 14, 0),
(111, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Monday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:05:46', 0, 46, 46, 0),
(112, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 18 in class ICT 2 on Monday from 17:45:00 to 18:30:00.', NULL, 'read', '2024-08-08 22:05:47', 17, 46, 12, 0),
(113, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:05:47', 0, 46, 46, 0),
(114, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:06:03', 0, 46, 46, 0),
(115, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:06:03', 0, 46, 46, 0),
(116, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:06:03', 0, 46, 46, 0),
(117, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:06:04', 0, 46, 46, 0),
(118, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Wednesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:06:04', 0, 46, 46, 0),
(119, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Wednesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:06:05', 0, 46, 46, 0),
(120, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Wednesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:06:05', 0, 46, 46, 0),
(121, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Wednesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:06:05', 0, 46, 46, 0),
(122, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Wednesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:06:06', 0, 46, 46, 0),
(123, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Thursday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:06:06', 0, 46, 46, 0),
(124, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Thursday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:06:06', 0, 46, 46, 0),
(125, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Thursday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:06:07', 0, 46, 46, 0),
(126, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Thursday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:06:07', 0, 46, 46, 0),
(127, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Thursday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:06:08', 0, 46, 46, 0),
(128, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Friday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:06:08', 0, 46, 46, 0),
(129, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Friday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:06:08', 0, 46, 46, 0),
(130, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Friday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:06:09', 0, 46, 46, 0),
(131, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Friday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:06:09', 0, 46, 46, 0),
(132, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Friday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:06:09', 0, 46, 46, 0),
(133, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 20 in class ICT 1 on Monday from 08:00:00 to 10:00:00.', NULL, 'read', '2024-08-08 22:06:09', 18, 46, 14, 0),
(134, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 16 in class ICT 1 on Monday from 10:15:00 to 12:15:00.', NULL, 'read', '2024-08-08 22:06:09', 19, 46, 13, 0),
(135, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 17 in class ICT 1 on Monday from 13:15:00 to 15:15:00.', NULL, 'read', '2024-08-08 22:06:09', 20, 46, 15, 0),
(136, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Monday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:06:10', 0, 46, 46, 0),
(137, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Monday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:06:10', 0, 46, 46, 0),
(138, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 18 in class ICT 1 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'read', '2024-08-08 22:06:10', 21, 46, 12, 0),
(139, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:06:11', 0, 46, 46, 0),
(140, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:06:11', 0, 46, 46, 0),
(141, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:06:11', 0, 46, 46, 0),
(142, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:06:12', 0, 46, 46, 0),
(143, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Wednesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:06:12', 0, 46, 46, 0),
(144, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Wednesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:06:12', 0, 46, 46, 0),
(145, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Wednesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:06:13', 0, 46, 46, 0),
(146, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Wednesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:06:13', 0, 46, 46, 0),
(147, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Wednesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:06:14', 0, 46, 46, 0),
(148, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Thursday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:06:14', 0, 46, 46, 0),
(149, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Thursday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:06:14', 0, 46, 46, 0),
(150, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Thursday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:06:30', 0, 46, 46, 0),
(151, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Thursday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:06:30', 0, 46, 46, 0),
(152, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Thursday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:06:31', 0, 46, 46, 0),
(153, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Friday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:06:31', 0, 46, 46, 0),
(154, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Friday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:06:32', 0, 46, 46, 0),
(155, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Friday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:06:32', 0, 46, 46, 0),
(156, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Friday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:06:34', 0, 46, 46, 0),
(157, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Friday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:06:34', 0, 46, 46, 0),
(158, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Monday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:06:35', 0, 46, 46, 0),
(159, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Monday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:06:36', 0, 46, 46, 0),
(160, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 16 in class Computer Studies 1 on Monday from 13:15:00 to 15:15:00.', NULL, 'read', '2024-08-08 22:06:36', 22, 46, 13, 0),
(161, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 20 in class Computer Studies 1 on Monday from 15:30:00 to 17:30:00.', NULL, 'read', '2024-08-08 22:06:36', 23, 46, 14, 0),
(162, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 17 in class Computer Studies 1 on Monday from 17:45:00 to 18:30:00.', NULL, 'read', '2024-08-08 22:06:36', 24, 46, 15, 0),
(163, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:06:37', 0, 46, 46, 0),
(164, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 18 in class Computer Studies 1 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'read', '2024-08-08 22:06:37', 25, 46, 12, 0),
(165, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:06:37', 0, 46, 46, 0),
(166, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:06:38', 0, 46, 46, 0),
(167, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:06:38', 0, 46, 46, 0),
(168, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Wednesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:06:38', 0, 46, 46, 0),
(169, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Wednesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:06:39', 0, 46, 46, 0),
(170, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Wednesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:06:39', 0, 46, 46, 0),
(171, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Wednesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:06:40', 0, 46, 46, 0),
(172, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Wednesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:06:40', 0, 46, 46, 0),
(173, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Thursday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:06:42', 0, 46, 46, 0),
(174, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Monday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:11:46', 0, 46, 46, 0),
(175, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Monday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:11:50', 0, 46, 46, 0),
(176, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Monday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:11:53', 0, 46, 46, 0),
(177, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 16 in class ICT 3 on Monday from 15:30:00 to 17:30:00.', NULL, 'read', '2024-08-08 22:11:53', 26, 46, 13, 0),
(178, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 20 in class ICT 3 on Monday from 17:45:00 to 18:30:00.', NULL, 'read', '2024-08-08 22:11:53', 27, 46, 14, 0),
(179, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 17 in class ICT 3 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'read', '2024-08-08 22:11:53', 28, 46, 15, 0),
(180, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:11:57', 0, 46, 46, 0),
(181, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 18 in class ICT 3 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'read', '2024-08-08 22:11:57', 29, 46, 12, 0),
(182, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:12:00', 0, 46, 46, 0),
(183, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:12:04', 0, 46, 46, 0),
(184, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Wednesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:12:07', 0, 46, 46, 0),
(185, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Wednesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:12:11', 0, 46, 46, 0),
(186, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Wednesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:12:14', 0, 46, 46, 0),
(187, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Wednesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:12:18', 0, 46, 46, 0),
(188, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Wednesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:12:21', 0, 46, 46, 0),
(189, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Thursday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:12:24', 0, 46, 46, 0),
(190, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Thursday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:12:27', 0, 46, 46, 0),
(191, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Monday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:17:19', 0, 46, 46, 0),
(192, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Monday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:17:23', 0, 46, 46, 0),
(193, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Monday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:17:26', 0, 46, 46, 0),
(194, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 17 in class ICT 3 on Monday from 15:30:00 to 17:30:00.', NULL, 'read', '2024-08-08 22:17:26', 30, 46, 15, 0),
(195, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 16 in class ICT 3 on Monday from 17:45:00 to 18:30:00.', NULL, 'read', '2024-08-08 22:17:26', 31, 46, 13, 0),
(196, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 20 in class ICT 3 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'read', '2024-08-08 22:17:26', 32, 46, 14, 0),
(197, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:17:30', 0, 46, 46, 0),
(198, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:17:34', 0, 46, 46, 0),
(199, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 18 in class ICT 3 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'read', '2024-08-08 22:17:34', 33, 46, 12, 0),
(200, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:17:37', 0, 46, 46, 0),
(201, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Wednesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:17:41', 0, 46, 46, 0),
(202, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Wednesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:17:45', 0, 46, 46, 0),
(203, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Wednesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:17:49', 0, 46, 46, 0),
(204, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Wednesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:17:52', 0, 46, 46, 0),
(205, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Wednesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:17:56', 0, 46, 46, 0),
(206, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Thursday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:17:59', 0, 46, 46, 0),
(207, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Thursday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:18:03', 0, 46, 46, 0),
(208, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Thursday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:18:06', 0, 46, 46, 0),
(209, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Thursday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:18:10', 0, 46, 46, 0),
(210, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Thursday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:18:29', 0, 46, 46, 0),
(211, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Friday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:18:33', 0, 46, 46, 0),
(212, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Friday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:18:36', 0, 46, 46, 0),
(213, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Friday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:18:40', 0, 46, 46, 0),
(214, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Friday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:18:44', 0, 46, 46, 0),
(215, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Friday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:18:48', 0, 46, 46, 0),
(216, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Monday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:18:51', 0, 46, 46, 0),
(217, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Monday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:18:55', 0, 46, 46, 0),
(218, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Monday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:18:58', 0, 46, 46, 0),
(219, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Monday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:19:07', 0, 46, 46, 0),
(220, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Monday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:19:11', 0, 46, 46, 0),
(221, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 16 in class ICT 2 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'read', '2024-08-08 22:19:11', 34, 46, 13, 0),
(222, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 20 in class ICT 2 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'read', '2024-08-08 22:19:11', 35, 46, 14, 0),
(223, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 17 in class ICT 2 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'read', '2024-08-08 22:19:11', 36, 46, 15, 0),
(224, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:19:14', 0, 46, 46, 0),
(225, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 18 in class ICT 2 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'read', '2024-08-08 22:19:14', 37, 46, 12, 0),
(226, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Monday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:33', 0, 46, 46, 0),
(227, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Monday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:33', 0, 46, 46, 0),
(228, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Monday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:33', 0, 46, 46, 0),
(229, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Monday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:33', 0, 46, 46, 0),
(230, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Monday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:33', 0, 46, 46, 0),
(231, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:33', 0, 46, 46, 0),
(232, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 16 in class ICT 3 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'read', '2024-08-08 22:21:33', 38, 46, 13, 0),
(233, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 20 in class ICT 3 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'read', '2024-08-08 22:21:34', 39, 46, 14, 0),
(234, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 17 in class ICT 3 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'read', '2024-08-08 22:21:34', 40, 46, 15, 0),
(235, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(236, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 18 in class ICT 3 on Wednesday from 08:00:00 to 10:00:00.', NULL, 'read', '2024-08-08 22:21:34', 41, 46, 12, 0),
(237, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Wednesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(238, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Wednesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(239, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Wednesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(240, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Wednesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(241, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Thursday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(242, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Thursday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(243, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Thursday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(244, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Thursday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(245, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Thursday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(246, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Friday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(247, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Friday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(248, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Friday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(249, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Friday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(250, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Friday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(251, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Monday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(252, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Monday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(253, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Monday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(254, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Monday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(255, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Monday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(256, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(257, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 17 in class ICT 2 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'read', '2024-08-08 22:21:34', 42, 46, 15, 0),
(258, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 16 in class ICT 2 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'read', '2024-08-08 22:21:34', 43, 46, 13, 0),
(259, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 20 in class ICT 2 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'read', '2024-08-08 22:21:34', 44, 46, 14, 0),
(260, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(261, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Wednesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(262, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 18 in class ICT 2 on Wednesday from 10:15:00 to 12:15:00.', NULL, 'read', '2024-08-08 22:21:34', 45, 46, 12, 0),
(263, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Wednesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(264, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Wednesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(265, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Wednesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(266, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Thursday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(267, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Thursday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(268, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Thursday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(269, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Thursday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(270, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Thursday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(271, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Friday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(272, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Friday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(273, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Friday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(274, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Friday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(275, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Friday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(276, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Monday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(277, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Monday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(278, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Monday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(279, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Monday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(280, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Monday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(281, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(282, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(283, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(284, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 16 in class ICT 1 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'read', '2024-08-08 22:21:34', 46, 46, 13, 0),
(285, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 20 in class ICT 1 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'read', '2024-08-08 22:21:34', 47, 46, 14, 0),
(286, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 17 in class ICT 1 on Wednesday from 08:00:00 to 10:00:00.', NULL, 'read', '2024-08-08 22:21:34', 48, 46, 15, 0),
(287, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Wednesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(288, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 18 in class ICT 1 on Wednesday from 13:15:00 to 15:15:00.', NULL, 'read', '2024-08-08 22:21:34', 49, 46, 12, 0),
(289, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Wednesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(290, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Wednesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(291, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Thursday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(292, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Thursday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(293, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Thursday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(294, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Thursday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(295, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Thursday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(296, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Friday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(297, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Friday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(298, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Friday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(299, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Friday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(300, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Friday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(301, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Monday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(302, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Monday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(303, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Monday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(304, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Monday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(305, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Monday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(306, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(307, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(308, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(309, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(310, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 16 in class Computer Studies 1 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'read', '2024-08-08 22:21:34', 50, 46, 13, 0),
(311, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 20 in class Computer Studies 1 on Wednesday from 08:00:00 to 10:00:00.', NULL, 'read', '2024-08-08 22:21:34', 51, 46, 14, 0),
(312, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 17 in class Computer Studies 1 on Wednesday from 10:15:00 to 12:15:00.', NULL, 'read', '2024-08-08 22:21:34', 52, 46, 15, 0),
(313, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Wednesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(314, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 18 in class Computer Studies 1 on Wednesday from 15:30:00 to 17:30:00.', NULL, 'read', '2024-08-08 22:21:34', 53, 46, 12, 0),
(315, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Wednesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(316, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Thursday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(317, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Thursday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(318, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Thursday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(319, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Thursday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(320, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Thursday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(321, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Friday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(322, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Friday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(323, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Friday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(324, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Friday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(325, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Friday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(326, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Monday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(327, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Monday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0);
INSERT INTO `notifications` (`id`, `title`, `user_role`, `message`, `link`, `status`, `notification_time`, `lesson_id`, `user_id`, `sender_id`, `is_sent`) VALUES
(328, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Monday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(329, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Monday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(330, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Monday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(331, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(332, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(333, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(334, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(335, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 17 in class Computer Studies 2 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'read', '2024-08-08 22:21:34', 54, 46, 15, 0),
(336, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 16 in class Computer Studies 2 on Wednesday from 08:00:00 to 10:00:00.', NULL, 'read', '2024-08-08 22:21:34', 55, 46, 13, 0),
(337, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 20 in class Computer Studies 2 on Wednesday from 10:15:00 to 12:15:00.', NULL, 'read', '2024-08-08 22:21:34', 56, 46, 14, 0),
(338, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Wednesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(339, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Wednesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(340, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 18 in class Computer Studies 2 on Wednesday from 17:45:00 to 18:30:00.', NULL, 'read', '2024-08-08 22:21:34', 57, 46, 12, 0),
(341, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Thursday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(342, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Thursday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(343, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Thursday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(344, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Thursday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(345, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Thursday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(346, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Friday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(347, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Friday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(348, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Friday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(349, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Friday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(350, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Friday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(351, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Monday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(352, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Monday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(353, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Monday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(354, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Monday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(355, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Monday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(356, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(357, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(358, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(359, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(360, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(361, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Wednesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(362, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 16 in class Computer Studies 3 on Wednesday from 10:15:00 to 12:15:00.', NULL, 'read', '2024-08-08 22:21:34', 58, 46, 13, 0),
(363, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 20 in class Computer Studies 3 on Wednesday from 13:15:00 to 15:15:00.', NULL, 'read', '2024-08-08 22:21:34', 59, 46, 14, 0),
(364, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 17 in class Computer Studies 3 on Wednesday from 15:30:00 to 17:30:00.', NULL, 'read', '2024-08-08 22:21:34', 60, 46, 15, 0),
(365, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Wednesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(366, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 18 in class Computer Studies 3 on Thursday from 08:00:00 to 10:00:00.', NULL, 'read', '2024-08-08 22:21:34', 61, 46, 12, 0),
(367, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Thursday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(368, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Thursday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(369, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Thursday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(370, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Thursday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(371, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Friday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(372, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Friday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(373, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Friday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(374, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Friday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(375, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Friday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(376, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Monday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(377, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Monday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(378, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Monday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(379, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Monday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(380, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Monday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(381, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(382, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(383, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(384, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(385, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(386, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Wednesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(387, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Wednesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(388, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 16 in class Telecom 1 on Wednesday from 13:15:00 to 15:15:00.', NULL, 'read', '2024-08-08 22:21:34', 62, 46, 13, 0),
(389, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 20 in class Telecom 1 on Wednesday from 15:30:00 to 17:30:00.', NULL, 'read', '2024-08-08 22:21:34', 63, 46, 14, 0),
(390, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 17 in class Telecom 1 on Wednesday from 17:45:00 to 18:30:00.', NULL, 'read', '2024-08-08 22:21:34', 64, 46, 15, 0),
(391, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Thursday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(392, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 18 in class Telecom 1 on Thursday from 10:15:00 to 12:15:00.', NULL, 'read', '2024-08-08 22:21:34', 65, 46, 12, 0),
(393, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Thursday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(394, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Thursday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(395, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Thursday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(396, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Friday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(397, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Friday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(398, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Friday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(399, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Friday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(400, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Friday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(401, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Monday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(402, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Monday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(403, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Monday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(404, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Monday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(405, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Monday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(406, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(407, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(408, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(409, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(410, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(411, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Wednesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(412, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Wednesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(413, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 17 in class Telecom 2 on Wednesday from 13:15:00 to 15:15:00.', NULL, 'read', '2024-08-08 22:21:34', 66, 46, 15, 0),
(414, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 16 in class Telecom 2 on Wednesday from 15:30:00 to 17:30:00.', NULL, 'read', '2024-08-08 22:21:34', 67, 46, 13, 0),
(415, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 20 in class Telecom 2 on Wednesday from 17:45:00 to 18:30:00.', NULL, 'read', '2024-08-08 22:21:34', 68, 46, 14, 0),
(416, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Thursday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(417, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Thursday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(418, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 18 in class Telecom 2 on Thursday from 13:15:00 to 15:15:00.', NULL, 'read', '2024-08-08 22:21:34', 69, 46, 12, 0),
(419, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Thursday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(420, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Thursday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(421, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Friday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(422, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Friday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(423, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Friday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(424, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Friday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(425, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Friday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(426, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Monday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(427, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Monday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(428, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Monday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(429, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Monday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(430, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Monday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(431, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(432, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(433, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(434, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(435, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(436, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Wednesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(437, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Wednesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(438, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Wednesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(439, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Wednesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(440, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 16 in class Telecom 3 on Wednesday from 17:45:00 to 18:30:00.', NULL, 'read', '2024-08-08 22:21:34', 70, 46, 13, 0),
(441, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 20 in class Telecom 3 on Thursday from 08:00:00 to 10:00:00.', NULL, 'read', '2024-08-08 22:21:34', 71, 46, 14, 0),
(442, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 17 in class Telecom 3 on Thursday from 10:15:00 to 12:15:00.', NULL, 'read', '2024-08-08 22:21:34', 72, 46, 15, 0),
(443, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Thursday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(444, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 18 in class Telecom 3 on Thursday from 15:30:00 to 17:30:00.', NULL, 'read', '2024-08-08 22:21:34', 73, 46, 12, 0),
(445, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Thursday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(446, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Friday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(447, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Friday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(448, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Friday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(449, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Friday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(450, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Friday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:21:34', 0, 46, 46, 0),
(451, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Monday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(452, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Monday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(453, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Monday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(454, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Monday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(455, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Monday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(456, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(457, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(458, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(459, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(460, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(461, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Wednesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(462, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Wednesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(463, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Wednesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(464, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Wednesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(465, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Wednesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(466, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 16 in class ICT 3 on Thursday from 08:00:00 to 10:00:00.', NULL, 'read', '2024-08-08 22:22:32', 74, 46, 13, 0),
(467, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 20 in class ICT 3 on Thursday from 10:15:00 to 12:15:00.', NULL, 'read', '2024-08-08 22:22:32', 75, 46, 14, 0),
(468, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 17 in class ICT 3 on Thursday from 13:15:00 to 15:15:00.', NULL, 'read', '2024-08-08 22:22:32', 76, 46, 15, 0),
(469, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Thursday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(470, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 18 in class ICT 3 on Thursday from 17:45:00 to 18:30:00.', NULL, 'read', '2024-08-08 22:22:32', 77, 46, 12, 0),
(471, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Friday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(472, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Friday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(473, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Friday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(474, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Friday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(475, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Friday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(476, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Monday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(477, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Monday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(478, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Monday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(479, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Monday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(480, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Monday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(481, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(482, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(483, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(484, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(485, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(486, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Wednesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(487, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Wednesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(488, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Wednesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(489, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Wednesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(490, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Wednesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(491, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 17 in class ICT 2 on Thursday from 08:00:00 to 10:00:00.', NULL, 'read', '2024-08-08 22:22:32', 78, 46, 15, 0),
(492, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 16 in class ICT 2 on Thursday from 10:15:00 to 12:15:00.', NULL, 'read', '2024-08-08 22:22:32', 79, 46, 13, 0),
(493, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 20 in class ICT 2 on Thursday from 13:15:00 to 15:15:00.', NULL, 'read', '2024-08-08 22:22:32', 80, 46, 14, 0),
(494, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Thursday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(495, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Thursday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(496, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 18 in class ICT 2 on Friday from 08:00:00 to 10:00:00.', NULL, 'read', '2024-08-08 22:22:32', 81, 46, 12, 0),
(497, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Friday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(498, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Friday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(499, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Friday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(500, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Friday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(501, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Monday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(502, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Monday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(503, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Monday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(504, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Monday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(505, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Monday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(506, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(507, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(508, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(509, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(510, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(511, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Wednesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(512, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Wednesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(513, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Wednesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(514, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Wednesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(515, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Wednesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(516, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Thursday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(517, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Thursday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(518, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 16 in class ICT 1 on Thursday from 13:15:00 to 15:15:00.', NULL, 'read', '2024-08-08 22:22:32', 82, 46, 13, 0),
(519, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 20 in class ICT 1 on Thursday from 15:30:00 to 17:30:00.', NULL, 'read', '2024-08-08 22:22:32', 83, 46, 14, 0),
(520, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 17 in class ICT 1 on Thursday from 17:45:00 to 18:30:00.', NULL, 'read', '2024-08-08 22:22:32', 84, 46, 15, 0),
(521, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Friday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(522, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 18 in class ICT 1 on Friday from 10:15:00 to 12:15:00.', NULL, 'read', '2024-08-08 22:22:32', 85, 46, 12, 0),
(523, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Friday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(524, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Friday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(525, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Friday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(526, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Monday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(527, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Monday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(528, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Monday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(529, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Monday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(530, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Monday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(531, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(532, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(533, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(534, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(535, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(536, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Wednesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(537, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Wednesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(538, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Wednesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(539, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Wednesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(540, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Wednesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(541, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Thursday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(542, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Thursday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(543, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Thursday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(544, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 16 in class Computer Studies 1 on Thursday from 15:30:00 to 17:30:00.', NULL, 'read', '2024-08-08 22:22:32', 86, 46, 13, 0),
(545, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 20 in class Computer Studies 1 on Thursday from 17:45:00 to 18:30:00.', NULL, 'read', '2024-08-08 22:22:32', 87, 46, 14, 0),
(546, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 17 in class Computer Studies 1 on Friday from 08:00:00 to 10:00:00.', NULL, 'read', '2024-08-08 22:22:32', 88, 46, 15, 0),
(547, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Friday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(548, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 18 in class Computer Studies 1 on Friday from 13:15:00 to 15:15:00.', NULL, 'read', '2024-08-08 22:22:32', 89, 46, 12, 0),
(549, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Friday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(550, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Friday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(551, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Monday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(552, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Monday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(553, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Monday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(554, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Monday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(555, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Monday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(556, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(557, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(558, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(559, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(560, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(561, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Wednesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(562, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Wednesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(563, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Wednesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(564, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Wednesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(565, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Wednesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(566, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Thursday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(567, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Thursday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(568, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Thursday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(569, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 17 in class Computer Studies 2 on Thursday from 15:30:00 to 17:30:00.', NULL, 'read', '2024-08-08 22:22:32', 90, 46, 15, 0),
(570, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 16 in class Computer Studies 2 on Thursday from 17:45:00 to 18:30:00.', NULL, 'read', '2024-08-08 22:22:32', 91, 46, 13, 0),
(571, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 20 in class Computer Studies 2 on Friday from 08:00:00 to 10:00:00.', NULL, 'read', '2024-08-08 22:22:32', 92, 46, 14, 0),
(572, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Friday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(573, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Friday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(574, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 18 in class Computer Studies 2 on Friday from 15:30:00 to 17:30:00.', NULL, 'read', '2024-08-08 22:22:32', 93, 46, 12, 0),
(575, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Friday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(576, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Monday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(577, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Monday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(578, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Monday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(579, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Monday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(580, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Monday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(581, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(582, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(583, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(584, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(585, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0);
INSERT INTO `notifications` (`id`, `title`, `user_role`, `message`, `link`, `status`, `notification_time`, `lesson_id`, `user_id`, `sender_id`, `is_sent`) VALUES
(586, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Wednesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(587, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Wednesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(588, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Wednesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(589, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Wednesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(590, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Wednesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(591, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Thursday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(592, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Thursday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(593, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Thursday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(594, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Thursday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(595, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Thursday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(596, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 16 in class Computer Studies 3 on Friday from 08:00:00 to 10:00:00.', NULL, 'read', '2024-08-08 22:22:32', 94, 46, 13, 0),
(597, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 20 in class Computer Studies 3 on Friday from 10:15:00 to 12:15:00.', NULL, 'read', '2024-08-08 22:22:32', 95, 46, 14, 0),
(598, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 17 in class Computer Studies 3 on Friday from 13:15:00 to 15:15:00.', NULL, 'read', '2024-08-08 22:22:32', 96, 46, 15, 0),
(599, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Friday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(600, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 18 in class Computer Studies 3 on Friday from 17:45:00 to 18:30:00.', NULL, 'read', '2024-08-08 22:22:32', 97, 46, 12, 0),
(601, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Monday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(602, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Monday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(603, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Monday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(604, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Monday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(605, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Monday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(606, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(607, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(608, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(609, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(610, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(611, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Wednesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(612, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Wednesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(613, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Wednesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(614, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Wednesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(615, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Wednesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(616, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Thursday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(617, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Thursday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(618, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Thursday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(619, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Thursday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(620, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Thursday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(621, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Friday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(622, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 16 in class Telecom 1 on Friday from 10:15:00 to 12:15:00.', NULL, 'read', '2024-08-08 22:22:32', 98, 46, 13, 0),
(623, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 20 in class Telecom 1 on Friday from 13:15:00 to 15:15:00.', NULL, 'read', '2024-08-08 22:22:32', 99, 46, 14, 0),
(624, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 17 in class Telecom 1 on Friday from 15:30:00 to 17:30:00.', NULL, 'read', '2024-08-08 22:22:32', 100, 46, 15, 0),
(625, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Friday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(626, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Monday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(627, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Monday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(628, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Monday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(629, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Monday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(630, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Monday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(631, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(632, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(633, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(634, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(635, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(636, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Wednesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(637, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Wednesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(638, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Wednesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(639, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Wednesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(640, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Wednesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(641, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Thursday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(642, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Thursday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(643, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Thursday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(644, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Thursday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(645, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Thursday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(646, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Friday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(647, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 17 in class Telecom 2 on Friday from 10:15:00 to 12:15:00.', NULL, 'read', '2024-08-08 22:22:32', 101, 46, 15, 0),
(648, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 16 in class Telecom 2 on Friday from 13:15:00 to 15:15:00.', NULL, 'read', '2024-08-08 22:22:32', 102, 46, 13, 0),
(649, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 20 in class Telecom 2 on Friday from 15:30:00 to 17:30:00.', NULL, 'read', '2024-08-08 22:22:32', 103, 46, 14, 0),
(650, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Friday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(651, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Monday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(652, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Monday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(653, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Monday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(654, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Monday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(655, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Monday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(656, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(657, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(658, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(659, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(660, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(661, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Wednesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(662, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Wednesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(663, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Wednesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(664, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Wednesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(665, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Wednesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(666, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Thursday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(667, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Thursday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(668, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Thursday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(669, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Thursday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(670, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Thursday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(671, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Friday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(672, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Friday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(673, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Friday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:22:32', 0, 46, 46, 0),
(674, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 16 in class Telecom 3 on Friday from 15:30:00 to 17:30:00.', NULL, 'read', '2024-08-08 22:22:32', 104, 46, 13, 0),
(675, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject ID 20 in class Telecom 3 on Friday from 17:45:00 to 18:30:00.', NULL, 'read', '2024-08-08 22:22:32', 105, 46, 14, 0),
(676, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Monday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:26', 0, 46, 46, 0),
(677, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Monday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:26', 0, 46, 46, 0),
(678, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Monday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:26', 0, 46, 46, 0),
(679, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Monday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:26', 0, 46, 46, 0),
(680, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Monday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:26', 0, 46, 46, 0),
(681, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:26', 0, 46, 46, 0),
(682, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:26', 0, 46, 46, 0),
(683, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(684, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(685, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(686, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Wednesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(687, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Wednesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(688, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Wednesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(689, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Wednesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(690, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Wednesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(691, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Thursday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(692, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Thursday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(693, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Thursday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(694, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Thursday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(695, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Thursday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(696, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Friday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(697, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Friday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(698, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Friday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(699, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 3 on Friday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(700, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Internet Based Programming (IBP)\' in class ICT 3 on Friday from 17:45:00 to 18:30:00.', NULL, 'read', '2024-08-08 22:28:27', 106, 46, 13, 0),
(701, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Monday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(702, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Monday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(703, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Monday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(704, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Monday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(705, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Monday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(706, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(707, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(708, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(709, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(710, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(711, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Wednesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(712, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Wednesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(713, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Wednesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(714, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Wednesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(715, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Wednesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(716, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Thursday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(717, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Thursday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(718, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Thursday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(719, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Thursday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(720, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Thursday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(721, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Friday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(722, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Friday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(723, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Friday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(724, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 2 on Friday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(725, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Management Information System (MIS)\' in class ICT 2 on Friday from 17:45:00 to 18:30:00.', NULL, 'read', '2024-08-08 22:28:27', 107, 46, 15, 0),
(726, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Monday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(727, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Monday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(728, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Monday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(729, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Monday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(730, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Monday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(731, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(732, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(733, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(734, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(735, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(736, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Wednesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(737, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Wednesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(738, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Wednesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(739, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Wednesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(740, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Wednesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(741, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Thursday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(742, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Thursday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(743, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Thursday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(744, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Thursday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(745, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Thursday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(746, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Friday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(747, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Friday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(748, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Friday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(749, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Friday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(750, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class ICT 1 on Friday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(751, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Monday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(752, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Monday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(753, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Monday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(754, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Monday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(755, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Monday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(756, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(757, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(758, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(759, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(760, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(761, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Wednesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(762, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Wednesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(763, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Wednesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(764, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Wednesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(765, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Wednesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(766, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Thursday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(767, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Thursday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(768, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Thursday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(769, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Thursday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(770, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Thursday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(771, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Friday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(772, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Friday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(773, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Friday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(774, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Friday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(775, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 1 on Friday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(776, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Monday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(777, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Monday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(778, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Monday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(779, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Monday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(780, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Monday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(781, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(782, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(783, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(784, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(785, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(786, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Wednesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(787, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Wednesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(788, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Wednesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(789, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Wednesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(790, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Wednesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(791, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Thursday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(792, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Thursday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(793, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Thursday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(794, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Thursday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(795, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Thursday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(796, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Friday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(797, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Friday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(798, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Friday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(799, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Friday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(800, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 2 on Friday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(801, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Monday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(802, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Monday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(803, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Monday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(804, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Monday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(805, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Monday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(806, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(807, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(808, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(809, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(810, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(811, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Wednesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(812, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Wednesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(813, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Wednesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(814, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Wednesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(815, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Wednesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(816, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Thursday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(817, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Thursday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(818, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Thursday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(819, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Thursday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(820, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Thursday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(821, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Friday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(822, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Friday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(823, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Friday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(824, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Friday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(825, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Computer Studies 3 on Friday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(826, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Monday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(827, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Monday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(828, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Monday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(829, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Monday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(830, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Monday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(831, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(832, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(833, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(834, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(835, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(836, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Wednesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(837, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Wednesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(838, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Wednesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(839, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Wednesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(840, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Wednesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(841, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Thursday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(842, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Thursday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(843, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Thursday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(844, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Thursday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(845, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Thursday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0);
INSERT INTO `notifications` (`id`, `title`, `user_role`, `message`, `link`, `status`, `notification_time`, `lesson_id`, `user_id`, `sender_id`, `is_sent`) VALUES
(846, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Friday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(847, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Friday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(848, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Friday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(849, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Friday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(850, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 1 on Friday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(851, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Monday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(852, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Monday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(853, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Monday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(854, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Monday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(855, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Monday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(856, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(857, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(858, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(859, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(860, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(861, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Wednesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(862, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Wednesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(863, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Wednesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(864, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Wednesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(865, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Wednesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(866, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Thursday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(867, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Thursday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(868, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Thursday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(869, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Thursday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(870, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Thursday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(871, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Friday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(872, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Friday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(873, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Friday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(874, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Friday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(875, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 2 on Friday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(876, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Monday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(877, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Monday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(878, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Monday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(879, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Monday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(880, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Monday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(881, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(882, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(883, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(884, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(885, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(886, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Wednesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(887, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Wednesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(888, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Wednesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(889, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Wednesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(890, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Wednesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(891, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Thursday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(892, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Thursday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(893, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Thursday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(894, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Thursday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(895, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Thursday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(896, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Friday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(897, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Friday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(898, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Friday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(899, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Friday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(900, 'No Available Lecturer', 'Admin', 'No available lecturers to allocate for class Telecom 3 on Friday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:28:27', 0, 46, 46, 0),
(901, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 3 on Monday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:32:08', 0, 46, 46, 0),
(902, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 3 on Monday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:32:12', 0, 46, 46, 0),
(903, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 3 on Monday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:32:15', 0, 46, 46, 0),
(904, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 3 on Monday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:32:18', 0, 46, 46, 0),
(905, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 3 on Monday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:32:22', 0, 46, 46, 0),
(906, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 3 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:32:25', 0, 46, 46, 0),
(907, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 3 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:32:28', 0, 46, 46, 0),
(908, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 3 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:32:31', 0, 46, 46, 0),
(909, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 3 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:32:35', 0, 46, 46, 0),
(910, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 3 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:32:38', 0, 46, 46, 0),
(911, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 3 on Wednesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:32:41', 0, 46, 46, 0),
(912, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 3 on Wednesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:32:45', 0, 46, 46, 0),
(913, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 3 on Wednesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:32:48', 0, 46, 46, 0),
(914, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 3 on Wednesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:32:51', 0, 46, 46, 0),
(915, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 3 on Wednesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:32:55', 0, 46, 46, 0),
(916, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 3 on Thursday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:32:58', 0, 46, 46, 0),
(917, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 3 on Thursday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:33:02', 0, 46, 46, 0),
(918, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 3 on Thursday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:33:05', 0, 46, 46, 0),
(919, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 3 on Thursday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:33:08', 0, 46, 46, 0),
(920, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 3 on Thursday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:33:12', 0, 46, 46, 0),
(921, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 3 on Friday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:33:15', 0, 46, 46, 0),
(922, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 3 on Friday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:33:19', 0, 46, 46, 0),
(923, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 3 on Friday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:33:23', 0, 46, 46, 0),
(924, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 3 on Friday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:33:26', 0, 46, 46, 0),
(925, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 3 on Friday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:33:30', 0, 46, 46, 0),
(926, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 2 on Monday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:33:33', 0, 46, 46, 0),
(927, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 2 on Monday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:33:36', 0, 46, 46, 0),
(928, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 2 on Monday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:33:40', 0, 46, 46, 0),
(929, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 2 on Monday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:33:43', 0, 46, 46, 0),
(930, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 2 on Monday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:33:47', 0, 46, 46, 0),
(931, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 2 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:33:51', 0, 46, 46, 0),
(932, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 2 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'unread', '2024-08-08 22:33:54', 0, 46, 46, 0),
(933, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 2 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'unread', '2024-08-08 22:33:58', 0, 46, 46, 0),
(934, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 2 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-08 22:34:01', 0, 46, 46, 0),
(935, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 2 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:34:05', 0, 46, 46, 0),
(936, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 3 on Monday from 08:00:00 to 10:00:00.', NULL, 'unread', '2024-08-08 22:38:20', 0, 46, 46, 0),
(937, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Internet Based Programming (IBP)\' in class ICT 3 on Monday from 08:00:00 to 10:00:00.', NULL, 'read', '2024-08-08 22:49:31', 108, 46, 12, 0),
(938, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Management Information System (MIS)\' in class ICT 3 on Monday from 10:15:00 to 12:15:00.', NULL, 'read', '2024-08-08 22:49:31', 109, 46, 12, 0),
(939, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Data Communication\' in class ICT 3 on Monday from 13:15:00 to 15:15:00.', NULL, 'read', '2024-08-08 22:49:31', 110, 46, 12, 0),
(940, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Quantitative Techniques\' in class ICT 3 on Monday from 15:30:00 to 17:30:00.', NULL, 'read', '2024-08-08 22:49:31', 111, 46, 14, 0),
(941, 'No Available Lecturer', 'User', 'No available lecturers to allocate for class ICT 3 on Monday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-08 22:49:36', 0, 46, 46, 0),
(942, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Internet Based Programming (IBP)\' in class ICT 2 on Monday from 08:00:00 to 10:00:00.', NULL, 'read', '2024-08-08 22:49:39', 112, 46, 13, 0),
(943, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Quantitative Techniques\' in class ICT 2 on Monday from 10:15:00 to 12:15:00.', NULL, 'read', '2024-08-08 22:49:39', 113, 46, 14, 0),
(944, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Management Information System (MIS)\' in class ICT 2 on Monday from 13:15:00 to 15:15:00.', NULL, 'read', '2024-08-08 22:49:39', 114, 46, 15, 0),
(945, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Data Communication\' in class ICT 2 on Monday from 15:30:00 to 17:30:00.', NULL, 'read', '2024-08-08 22:49:39', 115, 46, 12, 0),
(946, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Quantitative Techniques\' in class ICT 1 on Monday from 08:00:00 to 10:00:00.', NULL, 'read', '2024-08-08 22:49:39', 116, 46, 14, 0),
(947, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Internet Based Programming (IBP)\' in class ICT 1 on Monday from 10:15:00 to 12:15:00.', NULL, 'read', '2024-08-08 22:49:39', 117, 46, 13, 0),
(948, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Management Information System (MIS)\' in class ICT 1 on Monday from 15:30:00 to 17:30:00.', NULL, 'read', '2024-08-08 22:49:39', 118, 46, 15, 0),
(949, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Data Communication\' in class ICT 1 on Monday from 17:45:00 to 18:30:00.', NULL, 'read', '2024-08-08 22:49:39', 119, 46, 12, 0),
(950, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Management Information System (MIS)\' in class Computer Studies 1 on Monday from 08:00:00 to 10:00:00.', NULL, 'read', '2024-08-08 22:49:39', 120, 46, 15, 0),
(951, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Internet Based Programming (IBP)\' in class Computer Studies 1 on Monday from 13:15:00 to 15:15:00.', NULL, 'read', '2024-08-08 22:49:39', 121, 46, 13, 0),
(952, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Quantitative Techniques\' in class Computer Studies 1 on Monday from 17:45:00 to 18:30:00.', NULL, 'read', '2024-08-08 22:49:39', 122, 46, 14, 0),
(953, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Data Communication\' in class Computer Studies 1 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'read', '2024-08-08 22:49:39', 123, 46, 12, 0),
(954, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Management Information System (MIS)\' in class Computer Studies 2 on Monday from 10:15:00 to 12:15:00.', NULL, 'read', '2024-08-08 22:49:39', 124, 46, 15, 0),
(955, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Quantitative Techniques\' in class Computer Studies 2 on Monday from 13:15:00 to 15:15:00.', NULL, 'read', '2024-08-08 22:49:39', 125, 46, 14, 0),
(956, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Internet Based Programming (IBP)\' in class Computer Studies 2 on Monday from 15:30:00 to 17:30:00.', NULL, 'read', '2024-08-08 22:49:39', 126, 46, 13, 0),
(957, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Data Communication\' in class Computer Studies 2 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'read', '2024-08-08 22:49:39', 127, 46, 12, 0),
(958, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Internet Based Programming (IBP)\' in class Computer Studies 3 on Monday from 17:45:00 to 18:30:00.', NULL, 'read', '2024-08-08 22:49:39', 128, 46, 13, 0),
(959, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Quantitative Techniques\' in class Computer Studies 3 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'read', '2024-08-08 22:49:39', 129, 46, 14, 0),
(960, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Management Information System (MIS)\' in class Computer Studies 3 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'read', '2024-08-08 22:49:39', 130, 46, 15, 0),
(961, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Data Communication\' in class Computer Studies 3 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'read', '2024-08-08 22:49:39', 131, 46, 12, 0),
(962, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Management Information System (MIS)\' in class Telecom 1 on Monday from 17:45:00 to 18:30:00.', NULL, 'read', '2024-08-08 22:49:39', 132, 46, 15, 0),
(963, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Internet Based Programming (IBP)\' in class Telecom 1 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'read', '2024-08-08 22:49:39', 133, 46, 13, 0),
(964, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Quantitative Techniques\' in class Telecom 1 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'read', '2024-08-08 22:49:39', 134, 46, 14, 0),
(965, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Data Communication\' in class Telecom 1 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'read', '2024-08-08 22:49:39', 135, 46, 12, 0),
(966, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Management Information System (MIS)\' in class Telecom 2 on Tuesday from 08:00:00 to 10:00:00.', NULL, 'read', '2024-08-08 22:49:39', 136, 46, 15, 0),
(967, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Internet Based Programming (IBP)\' in class Telecom 2 on Tuesday from 10:15:00 to 12:15:00.', NULL, 'read', '2024-08-08 22:49:39', 137, 46, 13, 0),
(968, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Quantitative Techniques\' in class Telecom 2 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'read', '2024-08-08 22:49:39', 138, 46, 14, 0),
(969, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Data Communication\' in class Telecom 2 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'read', '2024-08-08 22:49:39', 139, 46, 12, 0),
(970, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Internet Based Programming (IBP)\' in class Telecom 3 on Tuesday from 13:15:00 to 15:15:00.', NULL, 'read', '2024-08-08 22:49:39', 140, 46, 13, 0),
(971, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Quantitative Techniques\' in class Telecom 3 on Tuesday from 15:30:00 to 17:30:00.', NULL, 'read', '2024-08-08 22:49:39', 141, 46, 14, 0),
(972, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Management Information System (MIS)\' in class Telecom 3 on Tuesday from 17:45:00 to 18:30:00.', NULL, 'read', '2024-08-08 22:49:39', 142, 46, 15, 0),
(973, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Data Communication\' in class Telecom 3 on Wednesday from 08:00:00 to 10:00:00.', NULL, 'read', '2024-08-08 22:49:39', 143, 46, 12, 0),
(974, 'Automatic Lesson Track', 'lecturer', 'The lesson has been automatically marked as missed.', '', 'read', '2024-08-08 22:53:56', 108, 3, 1, 0),
(975, 'Automatic Lesson Track', 'lecturer', 'The lesson has been automatically marked as missed.', '', 'read', '2024-08-08 22:53:56', 109, 3, 1, 0),
(976, 'Automatic Lesson Track', 'lecturer', 'The lesson has been automatically marked as missed.', '', 'read', '2024-08-08 22:53:56', 110, 3, 1, 0),
(977, 'Automatic Lesson Track', 'lecturer', 'The lesson has been automatically marked as missed.', '', 'read', '2024-08-08 22:53:56', 111, 3, 1, 0),
(978, 'No Available Lecturer', 'hod', 'No lecturer is available to teach the following lesson:<br>Class: ICT 3<br>Day: Monday<br>Start Time: 08:00:00<br>End Time: 10:00:00<br>', NULL, 'read', '2024-08-09 08:14:39', 0, 46, 46, 0),
(979, 'No Available Lecturer', 'hod', 'No available lecturer found for ICT 3 on Monday from 08:00:00 to 10:00:00.', NULL, 'read', '2024-08-09 09:08:32', 0, 46, 46, 0),
(980, 'Lesson Allocation', 'lecturer', 'You have been allocated a new lesson.', NULL, 'read', '2024-08-09 09:54:13', 144, 12, 46, 0),
(981, 'Lesson Allocation', 'lecturer', 'You have been allocated a new lesson.', NULL, 'read', '2024-08-09 10:04:35', 147, 12, 46, 0),
(982, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Internet Based Programming (IBP)\' in class ICT 3 on Monday from 08:00:00 to 10:00:00.', NULL, 'read', '2024-08-09 10:12:17', 150, 12, 46, 0),
(983, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Quantitative Techniques\' in class ICT 3 on Monday from 10:15:00 to 12:15:00.', NULL, 'read', '2024-08-09 10:12:20', 151, 14, 46, 0),
(984, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Management Information System (MIS)\' in class ICT 3 on Monday from 13:15:00 to 15:15:00.', NULL, 'read', '2024-08-09 10:12:23', 152, 15, 46, 0),
(985, 'No Lecturer Available', 'User', 'No available lecturer was found for class ICT 3 on Monday from 15:30:00 to 17:30:00.', NULL, 'unread', '2024-08-09 10:12:26', 0, 46, 46, 0),
(986, 'Lesson Allocation', 'Lecturer', 'You have been allocated a lesson for subject \'Internet Based Programming (IBP)\' in class ICT 3 on Monday from 15:30:00 to 17:30:00.', NULL, 'read', '2024-08-09 10:14:14', 154, 13, 46, 0),
(987, 'No Lecturer Available', 'User', 'No available lecturer was found for class ICT 3 on Monday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-09 10:14:17', 0, 46, 46, 0),
(988, 'No Lecturer Available', 'User', 'No available lecturer was found for class ICT 3 on Monday from 17:45:00 to 18:30:00.', NULL, 'unread', '2024-08-09 10:15:02', 0, 46, 46, 0),
(989, 'New Lesson Allocation', 'Lecturer', 'You have been allocated a new lesson in ICT 3 on Monday from 08:00:00 to 10:00:00.', NULL, 'read', '2024-08-09 10:33:21', 0, 12, 46, 0),
(990, 'New Lesson Allocation', 'Lecturer', 'You have been allocated a new lesson in ICT 3 on Monday from 10:15:00 to 12:15:00.', NULL, 'read', '2024-08-09 10:36:27', 0, 12, 46, 0),
(991, 'New Lesson Allocation', 'Lecturer', 'You have been allocated a new lesson in ICT 3 on Monday from 13:15:00 to 15:15:00.', NULL, 'read', '2024-08-09 10:38:42', 0, 15, 46, 0),
(992, 'New Lesson Allocation', 'lecturer', 'You have been allocated a new lesson.<br>Class: 84<br>Subject: 16<br>Start Time: 08:00<br>End Time: 10:00<br>Duration: 120 minutes<br>Day: Monday<br>', 'send_message.php', 'read', '2024-08-13 13:55:27', 0, 13, 46, 0),
(993, 'Automatic Lesson Track', 'lecturer', 'The lesson has been automatically marked as missed.', '', 'read', '2024-08-13 13:56:51', 475, 3, 1, 0),
(994, 'Account request', 'Principal', 'New account request from Esther Mbengi in Telecommunication department.', 'add_user.php?request_id=51&status=approved', 'unread', '2024-08-13 14:41:22', 0, 0, 0, 0),
(995, 'Account request', 'Deputy Principal', 'New account request from Esther Mbengi in Telecommunication department.', 'reject_request.php?request_id=51&status=rejected', 'read', '2024-08-13 14:41:22', 0, 0, 0, 0),
(996, 'Automatic Lesson Track', 'lecturer', 'The lesson has been automatically marked as missed.', '', 'read', '2024-08-19 21:06:45', 475, 3, 1, 0),
(997, 'Account request', 'Principal', 'New account request from jerevasio murithi in cs department.', 'add_user.php?request_id=52&status=approved', 'unread', '2024-08-20 10:15:49', 0, 0, 0, 0),
(998, 'Account request', 'Deputy Principal', 'New account request from jerevasio murithi in cs department.', 'reject_request.php?request_id=52&status=rejected', 'read', '2024-08-20 10:15:49', 0, 0, 0, 0),
(999, 'Automatic Lesson Track', 'lecturer', 'The lesson has been automatically marked as missed.', '', 'read', '2024-08-21 19:13:31', 562, 3, 1, 0),
(1000, 'Automatic Lesson Track', 'lecturer', 'The lesson has been automatically marked as missed.', '', 'read', '2024-08-21 19:13:31', 563, 3, 1, 0),
(1001, 'Automatic Lesson Track', 'lecturer', 'The lesson has been automatically marked as missed.', '', 'unread', '2024-08-21 19:13:31', 564, 3, 1, 0),
(1002, 'Automatic Lesson Track', 'lecturer', 'The lesson has been automatically marked as missed.', '', 'read', '2024-08-21 19:13:31', 565, 3, 1, 0),
(1003, 'Automatic Lesson Track', 'lecturer', 'The lesson has been automatically marked as missed.', '', 'read', '2024-08-21 19:13:31', 566, 3, 1, 0),
(1004, 'Automatic Lesson Track', 'lecturer', 'The lesson has been automatically marked as missed.', '', 'read', '2024-08-21 19:13:31', 567, 3, 1, 0),
(1005, 'Automatic Lesson Track', 'lecturer', 'The lesson has been automatically marked as missed.', '', 'read', '2024-08-21 19:13:31', 568, 3, 1, 0),
(1006, 'Automatic Lesson Track', 'lecturer', 'The lesson has been automatically marked as missed.', '', 'read', '2024-08-21 19:13:31', 569, 3, 1, 0),
(1007, 'Automatic Lesson Track', 'lecturer', 'The lesson has been automatically marked as missed.', '', 'read', '2024-08-21 19:13:31', 570, 3, 1, 0),
(1008, 'Automatic Lesson Track', 'lecturer', 'The lesson has been automatically marked as missed.', '', 'read', '2024-08-21 19:13:31', 571, 3, 1, 0),
(1009, 'Automatic Lesson Track', 'lecturer', 'The lesson has been automatically marked as missed.', '', 'read', '2024-08-21 19:13:31', 572, 3, 1, 0),
(1010, 'Automatic Lesson Track', 'lecturer', 'The lesson has been automatically marked as missed.', '', 'unread', '2024-08-21 19:13:31', 573, 3, 1, 0),
(1011, 'Automatic Lesson Track', 'lecturer', 'The lesson has been automatically marked as missed.', '', 'unread', '2024-08-21 19:13:31', 574, 3, 1, 0),
(1012, 'Automatic Lesson Track', 'lecturer', 'The lesson has been automatically marked as missed.', '', 'unread', '2024-08-21 19:13:31', 575, 3, 1, 0),
(1013, 'Automatic Lesson Track', 'lecturer', 'The lesson has been automatically marked as missed.', '', 'read', '2024-08-21 19:13:31', 576, 3, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

DROP TABLE IF EXISTS `requests`;
CREATE TABLE IF NOT EXISTS `requests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lecturer_id` int NOT NULL,
  `subject_id` int NOT NULL,
  `class_id` int NOT NULL,
  `course` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `duration` int NOT NULL,
  `day_of_week` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `reason` text,
  `department_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lecturer_id` (`lecturer_id`),
  KEY `subject_id` (`subject_id`),
  KEY `class_id` (`class_id`),
  KEY `department_id` (`department_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reschedules`
--

DROP TABLE IF EXISTS `reschedules`;
CREATE TABLE IF NOT EXISTS `reschedules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lesson_id` int NOT NULL,
  `class_id` int NOT NULL,
  `department_id` int NOT NULL,
  `reschedule_date` datetime NOT NULL,
  `reason` varchar(255) NOT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `lesson_id` (`lesson_id`),
  KEY `class_id` (`class_id`),
  KEY `department_id` (`department_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reschedule_requests`
--

DROP TABLE IF EXISTS `reschedule_requests`;
CREATE TABLE IF NOT EXISTS `reschedule_requests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lesson_id` int NOT NULL,
  `lecturer_id` int NOT NULL,
  `new_day` varchar(10) NOT NULL,
  `new_start_time` time NOT NULL,
  `new_end_time` time NOT NULL,
  `reason` text NOT NULL,
  `status` varchar(10) DEFAULT 'pending',
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `id` int NOT NULL AUTO_INCREMENT,
  `servNo` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `department_id` int DEFAULT NULL,
  `course_id` int DEFAULT NULL,
  `class_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `servNo` (`servNo`),
  KEY `fk_department` (`department_id`),
  KEY `fk_new_course` (`course_id`),
  KEY `fk_class` (`class_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `servNo`, `name`, `phone`, `email`, `department_id`, `course_id`, `class_id`) VALUES
(9, '187009', 'Daniel Chimbeja', '+254711133342', 'chimbejadan@gmail.com', 4, 6, 107),
(10, '200564', 'Rose Mulwa', '+254700112231', 'rozzy@gmail.com', 4, 6, 106),
(11, '201332', 'Jane Karimi', '+254101443300', 'exampleJ@gmail.com', 4, 6, 106),
(12, '200111', 'Eunice Njeri', '+254711133300', 'njerieunice@yahoo.com', 4, 6, 105),
(13, '119942', 'John Kamau', '+254701443323', 'jonny@gmail.com', 4, 6, 107),
(15, '188223', 'Mercy Chepkemboi', '708976532', 'mercychep@yahoo.com', 4, 6, 107),
(16, '193098', 'Benard Odero', '0700000000', 'mroderoben@yahoo.com', 2, 1, 84),
(17, '187304', 'Gloria wesonga Oduor', '0790003211', 'gloriaoduorw@gmail.com', 2, 1, 84);

-- --------------------------------------------------------

--
-- Table structure for table `student_absence`
--

DROP TABLE IF EXISTS `student_absence`;
CREATE TABLE IF NOT EXISTS `student_absence` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` int DEFAULT NULL,
  `subject_id` int DEFAULT NULL,
  `class_id` int DEFAULT NULL,
  `course_id` int DEFAULT NULL,
  `department_id` int DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `day_of_the_week` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  KEY `subject_id` (`subject_id`),
  KEY `class_id` (`class_id`),
  KEY `course_id` (`course_id`),
  KEY `department_id` (`department_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
CREATE TABLE IF NOT EXISTS `subjects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `subject_name` varchar(100) DEFAULT NULL,
  `course_id` int NOT NULL,
  `level_id` int NOT NULL,
  `class_id` int NOT NULL,
  `qualifications` text,
  `department_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  KEY `level_id` (`level_id`),
  KEY `FK_subjects_department` (`department_id`),
  KEY `idx_subject_name` (`subject_name`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `subject_name`, `course_id`, `level_id`, `class_id`, `qualifications`, `department_id`) VALUES
(11, 'Computational Mathematics', 1, 1, 86, 'Diploma in ICT', 2),
(16, 'Internet Based Programming (IBP)', 1, 3, 84, 'Internet Programming', 2),
(17, 'Management Information System (MIS)', 1, 3, 84, ' Certified Information Systems Security Professional (CISSP)', 2),
(18, 'Data Communication', 1, 3, 84, 'Bachelors Degree in Computer Networks and Telecommunications', 2),
(19, 'Networking', 1, 3, 84, 'Bachelors Degree in Computer Networks and Telecommunications', 2),
(20, 'Quantitative Techniques', 1, 2, 85, 'Certified Analytics Professional (CAP) and Certified Six Sigma Green Belt', 2),
(22, 'Digital Electronics', 3, 1, 90, 'Professional Bachelor of Engineering Sciences', 3),
(23, 'Technical Drawing', 6, 1, 105, 'A Bachelors degree in Building Technology and Technical Drawing', 4),
(24, 'Principles and Practice of Management ', 1, 3, 84, 'A bachelor\'s degree in management, business administration, or a related field.', 2);

-- --------------------------------------------------------

--
-- Table structure for table `subject_qualifications`
--

DROP TABLE IF EXISTS `subject_qualifications`;
CREATE TABLE IF NOT EXISTS `subject_qualifications` (
  `subject_id` int NOT NULL,
  `qualification` varchar(100) NOT NULL,
  PRIMARY KEY (`subject_id`,`qualification`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

DROP TABLE IF EXISTS `submissions`;
CREATE TABLE IF NOT EXISTS `submissions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assignment_id` int NOT NULL,
  `student_id` int NOT NULL,
  `submission_file` varchar(255) NOT NULL,
  `submitted_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `grade` varchar(10) DEFAULT NULL,
  `feedback` text,
  PRIMARY KEY (`id`),
  KEY `assignment_id` (`assignment_id`),
  KEY `student_id` (`student_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `term_dates`
--

DROP TABLE IF EXISTS `term_dates`;
CREATE TABLE IF NOT EXISTS `term_dates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `term_name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(20) NOT NULL DEFAULT 'running',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `term_dates`
--

INSERT INTO `term_dates` (`id`, `term_name`, `start_date`, `end_date`, `created_at`, `status`) VALUES
(1, 'Term Two', '2024-08-05', '2024-11-29', '2024-07-30 10:04:27', 'stopped'),
(2, 'Term 2', '2024-08-05', '2024-11-29', '2024-08-08 17:41:09', 'running');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `user_role` enum('Principal','Deputy Principal','HOD','Lecturer','Class Representative') NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_login` tinyint(1) DEFAULT '1',
  `UpdationDate` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `department_id` int NOT NULL,
  `otp` varchar(255) NOT NULL,
  `otp_expiry` int UNSIGNED NOT NULL,
  `class_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_department_id` (`department_id`),
  KEY `fk_class_id` (`class_id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `phone_number`, `user_role`, `password`, `first_login`, `UpdationDate`, `department_id`, `otp`, `otp_expiry`, `class_id`) VALUES
(1, 'ben.odero', 'ben.odero@gmail.com', '+254728005328', 'Principal', '$2y$10$BRLxbpRt5hDh1QvrqIBmUuxvyvieSLAFdutv8Q4wUINlceSwCw1X6', 0, '2024-08-01 09:23:55', 0, '814578', 1722493555, NULL),
(3, 'Felix Odhiambo', 'felixodhis81@gmail.com', '+254101443359', 'Class Representative', '$2y$10$yHTn.By8YloDs7uRJc1kjuxz/67Cw9DqX6X2K031xwpucC6Cin9pu', 0, '2024-08-05 17:48:21', 2, '905885', 0, 84),
(46, 'Caroline Ngigi', 'exampleC@gmail.com', '+254787654321', 'HOD', '$2y$10$r4V1G09AkSZqPZ32jvQB/.82BZnj0uha0rmW8PejK2K0TKnJRRKJm', 0, '2024-07-29 12:29:40', 2, '351052', 2024, NULL),
(29, 'Benard Odero', 'benardodero21@gmail.com', '+254728005323', 'Deputy Principal', '$2y$10$Iwk0agRzffx78ThMR8oXyewALiRe6eC0WAihoKjyAQm6u1BoK80DG', 0, '2024-08-13 15:07:47', 1, '', 1723550954, NULL),
(36, 'Joseph Moseti', 'mrmoseti@gmail.com', '+254700000123', 'Lecturer', '$2y$10$6DbJLDh3Q3PWhbk7ujlrbuJ7z.tO8eYmWQE3xlzQG0X7VGUQnHhvO', 1, '2024-07-30 13:29:40', 2, '708729', 2024, NULL),
(34, 'John Gichemi', 'johnGichemi@gmail.com', '+254700000011', 'HOD', '$2y$10$f4gDrszNVVYFvtiaiC309.ARuh5/JVXy46w4Cq9hhE/lt5evtRhLm', 0, '2024-07-23 20:26:58', 4, '584905', 2024, NULL),
(33, 'Teresia Muthoni', 'testes@gmail.com', '+254700000001', 'Lecturer', '$2y$10$9WrJzOjjnXynkRIrnw9Ireg3WaHBSvG.WtPTSNhjMhqsN7WWT0WO6', 0, '2024-07-21 04:39:20', 2, '205879', 2024, NULL),
(37, 'Frank Obura', 'frankobura@gmail.com', '+254700004321', 'Lecturer', '$2y$10$89aAvuHEuaZj1wMlf/JN.eMlBva2zmafysQtDUDAgQKdO/8byzdBK', 1, '2024-07-30 13:29:19', 2, '317464', 2024, NULL),
(38, 'Weldon Kamau', 'kamau1@gmail.com', '+254700004001', 'HOD', '$2y$10$ZahB3E5BUM88hyG4qet65.x6EFOSPOvn2epRBoqZusQ0ZlETkTk8C', 0, '2024-07-22 01:30:24', 7, '749979', 2024, NULL),
(39, 'Benard Esadia', 'besadia@gmail.com', '+254700054321', 'Lecturer', '$2y$10$KCc0R/aQ4S49oKz7.cgyDewFcJDBpx1RxTHlM.WhFk9aTZJGuO5LK', 0, '2024-07-29 13:14:06', 2, '895220', 2024, NULL),
(40, 'Moses Nyambane', 'nyambane99moses@gmail.com', '+254700000022', 'Lecturer', '$2y$10$qT3tKUhb2j3ekn/qR2BR9OXrM3LMULrmkMEsZb5CSzscmRhP3sN7G', 0, '2024-07-22 01:41:36', 7, '622740', 2024, NULL),
(44, 'Daniel Chimbeja', 'chimdan@gmail.com', '+254700124356', 'Class Representative', '$2y$10$LKdJNlcq66dPYAkBmPcBHezSSGpAz40x.xkldiHxjO3/rPg/Uu5PO', 0, '2024-07-29 14:51:49', 4, '', 0, 107),
(45, 'Jane Karimi', 'exampleJ@gmail.com', '+254101443300', 'Class Representative', '$2y$10$q8dTOTTFkiWmAE0In88N0u/mapKi8u9csebDZT1lU9Bq2exuUWfRW', 0, '2024-07-27 15:18:12', 4, '', 0, 106),
(47, 'Francis Mureithi', 'rozzy@gmail.com', '+254728005999', 'Lecturer', '$2y$10$hoLRaBcU1nKCzQa6f3FgwefwGOl2Jx1SL9Cf.4A0HncTUhB21s/lC', 1, NULL, 7, '172343', 2024, NULL),
(49, 'Madam Justine', 'mdmjustine@gmail.com', '+254743210005', 'Lecturer', '$2y$10$5JVtUdQWMsRrMUPOAm4d8uF.CFpfWVcCmWfKufaYlO2r8n2fosLTu', 1, NULL, 2, '411191', 2024, NULL),
(50, 'Madam Susan', 'mdmsusan@gmail.com', '+254712345678', 'Lecturer', '$2y$10$EJGQpBnXkJkyEM4Rs1Zrs.jcGuGh8SJae.qxyXk0Okq5jHm3Mk03a', 0, '2024-08-19 16:39:48', 2, '598870', 2024, NULL),
(51, 'jerevasio', 'murithijerevasio@gmail.com', '+254769291582', 'Lecturer', '$2y$10$WTYT8W78bAOzajmK.NcQJu/y8pmCjkFQV/I771o2UHCu/8erAwkGO', 1, NULL, 4, '211420', 2024, NULL);

--
-- Triggers `users`
--
DROP TRIGGER IF EXISTS `update_lecturer_department`;
DELIMITER $$
CREATE TRIGGER `update_lecturer_department` AFTER UPDATE ON `users` FOR EACH ROW BEGIN
    -- Update the department_id in lecturers table
    UPDATE lecturers
    SET department_id = NEW.department_id
    WHERE id = NEW.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `weekly_schedule`
--

DROP TABLE IF EXISTS `weekly_schedule`;
CREATE TABLE IF NOT EXISTS `weekly_schedule` (
  `id` int NOT NULL AUTO_INCREMENT,
  `day_of_week` varchar(10) NOT NULL,
  `lesson_start` time NOT NULL,
  `lesson_end` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `classes_ibfk_2` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_classes_department` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`);

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lecturer_qualifications`
--
ALTER TABLE `lecturer_qualifications`
  ADD CONSTRAINT `fk_lecturer_qualification_lecturer` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_lecturer_qualifications_lecturer` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturers` (`id`);

--
-- Constraints for table `lecturer_subjects`
--
ALTER TABLE `lecturer_subjects`
  ADD CONSTRAINT `fk_lecturer_subject_lecturer` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_lecturer_subject_subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_lecturer_subjects_lecturer` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturers` (`id`),
  ADD CONSTRAINT `fk_lecturer_subjects_subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `fk_lesson_subject` FOREIGN KEY (`lesson_name`) REFERENCES `subjects` (`subject_name`),
  ADD CONSTRAINT `fk_lessons_class` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`),
  ADD CONSTRAINT `fk_lessons_lecturer` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturers` (`id`),
  ADD CONSTRAINT `fk_lessons_subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `fk_class` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_department` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`),
  ADD CONSTRAINT `fk_new_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `FK_subjects_department` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
