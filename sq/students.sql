-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 03, 2020 at 11:07 AM
-- Server version: 5.7.28-0ubuntu0.18.04.4
-- PHP Version: 7.2.24-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `students`
--

-- --------------------------------------------------------

--
-- Table structure for table `StudentsDetails`
--

CREATE TABLE `StudentsDetails` (
  `_id` int(10) NOT NULL,
  `studentName` varchar(50) NOT NULL,
  `_createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `_updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `StudentsDetails`
--

INSERT INTO `StudentsDetails` (`_id`, `studentName`, `_createdAt`, `_updatedAt`) VALUES
(1, 'Jack.Sparrow', '2020-02-02 10:09:09', '2020-02-02 10:09:09'),
(2, 'Jack.Reacher', '2020-02-02 10:09:09', '2020-02-02 10:09:09'),
(5, 'Jack.Parrot', '2020-02-03 04:13:40', '2020-02-03 04:13:40'),
(6, 'Jack.Ryon', '2020-02-03 04:13:40', '2020-02-03 04:13:40');

-- --------------------------------------------------------

--
-- Table structure for table `StudentSubjectMarksMapping`
--

CREATE TABLE `StudentSubjectMarksMapping` (
  `_id` int(11) NOT NULL,
  `studentId` int(11) DEFAULT NULL,
  `subjectId` int(11) DEFAULT NULL,
  `marks` int(11) DEFAULT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT '0',
  `_createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `_updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `StudentSubjectMarksMapping`
--

INSERT INTO `StudentSubjectMarksMapping` (`_id`, `studentId`, `subjectId`, `marks`, `isDeleted`, `_createdAt`, `_updatedAt`) VALUES
(1, 1, 1, 11, 0, '2020-02-02 10:39:49', '2020-02-02 10:39:49'),
(2, 2, 2, 5012, 0, '2020-02-02 10:39:49', '2020-02-02 10:39:49'),
(3, 5, 1, 9242, 0, '2020-02-03 05:10:02', '2020-02-03 05:10:02'),
(7, 1, 2, 25000, 1, '2020-02-03 05:27:21', '2020-02-03 05:27:21'),
(8, 1, 2, 5000, 1, '2020-02-03 05:35:16', '2020-02-03 05:35:16'),
(9, 1, 2, 10500, 0, '2020-02-03 05:35:46', '2020-02-03 05:35:46');

-- --------------------------------------------------------

--
-- Table structure for table `SubjectsDetails`
--

CREATE TABLE `SubjectsDetails` (
  `_id` int(11) NOT NULL,
  `subjectName` varchar(50) DEFAULT NULL,
  `_createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `_updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `SubjectsDetails`
--

INSERT INTO `SubjectsDetails` (`_id`, `subjectName`, `_createdAt`, `_updatedAt`) VALUES
(1, 'endology', '2020-02-02 10:16:47', '2020-02-02 10:16:47'),
(2, 'oncology', '2020-02-02 10:16:47', '2020-02-02 10:16:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `StudentsDetails`
--
ALTER TABLE `StudentsDetails`
  ADD PRIMARY KEY (`_id`),
  ADD UNIQUE KEY `studentName` (`studentName`);

--
-- Indexes for table `StudentSubjectMarksMapping`
--
ALTER TABLE `StudentSubjectMarksMapping`
  ADD PRIMARY KEY (`_id`),
  ADD KEY `studentId` (`studentId`),
  ADD KEY `subjectid` (`subjectId`),
  ADD KEY `marks` (`marks`);

--
-- Indexes for table `SubjectsDetails`
--
ALTER TABLE `SubjectsDetails`
  ADD PRIMARY KEY (`_id`),
  ADD UNIQUE KEY `subjectName` (`subjectName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `StudentsDetails`
--
ALTER TABLE `StudentsDetails`
  MODIFY `_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `StudentSubjectMarksMapping`
--
ALTER TABLE `StudentSubjectMarksMapping`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `SubjectsDetails`
--
ALTER TABLE `SubjectsDetails`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
