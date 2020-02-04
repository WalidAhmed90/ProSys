-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2020 at 02:32 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.26

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
  `isActive` tinyint(4) DEFAULT 0 COMMENT '0= inactive , 1= active',
  `fyp_1/2` tinyint(1) DEFAULT 1 COMMENT '0 or 1',
  `createdDtm` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='batchDeadlinesInfo';

-- --------------------------------------------------------

--
-- Table structure for table `batch_settings`
--

CREATE TABLE `batch_settings` (
  `batchId` int(255) NOT NULL,
  `fyp1_grading` tinyint(1) NOT NULL,
  `fyp2_grading` tinyint(1) NOT NULL,
  `internal_evaluation` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `batch_tasks`
--

CREATE TABLE `batch_tasks` (
  `taskId` int(11) NOT NULL,
  `batchId` int(11) DEFAULT NULL,
  `fyp_1/2` tinyint(1) DEFAULT 1,
  `taskName` text DEFAULT NULL,
  `taskDetail` text DEFAULT NULL,
  `taskWeek` int(11) DEFAULT NULL,
  `taskDeadline` datetime DEFAULT NULL,
  `templateId` int(11) DEFAULT NULL,
  `hasDeliverable` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1=has deliverable',
  `createdDtm` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `batch_templates`
--

CREATE TABLE `batch_templates` (
  `templateId` int(11) NOT NULL,
  `batchId` int(11) DEFAULT NULL,
  `templateName` varchar(100) DEFAULT NULL,
  `templateLocation` varchar(150) DEFAULT NULL,
  `uploadedDtm` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `isActive` tinyint(1) NOT NULL DEFAULT 1
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
  `createdDtm` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Faculty Details';

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`facultyId`, `facultyRid`, `facultyName`, `facultyPhoneNo`, `facultyEmail`, `designation`, `facultyImage`, `facultyPassword`, `isCoordinator`, `createdDtm`) VALUES
(1, '00-11-123', 'Dr. Aarij', '03456787980', 'aarij@gmail.com', 'Coordinator', NULL, '456', 1, '2020-02-02 18:29:56'),
(2, '00-11-124', 'Ridah Fatima Mudassir', '03167896542', 'ridah@gmail.com', 'Supervisor', NULL, '456', 0, '2020-02-02 18:31:47');

-- --------------------------------------------------------

--
-- Table structure for table `faculty_student_group`
--

CREATE TABLE `faculty_student_group` (
  `facultyStudentId` int(255) NOT NULL,
  `groupId` int(255) NOT NULL,
  `facultyId` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='facultyGroupInfo';

-- --------------------------------------------------------

--
-- Table structure for table `faculty_student_request`
--

CREATE TABLE `faculty_student_request` (
  `requestId` int(11) NOT NULL,
  `facultyId` int(11) DEFAULT NULL,
  `groupId` int(11) DEFAULT NULL,
  `requestDtm` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `studentId` int(11) DEFAULT NULL,
  `groupId` int(11) DEFAULT NULL,
  `fyp_1/2` int(11) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `grade` varchar(50) DEFAULT NULL,
  `gradedBy` int(11) DEFAULT NULL COMMENT 'User id of user',
  `gradeDtm` datetime DEFAULT current_timestamp()
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
  `uploadedDtm` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `meeting_logs`
--

CREATE TABLE `meeting_logs` (
  `id` int(11) NOT NULL,
  `supervisor_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `meeting_title` varchar(50) NOT NULL,
  `meeting_dtm` datetime NOT NULL,
  `comments` text DEFAULT NULL,
  `meeting_status` enum('Pending','Done','Cancelled','Postponed') NOT NULL DEFAULT 'Pending',
  `created_dtm` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Maintain all meeting logs of supervisors with students';

-- --------------------------------------------------------

--
-- Table structure for table `project_repository`
--

CREATE TABLE `project_repository` (
  `id` int(11) NOT NULL,
  `batchId` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `createdDtm` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='FYP Student Records';

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`studentId`, `studentName`, `studentRid`, `studentEmail`, `studentPhoneNo`, `studentGender`, `studentPassword`, `studentImage`, `groupId`, `isLeader`, `batchId`, `isActive`, `createdDtm`) VALUES
(1, 'Walid', '12422', 'walidahmed@gmail.com', '03122990486', 'Male', '123', NULL, NULL, NULL, NULL, 1, '2020-02-02 17:27:23');

-- --------------------------------------------------------

--
-- Table structure for table `student_group`
--

CREATE TABLE `student_group` (
  `groupId` int(255) NOT NULL,
  `projectName` varchar(255) DEFAULT NULL,
  `batchId` int(11) DEFAULT NULL,
  `fyp_1/2` int(1) NOT NULL DEFAULT 1 COMMENT 'Here to check before deleting group',
  `groupLimit` int(1) NOT NULL DEFAULT 3,
  `inGroup` int(255) NOT NULL DEFAULT 1,
  `leaderId` int(255) NOT NULL,
  `createdDtm` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='groupInfo';

-- --------------------------------------------------------

--
-- Table structure for table `student_group_request`
--

CREATE TABLE `student_group_request` (
  `requestId` int(11) NOT NULL,
  `studentId` int(11) NOT NULL COMMENT 'Request sent by',
  `groupId` int(11) NOT NULL COMMENT 'Request sent to group',
  `requestDtm` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Requests sent to join a group a stored here temporarilty';

-- --------------------------------------------------------

--
-- Table structure for table `timeline_faculty`
--

CREATE TABLE `timeline_faculty` (
  `id` int(11) NOT NULL,
  `title` text DEFAULT NULL,
  `details` text DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `batchId` int(11) DEFAULT NULL,
  `fyp_1/2` int(11) DEFAULT NULL,
  `createdDtm` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='timeline for faculty';

-- --------------------------------------------------------

--
-- Table structure for table `timeline_student`
--

CREATE TABLE `timeline_student` (
  `id` int(11) NOT NULL,
  `title` text DEFAULT NULL,
  `details` text DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `taskId` int(11) DEFAULT NULL,
  `batchId` int(11) DEFAULT NULL,
  `fyp_1/2` int(11) DEFAULT NULL,
  `createdDtm` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Timeline for students';

-- --------------------------------------------------------

--
-- Table structure for table `work_load`
--

CREATE TABLE `work_load` (
  `loadId` int(255) NOT NULL,
  `facultyId` int(255) NOT NULL,
  `totalLoad` int(255) NOT NULL,
  `currentLoad` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='workload_Info';

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
-- Indexes for table `meeting_logs`
--
ALTER TABLE `meeting_logs`
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
  ADD KEY `FK_student_group_student` (`leaderId`),
  ADD KEY `fyp_1/2` (`fyp_1/2`);

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
  MODIFY `batchId` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `batch_tasks`
--
ALTER TABLE `batch_tasks`
  MODIFY `taskId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `batch_templates`
--
ALTER TABLE `batch_templates`
  MODIFY `templateId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `external_examiner`
--
ALTER TABLE `external_examiner`
  MODIFY `examinerId` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `facultyId` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `faculty_student_group`
--
ALTER TABLE `faculty_student_group`
  MODIFY `facultyStudentId` int(255) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meeting_logs`
--
ALTER TABLE `meeting_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_repository`
--
ALTER TABLE `project_repository`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `studentId` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student_group`
--
ALTER TABLE `student_group`
  MODIFY `groupId` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_group_request`
--
ALTER TABLE `student_group_request`
  MODIFY `requestId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `timeline_faculty`
--
ALTER TABLE `timeline_faculty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `timeline_student`
--
ALTER TABLE `timeline_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `work_load`
--
ALTER TABLE `work_load`
  MODIFY `loadId` int(255) NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `fk_faculty_id` FOREIGN KEY (`facultyId`) REFERENCES `faculty` (`facultyId`),
  ADD CONSTRAINT `fk_group_id` FOREIGN KEY (`groupId`) REFERENCES `student_group` (`groupId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `faculty_student_request`
--
ALTER TABLE `faculty_student_request`
  ADD CONSTRAINT `FK_faculty_student_request_faculty` FOREIGN KEY (`facultyId`) REFERENCES `faculty` (`facultyId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_faculty_student_request_faculty_student_group` FOREIGN KEY (`groupId`) REFERENCES `faculty_student_group` (`groupId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
-- Constraints for table `meeting_logs`
--
ALTER TABLE `meeting_logs`
  ADD CONSTRAINT `FK_meeting_logs_faculty` FOREIGN KEY (`supervisor_id`) REFERENCES `faculty` (`facultyId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_meeting_logs_faculty_student_group` FOREIGN KEY (`group_id`) REFERENCES `faculty_student_group` (`groupId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `project_repository`
--
ALTER TABLE `project_repository`
  ADD CONSTRAINT `FK_project_repository_batch` FOREIGN KEY (`batchId`) REFERENCES `batch` (`batchId`);

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
-- Constraints for table `work_load`
--
ALTER TABLE `work_load`
  ADD CONSTRAINT `FK_work_load_faculty` FOREIGN KEY (`facultyId`) REFERENCES `faculty` (`facultyId`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
