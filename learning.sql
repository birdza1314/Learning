-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2024 at 07:29 PM
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
(1, 'ไฟล์', 1, NULL, 1, NULL, NULL, NULL, NULL),
(2, 'แบบฝึกหัด', 1, NULL, NULL, NULL, NULL, 1, NULL),
(3, 'แบบทดสอบ', 1, NULL, NULL, NULL, 1, NULL, NULL),
(4, 'วิดีโอ', 1, 1, NULL, NULL, NULL, NULL, NULL),
(5, 'วิดีโอ', 1, NULL, NULL, NULL, NULL, NULL, 1);

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
  `file_name` varchar(255) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`assignment_id`, `lesson_id`, `title`, `description`, `deadline`, `file_path`, `open_time`, `close_time`, `status`, `file_name`, `course_id`) VALUES
(1, 1, 'Lab1', 'Lab1', '2024-04-06 21:24:00', 'uploads/ass/Lab13_002_Prewitt (1) (1).docx', '2024-03-31 21:24:00', '2024-04-06 21:24:00', 'open', 'Lab13_002_Prewitt (1) (1).docx', 1);

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
  `is_open` tinyint(1) DEFAULT 1,
  `access_code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`c_id`, `course_name`, `description`, `teacher_id`, `created_at`, `updated_at`, `c_img`, `course_code`, `group_id`, `is_open`, `access_code`) VALUES
(1, 'คณิตศาสตร์ ม4', 'คณิตศาสตร์', 1, '2024-03-31 21:22:51', '2024-03-31 21:22:51', '../admin/teacher_process/img/OIP.jpg', '4111569', 2, 1, '1234'),
(2, 'ภาษาไทย ม.1', 'ภาษาไทย ม.1', 1, '2024-03-31 21:30:14', '2024-03-31 21:30:14', '../admin/teacher_process/img/THAI_Cover2-01.png', '4111533', 1, 1, NULL),
(3, 'คณิตศาสตร์เพิ่มเติม', 'คณิตศาสตร์เพิ่มเติม', 1, '2024-03-31 21:34:15', '2024-03-31 21:34:15', '../admin/teacher_process/img/OIP.jpg', 'ค 31201', 2, 1, NULL),
(4, 'คณิตศาสตร์เพิ่มเติม ม.2', 'คณิตศาสตร์เพิ่มเติม', 1, '2024-03-31 21:47:55', '2024-03-31 21:47:55', '../admin/teacher_process/img/OIP.jpg', 'ค 31202', 2, 1, NULL);

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
(1, 1, 'Lab13_002_Prewitt (1) (1).docx', 'uploads/files/Lab13_002_Prewitt (1) (1).docx', NULL, 'code prewitt', '2024-03-31 14:23:43');

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
(1, 1, 'บทที่ 1', 'รอการเรียนรู้');

-- --------------------------------------------------------

--
-- Table structure for table `marks_as_done`
--

CREATE TABLE `marks_as_done` (
  `mark_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `mark_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `question_text` varchar(1000) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `choice_ch1` varchar(1000) NOT NULL,
  `choice_ch2` varchar(1000) NOT NULL,
  `choice_ch3` varchar(1000) NOT NULL,
  `choice_ch4` varchar(1000) NOT NULL,
  `correct_answer` varchar(1000) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
(1, 1, 'สอบครั้งที่ 1', 'สอบครั้งที่ 1', '10', 10, '2024-03-31 14:25:18', 1, 'ปิดใช้งาน');

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
  `class` varchar(50) NOT NULL,
  `image_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`s_id`, `username`, `password`, `first_name`, `last_name`, `class`, `image_id`) VALUES
