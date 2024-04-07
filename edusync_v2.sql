-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2024 at 01:16 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `edusync_v2`
--

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE `answer` (
  `answer_id` int(11) NOT NULL,
  `is_correct` tinyint(4) DEFAULT 0,
  `question_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `answer`
--

INSERT INTO `answer` (`answer_id`, `is_correct`, `question_id`) VALUES
(1, 25, 1),
(2, 13, 2),
(3, 22, 3);

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `is_present` tinyint(4) DEFAULT 0,
  `class_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `session_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `student_id`, `date`, `is_present`, `class_id`, `teacher_id`, `session_id`) VALUES
(1, 2, '2023-10-19', 0, 1, 1, 2),
(2, 1, '2023-11-02', 0, 1, 4, 4),
(3, 4, '2024-01-04', 2, 4, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `class_id` int(11) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `class_year` year(4) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `class_name`, `class_year`, `remarks`, `teacher_id`, `created_at`, `updated_at`) VALUES
(1, 'Dev101', '2022', 'Bonne classe', 3, '2022-09-07 12:25:15', '2024-01-15 12:25:15'),
(2, 'DEV202', '2023', 'Moyenne class', 2, '2023-09-15 12:27:01', '2023-12-22 12:27:01'),
(3, 'AA', '2019', 'Encore', 4, '2019-10-01 12:28:50', '2024-01-18 12:28:50'),
(4, 'Get', '2024', 'Passage', 4, '2024-01-01 12:30:23', '2024-03-28 13:30:23');

-- --------------------------------------------------------

--
-- Table structure for table `class_course`
--

CREATE TABLE `class_course` (
  `class_course_id` int(11) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class_course`
--

INSERT INTO `class_course` (`class_course_id`, `class_id`, `course_id`) VALUES
(1, 1, 4),
(2, 2, 1),
(3, 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `class_student`
--

CREATE TABLE `class_student` (
  `class_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class_student`
--

INSERT INTO `class_student` (`class_id`, `student_id`) VALUES
(3, 5),
(1, 2),
(2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(45) DEFAULT NULL,
  `course_code` varchar(45) DEFAULT NULL,
  `created_at` varchar(45) DEFAULT NULL,
  `updated_at` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `course_name`, `course_code`, `created_at`, `updated_at`) VALUES
(1, 'Java', '125', '2023-09-30 14:12:10', NULL),
(2, 'Exel', '209', NULL, NULL),
(3, 'Entreprenariat', '101', '2023-10-10 13:10:07', NULL),
(4, 'Anglais', '103', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fee`
--

CREATE TABLE `fee` (
  `fee_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `fee_description` varchar(255) DEFAULT NULL,
  `total_fee` float DEFAULT NULL,
  `fee_date` date DEFAULT NULL,
  `is_paid` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fee`
--

INSERT INTO `fee` (`fee_id`, `student_id`, `fee_description`, `total_fee`, `fee_date`, `is_paid`) VALUES
(1, 1, NULL, 3000, '2024-01-02', 1),
(2, 2, NULL, 3500, '2024-03-04', 1),
(3, 3, NULL, 2000, '2024-02-06', 3);

-- --------------------------------------------------------

--
-- Table structure for table `holiday`
--

CREATE TABLE `holiday` (
  `holiday_id` int(11) NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `holiday`
--

INSERT INTO `holiday` (`holiday_id`, `date`) VALUES
(1, '2023-12-03'),
(2, '2024-01-21'),
(3, '2024-03-10'),
(4, '2024-03-28');

-- --------------------------------------------------------

--
-- Table structure for table `homework`
--

CREATE TABLE `homework` (
  `homework_id` int(11) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `homework` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `homework`
--

INSERT INTO `homework` (`homework_id`, `class_id`, `teacher_id`, `course_id`, `homework`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 4, 'Exercice', '2024-04-06 12:17:21', NULL),
(2, 2, 3, 1, 'Tp en poo', '2024-04-06 12:17:21', NULL),
(3, 4, 4, 3, 'Trouver un entrepreneur', '2024-04-06 12:17:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `multimedia`
--

CREATE TABLE `multimedia` (
  `multimedia_id` int(11) NOT NULL,
  `file_type` varchar(45) DEFAULT NULL,
  `size` varchar(45) DEFAULT NULL,
  `title` varchar(45) DEFAULT NULL,
  `descrption` varchar(45) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `resource` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `multimedia`
--

INSERT INTO `multimedia` (`multimedia_id`, `file_type`, `size`, `title`, `descrption`, `class_id`, `resource`) VALUES
(1, 'audiovisuels', '783', 'Voir', 'fichiers audiovisuels', 1, 'Anc1123'),
(2, 'Documents', '103', 'Plus', 'fichiers documents', 3, 'OPP1908'),
(3, 'Audiovisuels', '202', 'Lire', 'Fichiers audiovisuels', 2, 'OFPPT89'),
(4, 'Textes', '190', 'Question', 'Fichiers textes', 3, 'AAA098');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `question_id` int(11) NOT NULL,
  `test_online_id` int(11) DEFAULT NULL,
  `question` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`question_id`, `test_online_id`, `question`) VALUES
(1, 1, ' défiiez  java?'),
(2, 2, 'C\'est quoi l\'IKGA ?'),
(3, 3, 'Donner un titre au texte ?');

-- --------------------------------------------------------

--
-- Table structure for table `report_card`
--

CREATE TABLE `report_card` (
  `report_card_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `teacher_remark` text DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `report_card`
--

INSERT INTO `report_card` (`report_card_id`, `student_id`, `teacher_remark`, `teacher_id`) VALUES
(1, 2, 'C\'est un bon élève qui étudie bien', 1),
(2, 5, 'une eleve negligee ,déclenché l\'emeute', 3),
(3, 3, 'Étudiant moyen, essayant d\'avancer', 3);

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `session_id` int(11) NOT NULL,
  `session_time` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`session_id`, `session_time`) VALUES
(1, '3'),
(2, '5'),
(3, '2'),
(4, '4');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `fathers_name` varchar(255) NOT NULL,
  `mothers_name` varchar(255) NOT NULL,
  `join_date` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `otp` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `first_name`, `last_name`, `phone_number`, `fathers_name`, `mothers_name`, `join_date`, `email`, `password`, `otp`, `created_at`, `updated_at`) VALUES
(1, 'Fatima Ezzahra', 'Baba', '0775729368', 'Rachid', 'Karima', '2023-10-03', 'babafatimaezzahra434@gmail.com', 'baba@babafz', 'OTkzNjY=', '2023-10-04 11:58:48', '2023-10-04 11:58:48'),
(2, 'Saad', 'Aboulhoda', '0671670183', 'Mohammed', 'Fatima', '2023-09-21', 'rakansubs@gmail.com', '$2y$10$KpKQXrszRJeqmDL4e6G9Mu5dZQEqXzR2BvlRzc7uBQxJhCb7dit9m', 'NzgyNjU=', '2023-09-21 12:03:22', '2024-02-05 11:03:22'),
(3, 'Hamza', 'El Hourch', '062901625', 'Ahmed', 'Fatima', '2023-11-01', 'elhorchhamza@gmail.com', 'hamza@hamza', 'OTkzNjY=', '2023-11-01 12:07:48', '2024-03-29 15:07:48'),
(4, 'Halima', 'Bezaz', '0613060106', 'Hassan', 'Amina', '2023-10-10', 'bzazhalima@gmail.com', 'halima@hailma', 'OTkzNjY=', '2023-10-10 12:10:07', '2023-12-02 09:10:07'),
(5, 'Kawter', 'El Azrak', '0603848212', 'Amin', 'Naziha', '2023-09-30', 'elazrakkawter@gmail.com', 'kawter@kawter', 'OTkzNjY=', '2023-09-30 13:12:10', '2024-03-03 12:12:10');

-- --------------------------------------------------------

--
-- Table structure for table `student_homework`
--

CREATE TABLE `student_homework` (
  `student_homework` int(11) NOT NULL,
  `homework_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_homework`
--

INSERT INTO `student_homework` (`student_homework`, `homework_id`, `student_id`) VALUES
(2, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `teacher_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `gender` varchar(6) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `experience` varchar(255) DEFAULT NULL,
  `cne` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip_code` int(11) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `email_confirm_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`teacher_id`, `first_name`, `last_name`, `email`, `password`, `phone_number`, `gender`, `date_of_birth`, `joining_date`, `qualification`, `experience`, `cne`, `adresse`, `city`, `state`, `zip_code`, `country`, `email_confirm_token`, `created_at`, `updated_at`) VALUES
(1, 'aaas', 'bbb', 'asliamin@gmail.com', 'amin@amin', '060000010', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2016-02-09 12:16:04', '2024-04-03 10:27:02'),
(2, 'Ismail', 'Chaoui', 'chaouiismail@gmail.com', 'ismail@ismail', '0600000000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-01-01 10:17:21', '2022-03-02 12:17:21'),
(3, 'Salwa', 'ElRhali', 'elrhalisalwa@gmail.com', 'salwa@salwa', '0650405040', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2015-03-16 13:19:37', '2022-02-15 12:19:37'),
(4, 'aaaa', 'bbb', 'sabirirajae@gmail.com', 'rajae@rajae', '060000010', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-03-29 13:23:21', '2024-04-03 11:05:30'),
(11, 'AHMED', 'EL GHAZALI', 'ahmed.elghazali@gmail.com', '$2y$10$b.A52dArvkPN8gCHEzKLP.5g..Lzu8f/kLqr/tfAtHwHtKybSBxuO', '0620868963', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-03 11:44:47', '2024-04-03 11:44:47'),
(12, 'dskdjsk', 'dqjkdh', 'ahmed.elghazai@gmail.com', '$2y$10$Jdet.0gKJRCsGYF5XKgs4OUWoZl4wMJUOUxMYKHet84IOAXHZHhNu', '0798789', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-04-03 11:52:31', '2024-04-03 11:52:31'),
(13, 'aaa', 'bbb', 'aaa.bbbb@gmail.com', '$2y$10$9dH4ViYKzXko9VyJpFSWBuMnYRbdZKGANWRIGYuRyXWBDQ.TjxNDi', '060000010', 'Male', '0000-00-00', '0000-00-00', 'QA', 'EX', 'GA2366', 'A11', 'New Work', 'New Work', 123, 'Morocco', NULL, '2024-04-03 13:16:35', '2024-04-03 13:16:35');

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `test_id` int(11) NOT NULL,
  `test_code` varchar(45) DEFAULT NULL,
  `mark` float DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`test_id`, `test_code`, `mark`, `student_id`, `course_id`, `created_at`, `updated_at`) VALUES
(1, '123GE', 19, 2, 1, '2024-04-06 11:56:23', NULL),
(2, '123GE', 19.5, 2, 1, '2024-04-06 11:56:23', NULL),
(3, '90NM', 19, 1, 2, '2024-04-06 11:56:23', NULL),
(4, '189SK', 18.5, 2, 4, '2024-04-06 11:56:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `test_online`
--

CREATE TABLE `test_online` (
  `test_online_id` int(11) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `duration` time DEFAULT NULL,
  `score` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test_online`
--

INSERT INTO `test_online` (`test_online_id`, `class_id`, `duration`, `score`) VALUES
(1, 2, '08:30:29', 30),
(2, 3, '13:30:22', 5),
(3, 4, '13:30:22', 25);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`answer_id`),
  ADD KEY `f_asnwer_question` (`question_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `f_attendance_student` (`student_id`),
  ADD KEY `f_attendance_class` (`class_id`),
  ADD KEY `f_attendance_session` (`session_id`),
  ADD KEY `f_attendance_teacher` (`teacher_id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_id`),
  ADD KEY `class_ibfk_1` (`teacher_id`);

--
-- Indexes for table `class_course`
--
ALTER TABLE `class_course`
  ADD PRIMARY KEY (`class_course_id`),
  ADD KEY `f1` (`class_id`),
  ADD KEY `f2` (`course_id`);

--
-- Indexes for table `class_student`
--
ALTER TABLE `class_student`
  ADD KEY `class_student_ibfk_1` (`class_id`),
  ADD KEY `class_student_ibfk_2` (`student_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `fee`
--
ALTER TABLE `fee`
  ADD PRIMARY KEY (`fee_id`),
  ADD KEY `f_fee_student` (`student_id`);

--
-- Indexes for table `holiday`
--
ALTER TABLE `holiday`
  ADD PRIMARY KEY (`holiday_id`);

--
-- Indexes for table `homework`
--
ALTER TABLE `homework`
  ADD PRIMARY KEY (`homework_id`),
  ADD KEY `f_homework_class` (`class_id`),
  ADD KEY `f_homework_teacher` (`teacher_id`),
  ADD KEY `f_homework_course` (`course_id`);

--
-- Indexes for table `multimedia`
--
ALTER TABLE `multimedia`
  ADD PRIMARY KEY (`multimedia_id`),
  ADD KEY `multimedia_class` (`class_id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `f_question_test_online` (`test_online_id`);

--
-- Indexes for table `report_card`
--
ALTER TABLE `report_card`
  ADD PRIMARY KEY (`report_card_id`),
  ADD KEY `f_report_card_student` (`student_id`),
  ADD KEY `f_report_card_teacher` (`teacher_id`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `student_homework`
--
ALTER TABLE `student_homework`
  ADD PRIMARY KEY (`student_homework`),
  ADD KEY `student_homework_student` (`student_id`),
  ADD KEY `student_homework_homework` (`homework_id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`teacher_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`test_id`),
  ADD KEY `f_test_student` (`student_id`),
  ADD KEY `f_test_course` (`course_id`);

--
-- Indexes for table `test_online`
--
ALTER TABLE `test_online`
  ADD PRIMARY KEY (`test_online_id`),
  ADD KEY `f_test_online_class` (`class_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answer`
--
ALTER TABLE `answer`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `fee`
--
ALTER TABLE `fee`
  MODIFY `fee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `holiday`
--
ALTER TABLE `holiday`
  MODIFY `holiday_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `homework`
--
ALTER TABLE `homework`
  MODIFY `homework_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `multimedia`
--
ALTER TABLE `multimedia`
  MODIFY `multimedia_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `report_card`
--
ALTER TABLE `report_card`
  MODIFY `report_card_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `student_homework`
--
ALTER TABLE `student_homework`
  MODIFY `student_homework` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `test_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `test_online`
--
ALTER TABLE `test_online`
  MODIFY `test_online_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `f_asnwer_question` FOREIGN KEY (`question_id`) REFERENCES `question` (`question_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `f_attendance_class` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `f_attendance_session` FOREIGN KEY (`session_id`) REFERENCES `session` (`session_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `f_attendance_student` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `f_attendance_teacher` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `class_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `class_course`
--
ALTER TABLE `class_course`
  ADD CONSTRAINT `f1` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `f2` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `class_student`
--
ALTER TABLE `class_student`
  ADD CONSTRAINT `class_student_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`),
  ADD CONSTRAINT `class_student_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `fee`
--
ALTER TABLE `fee`
  ADD CONSTRAINT `f_fee_student` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `homework`
--
ALTER TABLE `homework`
  ADD CONSTRAINT `f_homework_class` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `f_homework_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `f_homework_teacher` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `multimedia`
--
ALTER TABLE `multimedia`
  ADD CONSTRAINT `multimedia_class` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `f_question_test_online` FOREIGN KEY (`test_online_id`) REFERENCES `test_online` (`test_online_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `report_card`
--
ALTER TABLE `report_card`
  ADD CONSTRAINT `f_report_card_student` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `f_report_card_teacher` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `student_homework`
--
ALTER TABLE `student_homework`
  ADD CONSTRAINT `student_homework_homework` FOREIGN KEY (`homework_id`) REFERENCES `homework` (`homework_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `student_homework_student` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `test`
--
ALTER TABLE `test`
  ADD CONSTRAINT `f_test_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `f_test_student` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `test_online`
--
ALTER TABLE `test_online`
  ADD CONSTRAINT `f_test_online_class` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
