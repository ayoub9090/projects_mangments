-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 10, 2020 at 02:03 PM
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
-- Database: `projects`
--

-- --------------------------------------------------------

--
-- Table structure for table `pm_accounts`
--

DROP TABLE IF EXISTS `pm_accounts`;
CREATE TABLE IF NOT EXISTS `pm_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_amount` int(250) NOT NULL,
  `the_current_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `notes` varchar(250) NOT NULL,
  `user_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pm_accounts`
--

INSERT INTO `pm_accounts` (`id`, `payment_amount`, `the_current_date`, `created_date`, `notes`, `user_id`, `transaction_id`) VALUES
(1, 12, '2020-09-10 13:37:49', '2020-09-10 13:37:49', 'this is notes', 14, 6);

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pm_projects`
--

INSERT INTO `pm_projects` (`id`, `project_name`, `user_id`, `date_created`) VALUES
(8, 'my first project', 4, '2020-09-03 14:55:54'),
(10, 'my first project22', 4, '2020-09-06 18:02:19'),
(11, 'zarqa', 4, '2020-09-08 15:37:57'),
(12, 'amman', 4, '2020-09-08 15:38:18'),
(13, 'project created by admin ', 7, '2020-09-09 16:37:28');

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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pm_tasks`
--

INSERT INTO `pm_tasks` (`id`, `task_description`, `project_id`, `date_created`) VALUES
(13, 'task 1 ', 8, '2020-09-07 11:53:53'),
(14, 'task 22666', 8, '2020-09-07 11:54:03'),
(15, 'task 22', 10, '2020-09-07 11:54:17'),
(16, 'first task', 10, '2020-09-07 12:09:20'),
(17, 'task 22', 10, '2020-09-08 09:06:07'),
(18, 'antena', 11, '2020-09-08 15:39:34'),
(19, 'antena2', 11, '2020-09-08 15:39:48');

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
  `date_of_installation` timestamp NOT NULL,
  `project_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `im_id` int(11) NOT NULL,
  `work_amount` int(250) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `status_note` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pm_transaction`
--

INSERT INTO `pm_transaction` (`id`, `site_name`, `site_id`, `sub_con_name`, `notes`, `date_of_installation`, `project_id`, `task_id`, `im_id`, `work_amount`, `status`, `status_note`, `date_created`) VALUES
(5, 'site sample', 22, 'teh subcntractor', 'this is a note', '2020-09-01 21:00:00', 10, 15, 7, 0, 'pending', '', '2020-09-07 18:08:46'),
(6, 'site sample edit', 22, 'teh subcntractor', 'this is a note', '2020-09-07 21:00:00', 10, 16, 7, 77, 'approved', '', '2020-09-08 09:06:44'),
(7, 'Zarqa_princeHamzehAvenue', 33, 'yassien', 'this is a note', '2020-09-07 21:00:00', 11, 19, 7, 0, 'rejected', 'yyyyyyyy note', '2020-09-08 15:46:23');

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pm_users`
--

INSERT INTO `pm_users` (`id`, `email`, `password`, `first_name`, `last_name`, `role`, `date_created`, `phone`, `address`, `added_by_id`) VALUES
(4, 'admin@super.com', '202cb962ac59075b964b07152d234b70', 'super', 'admin', 'superAdmin', '2020-09-01 12:56:49', '00000', 'ttrtrt', 0),
(7, 'omari.ayoub90@gmail.com', '202cb962ac59075b964b07152d234b70', 'ayoub', 'admin', 'Admin', '2020-09-01 12:56:49', 'ttttttt', 'ttttttttttttttttttttt', 4),
(8, 'omari.ayoub9000@gmail.com', '202cb962ac59075b964b07152d234b70', 'ayoub1222222', 'Omari', 'SubContractor', '2020-09-01 13:02:37', '656565', 'ggg', 4),
(10, 'omari.ayoub900@gmail.com', '202cb962ac59075b964b07152d234b70', 'ayoub', 'Omari', 'SubContractor', '2020-09-03 08:28:22', '+962785507888', 'Amman, Jordan', 4),
(11, 'omari.ayoub9000@gmail.com', '202cb962ac59075b964b07152d234b70', 'ayoub222', 'Omari', 'SubContractor', '2020-09-08 15:33:55', '+962785507888', 'Amman, Jordan', 4),
(12, 'sub@gmail.com', '202cb962ac59075b964b07152d234b70', 'sub contractor 2', 'last', 'SubContractor', '2020-09-09 16:54:49', '+962785507888', 'Amman, Jordan', 4),
(13, 'omari.ayoub80@gmail.com', '202cb962ac59075b964b07152d234b70', 'sub2', 'con2', 'SubContractor', '2020-09-09 18:50:05', '+962785507888', 'Amman, Jordan', 7),
(14, 'accountable@accountable.com', '202cb962ac59075b964b07152d234b70', 'accountable', 'acc', 'Accountable', '2020-09-10 12:40:49', '+962785507888', 'Amman, Jordan', 4);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
