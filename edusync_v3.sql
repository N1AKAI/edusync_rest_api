-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2024 at 11:18 AM
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
-- Database: `edusync_v3`
--

-- --------------------------------------------------------

--
-- Table structure for table `absent_students`
--

CREATE TABLE `absent_students` (
  `absent_students_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absent_students`
--

INSERT INTO `absent_students` (`absent_students_id`, `student_id`, `teacher_id`, `class_id`, `date`, `start_time`, `end_time`) VALUES
(1, 1, 13, 2, '2024-04-16', '08:30:00', '10:30:00'),
(2, 4, 13, 2, '2024-04-16', '08:30:00', '10:30:00'),
(3, 3, 13, 1, '2024-04-16', '14:30:00', '16:30:00'),
(4, 3, 13, 1, '2024-04-16', '08:30:00', '12:30:00'),
(5, 3, 13, 1, '2024-04-16', '10:30:00', '12:30:00'),
(6, 1, 13, 2, '2024-04-16', '10:30:00', '12:30:00'),
(7, 4, 13, 2, '2024-04-16', '10:30:00', '12:30:00'),
(8, 5, 13, 2, '2024-04-16', '10:30:00', '12:30:00'),
(9, 12, 13, 2, '2024-04-17', '10:30:00', '12:30:00'),
(10, 7, 13, 2, '2024-04-17', '10:30:00', '12:30:00'),
(11, 5, 13, 2, '2024-04-17', '10:30:00', '12:30:00'),
(12, 25, 13, 2, '2024-04-17', '10:30:00', '12:30:00'),
(13, 9, 13, 3, '2024-04-17', '08:30:00', '09:30:00'),
(14, 8, 13, 3, '2024-04-17', '08:30:00', '09:30:00'),
(15, 18, 13, 3, '2024-04-17', '08:30:00', '09:30:00'),
(16, 3, 13, 1, '2024-04-17', '08:30:00', '12:30:00'),
(17, 19, 13, 1, '2024-04-17', '08:30:00', '12:30:00'),
(18, 11, 13, 1, '2024-04-17', '08:30:00', '12:30:00'),
(19, 3, 13, 1, '2024-04-17', '08:30:00', '12:30:00'),
(20, 22, 13, 1, '2024-04-17', '08:30:00', '12:30:00'),
(21, 11, 13, 1, '2024-04-17', '14:00:00', '16:00:00'),
(22, 3, 13, 1, '2024-04-17', '14:00:00', '16:00:00'),
(23, 14, 13, 1, '2024-04-17', '14:00:00', '16:00:00'),
(24, 19, 13, 1, '2024-04-17', '14:00:00', '16:00:00'),
(25, 11, 13, 1, '2024-04-18', '08:00:00', '10:00:00'),
(26, 3, 13, 1, '2024-04-18', '08:00:00', '10:00:00'),
(27, 2, 13, 1, '2024-04-18', '08:00:00', '10:00:00'),
(28, 2, 13, 1, '2024-04-19', '10:30:00', '12:30:00'),
(29, 3, 13, 1, '2024-04-19', '10:30:00', '12:30:00'),
(30, 2, 13, 1, '2024-04-19', '13:30:00', '15:30:00'),
(31, 11, 13, 1, '2024-04-19', '13:30:00', '15:30:00'),
(32, 14, 13, 1, '2024-04-19', '13:30:00', '15:30:00'),
(33, 14, 13, 1, '2024-04-19', '16:30:00', '18:30:00'),
(34, 19, 13, 1, '2024-04-19', '16:30:00', '18:30:00'),
(35, 2, 13, 1, '2024-04-20', '10:30:00', '12:30:00'),
(36, 11, 13, 1, '2024-04-20', '10:30:00', '12:30:00'),
(37, 3, 13, 1, '2024-04-20', '10:30:00', '12:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `forget_password_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `first_name`, `last_name`, `email`, `password`, `forget_password_token`, `created_at`, `updated_at`) VALUES
(1, 'MILOUD', 'ABOULHODA', 'rakansubs@gmail.com', '$2y$10$399FgPWRkDBmtbZGUvr3UOABw6RymjJuJhARQPY8dTrebOSXPijxu', NULL, '2024-04-09 10:11:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE `answer` (
  `answer_id` int(11) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `is_correct` tinyint(4) DEFAULT 0,
  `question_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `answer`
--

INSERT INTO `answer` (`answer_id`, `answer`, `is_correct`, `question_id`) VALUES
(1, '11', 0, 1),
(2, '12', 0, 1),
(3, '13', 1, 1),
(4, '14', 0, 1),
(5, 'Interfaces can contain constructors.', 0, 2),
(6, 'A class can implement multiple interfaces with the same method names but different implementations.', 1, 2),
(7, 'Interface methods are by default final and static.', 0, 2),
(8, 'Interfaces can have instance variables.', 0, 2),
(9, 'final int CONSTANT_VAR = 10;', 0, 3),
(10, 'constant int CONSTANT_VAR = 10;', 0, 3),
(11, 'static int CONSTANT_VAR = 10;', 0, 3),
(12, 'final static int CONSTANT_VAR = 10;', 1, 3),
(13, 'It refers to the current class instance.', 0, 4),
(14, 'It is used to access the superclass members.', 1, 4),
(15, 'It is used to create a new instance of a class.', 0, 4),
(16, 'It is used to declare a class as a superclass.', 0, 4),
(17, 'true', 0, 5),
(18, 'false', 1, 5),
(19, 'Compilation Error', 0, 5),
(20, 'Runtime Error', 0, 5),
(21, 'ArrayList', 0, 6),
(22, 'LinkedList', 0, 6),
(23, 'HashMap', 1, 6),
(24, 'TreeSet', 0, 6),
(25, 'Terminates the loop or switch statement and transfers execution to the statement immediately following the loop or switch.', 1, 7),
(26, 'Skips the current iteration of a loop and continues with the next iteration.', 0, 7),
(27, 'Jumps to a labeled statement in the current method.', 0, 7),
(28, 'Throws an exception and terminates the program.', 0, 7),
(29, 'Threads are lightweight processes that share the same memory space.', 1, 8),
(30, 'Java doesn\'t support multithreading.', 0, 8),
(31, 'A thread cannot be created by implementing the Runnable interface.', 0, 8),
(32, 'Threads always execute in parallel.', 0, 8);

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
  `is_absent` tinyint(1) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `session_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `student_id`, `date`, `is_present`, `class_id`, `teacher_id`, `is_absent`, `start_time`, `end_time`, `session_id`) VALUES
(1, 2, '2023-10-19', 0, 1, 13, 0, '00:00:00', '00:00:00', 2),
(2, 1, '2023-11-02', 0, 1, 13, 0, '00:00:00', '00:00:00', 4),
(3, 4, '2024-01-04', 2, 4, 13, 0, '00:00:00', '00:00:00', 3),
(4, 1, '0000-00-00', 0, 2, 13, 1, '08:30:00', '10:30:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `branch_id` int(11) NOT NULL,
  `branch_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`branch_id`, `branch_name`) VALUES
(1, 'Developpment Digital'),
(2, 'Developpment Digital Option Application Mobile'),
(3, 'Gestion des Entreprises');

-- --------------------------------------------------------

--
-- Table structure for table `branch_crouse`
--

CREATE TABLE `branch_crouse` (
  `branch_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branch_crouse`
--

INSERT INTO `branch_crouse` (`branch_id`, `course_id`) VALUES
(1, 3),
(3, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(3, 18),
(3, 19),
(3, 20),
(3, 21),
(3, 22),
(3, 23),
(3, 24),
(3, 25),
(3, 26);

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `class_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `class_year` year(4) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `branch_id`, `class_name`, `class_year`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, 'DEV101', '2022', 'Bonne classe', '2023-08-31 23:00:00', NULL),
(2, 2, 'DEV202', '2023', 'Moyenne class', '2023-08-31 23:00:00', NULL),
(3, 3, 'GE101', '2023', 'Encore', '2023-08-31 23:00:00', NULL),
(4, 3, 'GE102', '2023', 'Passage', '2023-08-31 23:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `class_student`
--

CREATE TABLE `class_student` (
  `class_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class_student`
--

INSERT INTO `class_student` (`class_id`, `student_id`, `id`) VALUES
(1, 2, 1),
(1, 3, 2),
(2, 1, 3),
(2, 4, 4),
(2, 5, 5),
(1, 19, 6),
(1, 22, 7),
(1, 14, 8),
(1, 11, 9),
(2, 7, 10),
(2, 12, 11),
(3, 8, 13),
(3, 9, 14),
(3, 13, 15),
(3, 23, 16),
(3, 18, 17),
(4, 21, 18),
(4, 20, 19),
(4, 16, 20),
(4, 15, 21),
(4, 6, 22),
(2, 25, 23),
(3, 24, 24);

-- --------------------------------------------------------

--
-- Table structure for table `class_teacher`
--

CREATE TABLE `class_teacher` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `num_test` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class_teacher`
--

INSERT INTO `class_teacher` (`id`, `class_id`, `teacher_id`, `course_id`, `num_test`) VALUES
(1, 1, 13, 14, 2),
(2, 2, 13, 28, 3),
(3, 3, 13, 2, 2),
(4, 4, 13, 2, NULL),
(5, 1, 13, 13, 2),
(6, 2, 13, 1, 4),
(7, 2, 13, 33, 3),
(9, 1, 13, 12, 3);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(45) DEFAULT NULL,
  `course_code` varchar(45) DEFAULT NULL,
  `MHT` int(11) NOT NULL,
  `Coef` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `course_name`, `course_code`, `MHT`, `Coef`, `created_at`, `updated_at`) VALUES
(1, 'Bases du développement Android', 'M201', 90, 3, '2023-08-31 23:00:00', NULL),
(2, 'Exel', 'M208', 60, 2, '2023-08-31 23:00:00', NULL),
(3, 'Métier et formation ', 'M101', 30, 1, '2023-08-31 23:00:00', NULL),
(4, 'Anglais technique', 'EGTS103', 60, 2, '2023-08-31 23:00:00', NULL),
(5, 'Arabe', 'EGTS101', 50, 2, '2023-08-31 23:00:00', NULL),
(6, 'Français', 'EGTS102', 30, 1, '2023-08-31 23:00:00', NULL),
(7, 'Culture entrepreneuriale-Partie 1', 'EGTS104', 115, 1, '2023-08-31 23:00:00', NULL),
(8, 'Compétences comportementales et sociales', 'EGTS105', 60, 2, '2023-08-31 23:00:00', NULL),
(9, 'Entrepreneuriat-PIE 1', 'EGTS108', 90, 2, '2023-08-31 23:00:00', NULL),
(10, 'Culture et techniques avancées du numérique', 'EGTSA106', 60, 2, '2023-08-31 23:00:00', NULL),
(11, 'Acquérir les bases de l’algorithmique', 'M102', 100, 2, '2024-04-14 09:36:15', NULL),
(12, 'Programmer en Orienté Objet', 'M103', 90, 2, '2024-04-14 09:36:15', NULL),
(13, 'Développer des sites web statiques', 'M104', 80, 2, '2024-04-14 09:36:15', NULL),
(14, 'Programmer en JavaScript', 'M105', 80, 2, '2024-04-14 09:36:15', NULL),
(15, 'Manipuler des bases de données', 'M106', 60, 2, '2024-04-14 09:36:15', NULL),
(16, 'Développer des sites web dynamiques', 'M107', 80, 2, '2024-04-14 09:36:15', NULL),
(17, 'S’initier à la sécurité des systèmes d’inform', 'M108', 60, 2, '2024-04-14 09:36:15', NULL),
(18, 'Droit fondamental', 'M102', 50, 2, '2024-04-14 09:48:05', NULL),
(19, 'Management des organisations', 'M103', 60, 2, '2024-04-14 09:48:05', NULL),
(20, 'Comptabilité générale 1', 'M104', 45, 2, '2024-04-14 09:48:05', NULL),
(21, 'Gestion électronique des données', 'M105', 60, 2, '2024-04-14 09:48:05', NULL),
(22, 'Marketing', 'M106', 75, 2, '2024-04-14 09:48:05', NULL),
(23, 'Comptabilité générale 2', 'M107', 60, 2, '2024-04-14 09:48:05', NULL),
(24, 'Ecrits professionnels', 'M108', 60, 2, '2024-04-14 09:48:05', NULL),
(25, 'Statistique', 'M109', 60, 2, '2024-04-14 09:48:05', NULL),
(26, 'Logiciel de Gestion Commerciale, Comptable', 'M110', 60, 2, '2024-04-14 09:48:05', NULL),
(28, 'Programmation KOTLIN', 'M202', 90, 2, '2024-04-14 11:39:41', NULL),
(29, 'Gestion de projet ', 'M203', 60, 2, '2024-04-14 11:39:41', NULL),
(30, 'Initiation aux composants et modèle d’une app', 'M204', 90, 2, '2024-04-14 11:39:41', NULL),
(31, 'Développement des interfaces utilisateurs sou', 'M205', 60, 2, '2024-04-14 11:39:41', NULL),
(32, 'Elaboration d’une application Android sécuris', 'M206', 80, 2, '2024-04-14 11:39:41', NULL),
(33, 'Développement des applications IOS ', 'M207', 60, 2, '2024-04-14 11:39:41', NULL),
(34, 'Développement multiplateforme ', 'M208', 90, 2, '2024-04-14 11:39:41', NULL),
(35, 'Intégration du milieu professionnel', 'M209', 100, 2, '2024-04-14 11:39:41', NULL);

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
(1, 1, 'School Fee for January', 3000, '2024-01-02', 1),
(2, 2, 'School Fee for March', 500, '2023-04-04', 1),
(3, 3, 'School Fee for Febraury', 2000, '2024-02-06', 1),
(4, 2, 'School Fee for April', 500, '2023-05-04', 1),
(5, 2, 'School Fee for May', 500, '2023-06-04', 1),
(6, 2, 'School Fee for June', 500, '2023-07-04', 1),
(7, 2, 'School Fee for July', 500, '2023-08-04', 1),
(8, 2, 'School Fee for Setepmber', 550, '2022-10-04', 1),
(9, 2, 'School Fee for October', 500, '2022-11-04', 1),
(10, 2, 'School Fee for November', 500, '2022-12-04', 1),
(11, 2, 'School Fee for December', 550, '2023-01-04', 1),
(24, 2, 'School for Setempber', 550, '2024-09-04', NULL);

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
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `homework`
--

INSERT INTO `homework` (`homework_id`, `class_id`, `teacher_id`, `course_id`, `homework`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 13, 4, 'Exercice', '', '2024-04-06 12:17:21', NULL),
(2, 2, 13, 1, 'Tp en poo', '', '2024-04-06 12:17:21', NULL),
(3, 2, 13, 3, 'Trouver un entrepreneur', '', '2024-04-06 12:17:21', NULL),
(16, 1, 13, 4, 'Creative Writing', '', '2024-04-07 14:17:48', NULL),
(17, 1, 13, 4, 'Grammar and Vocabulary', '', '2024-04-07 14:17:48', NULL),
(18, 1, 13, 4, 'Research and Report', '', '2024-04-07 14:17:48', NULL),
(19, 1, 13, 1, 'Basic Java Program', '', '2024-04-07 14:17:48', NULL),
(20, 1, 13, 1, 'Java Loops and Conditionals', '', '2024-04-07 14:17:48', NULL),
(21, 1, 13, 1, 'Polymorphisme', '', '2024-04-07 20:28:39', NULL),
(22, 1, 13, 1, 'Exception and Try/Catch', '', '2024-04-07 20:28:39', NULL),
(23, 2, 13, 1, 'Hello word', 'Write a programme that print \"Hello word\" in Java', '2024-04-17 01:02:22', NULL),
(24, 1, 13, 14, 'Async/Await', 'Write a get request using fetch method', '2024-04-17 06:14:17', NULL),
(25, 2, 13, 1, 'tamrin', 'diro had hadi', '2024-04-17 14:05:58', NULL),
(26, 1, 13, 14, 'JavaScript Console', 'Talk about Js Console', '2024-04-19 21:56:42', NULL);

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
  `question` text DEFAULT NULL,
  `mark` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`question_id`, `test_online_id`, `question`, `mark`) VALUES
(1, 4, 'What is the output of the following Java code snippet?\r\nint x = 5;\r\nSystem.out.println(x++ + ++x);', 12.5),
(2, 4, 'Which of the following statements is true about Java interface?', 12.5),
(3, 4, 'What is the correct way to declare a constant variable in Java?', 12.5),
(4, 4, 'What is the purpose of the super keyword in Java?', 12.5),
(5, 4, 'What will be the output of the following code?\nString str1 = \"hello\";\nString str2 = new String(\"hello\");\nSystem.out.println(str1 == str2);', 12.5),
(6, 4, 'Which collection class allows you to associate a unique key with a value in Java?', 12.5),
(7, 4, 'What does the break statement do in Java?', 12.5),
(8, 4, 'Which of the following statements is true about Java threads?', 12.5);

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
(1, 2, 'C\'est un bon élève qui étudie bien', 13),
(2, 5, 'une eleve negligee ,déclenché l\'emeute', 13),
(3, 3, 'Étudiant moyen, essayant d\'avancer', 13);

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
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(255) NOT NULL DEFAULT 'Female',
  `phone_number` varchar(255) NOT NULL,
  `fathers_name` varchar(255) NOT NULL,
  `mothers_name` varchar(255) NOT NULL,
  `join_date` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `otp` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `first_name`, `last_name`, `date_of_birth`, `gender`, `phone_number`, `fathers_name`, `mothers_name`, `join_date`, `email`, `password`, `avatar`, `otp`, `created_at`, `updated_at`) VALUES
(1, 'Fatima Ezzahra', 'Baba', '2004-10-19', 'Female', '0775729368', 'Rachid', 'Karima', '2022-09-01', 'babafatimaezzahra434@gmail.com', '$2y$10$XAijexiokMq8AeooE8gUeePUDbCSaf6/dkKzm0dFa1SxPMlL0KxuS', NULL, '', '2023-10-04 11:58:48', '2023-10-04 11:58:48'),
(2, 'Saad', 'Aboulhoda', '2003-01-30', 'Male', '0671670183', 'Miloud', 'Fatima', '2022-09-01', 'rakansubs@gmail.com', '$2y$10$Lo8Qj5.ynHqbGvnLWqcscenpVO1h5ftwIG..dzgxBL47fWOMAMA9m', NULL, NULL, '2023-09-21 12:03:22', '2024-02-05 11:03:22'),
(3, 'Hamza', 'El Hourch', '2004-06-15', 'Male', '062901625', 'Ahmed', 'Fatima', '2022-09-01', 'hamza.elhorch@gmail.com', '$2y$10$XAijexiokMq8AeooE8gUeePUDbCSaf6/dkKzm0dFa1SxPMlL0KxuS', NULL, '', '2023-11-01 12:07:48', '2024-03-29 15:07:48'),
(4, 'Halima', 'Bezaz', '2004-04-08', 'Female', '0613060106', 'Hassan', 'Amina', '2022-09-01', 'bzazhalima@gmail.com', '$2y$10$XAijexiokMq8AeooE8gUeePUDbCSaf6/dkKzm0dFa1SxPMlL0KxuS', NULL, '', '2023-10-10 12:10:07', '2023-12-02 09:10:07'),
(5, 'Kawter', 'El Azrak', '2003-04-22', 'Female', '0603848212', 'Amin', 'Naziha', '2022-09-01', 'elazrakkawter@gmail.com', '$2y$10$XAijexiokMq8AeooE8gUeePUDbCSaf6/dkKzm0dFa1SxPMlL0KxuS', NULL, '', '2023-09-30 13:12:10', '2024-03-03 12:12:10'),
(6, 'AHMED', 'AL GHAZALY', '2002-11-29', 'Male', '', '', '', '2022-09-01', 'AHMED.AL.GHAZALY@edusync.ma', '$2y$10$XAijexiokMq8AeooE8gUeePUDbCSaf6/dkKzm0dFa1SxPMlL0KxuS', NULL, NULL, '2024-04-17 00:16:07', NULL),
(7, 'CHAIMAE', 'BAKKA', '2002-06-27', 'Female', '', '', '', '2022-09-01', 'CHAIMAE.BAKKA@edusync.ma', '$2y$10$XAijexiokMq8AeooE8gUeePUDbCSaf6/dkKzm0dFa1SxPMlL0KxuS', NULL, NULL, '2024-04-17 00:31:47', NULL),
(8, 'DOUHA', 'BELARRAGUI', '2002-11-03', 'Female', '', '', '', '2022-09-01', 'DOUHA.BELARRAGUI@edusync.ma', '$2y$10$XAijexiokMq8AeooE8gUeePUDbCSaf6/dkKzm0dFa1SxPMlL0KxuS', NULL, NULL, '2024-04-17 00:31:47', NULL),
(9, 'HIND', 'BENMANSOUR', '2004-06-01', 'Female', '', '', '', '2022-09-01', 'HIND.BENMANSOUR@edusync.ma', '$2y$10$XAijexiokMq8AeooE8gUeePUDbCSaf6/dkKzm0dFa1SxPMlL0KxuS', NULL, NULL, '2024-04-17 00:31:47', NULL),
(10, 'HALIMA', 'BEZAIZ', '2004-01-04', 'Female', '', '', '', '2022-09-01', 'HALIMA.BEZAIZ@edusync.ma', '$2y$10$XAijexiokMq8AeooE8gUeePUDbCSaf6/dkKzm0dFa1SxPMlL0KxuS', NULL, NULL, '2024-04-17 00:31:47', NULL),
(11, 'OUSAMA', 'CHAFAI', '2001-09-16', 'Male', '', '', '', '2022-09-01', 'OUSSAMA.CHAFAI@edusync.ma', '$2y$10$XAijexiokMq8AeooE8gUeePUDbCSaf6/dkKzm0dFa1SxPMlL0KxuS', NULL, NULL, '2024-04-17 00:31:47', NULL),
(12, 'MALIKA', 'DEHAIDEH', '2002-09-11', 'Female', '', '', '', '2022-09-01', 'MALIKA.DEHAIDEH@edusync.ma', '$2y$10$XAijexiokMq8AeooE8gUeePUDbCSaf6/dkKzm0dFa1SxPMlL0KxuS', NULL, NULL, '2024-04-17 00:31:47', NULL),
(13, 'FATIMA', 'EL HAOUZI', '2004-08-14', 'Female', '', '', '', '2022-09-01', 'FATIMA.EL.HAOUZI@edusync.ma', '$2y$10$XAijexiokMq8AeooE8gUeePUDbCSaf6/dkKzm0dFa1SxPMlL0KxuS', NULL, NULL, '2024-04-17 00:31:47', NULL),
(14, 'AYOUB', 'EL HOUANI', '2004-09-04', 'Male', '', '', '', '2022-09-01', 'AYOUB.EL.HOUANI@edusync.ma', '$2y$10$XAijexiokMq8AeooE8gUeePUDbCSaf6/dkKzm0dFa1SxPMlL0KxuS', NULL, NULL, '2024-04-17 00:31:47', NULL),
(15, 'OUMAIMA', 'EL KHOUDRI', '2000-04-15', 'Female', '', '', '', '2022-09-01', 'OUMAIMA.EL.KHOUDRI@edusync.ma', '$2y$10$XAijexiokMq8AeooE8gUeePUDbCSaf6/dkKzm0dFa1SxPMlL0KxuS', NULL, NULL, '2024-04-17 00:31:47', NULL),
(16, 'NOUREDDINE', 'ELRHALMI', '1998-01-22', 'Male', '', '', '', '2022-09-01', 'NOUREDDINE.ELRHALMI@edusync.ma', '$2y$10$XAijexiokMq8AeooE8gUeePUDbCSaf6/dkKzm0dFa1SxPMlL0KxuS', NULL, NULL, '2024-04-17 00:31:47', NULL),
(18, 'MAROUA', 'FRAINE', '2004-01-18', 'Female', '', '', '', '2022-09-01', 'MAROUA.FRAINE@edusync.ma', '$2y$10$XAijexiokMq8AeooE8gUeePUDbCSaf6/dkKzm0dFa1SxPMlL0KxuS', NULL, NULL, '2024-04-17 00:31:47', NULL),
(19, 'MOHAMED', 'JBAREK', '2004-10-29', 'Male', '', '', '', '2022-09-01', 'MOHAMED.JBAREK@edusync.ma', '$2y$10$XAijexiokMq8AeooE8gUeePUDbCSaf6/dkKzm0dFa1SxPMlL0KxuS', NULL, NULL, '2024-04-17 00:31:47', NULL),
(20, 'EL MEHDI', 'MEFTAH', '2003-04-14', 'Male', '', '', '', '2022-09-01', 'EL.MEHDI.MEFTAH@edusync.ma', '$2y$10$XAijexiokMq8AeooE8gUeePUDbCSaf6/dkKzm0dFa1SxPMlL0KxuS', NULL, NULL, '2024-04-17 00:31:47', NULL),
(21, 'CHOROUK', 'NIOUA', '2003-10-18', 'Female', '', '', '', '2022-09-01', 'CHOROUK.NIOUA@edusync.ma', '$2y$10$XAijexiokMq8AeooE8gUeePUDbCSaf6/dkKzm0dFa1SxPMlL0KxuS', NULL, NULL, '2024-04-17 00:31:48', NULL),
(22, 'MOHAMED', 'TALEB', '2003-09-05', 'Male', '', '', '', '2022-09-01', 'MOHAMED.TALEB@edusync.ma', '$2y$10$XAijexiokMq8AeooE8gUeePUDbCSaf6/dkKzm0dFa1SxPMlL0KxuS', NULL, NULL, '2024-04-17 00:31:48', NULL),
(23, 'WIDAD', 'TALEB', '2004-05-11', 'Female', '', '', '', '2022-09-01', 'WIDAD.TALEB@edusync.ma', '$2y$10$XAijexiokMq8AeooE8gUeePUDbCSaf6/dkKzm0dFa1SxPMlL0KxuS', NULL, NULL, '2024-04-17 00:31:48', NULL),
(24, 'FATIMA', 'AZHARI', '2002-05-11', 'Female', '', '', '', '2022-09-01', 'FATIMA.AZHARI@edusync.ma', '$2y$10$XAijexiokMq8AeooE8gUeePUDbCSaf6/dkKzm0dFa1SxPMlL0KxuS', NULL, NULL, '2024-04-17 00:31:48', NULL),
(25, 'MARYAM', 'AIT EL BAHLOUL', '2003-03-12', 'Female', '', '', '', '2022-09-01', 'MARYAM.AIT.EL.BAHLOUL@edusync.ma', '$2y$10$XAijexiokMq8AeooE8gUeePUDbCSaf6/dkKzm0dFa1SxPMlL0KxuS', NULL, NULL, '2024-04-17 00:31:48', NULL);

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
(2, 1, 2),
(25, 22, 2),
(26, 20, 2),
(28, 18, 2),
(29, 17, 2),
(35, 19, 2),
(38, 24, 3),
(39, 22, 3),
(40, 21, 3),
(41, 20, 3),
(42, 1, 19),
(43, 26, 19),
(44, 24, 2);

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
  `email_confirm_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`teacher_id`, `first_name`, `last_name`, `email`, `password`, `phone_number`, `gender`, `date_of_birth`, `joining_date`, `qualification`, `experience`, `cne`, `adresse`, `city`, `state`, `zip_code`, `email_confirm_token`, `created_at`, `updated_at`) VALUES
(13, 'MILOUD', 'ABOULHODA', 'miloud.aboulhoda@gmail.com', '$2y$10$PVadFLK1Cqxyn0Il9B/5Su.9Mmnt050UmAzk2nyCI.EMNwLVMrd0e', '060100010', 'Male', '1995-06-30', '2010-01-26', 'Qualification', 'Experience', 'GA2366', 'A11', 'New Work', 'New Work', 123, NULL, '2024-04-03 13:16:35', '2024-04-03 13:16:35'),
(14, 'LATIFA', 'BENZAZA', 'latifa.benzaza@edusync.ma', '$2y$10$cUukkuLFjoU3ejMwazEnyOYrpllSgrAdUjDYUXmeBrquDsE7Q4v6.', '0612435678', 'Female', '1970-06-20', '2010-02-20', 'Docotor', '15 years', 'GK9234', '32 Angle Avenue Mohamed V Et Rue La Liberte Gueliz,', 'Sidi Kacem', NULL, 16000, NULL, '2024-04-18 10:15:35', '2024-04-18 10:15:35');

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
(1, 'CC2', 18, 2, 4, '2024-04-04 14:07:42', NULL),
(2, 'CC1', 19, 2, 1, '2024-04-06 11:56:23', NULL),
(3, 'CC2', 19.5, 2, 1, '2024-04-06 11:56:23', NULL),
(4, 'CC3', 19, 1, 2, '2024-04-06 11:56:23', NULL),
(5, 'EFM', 38, 2, 4, '2024-04-06 11:56:23', NULL),
(15, 'CC1', 16.5, 2, 14, '2024-04-19 16:40:12', NULL),
(16, 'CC2', 17, 2, 14, '2024-04-19 17:26:03', NULL),
(17, 'CC1', 17.5, 3, 14, '2024-04-19 20:17:15', NULL),
(18, 'CC1', 17, 19, 14, '2024-04-19 20:17:15', NULL),
(19, 'CC1', 20, 22, 14, '2024-04-19 20:17:15', NULL),
(20, 'CC1', 18, 14, 14, '2024-04-19 20:17:15', NULL),
(21, 'CC1', 17.5, 11, 14, '2024-04-19 20:17:15', NULL),
(22, 'CC2', 18, 3, 14, '2024-04-19 21:25:24', NULL),
(23, 'CC2', 18, 19, 14, '2024-04-19 21:25:24', NULL),
(24, 'CC2', 20, 22, 14, '2024-04-19 21:25:24', NULL),
(25, 'CC2', 18.5, 14, 14, '2024-04-19 21:25:24', NULL),
(26, 'CC2', 18, 11, 14, '2024-04-19 21:25:24', NULL),
(27, 'CC1', 18, 1, 1, '2024-04-19 21:39:19', NULL),
(28, 'CC2', 18.5, 1, 1, '2024-04-19 21:44:15', NULL),
(29, 'CC3', 18, 1, 1, '2024-04-19 21:44:15', NULL),
(30, 'CC4', 18, 1, 1, '2024-04-19 21:44:15', NULL),
(31, 'CC1', 17, 4, 1, '2024-04-19 21:44:15', NULL),
(32, 'CC2', 17.5, 4, 1, '2024-04-19 21:44:15', NULL),
(33, 'CC3', 18, 4, 1, '2024-04-19 21:44:15', NULL),
(34, 'CC4', 17.5, 4, 1, '2024-04-19 21:44:15', NULL),
(35, 'CC1', 16.5, 5, 1, '2024-04-19 21:44:15', NULL),
(36, 'CC2', 17, 5, 1, '2024-04-19 21:44:15', NULL),
(37, 'CC3', 18, 5, 1, '2024-04-19 21:44:15', NULL),
(38, 'CC4', 16, 5, 1, '2024-04-19 21:44:15', NULL),
(39, 'CC1', 16, 7, 1, '2024-04-19 21:44:15', NULL),
(40, 'CC2', 16, 7, 1, '2024-04-19 21:44:15', NULL),
(41, 'CC3', 16.75, 7, 1, '2024-04-19 21:44:15', NULL),
(42, 'CC4', 15, 7, 1, '2024-04-19 21:44:15', NULL),
(43, 'CC1', 15.5, 12, 1, '2024-04-19 21:44:15', NULL),
(44, 'CC2', 16.75, 12, 1, '2024-04-19 21:44:15', NULL),
(45, 'CC3', 17, 12, 1, '2024-04-19 21:44:15', NULL),
(46, 'CC4', 15, 12, 1, '2024-04-19 21:44:15', NULL),
(47, 'CC1', 16.5, 25, 1, '2024-04-19 21:44:15', NULL),
(48, 'CC2', 15, 25, 1, '2024-04-19 21:44:15', NULL),
(49, 'CC3', 16, 25, 1, '2024-04-19 21:44:15', NULL),
(50, 'CC4', 17, 25, 1, '2024-04-19 21:44:15', NULL),
(51, 'CC1', 10, 2, 13, '2024-04-19 21:59:36', NULL),
(52, 'CC2', 12, 2, 13, '2024-04-19 21:59:36', NULL),
(53, 'CC1', 14, 3, 13, '2024-04-19 21:59:36', NULL),
(54, 'CC2', 16, 3, 13, '2024-04-19 21:59:36', NULL),
(55, 'CC1', 16, 19, 13, '2024-04-19 21:59:36', NULL),
(56, 'CC2', 17.5, 19, 13, '2024-04-19 21:59:36', NULL),
(57, 'CC1', 20, 22, 13, '2024-04-19 21:59:36', NULL),
(58, 'CC2', 20, 22, 13, '2024-04-19 21:59:36', NULL),
(59, 'CC1', 16, 14, 13, '2024-04-19 21:59:36', NULL),
(60, 'CC2', 17, 14, 13, '2024-04-19 21:59:36', NULL),
(61, 'CC1', 18, 11, 13, '2024-04-19 21:59:36', NULL),
(62, 'CC2', 17, 11, 13, '2024-04-19 21:59:36', NULL),
(63, 'CC1', 6, 2, 12, '2024-04-20 12:32:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `test_online`
--

CREATE TABLE `test_online` (
  `test_online_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `test_online_name` varchar(255) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `duration` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test_online`
--

INSERT INTO `test_online` (`test_online_id`, `course_id`, `test_online_name`, `class_id`, `duration`) VALUES
(4, 1, 'Java Programming Quiz', 1, '00:30:00'),
(5, 14, 'DOM Quiz', 1, '00:15:00'),
(6, 14, 'BOM Quiz', 1, '00:15:00'),
(7, 16, 'PHP PDO Quiz', 1, '00:10:00'),
(8, 13, 'HTML & CSS Quiz', 1, '00:10:00');

-- --------------------------------------------------------

--
-- Table structure for table `test_online_student`
--

CREATE TABLE `test_online_student` (
  `test_online_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `score` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test_online_student`
--

INSERT INTO `test_online_student` (`test_online_id`, `student_id`, `score`) VALUES
(4, 2, 75);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absent_students`
--
ALTER TABLE `absent_students`
  ADD PRIMARY KEY (`absent_students_id`),
  ADD KEY `absent_students_student` (`student_id`),
  ADD KEY `absent_students_teacher` (`teacher_id`),
  ADD KEY `absent_students_class` (`class_id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

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
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`branch_id`);

--
-- Indexes for table `branch_crouse`
--
ALTER TABLE `branch_crouse`
  ADD PRIMARY KEY (`course_id`,`branch_id`),
  ADD KEY `ccc` (`branch_id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_id`),
  ADD KEY `class_branch` (`branch_id`);

--
-- Indexes for table `class_student`
--
ALTER TABLE `class_student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_student_ibfk_1` (`class_id`),
  ADD KEY `class_student_ibfk_2` (`student_id`);

--
-- Indexes for table `class_teacher`
--
ALTER TABLE `class_teacher`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_teacher_teacher` (`teacher_id`),
  ADD KEY `class_teacher_class` (`class_id`),
  ADD KEY `class_teacher_course` (`course_id`);

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
  ADD KEY `f_test_online_class` (`class_id`),
  ADD KEY `test_online_course` (`course_id`);

--
-- Indexes for table `test_online_student`
--
ALTER TABLE `test_online_student`
  ADD PRIMARY KEY (`test_online_id`,`student_id`),
  ADD KEY ` test_online_student_student` (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absent_students`
--
ALTER TABLE `absent_students`
  MODIFY `absent_students_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `answer`
--
ALTER TABLE `answer`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `class_student`
--
ALTER TABLE `class_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `class_teacher`
--
ALTER TABLE `class_teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `fee`
--
ALTER TABLE `fee`
  MODIFY `fee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `holiday`
--
ALTER TABLE `holiday`
  MODIFY `holiday_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `homework`
--
ALTER TABLE `homework`
  MODIFY `homework_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `multimedia`
--
ALTER TABLE `multimedia`
  MODIFY `multimedia_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `student_homework`
--
ALTER TABLE `student_homework`
  MODIFY `student_homework` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `test_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `test_online`
--
ALTER TABLE `test_online`
  MODIFY `test_online_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absent_students`
--
ALTER TABLE `absent_students`
  ADD CONSTRAINT `absent_students_class` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`),
  ADD CONSTRAINT `absent_students_student` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `absent_students_teacher` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`);

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
-- Constraints for table `branch_crouse`
--
ALTER TABLE `branch_crouse`
  ADD CONSTRAINT `ccc` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `vvv` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `class_branch` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `class_student`
--
ALTER TABLE `class_student`
  ADD CONSTRAINT `class_student_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`),
  ADD CONSTRAINT `class_student_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `class_teacher`
--
ALTER TABLE `class_teacher`
  ADD CONSTRAINT `class_teacher_class` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`),
  ADD CONSTRAINT `class_teacher_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`),
  ADD CONSTRAINT `class_teacher_teacher` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`);

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
  ADD CONSTRAINT `f_test_online_class` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `test_online_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `test_online_student`
--
ALTER TABLE `test_online_student`
  ADD CONSTRAINT ` test_online_student_student` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `test_online_student_test_online` FOREIGN KEY (`test_online_id`) REFERENCES `test_online` (`test_online_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `insert fee` ON SCHEDULE EVERY 1 MONTH STARTS '2023-09-01 14:40:12' ENDS '2024-07-01 14:40:12' ON COMPLETION NOT PRESERVE ENABLE DO INSERT INTO fee (fee_id, student_id, fee_description, total_fee, fee_date, is_paid)
SELECT null,
       student_id,
       CONCAT('School Fee for ', MONTHNAME(CURRENT_DATE)) AS fee_description,
       500,
       CURRENT_DATE,
       0
FROM student$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
