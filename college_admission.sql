-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 06, 2024 at 12:33 PM
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
-- Database: `rohitasy_admission`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'Deepak', '$2y$10$t2/JJZ.htcWBhw6Gem8d/uQ3C5E0YQ78Kl30iZuUJSsjk1.gkhj2K', '2024-10-04 07:35:44');

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `stream_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `stream` varchar(255) DEFAULT NULL,
  `course_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `student_id`, `stream_id`, `subject_id`, `status`, `created_at`, `stream`, `course_name`) VALUES
(1, 4, NULL, NULL, 'Pending', '2024-10-05 09:40:51', 'Your Stream Name', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fee_structures`
--

CREATE TABLE `fee_structures` (
  `id` int(11) NOT NULL,
  `stream_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `fee_structure` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fee_structures`
--

INSERT INTO `fee_structures` (`id`, `stream_id`, `subject_id`, `fee_structure`, `created_at`, `updated_at`) VALUES
(1, 2, 2, 10000.00, '2024-10-04 09:06:00', '2024-10-04 09:06:00'),
(2, 2, 3, 10000.00, '2024-10-04 09:06:42', '2024-10-04 09:06:42'),
(3, 2, 4, 8000.00, '2024-10-04 09:10:26', '2024-10-04 09:10:26'),
(4, 2, 5, 10000.00, '2024-10-04 09:19:00', '2024-10-04 09:19:00'),
(5, 2, 6, 10000.00, '2024-10-04 09:19:10', '2024-10-04 09:19:10'),
(6, 2, 7, 25000.00, '2024-10-04 09:19:23', '2024-10-04 09:19:23'),
(7, 2, 8, 8000.00, '2024-10-04 09:19:32', '2024-10-04 09:19:32'),
(8, 3, 27, 12000.00, '2024-10-04 09:20:22', '2024-10-04 09:20:22'),
(9, 1, 11, 5000.00, '2024-10-04 09:20:41', '2024-10-04 09:20:41'),
(10, 1, 12, 5000.00, '2024-10-04 09:20:48', '2024-10-04 09:21:31'),
(11, 1, 13, 5000.00, '2024-10-04 09:20:58', '2024-10-04 09:20:58'),
(12, 1, 14, 8000.00, '2024-10-04 09:21:49', '2024-10-04 09:21:49'),
(13, 1, 15, 5000.00, '2024-10-04 09:21:56', '2024-10-04 09:21:56'),
(14, 1, 16, 8000.00, '2024-10-04 09:22:03', '2024-10-04 09:22:22'),
(15, 1, 17, 5000.00, '2024-10-04 09:22:12', '2024-10-04 09:22:12'),
(16, 1, 18, 5000.00, '2024-10-04 09:22:47', '2024-10-04 09:22:47'),
(17, 1, 19, 5000.00, '2024-10-04 09:22:56', '2024-10-04 09:22:56'),
(18, 1, 20, 8000.00, '2024-10-04 09:23:08', '2024-10-04 09:23:08'),
(19, 1, 21, 5000.00, '2024-10-04 09:23:33', '2024-10-04 09:23:33'),
(20, 1, 22, 5000.00, '2024-10-04 09:23:45', '2024-10-04 09:23:45'),
(21, 1, 23, 5000.00, '2024-10-04 09:23:55', '2024-10-04 09:23:55'),
(22, 1, 24, 8000.00, '2024-10-04 09:24:03', '2024-10-04 09:24:03'),
(23, 1, 25, 8000.00, '2024-10-04 09:24:11', '2024-10-04 09:24:11'),
(24, 1, 26, 8000.00, '2024-10-04 09:24:18', '2024-10-04 09:24:18');

-- --------------------------------------------------------

--
-- Table structure for table `helpdesk`
--

CREATE TABLE `helpdesk` (
  `id` int(11) NOT NULL,
  `college_name` varchar(255) NOT NULL,
  `college_address` text NOT NULL,
  `college_phone` varchar(15) NOT NULL,
  `college_email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `helpdesk`
--

INSERT INTO `helpdesk` (`id`, `college_name`, `college_address`, `college_phone`, `college_email`, `created_at`, `updated_at`) VALUES
(1, 'Balsi Mahavidyalaya', 'Balsi, Kesinga, Kalahandi, Odisha', '9874563210', 'admin@balsimahavidyalaya.com', '2024-10-04 10:26:00', '2024-10-04 10:26:00');

-- --------------------------------------------------------

--
-- Table structure for table `important_dates`
--

CREATE TABLE `important_dates` (
  `id` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `important_dates`
--

INSERT INTO `important_dates` (`id`, `event_name`, `event_date`, `created_at`, `updated_at`) VALUES
(1, 'Online E Admission', '2024-10-04', '2024-10-04 09:59:13', '2024-10-04 09:59:13');

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `id` int(11) NOT NULL,
  `stream_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `total_seats` int(11) NOT NULL,
  `general_seats` int(11) NOT NULL,
  `obc_seats` int(11) NOT NULL,
  `sc_seats` int(11) NOT NULL,
  `st_seats` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`id`, `stream_id`, `subject_id`, `total_seats`, `general_seats`, `obc_seats`, `sc_seats`, `st_seats`, `created_at`, `updated_at`) VALUES
(1, 2, 2, 48, 19, 13, 8, 6, '2024-10-04 09:45:09', '2024-10-04 09:45:09'),
(2, 2, 3, 48, 19, 13, 8, 6, '2024-10-04 09:46:58', '2024-10-04 09:46:58'),
(3, 2, 4, 32, 13, 9, 5, 4, '2024-10-04 09:47:05', '2024-10-04 09:47:05'),
(4, 2, 5, 64, 26, 17, 10, 8, '2024-10-04 09:47:16', '2024-10-04 09:47:16'),
(5, 2, 6, 48, 19, 13, 8, 6, '2024-10-04 09:47:25', '2024-10-04 09:47:25'),
(6, 2, 7, 100, 40, 27, 16, 13, '2024-10-04 09:49:37', '2024-10-04 09:49:37'),
(7, 2, 8, 16, 6, 4, 3, 2, '2024-10-04 09:49:54', '2024-10-04 09:49:54'),
(8, 2, 10, 67, 27, 18, 11, 9, '2024-10-04 09:52:20', '2024-10-04 09:52:20'),
(9, 1, 11, 100, 40, 27, 16, 13, '2024-10-04 09:52:29', '2024-10-04 09:52:29'),
(10, 1, 12, 94, 38, 25, 15, 12, '2024-10-04 09:52:38', '2024-10-04 09:52:38'),
(11, 1, 13, 100, 40, 27, 16, 13, '2024-10-04 09:52:46', '2024-10-04 09:52:46'),
(12, 1, 14, 25, 10, 7, 4, 3, '2024-10-04 09:52:53', '2024-10-04 09:52:53'),
(13, 1, 15, 67, 27, 18, 11, 9, '2024-10-04 09:53:03', '2024-10-04 09:53:03'),
(14, 1, 16, 65, 26, 18, 10, 8, '2024-10-04 09:53:11', '2024-10-04 09:53:11'),
(15, 1, 17, 91, 36, 25, 15, 12, '2024-10-04 09:53:19', '2024-10-04 09:53:19'),
(16, 1, 18, 100, 40, 27, 16, 13, '2024-10-04 09:53:28', '2024-10-04 09:53:28'),
(17, 2, 19, 100, 40, 27, 16, 13, '2024-10-04 09:53:41', '2024-10-04 09:53:41'),
(18, 1, 20, 19, 8, 5, 3, 2, '2024-10-04 09:53:51', '2024-10-04 09:53:51'),
(19, 3, 27, 55, 22, 15, 9, 7, '2024-10-04 09:54:04', '2024-10-04 09:54:04'),
(20, 1, 21, 93, 37, 25, 15, 12, '2024-10-04 09:54:14', '2024-10-04 09:54:14'),
(21, 1, 22, 33, 13, 9, 5, 4, '2024-10-04 09:54:28', '2024-10-04 09:54:28'),
(22, 1, 23, 39, 16, 11, 6, 5, '2024-10-04 09:54:36', '2024-10-04 09:54:36'),
(23, 1, 24, 40, 16, 11, 6, 5, '2024-10-04 09:54:44', '2024-10-04 09:54:44'),
(24, 1, 25, 32, 13, 9, 5, 4, '2024-10-04 09:54:51', '2024-10-04 09:54:51'),
(25, 1, 26, 54, 22, 15, 9, 7, '2024-10-04 09:55:02', '2024-10-04 09:55:02');

-- --------------------------------------------------------

--
-- Table structure for table `streams`
--

CREATE TABLE `streams` (
  `id` int(11) NOT NULL,
  `stream_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `streams`
--

INSERT INTO `streams` (`id`, `stream_name`, `created_at`, `updated_at`) VALUES
(1, 'Arts', '2024-10-04 08:40:56', '2024-10-04 08:40:56'),
(2, 'Science', '2024-10-04 08:40:56', '2024-10-04 08:40:56'),
(3, 'Commerce', '2024-10-04 08:40:56', '2024-10-04 08:40:56'),
(4, 'Vocational', '2024-10-04 08:40:56', '2024-10-04 08:40:56');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `father_name` varchar(100) NOT NULL,
  `mother_name` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `caste` varchar(50) NOT NULL,
  `religion` varchar(50) NOT NULL,
  `present_address` text NOT NULL,
  `present_post` varchar(100) NOT NULL,
  `present_block` varchar(100) NOT NULL,
  `present_district` varchar(100) NOT NULL,
  `present_state` varchar(50) NOT NULL,
  `permanent_address` text NOT NULL,
  `permanent_post` varchar(100) NOT NULL,
  `permanent_block` varchar(100) NOT NULL,
  `permanent_district` varchar(100) NOT NULL,
  `permanent_state` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL DEFAULT 'India',
  `board_10th` varchar(100) NOT NULL,
  `institute_10th` varchar(100) NOT NULL,
  `secure_mark_10th` int(11) NOT NULL,
  `full_mark_10th` int(11) NOT NULL,
  `percentage_10th` decimal(5,2) GENERATED ALWAYS AS (`secure_mark_10th` / `full_mark_10th` * 100) STORED,
  `board_intermediate` varchar(100) NOT NULL,
  `institute_intermediate` varchar(100) NOT NULL,
  `secure_mark_intermediate` int(11) NOT NULL,
  `full_mark_intermediate` int(11) NOT NULL,
  `percentage_intermediate` decimal(5,2) GENERATED ALWAYS AS (`secure_mark_intermediate` / `full_mark_intermediate` * 100) STORED,
  `board_graduation` varchar(100) NOT NULL,
  `institute_graduation` varchar(100) NOT NULL,
  `secure_mark_graduation` int(11) NOT NULL,
  `full_mark_graduation` int(11) NOT NULL,
  `percentage_graduation` decimal(5,2) GENERATED ALWAYS AS (`secure_mark_graduation` / `full_mark_graduation` * 100) STORED,
  `stream_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `father_name`, `mother_name`, `mobile`, `email`, `password`, `gender`, `caste`, `religion`, `present_address`, `present_post`, `present_block`, `present_district`, `present_state`, `permanent_address`, `permanent_post`, `permanent_block`, `permanent_district`, `permanent_state`, `country`, `board_10th`, `institute_10th`, `secure_mark_10th`, `full_mark_10th`, `board_intermediate`, `institute_intermediate`, `secure_mark_intermediate`, `full_mark_intermediate`, `board_graduation`, `institute_graduation`, `secure_mark_graduation`, `full_mark_graduation`, `stream_id`, `subject_id`) VALUES
(4, 'Deepak Kumar Sahu', 'Kaibala Sahu', 'Swarnamanjari Sahu', '9937147999', 'dksksng@gmail.com', '$2y$10$LIn/uzq8mWle42bqJaYgJOdj7vsIgLlB7UR3psA/Nm4arQ7RW.sl.', 'Male', 'OBC', 'Hindu', 'Balsi', 'Balsi', 'Kesinga', 'Kalahandi', 'Odisha', 'Balsi', 'Balsi', 'Kesinga', 'Kalahandi', 'Odisha', 'India', 'Board of Secondry Education, Odisha', 'Jawahar Ucha Vidyapitha, balsi', 323, 600, 'Council of Higher Secondry Education, Odisha', 'Government Vocational Junior College, Saintala', 363, 650, 'Sambalpur University', 'Government Autonomous College, Rourkela', 1396, 1800, 2, 4),
(5, 'Nepal Sahu', 'Baishnaba Sahu', 'Lalita Sahu', '9556622757', 'nepalsahu@gmail.com', '$2y$10$gnnmRFrPdkrXJoBWQadMNe0ro7ORfFTfodGyTFm6rM2Jca/SRDdeK', 'Male', 'GENERAL', 'Hindu', 'Barpali', 'Barpali', 'Barpali', 'Bargarh', 'Odisha', 'Barpali', 'Barpali', 'Barpali', 'Bargarh', 'Odisha', 'India', 'BSE Odisha', 'Barpali School', 517, 600, 'CHSE Odisha', 'Barpali College', 499, 600, 'Sambalpur University', 'Burla University', 1211, 1800, 1, 21),
(6, 'Bhupindra Harijan', 'Khusiram Harijan', 'Kumari Harijan', '9583474733', 'bpds@gmail.com', '$2y$10$VL0kJzp3DRgRE3M0JqW3jeJ/L9uEuvQbNjyRQVUwLfWbTMZT6TE9q', 'Male', 'SC', 'Hindu', 'Bagad', 'Bagad', 'Kesinga', 'Kalahandi', 'Odisha', 'Bagad', 'Bagad', 'Kesinga', 'Kalahandi', 'Odisha', 'India', 'BSE Odisha', 'Kesinga School', 419, 600, 'CHSE Odisha', 'Kesinga Mahavidyalaya', 424, 600, 'Sambalpur University', 'Kesinga Mahavidyalaya', 1317, 1800, 1, 12);

-- --------------------------------------------------------

--
-- Table structure for table `student_academics`
--

CREATE TABLE `student_academics` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject_name` varchar(255) NOT NULL,
  `grade` varchar(5) NOT NULL,
  `credits` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `subject_name` varchar(255) NOT NULL,
  `stream_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `subject_name`, `stream_id`, `created_at`, `updated_at`) VALUES
(2, 'Physics', 2, '2024-10-04 08:13:47', '2024-10-04 11:37:25'),
(3, 'Chemistry', 2, '2024-10-04 08:18:39', '2024-10-04 11:40:52'),
(4, 'Mathematics', 2, '2024-10-04 08:18:43', '2024-10-04 11:40:56'),
(5, 'Botany', 2, '2024-10-04 08:18:50', '2024-10-04 11:41:01'),
(6, 'Zoology', 2, '2024-10-04 08:18:55', '2024-10-04 11:41:10'),
(7, 'Computer Science', 2, '2024-10-04 08:19:06', '2024-10-04 11:41:16'),
(8, 'Statistics', 2, '2024-10-04 08:19:13', '2024-10-04 11:41:20'),
(10, 'Geology', 2, '2024-10-04 08:27:07', '2024-10-04 11:41:25'),
(11, 'Odia', 1, '2024-10-04 08:27:12', '2024-10-04 11:41:31'),
(12, 'English', 1, '2024-10-04 08:27:17', '2024-10-04 11:41:35'),
(13, 'Hindi', 1, '2024-10-04 08:27:20', '2024-10-04 11:41:39'),
(14, 'Anthropology', 1, '2024-10-04 08:27:30', '2024-10-04 11:41:42'),
(15, 'History', 1, '2024-10-04 08:27:37', '2024-10-04 11:41:47'),
(16, 'Geography', 1, '2024-10-04 08:27:42', '2024-10-04 11:41:50'),
(17, 'Political Science', 1, '2024-10-04 08:27:48', '2024-10-04 11:41:53'),
(18, 'Sociology', 1, '2024-10-04 08:31:49', '2024-10-04 11:41:57'),
(19, 'Education', 1, '2024-10-04 08:32:33', '2024-10-04 11:42:01'),
(20, 'Music', 1, '2024-10-04 08:33:34', '2024-10-04 11:42:04'),
(21, 'Economics', 1, '2024-10-04 08:33:56', '2024-10-04 11:42:08'),
(22, 'Sanskrit', 1, '2024-10-04 08:34:13', '2024-10-04 11:42:12'),
(23, 'Philosophy', 1, '2024-10-04 08:34:26', '2024-10-04 11:42:16'),
(24, 'Psychology', 1, '2024-10-04 08:34:31', '2024-10-04 11:42:19'),
(25, 'Library and Information Science', 1, '2024-10-04 08:34:58', '2024-10-04 11:42:22'),
(26, 'Home Science', 1, '2024-10-04 08:35:05', '2024-10-04 11:42:26'),
(27, 'Commerce', 3, '2024-10-04 08:46:18', '2024-10-04 11:42:30');

-- --------------------------------------------------------

--
-- Table structure for table `subject_links`
--

CREATE TABLE `subject_links` (
  `id` int(11) NOT NULL,
  `stream_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject_links`
--

INSERT INTO `subject_links` (`id`, `stream_id`, `subject_id`, `created_at`, `updated_at`) VALUES
(1, 1, 11, '2024-10-04 08:41:11', '2024-10-04 08:41:11'),
(2, 1, 12, '2024-10-04 08:41:36', '2024-10-04 08:41:36'),
(3, 1, 13, '2024-10-04 08:41:43', '2024-10-04 08:41:43'),
(4, 1, 14, '2024-10-04 08:41:53', '2024-10-04 08:41:53'),
(5, 1, 15, '2024-10-04 08:42:12', '2024-10-04 08:42:12'),
(6, 1, 16, '2024-10-04 08:42:18', '2024-10-04 08:42:18'),
(7, 1, 17, '2024-10-04 08:42:23', '2024-10-04 08:42:23'),
(8, 1, 18, '2024-10-04 08:42:30', '2024-10-04 08:42:30'),
(9, 1, 19, '2024-10-04 08:42:36', '2024-10-04 08:42:36'),
(10, 1, 20, '2024-10-04 08:42:45', '2024-10-04 08:42:45'),
(11, 1, 21, '2024-10-04 08:42:51', '2024-10-04 08:42:51'),
(12, 1, 22, '2024-10-04 08:42:56', '2024-10-04 08:42:56'),
(13, 1, 23, '2024-10-04 08:43:03', '2024-10-04 08:43:03'),
(14, 1, 24, '2024-10-04 08:43:14', '2024-10-04 08:43:14'),
(15, 1, 25, '2024-10-04 08:43:23', '2024-10-04 08:43:23'),
(16, 1, 26, '2024-10-04 08:43:28', '2024-10-04 08:43:28'),
(17, 2, 2, '2024-10-04 08:44:31', '2024-10-04 08:44:31'),
(18, 2, 3, '2024-10-04 08:44:38', '2024-10-04 08:44:38'),
(19, 2, 4, '2024-10-04 08:44:43', '2024-10-04 08:44:43'),
(20, 2, 5, '2024-10-04 08:44:48', '2024-10-04 08:44:48'),
(21, 2, 6, '2024-10-04 08:44:53', '2024-10-04 08:44:53'),
(22, 2, 7, '2024-10-04 08:44:58', '2024-10-04 08:44:58'),
(23, 2, 8, '2024-10-04 08:45:04', '2024-10-04 08:45:04'),
(25, 2, 10, '2024-10-04 08:45:58', '2024-10-04 08:45:58'),
(26, 3, 27, '2024-10-04 08:46:27', '2024-10-04 08:46:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `stream_id` (`stream_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `fee_structures`
--
ALTER TABLE `fee_structures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stream_id` (`stream_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `helpdesk`
--
ALTER TABLE `helpdesk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `important_dates`
--
ALTER TABLE `important_dates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stream_id` (`stream_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `streams`
--
ALTER TABLE `streams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mobile` (`mobile`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `stream_id` (`stream_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `student_academics`
--
ALTER TABLE `student_academics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject_links`
--
ALTER TABLE `subject_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stream_id` (`stream_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fee_structures`
--
ALTER TABLE `fee_structures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `helpdesk`
--
ALTER TABLE `helpdesk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `important_dates`
--
ALTER TABLE `important_dates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `streams`
--
ALTER TABLE `streams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `student_academics`
--
ALTER TABLE `student_academics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `subject_links`
--
ALTER TABLE `subject_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`stream_id`) REFERENCES `streams` (`id`),
  ADD CONSTRAINT `applications_ibfk_3` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);

--
-- Constraints for table `fee_structures`
--
ALTER TABLE `fee_structures`
  ADD CONSTRAINT `fee_structures_ibfk_1` FOREIGN KEY (`stream_id`) REFERENCES `streams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fee_structures_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `seats`
--
ALTER TABLE `seats`
  ADD CONSTRAINT `seats_ibfk_1` FOREIGN KEY (`stream_id`) REFERENCES `streams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `seats_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`stream_id`) REFERENCES `streams` (`id`),
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);

--
-- Constraints for table `student_academics`
--
ALTER TABLE `student_academics`
  ADD CONSTRAINT `student_academics_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subject_links`
--
ALTER TABLE `subject_links`
  ADD CONSTRAINT `subject_links_ibfk_1` FOREIGN KEY (`stream_id`) REFERENCES `streams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subject_links_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
