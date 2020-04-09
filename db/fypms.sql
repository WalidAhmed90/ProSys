-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2020 at 01:29 PM
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
(3, 'Spring 2019', '2020-04-05', 1, 1, '2020-04-05 10:40:36');

-- --------------------------------------------------------

--
-- Table structure for table `batch_settings`
--

CREATE TABLE `batch_settings` (
  `batchId` int(255) NOT NULL,
  `fyp1_grading` tinyint(1) NOT NULL,
  `fyp2_grading` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `batch_settings`
--

INSERT INTO `batch_settings` (`batchId`, `fyp1_grading`, `fyp2_grading`) VALUES
(2, 0, 0),
(1, 0, 0),
(3, 0, 0);

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
(5, 1, 'project file', 'project file.jpg', '2020-03-31 03:46:19');

-- --------------------------------------------------------

--
-- Table structure for table `external_examiner`
--

CREATE TABLE `external_examiner` (
  `examinerId` int(255) NOT NULL,
  `examinerName` varchar(100) NOT NULL,
  `examinerEmail` varchar(255) NOT NULL,
  `examinerPhone` varchar(50) NOT NULL,
  `examinerPassword` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='examinerGroupInfo';

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
(1, '00-11-123', 'Coordinator', '03456787980', 'coordinator@gmail.com', 'Coordinator', NULL, '456', 1, '2020-02-02 18:29:56', 1),
(2, '00-11-124', 'Ridah Fatima Mudassir', '03167896542', 'ridah@gmail.com', 'Supervisor', NULL, '456', 0, '2020-02-02 18:31:47', 1),
(3, '00-11-125', 'Noman Islam', '', 'nomanislam@gmail.com', 'Supervisor', NULL, 'iuk123', 0, '2020-02-28 02:00:55', 1),
(4, '00-11-126', 'S.jamal haider zaidi', '', 'jamalhaider@gmail.com', 'Supervisor', NULL, 'iuk123', 0, '2020-02-28 02:04:04', 1),
(5, '00-11-127', 'Walid ahmed', '', '', 'Supervisor', NULL, 'iuk123', 0, '2020-02-28 02:27:03', 1),
(6, '00-11-128', 'alizain Aziz', '', '', 'Coordinator', NULL, 'iuk123', 1, '2020-02-28 02:27:52', 1);

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
(10, 21, 2, 0),
(12, 20, 2, 0);

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
  `comments` text,
  `grade` varchar(50) DEFAULT NULL,
  `gradedBy` int(11) DEFAULT NULL COMMENT 'User id of user',
  `gradeDtm` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

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

--
-- Dumping data for table `meeting_requests`
--

INSERT INTO `meeting_requests` (`id`, `supervisor_id`, `group_id`, `meeting_title`, `meeting_dtm`, `comments`, `meeting_status`, `created_dtm`) VALUES
(1, 2, 20, 'meet me at library', '2020-04-05 15:04:00', NULL, 'Pending', '2020-04-05 08:13:13');

-- --------------------------------------------------------

--
-- Table structure for table `project_repository`
--

CREATE TABLE `project_repository` (
  `id` int(11) NOT NULL,
  `batchId` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(2, 'fyp management System', 'final year project management system', 'Ridah Fatima Mudassir', 2, 0, '2020-03-31 01:32:34'),
(3, 'Iu chat bot ', 'iqra university onilne chat bot.', 'Ridah Fatima Mudassir', 2, 0, '2020-03-31 02:06:12'),
(4, 'android app', 'for the recent situation .', 'Ridah Fatima Mudassir', 2, 0, '2020-03-31 02:09:47'),
(8, 'IU Society Elections ', '<p><a href=\"http://www.google.com\" target=\"_blank\">www.google.com</a><a href=\"http://www.google.com\" target=\"_blank\"></a></p><p>search from google .</p>', 'Coordinator', 1, 0, '2020-03-31 02:48:10'),
(9, 'android app react', '<p>vuuvuvuivuyvuyvuyvuy</p>', 'Ridah Fatima Mudassir', 2, 0, '2020-04-04 19:25:11');

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
  `createdDtm` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='FYP Student Records';

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`studentId`, `studentName`, `studentRid`, `studentEmail`, `studentPhoneNo`, `studentGender`, `studentPassword`, `studentImage`, `groupId`, `isLeader`, `batchId`, `isActive`, `createdDtm`) VALUES
(10, 'Muhammad sami ullah qureshi', '12520', '', '', '', 'iuk123', NULL, 20, NULL, 1, 1, '2020-02-28 02:39:19'),
(12, 'Khalid Ahmed', '12423', 'khalidahmed@gmail.com', '03452286280', 'male', 'iuk123', NULL, 16, 1, 1, 1, '2020-02-28 03:12:14'),
(13, 'sohaib bilal zafar', '12421', 'sohaibbilal@gmail.com', '0312456784', '', '123', NULL, 16, NULL, 1, 1, '2020-02-28 03:57:43'),
(14, 'alizain', '12425', '', '', '', 'iuk123', NULL, 20, NULL, 1, 1, '2020-02-28 05:08:35'),
(15, 'waleed khan', '12426', '', '', '', 'iuk123', NULL, NULL, NULL, 1, 1, '2020-03-01 05:33:41'),
(16, 'khuzaima nadeem', '12427', '', '', '', 'iuk123', NULL, NULL, NULL, 1, 1, '2020-03-01 05:33:53'),
(17, 'mahad ahmed', '12428', '', '', '', 'iuk123', NULL, NULL, NULL, 1, 1, '2020-03-01 05:34:04'),
(18, 'azeem khan', '12429', '', '', '', 'iuk123', NULL, NULL, NULL, 1, 1, '2020-03-01 05:34:26'),
(19, 'mohi khan', '12430', 'mohikhan345@gmail.com', '09764336738', 'male', '123', NULL, 21, 1, 1, 1, '2020-03-01 05:34:38'),
(20, 'walid ahmed', '12422', 'walidkhan345@gmail.com', '03122990486', 'male', '123', '5e8892f109cfb8.43621097.jpg', 20, 1, 1, 1, '2020-03-01 05:38:46'),
(21, 'Mubashir Hussain', '12431', '', '', '', 'iuk123', NULL, 19, 1, 1, 1, '2020-03-27 20:52:05'),
(22, 'haroon rasheed', '12432', '', '', '', 'iuk123', NULL, 22, 1, 1, 1, '2020-03-27 20:52:28'),
(23, 'Ather Anwar', '12433', '', '', '', 'iuk123', NULL, NULL, NULL, 1, 1, '2020-03-27 20:52:49'),
(24, 'talha khan', '12434', 'talhakhan@gmail.com', '1134534546464', '', 'iuk123', NULL, NULL, NULL, 1, 1, '2020-03-27 20:53:02');

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
(22, 'yycvg', '3D/4D Printing', 'drdyhh', 1, 1, 3, 1, 22, '2020-03-27 21:19:46');

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
(18, 'Batch Upgraded', 'Spring 2019 has been upgraded to Project Defense', 'info', 3, 2, '2020-04-05 10:41:23');

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
(26, 'idea selection 2', '<p>90jjppjijiojoj</p>', 'task', 5, 1, 1, '2020-04-05 20:36:55');

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
(1, 2, 20, ' <p>vuhvuvuyh</p> ', '<p>iooiojj</p>', 2, ' <p>no</p>', 3, '<p>kmkmko</p>', '<p>walid,</p><p>sami</p>', '2020-04-04 19:22:30'),
(2, 2, 20, ' <p>ojopijiopj</p> ', '<p>pjpjop</p>', 5, ' <p>kl;mpjkp</p>', 3, '<p>pjpjop</p>', '<p>0jpjpjop</p>', '2020-04-04 19:23:53'),
(3, 2, 20, ' <p>pjpjop</p> ', '<p>gnfgnfgnfgn</p>', 6, ' <p>gnffgnfgnfg</p>', 3, '<p>fgnfgnfgnfgnf</p>', '<p>sdhdhsdfsbdb</p>', '2020-04-05 08:01:03'),
(4, 2, 21, ' <p>user panel</p> ', '<p>admin panel</p>', 1, ' <p>no</p>', 3, '<p>yes</p>', '<p>anyone</p>', '2020-04-05 08:10:53'),
(5, 2, 21, ' <p>admin panel</p> ', '<p>datbase</p>', 2, ' <p>no&nbsp;&nbsp;&nbsp;&nbsp;</p>', 3, '<p>yes</p>', '<p>anyone</p>', '2020-04-05 08:11:38');

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
(2, 2, 4, 2),
(3, 3, 4, 0),
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
-- Indexes for table `external_examiner`
--
ALTER TABLE `external_examiner`
  ADD PRIMARY KEY (`examinerId`);

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
-- AUTO_INCREMENT for table `batch_tasks`
--
ALTER TABLE `batch_tasks`
  MODIFY `taskId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `batch_templates`
--
ALTER TABLE `batch_templates`
  MODIFY `templateId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `external_examiner`
--
ALTER TABLE `external_examiner`
  MODIFY `examinerId` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `facultyId` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `faculty_student_group`
--
ALTER TABLE `faculty_student_group`
  MODIFY `facultyStudentId` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `faculty_student_request`
--
ALTER TABLE `faculty_student_request`
  MODIFY `requestId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `project_repository`
--
ALTER TABLE `project_repository`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `share_idea`
--
ALTER TABLE `share_idea`
  MODIFY `shareId` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `studentId` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `student_group`
--
ALTER TABLE `student_group`
  MODIFY `groupId` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `student_group_request`
--
ALTER TABLE `student_group_request`
  MODIFY `requestId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `timeline_faculty`
--
ALTER TABLE `timeline_faculty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `timeline_student`
--
ALTER TABLE `timeline_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `weekly_report`
--
ALTER TABLE `weekly_report`
  MODIFY `weekly_r_Id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
