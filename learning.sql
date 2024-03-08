-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2024 at 09:05 AM
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
-- Database: `learning_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_topic`
--

CREATE TABLE `add_topic` (
  `topic_id` int(11) NOT NULL,
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

INSERT INTO `add_topic` (`topic_id`, `lesson_id`, `video_embed_id`, `file_id`, `img_id`, `quiz_id`, `assignment_id`, `url_id`) VALUES
(143, 140, 32, NULL, NULL, NULL, NULL, NULL),
(144, 141, 33, NULL, NULL, NULL, NULL, NULL),
(147, 141, NULL, NULL, NULL, NULL, NULL, 1),
(148, 140, NULL, NULL, NULL, 57, NULL, NULL),
(149, 141, NULL, 24, NULL, NULL, NULL, NULL),
(150, 140, NULL, NULL, NULL, 58, NULL, NULL),
(151, 143, NULL, NULL, NULL, 59, NULL, NULL),
(153, 143, NULL, NULL, 17, NULL, NULL, NULL),
(154, 143, 34, NULL, NULL, NULL, NULL, NULL),
(155, 140, NULL, NULL, NULL, 60, NULL, NULL),
(156, 145, NULL, NULL, NULL, 61, NULL, NULL),
(160, 145, NULL, NULL, 18, NULL, NULL, NULL),
(161, 145, 35, NULL, NULL, NULL, NULL, NULL),
(163, 145, NULL, 25, NULL, NULL, NULL, NULL),
(167, 145, NULL, NULL, NULL, NULL, 33, NULL),
(172, 145, NULL, NULL, NULL, NULL, 38, NULL);

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
(1, 'admin', '$2y$10$p0PB0j4WPOfDXZ8rRWGQdu6bAKecz8Mvw4sqdmQLuRQcvIuMu.1I.');

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
  `file_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`assignment_id`, `lesson_id`, `title`, `description`, `deadline`, `file_path`, `open_time`, `close_time`, `status`, `file_name`) VALUES
(33, 145, 'LAB 1', 'ส่งรูปตัวเอง', '2024-03-09 11:09:00', 'uploads/ass/Lab13_002_Prewitt.docx', '2024-03-08 11:09:00', '2024-03-09 11:09:00', 'open', 'Lab13_002_Prewitt.docx'),
(38, 145, 'LAB 2', 'ส่งรูปที่ทำมา', '2024-03-08 15:05:00', 'uploads/ass/Qr.png', '2024-03-08 15:04:00', '2024-03-08 15:05:00', 'open', 'Qr.png');

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
  `group_id` int(11) NOT NULL,
  `is_open` tinyint(1) DEFAULT 1,
  `access_code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`c_id`, `course_name`, `description`, `teacher_id`, `created_at`, `updated_at`, `c_img`, `course_code`, `group_id`, `is_open`, `access_code`) VALUES
(10, 'ภาษาไทย', 'ภาษาไทยภาษาไทยภาษาไทยภาษาไทยภาษาไทย', 10, '2024-02-10 14:58:07', '2024-02-10 14:58:30', '../admin/teacher_process/img/THAI_Cover2-01.png', '0246589', 1, 1, ''),
(12, 'ภาษาไทย', 'ภาษาไทยภาษาไทยภาษาไทยภาษาไทย', 6, '2024-02-20 09:18:39', '2024-03-06 20:08:09', '../admin/teacher_process/img/THAI_Cover2-01.png', '4111569', 1, 1, ''),
(13, 'คณิตศาสตร์ ม1', '', 6, '2024-02-26 20:04:28', '2024-03-04 13:53:08', '../admin/teacher_process/img/OIP.jpg', '4111569', 2, 1, ''),
(14, 'ภาษาไทย ม1', 'ภาษาไทย ม1', 6, '2024-02-27 09:35:31', '2024-02-27 09:35:31', '../admin/teacher_process/img/THAI_Cover2-01.png', '0246589', 1, 1, NULL);

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
(24, 141, 'teachers.xlsx', 'uploads/files/teachers.xlsx', NULL, '', '2024-02-26 04:06:16'),
(25, 145, 'Lab13_002_Prewitt.docx', 'uploads/files/Lab13_002_Prewitt.docx', NULL, 'ฟหกฟ', '2024-03-06 04:48:01');

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

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`img_id`, `lesson_id`, `filename`, `file_path`, `description`) VALUES
(17, 143, 'THAI_Cover2-01.png', 'uploads/img/THAI_Cover2-01.png', ''),
(18, 145, 'THAI_Cover2-01.png', 'uploads/img/THAI_Cover2-01.png', '');

-- --------------------------------------------------------

--
-- Table structure for table `learning_subject_group`
--

