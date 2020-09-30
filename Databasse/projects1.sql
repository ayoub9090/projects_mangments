-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 30, 2020 at 04:49 PM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projects1`
--

-- --------------------------------------------------------

--
-- Table structure for table `pm_accounts`
--

DROP TABLE IF EXISTS `pm_accounts`;
CREATE TABLE IF NOT EXISTS `pm_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_amount` int(250) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `notes` varchar(250) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subcontractor_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pm_accounts`
--

INSERT INTO `pm_accounts` (`id`, `payment_amount`, `created_date`, `notes`, `user_id`, `subcontractor_id`) VALUES
(14, 1100, '2020-09-30 11:03:25', 'first payment test', 31, 32),
(15, 210, '2020-09-30 11:03:43', 'first payment test', 31, 32),
(16, 12, '2020-09-30 15:43:27', 'hello', 31, 32),
(18, 200, '2020-09-30 15:50:01', '', 31, 37),
(19, 110, '2020-09-30 15:50:11', '', 31, 37),
(20, 15, '2020-09-30 16:00:59', 'hay dof3a', 31, 32);

-- --------------------------------------------------------

--
-- Table structure for table `pm_projects`
--

DROP TABLE IF EXISTS `pm_projects`;
CREATE TABLE IF NOT EXISTS `pm_projects` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_name` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pm_projects`
--

INSERT INTO `pm_projects` (`id`, `project_name`, `user_id`, `date_created`) VALUES
(18, 'HWI-Jordan Orange 2020 RAN Exp Project', 27, '2020-09-21 11:05:07'),
(19, 'HWI-Orange 2019 RAN Exp project', 27, '2020-09-21 11:06:27'),
(20, 'HWI-Orange Account Common Engineering Program from 2015', 27, '2020-09-21 11:06:47'),
(21, 'HWI-ZAIN Account Common Engineering Program', 27, '2020-09-21 11:07:06'),
(22, 'HWI-Jordan ZAIN 2018 Scope Project', 27, '2020-09-21 11:07:47'),
(23, 'HWI-Jordan Zain L900 2020 Project', 27, '2020-09-21 11:09:17'),
(24, 'HWI-Jordan Zain Scope 2019 Project', 27, '2020-09-21 11:10:52'),
(25, 'HWI-Orange Account Common Engineering Program from 2019', 27, '2020-09-21 11:11:45'),
(26, 'HWI-Orange Account Common Engineering Program from 2020', 27, '2020-09-21 11:12:11'),
(27, 'HWI-ZAIN Account Common Engineering Program from 2019', 27, '2020-09-21 11:13:06'),
(28, 'UMNIAH PH14', 29, '2020-09-21 11:28:36'),
(29, 'Collecting Material ', 29, '2020-09-21 11:53:59'),
(30, 'C.B and DCDU installation', 29, '2020-09-21 11:55:10'),
(31, 'Transport', 29, '2020-09-21 11:57:11'),
(32, 'Old System', 29, '2020-09-27 09:37:42'),
(33, 'TDD tickets', 29, '2020-09-29 07:55:14');

-- --------------------------------------------------------

--
-- Table structure for table `pm_tasks`
--

