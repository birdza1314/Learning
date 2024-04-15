-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2024 at 04:26 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sp_learning`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_topic`
--

CREATE TABLE `add_topic` (
  `topic_id` int(11) NOT NULL,
  `topic_type` enum('แบบทดสอบ','แบบฝึกหัด','ไฟล์','วิดีโอ') DEFAULT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `video_embed_id` int(11) DEFAULT NULL,
  `file_id` int(11) DEFAULT NULL,
  `img_id` int(11) DEFAULT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `assignment_id` int(11) DEFAULT NULL,
  `url_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `add_topic`
--

INSERT INTO `add_topic` (`topic_id`, `topic_type`, `lesson_id`, `video_embed_id`, `file_id`, `img_id`, `quiz_id`, `assignment_id`, `url_id`) VALUES
(1, 'แบบทดสอบ', 1, NULL, NULL, NULL, 1, NULL, NULL),
(2, 'แบบฝึกหัด', 1, NULL, NULL, NULL, NULL, 1, NULL),
(3, 'วิดีโอ', 1, 1, NULL, NULL, NULL, NULL, NULL),
(8, 'แบบทดสอบ', 3, NULL, NULL, NULL, 4, NULL, NULL),
(9, 'ไฟล์', 5, NULL, 2, NULL, NULL, NULL, NULL),
(10, 'วิดีโอ', 3, 2, NULL, NULL, NULL, NULL, NULL),
(13, 'ไฟล์', 3, NULL, 4, NULL, NULL, NULL, NULL),
(14, 'ไฟล์', 6, NULL, 5, NULL, NULL, NULL, NULL),
(15, 'วิดีโอ', 6, 3, NULL, NULL, NULL, NULL, NULL),
(16, 'วิดีโอ', 6, NULL, NULL, NULL, NULL, NULL, 1),
(17, 'แบบฝึกหัด', 6, NULL, NULL, NULL, NULL, 4, NULL),
(18, 'แบบทดสอบ', 6, NULL, NULL, NULL, 5, NULL, NULL),
(19, 'ไฟล์', 7, NULL, 6, NULL, NULL, NULL, NULL),
(20, 'แบบฝึกหัด', 7, NULL, NULL, NULL, NULL, 5, NULL),
(21, 'แบบทดสอบ', 7, NULL, NULL, NULL, 6, NULL, NULL),
(22, 'วิดีโอ', 3, 4, NULL, NULL, NULL, NULL, NULL),
(23, 'วิดีโอ', 4, 5, NULL, NULL, NULL, NULL, NULL),
(24, 'ไฟล์', 4, NULL, 7, NULL, NULL, NULL, NULL),
(25, 'วิดีโอ', 4, 6, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `a_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`a_id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$21TAWv7dUgNI9M1JVFJRb.9N6paorFvCJryHXq.XdWp3jLNBRVy76');

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `assignment_id` int(11) NOT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `deadline` datetime DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `open_time` datetime DEFAULT NULL,
  `close_time` datetime DEFAULT NULL,
  `status` enum('open','closed') DEFAULT 'open',
  `file_name` varchar(255) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`assignment_id`, `lesson_id`, `title`, `description`, `deadline`, `file_path`, `open_time`, `close_time`, `status`, `file_name`, `course_id`) VALUES
(1, 1, 'Lab1', 'ส่งรูป', '2024-04-03 10:30:00', 'uploads/ass/Lab13_002_Prewitt.docx', '2024-04-02 10:30:00', '2024-04-03 10:30:00', 'open', 'Lab13_002_Prewitt.docx', 1),
(4, 6, 'จงเขียนเซตต่อไปนี้แบบแจกแจงสมาชิก', '1.1  เซตของจำนวนเต็มบวกที่หารด้วย  5  ลงตัว\r\n1.2  เซตของจังหวัดในประเทศไทยที่ขึ้นต้นด้วยพยัญชนะ  “ม”\r\n1.3  เซตของจำนวนคู่บวกที่น้อยกว่า  20\r\n1.4  เซตของจำนวนเต็มที่มากกว่า  2  แต่น้อยกว่า  10\r\n1.5  เซตของอักษรในคำว่า  MATHEMATICS\r\n', '2024-04-15 06:44:00', 'uploads/ass/จงเขียนเซตต่อไปนี้แบบแจกแจงสมาชิก.docx', '2024-04-08 06:44:00', '2024-04-15 06:44:00', 'open', 'จงเขียนเซตต่อไปนี้แบบแจกแจงสมาชิก.docx', 13),
(5, 7, 'จงเขียนเซตต่อไปนี้แบบแจกแจงสมาชิก', '1.1  เซตของจำนวนเต็มบวกที่หารด้วย  5  ลงตัว\r\n1.2  เซตของจังหวัดในประเทศไทยที่ขึ้นต้นด้วยพยัญชนะ  “ม”\r\n1.3  เซตของจำนวนคู่บวกที่น้อยกว่า  20\r\n1.4  เซตของจำนวนเต็มที่มากกว่า  2  แต่น้อยกว่า  10\r\n1.5  เซตของอักษรในคำว่า  MATHEMATICS\r\n', '2024-04-09 10:07:00', 'uploads/ass/จงเขียนเซตต่อไปนี้แบบแจกแจงสมาชิก.docx', '2024-04-08 10:07:00', '2024-04-09 10:07:00', 'open', 'จงเขียนเซตต่อไปนี้แบบแจกแจงสมาชิก.docx', 15);

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `class_id` int(11) NOT NULL,
  `classes` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`class_id`, `classes`) VALUES
(1, 'ระดับชั้นมัธยมศึกษาปีที่ 1'),
(2, 'ระดับชั้นมัธยมศึกษาปีที่ 2'),
(3, 'ระดับชั้นมัธยมศึกษาปีที่ 3'),
(4, 'ระดับชั้นมัธยมศึกษาปีที่ 4'),
(5, 'ระดับชั้นมัธยมศึกษาปีที่ 5'),
(6, 'ระดับชั้นมัธยมศึกษาปีที่ 6');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `c_id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `teacher_id` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `c_img` varchar(255) NOT NULL,
  `course_code` varchar(255) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `is_open` tinyint(1) DEFAULT 0,
  `access_code` varchar(255) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`c_id`, `course_name`, `description`, `teacher_id`, `created_at`, `updated_at`, `c_img`, `course_code`, `group_id`, `is_open`, `access_code`, `class_id`) VALUES
