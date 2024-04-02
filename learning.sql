-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2024 at 12:30 PM
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
(3, 'วิดีโอ', 1, 1, NULL, NULL, NULL, NULL, NULL);

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
(1, 1, 'Lab1', 'ส่งรูป', '2024-04-03 10:30:00', 'uploads/ass/Lab13_002_Prewitt.docx', '2024-04-02 10:30:00', '2024-04-03 10:30:00', 'open', 'Lab13_002_Prewitt.docx', 1);

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
  `access_code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`c_id`, `course_name`, `description`, `teacher_id`, `created_at`, `updated_at`, `c_img`, `course_code`, `group_id`, `is_open`, `access_code`) VALUES
(1, 'วิทยาศาสตร์', 'วิทยาศาสตร์วิทยาศาสตร์', 1, '2024-04-02 10:26:03', '2024-04-02 14:38:56', '../admin/teacher_process/img/OIP - Copy.jpg', 'ค 31202', 2, 1, '1234'),
(2, 'วิทยาศาสตร์', 'วิทยาศาสตร์', 1, '2024-04-02 10:26:43', '2024-04-02 10:26:43', '', 'ค 31202', 3, 1, NULL),
(3, 'Copy of วิทยาศาสตร์', 'วิทยาศาสตร์', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', NULL, 1, NULL),
(4, 'Copy of วิทยาศาสตร์', 'วิทยาศาสตร์วิทยาศาสตร์', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', NULL, 1, NULL),
(5, 'คณิตศาสตร์เพิ่มเติม ม.2', 'คณิตศาสตร์เพิ่มเติม ม.2', 3, '2024-04-02 15:53:21', '2024-04-02 15:53:21', '../admin/teacher_process/img/OIP - Copy.jpg', 'ค 31202', 2, 1, NULL),
(6, 'ภาษาไทย ม.1', 'ภาษาไทย ม.1', 3, '2024-04-02 15:55:10', '2024-04-02 15:55:10', '../admin/teacher_process/img/THAI_Cover2-01.png', 'ค 31202', 1, 1, NULL),
(9, 'Copy of ภาษาไทย ม.1', 'ภาษาไทย ม.1', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', NULL, 0, NULL);

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
(2, 5, 'บทที่ 1', 'รอการเรียนรู้');

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

--
-- Dumping data for table `marks_as_done`
--

INSERT INTO `marks_as_done` (`mark_id`, `student_id`, `course_id`, `lesson_id`, `mark_date`) VALUES
(1, 1, 1, 1, '2024-04-02');

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
(2, 1, '5+10', 'ให้ไปศึกษาบทที่ 1', '5', '15', '10', '30', '15', '2024-04-02 03:29:32');

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
(1, 1, 'สอบครั้งที่ 1สอบครั้งที่ 1', 'สอบครั้งที่ 1', '10', 2, '2024-04-02 03:29:41', 1, 'เปิดใช้งาน');

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

--
-- Dumping data for table `quiz_results`
--

INSERT INTO `quiz_results` (`result_id`, `quiz_id`, `user_id`, `score`, `total_questions`, `timestamp`) VALUES
(1, 1, 1, 1, 2, '2024-04-02 03:34:23');

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
  `classroom` varchar(50) NOT NULL,
  `year` int(10) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`s_id`, `username`, `password`, `first_name`, `last_name`, `gender`, `classroom`, `year`, `image`) VALUES
(1, 'student1', '$2y$10$AkUSmFQBVQdFIZbolzaA9egrP40/VFu/Oof6Ja8EzFEKTo3fFmFNC', 'student1', 'student1', '', '1', 0, '1.png');

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

--
-- Dumping data for table `student_answers`
--

INSERT INTO `student_answers` (`answer_id`, `student_id`, `quiz_id`, `question_id`, `chosen_answer`) VALUES
(1, 1, 1, 1, '10'),
(2, 1, 1, 2, '5');

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
(1, 1, 1, '2024-04-02 03:27:26', '1'),
(9, 1, 5, '2024-04-02 09:11:21', NULL);

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
(1, 1, '2024-04-02 03:35:37', 'ตรวจแล้ว', 1, 'สอบ.docx', '2024-04-02 03:35:37', '');

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
(1, 'lan', '$2y$10$g/6QsVLGAlGWCGuT8Ckjh.8Am62gACGKAwE5AAIFK/I28d0tdDX4y', 'ลัน', 'มะทา', 'ruslan@gmail.com', 1, 'alba-photo-001.png'),
(2, '406359002', '$2y$10$X5U46g6GAUxy.rYOhx0EBelsRm4Y4KnW43q7yV1MB.1uWjMHjbX.K', 'รุสลัน', 'มะทา', 'ruslan@gmail.com', 1, 'alba-photo-001.png'),
(3, 'teacher', '$2y$10$X8Z96TLvhxRGVfUCclVwrumvJYkcSt2dCykPvX9sEmUwwsvKuRJCe', 'Ruslan', 'Matha', 'ruslan123371@gmail.com', NULL, NULL);

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
(1, 1, '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/R6XcRjL4FG0?si=ovAk4csEBSVbxXGb\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>', 'วิชาคณิตศาสตร์ ชั้น ม.2 เรื่อง การบวกและการลบพหุนาม');

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
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `FK_courses_group_id` (`group_id`),
  ADD KEY `FK_courses_teacher_id` (`teacher_id`);

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
  MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `lesson_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `marks_as_done`
--
ALTER TABLE `marks_as_done`
  MODIFY `mark_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `quiz_results`
--
ALTER TABLE `quiz_results`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `student_answers`
--
ALTER TABLE `student_answers`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student_course_registration`
--
ALTER TABLE `student_course_registration`
  MODIFY `registration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `submitted_assignments`
--
ALTER TABLE `submitted_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `urls`
--
ALTER TABLE `urls`
  MODIFY `url_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `videos_embed`
--
ALTER TABLE `videos_embed`
  MODIFY `video_embed_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  ADD CONSTRAINT `FK_lessons_course_id` FOREIGN KEY (`course_id`) REFERENCES `courses` (`c_id`)ON DELETE CASCADE;

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
  ADD CONSTRAINT `quiz_results_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `students` (`s_id`);

--
-- Constraints for table `student_answers`
--
ALTER TABLE `student_answers`
  ADD CONSTRAINT `student_answers_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`s_id`)ON DELETE CASCADE,
  ADD CONSTRAINT `student_answers_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`quiz_id`)ON DELETE CASCADE,
  ADD CONSTRAINT `student_answers_ibfk_3` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`)ON DELETE CASCADE;

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