DROP TABLE IF EXISTS `pm_tasks`;
CREATE TABLE IF NOT EXISTS `pm_tasks` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `task_description` varchar(940) NOT NULL,
  `project_id` int(11) UNSIGNED NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pm_tasks`
--

INSERT INTO `pm_tasks` (`id`, `task_description`, `project_id`, `date_created`) VALUES
(23, 'MW Link (0.3-0.9) Installation ', 17, '2020-09-21 10:53:28'),
(25, ' survey ', 23, '2020-09-21 11:25:40'),
(26, ' survey', 18, '2020-09-21 11:26:05'),
(27, 'QC ', 23, '2020-09-21 11:26:50'),
(28, 'QC ', 18, '2020-09-21 11:27:09'),
(29, 'Add GUL 1 Sector + OMB', 18, '2020-09-21 11:28:28'),
(30, 'Add GUL 2 Sector + OMB', 18, '2020-09-21 11:28:43'),
(32, 'Add GUL 3 Sector + OMB', 18, '2020-09-21 11:29:41'),
(33, 'Add 1 GUL Sector', 18, '2020-09-21 11:44:41'),
(34, 'Add 2 GUL Sector', 18, '2020-09-21 11:44:51'),
(35, 'Add 3 GUL Sector', 18, '2020-09-21 11:45:07'),
(36, 'New GUL Site / 2 Sectors', 18, '2020-09-21 11:45:42'),
(37, 'New GUL Site / 3 Sectors', 18, '2020-09-21 11:45:58'),
(38, 'New GUL Site / 4 Sectors', 18, '2020-09-21 11:46:10'),
(39, 'ADD 1 Tech', 28, '2020-09-21 11:48:19'),
(40, 'ADD 2 Tech', 28, '2020-09-21 11:48:34'),
(41, 'ADD 3 Tech', 28, '2020-09-21 11:48:48'),
(42, '4G Split 1 Sector ', 18, '2020-09-21 11:48:54'),
(43, 'ADD 4 Tech', 28, '2020-09-21 11:49:00'),
(44, '4G Split 2 Sector ', 18, '2020-09-21 11:49:03'),
(45, '4G Split 3 Sector ', 18, '2020-09-21 11:49:12'),
(46, '4G Split 4 Sector ', 18, '2020-09-21 11:49:25'),
(47, 'ADD 1 Sector', 28, '2020-09-21 11:49:28'),
(48, 'ADD 2 Sector', 28, '2020-09-21 11:49:37'),
(49, 'ADD 3 Sector', 28, '2020-09-21 11:49:51'),
(50, 'Add FDD 1 Sector', 18, '2020-09-21 11:50:06'),
(51, 'QC', 28, '2020-09-21 11:50:10'),
(53, 'Survey', 28, '2020-09-21 11:50:19'),
(54, 'Extra visit ', 28, '2020-09-21 11:50:36'),
(55, 'Add FDD 2 Sector', 18, '2020-09-21 11:50:44'),
(56, 'Add FDD 3 Sector', 18, '2020-09-21 11:50:53'),
(57, 'Battery Swap indoor ', 28, '2020-09-21 11:50:58'),
(58, 'Add FDD 4 Sector', 18, '2020-09-21 11:51:02'),
(59, 'Battery swap outdoor', 28, '2020-09-21 11:51:12'),
(60, 'power Swap Indoor ', 28, '2020-09-21 11:51:25'),
(61, 'Power swap Outdoor', 28, '2020-09-21 11:51:38'),
(62, 'migration ', 28, '2020-09-21 11:51:53'),
(63, 'MW Link installation (0.3-0.9)', 20, '2020-09-21 11:52:00'),
(64, 'C.B installation ', 28, '2020-09-21 11:52:10'),
(65, 'MW Link installation (1.2)', 20, '2020-09-21 11:52:12'),
(66, 'Relocation Site on same roof ', 28, '2020-09-21 11:52:29'),
(67, 'MW Link installation (1.8)', 20, '2020-09-21 11:52:34'),
(68, 'Relocation Site to Diff Roof ', 28, '2020-09-21 11:53:00'),
(69, 'MW installation (0.3-0.9)', 28, '2020-09-21 11:53:27'),
(70, 'collecting  Material ', 29, '2020-09-21 11:54:25'),
(71, 'ADD C.B ', 30, '2020-09-21 11:55:25'),
(72, 'ADD DCDU ', 30, '2020-09-21 11:55:38'),
(73, 'IPRAN_X2', 22, '2020-09-21 11:55:45'),
(74, 'IPRAN_X8', 22, '2020-09-21 11:55:55'),
(75, 'IPRAN_ATN910C,950C', 24, '2020-09-21 11:56:50'),
(76, ' transportation (Amman,Madaba,Salt,Zarqa)', 31, '2020-09-21 11:58:05'),
(77, 'DWDM_CAB', 24, '2020-09-21 11:58:13'),
(78, ' transportation (Irbid,ajloun,jarash,Mafraq,Ramtha)', 31, '2020-09-21 11:58:43'),
(79, ' transportation (Karak,Tafila,maan,aqaba)', 31, '2020-09-21 11:59:11'),
(80, 'New Board installation ', 26, '2020-09-21 11:59:30'),
(81, 'DWDM- Large Single Rack', 26, '2020-09-21 11:59:56'),
(82, 'Extra Visit', 23, '2020-09-21 12:00:29'),
(83, 'Extra Visit', 18, '2020-09-21 12:00:39'),
(84, 'MDU_IND,OUT', 21, '2020-09-21 12:01:27'),
(85, 'MW Link installation (0.3-0.9) (1 +0 XPIC)', 23, '2020-09-21 12:02:44'),
(86, 'MW Link installation (1.2) (1 +0 XPIC)', 23, '2020-09-21 12:03:48'),
(87, 'MW Link installation (1.8) (1 +0 XPIC)', 23, '2020-09-21 12:04:01'),
(88, 'MW Link installation (0.3-0.9) (2 +0 XPIC)', 23, '2020-09-21 12:04:16'),
(89, 'MW Link installation (1.2) (2 +0 XPIC)', 23, '2020-09-21 12:04:29'),
(90, 'MW Link installation (1.8) (2 +0 XPIC)', 23, '2020-09-21 12:04:46'),
(91, 'Crane', 31, '2020-09-21 12:10:57'),
(92, 'Closing Old System', 32, '2020-09-27 09:37:59'),
(93, 'TDD solve tickets', 33, '2020-09-29 07:55:32'),
(94, 'Drive test', 18, '2020-09-29 12:11:08');

-- --------------------------------------------------------

--
-- Table structure for table `pm_transaction`
--

DROP TABLE IF EXISTS `pm_transaction`;
CREATE TABLE IF NOT EXISTS `pm_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_name` varchar(255) NOT NULL,
  `site_id` int(255) NOT NULL,
  `sub_con_name` varchar(255) NOT NULL,
  `notes` varchar(255) NOT NULL,
  `date_of_installation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `project_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `im_id` int(11) NOT NULL,
  `work_amount` int(250) NOT NULL DEFAULT '0',
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `status_note` varchar(255) DEFAULT NULL,
  `created_by_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pm_transaction`
--

INSERT INTO `pm_transaction` (`id`, `site_name`, `site_id`, `sub_con_name`, `notes`, `date_of_installation`, `project_id`, `task_id`, `im_id`, `work_amount`, `status`, `status_note`, `created_by_id`, `date_created`) VALUES
(23, 'OPEN Balance', 92020, '33', '', '2020-09-15 06:00:00', 32, 92, 29, 0, 'pending', 'تعديل التاريخ ليصبح 15-9-2020', 33, '2020-09-27 10:54:59'),
(21, 'OPEN Balance', 92020, '32', '', '2020-09-27 11:00:52', 32, 92, 29, 1971, 'approved', '', 32, '2020-09-27 09:54:39'),
(22, 'OPEN BALANCE ', 92020, '43', '', '2020-09-27 11:00:05', 32, 92, 29, 1560, 'approved', '', 43, '2020-09-27 10:08:08'),
(24, 'OPEN Balance', 92020, '33', '', '2020-09-27 12:13:00', 32, 92, 29, 70, 'approved', '', 33, '2020-09-27 12:09:15'),
(27, 'OPEN Balance', 92020, '38', '', '2020-09-15 06:00:00', 32, 92, 29, 2370, 'approved', '', 38, '2020-09-27 12:33:09'),
(30, 'OPEN Balance', 92020, '37', '', '2020-09-15 06:00:00', 32, 92, 29, 1115, 'approved', '', 37, '2020-09-27 20:07:47'),
(31, 'Open balance', 92020, '34', '', '2020-09-15 06:00:00', 32, 92, 29, 450, 'approved', '', 34, '2020-09-28 08:44:03'),
(32, 'Um_ alnjaseh', 1735, '39', '', '2020-09-28 06:00:00', 28, 47, 29, 150, 'approved', '', 39, '2020-09-28 16:20:56'),
(33, 'OPEN BALANCE ', 92020, '43', '', '2020-09-29 06:00:00', 32, 92, 27, 1560, 'approved', '', 43, '2020-09-29 07:58:04'),
(34, 'Aqaba tickets ', 9, '48', '9 tickets ', '2020-08-15 06:00:00', 33, 93, 29, 225, 'approved', '', 48, '2020-09-29 08:02:15'),
(35, 'Open Balance', 92020, '50', '', '2020-09-15 06:00:00', 32, 92, 29, 0, 'pending', NULL, 50, '2020-09-29 11:38:16'),
(36, 'site sample', 22, '33', '', '2020-09-21 21:00:00', 33, 93, 27, 0, 'pending', NULL, 4, '2020-09-29 16:06:30');

-- --------------------------------------------------------

--
-- Table structure for table `pm_users`
--

DROP TABLE IF EXISTS `pm_users`;
CREATE TABLE IF NOT EXISTS `pm_users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(64) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `role` enum('superAdmin','Admin','SubContractor','Accountable') DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `added_by_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pm_users`
--