(1, 'คณิตศาสตร์เพิ่มเติม', 'คณิตศาสตร์เพิ่มเติม', 1, '2024-04-02 10:26:03', '2024-04-08 15:15:43', '../admin/teacher_process/img/OIP - Copy.jpg', 'ค 31202', 2, 1, '1234', 6),
(2, 'วิทยาศาสตร์', 'วิทยาศาสตร์', 1, '2024-04-02 10:26:43', '2024-04-08 15:15:50', '../admin/teacher_process/img/R.jpg', 'ค 31202', 3, 1, '', 6),
(5, 'ภาษาไทย ม.6', 'คณิตศาสตร์เพิ่มเติม ม.6', 3, '2024-04-02 15:53:21', '2024-04-13 14:54:01', '../admin/teacher_process/img/OIP - Copy.jpg', 'ค 31202', 1, 1, '1234', 6),
(13, 'รายวิชาคณิตศาสตร์เพิ่มเติม ม.6', 'เซต  เป็นคำที่ใช้บ่งบอกถึงกลุ่มของสิ่งต่างๆ เรียกสิ่งที่อยู่ในเซตว่า  สมาชิกของเซตการเขียนเซต  มี  2  แบบ  คือ  เขียนแบบแจกแจงสมาชิก  และแบบบอกเงื่อนไขของสมาชิก\r\n\r\n', 3, '2024-04-08 06:35:43', '2024-04-13 14:54:40', '../admin/teacher_process/img/รูปปกวิชา.jpg', 'ค ๓๑๒๐๑   ', 2, 1, '1234', 6),
(15, 'รายวิชาคณิตศาสตร์เพิ่มเติม ม.1', 'เซต  เป็นคำที่ใช้บ่งบอกถึงกลุ่มของสิ่งต่างๆ เรียกสิ่งที่อยู่ในเซตว่า  สมาชิกของเซตการเขียนเซต  มี  2  แบบ  คือ  เขียนแบบแจกแจงสมาชิก  และแบบบอกเงื่อนไขของสมาชิก\r\n\r\n', 3, '2024-04-08 10:00:17', '2024-04-08 11:23:19', '../admin/teacher_process/img/รูปปกวิชา.jpg', 'ค 31202', 2, 1, '', 6);

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `file_id` int(11) NOT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`file_id`, `lesson_id`, `file_name`, `file_path`, `file_type`, `description`, `created_at`) VALUES
(2, 5, 'Lab13_002_Prewitt (1).docx', 'uploads/files/Lab13_002_Prewitt (1).docx', NULL, '', '2024-04-02 19:07:38'),
(4, 3, 'students.xlsx', 'uploads/files/students.xlsx', NULL, 'ฟหกฟ', '2024-04-07 08:25:39'),
(5, 6, 'ชั่วโมงที่ ๑.docx', 'uploads/files/ชั่วโมงที่ ๑.docx', NULL, 'เอกสารหนวยการเรียนรู้ที่ 1', '2024-04-07 23:39:24'),
(6, 7, 'ชั่วโมงที่ ๑.docx', 'uploads/files/ชั่วโมงที่ ๑.docx', NULL, 'เอกสารหนวยการเรียนรู้ที่ 1', '2024-04-08 03:05:32'),
(7, 4, 'ข้อมูลที่ 1.docx', 'uploads/files/ข้อมูลที่ 1.docx', NULL, 'หฟกหฟ', '2024-04-13 04:25:40');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `img_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `learning_subject_group`
--

CREATE TABLE `learning_subject_group` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `learning_subject_group`
--

INSERT INTO `learning_subject_group` (`group_id`, `group_name`) VALUES
(1, 'กลุ่มสาระการเรียนรู้ภาษาไทย'),
(2, 'กลุ่มสาระการเรียนรู้คณิตศาสตร์'),
(3, 'กลุ่มสาระการเรียนรู้วิทยาศาสตร์และเทคโนโลยี'),
(4, 'กลุ่มสาระการเรียนรู้สังคมศึกษาฯ'),
(5, 'กลุ่มสาระการเรียนรู้สุขศึกษาฯ'),
(6, 'กลุ่มสาระการเรียนรู้ศิลปะ'),
(7, 'กลุ่มสาระการเรียนรู้การงานอาชีพ'),
(8, 'กลุ่มสาระการเรียนรู้ภาษาต่างประเทศ'),
(9, 'ครูผู้สอนอิสลามศึกษา');

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `lesson_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `lesson_name` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT 'รอการเรียนรู้'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`lesson_id`, `course_id`, `lesson_name`, `status`) VALUES
(1, 1, 'บทที่ 1', 'รอการเรียนรู้'),
(3, 5, 'บทที่ 1', 'รอการเรียนรู้'),
(4, 5, 'บmที่ 2', 'รอการเรียนรู้'),
(5, 1, 'บทที่ 2', 'รอการเรียนรู้'),
(6, 13, 'หน่วยการเรียนรู้ที่ ๑ ', 'รอการเรียนรู้'),
(7, 15, 'หน่วยการเรียนรู้ที่ ๑ ', 'รอการเรียนรู้'),
(10, 5, 'วิดีโอ', 'รอการเรียนรู้');

