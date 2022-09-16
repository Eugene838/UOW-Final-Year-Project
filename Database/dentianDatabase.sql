-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 20, 2022 at 05:34 AM
-- Server version: 8.0.26-google
-- PHP Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dentianDatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment_table`
--

CREATE TABLE `appointment_table` (
  `appointment_id` int NOT NULL,
  `dentist_id` int NOT NULL,
  `dentist_name` varchar(50) NOT NULL,
  `patient_id` int NOT NULL,
  `schedule_id` int NOT NULL,
  `appt_number` int NOT NULL,
  `appt_reason` mediumtext NOT NULL,
  `appt_date` date NOT NULL,
  `appt_day` enum('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday') NOT NULL,
  `appt_time` varchar(255) NOT NULL,
  `status` varchar(30) NOT NULL,
  `comments` mediumtext NOT NULL,
  `Company` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `appointment_table`
--

INSERT INTO `appointment_table` (`appointment_id`, `dentist_id`, `dentist_name`, `patient_id`, `schedule_id`, `appt_number`, `appt_reason`, `appt_date`, `appt_day`, `appt_time`, `status`, `comments`, `Company`) VALUES
(1, 1013, 'Aaron Seow Lee Huat', 30, 89, 1000, 'Check up', '2022-08-20', 'Saturday', '11:00-12:00', 'Paid', '', 'Dr Seow Dental Surgery'),
(2, 1013, 'Aaron Seow Lee Huat', 30, 80, 1001, 'Check up', '2022-08-22', 'Monday', '11:00-12:00', 'Booked', '', 'Dr Seow Dental Surgery'),
(3, 1016, 'Ryan Chee', 31, 193, 1002, 'Toothache', '2022-08-20', 'Saturday', '12:00-13:15', 'Paid', '', 'Crown Dental Surgery'),
(4, 1016, 'Ryan Chee', 31, 194, 1003, 'Braces', '2022-08-27', 'Saturday', '13:15-14:30', 'Booked', '', 'Crown Dental Surgery'),
(5, 1002, 'Kelvin Lim', 31, 136, 1004, 'Cleaning and polishing', '2022-08-31', 'Wednesday', '12:30-13:45', 'Booked', '', 'Crown Dental Surgery'),
(6, 1005, 'Keith Lim', 31, 235, 1005, 'Scaling', '2022-08-28', 'Sunday', '16:30-17:00', 'Booked', '', 'Dental Focus Eunos Clinic'),
(7, 1014, 'James Lau', 31, 98, 1006, 'Polishing', '2022-08-22', 'Monday', '20:00-21:00', 'Booked', '', 'Dr Seow Dental Surgery'),
(8, 1009, 'Janice Aw', 31, 189, 1007, 'Scaling', '2022-08-21', 'Sunday', '11:30-12:00', 'Booked', '', 'MyBracesClinic'),
(9, 1005, 'Keith Lim', 28, 230, 1008, 'Filling', '2022-08-20', 'Saturday', '16:00-16:30', 'Booked', '', 'Dental Focus Eunos Clinic'),
(10, 1005, 'Keith Lim', 28, 231, 1009, 'Filling', '2022-08-27', 'Saturday', '16:00-16:30', 'Booked', '', 'Dental Focus Eunos Clinic'),
(11, 1005, 'Keith Lim', 28, 234, 1010, 'Filling', '2022-08-21', 'Sunday', '17:30-18:00', 'Booked', '', 'Dental Focus Eunos Clinic'),
(12, 1003, 'Johnathan  Ho', 35, 71, 1011, 'Polishing', '2022-08-20', 'Saturday', '13:00-14:00', 'Completed', '', 'Luminous Dental Clinic'),
(13, 1010, 'Ray Khoo', 33, 273, 1012, 'Regular check up', '2022-08-20', 'Saturday', '14:40-15:30', 'Booked', '', 'MyBracesClinic'),
(14, 1010, 'Ray Khoo', 33, 277, 1013, 'Scaling and polishing', '2022-08-21', 'Sunday', '14:40-15:30', 'Booked', '', 'MyBracesClinic'),
(15, 1012, 'Adeline Lee', 37, 291, 1014, 'Difficulty swallowing food', '2022-08-20', 'Saturday', '17:25-18:20', 'Booked', '', 'MyBracesClinic'),
(16, 1009, 'Janice Aw', 29, 185, 1015, 'Consultation for getting braces', '2022-08-20', 'Saturday', '11:30-12:15', 'Booked', '', 'MyBracesClinic'),
(17, 1009, 'Janice Aw', 29, 189, 1016, 'X-ray scan for braces', '2022-08-21', 'Sunday', '12:00-12:30', 'Booked', '', 'MyBracesClinic');

-- --------------------------------------------------------

--
-- Table structure for table `dental_services`
--

CREATE TABLE `dental_services` (
  `SID` int NOT NULL,
  `Service_ID` varchar(5) NOT NULL,
  `Service_Name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Price` double(10,2) NOT NULL,
  `CHAS_color` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `dental_services`
--

INSERT INTO `dental_services` (`SID`, `Service_ID`, `Service_Name`, `Price`, `CHAS_color`) VALUES
(1, 'O01', 'General Consultation(Orange)', 50.00, 'Orange'),
(2, 'O02', 'Extraction, Anterior(Orange)', 80.00, 'Orange'),
(3, 'O03', 'Extraction, Posterior(Orange)', 100.00, 'Orange'),
(4, 'O04', 'Filling, simple(Orange)', 80.00, 'Orange'),
(5, 'O05', 'Filling, complex(Orange)', 100.00, 'Orange'),
(6, 'O06', 'Removable Denture, Complete(Upper or Lower)(Orange)', 530.00, 'Orange'),
(7, 'O07', 'Removable Denture, Partial, Simple(Upper or Lower)(Orange)', 235.00, 'Orange'),
(8, 'O08', 'Removable Denture, Partial, Complex (Upper or Lower)(Orange)', 360.00, 'Orange'),
(9, 'O09', 'Denture Reline/Repair (Upper or Lower)(Orange)', 150.00, 'Orange'),
(10, 'O10', 'Permanent Crown(Orange)', 916.00, 'Orange'),
(11, 'O11', 'Re-cementation(Orange)', 150.00, 'Orange'),
(12, 'O12', 'Root Canal Treatment (Anterior)(Orange)', 691.00, 'Orange'),
(13, 'O13', 'Root Canal Treatment (Pre-Molar)(Orange)', 580.00, 'Orange'),
(14, 'O14', 'Root Canal Treatment (Molar)(Orange)', 830.00, 'Orange'),
(15, 'O15', 'Polishing(Orange)', 100.00, 'Orange'),
(16, 'O16', 'Scaling(Orange)', 100.00, 'Orange'),
(17, 'O17', 'Tropical Fluoride(Orange)', 50.00, 'Orange'),
(18, 'O18', 'X-Ray(Orange)', 100.00, 'Orange'),
(19, 'B01', 'General Consultation(Blue)', 30.00, 'Blue'),
(20, 'B02', 'Extraction, Anterior(Blue)', 52.00, 'Blue'),
(21, 'B03', 'Extraction, Posterior(Blue)', 32.00, 'Blue'),
(22, 'B04', 'Filling, Simple(Blue)', 50.00, 'Blue'),
(23, 'B05', 'Filling, Complex(Blue)', 50.00, 'Blue'),
(24, 'B06', 'Removable Denture, Complete(Upper or Lower)(Blue)', 444.00, 'Blue'),
(25, 'B07', 'Removable Denture, Partial(Upper or Lower)(Blue)', 202.00, 'Blue'),
(26, 'B08', 'Removable Denture, Partial, Complex(Upper or Lower)(Blue)', 210.00, 'Blue'),
(27, 'B09', 'Denture Reline/Repair(Blue)', 125.00, 'Blue'),
(28, 'B10', 'Permanent Crown(Blue)', 873.00, 'Blue'),
(29, 'B11', 'Re-cementation(Blue)', 115.00, 'Blue'),
(30, 'B12', 'Root Canal Treatment(Anterior)(Blue)', 636.00, 'Blue'),
(31, 'B13', 'Root Canal Treatment(Pre-Molar)(Blue)', 494.00, 'Blue'),
(32, 'B14', 'Root Canal Treatment(Molar)(Blue)', 744.00, 'Blue'),
(33, 'B15', 'Polishing(Blue)', 80.00, 'Blue'),
(34, 'B16', 'Scaling(Blue)', 70.00, 'Blue'),
(35, 'B17', 'Tropical Fluoride(Blue)', 20.00, 'Blue'),
(36, 'B18', 'X-Ray(Blue)', 89.00, 'Blue'),
(37, 'MG01', 'General Consultation(MG)', 25.00, 'Pink'),
(38, 'MG02', 'Extraction, Anterior(MG)', 47.00, 'Pink'),
(39, 'MG03', 'Extraction, Posterior(MG)', 27.00, 'Pink'),
(40, 'MG04', 'Filling, Simple(MG)', 45.00, 'Pink'),
(41, 'MG05', 'Filling, Complex(MG)', 45.00, 'Pink'),
(42, 'MG06', 'Removable Denture, Complete(Upper or Lower)(MG)', 439.00, 'Pink'),
(43, 'MG07', 'Removable Denture, Partial, Simple(Upper or Lower)(MG)', 197.00, 'Pink'),
(44, 'MG08', 'Removable Denture, Partial, Complex(Upper or Lower)(MG)', 285.00, 'Pink'),
(45, 'MG09', 'Denture Reline/Repair(Upper or Lower)(MG)', 120.00, 'Pink'),
(46, 'MG010', 'Permanent Crown(MG)', 868.00, 'Pink'),
(47, 'MG011', 'Re-cementation(MG)', 110.00, 'Pink'),
(48, 'MG012', 'Root Canal Treatment(Anterior)(MG)', 631.00, 'Pink'),
(49, 'MG013', 'Root Canal Treatment(Pre-Molar)(MG)', 489.00, 'Pink'),
(50, 'MG014', 'Root Canal Treatment(Molar)(MG)', 739.00, 'Pink'),
(51, 'MG015', 'Polishing(MG)', 75.00, 'Pink'),
(52, 'MG016', 'Scaling(MG)', 65.00, 'Pink'),
(53, 'MG017', 'Tropical Fluoride(MG)', 15.00, 'Pink'),
(54, 'MG018', 'X-Ray(MG)', 84.00, 'Pink'),
(55, 'PG01', 'General Consultation(PG)', 20.00, 'Red'),
(56, 'PG02', 'Extraction, Anterior(PG)', 42.00, 'Red'),
(57, 'PG03', 'Extraction, Posterior(PG)', 22.00, 'Red'),
(58, 'PG04', 'Filing, Simple(PG)', 40.00, 'Red'),
(59, 'PG05', 'Filing, Complex(PG)', 40.00, 'Red'),
(60, 'PG06', 'Removable Denture Complete(Upper or Lower)(PG)', 434.00, 'Red'),
(61, 'PG07', 'Removable Denture, Partial, Simple(Upper or Lower)(PG)', 192.00, 'Red'),
(62, 'PG08', 'Removable Denture, Partial, Complex(Upper or Lower)(PG)', 280.00, 'Red'),
(63, 'PG09', 'Denture Reline/Repair(Upper or Lower)(PG)', 115.00, 'Red'),
(64, 'PG10', 'Permanent Crown)(PG)', 863.00, 'Red'),
(65, 'PG11', 'Re-cementation)(PG)', 105.00, 'Red'),
(66, 'PG12', 'Root Canal Treatment(Anterior)(PG)', 626.00, 'Red'),
(67, 'PG13', 'Root Canal Treatment(Pre-Molar)(PG)', 484.00, 'Red'),
(68, 'PG14', 'Root Canal Treatment(Molar)(PG)', 734.00, 'Red'),
(69, 'PG15', 'Polishing(PG)', 70.00, 'Red'),
(70, 'PG16', 'Scaling(PG)', 60.00, 'Red'),
(71, 'PG17', 'Tropical Fluoride(PG)', 10.00, 'Red'),
(72, 'PG18', 'X-Ray(PG)', 79.00, 'Red'),
(73, 'N01', 'General Consultation', 50.00, 'None'),
(74, 'N02', 'Extraction, Anterior', 80.00, 'None'),
(75, 'N03', 'Extraction, Posterior', 100.00, 'None'),
(76, 'N04', 'Filling, Simple', 80.00, 'None'),
(77, 'N05', 'Filling, Complex', 100.00, 'None'),
(78, 'N06', 'Removable Denture, Complete (Upper or Lower)', 700.00, 'None'),
(79, 'N07', 'Removable Denture, Partial, Simple(Upper or Lower)', 700.00, 'None'),
(80, 'N08', 'Removable Denture, Partial, Complex (Upper or Lower)', 500.00, 'None'),
(81, 'N09', 'Denture Reline/Repair (Upper or Lower)', 500.00, 'None'),
(82, 'N10', 'Permanent Crown', 1000.00, 'None'),
(83, 'N11', 'Re-cementation', 150.00, 'None'),
(84, 'N12', 'Root Canal Treatment (Anterior)', 800.00, 'None'),
(85, 'N13', 'Root Canal Treatment (Pre-Molar)', 750.00, 'None'),
(86, 'N14', 'Root Canal Treatment (Molar)', 1000.00, 'None'),
(87, 'N15', 'Polishing', 100.00, 'None'),
(88, 'N16', 'Scaling', 100.00, 'None'),
(89, 'N17', 'Tropical Fluoride', 50.00, 'None'),
(90, 'N18', 'X-Ray', 100.00, 'None');

-- --------------------------------------------------------

--
-- Table structure for table `dentist_schedule`
--

CREATE TABLE `dentist_schedule` (
  `schedule_id` int NOT NULL,
  `dentist_id` int NOT NULL,
  `schedule_date` date NOT NULL,
  `schedule_day` enum('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday') NOT NULL,
  `schedule_start_time` varchar(20) NOT NULL,
  `schedule_end_time` varchar(20) NOT NULL,
  `avg_consult_time` varchar(10) NOT NULL,
  `Status` enum('Active','Inactive') NOT NULL,
  `Company` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `dentist_schedule`
--

INSERT INTO `dentist_schedule` (`schedule_id`, `dentist_id`, `schedule_date`, `schedule_day`, `schedule_start_time`, `schedule_end_time`, `avg_consult_time`, `Status`, `Company`) VALUES
(1, 1001, '2022-09-05', 'Monday', '08:00', '23:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(2, 1001, '2022-09-12', 'Monday', '08:00', '23:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(3, 1001, '2022-09-19', 'Monday', '08:00', '23:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(4, 1001, '2022-09-26', 'Monday', '08:00', '23:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(5, 1001, '2022-08-02', 'Tuesday', '13:00', '16:00', '45 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(6, 1001, '2022-08-09', 'Tuesday', '13:00', '16:00', '45 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(7, 1001, '2022-08-16', 'Tuesday', '13:00', '16:00', '45 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(8, 1001, '2022-08-23', 'Tuesday', '13:00', '16:00', '45 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(9, 1001, '2022-08-30', 'Tuesday', '13:00', '16:00', '45 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(10, 1001, '2022-09-07', 'Wednesday', '08:00', '11:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(11, 1001, '2022-09-14', 'Wednesday', '08:00', '11:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(12, 1001, '2022-09-21', 'Wednesday', '08:00', '11:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(13, 1001, '2022-09-28', 'Wednesday', '08:00', '11:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(14, 1001, '2022-09-02', 'Friday', '08:00', '11:00', '60 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(15, 1001, '2022-09-09', 'Friday', '08:00', '11:00', '60 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(16, 1001, '2022-09-16', 'Friday', '08:00', '11:00', '60 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(17, 1001, '2022-09-23', 'Friday', '08:00', '11:00', '60 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(18, 1001, '2022-09-30', 'Friday', '08:00', '11:00', '60 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(19, 1004, '2022-08-03', 'Wednesday', '15:00', '18:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(20, 1004, '2022-08-10', 'Wednesday', '15:00', '18:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(21, 1004, '2022-08-17', 'Wednesday', '15:00', '18:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(22, 1004, '2022-08-24', 'Wednesday', '15:00', '18:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(23, 1004, '2022-08-31', 'Wednesday', '15:00', '18:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(24, 1004, '2022-09-06', 'Tuesday', '12:00', '15:00', '45 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(25, 1004, '2022-09-13', 'Tuesday', '12:00', '15:00', '45 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(26, 1004, '2022-09-20', 'Tuesday', '12:00', '15:00', '45 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(27, 1004, '2022-09-27', 'Tuesday', '12:00', '15:00', '45 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(28, 1004, '2022-09-01', 'Thursday', '12:00', '15:00', '40 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(29, 1004, '2022-09-08', 'Thursday', '12:00', '15:00', '40 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(30, 1004, '2022-09-15', 'Thursday', '12:00', '15:00', '40 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(31, 1004, '2022-09-22', 'Thursday', '12:00', '15:00', '40 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(32, 1004, '2022-09-29', 'Thursday', '12:00', '15:00', '40 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(33, 1004, '2022-09-02', 'Friday', '12:00', '15:00', '45 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(34, 1004, '2022-09-09', 'Friday', '12:00', '15:00', '45 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(35, 1004, '2022-09-16', 'Friday', '12:00', '15:00', '45 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(36, 1004, '2022-09-23', 'Friday', '12:00', '15:00', '45 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(37, 1004, '2022-09-30', 'Friday', '12:00', '15:00', '45 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(38, 1005, '2022-08-04', 'Thursday', '12:00', '18:00', '60 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(39, 1005, '2022-08-11', 'Thursday', '12:00', '18:00', '60 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(40, 1005, '2022-08-18', 'Thursday', '12:00', '18:00', '60 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(41, 1005, '2022-08-25', 'Thursday', '12:00', '18:00', '60 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(42, 1005, '2022-08-05', 'Friday', '12:00', '18:00', '60 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(43, 1005, '2022-08-12', 'Friday', '12:00', '18:00', '60 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(44, 1005, '2022-08-19', 'Friday', '12:00', '18:00', '60 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(45, 1005, '2022-08-26', 'Friday', '12:00', '18:00', '60 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(46, 1005, '2022-09-05', 'Monday', '13:00', '17:00', '60 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(47, 1005, '2022-09-12', 'Monday', '13:00', '17:00', '60 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(48, 1005, '2022-09-19', 'Monday', '13:00', '17:00', '60 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(49, 1005, '2022-09-26', 'Monday', '13:00', '17:00', '60 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(50, 1005, '2022-09-06', 'Tuesday', '13:00', '17:00', '60 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(51, 1005, '2022-09-13', 'Tuesday', '13:00', '17:00', '60 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(52, 1005, '2022-09-20', 'Tuesday', '13:00', '17:00', '60 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(53, 1005, '2022-09-27', 'Tuesday', '13:00', '17:00', '60 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(54, 1005, '2022-09-01', 'Thursday', '13:00', '17:00', '60 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(55, 1005, '2022-09-08', 'Thursday', '13:00', '17:00', '60 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(56, 1005, '2022-09-15', 'Thursday', '13:00', '17:00', '60 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(57, 1005, '2022-09-22', 'Thursday', '13:00', '17:00', '60 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(58, 1005, '2022-09-29', 'Thursday', '13:00', '17:00', '60 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(59, 1003, '2022-08-01', 'Monday', '10:00', '14:00', '60 minutes', 'Active', 'Luminous Dental Clinic'),
(60, 1003, '2022-08-08', 'Monday', '10:00', '14:00', '60 minutes', 'Active', 'Luminous Dental Clinic'),
(61, 1003, '2022-08-15', 'Monday', '10:00', '14:00', '60 minutes', 'Active', 'Luminous Dental Clinic'),
(62, 1003, '2022-08-22', 'Monday', '10:00', '14:00', '60 minutes', 'Active', 'Luminous Dental Clinic'),
(63, 1003, '2022-08-29', 'Monday', '10:00', '14:00', '60 minutes', 'Active', 'Luminous Dental Clinic'),
(64, 1003, '2022-08-03', 'Wednesday', '10:00', '14:00', '60 minutes', 'Active', 'Luminous Dental Clinic'),
(65, 1003, '2022-08-10', 'Wednesday', '10:00', '14:00', '60 minutes', 'Active', 'Luminous Dental Clinic'),
(66, 1003, '2022-08-17', 'Wednesday', '10:00', '14:00', '60 minutes', 'Active', 'Luminous Dental Clinic'),
(67, 1003, '2022-08-24', 'Wednesday', '10:00', '14:00', '60 minutes', 'Active', 'Luminous Dental Clinic'),
(68, 1003, '2022-08-31', 'Wednesday', '10:00', '14:00', '60 minutes', 'Active', 'Luminous Dental Clinic'),
(69, 1003, '2022-08-06', 'Saturday', '10:00', '14:00', '60 minutes', 'Active', 'Luminous Dental Clinic'),
(70, 1003, '2022-08-13', 'Saturday', '10:00', '14:00', '60 minutes', 'Active', 'Luminous Dental Clinic'),
(71, 1003, '2022-08-20', 'Saturday', '10:00', '14:00', '60 minutes', 'Active', 'Luminous Dental Clinic'),
(72, 1003, '2022-08-27', 'Saturday', '10:00', '14:00', '60 minutes', 'Active', 'Luminous Dental Clinic'),
(73, 1003, '2022-08-07', 'Sunday', '10:00', '14:00', '60 minutes', 'Active', 'Luminous Dental Clinic'),
(74, 1003, '2022-08-14', 'Sunday', '10:00', '14:00', '60 minutes', 'Active', 'Luminous Dental Clinic'),
(75, 1003, '2022-08-21', 'Sunday', '10:00', '14:00', '60 minutes', 'Active', 'Luminous Dental Clinic'),
(76, 1003, '2022-08-28', 'Sunday', '10:00', '14:00', '60 minutes', 'Active', 'Luminous Dental Clinic'),
(77, 1013, '2022-08-01', 'Monday', '09:00', '17:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(78, 1013, '2022-08-08', 'Monday', '09:00', '17:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(79, 1013, '2022-08-15', 'Monday', '09:00', '17:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(80, 1013, '2022-08-22', 'Monday', '09:00', '17:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(81, 1013, '2022-08-29', 'Monday', '09:00', '17:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(82, 1013, '2022-08-03', 'Wednesday', '09:00', '17:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(83, 1013, '2022-08-10', 'Wednesday', '09:00', '17:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(84, 1013, '2022-08-17', 'Wednesday', '09:00', '17:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(85, 1013, '2022-08-24', 'Wednesday', '09:00', '17:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(86, 1013, '2022-08-31', 'Wednesday', '09:00', '17:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(87, 1013, '2022-08-06', 'Saturday', '09:00', '15:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(88, 1013, '2022-08-13', 'Saturday', '09:00', '15:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(89, 1013, '2022-08-20', 'Saturday', '09:00', '15:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(90, 1013, '2022-08-27', 'Saturday', '09:00', '15:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(91, 1013, '2022-08-07', 'Sunday', '09:00', '15:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(92, 1013, '2022-08-14', 'Sunday', '09:00', '15:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(93, 1013, '2022-08-21', 'Sunday', '09:00', '15:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(94, 1013, '2022-08-28', 'Sunday', '09:00', '15:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(95, 1014, '2022-08-01', 'Monday', '13:00', '21:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(96, 1014, '2022-08-08', 'Monday', '13:00', '21:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(97, 1014, '2022-08-15', 'Monday', '13:00', '21:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(98, 1014, '2022-08-22', 'Monday', '13:00', '21:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(99, 1014, '2022-08-29', 'Monday', '13:00', '21:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(100, 1014, '2022-08-06', 'Saturday', '13:00', '21:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(101, 1014, '2022-08-13', 'Saturday', '13:00', '21:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(102, 1014, '2022-08-20', 'Saturday', '13:00', '21:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(103, 1014, '2022-08-27', 'Saturday', '13:00', '21:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(104, 1007, '2022-08-01', 'Monday', '14:00', '18:00', '60 minutes', 'Active', 'Luminous Dental Clinic'),
(105, 1007, '2022-08-08', 'Monday', '14:00', '18:00', '60 minutes', 'Active', 'Luminous Dental Clinic'),
(106, 1007, '2022-08-15', 'Monday', '14:00', '18:00', '60 minutes', 'Active', 'Luminous Dental Clinic'),
(107, 1007, '2022-08-22', 'Monday', '14:00', '18:00', '60 minutes', 'Active', 'Luminous Dental Clinic'),
(108, 1007, '2022-08-29', 'Monday', '14:00', '18:00', '60 minutes', 'Active', 'Luminous Dental Clinic'),
(109, 1007, '2022-08-03', 'Wednesday', '14:00', '18:00', '60 minutes', 'Active', 'Luminous Dental Clinic'),
(110, 1007, '2022-08-10', 'Wednesday', '14:00', '18:00', '60 minutes', 'Active', 'Luminous Dental Clinic'),
(111, 1007, '2022-08-17', 'Wednesday', '14:00', '18:00', '60 minutes', 'Active', 'Luminous Dental Clinic'),
(112, 1007, '2022-08-24', 'Wednesday', '14:00', '18:00', '60 minutes', 'Active', 'Luminous Dental Clinic'),
(113, 1007, '2022-08-31', 'Wednesday', '14:00', '18:00', '60 minutes', 'Active', 'Luminous Dental Clinic'),
(114, 1007, '2022-08-06', 'Saturday', '14:00', '18:00', '60 minutes', 'Active', 'Luminous Dental Clinic'),
(115, 1007, '2022-08-13', 'Saturday', '14:00', '18:00', '60 minutes', 'Active', 'Luminous Dental Clinic'),
(116, 1007, '2022-08-20', 'Saturday', '14:00', '18:00', '60 minutes', 'Active', 'Luminous Dental Clinic'),
(117, 1007, '2022-08-27', 'Saturday', '14:00', '18:00', '60 minutes', 'Active', 'Luminous Dental Clinic'),
(118, 1015, '2022-08-03', 'Wednesday', '13:00', '21:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(119, 1015, '2022-08-10', 'Wednesday', '13:00', '21:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(120, 1015, '2022-08-17', 'Wednesday', '13:00', '21:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(121, 1015, '2022-08-24', 'Wednesday', '13:00', '21:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(122, 1015, '2022-08-31', 'Wednesday', '13:00', '21:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(123, 1015, '2022-08-07', 'Sunday', '13:00', '21:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(124, 1015, '2022-08-14', 'Sunday', '13:00', '21:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(125, 1015, '2022-08-21', 'Sunday', '13:00', '21:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(126, 1015, '2022-08-28', 'Sunday', '13:00', '21:00', '60 minutes', 'Active', 'Dr Seow Dental Surgery'),
(127, 1002, '2022-08-01', 'Monday', '14:00', '18:00', '75 minutes', 'Active', 'Crown Dental Surgery'),
(128, 1002, '2022-08-08', 'Monday', '14:00', '18:00', '75 minutes', 'Active', 'Crown Dental Surgery'),
(129, 1002, '2022-08-15', 'Monday', '14:00', '18:00', '75 minutes', 'Active', 'Crown Dental Surgery'),
(130, 1002, '2022-08-22', 'Monday', '14:00', '18:00', '75 minutes', 'Active', 'Crown Dental Surgery'),
(131, 1002, '2022-08-29', 'Monday', '14:00', '18:00', '75 minutes', 'Active', 'Crown Dental Surgery'),
(132, 1002, '2022-08-03', 'Wednesday', '10:00', '16:00', '75 minutes', 'Active', 'Crown Dental Surgery'),
(133, 1002, '2022-08-10', 'Wednesday', '10:00', '16:00', '75 minutes', 'Active', 'Crown Dental Surgery'),
(134, 1002, '2022-08-17', 'Wednesday', '10:00', '16:00', '75 minutes', 'Active', 'Crown Dental Surgery'),
(135, 1002, '2022-08-24', 'Wednesday', '10:00', '16:00', '75 minutes', 'Active', 'Crown Dental Surgery'),
(136, 1002, '2022-08-31', 'Wednesday', '10:00', '16:00', '75 minutes', 'Active', 'Crown Dental Surgery'),
(137, 1002, '2022-08-07', 'Sunday', '09:00', '15:00', '75 minutes', 'Active', 'Crown Dental Surgery'),
(138, 1002, '2022-08-14', 'Sunday', '09:00', '15:00', '75 minutes', 'Active', 'Crown Dental Surgery'),
(139, 1002, '2022-08-21', 'Sunday', '09:00', '15:00', '75 minutes', 'Active', 'Crown Dental Surgery'),
(140, 1002, '2022-08-28', 'Sunday', '09:00', '15:00', '75 minutes', 'Active', 'Crown Dental Surgery'),
(141, 1006, '2022-08-02', 'Tuesday', '14:00', '18:00', '60 minutes', 'Active', 'Crown Dental Surgery'),
(142, 1006, '2022-08-09', 'Tuesday', '14:00', '18:00', '60 minutes', 'Active', 'Crown Dental Surgery'),
(143, 1006, '2022-08-16', 'Tuesday', '14:00', '18:00', '60 minutes', 'Active', 'Crown Dental Surgery'),
(144, 1006, '2022-08-23', 'Tuesday', '14:00', '18:00', '60 minutes', 'Active', 'Crown Dental Surgery'),
(145, 1006, '2022-08-30', 'Tuesday', '14:00', '18:00', '60 minutes', 'Active', 'Crown Dental Surgery'),
(146, 1006, '2022-08-03', 'Wednesday', '11:30', '17:30', '60 minutes', 'Active', 'Crown Dental Surgery'),
(147, 1006, '2022-08-10', 'Wednesday', '11:30', '17:30', '60 minutes', 'Active', 'Crown Dental Surgery'),
(148, 1006, '2022-08-17', 'Wednesday', '11:30', '17:30', '60 minutes', 'Active', 'Crown Dental Surgery'),
(149, 1006, '2022-08-24', 'Wednesday', '11:30', '17:30', '60 minutes', 'Active', 'Crown Dental Surgery'),
(150, 1006, '2022-08-31', 'Wednesday', '11:30', '17:30', '60 minutes', 'Active', 'Crown Dental Surgery'),
(151, 1006, '2022-08-04', 'Thursday', '09:00', '18:00', '60 minutes', 'Active', 'Crown Dental Surgery'),
(152, 1006, '2022-08-11', 'Thursday', '09:00', '18:00', '60 minutes', 'Active', 'Crown Dental Surgery'),
(153, 1006, '2022-08-18', 'Thursday', '09:00', '18:00', '60 minutes', 'Active', 'Crown Dental Surgery'),
(154, 1006, '2022-08-25', 'Thursday', '09:00', '18:00', '60 minutes', 'Active', 'Crown Dental Surgery'),
(155, 1001, '2022-08-01', 'Monday', '12:00', '15:00', '40 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(156, 1001, '2022-08-08', 'Monday', '12:00', '15:00', '40 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(157, 1001, '2022-08-15', 'Monday', '12:00', '15:00', '40 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(158, 1001, '2022-08-22', 'Monday', '12:00', '15:00', '40 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(159, 1001, '2022-08-29', 'Monday', '12:00', '15:00', '40 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(160, 1001, '2022-08-03', 'Wednesday', '12:00', '15:00', '45 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(161, 1001, '2022-08-10', 'Wednesday', '12:00', '15:00', '45 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(162, 1001, '2022-08-17', 'Wednesday', '12:00', '15:00', '45 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(163, 1001, '2022-08-24', 'Wednesday', '12:00', '15:00', '45 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(164, 1001, '2022-08-31', 'Wednesday', '12:00', '15:00', '45 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(165, 1001, '2022-08-06', 'Saturday', '12:00', '15:00', '45 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(166, 1001, '2022-08-13', 'Saturday', '12:00', '15:00', '45 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(167, 1001, '2022-08-20', 'Saturday', '12:00', '15:00', '45 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(168, 1001, '2022-08-27', 'Saturday', '12:00', '15:00', '45 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(169, 1001, '2022-08-07', 'Sunday', '12:00', '15:00', '45 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(170, 1001, '2022-08-14', 'Sunday', '12:00', '15:00', '45 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(171, 1001, '2022-08-21', 'Sunday', '12:00', '15:00', '45 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(172, 1001, '2022-08-28', 'Sunday', '12:00', '15:00', '45 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(173, 1009, '2022-08-01', 'Monday', '08:30', '12:30', '45 minutes', 'Active', 'MyBracesClinic'),
(174, 1009, '2022-08-08', 'Monday', '08:30', '12:30', '45 minutes', 'Active', 'MyBracesClinic'),
(175, 1009, '2022-08-15', 'Monday', '08:30', '12:30', '45 minutes', 'Active', 'MyBracesClinic'),
(176, 1009, '2022-08-22', 'Monday', '08:30', '12:30', '45 minutes', 'Active', 'MyBracesClinic'),
(177, 1009, '2022-08-29', 'Monday', '08:30', '12:30', '45 minutes', 'Active', 'MyBracesClinic'),
(178, 1009, '2022-08-03', 'Wednesday', '08:30', '12:30', '45 minutes', 'Active', 'MyBracesClinic'),
(179, 1009, '2022-08-10', 'Wednesday', '08:30', '12:30', '45 minutes', 'Active', 'MyBracesClinic'),
(180, 1009, '2022-08-17', 'Wednesday', '08:30', '12:30', '45 minutes', 'Active', 'MyBracesClinic'),
(181, 1009, '2022-08-24', 'Wednesday', '08:30', '12:30', '45 minutes', 'Active', 'MyBracesClinic'),
(182, 1009, '2022-08-31', 'Wednesday', '08:30', '12:30', '45 minutes', 'Active', 'MyBracesClinic'),
(183, 1009, '2022-08-06', 'Saturday', '08:30', '12:30', '45 minutes', 'Active', 'MyBracesClinic'),
(184, 1009, '2022-08-13', 'Saturday', '08:30', '12:30', '45 minutes', 'Active', 'MyBracesClinic'),
(185, 1009, '2022-08-20', 'Saturday', '08:30', '12:30', '45 minutes', 'Active', 'MyBracesClinic'),
(186, 1009, '2022-08-27', 'Saturday', '08:30', '12:30', '45 minutes', 'Active', 'MyBracesClinic'),
(187, 1009, '2022-08-07', 'Sunday', '08:30', '12:30', '30 minutes', 'Active', 'MyBracesClinic'),
(188, 1009, '2022-08-14', 'Sunday', '08:30', '12:30', '30 minutes', 'Active', 'MyBracesClinic'),
(189, 1009, '2022-08-21', 'Sunday', '08:30', '12:30', '30 minutes', 'Active', 'MyBracesClinic'),
(190, 1009, '2022-08-28', 'Sunday', '08:30', '12:30', '30 minutes', 'Active', 'MyBracesClinic'),
(191, 1016, '2022-08-06', 'Saturday', '12:00', '19:00', '75 minutes', 'Active', 'Crown Dental Surgery'),
(192, 1016, '2022-08-13', 'Saturday', '12:00', '19:00', '75 minutes', 'Active', 'Crown Dental Surgery'),
(193, 1016, '2022-08-20', 'Saturday', '12:00', '19:00', '75 minutes', 'Active', 'Crown Dental Surgery'),
(194, 1016, '2022-08-27', 'Saturday', '12:00', '19:00', '75 minutes', 'Active', 'Crown Dental Surgery'),
(195, 1004, '2022-08-01', 'Monday', '08:00', '11:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(196, 1004, '2022-08-08', 'Monday', '08:00', '11:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(197, 1004, '2022-08-15', 'Monday', '08:00', '11:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(198, 1004, '2022-08-22', 'Monday', '08:00', '11:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(199, 1004, '2022-08-29', 'Monday', '08:00', '11:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(200, 1004, '2022-08-06', 'Saturday', '08:00', '11:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(201, 1004, '2022-08-13', 'Saturday', '08:00', '11:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(202, 1004, '2022-08-20', 'Saturday', '08:00', '11:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(203, 1004, '2022-08-27', 'Saturday', '08:00', '11:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(204, 1004, '2022-08-07', 'Sunday', '08:00', '11:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(205, 1004, '2022-08-14', 'Sunday', '08:00', '11:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(206, 1004, '2022-08-21', 'Sunday', '08:00', '11:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(207, 1004, '2022-08-28', 'Sunday', '08:00', '11:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(208, 1008, '2022-08-01', 'Monday', '11:00', '13:00', '30 minutes', 'Active', 'Crown Dental Surgery'),
(209, 1008, '2022-08-08', 'Monday', '11:00', '13:00', '30 minutes', 'Active', 'Crown Dental Surgery'),
(210, 1008, '2022-08-15', 'Monday', '11:00', '13:00', '30 minutes', 'Active', 'Crown Dental Surgery'),
(211, 1008, '2022-08-22', 'Monday', '11:00', '13:00', '30 minutes', 'Active', 'Crown Dental Surgery'),
(212, 1008, '2022-08-29', 'Monday', '11:00', '13:00', '30 minutes', 'Active', 'Crown Dental Surgery'),
(213, 1008, '2022-12-02', 'Friday', '14:30', '20:30', '50 minutes', 'Active', 'Crown Dental Surgery'),
(214, 1008, '2022-12-09', 'Friday', '14:30', '20:30', '50 minutes', 'Active', 'Crown Dental Surgery'),
(215, 1008, '2022-12-16', 'Friday', '14:30', '20:30', '50 minutes', 'Active', 'Crown Dental Surgery'),
(216, 1008, '2022-12-23', 'Friday', '14:30', '20:30', '50 minutes', 'Active', 'Crown Dental Surgery'),
(217, 1008, '2022-12-30', 'Friday', '14:30', '20:30', '50 minutes', 'Active', 'Crown Dental Surgery'),
(218, 1008, '2022-12-03', 'Saturday', '08:00', '18:00', '40 minutes', 'Active', 'Crown Dental Surgery'),
(219, 1008, '2022-12-10', 'Saturday', '08:00', '18:00', '40 minutes', 'Active', 'Crown Dental Surgery'),
(220, 1008, '2022-12-17', 'Saturday', '08:00', '18:00', '40 minutes', 'Active', 'Crown Dental Surgery'),
(221, 1008, '2022-12-24', 'Saturday', '08:00', '18:00', '40 minutes', 'Active', 'Crown Dental Surgery'),
(222, 1008, '2022-12-31', 'Saturday', '08:00', '18:00', '40 minutes', 'Active', 'Crown Dental Surgery'),
(223, 1005, '2022-08-01', 'Monday', '15:00', '18:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(224, 1005, '2022-08-08', 'Monday', '15:00', '18:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(225, 1005, '2022-08-15', 'Monday', '15:00', '18:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(226, 1005, '2022-08-22', 'Monday', '15:00', '18:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(227, 1005, '2022-08-29', 'Monday', '15:00', '18:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(228, 1005, '2022-08-06', 'Saturday', '15:00', '18:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(229, 1005, '2022-08-13', 'Saturday', '15:00', '18:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(230, 1005, '2022-08-20', 'Saturday', '15:00', '18:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(231, 1005, '2022-08-27', 'Saturday', '15:00', '18:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(232, 1005, '2022-08-07', 'Sunday', '15:00', '18:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(233, 1005, '2022-08-14', 'Sunday', '15:00', '18:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(234, 1005, '2022-08-21', 'Sunday', '15:00', '18:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(235, 1005, '2022-08-28', 'Sunday', '15:00', '18:00', '30 minutes', 'Active', 'Dental Focus Eunos Clinic'),
(236, 1016, '2022-09-05', 'Monday', '12:20', '19:00', '65 minutes', 'Active', 'Crown Dental Surgery'),
(237, 1016, '2022-09-12', 'Monday', '12:20', '19:00', '65 minutes', 'Active', 'Crown Dental Surgery'),
(238, 1016, '2022-09-19', 'Monday', '12:20', '19:00', '65 minutes', 'Active', 'Crown Dental Surgery'),
(239, 1016, '2022-09-26', 'Monday', '12:20', '19:00', '65 minutes', 'Active', 'Crown Dental Surgery'),
(240, 1016, '2022-09-07', 'Wednesday', '14:00', '18:30', '55 minutes', 'Active', 'Crown Dental Surgery'),
(241, 1016, '2022-09-14', 'Wednesday', '14:00', '18:30', '55 minutes', 'Active', 'Crown Dental Surgery'),
(242, 1016, '2022-09-21', 'Wednesday', '14:00', '18:30', '55 minutes', 'Active', 'Crown Dental Surgery'),
(243, 1016, '2022-09-28', 'Wednesday', '14:00', '18:30', '55 minutes', 'Active', 'Crown Dental Surgery'),
(244, 1016, '2022-09-01', 'Thursday', '09:20', '19:20', '70 minutes', 'Active', 'Crown Dental Surgery'),
(245, 1016, '2022-09-08', 'Thursday', '09:20', '19:20', '70 minutes', 'Active', 'Crown Dental Surgery'),
(246, 1016, '2022-09-15', 'Thursday', '09:20', '19:20', '70 minutes', 'Active', 'Crown Dental Surgery'),
(247, 1016, '2022-09-22', 'Thursday', '09:20', '19:20', '70 minutes', 'Active', 'Crown Dental Surgery'),
(248, 1016, '2022-09-29', 'Thursday', '09:20', '19:20', '70 minutes', 'Active', 'Crown Dental Surgery'),
(249, 1008, '2022-09-03', 'Saturday', '08:20', '18:20', '75 minutes', 'Active', 'Crown Dental Surgery'),
(250, 1008, '2022-09-10', 'Saturday', '08:20', '18:20', '75 minutes', 'Active', 'Crown Dental Surgery'),
(251, 1008, '2022-09-17', 'Saturday', '08:20', '18:20', '75 minutes', 'Active', 'Crown Dental Surgery'),
(252, 1008, '2022-09-24', 'Saturday', '08:20', '18:20', '75 minutes', 'Active', 'Crown Dental Surgery'),
(253, 1008, '2022-09-04', 'Sunday', '08:20', '18:20', '50 minutes', 'Active', 'Crown Dental Surgery'),
(254, 1008, '2022-09-11', 'Sunday', '08:20', '18:20', '50 minutes', 'Active', 'Crown Dental Surgery'),
(255, 1008, '2022-09-18', 'Sunday', '08:20', '18:20', '50 minutes', 'Active', 'Crown Dental Surgery'),
(256, 1008, '2022-09-25', 'Sunday', '08:20', '18:20', '50 minutes', 'Active', 'Crown Dental Surgery'),
(257, 1008, '2022-08-05', 'Friday', '08:20', '18:20', '55 minutes', 'Active', 'Crown Dental Surgery'),
(258, 1008, '2022-08-12', 'Friday', '08:20', '18:20', '55 minutes', 'Active', 'Crown Dental Surgery'),
(259, 1008, '2022-08-19', 'Friday', '08:20', '18:20', '55 minutes', 'Active', 'Crown Dental Surgery'),
(260, 1008, '2022-08-26', 'Friday', '08:20', '18:20', '55 minutes', 'Active', 'Crown Dental Surgery'),
(261, 1010, '2022-08-01', 'Monday', '13:00', '16:00', '50 minutes', 'Active', 'MyBracesClinic'),
(262, 1010, '2022-08-08', 'Monday', '13:00', '16:00', '50 minutes', 'Active', 'MyBracesClinic'),
(263, 1010, '2022-08-15', 'Monday', '13:00', '16:00', '50 minutes', 'Active', 'MyBracesClinic'),
(264, 1010, '2022-08-22', 'Monday', '13:00', '16:00', '50 minutes', 'Active', 'MyBracesClinic'),
(265, 1010, '2022-08-29', 'Monday', '13:00', '16:00', '50 minutes', 'Active', 'MyBracesClinic'),
(266, 1010, '2022-08-03', 'Wednesday', '13:00', '16:00', '50 minutes', 'Active', 'MyBracesClinic'),
(267, 1010, '2022-08-10', 'Wednesday', '13:00', '16:00', '50 minutes', 'Active', 'MyBracesClinic'),
(268, 1010, '2022-08-17', 'Wednesday', '13:00', '16:00', '50 minutes', 'Active', 'MyBracesClinic'),
(269, 1010, '2022-08-24', 'Wednesday', '13:00', '16:00', '50 minutes', 'Active', 'MyBracesClinic'),
(270, 1010, '2022-08-31', 'Wednesday', '13:00', '16:00', '50 minutes', 'Active', 'MyBracesClinic'),
(271, 1010, '2022-08-06', 'Saturday', '13:00', '16:00', '50 minutes', 'Active', 'MyBracesClinic'),
(272, 1010, '2022-08-13', 'Saturday', '13:00', '16:00', '50 minutes', 'Active', 'MyBracesClinic'),
(273, 1010, '2022-08-20', 'Saturday', '13:00', '16:00', '50 minutes', 'Active', 'MyBracesClinic'),
(274, 1010, '2022-08-27', 'Saturday', '13:00', '16:00', '50 minutes', 'Active', 'MyBracesClinic'),
(275, 1010, '2022-08-07', 'Sunday', '13:00', '16:00', '50 minutes', 'Active', 'MyBracesClinic'),
(276, 1010, '2022-08-14', 'Sunday', '13:00', '16:00', '50 minutes', 'Active', 'MyBracesClinic'),
(277, 1010, '2022-08-21', 'Sunday', '13:00', '16:00', '50 minutes', 'Active', 'MyBracesClinic'),
(278, 1010, '2022-08-28', 'Sunday', '13:00', '16:00', '50 minutes', 'Active', 'MyBracesClinic'),
(279, 1012, '2022-08-01', 'Monday', '16:30', '19:00', '55 minutes', 'Active', 'MyBracesClinic'),
(280, 1012, '2022-08-08', 'Monday', '16:30', '19:00', '55 minutes', 'Active', 'MyBracesClinic'),
(281, 1012, '2022-08-15', 'Monday', '16:30', '19:00', '55 minutes', 'Active', 'MyBracesClinic'),
(282, 1012, '2022-08-22', 'Monday', '16:30', '19:00', '55 minutes', 'Active', 'MyBracesClinic'),
(283, 1012, '2022-08-29', 'Monday', '16:30', '19:00', '55 minutes', 'Active', 'MyBracesClinic'),
(284, 1012, '2022-08-03', 'Wednesday', '16:30', '19:00', '55 minutes', 'Active', 'MyBracesClinic'),
(285, 1012, '2022-08-10', 'Wednesday', '16:30', '19:00', '55 minutes', 'Active', 'MyBracesClinic'),
(286, 1012, '2022-08-17', 'Wednesday', '16:30', '19:00', '55 minutes', 'Active', 'MyBracesClinic'),
(287, 1012, '2022-08-24', 'Wednesday', '16:30', '19:00', '55 minutes', 'Active', 'MyBracesClinic'),
(288, 1012, '2022-08-31', 'Wednesday', '16:30', '19:00', '55 minutes', 'Active', 'MyBracesClinic'),
(289, 1012, '2022-08-06', 'Saturday', '16:30', '19:00', '55 minutes', 'Active', 'MyBracesClinic'),
(290, 1012, '2022-08-13', 'Saturday', '16:30', '19:00', '55 minutes', 'Active', 'MyBracesClinic'),
(291, 1012, '2022-08-20', 'Saturday', '16:30', '19:00', '55 minutes', 'Active', 'MyBracesClinic'),
(292, 1012, '2022-08-27', 'Saturday', '16:30', '19:00', '55 minutes', 'Active', 'MyBracesClinic'),
(293, 1012, '2022-08-07', 'Sunday', '16:30', '19:00', '55 minutes', 'Active', 'MyBracesClinic'),
(294, 1012, '2022-08-14', 'Sunday', '16:30', '19:00', '55 minutes', 'Active', 'MyBracesClinic'),
(295, 1012, '2022-08-21', 'Sunday', '16:30', '19:00', '55 minutes', 'Active', 'MyBracesClinic'),
(296, 1012, '2022-08-28', 'Sunday', '16:30', '19:00', '55 minutes', 'Active', 'MyBracesClinic');

-- --------------------------------------------------------

--
-- Table structure for table `dentist_work_time`
--

CREATE TABLE `dentist_work_time` (
  `work_id` int NOT NULL,
  `dentist_id` int NOT NULL,
  `day` enum('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday') NOT NULL,
  `work_timing` varchar(255) NOT NULL,
  `month_year` varchar(50) NOT NULL,
  `working_off` enum('Working','Off') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_order`