(1, 'student1', '$2y$10$U1FF6LXxdauAYYlRxg8dHer8I2jnFJBvN0xTeToGsEvGOJTPcTjhq', 'student1', 'student1', '1', 0),
(2, 'student2', '$2y$10$TzEMIye0P.XJg1n1URoF.O7K0V6sNVrJgcl5DuobWZTRwtdsABLZW', 'student2', 'student2', '2', 0),
(3, 'student3', '$2y$10$UCEcH50cPIV5sy98i4xiRO9z52ng9WtH13wDUDGtnW3/o3nLHK0Fy', 'student3', 'student3', '3', 0),
(4, 'student4', '$2y$10$TxyGOiifBU8Ae3QyVeAtNeEQ0nouKmJCPrtfwER3npltj9FHhbAji', 'student4', 'student4', '1', 0),
(5, 'student5', '$2y$10$ebzX9ZLNyWWQYravOy1zJOA8Q5m9ttpe9g8VZWNILOoF75K47EPdu', 'student5', 'student5', '1', 0),
(6, 'student6', '$2y$10$Dac3Ci8g3A/nzqr1pedGJOa63D4DEDsqLIls.rVU2NGbToGQzjKvC', 'student6', 'student6', '1', 0),
(7, 'student7', '$2y$10$bKNN3nhFmiry3yYTmtKg.OlvPqzNnEQUjZXbweXU901Gee4xFjGmm', 'student7', 'student7', '1', 0);

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
  `class` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `student_course_registration`
--

INSERT INTO `student_course_registration` (`registration_id`, `student_id`, `course_id`, `registration_date`, `class`) VALUES
(1, 1, 1, '2024-03-31 14:28:51', NULL),
(3, 1, 3, '2024-03-31 14:34:51', NULL),
(4, 1, 4, '2024-03-31 14:48:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_images`
--

CREATE TABLE `student_images` (
  `image_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `filename` varchar(1000) NOT NULL
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
(1, '406359002', '$2y$10$mMBmX9LaAjWdkMPmm8AEBe5LSOJy79Kxktpt6DHbMS8ZkiPAeVjRy', 'รุสลัน', 'มะทา', 'ruslan@gmail.com', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `teachers_images`
--

CREATE TABLE `teachers_images` (
  `image_id` int(11) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `teachers_images`
--

INSERT INTO `teachers_images` (`image_id`, `teacher_id`, `filename`) VALUES
(1, 1, '1.jpg');

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
(1, 1, 'https://youtu.be/bYRwxh0LdHk?si=s0spMxGAGbtbuFgr', 'เซต ม.4 - สรุปทุกสิ่งที่ต้องรู้ คณิตวันละนิด');

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
(1, 1, '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/bYRwxh0LdHk?si=ooz4Jy9MPzXk8BKR\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>', 'เซต ม.4 - สรุปทุกสิ่งที่ต้องรู้ คณิตวันละนิด');

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
-- Indexes for table `marks_as_done`
--
ALTER TABLE `marks_as_done`
  ADD PRIMARY KEY (`mark_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `lesson_id` (`lesson_id`);

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
  ADD KEY `lesson_id` (`lesson_id`),
  ADD KEY `fk_quizzes_courses` (`c_id`);

--
-- Indexes for table `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD PRIMARY KEY (`result_id`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `user_id` (`user_id`);

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
  ADD KEY `student_id` (`student_id`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `question_id` (`question_id`);

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
  ADD KEY `student_images` (`student_id`);

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
  ADD KEY `FK_teachers_id` (`teacher_id`);

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
  ADD KEY `videos_embed_ibfk_1` (`lesson_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_topic`
--
ALTER TABLE `add_topic`
  MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `lesson_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `student_course_registration`
--
ALTER TABLE `student_course_registration`
  MODIFY `registration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `student_images`
--
ALTER TABLE `student_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `submitted_assignments`
--
ALTER TABLE `submitted_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `teachers_images`
--
ALTER TABLE `teachers_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `urls`
--
ALTER TABLE `urls`
  MODIFY `url_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `videos_embed`
--
ALTER TABLE `videos_embed`
  MODIFY `video_embed_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
