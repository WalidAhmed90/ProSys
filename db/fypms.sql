-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2020 at 09:55 PM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fypms`
--

-- --------------------------------------------------------

--
-- Table structure for table `batch`
--

CREATE TABLE `batch` (
  `batchId` int(255) NOT NULL,
  `batchName` varchar(255) NOT NULL,
  `startingDate` date DEFAULT NULL,
  `isActive` tinyint(4) DEFAULT '0' COMMENT '0= inactive , 1= active',
  `fypPart` tinyint(1) DEFAULT '1' COMMENT '0 or 1',
  `createdDtm` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='batchDeadlinesInfo';

--
-- Dumping data for table `batch`
--

INSERT INTO `batch` (`batchId`, `batchName`, `startingDate`, `isActive`, `fypPart`, `createdDtm`) VALUES
(1, 'Spring 2020', '2020-01-01', 1, 1, '2020-02-12 13:29:08'),
(2, 'Fall 2020', '2020-03-30', 1, 1, '2020-03-29 04:02:35'),
(3, 'Spring 2019', '2020-04-05', 0, 1, '2020-04-05 10:40:36');

-- --------------------------------------------------------

--
-- Table structure for table `batch_settings`
--

CREATE TABLE `batch_settings` (
  `settingId` int(11) NOT NULL,
  `batchId` int(255) NOT NULL,
  `fyp1_grading` tinyint(1) NOT NULL,
  `fyp2_grading` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `batch_settings`
--

INSERT INTO `batch_settings` (`settingId`, `batchId`, `fyp1_grading`, `fyp2_grading`) VALUES
(1, 2, 0, 0),
(2, 1, 0, 0),
(3, 3, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `batch_tasks`
--

CREATE TABLE `batch_tasks` (
  `taskId` int(11) NOT NULL,
  `batchId` int(11) DEFAULT NULL,
  `fypPart` tinyint(1) DEFAULT '1',
  `taskName` text,
  `taskDetail` text,
  `taskWeek` int(11) DEFAULT NULL,
  `taskDeadline` datetime DEFAULT NULL,
  `templateId` int(11) DEFAULT NULL,
  `hasDeliverable` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1=has deliverable',
  `createdDtm` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `batch_tasks`
--

INSERT INTO `batch_tasks` (`taskId`, `batchId`, `fypPart`, `taskName`, `taskDetail`, `taskWeek`, `taskDeadline`, `templateId`, `hasDeliverable`, `createdDtm`) VALUES
(3, 1, 1, 'idea selection', '<p>select the task</p>', 1, '2020-04-06 12:34:00', 4, 1, '2020-04-05 09:33:59'),
(4, 1, 1, 'ERD ', '<p>nion9iojjio</p>', 1, '2020-04-14 12:00:00', 5, 0, '2020-04-05 20:34:14'),
(5, 1, 1, 'idea selection 2', '<p>90jjppjijiojoj</p>', 3, '2020-04-23 13:59:00', 4, 0, '2020-04-05 20:36:55');

-- --------------------------------------------------------

--
-- Table structure for table `batch_templates`
--

CREATE TABLE `batch_templates` (
  `templateId` int(11) NOT NULL,
  `batchId` int(11) DEFAULT NULL,
  `templateName` varchar(100) DEFAULT NULL,
  `templateLocation` varchar(150) DEFAULT NULL,
  `uploadedDtm` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `batch_templates`
--

INSERT INTO `batch_templates` (`templateId`, `batchId`, `templateName`, `templateLocation`, `uploadedDtm`) VALUES
(4, 1, 'file', 'file.jpg', '2020-03-31 03:45:16'),
(5, 1, 'project file', 'project file.jpg', '2020-03-31 03:46:19'),
(6, 1, 'resume template', 'resume template.docx', '2020-06-12 02:01:41');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `facultyId` int(255) NOT NULL,
  `facultyRid` varchar(50) NOT NULL,
  `facultyName` varchar(255) NOT NULL,
  `facultyPhoneNo` varchar(50) NOT NULL,
  `facultyEmail` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `facultyImage` varchar(255) DEFAULT NULL,
  `facultyPassword` varchar(255) NOT NULL,
  `isCoordinator` tinyint(1) DEFAULT NULL,
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isActive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Faculty Details';

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`facultyId`, `facultyRid`, `facultyName`, `facultyPhoneNo`, `facultyEmail`, `designation`, `facultyImage`, `facultyPassword`, `isCoordinator`, `createdDtm`, `isActive`) VALUES
(1, '00-11-123', 'Coordinator', '03456787980', 'coordinator@gmail.com', 'Coordinator', NULL, '$2y$10$5YvSFZ6Zfg77lSBT458stu1YwUbYqd7fP6RTsCNWV7So5G9WYnm3G', 1, '2020-02-02 18:29:56', 1),
(2, '00-11-124', 'Ridah Fatima Mudassir', '03167896542', 'ridah@gmail.com', 'Supervisor', NULL, '$2y$10$sgawcL/zxlqO7LsEutF7xelVxcto7Hxo5XLQMSpy4wMN4QTlHkHOq', 0, '2020-02-02 18:31:47', 1),
(3, '00-11-125', 'Noman Islam', '', 'nomanislam@gmail.com', 'Supervisor', NULL, '$2y$10$ap8ILiLgNbdwKvDjnhc6n.jZI7WyBMrYxof1omX42Rjwl514PWR2q', 0, '2020-02-28 02:00:55', 1),
(4, '00-11-126', 'S.jamal haider zaidi', '', 'jamalhaider@gmail.com', 'Supervisor', NULL, '$2y$10$slS8sJhHW.SAvgb1O/.8veEI.oq820eu.sNX6dazdFSgQ2L1uTsy2', 0, '2020-02-28 02:04:04', 1),
(5, '00-11-127', 'Walid ahmed', '', '', 'Supervisor', NULL, '$2y$10$gBJeKhJ80LkRa4ej2wRWa..HLu.uV1lj4t7/JJI6Ua1ch/WAGybWi', 0, '2020-02-28 02:27:03', 1),
(6, '00-11-128', 'alizain Aziz', '', '', 'Coordinator', NULL, '$2y$10$DdcDGl5u0I1SW6gLGDfU0.xc0/6io7BCGMGdnjk2foA9/wXjhWt9O', 1, '2020-02-28 02:27:52', 1);

-- --------------------------------------------------------

--
-- Table structure for table `faculty_student_group`
--

CREATE TABLE `faculty_student_group` (
  `facultyStudentId` int(255) NOT NULL,
  `groupId` int(255) NOT NULL,
  `facultyId` int(255) NOT NULL,
  `remove_group` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='facultyGroupInfo';

--
-- Dumping data for table `faculty_student_group`
--

INSERT INTO `faculty_student_group` (`facultyStudentId`, `groupId`, `facultyId`, `remove_group`) VALUES
(12, 20, 2, 0),
(13, 16, 3, 0),
(14, 22, 3, 0),
(15, 21, 2, 0),
(16, 24, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `faculty_student_request`
--

CREATE TABLE `faculty_student_request` (
  `requestId` int(11) NOT NULL,
  `facultyId` int(11) DEFAULT NULL,
  `groupId` int(11) DEFAULT NULL,
  `requestDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `studentId` int(11) DEFAULT NULL,
  `groupId` int(11) DEFAULT NULL,
  `fypPart` int(11) DEFAULT NULL,
  `contribution` int(255) NOT NULL,
  `anstoques` int(255) NOT NULL,
  `completion` int(255) NOT NULL,
  `presentation` int(255) NOT NULL,
  `novelty` int(255) NOT NULL,
  `comments` text,
  `grade` int(50) DEFAULT NULL,
  `gradedBy` int(11) DEFAULT NULL COMMENT 'User id of user',
  `iscord` int(255) NOT NULL,
  `gradeDtm` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `studentId`, `groupId`, `fypPart`, `contribution`, `anstoques`, `completion`, `presentation`, `novelty`, `comments`, `grade`, `gradedBy`, `iscord`, `gradeDtm`) VALUES