--

CREATE TABLE `invoice_order` (
  `order_id` int NOT NULL,
  `appt_id` int DEFAULT NULL,
  `Email` varchar(100) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_receiver_name` varchar(250) NOT NULL,
  `order_receiver_address` mediumtext NOT NULL,
  `order_total_before_tax` decimal(10,2) NOT NULL,
  `order_total_tax` decimal(10,2) NOT NULL,
  `order_tax_per` varchar(250) NOT NULL,
  `order_total_after_tax` double(10,2) NOT NULL,
  `order_amount_paid` decimal(10,2) NOT NULL,
  `order_total_amount_due` decimal(10,2) NOT NULL,
  `Company` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `note` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `invoice_order`
--

INSERT INTO `invoice_order` (`order_id`, `appt_id`, `Email`, `order_date`, `order_receiver_name`, `order_receiver_address`, `order_total_before_tax`, `order_total_tax`, `order_tax_per`, `order_total_after_tax`, `order_amount_paid`, `order_total_amount_due`, `Company`, `note`) VALUES
(804, 1, 'xinyi.toh1998@gmail.com', '2022-08-20 04:50:16', ' Xin Yi Toh', '27 Chai Chee Rd, #05-422', '50.00', '3.50', '7', 53.50, '0.00', '53.50', 'Dr Seow Dental Surgery', 'Nil'),
(805, 3, 'ChloeWong@gmail.com', '2022-08-20 04:54:42', ' Chloe Wong', '326 Thomson Rd \r\n# 10-12', '100.00', '17.00', '17', 117.00, '0.00', '117.00', 'Crown Dental Surgery', 'NIL'),
(806, 0, 'albertong37@yahoo.com', '2022-08-20 04:55:15', 'Albert Ong', '528 Bukit Batok Street 51, 12-130', '150.00', '0.00', '0', 150.00, '0.00', '150.00', 'Dental Focus Eunos Clinic', 'nil'),
(807, 0, 'j.koh94@gmail.com', '2022-08-20 04:55:18', 'Jonathan Koh', '118 Yishun Ring Rd #02-068', '50.00', '3.50', '7', 53.50, '0.00', '53.50', 'Dr Seow Dental Surgery', 'Nil'),
(808, 0, 'albertong37@yahoo.com', '2022-08-20 04:56:03', 'Albert Ong', '528 Bukit Batok Street 51, 12-130', '50.00', '0.00', '0', 50.00, '0.00', '50.00', 'Dental Focus Eunos Clinic', 'nil'),
(809, 0, 'SamTan@gmail.com', '2022-08-20 04:57:52', 'Sam Tan', '227 Serangoon Avenue 4 #02-03', '150.00', '0.00', '0', 150.00, '0.00', '150.00', 'Dental Focus Eunos Clinic', 'nil'),
(810, 0, 'gabtan@hotmail.com', '2022-08-20 04:58:59', 'Gabriel Tan', 'Blk 150 Bishan Street 11, #02-233', '80.00', '5.60', '7', 85.60, '0.00', '85.60', 'Dr Seow Dental Surgery', 'Nil'),
(811, 0, 'xinyi.toh1998@gmail.com', '2022-08-20 04:59:48', 'Xin Yi Toh', '27 Chai Chee Rd, #05-422', '150.00', '0.00', '0', 150.00, '0.00', '150.00', 'Dental Focus Eunos Clinic', 'Nil'),
(812, 0, 'TomLim@hotmail.com', '2022-08-20 05:00:53', 'Tom Lim', 'Blk 31 Serangoon Garden Estate 15 Blandford Drive', '1050.00', '0.00', '0', 1050.00, '0.00', '1050.00', 'Dental Focus Eunos Clinic', 'Nil'),
(813, 0, 'TomLim@gmail.com', '2022-08-20 05:07:08', 'Tom Lim', 'Blk 31 Serangoon Garden Estate 15 Blandford Drive', '85.00', '5.95', '7', 90.95, '0.00', '90.95', 'Luminous Dental Clinic', 'Nil'),
(814, 0, 'bluesparkz@gmail.com', '2022-08-20 05:08:08', 'Mohd Aaqil', '429 Woodlands Street 41, #01-528', '110.00', '7.70', '7', 117.70, '0.00', '117.70', 'Luminous Dental Clinic', 'Nil'),
(815, 0, 'SamTan@hotmail.com', '2022-08-20 05:09:45', 'Sam Tan', '227 Serangoon Avenue 4\r\n#02-03', '35.00', '2.45', '7', 37.45, '0.00', '37.45', 'Luminous Dental Clinic', 'Nil'),
(816, 0, 'albertong37@yahoo.com', '2022-08-20 05:32:33', 'Albert Ong', '528 Bukit Batok Street 51, #12-130 Singapore 650528', '82.00', '5.74', '7', 87.74, '0.00', '87.74', 'MyBracesClinic', 'NIL'),
(817, 0, 'KelvinKK@yahoo.com', '2022-08-20 05:34:16', 'Kelvin Kong', 'Blk 5 Mayo Street #01-02 Singapore 208785', '806.80', '56.48', '7', 863.28, '0.00', '863.28', 'MyBracesClinic', 'Nil');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_order_item`
--

CREATE TABLE `invoice_order_item` (
  `order_item_id` int NOT NULL,
  `order_id` int NOT NULL,
  `item_code` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `item_name` varchar(250) NOT NULL,
  `order_item_quantity` decimal(10,2) DEFAULT '1.00',
  `order_item_price` decimal(10,2) DEFAULT NULL,
  `order_item_final_amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `invoice_order_item`
--

INSERT INTO `invoice_order_item` (`order_item_id`, `order_id`, `item_code`, `item_name`, `order_item_quantity`, `order_item_price`, `order_item_final_amount`) VALUES
(4702, 804, 'O01', 'General Consultation(Orange)', '1.00', '50.00', '50.00'),
(4703, 805, 'O15', 'Polishing(Orange)', '1.00', '100.00', '100.00'),
(4704, 806, 'O01', 'General Consultation(Orange)', '1.00', '50.00', '50.00'),
(4705, 806, 'O18', 'X-Ray(Orange)', '1.00', '100.00', '100.00'),
(4706, 807, 'O01', 'General Consultation(Orange)', '1.00', '50.00', '50.00'),
(4707, 808, 'O01', 'General Consultation(Orange)', '1.00', '50.00', '50.00'),
(4708, 809, 'N16', 'Scaling', '1.00', '100.00', '100.00'),
(4709, 809, 'N01', 'General Consultation', '1.00', '50.00', '50.00'),
(4710, 810, 'N04', 'Filling, Simple', '1.00', '80.00', '80.00'),
(4711, 811, 'N01', 'General Consultation', '1.00', '50.00', '50.00'),
(4712, 811, 'N05', 'Filling, Complex', '1.00', '100.00', '100.00'),
(4713, 812, 'n01', 'General Consultation', '1.00', '50.00', '50.00'),
(4714, 812, 'n10', 'Permanent Crown', '1.00', '1000.00', '1000.00'),
(4715, 813, 'N02', 'Extraction, Anterior', '1.00', '80.00', '80.00'),
(4716, 813, '9', 'Colgate Plax Peppermint Mouthwash', '1.00', '5.00', '5.00'),
(4717, 814, 'N03', 'Extraction, Posterior', '1.00', '100.00', '100.00'),
(4718, 814, '1', 'Colgate Maximum Cavity Protection Fresh Cool Mint Toothpaste', '1.00', '10.00', '10.00'),
(4719, 815, 'MG01', 'General Consultation(MG)', '1.00', '25.00', '25.00'),
(4720, 815, '1', 'Colgate Maximum Cavity Protection Fresh Cool Mint Toothpaste', '1.00', '10.00', '10.00'),
(4721, 816, 'B01', 'General Consultation(Blue)', '1.00', '30.00', '30.00'),
(4722, 816, 'B02', 'Extraction, Anterior(Blue)', '1.00', '52.00', '52.00'),
(4723, 817, 'N01', 'General Consultation', '1.00', '50.00', '50.00'),
(4724, 817, 'N13', 'Root Canal Treatment (Pre-Molar)', '1.00', '750.00', '750.00'),
(4725, 817, '21', 'Darlie Anti Bacteria Mouthwash Double Mint', '1.00', '6.80', '6.80');

-- --------------------------------------------------------

--
-- Table structure for table `patient_profile`
--

CREATE TABLE `patient_profile` (
  `Patient_ID` int NOT NULL,
  `Status` varchar(10) NOT NULL DEFAULT 'Active',
  `First_Name` varchar(20) NOT NULL,
  `Last_Name` varchar(20) NOT NULL,
  `NRIC_PNum` varchar(9) NOT NULL,
  `Gender` char(1) NOT NULL,
  `Birth_Date` date DEFAULT NULL,
  `Address` varchar(50) NOT NULL,
  `Nationality` varchar(100) NOT NULL,
  `Phone_Num` int NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Marital Status` varchar(20) NOT NULL,
  `Occupation` varchar(50) NOT NULL,
  `Smoker` varchar(3) NOT NULL,
  `Allergies` varchar(100) DEFAULT NULL,
  `Long_term_med` varchar(200) DEFAULT NULL,
  `Existing_Med_Conds` varchar(200) DEFAULT NULL,
  `Referred_by_clinic` varchar(50) DEFAULT NULL,
  `Referred_memo` varchar(200) DEFAULT NULL,
  `Family_ID` int DEFAULT NULL,
  `Emer_Name` varchar(20) NOT NULL,
  `Emer_Contact` int NOT NULL,
  `Emer_relation` varchar(10) NOT NULL,
  `Subsidies` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `patient_record`
--

CREATE TABLE `patient_record` (
  `Record_ID` int NOT NULL,
  `Patient_ID` int NOT NULL,
  `Treatment_Date` date DEFAULT NULL,
  `Treatment_type` varchar(50) NOT NULL,
  `Treatment_details` varchar(255) NOT NULL,
  `Material_used` varchar(255) NOT NULL,
  `Doctor/Assistant 1` varchar(50) NOT NULL,
  `Doctor/Assistant 2` varchar(50) NOT NULL,
  `Company` varchar(100) NOT NULL,
  `Remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `patient_record`
--

INSERT INTO `patient_record` (`Record_ID`, `Patient_ID`, `Treatment_Date`, `Treatment_type`, `Treatment_details`, `Material_used`, `Doctor/Assistant 1`, `Doctor/Assistant 2`, `Company`, `Remarks`) VALUES
(1, 31, '2022-08-20', 'Polishing', 'Patient undergo polishing service. Mainly her left molars show small decay and request patient to come back in 6months to check again.\r\n\r\nMaterial used: Prophy paste', 'Prophy paste', 'Rosa Mendenz', 'NIL', 'Crown Dental Surgery', 'Added material'),
(2, 30, '2022-08-20', 'General Consultation', 'Nil', 'Nil', 'Aaron Seow Lee Huat', 'Hui Min Song ', 'Dr Seow Dental Surgery', ''),
(3, 26, '2022-08-20', 'Dental Check ups', 'Nil', 'Nil', 'James Lau', 'Alan Lee', 'Dr Seow Dental Surgery', ''),
(4, 35, '2022-08-20', 'Filling, simple', 'Right Molar', 'Composite fillings', 'Aaron Seow Lee Huat', 'Hui Min Song ', 'Dr Seow Dental Surgery', ''),
(5, 35, '2022-08-20', 'Polishing', 'Normal polishing', 'Nil', 'Johnathan  Ho', 'Lelia Peck', 'Luminous Dental Clinic', ''),
(6, 29, '2022-02-08', 'General Consultation', 'Right upper Molar - Resin Composite', 'Resin composites', 'Johnathan  Ho', 'NIL', 'Luminous Dental Clinic', ''),
(7, 35, '2022-08-20', 'Filling, simple', 'Filling done for right molars', 'Silver', 'Johnathan  Ho', 'Lay Bee Tan', 'Luminous Dental Clinic', ''),
(8, 36, '2022-08-17', 'Removable Denture, Partial, Complex', 'Left Molar', 'Cotton rolls\r\nTopical numbing agent\r\nAnesthetic', 'James Lau', 'Jerome Foo', 'Dr Seow Dental Surgery', ''),
(9, 33, '2022-08-20', 'General Consultation', 'Normal cleaning of teeths', 'Nil', 'Marcus Ong', 'Angel Tock', 'Dental Focus Eunos Clinic', ''),
(10, 37, '2022-08-20', 'Polishing', 'Routine polishing', 'Tropical fluoride', 'Johnathan  Ho', 'Lay Bee Tan', 'Luminous Dental Clinic', 'Nil'),
(11, 32, '2022-08-14', 'Polishing', 'Nil', 'Prophylaxis paste', 'Aaron Seow Lee Huat', 'Hui Min Song ', 'Dr Seow Dental Surgery', ''),
(12, 33, '2022-08-14', 'X-Ray', 'Normal x-ray to scan jaw', 'Nil', 'Marcus Ong', 'NIL', 'Dental Focus Eunos Clinic', ''),
(13, 31, '2022-06-15', 'Filling, simple', 'Root canal for lower Incisors', 'Mineral trioxide aggregate.', 'Johnathan  Ho', 'Natalie Wong', 'Luminous Dental Clinic', ''),
(14, 37, '2022-08-15', 'Scaling', 'Scaling and polishing done. Found decay on Right Molars', 'Nil', 'Marcus Ong', 'Angel Tock', 'Dental Focus Eunos Clinic', ''),
(15, 30, '2022-08-20', 'Filling, complex', 'Filling done for right molar 1', 'Gold, Silver', 'Marcus Ong', 'Angel Tock', 'Dental Focus Eunos Clinic', ''),
(16, 29, '2022-08-20', 'Permanent Crown', 'Crowning done for left premolars', 'Crown', 'Marcus Ong', 'Mary Teo', 'Dental Focus Eunos Clinic', ''),
(17, 28, '2022-08-19', 'General Consultation', 'All teeth are healthy. Next check up in 6 months time.', 'Nil', 'Janice Aw', 'NIL', 'MyBracesClinic', ''),
(18, 36, '2022-08-20', 'Filling, simple', 'Slight decay found on second left molar. Arrange for follow up in 2 weeks time.', 'Porcelain, Composite Resin', 'Janice Aw', 'NIL', 'MyBracesClinic', ''),
(19, 33, '2022-08-20', 'Root Canal Treatment (Molar)', 'Root canal completed. Arrange for follow up in 2 weeks time.', 'Gutta-percha', 'Janice Aw', 'NIL', 'MyBracesClinic', ''),
(20, 28, '2022-08-02', 'General Consultation', 'Patient came in for consultation only', 'Nil', 'Wei Jie Chia', 'NIL', 'Crown Dental Surgery', ''),
(21, 32, '2022-08-15', 'X-Ray', 'Patient came in to get an x-ray for their teeth. Noticed wisdom tooth growing nicely, did not affect anything.', 'Nil', 'Lisa Sim', 'Rosa Mendenz', 'Crown Dental Surgery', ''),
(22, 34, '2022-08-20', 'Extraction, Anterior', 'Extracted canine. Arrange removal of stitches in 2 weeks.', 'Cotton rolls, Topical numbing agent, Gauze, Anesthesia needle, Anesthetic, Syringe, Periosteal elevator, Surgical curette', 'Ray Khoo', 'NIL', 'MyBracesClinic', '');

-- --------------------------------------------------------

--
-- Table structure for table `product_table`
--

CREATE TABLE `product_table` (
  `product_id` int NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `product_price` float NOT NULL,
  `quantity` int NOT NULL,
  `Company` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `product_table`
--

INSERT INTO `product_table` (`product_id`, `product_name`, `product_price`, `quantity`, `Company`) VALUES
(1, 'Colgate Maximum Cavity Protection Fresh Cool Mint Toothpaste', 10, 200, 'Luminous Dental Clinic'),
(2, 'Colgate Easy Comfort Wide Head Super Soft Toothbrush', 8, 200, 'Luminous Dental Clinic'),
(3, 'BioGaia', 39.9, 50, 'Dr Seow Dental Surgery'),
(4, 'Philips Sonicare Diamond Clean Smart', 399.9, 30, 'Dr Seow Dental Surgery'),
(5, 'Philips Sonicare Diamond Clean', 314.9, 30, 'Dr Seow Dental Surgery'),
(6, 'Listerine Original', 20, 100, 'Luminous Dental Clinic'),
(7, 'GC Tooth Mousse', 29.9, 100, 'Dr Seow Dental Surgery'),
(8, 'Philips Sonicare Smart for Kids', 69.9, 50, 'Dr Seow Dental Surgery'),
(9, 'Colgate Plax Peppermint Mouthwash', 5, 100, 'Luminous Dental Clinic'),
(10, 'Darlie Double Action Toothpaste', 6, 200, 'Luminous Dental Clinic'),
(11, 'Curaprox Toothpaste BE YOU Gin and Tonic and Persimmon', 17, 100, 'Dental Focus Eunos Clinic'),
(12, 'Curaprox Black is White toothpaste set', 40, 100, 'Dental Focus Eunos Clinic'),
(13, 'Colgate Miracle Repair Gum Revival Toothpaste', 19.9, 25, 'Crown Dental Surgery'),
(14, 'Colgate SlimSoft Charcoal Gold Toothbrush', 12.99, 11, 'Crown Dental Surgery'),
(15, 'Red Seal Toothpaste for smokers', 8, 100, 'Dental Focus Eunos Clinic'),
(16, 'Colgate Ortho Defense Mouthwash', 25.99, 33, 'Crown Dental Surgery'),
(17, 'Colgate Sensitive Pro Relief Complete Protection Toothpaste', 19.9, 40, 'Crown Dental Surgery'),
(18, 'Pearlie White Sonic Tooth Stain Eraser with plaque remover with light', 12, 100, 'Dental Focus Eunos Clinic'),
(19, 'Pearlie White Floss Pick', 5.99, 30, 'Crown Dental Surgery'),
(20, 'Original Oral B Electric Toothbrush', 20.99, 3, 'Crown Dental Surgery'),
(21, 'Darlie Anti Bacteria Mouthwash Double Mint', 6.8, 50, 'MyBracesClinic'),
(22, 'Colgate Renewal Whitening Restoration Gel Toothpaste', 15, 100, 'Dental Focus Eunos Clinic'),
(23, 'Pearlie White Tooth Whitener', 14.8, 50, 'MyBracesClinic'),
(24, 'Orabase Protective Paste', 7.45, 20, 'MyBracesClinic'),
(25, 'Tepe Interdental Brush Mixed pack', 8, 99, 'MyBracesClinic'),
(26, 'ELMEX Anti Caries Swiss Brand Mouthwash', 12.95, 50, 'MyBracesClinic');

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE `user_table` (
  `Emp_ID` int NOT NULL,
  `First_Name` varchar(20) NOT NULL,
  `Last_Name` varchar(20) DEFAULT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `NRIC_PNum` varchar(9) NOT NULL,
  `Gender` char(1) NOT NULL,
  `Birth_Date` date DEFAULT NULL,
  `Address` varchar(100) NOT NULL,
  `Phone_Num` int NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Role` varchar(20) NOT NULL,
  `Specialization` varchar(50) NOT NULL,
  `Company` varchar(100) NOT NULL,
  `status` varchar(8) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`Emp_ID`, `First_Name`, `Last_Name`, `username`, `password`, `NRIC_PNum`, `Gender`, `Birth_Date`, `Address`, `Phone_Num`, `Email`, `Role`, `Specialization`, `Company`, `status`) VALUES
(1, 'Wei Lun', 'Neo', 'weilunneo', 'password', 'S9004347C', 'M', '1995-02-06', '79 Toa Payoh Central #19-69 Singapore 315079', 89990123, 'weilun@dentian.com', 'Super Admin', 'NULL', 'Dentian', 'Active'),
(2, 'Ian', 'Neo', 'ianneo', 'password', 'S4517037C', 'M', '1993-06-12', '50 Raffles Place #31-03 Lan Tower Singapore 048623', 95558311, 'ianneo@dentian.online', 'Super Admin', 'NULL', 'Dentian', 'Active'),
(3, 'Eugene', 'Sim', 'eugenesim', 'password', 'S2756750I', 'M', '1994-11-20', '111 North Bridge Road #04-25 Singapore 179098', 85557784, 'eugenesim@dentian.online', 'Super Admin', 'NULL', 'Dentian', 'Active'),
(4, 'Zhen Yi', 'Tan', 'tanzhenyi', 'password', 'S6860028F', 'F', '1996-03-16', 'Blk 302 Ang Mo Kio #01-1838 Singapore 560302', 85550144, 'tanzhenyi@dentian.online', 'Super Admin', 'NULL', 'Dentian', 'Active'),
(5, 'Dominic', 'Ng', 'dominicng', 'password', 'S8224678I', 'M', '1997-10-03', '385 Bukit Batok West Ave 5 #24-344 Singapore 650385', 85250794, 'dominicng@dentian.online', 'Super Admin', 'NULL', 'Dentian', 'Active'),
(6, 'Xin Xian', 'Tan', 'tanxinxian', 'password', 'S7827971J', 'F', '1998-02-09', 'Blk 157 Mei Ling Street #01-70 Singapore 140157', 95550863, 'tanxinxian@dentian.online', 'Super Admin', 'NULL', 'Dentian', 'Active'),
(1001, 'Marcus', 'Ong', 'marcusong', 'password', 'S8647225G', 'M', '1986-06-20', '404 Bedok North Ave 3, #11-145 460404', 84382569, 'marcusong@gmail.com', 'Dentist', 'Prosthodontist', 'Dental Focus Eunos Clinic', 'Active'),
(1002, 'Kelvin', 'Lim', 'limkelvin', 'password', 'S9911234B', 'M', '1999-09-12', '311A Anchorvale Lane, #14-30, 541311', 91137088, 'kevlim@crowndental.com', 'Dentist', 'Pedodontist', 'Crown Dental Surgery', 'Active'),
(1003, 'Johnathan ', 'Ho', 'JohnathanHo', 'password', 'S9785123O', 'M', '1997-07-23', 'Blk 95 Pasir Ris Street 21\r\n#12-02\r\n569120', 94588855, 'JohnnyTan@gmail.com', 'Dentist', 'General Dentist', 'Luminous Dental Clinic', 'Active'),
(1004, 'Brandon', 'Lee', 'brandonlee', 'password', 'S8219475D', 'M', '1982-12-02', '17A Taman Siglap 455696', 81280043, 'brandonlee@gmail.com', 'Dentist', 'General Dentist', 'Dental Focus Eunos Clinic', 'Active'),
(1005, 'Keith', 'Lim', 'keithlim', 'password', 'S8614436I', 'M', '1986-02-16', '15 Hartley Grove 457884', 97993226, 'keithlim@gmail.com', 'Dentist', 'Prosthodontist', 'Dental Focus Eunos Clinic', 'Active'),
(1006, 'Lisa', 'Sim', 'simlisa', 'password', 'S8922258K', 'F', '1989-01-02', '941 Hougang Street 92 530941', 80094750, 'lisasim@crowndental.com', 'Dentist', 'Endodontist', 'Crown Dental Surgery', 'Active'),
(1007, 'Natalie', 'Wong', 'NataWong', 'password', 'S9312502J', 'F', '1993-02-02', '647A Tampines St 62, #10-01\r\nSingapore 521647', 94588855, 'NatalieWong123@gmail.com', 'Dentist', 'Pedodontist', 'Luminous Dental Clinic', 'Active'),
(1008, 'SiewMei', 'Wong', 'wongsiewmei', 'password', 'S9384753S', 'F', '1993-07-06', '410 Serangoon Central 550410', 97680345, 'wongsiewm@crowndental.com', 'Dentist', 'General Dentist', 'Crown Dental Surgery', 'Active'),
(1009, 'Janice', 'Aw', 'janiceaw', 'password', 'S7467783P', 'F', '1988-12-12', 'Blk 40 Lorong 10 Bukit Purmei #11-31 Singapore 090104', 94649722, 'janiceaw@gmail.com', 'Dentist', 'Orthodontist', 'MyBracesClinic', 'Active'),
(1010, 'Ray', 'Khoo', 'raykhoo', 'password', 'G1891463Z', 'M', '1985-01-22', 'Blk 19 Lorong 5 Gek Poh Ville #08-13 Singapore 649149', 88879264, 'raykhoo1985@gmail.com', 'Dentist', 'General Dentist', 'MyBracesClinic', 'Active'),
(1011, 'Dickson', 'Goh', 'DicksonGoh', 'password', 'S9381205G', 'M', '1993-06-21', '31 Punggol Field, #01-08\r\nSingapore 828809', 83122255, 'DicksonGoh@hotmail.com', 'Dentist', 'Oral Pathologist', 'Luminous Dental Clinic', 'Active'),
(1012, 'Adeline', 'Lee', 'adelinelee', 'password', 'S6440684P', 'F', '1990-06-11', '78 Bedok Reservoir Green #06-03 Singapore 460078', 90915031, 'adelinelee@gmail.com', 'Dentist', 'Oral Pathologist', 'MyBracesClinic', 'Active'),
(1013, 'Aaron', 'Seow Lee Huat', 'aaronseowlh', 'password', 'S8545038A', 'M', '1985-05-03', '56 Jln Girang, Singapore 359225', 92450865, 'aaron.seowlh@drseow.com', 'Dentist', 'General Dentist', 'Dr Seow Dental Surgery', 'Active'),
(1014, 'James', 'Lau', 'jameslau', 'password', 'S9339974I', 'M', '1993-03-25', '24 Li Hwan Cl, Singapore 557147', 95551297, 'james.lau@drseow.com', 'Dentist', 'Oral Pathologist', 'Dr Seow Dental Surgery', 'Active'),
(1015, 'Jerome', 'Foo', 'jeromefoo', 'password', 'S8980307A', 'M', '1989-09-16', '68 Borthwick Dr, Singapore 559571', 90309974, 'jerome.foo@drseow.com', 'Dentist', 'Orthodontist', 'Dr Seow Dental Surgery', 'Active'),
(1016, 'Ryan', 'Chee', 'cheeryan', 'password', 'G9930028R', 'M', '1988-02-17', '6 Sims Dr, Singapore 387388', 81102733, 'ryanchee@crowndental.com', 'Dentist', 'Oral Pathologist', 'Crown Dental Surgery', 'Active'),
(2001, 'Mary', 'Teo', 'maryteo', 'password', 'S8420001A', 'F', '1984-01-02', '116 Bedok Reservoir Rd, #08-110 470116', 96621384, 'maryteo@gmail.com', 'Dentist Assistant', 'NULL', 'Dental Focus Eunos Clinic', 'Active'),
(2002, 'Angel', 'Tock', 'angeltock', 'password', 'S8810334F', 'F', '1988-02-10', '369 Tampines Street 34 #02-35 520369', 81611024, 'angeltock@gmail.com', 'Dentist Assistant', 'NULL', 'Dental Focus Eunos Clinic', 'Active'),
(2003, 'Natasha', 'Tam', 'NatashaTam', 'password', 'S9581302P', 'F', '1995-10-19', '39 Saraca Rd, #08-07\r\nSingapore 807385', 94588866, 'NatashaTam@yahoo.com', 'Dentist Assistant', 'NULL', 'Luminous Dental Clinic', 'Active'),
(2004, 'Betty', 'Eng', 'bettyeng', 'password', 'S8851639Q', 'F', '1980-02-24', 'Blk 421 Hougang Street 16 #07-30 Singapore 530421', 81338368, 'bettyeng@gmail.com', 'Dentist Assistant', 'NULL', 'MyBracesClinic', 'Active'),
(2005, 'Garett', 'Pang', 'garettpang', 'password', 'G0240762L', 'M', '1993-12-10', 'Blk 49 Jurong East Street 75 #11-06 Singapore 609653', 97711583, 'garettpang@gmail.com', 'Dentist Assistant', 'NULL', 'MyBracesClinic', 'Active'),
(2006, 'Lay Bee', 'Tan', 'LayBeeTan', 'password', 'S6812036I', 'F', '1968-10-09', '118 Aljunied Ave 2, #01-101,\r\n Singapore 380118', 91844233, 'LayBeeTan@gmail.com', 'Dentist Assistant', 'NULL', 'Luminous Dental Clinic', 'Active'),
(2007, 'Lelia', 'Peck', 'LeliaPeck', 'password', 'S8912036L', 'F', '1989-01-10', '101 Lor Sarina, #02-03\r\nSingapore 416729', 95855633, 'LeliaPeck@gmail.com', 'Dentist Assistant', 'NULL', 'Luminous Dental Clinic', 'Active'),
(2008, 'Rosa', 'Mendenz', 'mendenzrosa', 'password', 'G0034911R', 'F', '1996-06-25', '507 Bedok North Ave 3 Singapore 460507', 81130485, 'rosamendenz@crowndental.com', 'Dentist Assistant', 'NULL', 'Crown Dental Surgery', 'Active'),
(2009, 'Wei Jie', 'Chia', 'chiaweijie', 'password', 'S7000711Y', 'M', '1999-08-20', '51A Lor H Telok Kurau, Singapore 426154', 81184930, 'chiaweij@crowndental.com', 'Dentist Assistant', 'NULL', 'Crown Dental Surgery', 'Active'),
(2010, 'Hui Min', 'Song ', 'huiminsong', 'password', 'T0174619J', 'F', '2001-08-01', '141 Lor Ah Soo #03-640, Singapore 530141', 97435177, 'huimin.song@drseow.com', 'Dentist Assistant', 'NULL', 'Dr Seow Dental Surgery', 'Active'),
(2011, 'Alan', 'Lee', 'alanlee', 'password', 'S9977659E', 'M', '1999-07-14', '233 Hougang Street 21 #12-388, Singapore 530233', 92868369, 'alan.lee@drseow.com', 'Dentist Assistant', 'NULL', 'Dr Seow Dental Surgery', 'Active'),
(3001, 'Valerie', 'Soh Chien Yi', 'valeriesoh', 'password', 'S9012688C', 'F', '1990-02-02', '220 Serangoon Ave 4 #08-530, Singapore 550220', 96324678, 'valerie.sohcy@drseow.com', 'Receptionist', 'NULL', 'Dr Seow Dental Surgery', 'Active'),
(3002, 'Kenneth', 'Tan', 'tankenneth', 'password', 'T0101764H', 'M', '2001-05-14', '1 Tampines Ln, Singapore 528482', 94857365, 'kennethtan@crowndental.com', 'Receptionist', 'NULL', 'Crown Dental Surgery', 'Active'),
(3003, 'Pearlyn ', 'Lee', 'pearlynlee', 'password', 'S9601784H', 'F', '1996-01-15', '14 Clifton Vale, Singapore 359688', 82246457, 'pearlyn.lee@drseow.com', 'Receptionist', 'NULL', 'Dr Seow Dental Surgery', 'Active'),
(3004, 'Shannon', 'Tan', 'shannontan', 'password', 'S9202345P', 'F', '1992-03-30', '533 Bedok North Street 3 #05-369 460533', 86594470, 'shannontan@gmail.com', 'Receptionist', 'NULL', 'Dental Focus Eunos Clinic', 'Active'),
(3005, 'Izabella', 'Tan', 'tanizabella', 'password', 'S9937461R', 'F', '1999-10-19', '148 Tampines Ave 5, Singapore 521148', 93211173, 'izabellatan@crowndental.com', 'Receptionist', 'NULL', 'Crown Dental Surgery', 'Active'),
(3006, 'Jennifer', 'Wong', 'jenwong', 'password', 'S9092210E', 'F', '1990-11-05', '98 Ceylon Road 429679', 97881244, 'jenwong@gmail.com', 'Receptionist', 'NULL', 'Dental Focus Eunos Clinic', 'Active'),
(3007, 'Zaidah', 'Nasir', 'zaidahnasir', 'password', 'S8308527L', 'F', '1992-10-02', '11 Jln Melor Singapore 368846', 99444328, 'zaidahnasir92@gmail.com', 'Receptionist', 'NULL', 'MyBracesClinic', 'Active'),
(3008, 'Claire', 'Lye', 'clairelye', 'password', 'S4197920P', 'F', '1997-05-11', 'Blk 25 Hougang Street 76 #12-15 Singapore 530025', 94216607, 'clairelye1997@gmail.com', 'Receptionist', 'NULL', 'MyBracesClinic', 'Active'),
(3009, 'Roslyn', 'Rajoo', 'RoslynRajoo', 'password', 'S6712048O', 'F', '1967-10-26', '712 Bedok Reservoir Rd, #09-05\r\nSingapore 470712', 91855642, 'RoslynRajoo@yahoo.com', 'Receptionist', 'NULL', 'Luminous Dental Clinic', 'Active'),
(3010, 'Roger', 'Guo', 'RogerGuo', 'password', 'S8513591B', 'M', '1985-12-11', '7 Tanah Merah Kechil Rd, #09-09\r\n Singapore 466666', 98755510, 'RogerGuo@hotmail.com', 'Receptionist', 'NULL', 'Luminous Dental Clinic', 'Active'),
(5001, 'Sidney', 'Tan', 'sidneytan', 'password', 'S9385506I', 'M', '1993-10-25', '468 Pasir Ris Drive 6 #02-21', 97180306, 'sidneytan@gmail.com', 'Clinic Admin', 'NULL', 'Dental Focus Eunos Clinic', 'Active'),
(5002, 'Zhen Zhen', 'Tan', 'tanzhenzhen', 'password', 'S9931926R', 'F', '1999-02-15', '100 Punggol Dr., Singapore 828853', 98630010, 'zhenzhentan@crowndental.com', 'Clinic Admin', 'NULL', 'Crown Dental Surgery', 'Active'),
(5003, 'Nichole', 'Koh', 'nicholekoh', 'password', 'S6779079B', 'F', '1995-05-14', 'Blk 289 Pasir Ris Street 33 #04-05 Singapore 510256', 96142406, 'nicholekoh95@gmail.com', 'Clinic Admin', 'NULL', 'MyBracesClinic', 'Active'),
(5004, 'Rahul', 'Riduan', 'RahulRiduan', 'password', 'S9345168O', 'M', '1993-02-03', '294 Tampines Street 22, #06-10\r\nBlock 294, Singapore 520294', 94852365, 'RahulRiduan@gmail.com', 'Clinic Admin', 'NULL', 'Luminous Dental Clinic', 'Active'),
(5005, 'Aiden', 'Pang', 'AidenPang', 'password', 'S9513258P', 'M', '1995-03-08', '200 Loyang Ave, #03-05\r\nSingapore 509058', 98462058, 'AidenPang@gmail.com', 'Clinic Admin', 'NULL', 'Luminous Dental Clinic', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment_table`
--
ALTER TABLE `appointment_table`
  ADD PRIMARY KEY (`appointment_id`);

--
-- Indexes for table `dental_services`
--
ALTER TABLE `dental_services`
  ADD PRIMARY KEY (`SID`),
  ADD UNIQUE KEY `Service_ID` (`Service_ID`);

--
-- Indexes for table `dentist_schedule`
--
ALTER TABLE `dentist_schedule`
  ADD PRIMARY KEY (`schedule_id`);

--
-- Indexes for table `dentist_work_time`
--
ALTER TABLE `dentist_work_time`
  ADD PRIMARY KEY (`work_id`);

--
-- Indexes for table `invoice_order`
--
ALTER TABLE `invoice_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `invoice_order_item`
--
ALTER TABLE `invoice_order_item`
  ADD PRIMARY KEY (`order_item_id`);

--
-- Indexes for table `patient_profile`
--
ALTER TABLE `patient_profile`
  ADD PRIMARY KEY (`Patient_ID`);

--
-- Indexes for table `patient_record`
--
ALTER TABLE `patient_record`
  ADD PRIMARY KEY (`Record_ID`),
  ADD KEY `Patient_ID` (`Patient_ID`);

--
-- Indexes for table `product_table`
--
ALTER TABLE `product_table`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`Emp_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment_table`
--
ALTER TABLE `appointment_table`
  MODIFY `appointment_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `dentist_schedule`
--
ALTER TABLE `dentist_schedule`
  MODIFY `schedule_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=297;

--
-- AUTO_INCREMENT for table `dentist_work_time`
--
ALTER TABLE `dentist_work_time`
  MODIFY `work_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_order`
--
ALTER TABLE `invoice_order`
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=818;

--
-- AUTO_INCREMENT for table `invoice_order_item`
--
ALTER TABLE `invoice_order_item`
  MODIFY `order_item_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4726;

--
-- AUTO_INCREMENT for table `patient_record`
--
ALTER TABLE `patient_record`
  MODIFY `Record_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `product_table`
--
ALTER TABLE `product_table`
  MODIFY `product_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `patient_record`
--
ALTER TABLE `patient_record`
  ADD CONSTRAINT `patient_record_ibfk_1` FOREIGN KEY (`Patient_ID`) REFERENCES `wixDatabase`.`wixPatients` (`Patient_ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
