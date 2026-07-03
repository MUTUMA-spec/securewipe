-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql300.infinityfree.com
-- Generation Time: Jul 02, 2026 at 03:45 AM
-- Server version: 11.4.12-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_41357689_securetool_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password_hash`, `created_at`, `last_login`) VALUES
(2, 'admin', '$2a$12$L8YPBWUgk0wj2f2GSYpJ.OMOWUWcNCRoq6QTDKl0bxgRYvHpVbnCy', '2026-02-25 12:20:15', '2026-05-05 12:27:27');

-- --------------------------------------------------------

--
-- Table structure for table `erase_logs`
--

CREATE TABLE `erase_logs` (
  `log_id` int(11) NOT NULL,
  `device_type` enum('android','iphone','other') NOT NULL,
  `device_model` varchar(100) NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `completion_time` timestamp NULL DEFAULT NULL,
  `status` enum('STARTED','STEP1','STEP2','STEP3','STEP4','COMPLETED','FAILED') DEFAULT 'STARTED',
  `steps_completed` int(11) DEFAULT 0,
  `tool_type` enum('web','desktop') DEFAULT 'web',
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `erase_logs`
--

INSERT INTO `erase_logs` (`log_id`, `device_type`, `device_model`, `start_time`, `completion_time`, `status`, `steps_completed`, `tool_type`, `ip_address`, `user_agent`) VALUES
(18, 'android', 'samsung', '2026-03-18 07:34:16', '2026-03-18 17:35:07', 'COMPLETED', 4, 'web', '41.84.146.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(19, 'android', 'jjj', '2026-03-24 14:06:24', '2026-03-25 00:10:37', 'COMPLETED', 4, 'web', '41.209.14.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(20, 'android', 's 10', '2026-03-27 06:02:22', '2026-03-27 16:02:33', 'COMPLETED', 4, 'web', '41.209.14.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(21, 'android', 'Samsung Galaxy S20', '2026-03-28 17:23:23', NULL, 'STARTED', 0, 'web', '41.209.14.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(22, 'iphone', 'iPhone iPhone 12 Pro Max', '2026-03-28 17:29:47', NULL, 'STARTED', 0, 'web', '41.209.14.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(23, 'android', 'Huawei Mate 20 Lite', '2026-03-28 18:55:02', NULL, 'STARTED', 0, 'web', '41.209.14.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(24, 'android', 'OPPO A55', '2026-03-30 06:24:13', NULL, 'STARTED', 0, 'web', '41.209.14.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(25, 'android', 'Infinix Hot 10i', '2026-04-02 06:13:15', NULL, 'STARTED', 0, 'web', '197.138.0.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0'),
(26, 'android', 'Samsung Galaxy S24 Ultra', '2026-05-05 12:59:45', NULL, 'STARTED', 0, 'web', '196.201.230.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0'),
(27, 'android', 'Samsung Galaxy S10', '2026-06-11 18:10:34', NULL, 'STARTED', 0, 'web', '41.209.14.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 OPR/132.0.0.0'),
(28, 'android', 'Infinix Hot 9', '2026-06-11 18:13:56', NULL, 'STARTED', 0, 'web', '41.209.14.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 OPR/132.0.0.0'),
(29, 'android', 'Samsung Galaxy S10', '2026-06-12 04:13:29', NULL, 'STARTED', 0, 'web', '41.209.14.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `approved` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `user_name`, `email`, `comment`, `approved`, `created_at`) VALUES
(12, 'securewipe_db', 'dumbkelly70@gmail.com', 'nice', 1, '2026-03-27 14:00:30'),
(13, 'tony', 'mkenyay70@gmail.com', 'okay', 1, '2026-03-27 14:01:29');

-- --------------------------------------------------------

--
-- Table structure for table `guides`
--

CREATE TABLE `guides` (
  `guide_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `device_type` enum('android','ios','general') NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `views` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `survey_responses`
--

CREATE TABLE `survey_responses` (
  `response_id` int(11) NOT NULL,
  `age_group` varchar(20) NOT NULL,
  `reset_method` text NOT NULL,
  `believes_secure` tinyint(1) NOT NULL,
  `info_source` varchar(100) NOT NULL,
  `device_type` varchar(50) DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `survey_responses`
--

INSERT INTO `survey_responses` (`response_id`, `age_group`, `reset_method`, `believes_secure`, `info_source`, `device_type`, `submitted_at`) VALUES
(4, '18-24', 'yes', 1, 'online_tutorial', 'android', '2026-03-18 07:31:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `erase_logs`
--
ALTER TABLE `erase_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `idx_erase_start` (`start_time`),
  ADD KEY `idx_erase_device` (`device_type`),
  ADD KEY `idx_erase_tool` (`tool_type`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `idx_feedback_approved` (`approved`);

--
-- Indexes for table `guides`
--
ALTER TABLE `guides`
  ADD PRIMARY KEY (`guide_id`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `idx_guides_device` (`device_type`);

--
-- Indexes for table `survey_responses`
--
ALTER TABLE `survey_responses`
  ADD PRIMARY KEY (`response_id`),
  ADD KEY `idx_survey_date` (`submitted_at`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `erase_logs`
--
ALTER TABLE `erase_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `guides`
--
ALTER TABLE `guides`
  MODIFY `guide_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `survey_responses`
--
ALTER TABLE `survey_responses`
  MODIFY `response_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `guides`
--
ALTER TABLE `guides`
  ADD CONSTRAINT `guides_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `admin` (`admin_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