-- --------------------------------------------------------

--
-- Table structure for table `marks_as_done`
--

CREATE TABLE `marks_as_done` (
  `mark_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `mark_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `question_text` text NOT NULL,
  `description` text NOT NULL,
  `choice_ch1` text NOT NULL,
  `choice_ch2` text NOT NULL,
  `choice_ch3` text NOT NULL,
  `choice_ch4` text NOT NULL,
  `correct_answer` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `quiz_id`, `question_text`, `description`, `choice_ch1`, `choice_ch2`, `choice_ch3`, `choice_ch4`, `correct_answer`, `created_at`) VALUES
(1, 1, '5+5', 'ให้ไปศึกษาบทที่ 1', '5', '15', '10', '30', '10', '2024-04-02 03:29:18'),
(2, 1, '5+10', 'ให้ไปศึกษาบทที่ 1', '5', '15', '10', '30', '15', '2024-04-02 03:29:32'),
(6, 4, '5+5', 'ให้ไปศึกษาบทที่ 1', '10', '15', '20', '25', '10', '2024-04-02 18:06:31'),
(8, 4, '5+5', 'ฟหก', '10', '20', '35', '30', '10', '2024-04-07 08:05:03'),
(10, 4, '5+5', 'หฟดก', '65', '55', '60', '50', '60', '2024-04-07 08:13:38'),
(11, 5, 'A  =  {1, 2, 3, 4},  B  =  {2, 4, 5}', 'ให้นักเรียนไปศึกษาเรื่อ เซต หนวยการเรียนรู้ที่ 1', 'เซตว่าง', 'เซตจำกัด', 'เซตอนันต์ ', 'เซตที่เท่ากัน', 'เซตจำกัด', '2024-04-07 23:53:44'),
(12, 5, 'A  =  {2, 4, 6, 8, 10},  \r\nB  =  {x |  x  เป็นจำนวนนับที่น้อยกว่า  5}', 'ให้นักเรียนไปศึกษาเรื่อ เซต หนวยการเรียนรู้ที่ 1', 'เซตว่าง  ', 'เซตจำกัด', 'เซตอนันต์', 'เซตที่เท่ากัน', 'เซตว่าง  ', '2024-04-07 23:54:41'),
(13, 5, 'A  =  {2, 4, 6, 4, 2} ,  B  =  {4, 2, 2, 6, 6}', 'ให้นักเรียนไปศึกษาเรื่อ เซต หนวยการเรียนรู้ที่ 1', 'เซตว่าง', 'เซตจำกัด', 'เซตอนันต์', ' เซตที่เท่ากัน', 'เซตจำกัด', '2024-04-07 23:55:35'),
(14, 6, 'ให้นักเรียนพิจารณาเซตในแต่ละข้อต่อไปนี้ข้อใดเป็นเซตว่าง  เซตจำกัด  เซตอนันต์และเซตที่เท่ากันA  =  {1, 2, 3, 4},  B  =  {2, 4, 5}', 'ให้ไปศึกษาเรื่องเซต', 'เซตว่าง ', 'เซตจำกัด', 'เซตอนันต์ ', 'เซตที่เท่ากัน', 'เซตว่าง ', '2024-04-08 03:27:52'),
(15, 6, 'ให้นักเรียนพิจารณาเซตในแต่ละข้อต่อไปนี้ข้อใดเป็นเซตว่าง  เซตจำกัด  เซตอนันต์\r\n			และเซตที่เท่ากัน\r\n\r\nA  =  {2, 4, 6, 8, 10},  \r\nB  =  {x |  x  เป็นจำนวนนับที่น้อยกว่า  5}\r\n', 'ให้ไปศึกษาบทที่ 1', 'เซตว่าง ', ' เซตจำกัด', ' เซตอนันต์', 'เซตที่เท่ากัน', ' เซตจำกัด', '2024-04-08 03:28:55');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `quiz_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `quiz_description` text NOT NULL,
  `quiz_title` varchar(1000) NOT NULL,
  `time_limit` varchar(1000) NOT NULL,
  `question_limit` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `c_id` int(11) DEFAULT NULL,
  `status` enum('เปิดใช้งาน','ปิดใช้งาน') NOT NULL DEFAULT 'ปิดใช้งาน'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`quiz_id`, `lesson_id`, `quiz_description`, `quiz_title`, `time_limit`, `question_limit`, `created`, `c_id`, `status`) VALUES
(1, 1, 'สอบครั้งที่ 1สอบครั้งที่ 1', 'สอบครั้งที่ 1', '10', 2, '2024-04-02 03:29:41', 1, 'เปิดใช้งาน'),
(4, 3, '', 'สอบครั้งที่ 2', '2', 3, '2024-04-07 07:36:53', 5, 'เปิดใช้งาน'),
(5, 6, 'ให้นักเรียนพิจารณาเซตในแต่ละข้อต่อไปนี้ข้อใดเป็นเซตว่าง  เซตจำกัด  เซตอนันต์ และเซตที่เท่ากัน', 'แบบทดสอบที่ 1', '3', 3, '2024-04-07 23:55:42', 13, 'เปิดใช้งาน'),
(6, 7, 'สอบครั้งที่ 1', 'สอบครั้งที่ 1', '5', 2, '2024-04-08 03:30:04', 15, 'เปิดใช้งาน');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_results`
--