(1, 12, 16, 1, 15, 8, 17, 0, 0, 'no', 40, 2, 0, '2020-05-12 14:14:16'),
(2, 13, 16, 1, 17, 6, 19, 0, 0, 'no', 42, 2, 0, '2020-05-12 14:14:16'),
(3, 10, 20, 1, 16, 8, 17, 0, 0, 'no', 41, 2, 0, '2020-05-12 14:14:40'),
(4, 14, 20, 1, 17, 6, 18, 0, 0, 'no', 41, 2, 0, '2020-05-12 14:14:40'),
(5, 20, 20, 1, 18, 9, 19, 0, 0, 'no', 46, 2, 0, '2020-05-12 14:14:40'),
(6, 10, 20, 1, 16, 4, 17, 0, 0, 'no', 37, 3, 0, '2020-05-12 14:15:34'),
(7, 14, 20, 1, 16, 5, 18, 0, 0, 'no', 39, 3, 0, '2020-05-12 14:15:34'),
(8, 20, 20, 1, 18, 7, 19, 0, 0, 'no', 44, 3, 0, '2020-05-12 14:15:34'),
(9, 22, 22, 1, 16, 9, 19, 0, 0, 'no', 44, 3, 0, '2020-05-12 14:15:44'),
(10, 12, 16, 1, 16, 8, 18, 0, 0, 'no', 42, 1, 1, '2020-05-12 14:19:05'),
(11, 13, 16, 1, 17, 8, 19, 0, 0, 'no', 44, 1, 1, '2020-05-12 14:19:05'),
(12, 12, 16, 1, 17, 7, 19, 0, 0, 'no', 43, 4, 0, '2020-05-12 15:32:12'),
(13, 13, 16, 1, 18, 9, 18, 0, 0, 'no', 45, 4, 0, '2020-05-12 15:32:12'),
(14, 10, 20, 1, 17, 9, 18, 0, 0, 'no', 44, 1, 1, '2020-05-13 16:58:24'),
(15, 14, 20, 1, 15, 5, 18, 0, 0, 'no', 38, 1, 1, '2020-05-13 16:58:24'),
(16, 20, 20, 1, 17, 8, 19, 0, 0, 'no', 44, 1, 1, '2020-05-13 16:58:24'),
(17, 19, 21, 1, 16, 7, 16, 0, 0, 'good', 39, 2, 0, '2020-05-13 16:59:17'),
(18, 26, 24, 2, 17, 0, 0, 18, 8, 'no', 43, 2, 0, '2020-06-06 23:36:27'),
(19, 27, 24, 2, 18, 0, 0, 16, 7, 'no', 41, 2, 0, '2020-06-06 23:36:28'),
(20, 26, 24, 2, 16, 0, 0, 17, 8, 'no', 41, 1, 1, '2020-06-06 23:37:34'),
(21, 27, 24, 2, 18, 0, 0, 19, 9, 'no', 46, 1, 1, '2020-06-06 23:37:34');

-- --------------------------------------------------------

--
-- Table structure for table `group_requests`
--

