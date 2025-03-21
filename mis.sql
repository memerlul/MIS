-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 16, 2025 at 03:19 PM
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
-- Database: `mis`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `log_id` int(11) NOT NULL,
  `log_user_id` int(11) NOT NULL,
  `log_description` text NOT NULL,
  `log_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`log_id`, `log_user_id`, `log_description`, `log_date`) VALUES
(2, 7, 'Added new user: kiko pangalaninan (kikoako) position (admin)', '2025-03-16 13:58:20'),
(4, 3, 'Updated user: justin melvin (zhask) to position: admin', '2025-03-16 14:07:01'),
(6, 6, 'Deleted user: alden', '2025-03-16 14:11:30');

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `chat_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message_text` text NOT NULL,
  `message_media` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `systemFrom` varchar(60) NOT NULL,
  `systemTo` varchar(60) NOT NULL,
  `message_status` int(11) NOT NULL DEFAULT 1 COMMENT '0=deleted,1=existing,2=waiting for approval',
  `date_sent` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`chat_id`, `sender_id`, `receiver_id`, `message_text`, `message_media`, `systemFrom`, `systemTo`, `message_status`, `date_sent`) VALUES
(60, 4, 14, 'sent from mis', NULL, 'mis', 'alumni', 1, '2025-03-14 01:37:14'),
(61, 4, 2, 'sent from mis', NULL, 'mis', 'mis', 1, '2025-03-14 01:37:26'),
(62, 4, 3, 'sent from mis', NULL, 'mis', 'library', 1, '2025-03-14 01:37:34'),
(63, 4, 15, '', 'file_67d38874b667e3.31367776.jpg', 'mis', 'alumni', 1, '2025-03-14 01:37:56'),
(64, 5, 15, '', 'file_67d388a00e3856.79850718.jpg', 'mis', 'alumni', 2, '2025-03-14 01:38:40'),
(65, 15, 4, '', 'file_67d389458fc3a1.69253054.jpg', 'alumni', 'mis', 2, '2025-03-14 01:41:25'),
(66, 15, 5, '', 'file_67d38975724b99.36236290.webp', 'alumni', 'mis', 2, '2025-03-14 01:42:13'),
(67, 1, 4, 'test', NULL, 'library', 'mis', 1, '2025-03-14 02:26:43'),
(68, 15, 1, '', 'file_67d3942f305c29.85898068.png', 'alumni', 'library', 2, '2025-03-14 02:27:59'),
(69, 1, 15, '', 'file_67d3950e672387.26380770.jpeg', 'library', 'alumni', 0, '2025-03-14 02:34:37'),
(70, 4, 1, '', 'file_67d395a4e2eb77.65199261.jpeg', 'alumni', 'library', 1, '2025-03-14 02:34:12'),
(71, 1, 3, '', 'file_67d397e56ab302.09328640.jpg', 'library', 'mis', 2, '2025-03-14 02:43:49');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` varchar(60) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '0=deleted,1=existing'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `password`, `type`, `status`) VALUES
(2, 'andy anderson', 'andyisaac', '$2y$10$98lrOZf2vco789aT0UUZLu.NsV7jRAoIoj11D0agUZhYGxV3arDjC', 'super admin', 1),
(3, 'justin melvin', 'zhask', '$2y$10$dGvKBUmqq5/EGXnamzd2FOd/cCy7mJyIeaDJzG2P8Obx6liaBwmBi', 'admin', 1),
(4, 'joshua padilla', 'super admin', '$2y$10$feUpFKjojRhk5LQYop6JyueSIAs56IKlcqeU.ZFUefoK/7zoMxgO2', 'super admin', 1),
(5, 'refactor', 'refactor', '$2y$10$KDTVKDxlCc5i.x60xaSikuiKpH6WnAbuaNsqCrbLpvzeerh.LyBhi', 'admin', 1),
(6, 'alden richard', 'alden', '$2y$10$zY9/eO9k80QgYXngg.VHwuXxTWi7rkuc48JuBRLWtHByIcGdK8AUa', 'super admin', 0),
(7, 'kiko pangalaninan', 'kikoako', '$2y$10$Ca0Y7022flVg9fbbXXJR7eZRmUioSqjdTOkTZDx4PpL70Vs2eWlR.', 'admin', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