CREATE TABLE `quiz_results` (
  `result_id` int(11) NOT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `total_questions` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `s_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `classes` varchar(50) NOT NULL,
  `classroom` varchar(50) NOT NULL,
  `year` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`s_id`, `username`, `password`, `first_name`, `last_name`, `classes`, `classroom`, `year`, `image`) VALUES
(1110, '06412', '$2y$10$EqqQ.IrTJ1/hFG9YRqnosO3NNLbAJ19JgjeK8kFjP.Woa0Xr/D6Q6', 'นิอัฟฮาม', 'เจ๊ะอาแซ', '6', '1', '2561', NULL),
(1111, '06412', '$2y$10$oWhOHn/ISuHW2fgOKL5DvukGBSTGxsXKwOcXqL7HQVUncVrAqmAeu', 'นิอัฟฮาม', 'เจ๊ะอาแซ', '6', '1', '2561', NULL),
(1112, '06413', '$2y$10$n61Jz91WseHgg7hYesU3SOpBJnmxz5Q7o40CH7umLmL0RsSJI2M7.', 'นูรุดดีน', 'สิริเปาะจิ', '6', '1', '2561', NULL),
(1113, '06414', '$2y$10$Oy9bq6PlgCKfmPPQZGAxvek5A4rjp.9g2U52aF6lKeKF6Ai.jycM2', 'มุสลิม', 'สาแม', '6', '1', '2561', NULL),
(1114, '06415', '$2y$10$8tib4U78uKvmY0cD/XD6NupHuYfvjKZxM.BxcUvkZmb8RKpmSZrsu', 'มูฮัมหมัดอาซราฟีล', 'เจ๊ะดอเล๊าะ', '6', '2', '2561', NULL),
(1115, '06416', '$2y$10$.gDt9FuYxbcunriX890rSOstReK3miFXMCUjDr37rzjEnvWYa9oeG', 'ดารวิส', 'หลง', '5', '2', '2562', NULL),
(1116, '06417', '$2y$10$qmFF6YCLYsVhtfzHD/iw/uj3Nz6V2XFqwpyuQ6F1xa6u.GTDVyiuy', 'นิอัฟฮาม', 'เจ๊ะอาแซ', '5', '2', '2562', NULL),
(1117, '06418', '$2y$10$foMjrqXSOtAQv9uwp4WKlumy8h624S/6Hugoy7zXwj..hVNB8Sq5.', 'นูรุดดีน', 'สิริเปาะจิ', '5', '2', '2562', NULL),
(1118, '06419', '$2y$10$Z7lPBs5bZfKdSi5brYYzke7tNONq61722MxvaVsc7nNUeEqjiZkpe', 'มุสลิม', 'สาแม', '5', '2', '2562', NULL),
(1119, '06420', '$2y$10$6n2hqgxXvB5ztYnLhjBk2OZncxsRNZz0hjLXgnK.G5mwK8Wwte6F.', 'มูฮัมหมัดอาซราฟีล', 'เจ๊ะดอเล๊าะ', '4', '1', '2563', NULL),
(1120, '06421', '$2y$10$hHHo6AaEtkrD1mrE7VKxmOGvY79RUD2y.tObDpL9UCL1Mj/LApeT6', 'มูฮัมหมัดอาซราฟีล', 'เจ๊ะดอเล๊าะ', '4', '1', '2563', NULL),
(1121, '06422', '$2y$10$ZlXKWm0uhQPfRHFYe6qbIuB9MzNCSBQm7VgygycK/SArM43ivOU0e', 'ดารวิส', 'หลง', '4', '1', '2563', NULL),
(1122, '06423', '$2y$10$OOamA6I/d1mo6A3R5wqVVehZhk0DiFEVmcXrJzAQH7tOyfUa35.kO', 'นิอัฟฮาม', 'เจ๊ะอาแซ', '3', '1', '2564', NULL),
(1123, '06424', '$2y$10$V2AwxKCoCdEDlYSEE2LyPeCizEoHOKz.Uxkomh03zw0DXf7jTZDMq', 'นูรุดดีน', 'สิริเปาะจิ', '3', '1', '2564', NULL),
(1124, '06425', '$2y$10$bq3U/KTQf4GZwgaFQRSgyuH2a6axY1Gpkyak9O04r0jXaEbIo7Wz.', 'มุสลิม', 'สาแม', '3', '1', '2564', NULL),
(1125, '06426', '$2y$10$I4QpfV9c2/MdHLVw3VZBduAXZkpkv6J.tC8fYidXFRQk/BJfqauJS', 'มูฮัมหมัดอาซราฟีล', 'เจ๊ะดอเล๊าะ', '3', '2', '2564', NULL),
(1126, '06427', '$2y$10$2mjhF0qylTEttV2Uf8tlLeNnKyN8VQuhDj70KQZlkLV/3U5co5R9q', 'มูฮัมหมัดอาซราฟีล', 'เจ๊ะดอเล๊าะ', '2', '2', '2565', NULL),
(1127, '06428', '$2y$10$bPIaOeiejwHMqAX8FGBdYe4T29NZ87Uj83.lmkNXeRh.qMBBn2m5O', 'ดารวิส', 'หลง', '2', '2', '2565', NULL),
(1128, '06429', '$2y$10$qvrMy1DE1t1TnRtVHTIt8.WDHe6MKO5ojCECBhcTR27TNaj68I6t6', 'นิอัฟฮาม', 'เจ๊ะอาแซ', '2', '2', '2565', NULL),
(1129, '06430', '$2y$10$dbPiCZ54aAWtO4WoPaPJ2.By9X1jIX6TRYsfyS3pVCo8x6pmynoeG', 'นูรุดดีน', 'สิริเปาะจิ', '2', '2', '2565', NULL),
(1130, '06431', '$2y$10$/714kiyAAbnldcs2XLexP.PlT85J1LlD0IPTzqeeENJ9ElvdjioqC', 'นูรุดดีน', 'สิริเปาะจิ', '1', '2', '2566', NULL),
(1131, '06432', '$2y$10$Y0nsNgB5SsPQweVzRMxt0u48uWmsKSyqA./tafH76nKFXpnrqLdIm', 'นูรุดดีน', 'สิริเปาะจิ', '1', '2', '2566', NULL),
(1132, '06433', '$2y$10$KYAOFEZo6YG.U1bT5mdGLOthC8Zl5r8OVDAMHfd3Q4J5rEeNjb9uK', 'นูรุดดีน', 'สิริเปาะจิ', '1', '2', '2566', NULL),
(1133, '06434', '$2y$10$bEHSy91RhHSPgLkB8ZEC/e7y5aeuW7.EyW0BonF1vSPzJCOrNHUHy', 'นูรุดดีน', 'สิริเปาะจิ', '1', '2', '2566', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_answers`
--

CREATE TABLE `student_answers` (
  `answer_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `chosen_answer` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_course_registration`
--

CREATE TABLE `student_course_registration` (
  `registration_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `classroom` varchar(255) DEFAULT NULL,
  `classes` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `student_course_registration`
--

INSERT INTO `student_course_registration` (`registration_id`, `student_id`, `course_id`, `registration_date`, `classroom`, `classes`) VALUES
(110, 1119, 5, '2024-04-15 09:34:15', '1', '4'),
(111, 1120, 5, '2024-04-15 09:34:15', '1', '4'),
(112, 1121, 5, '2024-04-15 09:34:15', '1', '4'),
(114, 1133, 5, '2024-04-15 12:11:22', '2', '1');

-- --------------------------------------------------------

--
-- Table structure for table `submitted_assignments`
--

CREATE TABLE `submitted_assignments` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('ตรวจแล้ว','ยังไม่ตรวจ') NOT NULL DEFAULT 'ยังไม่ตรวจ',
  `assignment_id` int(11) NOT NULL,
  `submitted_file` varchar(255) NOT NULL,
  `submitted_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `comment` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `t_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `image` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`t_id`, `username`, `password`, `first_name`, `last_name`, `email`, `group_id`, `image`) VALUES
(1, 'lan', '$2y$10$g/6QsVLGAlGWCGuT8Ckjh.8Am62gACGKAwE5AAIFK/I28d0tdDX4y', 'ลัน', 'มะทา', 'ruslan@gmail.com', 2, 'alba-photo-001.png'),
(3, 'teacher', '$2y$10$X8Z96TLvhxRGVfUCclVwrumvJYkcSt2dCykPvX9sEmUwwsvKuRJCe', 'Ruslan', 'Matha', 'ruslan123371@gmail.com', NULL, 'ไทย.jpg'),
(5, 'teacher1', '$2y$10$J0KyPOk7rDyIM7etWOe3jetpka1nfB8JCGmHPd6Z7KuX2DLePLv2K', 'teacher1', 'teacher1', '', NULL, NULL),
(6, '406359002', '$2y$10$sq8WkMLpU20ML9wGmME2Qum1AN4CPtT3Nk9EISiqfUSyMDOTYQm3i', 'รุสลัน', 'มะทา', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `urls`
--

CREATE TABLE `urls` (
  `url_id` int(11) NOT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `urls`
--

INSERT INTO `urls` (`url_id`, `lesson_id`, `url`, `description`) VALUES
(1, 6, 'https://www.youtube.com/live/yamUTkGFN8c?si=QCVeR5D-3qxfLpqX', ' เซต ม.4 - ปูพื้นฐาน');

-- --------------------------------------------------------

--
-- Table structure for table `videos_embed`
--

CREATE TABLE `videos_embed` (
  `video_embed_id` int(11) NOT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `embed_code` text DEFAULT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `videos_embed`
--

INSERT INTO `videos_embed` (`video_embed_id`, `lesson_id`, `embed_code`, `description`) VALUES
(1, 1, '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/R6XcRjL4FG0?si=ovAk4csEBSVbxXGb\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>', 'วิชาคณิตศาสตร์ ชั้น ม.2 เรื่อง การบวกและการลบพหุนาม'),
(2, 3, '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/XPNTfnCg3aY?si=eq60FdgNZyoh1wP5\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>', 'การบวก ลบ คูณ หาร จำนวนเต็ม (คณิต ม.1) คณิตวันละนิด ม.ต้น EP.1 | คณิตศาสตร์ by พี่ปั้น'),
(3, 6, '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/yamUTkGFN8c?si=QCVeR5D-3qxfLpqX\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>', 'เซต ม.4 - ปูพื้นฐาน'),
(4, 3, '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/elAxW_LAawU?si=dAbaygJQqXpPO0sj\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>', 'ฟหดฟหก'),
(5, 4, '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/elAxW_LAawU?si=dAbaygJQqXpPO0sj\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>', 'ฟหกดหกดห'),
(6, 4, '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/elAxW_LAawU?si=dAbaygJQqXpPO0sj\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>', 'ฟหกดหกดห');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_topic`
--
ALTER TABLE `add_topic`
  ADD PRIMARY KEY (`topic_id`),
  ADD KEY `FK_add_topic_lesson_id` (`lesson_id`),
  ADD KEY `FK_add_topic_video_embed_id` (`video_embed_id`),
  ADD KEY `FK_add_topic_file_id` (`file_id`),
  ADD KEY `FK_add_topic_img_id` (`img_id`),
  ADD KEY `FK_add_topic_quiz_id` (`quiz_id`),
  ADD KEY `FK_add_topic_assignment_id` (`assignment_id`),
  ADD KEY `FK_add_topic_url_id` (`url_id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`assignment_id`),
  ADD KEY `FK_assignments_lesson_id` (`lesson_id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `FK_courses_group_id` (`group_id`),
  ADD KEY `FK_courses_teacher_id` (`teacher_id`),
  ADD KEY `FK_courses_class_id` (`class_id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`file_id`),
  ADD KEY `FK_files_lesson_id` (`lesson_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`img_id`),
  ADD KEY `FK_images_lesson_id` (`lesson_id`);

--
-- Indexes for table `learning_subject_group`
--
ALTER TABLE `learning_subject_group`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`lesson_id`),
  ADD KEY `FK_lessons_course_id` (`course_id`);

--
-- Indexes for table `marks_as_done`
--
ALTER TABLE `marks_as_done`
  ADD PRIMARY KEY (`mark_id`),
  ADD KEY `marks_as_done_ibfk_1` (`student_id`),
  ADD KEY `marks_as_done_ibfk_2` (`course_id`),
  ADD KEY `marks_as_done_ibfk_3` (`lesson_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `FK_quizzes_id` (`quiz_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`quiz_id`),
  ADD KEY `FK_course_id` (`c_id`),
  ADD KEY `FK_lesson_id` (`lesson_id`);

--
-- Indexes for table `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD PRIMARY KEY (`result_id`),
  ADD KEY `quiz_results_ibfk_1` (`quiz_id`),
  ADD KEY `quiz_results_ibfk_2` (`user_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `student_answers`
--
ALTER TABLE `student_answers`
  ADD PRIMARY KEY (`answer_id`),
  ADD KEY `student_answers_ibfk_1` (`student_id`),
  ADD KEY `student_answers_ibfk_2` (`quiz_id`),
  ADD KEY `student_answers_ibfk_3` (`question_id`);

--
-- Indexes for table `student_course_registration`
--
ALTER TABLE `student_course_registration`
  ADD PRIMARY KEY (`registration_id`),
  ADD KEY `FK_courses_id` (`course_id`),
  ADD KEY `FK_students_id` (`student_id`);

--
-- Indexes for table `submitted_assignments`
--
ALTER TABLE `submitted_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_submitted_assignments_assignment_id` (`assignment_id`),
  ADD KEY `fk_submitted_assignments_student_id` (`student_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`t_id`);

--
-- Indexes for table `urls`
--
ALTER TABLE `urls`
  ADD PRIMARY KEY (`url_id`),
  ADD KEY `FK_url_lesson_id` (`lesson_id`);

--
-- Indexes for table `videos_embed`
--
ALTER TABLE `videos_embed`
  ADD PRIMARY KEY (`video_embed_id`),
  ADD KEY `FK_videos_embed_lesson_id` (`lesson_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_topic`
--
ALTER TABLE `add_topic`
  MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `lesson_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `marks_as_done`
--
ALTER TABLE `marks_as_done`
  MODIFY `mark_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `quiz_results`
--
ALTER TABLE `quiz_results`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1135;

--
-- AUTO_INCREMENT for table `student_answers`
--
ALTER TABLE `student_answers`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `student_course_registration`
--
ALTER TABLE `student_course_registration`
  MODIFY `registration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `submitted_assignments`
--
ALTER TABLE `submitted_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `urls`
--
ALTER TABLE `urls`
  MODIFY `url_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `videos_embed`
--
ALTER TABLE `videos_embed`
  MODIFY `video_embed_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `add_topic`
--
ALTER TABLE `add_topic`
  ADD CONSTRAINT `FK_add_topic_assignment_id` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`assignment_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_add_topic_file_id` FOREIGN KEY (`file_id`) REFERENCES `files` (`file_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_add_topic_img_id` FOREIGN KEY (`img_id`) REFERENCES `images` (`img_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_add_topic_lesson_id` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`lesson_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_add_topic_quiz_id` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`quiz_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_add_topic_url_id` FOREIGN KEY (`url_id`) REFERENCES `urls` (`url_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_add_topic_video_embed_id` FOREIGN KEY (`video_embed_id`) REFERENCES `videos_embed` (`video_embed_id`) ON DELETE CASCADE;

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `FK_assignments_lesson_id` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`lesson_id`) ON DELETE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `FK_courses_class_id` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_courses_group_id` FOREIGN KEY (`group_id`) REFERENCES `learning_subject_group` (`group_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_courses_teacher_id` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`t_id`) ON DELETE CASCADE;

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `FK_files_lesson_id` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`lesson_id`) ON DELETE CASCADE;

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `FK_images_lesson_id` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`lesson_id`) ON DELETE CASCADE;

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `FK_lessons_course_id` FOREIGN KEY (`course_id`) REFERENCES `courses` (`c_id`) ON DELETE CASCADE;

--
-- Constraints for table `marks_as_done`
--
ALTER TABLE `marks_as_done`
  ADD CONSTRAINT `marks_as_done_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`s_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `marks_as_done_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`c_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `marks_as_done_ibfk_3` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`lesson_id`) ON DELETE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `FK_quizzes_id` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`quiz_id`) ON DELETE CASCADE;

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `FK_course_id` FOREIGN KEY (`c_id`) REFERENCES `courses` (`c_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_lesson_id` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`lesson_id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD CONSTRAINT `quiz_results_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`quiz_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_results_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `students` (`s_id`) ON DELETE CASCADE;

--
-- Constraints for table `student_answers`
--
ALTER TABLE `student_answers`
  ADD CONSTRAINT `student_answers_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`s_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_answers_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`quiz_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_answers_ibfk_3` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`) ON DELETE CASCADE;

--
-- Constraints for table `student_course_registration`
--
ALTER TABLE `student_course_registration`
  ADD CONSTRAINT `FK_courses_id` FOREIGN KEY (`course_id`) REFERENCES `courses` (`c_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_students_id` FOREIGN KEY (`student_id`) REFERENCES `students` (`s_id`) ON DELETE CASCADE;

--
-- Constraints for table `submitted_assignments`
--
ALTER TABLE `submitted_assignments`
  ADD CONSTRAINT `fk_submitted_assignments_assignment_id` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`assignment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_submitted_assignments_student_id` FOREIGN KEY (`student_id`) REFERENCES `students` (`s_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `urls`
--
ALTER TABLE `urls`
  ADD CONSTRAINT `FK_url_lesson_id` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`lesson_id`) ON DELETE CASCADE;

--
-- Constraints for table `videos_embed`
--
ALTER TABLE `videos_embed`
  ADD CONSTRAINT `FK_videos_embed_lesson_id` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`lesson_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
