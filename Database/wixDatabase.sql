-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 20, 2022 at 05:35 AM
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
-- Database: `wixDatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `wixClients`
--

CREATE TABLE `wixClients` (
  `_id` varchar(50) NOT NULL,
  `_createdDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `_updatedDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `_owner` varchar(50) DEFAULT NULL,
  `Emp_ID` int NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `contact_number` int NOT NULL,
  `NRIC_PNum` varchar(9) NOT NULL,
  `Birth_Date` date DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `clinic_name` varchar(100) NOT NULL,
  `clinic_contact` int NOT NULL,
  `clinic_uen` varchar(100) NOT NULL,
  `clinic_specialization` varchar(100) NOT NULL,
  `clinic_address` varchar(255) NOT NULL,
  `postal_code` int NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'Clinic Admin',
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `wixClients`
--

INSERT INTO `wixClients` (`_id`, `_createdDate`, `_updatedDate`, `_owner`, `Emp_ID`, `first_name`, `last_name`, `contact_number`, `NRIC_PNum`, `Birth_Date`, `email`, `address`, `username`, `password`, `clinic_name`, `clinic_contact`, `clinic_uen`, `clinic_specialization`, `clinic_address`, `postal_code`, `role`, `status`) VALUES
('1e6558ce-3f85-4db5-92fe-8e52e5ac87be', '2022-08-19 19:01:56', '2022-08-19 19:01:56', '083b9c78-1336-48b6-bd50-2251246afa23', 4021, 'Ryan', 'Goh', 81382245, 'S8418531F', '1984-05-24', 'ryan@crowndental.com', '32 Tanah Merah Kechil Road #11-17 East Meadows, 465559', 'ryangoh', 'password', 'Crown Dental Surgery', 67889110, '1536620G', 'General Dentistry', '821 Tampines Street 81 #01-210', 520821, 'Clinic Admin', 'Active'),
('2d0d78bc-091a-451f-b398-cc524d5352b0', '2022-08-19 19:18:58', '2022-08-19 19:18:58', '083b9c78-1336-48b6-bd50-2251246afa23', 4024, 'Kelvin', 'Ong', 98226501, 'S8103376B', '1981-01-14', 'kelvinong@gmail.com', '5 Jln Ismail 419253', 'kelvinong', 'password', 'Dental Focus Eunos Clinic', 68410686, '1213168R', 'Prosthodontist', '2A Eunos Cres, #01-2439', 401002, 'Clinic Admin', 'Active'),
('417fbac0-eaa3-41a0-8485-b9b31aa88e43', '2022-08-19 19:07:01', '2022-08-19 19:07:01', '083b9c78-1336-48b6-bd50-2251246afa23', 4022, 'Sylvia', 'Chua', 96246651, 'S7415944F', '1974-03-22', 'sylvia@gmail.com', '416 Yishun Ring Road, #10-1440 760416', 'sylviachua', 'password', 'Luminous Dental Clinic', 62500355, '1626186C', 'General Dentistry', 'Northpoint City (South Wing) 1 Northpoint Drive #02-150', 768019, 'Clinic Admin', 'Active'),
('514d5078-deb0-491d-bce5-e3eab244734c', '2022-08-19 19:13:19', '2022-08-19 19:13:19', '083b9c78-1336-48b6-bd50-2251246afa23', 4023, 'Crystal', 'Tan', 93682933, 'S7641253E', '1976-08-09', 'crystaltan@gmail.com', '53 Meyer Road #06-108 437876', 'crystaltan', 'password', 'MyBracesClinic', 67379797, '1316071K', 'Braces', '43 Jalan Merah Saga #01-80 Chip Bee Gardens', 278115, 'Clinic Admin', 'Active'),
('7d2bab7e-268d-4e68-961c-2383d120563a', '2022-08-19 18:58:14', '2022-08-19 18:58:14', '083b9c78-1336-48b6-bd50-2251246afa23', 4020, 'Aaron', 'Seow', 92265862, 'S8514437H', '1985-06-17', 'aaron@drseow.com', '9 Siglap Ave 456291', 'aaronseow', 'password', 'Dr Seow Dental Surgery', 67770113, '0072493D', 'Dental Surguery', '43 Holland Drive #01-51', 270043, 'Clinic Admin', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `wixPatients`
--

CREATE TABLE `wixPatients` (
  `_id` varchar(50) NOT NULL,
  `_createdDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `_updatedDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `_owner` varchar(50) DEFAULT NULL,
  `Patient_ID` int NOT NULL,
  `First_Name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Last_Name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `NRIC_PNum` varchar(9) NOT NULL,
  `Gender` varchar(6) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Birth_Date` date DEFAULT NULL,
  `Address` varchar(100) NOT NULL,
  `postal_code` int NOT NULL,
  `Nationality` varchar(50) NOT NULL,
  `Phone_Num` int NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Marital_Status` varchar(20) NOT NULL,
  `Occupation` varchar(50) NOT NULL,
  `Smoker` varchar(3) NOT NULL,
  `Allergies` varchar(200) DEFAULT NULL,
  `Long_term_med` varchar(200) DEFAULT NULL,
  `Existing_Med_Conds` varchar(200) DEFAULT NULL,
  `Referred_by_clinic` varchar(200) DEFAULT NULL,
  `Referred_memo` varchar(200) DEFAULT NULL,
  `Emer_Name` varchar(50) NOT NULL,
  `Emer_Contact` int NOT NULL,
  `Emer_relation` varchar(20) NOT NULL,
  `Subsidies` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `wixPatients`
