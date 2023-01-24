-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2023 at 01:10 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `attendance`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `name` varchar(70) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `data_added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `username`, `password`, `data_added`) VALUES
(1, 'ahmed nasr', 'test', '$2y$10$up46oAzwhdBTy259jwTJgeC1dxRAva8bjiDQEqu0kR.bjo.Qjwu.2', '2023-01-20 21:25:45'),
(2, 'mohamed nasr', 'medo', '$2y$10$OdezC.QU8xTg7kG7qP8.a.zF1p2rBAPkl4Suppq.GsM.2Fgj7kjHC', '2023-01-20 23:27:56');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_list`
--

CREATE TABLE `attendance_list` (
  `attendance_id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `type` int(11) NOT NULL DEFAULT 1,
  `date_updated` varchar(255) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance_list`
--

INSERT INTO `attendance_list` (`attendance_id`, `student_id`, `type`, `date_updated`, `date_created`) VALUES
(1, '1', 1, 'Jan 24 ,2023 12:04 AM', '2023-01-23 20:30:41'),
(2, '1', 2, 'Jan 24 ,2023 12:04 AM', '2023-01-24 20:31:02'),
(3, '2', 1, 'Jan 24 ,2023 12:04 AM', '2023-01-23 23:11:04'),
(6, '12', 1, 'Jan 24 ,2023 12:10 AM', '2023-01-24 01:10:25'),
(7, '12', 2, 'Jan 24 ,2023 12:10 AM', '2023-01-24 01:10:45'),
(8, '19', 1, 'Jan 24 ,2023 12:34 AM', '2023-01-24 01:34:35'),
(9, '19', 2, 'Jan 24 ,2023 12:36 AM', '2023-01-24 01:36:44');

-- --------------------------------------------------------

--
-- Table structure for table `course_list`
--

CREATE TABLE `course_list` (
  `course_id` int(11) NOT NULL,
  `course_code` varchar(60) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `date_added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course_list`
--

INSERT INTO `course_list` (`course_id`, `course_code`, `status`, `date_added`) VALUES
(1, 'BSCS', 1, '2023-01-21 00:27:35'),
(2, 'BSED', 1, '2023-01-21 00:27:35'),
(3, 'BSIS', 1, '2023-01-21 00:27:51'),
(4, 'BSITT', 1, '2023-01-21 00:27:51');

-- --------------------------------------------------------

--
-- Table structure for table `school_year`
--

CREATE TABLE `school_year` (
  `sy_id` int(11) NOT NULL,
  `school_year` varchar(60) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `date_added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `school_year`
--

INSERT INTO `school_year` (`sy_id`, `school_year`, `status`, `date_added`) VALUES
(1, '2021-2022', 0, '2023-01-21 00:25:01'),
(2, '2022-2023', 1, '2023-01-21 00:25:13'),
(4, '2019-2020', 0, '2023-01-21 19:21:43');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `student_code` varchar(50) NOT NULL,
  `fname` varchar(60) NOT NULL,
  `mname` varchar(60) NOT NULL,
  `lname` varchar(60) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `course_id` int(11) NOT NULL,
  `yl_id` int(11) NOT NULL,
  `sy_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `date_added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `student_code`, `fname`, `mname`, `lname`, `gender`, `email`, `contact`, `course_id`, `yl_id`, `sy_id`, `status`, `date_added`) VALUES
(1, '10140715', 'Cooper', 'Mark', 'D', 'male', 'aa@mgmail.com', '09321456789', 1, 2, 2, 1, '2023-01-21 00:18:51'),
(2, '62314150', 'Blake', 'Claire', 'D', 'female', 'aa@fgmail.com', '0977456789', 2, 1, 2, 0, '2023-01-21 00:22:37'),
(4, '623141505585', 'mohamed', '', 'medo', 'male', 'ewewd@cded.ew', '88555555888', 1, 1, 2, 1, '2023-01-22 23:30:57'),
(5, '7744168686109', 'njndew', '', 'eewe', 'male', 'a@a.aa', '7777789501', 1, 1, 2, 1, '2023-01-23 21:26:20'),
(6, '7744168686', 'edwe', '', 'ijie', 'male', 'aaa@gmail.com', '888569699', 2, 2, 2, 1, '2023-01-23 21:23:53'),
(7, '77441686861', 'edwe', '', 'ijie', 'male', 'aaa1@gmail.com', '888569699', 2, 2, 2, 1, '2023-01-23 21:24:55'),
(8, '774416868610', 'njndew', '', 'eewe', 'male', 'a@a.aa', '7777789501', 1, 1, 2, 1, '2023-01-23 21:25:26'),
(9, '7744168686101', 'njndew', '', 'eewe', 'male', 'a@a.aa', '7777789501', 1, 1, 2, 1, '2023-01-23 21:26:19'),
(10, '7744168686102', 'njndew', '', 'eewe', 'male', 'a@a.aa', '7777789501', 1, 1, 2, 1, '2023-01-23 21:26:19'),
(12, '7744168686104', 'njndew', '', 'eewe', 'male', 'a@a.aa', '7777789501', 1, 1, 2, 1, '2023-01-23 21:26:19'),
(13, '7744168686105', 'njndew', '', 'eewe', 'male', 'a@a.aa', '7777789501', 1, 1, 2, 1, '2023-01-23 21:26:19'),
(14, '7744168686106', 'njndew', '', 'eewe', 'male', 'a@a.aa', '7777789501', 1, 1, 2, 1, '2023-01-23 21:26:19'),
(15, '7744168686107', 'njndew', '', 'eewe', 'male', 'a@a.aa', '7777789501', 1, 1, 2, 1, '2023-01-23 21:26:19'),
(16, '7744168686108', 'njndew', '', 'eewe', 'male', 'a@a.aa', '7777789501', 1, 1, 2, 1, '2023-01-23 21:26:20'),
(17, '77441686861010', 'njndew', '', 'eewe', 'male', 'a@a.aa', '7777789501', 1, 1, 2, 1, '2023-01-23 21:26:20'),
(19, '777744580055', 'eew', '', 'ewed', 'male', 'ed@gmail.com', '7774110247788', 2, 1, 2, 1, '2023-01-24 01:34:14');

-- --------------------------------------------------------

--
-- Table structure for table `user_list`
--

CREATE TABLE `user_list` (
  `user_id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(70) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `date_added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_list`
--

INSERT INTO `user_list` (`user_id`, `fullname`, `username`, `password`, `type`, `status`, `date_added`) VALUES
(3, 'elmaistro hip', 'andro', '$2y$10$qPwB99u2synJlYYEaDtzw.4/EkTe0oxK404N33tqaWlspai.1UtUG', 1, 1, '2023-01-24 02:09:28');

-- --------------------------------------------------------

--
-- Table structure for table `year_level`
--

CREATE TABLE `year_level` (
  `yl_id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `year_level`
--

INSERT INTO `year_level` (`yl_id`, `name`, `date_added`) VALUES
(1, 'Third Year', '2023-01-21 00:25:50'),
(2, 'Second Year', '2023-01-21 00:25:50'),
(3, 'Fourth Year', '2023-01-21 00:26:08'),
(4, 'First Year', '2023-01-21 00:26:08'),
(5, 'Fifth Year', '2023-01-21 00:27:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `attendance_list`
--
ALTER TABLE `attendance_list`
  ADD PRIMARY KEY (`attendance_id`);

--
-- Indexes for table `course_list`
--
ALTER TABLE `course_list`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `school_year`
--
ALTER TABLE `school_year`
  ADD PRIMARY KEY (`sy_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `user_list`
--
ALTER TABLE `user_list`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `year_level`
--
ALTER TABLE `year_level`
  ADD PRIMARY KEY (`yl_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `attendance_list`
--
ALTER TABLE `attendance_list`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `course_list`
--
ALTER TABLE `course_list`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `school_year`
--
ALTER TABLE `school_year`
  MODIFY `sy_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user_list`
--
ALTER TABLE `user_list`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `year_level`
--
ALTER TABLE `year_level`
  MODIFY `yl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