CREATE TABLE `learning_subject_group` (
  `group_id` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `learning_subject_group`
--

INSERT INTO `learning_subject_group` (`group_id`, `group_name`, `created_at`, `updated_at`) VALUES
(1, 'กลุ่มสาระการเรียนรู้ภาษาไทย', '2024-01-28 16:25:10', '2024-01-28 16:25:10'),
(2, 'กลุ่มสาระการเรียนรู้คณิตศาสตร์', '2024-01-28 16:25:10', '2024-01-28 16:25:10'),
(3, 'กลุ่มสาระการเรียนรู้วิทยาศาสตร์และเทคโนโลยี', '2024-01-28 16:27:58', '2024-01-28 16:27:58'),
(4, 'กลุ่มสาระการเรียนรู้สังคมศึกษาฯ', '2024-01-28 16:27:58', '2024-01-28 16:27:58'),
(5, 'กลุ่มสาระการเรียนรู้สุขศึกษาฯ', '2024-01-28 16:29:13', '2024-01-28 16:29:13'),
(6, 'กลุ่มสาระการเรียนรู้ศิลปะ', '2024-01-28 16:29:13', '2024-01-28 16:29:13'),
(7, 'กลุ่มสาระการเรียนรู้การงานอาชีพ', '2024-01-28 16:30:03', '2024-01-28 16:30:03'),
(8, 'กลุ่มสาระการเรียนรู้ภาษาต่างประเทศ', '2024-01-28 16:30:03', '2024-01-28 16:30:03'),
(9, 'ครูผู้สอนอิสลามศึกษา', '2024-01-28 16:30:50', '2024-01-28 16:30:50');

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `lesson_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `lesson_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`lesson_id`, `course_id`, `lesson_name`) VALUES
(140, 12, 'บทที่ 1'),
(141, 12, 'บทที่ 2'),
(143, 14, 'บทที่ 1'),
(144, 14, 'บทที่ 2'),
(145, 13, 'บทที่ 1'),
(147, 13, 'บที่ 2');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `m_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','teacher','admin') NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `question_text` varchar(1000) NOT NULL,
  `choice_ch1` varchar(1000) NOT NULL,
  `choice_ch2` varchar(1000) NOT NULL,
  `choice_ch3` varchar(1000) NOT NULL,
  `choice_ch4` varchar(1000) NOT NULL,
  `correct_answer` varchar(1000) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `quiz_id`, `question_text`, `choice_ch1`, `choice_ch2`, `choice_ch3`, `choice_ch4`, `correct_answer`, `created_at`) VALUES
(19, 51, '10+5', '15', '10', '5', '20', '15', '2024-02-22 05:58:28'),
(21, 52, '50-25', '25', '20', '10', '15', '25', '2024-02-25 03:17:14'),
(22, 52, '50-25', '25', '20', '10', '15', '25', '2024-02-25 03:19:10'),
(23, 58, '5+5', '10', '5', '5', '18', '10', '2024-02-27 02:21:25'),
(24, 59, '5+5', '10', '5', '5', '18', '10', '2024-02-27 02:37:50'),
(25, 58, '50+5', '45', '10', '40', '20', '45', '2024-02-27 03:27:53');

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
  `c_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`quiz_id`, `lesson_id`, `quiz_description`, `quiz_title`, `time_limit`, `question_limit`, `created`, `c_id`) VALUES
(57, 140, 'กลางภาคกลางภาคกลางภาค', 'กลางภาค', '60', 10, '2024-02-26 02:31:10', 12),
(58, 140, '', 'สอบกลางภาค', '60', 50, '2024-02-27 02:20:35', 12),
(59, 143, 'ภาษาไทย ม1', 'สอบกลางภาค', '40', 50, '2024-02-27 02:37:04', 14),
(60, 140, '', 'สอบกลางภาค', '30', 10, '2024-02-27 03:27:12', 12),
(61, 145, '10', 'สอบกลางภาค', '10', 10, '2024-03-03 07:08:28', 13);

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
  `gender` varchar(50) NOT NULL,
  `class` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`s_id`, `username`, `password`, `first_name`, `last_name`, `gender`, `class`) VALUES