CREATE TABLE `group_requests` (
  `requestId` int(255) NOT NULL,
  `studentId` int(255) NOT NULL,
  `groupId` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `group_uploads`
--

CREATE TABLE `group_uploads` (
  `id` int(11) NOT NULL,
  `groupId` int(11) NOT NULL,
  `taskId` int(11) NOT NULL,
  `uploadFile` varchar(50) NOT NULL,
  `uploadedBy` int(11) NOT NULL COMMENT 'userId of uploader',
  `uploadedDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `group_uploads`
--

INSERT INTO `group_uploads` (`id`, `groupId`, `taskId`, `uploadFile`, `uploadedBy`, `uploadedDtm`) VALUES
(1, 20, 3, 'group_20_deliverable_3.jpg', 20, '2020-04-05 09:35:10');

-- --------------------------------------------------------

--
-- Table structure for table `meeting_requests`
--

CREATE TABLE `meeting_requests` (
  `id` int(11) NOT NULL,
  `supervisor_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `meeting_title` varchar(50) NOT NULL,
  `meeting_dtm` datetime NOT NULL,
  `comments` text,
  `meeting_status` enum('Pending','Done','Cancelled','Postponed') NOT NULL DEFAULT 'Pending',
  `created_dtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Maintain all meeting logs of supervisors with students';

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notificationId` int(11) NOT NULL,
  `studentId` int(255) DEFAULT NULL,
  `batchId` int(255) DEFAULT NULL,
  `taskId` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notificationId`, `studentId`, `batchId`, `taskId`) VALUES
(1, 20, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `project_repository`
--

CREATE TABLE `project_repository` (
  `id` int(11) NOT NULL,
  `batchId` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project_repository`
--

INSERT INTO `project_repository` (`id`, `batchId`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `share_idea`
--

CREATE TABLE `share_idea` (
  `shareId` int(255) NOT NULL,
  `title` text,
  `details` text,
  `facultyName` text NOT NULL,
  `facultyId` int(255) NOT NULL,
  `fypPart` int(11) DEFAULT NULL,
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `share_idea`
--

INSERT INTO `share_idea` (`shareId`, `title`, `details`, `facultyName`, `facultyId`, `fypPart`, `createdDtm`) VALUES
(2, 'fyp management System', 'final year project management system', 'Ridah Fatima Mudassir', 2, 1, '2020-03-31 01:32:34'),
(3, 'Iu chat bot ', 'iqra university onilne chat bot.', 'Ridah Fatima Mudassir', 2, 1, '2020-03-31 02:06:12'),
(4, 'android app', 'for the recent situation .', 'Ridah Fatima Mudassir', 2, 1, '2020-03-31 02:09:47'),
(8, 'IU Society Elections ', '<p><a href=\"http://www.google.com\" target=\"_blank\">www.google.com</a><a href=\"http://www.google.com\" target=\"_blank\"></a></p><p>search from google .</p>', 'Coordinator', 1, 1, '2020-03-31 02:48:10'),
(9, 'android app react', '<p>vuuvuvuivuyvuyvuyvuy</p>', 'Ridah Fatima Mudassir', 2, 1, '2020-04-04 19:25:11'),
(11, 'Iu chat bot ', 'addddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd', 'Ridah Fatima Mudassir', 2, 1, '2020-06-07 00:21:47');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `studentId` int(255) NOT NULL,
  `studentName` varchar(255) CHARACTER SET utf8 NOT NULL,
  `studentRid` varchar(50) CHARACTER SET utf8 NOT NULL,
  `studentEmail` varchar(255) CHARACTER SET utf8 NOT NULL,
  `studentPhoneNo` varchar(50) CHARACTER SET utf8 NOT NULL,
  `studentGender` varchar(10) CHARACTER SET utf8 NOT NULL,
  `studentPassword` varchar(255) CHARACTER SET utf8 NOT NULL,
  `studentImage` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `groupId` int(255) DEFAULT NULL,
  `isLeader` int(1) DEFAULT NULL,
  `batchId` int(4) DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '1',
  `isVerify` int(11) NOT NULL,
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='FYP Student Records';

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`studentId`, `studentName`, `studentRid`, `studentEmail`, `studentPhoneNo`, `studentGender`, `studentPassword`, `studentImage`, `groupId`, `isLeader`, `batchId`, `isActive`, `isVerify`, `createdDtm`) VALUES
(10, 'Muhammad sami ullah qureshi', '12520', '', '', '', '$2y$10$k3EY.mMAWTPCjZehNRWvhONagYx.VRVEFZROuyEXOppWpwNGzhxEe', NULL, 20, NULL, 1, 1, 0, '2020-02-28 02:39:19'),
(12, 'Khalid Ahmed', '12423', 'khalidahmed@gmail.com', '03452', 'male', '$2y$10$bHQK19mQGWACLDANaKZvZeRRsZQH3TYGdw7r4AIU5/mEGL65VkRb.', '5ee29b4fee3163.87984288.jpg', 16, 1, 1, 1, 0, '2020-02-28 03:12:14'),
(13, 'sohaib bilal zafar', '12421', 'sohaibbilal@gmail.com', '03124567', '', '$2y$10$zqYOGFkPh1xTUAYVl/6CbusnTf3/SCDZer6f6cGkTeAdvVEmxmr3C', NULL, 16, NULL, 1, 1, 0, '2020-02-28 03:57:43'),
(14, 'alizain', '12425', '', '', '', '$2y$10$iKuBsWHciG3FnMYSPP8DA.ZsKzZkufpXBJbHg4dx2Ze1tmtnh7JxS', NULL, 20, NULL, 1, 1, 0, '2020-02-28 05:08:35'),
(15, 'waleed khan', '12426', '', '', '', '$2y$10$UpimJRpl7D5m4.ZLsrZV9OaBBUqWNhqKXjw8F9VAqXmhIe4Adn9Ma', NULL, NULL, NULL, 1, 1, 0, '2020-03-01 05:33:41'),
(16, 'khuzaima nadeem', '12427', '', '', '', '$2y$10$3VSEArAkCRDSnAVKnY2awewYkpgV2V9nbCtvH1dLyOgkrCMSK3FNi', NULL, NULL, NULL, 1, 1, 0, '2020-03-01 05:33:53'),
(17, 'mahad ahmed', '12428', '', '', '', '$2y$10$I8lK8oEz86aJDm11mWR9cOMhc1OfLVLk67meGei5XGqf8QT.NKwhm', NULL, NULL, NULL, 1, 1, 0, '2020-03-01 05:34:04'),
(18, 'azeem khan', '12429', '', '', '', '$2y$10$R0ruEY8KlwWmDj5d6XwJI.CnVPNNpTr66Wbhi/GdvZPlfdznlNQ4m', NULL, NULL, NULL, 1, 1, 0, '2020-03-01 05:34:26'),
(19, 'mohi khan', '12430', 'mohikhan345@gmail.com', '09764336738', 'male', '$2y$10$1fZhE16E7jRC/X6j91pQQOC4F7gQQxq5yG0g7QwhC9wPotm9SlDhS', NULL, 21, 1, 1, 1, 0, '2020-03-01 05:34:38'),
(20, 'walid ahmed', '12422', 'walidkhan@gmail.com', '03122', 'male', '$2y$10$B8gHE5XXl31c4rsUsW0y9OFTUuUUD5nj8xpPOSYrE/UiA1k4lSyly', '5ee29b16165f78.61262012.jpg', 20, 1, 1, 1, 0, '2020-03-01 05:38:46'),
(21, 'Mubashir Hussain', '12431', '', '', '', '$2y$10$J7GVZPW.1WNaIIebqqVCyefk68KygwPkuy7xRLtP8PycErqhra3aa', NULL, 23, 1, 1, 1, 0, '2020-03-27 20:52:05'),
(22, 'haroon rasheed', '12432', '', '', '', '$2y$10$Ni7Ol2VRq/FuTwCebnP6cuYg6nINp/lGiIZhMQFr52K9fQ0/X545S', NULL, 22, 1, 1, 1, 0, '2020-03-27 20:52:28'),
(23, 'Ather Anwar', '12433', '', '', '', '$2y$10$9clzbnVUTOO0CDHSvSqX4u4j6hdSwcWhQWy5w6jUE8kqkCRm2Y47e', NULL, NULL, NULL, 1, 1, 0, '2020-03-27 20:52:49'),
(24, 'talha khan', '12434', 'talhakhan@gmail.com', '1134534546464', '', '$2y$10$p4NySgWzfhId6q32hBV/Ae9zSFwOgnid7flksk843jwgeUP4SqXYq', NULL, NULL, NULL, 1, 1, 0, '2020-03-27 20:53:02'),
(25, 'areeb ahmed', '12435', 'areebahmed@gmail.com', '33223244232', 'male', '$2y$10$dm8fOdGbyKfV9edC.xcycu2Oc98Uu/whm7I/Dhl5NHzZPF1h3kuoW', NULL, NULL, NULL, 1, 1, 0, '2020-05-02 02:06:48'),
(26, 'sajeer', '12345', '', '', '', '$2y$10$AQYnRVBLsM9PWFmXXbqC1.KIMIZqu/6yonOip582jZf/aJ2YpotoK', NULL, 24, 1, 2, 1, 0, '2020-06-06 22:50:29'),
(27, 'walid', '12344', '', '', '', '$2y$10$2Jm7DAphJCnPGirSwE2XsOLaKSA.M9oGIlauj7UoxmGALWsPuSZMW', NULL, 24, NULL, 2, 1, 0, '2020-06-06 22:50:38'),
(28, 'areeb', '12346', '', '', '', '$2y$10$j.edPkES9UKMU8YJTmneH.l/CzN3xdL6h0MqhMGgssO0u3A53VaRS', NULL, 24, NULL, 2, 1, 0, '2020-06-06 22:50:47'),
(29, 'Abdul sami', '12347', '', '', '', '$2y$10$O/ElXG5hgFExPubd1NA4F.6kgBDLM/TfWZhN8dOp3wbdNzr7u2b9O', NULL, 25, 1, 2, 1, 0, '2020-06-06 22:51:40');

-- --------------------------------------------------------

--
-- Table structure for table `student_group`
--

CREATE TABLE `student_group` (
  `groupId` int(255) NOT NULL,
  `projectName` varchar(255) DEFAULT NULL,
  `categories` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `batchId` int(11) DEFAULT NULL,
  `fypPart` int(1) NOT NULL DEFAULT '1' COMMENT 'Here to check before deleting group',
  `groupLimit` int(1) NOT NULL DEFAULT '3',
  `inGroup` int(255) NOT NULL DEFAULT '1',
  `leaderId` int(255) NOT NULL,
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='groupInfo';

--
-- Dumping data for table `student_group`
--

INSERT INTO `student_group` (`groupId`, `projectName`, `categories`, `description`, `batchId`, `fypPart`, `groupLimit`, `inGroup`, `leaderId`, `createdDtm`) VALUES
(16, 'IU Chat Bot', 'Artificial Intelligence', 'university chatbot..', 1, 1, 3, 2, 12, '2020-03-01 03:16:40'),
(20, 'proSys', 'web portal', 'jsvps;lv;s', 1, 1, 3, 3, 20, '2020-03-01 06:00:50'),
(21, 'smart robot', 'Robotics', 'my first smart robot', 1, 1, 3, 1, 19, '2020-03-09 01:10:51'),
(22, 'yycvg', '3D/4D Printing', 'drdyhh', 1, 1, 3, 1, 22, '2020-03-27 21:19:46'),
(23, 'Smart Card', 'Augmented Reality/Virtual Reality', 'based on augmented reality', 1, 1, 3, 1, 21, '2020-04-09 20:24:34'),
(24, 'chatterbot', 'Artificial Intelligence', 'Ai project', 2, 1, 3, 3, 26, '2020-06-06 23:02:07'),
(25, 'Work 4 Worker', 'werbpotal', 'Web portal for workers to get job by home ', 2, 1, 3, 1, 29, '2020-06-25 23:37:12');

-- --------------------------------------------------------

--
-- Table structure for table `student_group_request`
--

CREATE TABLE `student_group_request` (
  `requestId` int(11) NOT NULL,
  `studentId` int(11) NOT NULL COMMENT 'Request sent by',
  `groupId` int(11) NOT NULL COMMENT 'Request sent to group',
  `requestDtm` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Requests sent to join a group a stored here temporarilty';

-- --------------------------------------------------------

--
-- Table structure for table `timeline_faculty`
--

CREATE TABLE `timeline_faculty` (
  `id` int(11) NOT NULL,
  `title` text,
  `details` text,
  `type` varchar(50) DEFAULT NULL,
  `batchId` int(11) DEFAULT NULL,
  `fypPart` int(11) DEFAULT NULL,
  `createdDtm` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='timeline for faculty';

--
-- Dumping data for table `timeline_faculty`
--

INSERT INTO `timeline_faculty` (`id`, `title`, `details`, `type`, `batchId`, `fypPart`, `createdDtm`) VALUES
(5, 'Info', 'Ridah Fatima Mudassir is not supervising group proSys', 'info', 1, 1, '2020-03-31 11:22:04'),
(6, 'Info', 'Ridah Fatima Mudassir is now supervising group proSys', 'info', 1, 1, '2020-03-31 11:41:10'),
(7, 'Info', 'Ridah Fatima Mudassir is now supervising group IU Chat Bot', 'info', 1, 1, '2020-03-31 11:49:17'),
(8, 'Info', 'Ridah Fatima Mudassir is now supervising group proSys', 'info', 1, 1, '2020-04-02 05:25:10'),
(9, 'Info', 'Ridah Fatima Mudassir is now supervising group IU Chat Bot', 'info', 1, 1, '2020-04-02 05:25:12'),
(10, 'Info', 'Ridah Fatima Mudassir is not supervising group IU Chat Bot', 'info', 1, 1, '2020-04-02 05:27:06'),
(11, 'Info', 'Ridah Fatima Mudassir is now supervising group IU Chat Bot', 'info', 1, 1, '2020-04-02 05:30:07'),
(12, 'Info', 'Ridah Fatima Mudassir is now supervising group smart robot', 'info', 1, 1, '2020-04-02 05:30:09'),
(13, 'Info', 'Ridah Fatima Mudassir is not supervising group proSys', 'info', 1, 1, '2020-04-02 06:27:34'),
(14, 'Info', 'Ridah Fatima Mudassir is now supervising group proSys', 'info', 1, 1, '2020-04-02 06:28:02'),
(15, 'Info', 'Ridah Fatima Mudassir is not supervising group proSys', 'info', 1, 1, '2020-04-02 17:29:02'),
(16, 'Info', 'Ridah Fatima Mudassir is now supervising group proSys', 'info', 1, 1, '2020-04-02 17:30:10'),
(17, 'Info', 'Ridah Fatima Mudassir is not supervising group IU Chat Bot', 'info', 1, 1, '2020-04-04 19:27:27'),
(18, 'Batch Upgraded', 'Spring 2019 has been upgraded to Project Defense', 'info', 3, 2, '2020-04-05 10:41:23'),
(19, 'Info', 'Noman Islam is now supervising group IU Chat Bot', 'info', 1, 1, '2020-04-09 19:54:15'),
(20, 'Info', 'Noman Islam is now supervising group yycvg', 'info', 1, 1, '2020-04-09 19:54:17'),
(21, 'Info', 'Ridah Fatima Mudassir is not supervising group smart robot', 'info', 1, 1, '2020-04-11 21:39:23'),
(22, 'Info', 'Ridah Fatima Mudassir is now supervising group smart robot', 'info', 1, 1, '2020-04-11 21:40:57'),
(23, 'Batch Upgraded', 'Spring 2020 has been upgraded to Project Defense', 'info', 1, 2, '2020-04-14 15:45:52'),
(24, 'Batch Upgraded', 'Spring 2020 has been upgraded to Project Defense', 'info', 1, 2, '2020-04-14 15:54:52'),
(25, 'Batch Upgraded', 'Spring 2020 has been upgraded to Project Defense', 'info', 1, 2, '2020-04-14 15:58:25'),
(26, 'Batch Upgraded', 'Fall 2020 has been upgraded to Project Defense', 'info', 2, 2, '2020-06-06 22:42:05'),
(27, 'Batch Upgraded', 'Fall 2020 has been upgraded to Project Defense', 'info', 2, 2, '2020-06-06 23:07:36'),
(28, 'Info', 'Ridah Fatima Mudassir is now supervising group chatterbot', 'info', 2, 2, '2020-06-06 23:10:06');

-- --------------------------------------------------------

--
-- Table structure for table `timeline_student`
--

CREATE TABLE `timeline_student` (
  `id` int(11) NOT NULL,
  `title` text,
  `details` text,
  `type` varchar(50) DEFAULT NULL,
  `taskId` int(11) DEFAULT NULL,
  `batchId` int(11) DEFAULT NULL,
  `fypPart` int(11) DEFAULT NULL,
  `createdDtm` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Timeline for students';

--
-- Dumping data for table `timeline_student`
--

INSERT INTO `timeline_student` (`id`, `title`, `details`, `type`, `taskId`, `batchId`, `fypPart`, `createdDtm`) VALUES
(7, 'Info', 'Ridah Fatima Mudassir is not supervising group proSys', 'info', NULL, 1, 1, '2020-03-31 11:22:04'),
(8, 'Info', 'Ridah Fatima Mudassir is now supervising group proSys', 'info', NULL, 1, 1, '2020-03-31 11:41:10'),
(9, 'Info', 'Ridah Fatima Mudassir is now supervising group IU Chat Bot', 'info', NULL, 1, 1, '2020-03-31 11:49:17'),
(10, 'Info', 'Ridah Fatima Mudassir is now supervising group proSys', 'info', NULL, 1, 1, '2020-04-02 05:25:10'),
(11, 'Info', 'Ridah Fatima Mudassir is now supervising group IU Chat Bot', 'info', NULL, 1, 1, '2020-04-02 05:25:12'),
(12, 'Info', 'Ridah Fatima Mudassir is not supervising group IU Chat Bot', 'info', NULL, 1, 1, '2020-04-02 05:27:06'),
(13, 'Info', 'Ridah Fatima Mudassir is now supervising group IU Chat Bot', 'info', NULL, 1, 1, '2020-04-02 05:30:07'),
(14, 'Info', 'Ridah Fatima Mudassir is now supervising group smart robot', 'info', NULL, 1, 1, '2020-04-02 05:30:09'),
(15, 'Info', 'Ridah Fatima Mudassir is not supervising group proSys', 'info', NULL, 1, 1, '2020-04-02 06:27:33'),
(16, 'Info', 'Ridah Fatima Mudassir is now supervising group proSys', 'info', NULL, 1, 1, '2020-04-02 06:28:02'),
(17, 'Info', 'Ridah Fatima Mudassir is not supervising group proSys', 'info', NULL, 1, 1, '2020-04-02 17:29:02'),
(18, 'Info', 'Ridah Fatima Mudassir is now supervising group proSys', 'info', NULL, 1, 1, '2020-04-02 17:30:10'),
(19, 'Info', 'Ridah Fatima Mudassir is not supervising group IU Chat Bot', 'info', NULL, 1, 1, '2020-04-04 19:27:27'),
(22, 'idea selection', '<p>select the task</p>', 'task', 3, 1, 1, '2020-04-05 09:33:59'),
(24, 'Batch Upgraded', '                                                    Spring 2019 has been upgraded to Project Defense                                                ', 'info', NULL, 3, 2, '2020-04-05 19:21:58'),
(25, 'ERD ', '<p>nion9iojjio</p>', 'task', 4, 1, 1, '2020-04-05 20:34:14'),
(26, 'idea selection 2', '<p>90jjppjijiojoj</p>', 'task', 5, 1, 1, '2020-04-05 20:36:55'),
(27, 'Info', 'Noman Islam is now supervising group IU Chat Bot', 'info', NULL, 1, 1, '2020-04-09 19:54:15'),
(28, 'Info', 'Noman Islam is now supervising group yycvg', 'info', NULL, 1, 1, '2020-04-09 19:54:17'),
(29, 'Info', 'Ridah Fatima Mudassir is not supervising group smart robot', 'info', NULL, 1, 1, '2020-04-11 21:39:23'),
(30, 'Info', 'Ridah Fatima Mudassir is now supervising group smart robot', 'info', NULL, 1, 1, '2020-04-11 21:40:57'),
(31, 'Batch Upgraded', 'Spring 2020 has been upgraded to Project Defense', 'info', NULL, 1, 2, '2020-04-14 15:45:52'),
(32, 'Batch Upgraded', 'Spring 2020 has been upgraded to Project Defense', 'info', NULL, 1, 2, '2020-04-14 15:54:52'),
(33, 'Batch Upgraded', 'Spring 2020 has been upgraded to Project Defense', 'info', NULL, 1, 2, '2020-04-14 15:58:25'),
(34, 'Batch Upgraded', 'Fall 2020 has been upgraded to Project Defense', 'info', NULL, 2, 2, '2020-06-06 22:42:05'),
(35, 'Batch Upgraded', 'Fall 2020 has been upgraded to Project Defense', 'info', NULL, 2, 2, '2020-06-06 23:07:36'),
(36, 'Info', 'Ridah Fatima Mudassir is now supervising group chatterbot', 'info', NULL, 2, 2, '2020-06-06 23:10:06');

-- --------------------------------------------------------

--
-- Table structure for table `weekly_report`
--

CREATE TABLE `weekly_report` (
  `weekly_r_Id` int(255) NOT NULL,
  `supervisor_Id` int(255) NOT NULL,
  `group_Id` int(255) NOT NULL,
  `planned_work` text,
  `proposed_work` text,
  `week_No` int(255) DEFAULT NULL,
  `achievements` varchar(255) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `comments` text,
  `attendance` text,
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `weekly_report`
--

INSERT INTO `weekly_report` (`weekly_r_Id`, `supervisor_Id`, `group_Id`, `planned_work`, `proposed_work`, `week_No`, `achievements`, `score`, `comments`, `attendance`, `createdDtm`) VALUES
(2, 2, 20, ' faculty Panel ', 'batch setting', 2, ' yes', 3, 'good', 'all', '2020-06-07 00:15:37'),
(3, 2, 20, ' batch setting ', 'batch task', 3, ' no', 2, 'no comments', 'Muhammad sami ullah qureshi\r\nwalid ahmed\r\n', '2020-06-07 01:22:25');

-- --------------------------------------------------------

--
-- Table structure for table `work_load`
--

CREATE TABLE `work_load` (
  `loadId` int(255) NOT NULL,
  `facultyId` int(255) NOT NULL,
  `totalLoad` int(255) NOT NULL,
  `currentLoad` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='workload_Info';

--
-- Dumping data for table `work_load`
--

INSERT INTO `work_load` (`loadId`, `facultyId`, `totalLoad`, `currentLoad`) VALUES
(1, 1, 4, 0),
(2, 2, 4, 3),
(3, 3, 4, 2),
(4, 4, 4, 0),
(5, 5, 3, 0),
(6, 6, 4, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `batch`
--
ALTER TABLE `batch`
  ADD PRIMARY KEY (`batchId`);

--
-- Indexes for table `batch_settings`
--
ALTER TABLE `batch_settings`
  ADD PRIMARY KEY (`settingId`),
  ADD KEY `batchId` (`batchId`);

--
-- Indexes for table `batch_tasks`
--
ALTER TABLE `batch_tasks`
  ADD PRIMARY KEY (`taskId`),
  ADD KEY `FK_batch_tasks_batch` (`batchId`);

--
-- Indexes for table `batch_templates`
--
ALTER TABLE `batch_templates`
  ADD PRIMARY KEY (`templateId`),
  ADD KEY `FK_batch_templates_batch` (`batchId`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`facultyId`);

--
-- Indexes for table `faculty_student_group`
--
ALTER TABLE `faculty_student_group`
  ADD PRIMARY KEY (`facultyStudentId`),
  ADD KEY `fk_group_id` (`groupId`),
  ADD KEY `fk_faculty_id` (`facultyId`);

--
-- Indexes for table `faculty_student_request`
--
ALTER TABLE `faculty_student_request`
  ADD PRIMARY KEY (`requestId`),
  ADD KEY `FK_faculty_student_request_faculty` (`facultyId`),
  ADD KEY `FK_faculty_student_request_faculty_student_group` (`groupId`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_grades_student` (`studentId`),
  ADD KEY `FK_grades_student_group` (`groupId`);

--
-- Indexes for table `group_requests`
--
ALTER TABLE `group_requests`
  ADD PRIMARY KEY (`requestId`),
  ADD KEY `FK_group_requests_student` (`studentId`),
  ADD KEY `FK_group_requests_student_group` (`groupId`);

--
-- Indexes for table `group_uploads`
--
ALTER TABLE `group_uploads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_group_uploads_faculty_student_group` (`groupId`),
  ADD KEY `FK_group_uploads_batch_tasks` (`taskId`),
  ADD KEY `FK_group_uploads_student` (`uploadedBy`);

--
-- Indexes for table `meeting_requests`
--
ALTER TABLE `meeting_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_meeting_logs_faculty` (`supervisor_id`),
  ADD KEY `FK_meeting_logs_faculty_student_group` (`group_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notificationId`);

--
-- Indexes for table `project_repository`
--
ALTER TABLE `project_repository`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_project_repository_batch` (`batchId`);

--
-- Indexes for table `share_idea`
--
ALTER TABLE `share_idea`
  ADD PRIMARY KEY (`shareId`),
  ADD KEY `FK_share_idea_facultyId` (`facultyId`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`studentId`),
  ADD KEY `FK_student_batch` (`batchId`);

--
-- Indexes for table `student_group`
--
ALTER TABLE `student_group`
  ADD PRIMARY KEY (`groupId`),
  ADD KEY `FK_student_group_batch` (`batchId`),
  ADD KEY `FK_student_group_student` (`leaderId`);

--
-- Indexes for table `student_group_request`
--
ALTER TABLE `student_group_request`
  ADD PRIMARY KEY (`requestId`),
  ADD KEY `FK_student_group_request_student` (`studentId`),
  ADD KEY `FK_student_group_request_student_group` (`groupId`);

--
-- Indexes for table `timeline_faculty`
--
ALTER TABLE `timeline_faculty`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_timeline_faculty_batch` (`batchId`);

--
-- Indexes for table `timeline_student`
--
ALTER TABLE `timeline_student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_timeline_student_batch_tasks` (`taskId`),
  ADD KEY `FK_timeline_student_batch_tasks_2` (`batchId`);

--
-- Indexes for table `weekly_report`
--
ALTER TABLE `weekly_report`
  ADD PRIMARY KEY (`weekly_r_Id`),
  ADD KEY `FK_weekly_report_faculty` (`supervisor_Id`),
  ADD KEY `FK_weekly_report_faculty_student` (`group_Id`);

--
-- Indexes for table `work_load`
--
ALTER TABLE `work_load`
  ADD PRIMARY KEY (`loadId`),
  ADD KEY `FK_work_load_faculty` (`facultyId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `batch`
--
ALTER TABLE `batch`
  MODIFY `batchId` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `batch_settings`
--
ALTER TABLE `batch_settings`
  MODIFY `settingId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `batch_tasks`
--
ALTER TABLE `batch_tasks`
  MODIFY `taskId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `batch_templates`
--
ALTER TABLE `batch_templates`
  MODIFY `templateId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `facultyId` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `faculty_student_group`
--
ALTER TABLE `faculty_student_group`
  MODIFY `facultyStudentId` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `faculty_student_request`
--
ALTER TABLE `faculty_student_request`
  MODIFY `requestId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `group_requests`
--
ALTER TABLE `group_requests`
  MODIFY `requestId` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_uploads`
--
ALTER TABLE `group_uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `meeting_requests`
--
ALTER TABLE `meeting_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notificationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `project_repository`
--
ALTER TABLE `project_repository`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `share_idea`
--
ALTER TABLE `share_idea`
  MODIFY `shareId` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `studentId` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `student_group`
--
ALTER TABLE `student_group`
  MODIFY `groupId` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `student_group_request`
--
ALTER TABLE `student_group_request`
  MODIFY `requestId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `timeline_faculty`
--
ALTER TABLE `timeline_faculty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `timeline_student`
--
ALTER TABLE `timeline_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `weekly_report`
--
ALTER TABLE `weekly_report`
  MODIFY `weekly_r_Id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `work_load`
--
ALTER TABLE `work_load`
  MODIFY `loadId` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `batch_settings`
--
ALTER TABLE `batch_settings`
  ADD CONSTRAINT `batchId` FOREIGN KEY (`batchId`) REFERENCES `batch` (`batchId`);

--
-- Constraints for table `batch_tasks`
--
ALTER TABLE `batch_tasks`
  ADD CONSTRAINT `FK_batch_tasks_batch` FOREIGN KEY (`batchId`) REFERENCES `batch` (`batchId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `batch_templates`
--
ALTER TABLE `batch_templates`
  ADD CONSTRAINT `FK_batch_templates_batch` FOREIGN KEY (`batchId`) REFERENCES `batch` (`batchId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `faculty_student_group`
--
ALTER TABLE `faculty_student_group`
  ADD CONSTRAINT `fk_faculty_id` FOREIGN KEY (`facultyId`) REFERENCES `faculty` (`facultyId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_group_id` FOREIGN KEY (`groupId`) REFERENCES `student_group` (`groupId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `faculty_student_request`
--
ALTER TABLE `faculty_student_request`
  ADD CONSTRAINT `FK_faculty_student_request_faculty` FOREIGN KEY (`facultyId`) REFERENCES `faculty` (`facultyId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_faculty_student_request_faculty_student_group` FOREIGN KEY (`groupId`) REFERENCES `student_group` (`groupId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `FK_grades_student` FOREIGN KEY (`studentId`) REFERENCES `student` (`studentId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_grades_student_group` FOREIGN KEY (`groupId`) REFERENCES `student_group` (`groupId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `group_requests`
--
ALTER TABLE `group_requests`
  ADD CONSTRAINT `FK_group_requests_student` FOREIGN KEY (`studentId`) REFERENCES `student` (`studentId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_group_requests_student_group` FOREIGN KEY (`groupId`) REFERENCES `student_group` (`groupId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `group_uploads`
--
ALTER TABLE `group_uploads`
  ADD CONSTRAINT `FK_group_uploads_batch_tasks` FOREIGN KEY (`taskId`) REFERENCES `batch_tasks` (`taskId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_group_uploads_faculty_student_group` FOREIGN KEY (`groupId`) REFERENCES `faculty_student_group` (`groupId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_group_uploads_student` FOREIGN KEY (`uploadedBy`) REFERENCES `student` (`studentId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `meeting_requests`
--
ALTER TABLE `meeting_requests`
  ADD CONSTRAINT `FK_meeting_logs_faculty` FOREIGN KEY (`supervisor_id`) REFERENCES `faculty` (`facultyId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_meeting_logs_faculty_student_group` FOREIGN KEY (`group_id`) REFERENCES `faculty_student_group` (`groupId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `project_repository`
--
ALTER TABLE `project_repository`
  ADD CONSTRAINT `FK_project_repository_batch` FOREIGN KEY (`batchId`) REFERENCES `batch` (`batchId`);

--
-- Constraints for table `share_idea`
--
ALTER TABLE `share_idea`
  ADD CONSTRAINT `FK_share_idea_facultyId` FOREIGN KEY (`facultyId`) REFERENCES `faculty` (`facultyId`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `FK_student_batch` FOREIGN KEY (`batchId`) REFERENCES `batch` (`batchId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `student_group`
--
ALTER TABLE `student_group`
  ADD CONSTRAINT `FK_student_group_student` FOREIGN KEY (`leaderId`) REFERENCES `student` (`studentId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `student_group_request`
--
ALTER TABLE `student_group_request`
  ADD CONSTRAINT `FK_student_group_request_student` FOREIGN KEY (`studentId`) REFERENCES `student` (`studentId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_student_group_request_student_group` FOREIGN KEY (`groupId`) REFERENCES `student_group` (`groupId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `timeline_faculty`
--
ALTER TABLE `timeline_faculty`
  ADD CONSTRAINT `FK_timeline_faculty_batch` FOREIGN KEY (`batchId`) REFERENCES `batch` (`batchId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `timeline_student`
--
ALTER TABLE `timeline_student`
  ADD CONSTRAINT `FK_timeline_student_batch_tasks` FOREIGN KEY (`taskId`) REFERENCES `batch_tasks` (`taskId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_timeline_student_batch_tasks_2` FOREIGN KEY (`batchId`) REFERENCES `batch` (`batchId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `weekly_report`
--
ALTER TABLE `weekly_report`
  ADD CONSTRAINT `FK_weekly_report_faculty` FOREIGN KEY (`supervisor_Id`) REFERENCES `faculty` (`facultyId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_weekly_report_faculty_student` FOREIGN KEY (`group_Id`) REFERENCES `faculty_student_group` (`groupId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `work_load`
--
ALTER TABLE `work_load`
  ADD CONSTRAINT `FK_work_load_faculty` FOREIGN KEY (`facultyId`) REFERENCES `faculty` (`facultyId`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
