-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 15, 2024 at 11:22 AM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `borrowing`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

DROP TABLE IF EXISTS `tbl_admin`;
CREATE TABLE IF NOT EXISTS `tbl_admin` (
  `admin_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_borrower`
--

DROP TABLE IF EXISTS `tbl_borrower`;
CREATE TABLE IF NOT EXISTS `tbl_borrower` (
  `borrower_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  `year_level` varchar(100) NOT NULL,
  `course_id` int NOT NULL,
  `department_id` int NOT NULL,
  `type` varchar(50) NOT NULL,
  `status` int NOT NULL DEFAULT '0',
  `status_approval` int DEFAULT '0',
  `docs_file` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`borrower_id`),
  KEY `fk_course_id` (`course_id`),
  KEY `fk_department_id` (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categories`
--

DROP TABLE IF EXISTS `tbl_categories`;
CREATE TABLE IF NOT EXISTS `tbl_categories` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_categories`
--

INSERT INTO `tbl_categories` (`category_id`, `category_name`, `status`) VALUES
(1, 'cvxxvcvcb', 1),
(2, 'qwe', 1),
(4, 'qwex', 1),
(5, 'qqq', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_course`
--

DROP TABLE IF EXISTS `tbl_course`;
CREATE TABLE IF NOT EXISTS `tbl_course` (
  `course_id` int NOT NULL AUTO_INCREMENT,
  `course_name` varchar(100) NOT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`course_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_course`
--

INSERT INTO `tbl_course` (`course_id`, `course_name`, `status`) VALUES
(2, 'ccc', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_damage_items`
--

DROP TABLE IF EXISTS `tbl_damage_items`;
CREATE TABLE IF NOT EXISTS `tbl_damage_items` (
  `item_dmg_no` int NOT NULL AUTO_INCREMENT,
  `transaction_id` int NOT NULL,
  `ex_replace_date` date NOT NULL,
  `penalty` int NOT NULL,
  `quantity` int NOT NULL,
  `remarks` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`item_dmg_no`),
  KEY `fk_dmg_trans_no` (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_department`
--

DROP TABLE IF EXISTS `tbl_department`;
CREATE TABLE IF NOT EXISTS `tbl_department` (
  `department_id` int NOT NULL AUTO_INCREMENT,
  `description` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_department`
--

INSERT INTO `tbl_department` (`department_id`, `description`, `status`) VALUES
(15, 'zxcxzx', 1),
(16, 'cxzcxz', 1),
(17, 'cxzcxzccv', 1),
(19, 'fdsdf', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inventory`
--

DROP TABLE IF EXISTS `tbl_inventory`;
CREATE TABLE IF NOT EXISTS `tbl_inventory` (
  `item_code` varchar(100) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `category_id` int NOT NULL,
  `item_model` varchar(100) NOT NULL,
  `quantity` int NOT NULL,
  `item_condition` varchar(100) NOT NULL,
  `status` int NOT NULL,
  `description` varchar(100) NOT NULL,
  `img_path` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`item_code`),
  KEY `fk_category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_inventory`
--

INSERT INTO `tbl_inventory` (`item_code`, `item_name`, `category_id`, `item_model`, `quantity`, `item_condition`, `status`, `description`, `img_path`) VALUES
('123', 'fsdfsd', 1, 'dasd', 0, 'Good', 1, 'fsdfds', NULL),
('212', 'xxxxx', 1, 'fdgdf', 0, 'Good', 1, 'gfdgfd', '1888fe9f-3fa2-4d57-b71a-139f47729368.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_penalty`
--

DROP TABLE IF EXISTS `tbl_penalty`;
CREATE TABLE IF NOT EXISTS `tbl_penalty` (
  `penalty_id` int NOT NULL AUTO_INCREMENT,
  `transaction_no` int NOT NULL,
  `penalty` int NOT NULL,
  PRIMARY KEY (`penalty_id`),
  KEY `fk_pen_trans_no` (`transaction_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_retirement`
--

DROP TABLE IF EXISTS `tbl_retirement`;
CREATE TABLE IF NOT EXISTS `tbl_retirement` (
  `retirement_no` int NOT NULL,
  `item_code` varchar(100) NOT NULL,
  `quantity` int NOT NULL,
  `remarks` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`retirement_no`),
  KEY `fk_item_code` (`item_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_return_items`
--

DROP TABLE IF EXISTS `tbl_return_items`;
CREATE TABLE IF NOT EXISTS `tbl_return_items` (
  `return_id` int NOT NULL AUTO_INCREMENT,
  `transaction_id` int NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`return_id`),
  KEY `fk_rtn_trans_no` (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaction`
--

DROP TABLE IF EXISTS `tbl_transaction`;
CREATE TABLE IF NOT EXISTS `tbl_transaction` (
  `transaction_no` int NOT NULL,
  `borrower_id` varchar(100) NOT NULL,
  `item_code` varchar(100) NOT NULL,
  `quantity` int NOT NULL,
  `start_date` date NOT NULL,
  `return_date` date NOT NULL,
  `return_condition` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  PRIMARY KEY (`transaction_no`),
  KEY `fk_trans_item_code` (`item_code`),
  KEY `fk_trans_borrower_id` (`borrower_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_borrower`
--
ALTER TABLE `tbl_borrower`
  ADD CONSTRAINT `fk_course_id` FOREIGN KEY (`course_id`) REFERENCES `tbl_course` (`course_id`),
  ADD CONSTRAINT `fk_department_id` FOREIGN KEY (`department_id`) REFERENCES `tbl_department` (`department_id`);

--
-- Constraints for table `tbl_damage_items`
--
ALTER TABLE `tbl_damage_items`
  ADD CONSTRAINT `fk_dmg_trans_no` FOREIGN KEY (`transaction_id`) REFERENCES `tbl_transaction` (`transaction_no`);

--
-- Constraints for table `tbl_inventory`
--
ALTER TABLE `tbl_inventory`
  ADD CONSTRAINT `fk_category_id` FOREIGN KEY (`category_id`) REFERENCES `tbl_categories` (`category_id`);

--
-- Constraints for table `tbl_penalty`
--
ALTER TABLE `tbl_penalty`
  ADD CONSTRAINT `fk_pen_trans_no` FOREIGN KEY (`transaction_no`) REFERENCES `tbl_transaction` (`transaction_no`);

--
-- Constraints for table `tbl_retirement`
--
ALTER TABLE `tbl_retirement`
  ADD CONSTRAINT `fk_item_code` FOREIGN KEY (`item_code`) REFERENCES `tbl_inventory` (`item_code`);

--
-- Constraints for table `tbl_return_items`
--
ALTER TABLE `tbl_return_items`
  ADD CONSTRAINT `fk_rtn_trans_no` FOREIGN KEY (`transaction_id`) REFERENCES `tbl_transaction` (`transaction_no`);

--
-- Constraints for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  ADD CONSTRAINT `fk_trans_borrower_id` FOREIGN KEY (`borrower_id`) REFERENCES `tbl_borrower` (`borrower_id`),
  ADD CONSTRAINT `fk_trans_item_code` FOREIGN KEY (`item_code`) REFERENCES `tbl_inventory` (`item_code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