(1, 'student', '$2y$10$C4RAJLHCGOZr/rx.XDzvH.u/rk.4qsHUFZqKGnucvA7hPNfDBpV2O', 'lan', 'matha', 'female', '1/1'),
(3, '406359002', '$2y$10$eEQXcR0l298HRH91HArJCuq6Hs3f7cwjo123PqOvhj8ePpBlA1epW', 'รุสลัน', 'มะทา', 'female', '1/1'),
(9, 'student1', '$2y$10$cmr6yWFjm8cv.SfoM63aOuH5S/TBbnNZkcInzOD4NKvGbD7a6Pj8.', 'student1', 'มะทา', 'ชาย', '1'),
(10, 'student2', '$2y$10$aBUv55hylSaLbdJbVLIBRO5bdT.ejHztdw1HSVbbtV77PREHT02mq', 'student2', 'มะทา', 'ชาย', '2'),
(11, 'student3', '$2y$10$Xxg3JYfztiJ0iP3i21gX0ONd54u4chwFFqimZYR9DFHZpzAlgWKPS', 'student3', 'มะทา', 'ชาย', '3'),
(12, 'student4', '$2y$10$D8JHbr8Oytt8hCBnug3Z7enaDnrfzOmTCEBwqS9YO06BXUcl094iq', 'student1', 'มะทา', 'ชาย', '1'),
(13, 'student5', '$2y$10$DPZPUu5A8IZuI0eGYmbZiObd7i7bbED37AwH2GduJ1MonBhXmQj12', 'student1', 'มะทา', 'ชาย', '1'),
(14, 'student6', '$2y$10$j4bi7q6Iu0aUM5NTLnL14OPM6r2kgvn4EycYgXPW6OlIgHCbpwv6W', 'student1', 'มะทา', 'ชาย', '1'),
(15, 'student7', '$2y$10$sytwyvxkqBQw.FtR2rNzPezsyqviBUF5LR5ptWFMLywLxKNmttabq', 'student1', 'มะทา', 'ชาย', '1');

-- --------------------------------------------------------

--
-- Table structure for table `student_course_registration`
--