INSERT INTO `pm_users` (`id`, `email`, `password`, `first_name`, `last_name`, `role`, `date_created`, `phone`, `address`, `added_by_id`) VALUES
(4, 'admin@super.com', '202cb962ac59075b964b07152d234b70', 'super', 'admin', 'superAdmin', '2020-09-01 12:56:49', '00000', 'ttrtrt', 0),
(22, 'h.ghulmi@ses-jo.com', '555962808c57014e2ee6ef350a135173', 'Hisham', 'Ghulmi', 'superAdmin', '2020-09-21 07:03:50', '00962785293168', 'Amman', 4),
(27, 'm.jabata@ses-jo.com', '5fec611b19b27eb2c5d005056fb5ab06', 'Muath ', 'Jabata', 'Admin', '2020-09-21 10:05:50', '00962780502080', 'Amman - Abu nsair ', 22),
(28, 'l.daamseh@ses-jo.com', 'c7a7b82cf9601be321b975696407de42', 'Loay', 'Aldaamseh', 'Admin', '2020-09-21 10:07:15', '0788881798', 'Madaba - Madba ', 22),
(29, 'm.otaibi@ses-jo.com', '028d3461c2322aba4de250270ede7fec', 'Mohammad', 'Otibi', 'Admin', '2020-09-21 10:12:34', '00962788060850', 'Madaba - Madba ', 22),
(30, 'a.abunadi@ses-jo.com', '08f8f42f78cff7d10f3b285d26ecf0bd', 'Ahmad ', 'Abu alnadi', 'Admin', '2020-09-21 10:38:11', '0096278778387', 'irbid - irbid ', 22),
(31, 'a.awawdeh@ses-jo.com', '202cb962ac59075b964b07152d234b70', 'Ahmad ', 'Awawdeh', 'Accountable', '2020-09-21 11:05:47', '0796339911', 'amman - dahea prince hasan', 22),
(32, 'ismail.alqaisi89@gmail.com', 'b9d3131c3410e87aac1035d783307442', 'ismaeel', 'Alqaisi', 'SubContractor', '2020-09-21 11:12:17', '+962 7 9660 6432', 'Amman-Hay Nazal', 29),
(33, 'hasanalzabin202@gmail.com', '89a2e032dcc001c00d63357dad0c9265', 'Hassan', 'Alzaben', 'SubContractor', '2020-09-21 11:15:13', '+962 7 8752 8528', 'Amman-Jabal Alqusour ', 29),
(34, 'aamre1999@gmail.com', 'a1ebcc86166bfec90f04e9842f4280c5', 'ALAA', 'Balawi', 'SubContractor', '2020-09-21 12:00:27', '+962 7 9202 7010', 'Amman-Jabal Alqusour ', 29),
(36, 'A.ahmad.almari@gmail.com', '5eecdefe50cf3e02443564783ef0b486', 'Amro', 'Mari', 'SubContractor', '2020-09-21 12:02:59', '+962 7 8200 7818', 'Zarqa', 29),
(37, 'rahafkhader44@gmail.com', '7ddb9b79bc1d3e37e9036c47f738cbe8', 'Mohammad', 'Othman', 'SubContractor', '2020-09-21 12:04:40', '+962 7 8081 1180', 'Amman- jabal alzohour ', 29),
(38, 'Abuyaagob9@gmail.com', 'ac8ce27cab04c92f89a4049af8462abe', 'Ali', 'Alnoosh ', 'SubContractor', '2020-09-27 08:19:37', '+962 7 9569 6536', 'Amman', 29),
(39, 'Mohamd123Saadeh@gmail.com', 'f7236eebe7e28deee9dacbba26416b43', 'Mohammad', 'Fayeq', 'SubContractor', '2020-09-27 08:22:25', '+962 7 9751 2375', 'Amman-Jabal Alqusour ', 29),
(42, 'ihasonia9256@gmail.com', '9f42bc5ca216b1545c4ccb866deed27e', 'ibrahem ', 'hassonah', 'SubContractor', '2020-09-27 09:26:50', '+962 7 8752 8825', 'Amman -Aqsa Dis', 29),
(43, 'Alkyyaly@hotmail.com', '94b767c66a010969a742bfd0e11f3b7a', 'Anas ', 'kayali ', 'SubContractor', '2020-09-27 09:51:35', '+962 7 7954 6867', 'Amman', 29),
(44, 'abomoathabbadi@gmail.com', '3ecd92d4ef9833101eb2122054886944', 'shehadeh ', '(abu moath)', 'SubContractor', '2020-09-27 10:53:29', '+962 7 9548 7483', 'Amman-albayader', 29),
(45, 'l.albarbarawy@gmail.com', '6cc5f5d45532703b855b7a71f9dbbeff', 'loai', 'Halhouly', 'SubContractor', '2020-09-27 11:42:16', '+962 7 8858 2858', 'Amman-Jabal Alqusour ', 29),
(47, 'yaseen.hajajweh@gmail.com', '202cb962ac59075b964b07152d234b70', 'Yaseen', 'Hajajweh', 'SubContractor', '2020-09-27 12:22:50', '0789509514', 'Amman', 4),
(49, 'baha.shawawreh@yahoo.com', 'c65f673235d9c320f98f3824699ef99e', 'bahaa', 'shawawrah ', 'SubContractor', '2020-09-29 07:54:24', '+962 7 9825 1416', 'AQABA', 29),
(50, 'hamzaalzamer42@gmail.com', '87e9d1c37bbd51c9962da85fca7c8b7b', 'Hamzeh', 'Alzamer', 'SubContractor', '2020-09-29 11:35:50', '0791017945', 'amman - nuzha ', 22);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