--

INSERT INTO `wixPatients` (`_id`, `_createdDate`, `_updatedDate`, `_owner`, `Patient_ID`, `First_Name`, `Last_Name`, `NRIC_PNum`, `Gender`, `Birth_Date`, `Address`, `postal_code`, `Nationality`, `Phone_Num`, `Email`, `Marital_Status`, `Occupation`, `Smoker`, `Allergies`, `Long_term_med`, `Existing_Med_Conds`, `Referred_by_clinic`, `Referred_memo`, `Emer_Name`, `Emer_Contact`, `Emer_relation`, `Subsidies`) VALUES
('155d5226-45fb-42bb-b180-6566b3da2054', '2022-08-19 19:16:19', '2022-08-19 19:16:19', 'ae612901-db32-483b-ae6a-2bbe683745e2', 31, 'Chloe', 'Wong', 'S9631582L', 'Female', '1996-10-09', '326 Thomson Rd \n# 10-12', 307631, 'Singaporean', 95888855, 'ChloeWong@gmail.com', 'Single', 'Insurance agent', 'Yes', 'Acrylates ', 'Steroid', '', '', '', 'Cindy', 98122255, 'Children', 'No'),
('1a116dfd-406e-4d76-9805-9a59f0969bdd', '2022-08-19 19:01:40', '2022-08-19 19:01:40', '957ce156-bad0-43f4-8dd6-415376cf06bb', 26, 'Jonathan', 'Koh', 'S9405008A', 'Male', '1994-01-04', '118 Yishun Ring Rd #02-068', 760118, 'Singaporean', 90284862, 'j.koh94@gmail.com', 'Single', 'Sales', 'Yes', '', '', 'Asthma', '', '', 'Sarah', 83380258, 'Mother', 'Yes'),
('1f9e0475-afdb-461e-b7c5-62e4966e0996', '2022-08-19 19:07:38', '2022-08-19 19:07:38', '957ce156-bad0-43f4-8dd6-415376cf06bb', 28, 'Kar Chun', 'Wong', 'S8845079J', 'Male', '1988-04-12', '401 Sin Ming Ave #01-316', 570401, 'Singaporean', 94256685, 'wongkczz@gmail.com', 'Married', 'Manager', 'No', '', '', '', '', '', 'Wong Chee Kiat', 90208865, 'Father', 'No'),
('3c47781b-8712-48ed-95c3-8a233c703257', '2022-08-19 19:13:57', '2022-08-19 19:13:57', '957ce156-bad0-43f4-8dd6-415376cf06bb', 30, 'Xin Yi', 'Toh', 'S9855308G', 'Female', '1998-05-12', '27 Chai Chee Rd, #05-422', 460027, 'Singaporean', 91267876, 'xinyi.toh1998@gmail.com', 'Single', 'Student', 'No', 'Peanut', '', '', '', '', 'Toh Meng Hao', 97026012, 'Father', 'No'),
('86f92743-15c8-4260-97b9-070c5f22307a', '2022-08-19 19:23:34', '2022-08-19 19:23:34', 'd5fbc59a-741f-4ffb-b9eb-171e31d94451', 35, 'Gabriel', 'Tan', 'T0487931E', 'Male', '2004-10-20', 'Blk 150 Bishan Street 11, #02-233', 570150, 'Singaporean', 90076391, 'gabtan@hotmail.com', 'Single', 'Student', 'No', '', '', '', '', '', 'Sheryl Tan', 80019881, 'Mother', 'No'),
('98e44b7f-25a7-4cce-b6e5-eae4b70cded1', '2022-08-19 19:19:39', '2022-08-19 19:19:39', '957ce156-bad0-43f4-8dd6-415376cf06bb', 32, 'Peter', 'Ong Wei Jie', 'S8562773C', 'Male', '1985-05-31', '155 Lor 1 Toa Payoh #12-138', 310155, 'Singaporean', 81380358, 'peter.weijie85@hotmail.com', 'Married', 'Analyst', 'Yes', '', '', '', 'Smile Central Clinic', 'Nil', 'Sheryl Ong', 92257486, 'Spouse', 'Yes'),
('9e2b96d5-9f2a-4510-b5b6-227f87ee0209', '2022-08-19 19:20:21', '2022-08-19 19:20:21', 'd5fbc59a-741f-4ffb-b9eb-171e31d94451', 33, 'Albert', 'Ong', 'S3703819M', 'Male', '1937-03-09', '528 Bukit Batok Street 51, 12-130', 650528, 'Singaporean', 92760183, 'albertong37@yahoo.com', 'Widow', 'Retiree', 'Yes', 'Ethanol, Penicillin', 'High Cholesterol Medication', 'High Cholesterol', '', '', 'Ong Xin Na', 93087229, 'Children', 'Yes'),
('af7593fe-1c4b-4693-a1c7-36c0552fd457', '2022-08-19 19:06:58', '2022-08-19 19:06:58', 'ae612901-db32-483b-ae6a-2bbe683745e2', 27, 'John', 'Tan', 'S6984310I', 'Male', '1969-08-09', 'Blk 10 Loyang Villas 6 Loyang Rise', 507712, 'Singaporean', 81596305, 'JohnTan123@gmail.com', 'Single', 'Teacher', 'No', '', '', '', '', '', 'James', 97851365, 'Father', 'No'),
('b1e3976b-c6a7-4634-b164-8aad1069b887', '2022-08-19 19:22:01', '2022-08-19 19:22:01', 'ae612901-db32-483b-ae6a-2bbe683745e2', 34, 'Kelvin ', 'Kong', 'S9015345L', 'Male', '1990-07-04', 'Blk 5 Mayo Street #01-02', 208785, 'Singaporean', 96625588, 'KelvinKK@yahoo.com', 'Married', 'Military Personnel', 'Yes', 'Rashes when in contact with latex', 'High-blood pressure medication', 'Diabetes', '', '', 'Calvin', 94588877, 'Sibling', 'No'),
('be1f76c4-b39e-46f7-a834-f359472e0048', '2022-08-19 19:26:42', '2022-08-19 19:26:42', 'ae612901-db32-483b-ae6a-2bbe683745e2', 37, 'Sam', 'Tan', 'S9410236K', 'Male', '1994-11-02', '227 Serangoon Avenue 4\n#02-03', 550227, 'Singaporean', 98455522, 'SamTan@gmail.com', 'Single', 'Physical trainer', 'No', '', ' Inhaled corticosteroids', 'Asthma', '', '', 'Tam Tan', 94566633, 'Mother', 'No'),
('dbc65dcf-e34a-49b1-a860-691e208a218f', '2022-08-19 19:25:07', '2022-08-19 19:25:07', '957ce156-bad0-43f4-8dd6-415376cf06bb', 36, 'Mohd Aaqil', 'bin Afiq', 'S9723045A', 'Male', '1997-03-26', '429 Woodlands Street 41, #01-528', 730429, 'Singaporean', 93681255, 'bluesparkz@gmail.com', 'Single', 'Student', 'Yes', '', '', '', '', '', 'Mohd Afiq bin Shakil', 90017861, 'Father', 'No'),
('dddc6d27-f7e7-4f96-bfef-d5d05cf6ae1b', '2022-08-19 19:09:44', '2022-08-19 19:09:44', 'ae612901-db32-483b-ae6a-2bbe683745e2', 29, 'Tom', 'Lim', 'S9231584P', 'Male', '1992-05-06', 'Blk 31 Serangoon Garden Estate 15 Blandford Drive', 559849, 'Singaporean', 94851022, 'TomLim@hotmail.com', 'Single', 'Student', 'Yes', '', '', '', '', '', 'Jerry Lim', 98400055, 'Sibling', 'No');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wixClients`
--
ALTER TABLE `wixClients`
  ADD PRIMARY KEY (`_id`),
  ADD KEY `Emp_ID` (`Emp_ID`);

--
-- Indexes for table `wixPatients`
--
ALTER TABLE `wixPatients`
  ADD PRIMARY KEY (`_id`),
  ADD UNIQUE KEY `Patient_ID` (`Patient_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wixClients`
--
ALTER TABLE `wixClients`
  MODIFY `Emp_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4025;

--
-- AUTO_INCREMENT for table `wixPatients`
--
ALTER TABLE `wixPatients`
  MODIFY `Patient_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