CREATE TABLE `student_course_registration` (
  `registration_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `class` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `student_course_registration`
--

INSERT INTO `student_course_registration` (`registration_id`, `student_id`, `course_id`, `registration_date`, `class`) VALUES
(2, 9, 12, '2024-02-26 03:21:22', '1'),
(3, 12, 12, '2024-02-26 03:21:22', '1'),
(4, 13, 12, '2024-02-26 03:21:22', '1'),
(5, 14, 12, '2024-02-26 03:21:22', '1'),
(6, 15, 12, '2024-02-26 03:21:22', '1'),
(9, 1, 12, '2024-02-26 03:49:44', '1/1'),
(10, 3, 12, '2024-02-26 03:49:44', '1/1'),
(12, 10, 12, '2024-02-26 04:22:27', '2'),
(13, 9, 13, '2024-03-04 06:53:08', '1'),
(14, 12, 13, '2024-03-04 06:53:08', '1'),
(15, 13, 13, '2024-03-04 06:53:08', '1'),
(16, 14, 13, '2024-03-04 06:53:08', '1'),
(17, 15, 13, '2024-03-04 06:53:08', '1'),
(20, 1, 10, '2024-03-04 13:49:08', NULL),
(21, 1, 12, '2024-03-06 13:08:09', '1/1'),
(22, 3, 12, '2024-03-06 13:08:09', '1/1'),
(23, 9, 14, '2024-03-08 02:19:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_images`
--

CREATE TABLE `student_images` (
  `image_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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

--
-- Dumping data for table `submitted_assignments`
--

INSERT INTO `submitted_assignments` (`id`, `student_id`, `last_updated`, `status`, `assignment_id`, `submitted_file`, `submitted_datetime`, `comment`) VALUES
(114, 9, '2024-03-08 06:01:17', 'ตรวจแล้ว', 33, 'Lab13_002_Prewitt (1).docx', '2024-03-08 04:39:45', 'ฟหดฟห');

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
  `image_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`t_id`, `username`, `password`, `first_name`, `last_name`, `email`, `group_id`, `image_id`) VALUES
(6, 'teacher', '$2y$10$KPNScWqw0Sj28mbOttLQNOImw57Bj9ddTcBEDbXBFL0j.TGjEL/za', 'Ruslan', 'Matha', 'teacher@gmail.com', 9, NULL),
(9, 'ruslan', '$2y$10$k6j1nZ4LWaeW4zcTKLRtGOwbw/EeLaWV7ZpGIZahYWk3DZ4M31LpW', 'รุสลัน', 'มะทา', 'ruslan@gmail.com', 1, NULL),
(10, 'test', '$2y$10$kWfw.DDWLAMheRm2pZrnDuFzv1jp4ZarCJiwLQLFf4aAt4t5bg4N6', 'test01', 'ssss', 'test@gmail.com', 1, NULL),
(13, '406359002', '$2y$10$6kliEOF.pTAO4QYgbycNz.bz32rlByxyHYYm794GcknI.JvBQErdq', 'รุสลัน', 'มะทา', 'ruslan@gmail.com', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teachers_images`
--

CREATE TABLE `teachers_images` (
  `image_id` int(11) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
(1, 141, 'https://youtu.be/FvsHCaVsMNU?si=A_g5vghOII_Rkki5', 'Video URL');

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
(32, 140, '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/0eLxwusfzDY?si=ZzGBeatnefbkDI6d\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>', ''),
(33, 141, '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/0eLxwusfzDY?si=ZzGBeatnefbkDI6d\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>', ''),
(34, 143, '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/ntZazVswGfs?si=kqnQ8o2dufY8lRDp\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>', ''),
(35, 145, '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/JnWqhQ9OSBU?si=91AFd7Pvx8x_cUz5\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen></iframe>', '');

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
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `fk_courses_teachers` (`teacher_id`),
  ADD KEY `fk_courses_subject_group` (`group_id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`file_id`),
  ADD KEY `files_ibfk_1` (`lesson_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`img_id`),
  ADD KEY `lesson_id` (`lesson_id`);

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
  ADD KEY `lessons_ibfk_1` (`course_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`m_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`quiz_id`),
  ADD KEY `lesson_id` (`lesson_id`),
  ADD KEY `fk_quizzes_courses` (`c_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `student_course_registration`
--
ALTER TABLE `student_course_registration`
  ADD PRIMARY KEY (`registration_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `student_images`
--
ALTER TABLE `student_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `submitted_assignments`
--
ALTER TABLE `submitted_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `assignment_id` (`assignment_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`t_id`),
  ADD KEY `fk_teachers_learning_subject_group` (`group_id`),
  ADD KEY `images_id` (`image_id`);

--
-- Indexes for table `teachers_images`
--
ALTER TABLE `teachers_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `urls`
--
ALTER TABLE `urls`
  ADD PRIMARY KEY (`url_id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `videos_embed`
--
ALTER TABLE `videos_embed`
  ADD PRIMARY KEY (`video_embed_id`),
  ADD KEY `videos_embed_ibfk_1` (`lesson_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_topic`
--
ALTER TABLE `add_topic`
  MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `learning_subject_group`
--
ALTER TABLE `learning_subject_group`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `lesson_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `student_course_registration`
--
ALTER TABLE `student_course_registration`
  MODIFY `registration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `student_images`
--
ALTER TABLE `student_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `submitted_assignments`
--
ALTER TABLE `submitted_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `teachers_images`
--
ALTER TABLE `teachers_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `urls`
--
ALTER TABLE `urls`
  MODIFY `url_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `videos_embed`
--
ALTER TABLE `videos_embed`
  MODIFY `video_embed_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `add_topic`
--
ALTER TABLE `add_topic`
  ADD CONSTRAINT `FK_add_topic_assignment_id` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`assignment_id`)ON DELETE CASCADE,
  ADD CONSTRAINT `FK_add_topic_file_id` FOREIGN KEY (`file_id`) REFERENCES `files` (`file_id`)ON DELETE CASCADE,
  ADD CONSTRAINT `FK_add_topic_img_id` FOREIGN KEY (`img_id`) REFERENCES `images` (`img_id`)ON DELETE CASCADE,
  ADD CONSTRAINT `FK_add_topic_lesson_id` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`lesson_id`)ON DELETE CASCADE,
  ADD CONSTRAINT `FK_add_topic_quiz_id` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`quiz_id`)ON DELETE CASCADE,
  ADD CONSTRAINT `FK_add_topic_url_id` FOREIGN KEY (`url_id`) REFERENCES `urls` (`url_id`)ON DELETE CASCADE,
  ADD CONSTRAINT `FK_add_topic_video_embed_id` FOREIGN KEY (`video_embed_id`) REFERENCES `videos_embed` (`video_embed_id`)ON DELETE CASCADE;

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `FK_assignments_lesson_id` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`lesson_id`)ON DELETE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `FK_courses_group_id` FOREIGN KEY (`group_id`) REFERENCES `learning_subject_group` (`group_id`)ON DELETE CASCADE,
  ADD CONSTRAINT `FK_courses_teacher_id` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`t_id`)ON DELETE CASCADE;

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `FK_files_lesson_id` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`lesson_id`)ON DELETE CASCADE;

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `FK_images_lesson_id` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`lesson_id`)ON DELETE CASCADE;

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `FK_lessons_course_id` FOREIGN KEY (`course_id`) REFERENCES `courses` (`c_id`);

--
-- Constraints for table `submitted_assignments`
--
ALTER TABLE `submitted_assignments`
  ADD CONSTRAINT `fk_submitted_assignments_assignment_id` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`assignment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_submitted_assignments_student_id` FOREIGN KEY (`student_id`) REFERENCES `students` (`s_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
